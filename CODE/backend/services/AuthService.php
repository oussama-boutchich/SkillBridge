<?php
/**
 * SkillBridge — AuthService
 *
 * Business logic for registration, login, and logout.
 * Coordinates UserModel, StudentProfileModel, CompanyProfileModel.
 */

declare(strict_types=1);

class AuthService
{
    private UserModel          $userModel;
    private StudentProfileModel $studentProfileModel;
    private CompanyProfileModel $companyProfileModel;

    public function __construct()
    {
        $this->userModel           = new UserModel();
        $this->studentProfileModel = new StudentProfileModel();
        $this->companyProfileModel = new CompanyProfileModel();
    }

    /**
     * Register a new student or company account.
     *
     * @throws RuntimeException on duplicate email.
     * @return array The new user data (without password).
     */
    public function register(string $email, string $password, string $fullName, string $role): array
    {
        // Check for duplicate email
        if ($this->userModel->emailExists($email)) {
            Response::error('An account with this email already exists.', 409);
        }

        // Hash password with bcrypt
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // Insert user
        $userId = $this->userModel->create($email, $hashed, $fullName, $role);

        // Auto-create empty role-specific profile
        if ($role === AppConstants::ROLE_STUDENT) {
            $this->studentProfileModel->createEmpty($userId);
        } elseif ($role === AppConstants::ROLE_COMPANY) {
            $this->companyProfileModel->createEmpty($userId, $fullName);
        }

        return [
            'user_id'   => $userId,
            'email'     => $email,
            'full_name' => $fullName,
            'role'      => $role,
        ];
    }

    /**
     * Authenticate a user and populate $_SESSION.
     *
     * @return array The authenticated user data (without password).
     */
    public function login(string $email, string $password): array
    {
        $user = $this->userModel->getByEmail($email);

        // Intentionally use generic message to avoid email enumeration
        if (!$user) {
            Response::error('Invalid email or password.', 401);
        }

        if (!password_verify($password, $user['password'])) {
            Response::error('Invalid email or password.', 401);
        }

        if ((int) $user['is_banned'] === 1) {
            Response::error('Your account has been suspended. Please contact support.', 403);
        }

        // Harden session: regenerate ID to prevent session fixation
        session_regenerate_id(true);

        $_SESSION['user_id']      = $user['id'];
        $_SESSION['email']        = $user['email'];
        $_SESSION['full_name']    = $user['full_name'];
        $_SESSION['role']         = $user['role'];
        $_SESSION['logged_in_at'] = date('Y-m-d H:i:s');

        return [
            'user_id'   => $user['id'],
            'email'     => $user['email'],
            'full_name' => $user['full_name'],
            'role'      => $user['role'],
            'is_banned' => false,
            'avatar_url'=> $user['avatar_url'],
        ];
    }

    /** Destroy the current session completely. */
    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    /** Return current user data from session (no DB hit needed). */
    public function getCurrentUser(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }

        // Refresh from DB to catch bans or name changes
        $user = $this->userModel->getById((int) $_SESSION['user_id']);
        if (!$user) {
            return null;
        }

        return [
            'user_id'   => $user['id'],
            'email'     => $user['email'],
            'full_name' => $user['full_name'],
            'role'      => $user['role'],
            'avatar_url'=> $user['avatar_url'],
        ];
    }
}
