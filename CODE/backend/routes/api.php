<?php
/**
 * SkillBridge — API Route Definitions
 *
 * Format: $router->METHOD('/api/path', 'Controller@method', ['middleware']);
 * Middleware options:
 *   'auth'          → requires authenticated session
 *   'role:student'  → requires student role
 *   'role:company'  → requires company role
 *   'role:admin'    → requires admin role
 */

declare(strict_types=1);

require_once __DIR__ . '/Router.php';

// Load all controller files up-front so the router can resolve them
$controllerPath = __DIR__ . '/../controllers/';
foreach (glob($controllerPath . '*.php') as $file) {
    require_once $file;
}

$router = new Router();

// ════════════════════════════════════════════════════════════
// HEALTH CHECK (public)
// ════════════════════════════════════════════════════════════
$router->get('/api/health', 'HealthController@check');

// ════════════════════════════════════════════════════════════
// AUTHENTICATION (public)
// ════════════════════════════════════════════════════════════
$router->post('/api/auth/register', 'AuthController@register');
$router->post('/api/auth/login',    'AuthController@login');
$router->post('/api/auth/logout',   'AuthController@logout',  ['auth']);
$router->get('/api/auth/me',        'AuthController@me',      ['auth']);

// ════════════════════════════════════════════════════════════
// STUDENT PROFILES
// ════════════════════════════════════════════════════════════
$router->get('/api/profiles/student/{id}', 'ProfileController@showStudent', ['auth']);
$router->put('/api/profiles/student',      'ProfileController@updateStudent', ['auth', 'role:student']);

// ════════════════════════════════════════════════════════════
// COMPANY PROFILES
// ════════════════════════════════════════════════════════════
$router->get('/api/profiles/company/{id}', 'ProfileController@showCompany', ['auth']);
$router->put('/api/profiles/company',      'ProfileController@updateCompany', ['auth', 'role:company']);

// ════════════════════════════════════════════════════════════
// CERTIFICATES (student only)
// ════════════════════════════════════════════════════════════
$router->get('/api/certificates',        'CertificateController@index',   ['auth', 'role:student']);
$router->post('/api/certificates',       'CertificateController@store',   ['auth', 'role:student']);
$router->delete('/api/certificates/{id}','CertificateController@destroy', ['auth', 'role:student']);

// ════════════════════════════════════════════════════════════
// POSTS / OPPORTUNITIES
// Note: /api/posts/my MUST be registered before /api/posts/{id}
// ════════════════════════════════════════════════════════════
$router->get('/api/posts/my',      'PostController@myPosts', ['auth', 'role:company']);
$router->get('/api/posts',         'PostController@index',   ['auth']);
$router->get('/api/posts/{id}',    'PostController@show',    ['auth']);
$router->post('/api/posts',        'PostController@store',   ['auth', 'role:company']);
$router->put('/api/posts/{id}',    'PostController@update',  ['auth', 'role:company']);
$router->delete('/api/posts/{id}', 'PostController@destroy', ['auth', 'role:company']);

// ════════════════════════════════════════════════════════════
// APPLICATIONS
// ════════════════════════════════════════════════════════════
$router->post('/api/applications',                'ApplicationController@store',        ['auth', 'role:student']);
$router->get('/api/applications/my',              'ApplicationController@myApps',       ['auth', 'role:student']);
$router->get('/api/applications/post/{post_id}',  'ApplicationController@forPost',      ['auth', 'role:company']);
$router->patch('/api/applications/{id}/status',   'ApplicationController@updateStatus', ['auth', 'role:company']);

// ════════════════════════════════════════════════════════════
// NOTIFICATIONS
// Note: /api/notifications/read-all before /api/notifications/{id}/read
// ════════════════════════════════════════════════════════════
$router->get('/api/notifications',                  'NotificationController@index',      ['auth']);
$router->patch('/api/notifications/read-all',       'NotificationController@markAllRead',['auth']);
$router->patch('/api/notifications/{id}/read',      'NotificationController@markRead',   ['auth']);

// ════════════════════════════════════════════════════════════
// FEED
// ════════════════════════════════════════════════════════════
$router->get('/api/feed', 'FeedController@index', ['auth']);

// ════════════════════════════════════════════════════════════
// ADMIN
// ════════════════════════════════════════════════════════════
$router->get('/api/admin/users',               'AdminController@users',      ['auth', 'role:admin']);
$router->patch('/api/admin/users/{id}/ban',    'AdminController@banUser',    ['auth', 'role:admin']);
$router->patch('/api/admin/users/{id}/unban',  'AdminController@unbanUser',  ['auth', 'role:admin']);
$router->get('/api/admin/posts',               'AdminController@posts',      ['auth', 'role:admin']);
$router->delete('/api/admin/posts/{id}',       'AdminController@deletePost', ['auth', 'role:admin']);
$router->get('/api/admin/analytics',           'AdminController@analytics',  ['auth', 'role:admin']);
$router->get('/api/admin/logs',                'AdminController@logs',       ['auth', 'role:admin']);

return $router;
