<?php
/**
 * SkillBridge — StudentProfileModel
 */

declare(strict_types=1);

class StudentProfileModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /** Get profile joined with user data. */
    public function getByUserId(int $userId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT u.id AS user_id, u.full_name, u.email, u.avatar_url,
                    sp.university, sp.field_of_study, sp.bio, sp.skills,
                    sp.resume_url, sp.linkedin_url, sp.graduation_year,
                    sp.created_at, sp.updated_at
             FROM users u
             LEFT JOIN student_profiles sp ON sp.user_id = u.id
             WHERE u.id = ? AND u.role = "student"
             LIMIT 1'
        );
        $stmt->execute([$userId]);
        return $stmt->fetch() ?: null;
    }

    /** Create an empty profile row for a new student (auto-called on register). */
    public function createEmpty(int $userId): void
    {
        $stmt = $this->db->prepare(
            'INSERT IGNORE INTO student_profiles (user_id) VALUES (?)'
        );
        $stmt->execute([$userId]);
    }

    /** Update all optional profile fields. */
    public function update(int $userId, array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO student_profiles (user_id, university, field_of_study, bio, skills, resume_url, linkedin_url, graduation_year)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
               university      = VALUES(university),
               field_of_study  = VALUES(field_of_study),
               bio             = VALUES(bio),
               skills          = VALUES(skills),
               resume_url      = VALUES(resume_url),
               linkedin_url    = VALUES(linkedin_url),
               graduation_year = VALUES(graduation_year)'
        );
        $stmt->execute([
            $userId,
            $data['university']     ?? null,
            $data['field_of_study'] ?? null,
            $data['bio']            ?? null,
            $data['skills']         ?? null,
            $data['resume_url']     ?? null,
            $data['linkedin_url']   ?? null,
            $data['graduation_year'] ?? null,
        ]);
    }
}
