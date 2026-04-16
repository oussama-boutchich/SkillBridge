<?php
/**
 * SkillBridge — CertificateModel
 */
declare(strict_types=1);

class CertificateModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT id, title, issuer, issue_date, credential_url, description, created_at
             FROM certificates WHERE user_id = ? ORDER BY issue_date DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM certificates WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(int $userId, array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO certificates (user_id, title, issuer, issue_date, credential_url, description)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $userId,
            $data['title'],
            $data['issuer'],
            $data['issue_date'],
            $data['credential_url'] ?? null,
            $data['description']    ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM certificates WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function countByUserId(int $userId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM certificates WHERE user_id = ?');
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }
}
