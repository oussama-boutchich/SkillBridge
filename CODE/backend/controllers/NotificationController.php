<?php
/**
 * SkillBridge — NotificationController
 */
declare(strict_types=1);

class NotificationController
{
    private NotificationModel $model;

    public function __construct()
    {
        require_once __DIR__ . '/../models/NotificationModel.php';
        $this->model = new NotificationModel();
    }

    /** GET /api/notifications */
    public function index(): void
    {
        $userId = (int) $_SESSION['user_id'];
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 15;
        $offset = ($page - 1) * $limit;

        $notifications = $this->model->getByUserId($userId, false, $limit, $offset);
        $total         = $this->model->countAll($userId);
        $unread        = $this->model->countUnread($userId);

        Response::success([
            'items'  => $notifications,
            'unread' => $unread,
            'pagination' => [
                'current_page' => $page,
                'total_pages'  => (int) ceil($total / $limit),
                'total_items'  => $total,
                'per_page'     => $limit,
            ],
        ]);
    }

    /** PATCH /api/notifications/{id}/read */
    public function markRead(string $id): void
    {
        $this->model->markRead((int) $id, (int) $_SESSION['user_id']);
        Response::success(['message' => 'Notification marked as read.']);
    }

    /** PATCH /api/notifications/read-all */
    public function markAllRead(): void
    {
        $this->model->markAllRead((int) $_SESSION['user_id']);
        Response::success(['message' => 'All notifications marked as read.']);
    }
}
