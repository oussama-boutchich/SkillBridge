<?php
/**
 * SkillBridge — ApplicationModel
 */
declare(strict_types=1);

class ApplicationModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM applications WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            'SELECT a.*, p.title AS post_title, cp.company_name
             FROM applications a
             JOIN posts p ON p.id = a.post_id
             LEFT JOIN company_profiles cp ON cp.user_id = p.company_id
             WHERE a.student_id = ?
             ORDER BY a.created_at DESC'
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public function getByPost(int $postId): array
    {
        $stmt = $this->db->prepare(
            'SELECT a.*, u.full_name AS student_name, u.avatar_url AS student_avatar,
                    sp.university
             FROM applications a
             JOIN users u ON u.id = a.student_id
             LEFT JOIN student_profiles sp ON sp.user_id = a.student_id
             WHERE a.post_id = ?
             ORDER BY a.created_at DESC'
        );
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public function exists(int $studentId, int $postId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT id FROM applications WHERE student_id = ? AND post_id = ? LIMIT 1'
        );
        $stmt->execute([$studentId, $postId]);
        return (bool) $stmt->fetch();
    }

    public function create(int $studentId, int $postId, ?string $coverLetter): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO applications (student_id, post_id, cover_letter) VALUES (?, ?, ?)'
        );
        $stmt->execute([$studentId, $postId, $coverLetter]);
        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): void
    {
        $stmt = $this->db->prepare('UPDATE applications SET status = ? WHERE id = ?');
        $stmt->execute([$status, $id]);
    }

    public function countByStudent(int $userId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM applications WHERE student_id = ?');
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM applications')->fetchColumn();
    }
}
