<?php
/**
 * SkillBridge — PostModel
 */
declare(strict_types=1);

class PostModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $where  = ['p.status = "active"'];
        $params = [];

        if (!empty($filters['type'])) {
            $where[]  = 'p.type = ?';
            $params[] = $filters['type'];
        }
        if (!empty($filters['search'])) {
            $where[]  = '(p.title LIKE ? OR p.description LIKE ?)';
            $s        = '%' . $filters['search'] . '%';
            $params[] = $s;
            $params[] = $s;
        }

        $sql = 'SELECT p.id, p.title, p.type, p.location, p.is_remote, p.deadline, p.status, p.created_at,
                       cp.company_name, u.avatar_url AS company_avatar,
                       (SELECT COUNT(*) FROM applications a WHERE a.post_id = p.id) AS applications_count
                FROM posts p
                JOIN users u ON u.id = p.company_id
                LEFT JOIN company_profiles cp ON cp.user_id = p.company_id
                WHERE ' . implode(' AND ', $where) . '
                ORDER BY p.created_at DESC
                LIMIT ? OFFSET ?';

        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countAll(array $filters = []): int
    {
        $where  = ['p.status = "active"'];
        $params = [];

        if (!empty($filters['type'])) { $where[] = 'p.type = ?'; $params[] = $filters['type']; }
        if (!empty($filters['search'])) {
            $where[]  = '(p.title LIKE ? OR p.description LIKE ?)';
            $s        = '%' . $filters['search'] . '%';
            $params[] = $s; $params[] = $s;
        }

        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM posts p WHERE ' . implode(' AND ', $where)
        );
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function getById(int $id, ?int $studentId = null): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, cp.company_name, cp.industry, u.avatar_url AS company_avatar,
                    (SELECT COUNT(*) FROM applications a WHERE a.post_id = p.id) AS applications_count
             FROM posts p
             JOIN users u ON u.id = p.company_id
             LEFT JOIN company_profiles cp ON cp.user_id = p.company_id
             WHERE p.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        if (!$post) return null;

        if ($studentId) {
            $appStmt = $this->db->prepare(
                'SELECT id FROM applications WHERE student_id = ? AND post_id = ? LIMIT 1'
            );
            $appStmt->execute([$studentId, $id]);
            $post['has_applied'] = (bool) $appStmt->fetch();
        }

        return $post;
    }

    public function getByCompany(int $companyId): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, (SELECT COUNT(*) FROM applications a WHERE a.post_id = p.id) AS applications_count
             FROM posts p WHERE p.company_id = ? ORDER BY p.created_at DESC'
        );
        $stmt->execute([$companyId]);
        return $stmt->fetchAll();
    }

    public function create(int $companyId, array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO posts (company_id, title, description, type, requirements, location, is_remote, deadline, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, "active")'
        );
        $stmt->execute([
            $companyId,
            $data['title'],
            $data['description'],
            $data['type'],
            $data['requirements'] ?? null,
            $data['location']     ?? null,
            isset($data['is_remote']) ? (int)$data['is_remote'] : 0,
            $data['deadline']     ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $fields = [];
        $params = [];
        $allowed = ['title','description','type','requirements','location','is_remote','deadline','status'];
        foreach ($allowed as $f) {
            if (array_key_exists($f, $data)) {
                $fields[] = "$f = ?";
                $params[] = $data[$f];
            }
        }
        if (empty($fields)) return;
        $params[] = $id;
        $this->db->prepare('UPDATE posts SET ' . implode(', ', $fields) . ' WHERE id = ?')->execute($params);
    }

    public function delete(int $id): void
    {
        $this->db->prepare('DELETE FROM posts WHERE id = ?')->execute([$id]);
    }

    public function countAll2(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }
}
