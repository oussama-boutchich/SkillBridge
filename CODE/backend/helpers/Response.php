<?php
/**
 * SkillBridge — JSON Response Helper
 *
 * All API responses go through this class to guarantee a consistent envelope:
 *   Success: { "success": true,  "data": ... }
 *   Error:   { "success": false, "error": ... }
 */

declare(strict_types=1);

class Response
{
    /**
     * Send a successful JSON response and exit.
     *
     * @param mixed $data       Any JSON-serialisable value.
     * @param int   $statusCode HTTP status code (default 200).
     */
    public static function success(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        echo json_encode([
            'success' => true,
            'data'    => $data,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send an error JSON response and exit.
     *
     * @param mixed $message    String message or associative array of field errors.
     * @param int   $statusCode HTTP status code (default 400).
     */
    public static function error(mixed $message, int $statusCode = 400): void
    {
        http_response_code($statusCode);
        echo json_encode([
            'success' => false,
            'error'   => $message,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send a paginated list response.
     *
     * @param array $items       The page of items.
     * @param int   $page        Current page number.
     * @param int   $totalItems  Total items across all pages.
     * @param int   $perPage     Items per page.
     */
    public static function paginated(array $items, int $page, int $totalItems, int $perPage): void
    {
        self::success([
            'items'      => $items,
            'pagination' => [
                'current_page' => $page,
                'total_pages'  => (int) ceil($totalItems / max(1, $perPage)),
                'total_items'  => $totalItems,
                'per_page'     => $perPage,
            ],
        ]);
    }
}
