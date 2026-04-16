<?php
/**
 * SkillBridge — AuthMiddleware
 *
 * Verifies that a valid session exists. Every protected route calls this first.
 */

declare(strict_types=1);

class AuthMiddleware
{
    /**
     * Abort with 401 if the user is not authenticated.
     * Called inside Router::dispatch() for routes with 'auth' middleware.
     */
    public static function handle(): void
    {
        if (empty($_SESSION['user_id'])) {
            Response::error('Not authenticated. Please log in.', 401);
        }
    }
}
