<?php
/**
 * SkillBridge — RoleMiddleware
 *
 * Checks that the authenticated user has the required role.
 * Always calls AuthMiddleware first to ensure session exists.
 */

declare(strict_types=1);

class RoleMiddleware
{
    /**
     * Abort with 403 if the session role does not match $requiredRole.
     *
     * @param string $requiredRole   One of: 'student', 'company', 'admin'
     */
    public static function handle(string $requiredRole): void
    {
        AuthMiddleware::handle(); // ensure authenticated first

        if (($_SESSION['role'] ?? '') !== $requiredRole) {
            Response::error(
                "Access denied. This action requires the '{$requiredRole}' role.",
                403
            );
        }
    }
}
