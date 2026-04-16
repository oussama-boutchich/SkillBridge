<?php
/**
 * SkillBridge — UserModel
 *
 * All queries against the `users` table.
 * Uses PDO prepared statements exclusively.
 */

declare(strict_types=1);

class UserModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /** Find user by email. Returns null if not found. */
    public function getByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, email, password, full_name, role, is_banned, avatar_url, created_at
             FROM users WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    /** Find user by ID. Returns null if not found. */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, email, full_name, role, is_banned, avatar_url, created_at
             FROM users WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /** Check if an email already exists in the users table. */
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Insert a new user. Returns the new user's ID.
     *
     * @param string $hashedPassword  Already bcrypt-hashed password.
     */
    public function create(string $email, string $hashedPassword, string $fullName, string $role): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$email, $hashedPassword, $fullName, $role]);
        return (int) $this->db->lastInsertId();
    }

    /** Set is_banned = 1 for the given user ID. */
    public function ban(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE users SET is_banned = 1 WHERE id = ?');
        $stmt->execute([$id]);
    }

    /** Set is_banned = 0 for the given user ID. */
    public function unban(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE users SET is_banned = 0 WHERE id = ?');
        $stmt->execute([$id]);
    }

    /** Update avatar URL. */
    public function updateAvatar(int $id, string $url): void
    {
        $stmt = $this->db->prepare('UPDATE users SET avatar_url = ? WHERE id = ?');
        $stmt->execute([$url, $id]);
    }

    /**
     * List all users (admin use). Optional role filter.
     *
     * @return array<int, array>
     */
    public function getAll(?string $role = null): array
    {
        if ($role !== null) {
            $stmt = $this->db->prepare(
                'SELECT id, email, full_name, role, is_banned, avatar_url, created_at
                 FROM users WHERE role = ? ORDER BY created_at DESC'
            );
            $stmt->execute([$role]);
        } else {
            $stmt = $this->db->query(
                'SELECT id, email, full_name, role, is_banned, avatar_url, created_at
                 FROM users ORDER BY created_at DESC'
            );
        }
        return $stmt->fetchAll();
    }

    /** Count users by role. */
    public function countByRole(string $role): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE role = ?');
        $stmt->execute([$role]);
        return (int) $stmt->fetchColumn();
    }

    /** Total user count. */
    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }
}
