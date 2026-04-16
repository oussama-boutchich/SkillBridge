<?php
/**
 * SkillBridge — HealthController
 * Simple endpoint to confirm the API is running.
 */

declare(strict_types=1);

class HealthController
{
    public function check(): void
    {
        // Also test DB connectivity
        try {
            $pdo = Database::getConnection();
            $pdo->query('SELECT 1');
            $dbStatus = 'connected';
        } catch (Throwable) {
            $dbStatus = 'error';
        }

        Response::success([
            'message'   => 'SkillBridge API is running.',
            'version'   => '1.0.0',
            'database'  => $dbStatus,
            'timestamp' => date('Y-m-d H:i:s'),
        ]);
    }
}
