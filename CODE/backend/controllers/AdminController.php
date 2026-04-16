<?php
/**
 * SkillBridge — AdminController
 */
declare(strict_types=1);

class AdminController
{
    private UserModel        $userModel;
    private PostModel        $postModel;
    private ApplicationModel $appModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/UserModel.php';
        require_once __DIR__ . '/../models/PostModel.php';
        require_once __DIR__ . '/../models/ApplicationModel.php';
        $this->userModel = new UserModel();
        $this->postModel = new PostModel();
        $this->appModel  = new ApplicationModel();
    }

    /** GET /api/admin/users */
    public function users(): void
    {
        $role  = $_GET['role'] ?? null;
        $users = $this->userModel->getAll($role);
        Response::success($users);
    }

    /** PATCH /api/admin/users/{id}/ban */
    public function banUser(string $id): void
    {
        $targetId = (int) $id;
        $this->ensureNotSelf($targetId);
        $user = $this->userModel->getById($targetId);
        if (!$user) Response::error('User not found.', 404);

        $this->userModel->ban($targetId);
        $this->logAction((int)$_SESSION['user_id'], AppConstants::LOG_BAN_USER, 'user', $targetId, "Banned user: {$user['email']}");
        Response::success(['message' => "User {$user['email']} has been banned."]);
    }

    /** PATCH /api/admin/users/{id}/unban */
    public function unbanUser(string $id): void
    {
        $targetId = (int) $id;
        $user = $this->userModel->getById($targetId);
        if (!$user) Response::error('User not found.', 404);

        $this->userModel->unban($targetId);
        $this->logAction((int)$_SESSION['user_id'], AppConstants::LOG_UNBAN_USER, 'user', $targetId, "Unbanned user: {$user['email']}");
        Response::success(['message' => "User {$user['email']} has been unbanned."]);
    }

    /** GET /api/admin/posts */
    public function posts(): void
    {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 10;
        $offset = ($page - 1) * $limit;
        $total  = $this->postModel->countAll2();
        $posts  = $this->postModel->getAll([], $limit, $offset);
        Response::paginated($posts, $page, $total, $limit);
    }

    /** DELETE /api/admin/posts/{id} */
    public function deletePost(string $id): void
    {
        $postId = (int) $id;
        $post   = $this->postModel->getById($postId);
        if (!$post) Response::error('Post not found.', 404);

        $this->postModel->delete($postId);
        $this->logAction((int)$_SESSION['user_id'], AppConstants::LOG_DELETE_POST, 'post', $postId, "Deleted post #{$postId}: {$post['title']}");
        Response::success(['message' => 'Post deleted.']);
    }

    /** GET /api/admin/analytics */
    public function analytics(): void
    {
        Response::success([
            'total_users'        => $this->userModel->countAll(),
            'total_students'     => $this->userModel->countByRole('student'),
            'total_companies'    => $this->userModel->countByRole('company'),
            'total_posts'        => $this->postModel->countAll2(),
            'total_applications' => $this->appModel->countAll(),
        ]);
    }

    /** GET /api/admin/logs */
    public function logs(): void
    {
        $pdo  = Database::getConnection();
        $logs = $pdo->query(
            'SELECT al.*, u.email AS admin_email
             FROM admin_logs al
             LEFT JOIN users u ON u.id = al.admin_id
             ORDER BY al.created_at DESC LIMIT 50'
        )->fetchAll();
        Response::success($logs);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    private function ensureNotSelf(int $targetId): void
    {
        if ($targetId === (int) $_SESSION['user_id']) {
            Response::error('You cannot perform this action on yourself.', 400);
        }
    }

    private function logAction(int $adminId, string $action, string $targetType, int $targetId, string $desc): void
    {
        $pdo = Database::getConnection();
        $pdo->prepare(
            'INSERT INTO admin_logs (admin_id, action, target_type, target_id, description) VALUES (?, ?, ?, ?, ?)'
        )->execute([$adminId, $action, $targetType, $targetId, $desc]);
    }
}
