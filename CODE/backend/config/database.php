<?php
/**
 * SkillBridge — Database Configuration
 *
 * PDO singleton. Uses real prepared statements (EMULATE_PREPARES = false)
 * for SQL-injection protection. Errors throw exceptions (ERRMODE_EXCEPTION).
 */

declare(strict_types=1);

class Database
{
    private static ?PDO $instance = null;

    // ── Connection settings — update for your XAMPP/Laragon environment ────
    private const HOST    = 'localhost';
    private const DB_NAME = 'skillbridge';
    private const USER    = 'root';
    private const PASS    = '';          // change if your MySQL has a root password
    private const CHARSET = 'utf8mb4';

    /** Returns the shared PDO instance (creates it on first call). */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                self::HOST,
                self::DB_NAME,
                self::CHARSET
            );

            self::$instance = new PDO($dsn, self::USER, self::PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,   // real prepared stmts
            ]);
        }

        return self::$instance;
    }

    // Prevent instantiation / cloning
    private function __construct() {}
    private function __clone() {}
}
