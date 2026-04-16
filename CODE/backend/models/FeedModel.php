<?php
/**
 * SkillBridge — FeedModel
 */
declare(strict_types=1);

class FeedModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getByUserId(int $userId, int $limit = 20): array
    {
        $stmt = $this->db->prepare(
            'SELECT fa.*, u.full_name, u.avatar_url
             FROM feed_activities fa
             JOIN users u ON u.id = fa.user_id
             WHERE fa.user_id = ?
             ORDER BY fa.created_at DESC
             LIMIT ?'
        );
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }

    public function create(int $userId, string $activityType, string $description, ?int $referenceId = null): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO feed_activities (user_id, activity_type, description, reference_id)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $activityType, $description, $referenceId]);
    }
}
