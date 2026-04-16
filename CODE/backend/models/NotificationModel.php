<?php
/**
 * SkillBridge — NotificationModel
 */
declare(strict_types=1);

class NotificationModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getByUserId(int $userId, bool $unreadOnly = false, int $limit = 20, int $offset = 0): array
    {
        $where = $unreadOnly ? 'AND is_read = 0' : '';
        $stmt  = $this->db->prepare(
            "SELECT * FROM notifications
             WHERE user_id = ? $where
             ORDER BY created_at DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->execute([$userId, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function countUnread(int $userId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0');
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }

    public function countAll(int $userId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM notifications WHERE user_id = ?');
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }

    public function markRead(int $id, int $userId): void
    {
        $stmt = $this->db->prepare('UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }

    public function markAllRead(int $userId): void
    {
        $stmt = $this->db->prepare('UPDATE notifications SET is_read = 1 WHERE user_id = ?');
        $stmt->execute([$userId]);
    }

    public function create(int $userId, string $title, string $message, string $type, ?int $referenceId = null): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO notifications (user_id, title, message, type, reference_id)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $title, $message, $type, $referenceId]);
    }
}
