<?php
/**
 * SkillBridge — AuthController
 *
 * Handles:  POST /api/auth/register
 *           POST /api/auth/login
 *           POST /api/auth/logout
 *           GET  /api/auth/me
 */

declare(strict_types=1);

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        require_once __DIR__ . '/../models/UserModel.php';
        require_once __DIR__ . '/../models/StudentProfileModel.php';
        require_once __DIR__ . '/../models/CompanyProfileModel.php';
        require_once __DIR__ . '/../services/AuthService.php';

        $this->authService = new AuthService();
    }

    // ── POST /api/auth/register ────────────────────────────────────────────
    public function register(): void
    {
        $input = $this->getJsonInput();

        $email    = Sanitizer::email($input['email']    ?? '');
        $password = $input['password']                  ?? '';
        $fullName = Sanitizer::string($input['full_name'] ?? '');
        $role     = $input['role']                      ?? '';

        // Validate
        $v = new Validator();
        $v->required('email', $email)
          ->email('email', $email)
          ->required('password', $password)
          ->minLength('password', $password, 8)
          ->maxLength('password', $password, 128)
          ->required('full_name', $fullName)
          ->minLength('full_name', $fullName, 2)
          ->maxLength('full_name', $fullName, 150)
          ->required('role', $role)
          ->inList('role', $role, [AppConstants::ROLE_STUDENT, AppConstants::ROLE_COMPANY]);

        if (!$v->passes()) {
            Response::error($v->getErrors(), 400);
        }

        $user = $this->authService->register($email, $password, $fullName, $role);
        Response::success($user, 201);
    }

    // ── POST /api/auth/login ───────────────────────────────────────────────
    public function login(): void
    {
        $input = $this->getJsonInput();

        $email    = Sanitizer::email($input['email']    ?? '');
        $password = $input['password']                  ?? '';

        // Validate
        $v = new Validator();
        $v->required('email', $email)
          ->email('email', $email)
          ->required('password', $password);

        if (!$v->passes()) {
            Response::error($v->getErrors(), 400);
        }

        $user = $this->authService->login($email, $password);
        Response::success($user);
    }

    // ── POST /api/auth/logout  (auth required — enforced by middleware) ────
    public function logout(): void
    {
        $this->authService->logout();
        Response::success(['message' => 'Logged out successfully.']);
    }

    // ── GET /api/auth/me  (auth required — enforced by middleware) ─────────
    public function me(): void
    {
        $user = $this->authService->getCurrentUser();

        if (!$user) {
            Response::error('Not authenticated.', 401);
        }

        Response::success($user);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /** Decode the raw JSON request body. Always returns an array. */
    private function getJsonInput(): array
    {
        $raw = file_get_contents('php://input');
        return json_decode($raw ?: '{}', true) ?? [];
    }
}
