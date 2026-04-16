<?php
/**
 * SkillBridge — CompanyProfileModel
 */

declare(strict_types=1);

class CompanyProfileModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getByUserId(int $userId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT u.id AS user_id, u.full_name, u.email, u.avatar_url,
                    cp.company_name, cp.industry, cp.description, cp.website,
                    cp.location, cp.company_size, cp.founded_year,
                    cp.created_at, cp.updated_at,
                    (SELECT COUNT(*) FROM posts WHERE company_id = u.id AND status = "active") AS active_posts_count
             FROM users u
             LEFT JOIN company_profiles cp ON cp.user_id = u.id
             WHERE u.id = ? AND u.role = "company"
             LIMIT 1'
        );
        $stmt->execute([$userId]);
        return $stmt->fetch() ?: null;
    }

    public function createEmpty(int $userId, string $companyName): void
    {
        $stmt = $this->db->prepare(
            'INSERT IGNORE INTO company_profiles (user_id, company_name) VALUES (?, ?)'
        );
        $stmt->execute([$userId, $companyName]);
    }

    public function update(int $userId, array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO company_profiles (user_id, company_name, industry, description, website, location, company_size, founded_year)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
               company_name = VALUES(company_name),
               industry     = VALUES(industry),
               description  = VALUES(description),
               website      = VALUES(website),
               location     = VALUES(location),
               company_size = VALUES(company_size),
               founded_year = VALUES(founded_year)'
        );
        $stmt->execute([
            $userId,
            $data['company_name']  ?? '',
            $data['industry']      ?? null,
            $data['description']   ?? null,
            $data['website']       ?? null,
            $data['location']      ?? null,
            $data['company_size']  ?? null,
            $data['founded_year']  ?? null,
        ]);
    }
}
