<?php
/**
 * SkillBridge — Front Controller
 *
 * All HTTP requests are funnelled here via .htaccess mod_rewrite.
 * Flow: session → CORS → autoload → database → route → dispatch
 */

declare(strict_types=1);

// ── Security: harden session cookie before session_start ───────────────────
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_secure', '0');   // set to 1 on production HTTPS

session_start();

// ── Headers ────────────────────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');

// ── CORS ───────────────────────────────────────────────────────────────────
require_once __DIR__ . '/config/cors.php';

// ── Simple PSR-4-style autoloader ──────────────────────────────────────────
spl_autoload_register(function (string $class): void {
    $directories = [
        __DIR__ . '/helpers/',
        __DIR__ . '/config/',
        __DIR__ . '/middleware/',
        __DIR__ . '/models/',
        __DIR__ . '/services/',
        __DIR__ . '/controllers/',
        __DIR__ . '/routes/',
    ];
    foreach ($directories as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// ── Bootstrap: load helpers early (Response needed for error handling) ──────
require_once __DIR__ . '/helpers/Response.php';
require_once __DIR__ . '/helpers/Validator.php';
require_once __DIR__ . '/helpers/Sanitizer.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/middleware/RoleMiddleware.php';
require_once __DIR__ . '/routes/Router.php';

// ── Parse request ──────────────────────────────────────────────────────────
$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Strip the sub-directory prefix so routes start at /api/...
// Adjust $basePath to match your XAMPP deployment path.
$basePath = '/SkillBridge/CODE/backend';
$uri = str_replace($basePath, '', $uri);
$uri = rtrim($uri, '/') ?: '/';

// ── Dispatch ───────────────────────────────────────────────────────────────
try {
    $router = require __DIR__ . '/routes/api.php';
    $router->dispatch($method, $uri);
} catch (PDOException $e) {
    error_log('[SkillBridge DB Error] ' . $e->getMessage());
    Response::error('A database error occurred.', 500);
} catch (Throwable $e) {
    error_log('[SkillBridge Error] ' . $e->getMessage());
    Response::error('An internal server error occurred.', 500);
}
