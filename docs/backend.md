# SkillBridge — Backend Architecture

> PHP API architecture, module design, request handling, and implementation patterns.

---

## 1. Architecture Overview

The backend follows an **MVC-inspired architecture** without using a framework. All requests enter through a single front controller (`index.php`), are routed to the appropriate controller, pass through middleware for authentication and authorization, and return JSON responses.

```
Request → index.php → Router → Middleware → Controller → Service → Model → Response
```

---

## 2. Directory Structure

```
backend/
├── index.php                       # Front controller
├── .htaccess                       # URL rewriting
│
├── config/
│   ├── database.php                # PDO connection singleton
│   ├── cors.php                    # CORS headers
│   └── constants.php               # App constants (roles, statuses)
│
├── routes/
│   └── api.php                     # Route definitions
│
├── middleware/
│   ├── AuthMiddleware.php          # Session verification
│   └── RoleMiddleware.php          # Role-based access control
│
├── controllers/
│   ├── AuthController.php          # Registration, login, logout
│   ├── StudentProfileController.php # Student profile CRUD
│   ├── CompanyProfileController.php # Company profile CRUD
│   ├── CertificateController.php   # Certificate management
│   ├── PostController.php          # Post CRUD and listing
│   ├── ApplicationController.php   # Application submission + decisions
│   ├── NotificationController.php  # Notification listing + read
│   ├── FeedController.php          # Activity feed
│   └── AdminController.php         # Admin operations
│
├── services/
│   ├── AuthService.php
│   ├── ProfileService.php
│   ├── CertificateService.php
│   ├── PostService.php
│   ├── ApplicationService.php
│   ├── NotificationService.php
│   ├── FeedService.php
│   └── AdminService.php
│
├── models/
│   ├── UserModel.php
│   ├── StudentProfileModel.php
│   ├── CompanyProfileModel.php
│   ├── CertificateModel.php
│   ├── PostModel.php
│   ├── ApplicationModel.php
│   ├── NotificationModel.php
│   ├── FeedModel.php
│   └── AdminLogModel.php
│
└── helpers/
    ├── Response.php                # JSON response builder
    ├── Validator.php               # Input validation
    └── Sanitizer.php               # Input sanitization
```

---

## 3. Core Components

### 3.1 Front Controller (`index.php`)

All HTTP requests are funneled through `index.php` via Apache's `mod_rewrite`:

```php
<?php
// index.php — Front Controller

// Start session
session_start();

// Set response headers
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config/cors.php';

// Autoload classes (simple PSR-4 style)
spl_autoload_register(function ($class) {
    $directories = ['controllers', 'services', 'models', 'middleware', 'helpers'];
    foreach ($directories as $dir) {
        $file = __DIR__ . "/$dir/$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Load database connection
require_once __DIR__ . '/config/database.php';

// Parse request
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base path prefix (adjust based on deployment)
$basePath = '/SkillBridge/backend';
$uri = str_replace($basePath, '', $uri);
$uri = rtrim($uri, '/');

// Load and execute routes
$router = require __DIR__ . '/routes/api.php';
$router->dispatch($method, $uri);
```

### 3.2 Router (`routes/api.php`)

```php
<?php
// routes/api.php — Route Definitions

$router = new Router();

// Authentication (public)
$router->post('/api/auth/register',   'AuthController@register');
$router->post('/api/auth/login',      'AuthController@login');
$router->post('/api/auth/logout',     'AuthController@logout',     ['auth']);
$router->get('/api/auth/me',          'AuthController@me',         ['auth']);

// Student Profiles
$router->get('/api/profiles/student/{id}', 'StudentProfileController@show', ['auth']);
$router->put('/api/profiles/student',      'StudentProfileController@update', ['auth', 'role:student']);

// Company Profiles
$router->get('/api/profiles/company/{id}', 'CompanyProfileController@show', ['auth']);
$router->put('/api/profiles/company',      'CompanyProfileController@update', ['auth', 'role:company']);

// Certificates
$router->get('/api/certificates',       'CertificateController@index',   ['auth', 'role:student']);
$router->post('/api/certificates',      'CertificateController@store',   ['auth', 'role:student']);
$router->delete('/api/certificates/{id}', 'CertificateController@destroy', ['auth', 'role:student']);

// Posts
$router->get('/api/posts',          'PostController@index',   ['auth']);
$router->get('/api/posts/my',       'PostController@myPosts', ['auth', 'role:company']);
$router->get('/api/posts/{id}',     'PostController@show',    ['auth']);
$router->post('/api/posts',         'PostController@store',   ['auth', 'role:company']);
$router->put('/api/posts/{id}',     'PostController@update',  ['auth', 'role:company']);
$router->delete('/api/posts/{id}',  'PostController@destroy', ['auth', 'role:company']);

// Applications
$router->post('/api/applications',              'ApplicationController@store',     ['auth', 'role:student']);
$router->get('/api/applications/my',            'ApplicationController@myApps',    ['auth', 'role:student']);
$router->get('/api/applications/post/{id}',     'ApplicationController@forPost',   ['auth', 'role:company']);
$router->patch('/api/applications/{id}/status', 'ApplicationController@updateStatus', ['auth', 'role:company']);

// Notifications
$router->get('/api/notifications',              'NotificationController@index',    ['auth']);
$router->patch('/api/notifications/{id}/read',  'NotificationController@markRead', ['auth']);
$router->patch('/api/notifications/read-all',   'NotificationController@markAllRead', ['auth']);

// Feed
$router->get('/api/feed', 'FeedController@index', ['auth']);

// Admin
$router->get('/api/admin/users',              'AdminController@users',      ['auth', 'role:admin']);
$router->patch('/api/admin/users/{id}/ban',   'AdminController@banUser',    ['auth', 'role:admin']);
$router->patch('/api/admin/users/{id}/unban', 'AdminController@unbanUser',  ['auth', 'role:admin']);
$router->get('/api/admin/posts',              'AdminController@posts',      ['auth', 'role:admin']);
$router->delete('/api/admin/posts/{id}',      'AdminController@deletePost', ['auth', 'role:admin']);
$router->get('/api/admin/analytics',          'AdminController@analytics',  ['auth', 'role:admin']);
$router->get('/api/admin/logs',               'AdminController@logs',       ['auth', 'role:admin']);

return $router;
```

### 3.3 Database Configuration (`config/database.php`)

```php
<?php
// config/database.php — PDO Singleton

class Database {
    private static ?PDO $instance = null;

    private const HOST = 'localhost';
    private const DB_NAME = 'skillbridge';
    private const USERNAME = 'root';
    private const PASSWORD = '';
    private const CHARSET = 'utf8mb4';

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                self::HOST, self::DB_NAME, self::CHARSET
            );

            self::$instance = new PDO($dsn, self::USERNAME, self::PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
        return self::$instance;
    }
}
```

### 3.4 Response Helper (`helpers/Response.php`)

```php
<?php
// helpers/Response.php — Standardized JSON responses

class Response {
    public static function success($data, int $statusCode = 200): void {
        http_response_code($statusCode);
        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
        exit;
    }

    public static function error(string $message, int $statusCode = 400): void {
        http_response_code($statusCode);
        echo json_encode([
            'success' => false,
            'error' => $message,
        ]);
        exit;
    }

    public static function paginated(array $items, int $page, int $totalItems, int $perPage): void {
        self::success([
            'items' => $items,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => (int)ceil($totalItems / $perPage),
                'total_items' => $totalItems,
                'per_page' => $perPage,
            ],
        ]);
    }
}
```

### 3.5 Validator Helper (`helpers/Validator.php`)

```php
<?php
// helpers/Validator.php — Input Validation

class Validator {
    private array $errors = [];

    public function required(string $field, $value): self {
        if (empty(trim($value))) {
            $this->errors[$field] = "$field is required.";
        }
        return $this;
    }

    public function email(string $field, $value): self {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Invalid email format.";
        }
        return $this;
    }

    public function minLength(string $field, $value, int $min): self {
        if (strlen($value) < $min) {
            $this->errors[$field] = "$field must be at least $min characters.";
        }
        return $this;
    }

    public function maxLength(string $field, $value, int $max): self {
        if (strlen($value) > $max) {
            $this->errors[$field] = "$field must not exceed $max characters.";
        }
        return $this;
    }

    public function inList(string $field, $value, array $allowed): self {
        if (!in_array($value, $allowed)) {
            $this->errors[$field] = "$field must be one of: " . implode(', ', $allowed);
        }
        return $this;
    }

    public function passes(): bool {
        return empty($this->errors);
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
```

---

## 4. Middleware

### 4.1 Authentication Middleware

```php
<?php
// middleware/AuthMiddleware.php

class AuthMiddleware {
    public static function handle(): void {
        if (!isset($_SESSION['user_id'])) {
            Response::error('Not authenticated.', 401);
        }
    }
}
```

### 4.2 Role Middleware

```php
<?php
// middleware/RoleMiddleware.php

class RoleMiddleware {
    public static function handle(string $requiredRole): void {
        AuthMiddleware::handle();

        if ($_SESSION['role'] !== $requiredRole) {
            Response::error('Access denied. Required role: ' . $requiredRole, 403);
        }
    }
}
```

---

## 5. Controller Pattern

Every controller follows a consistent pattern:

```php
<?php
// controllers/AuthController.php

class AuthController {
    private AuthService $service;

    public function __construct() {
        $this->service = new AuthService();
    }

    public function register(): void {
        // 1. Get input
        $input = json_decode(file_get_contents('php://input'), true);

        // 2. Validate
        $validator = new Validator();
        $validator->required('email', $input['email'] ?? '')
                  ->email('email', $input['email'] ?? '')
                  ->required('password', $input['password'] ?? '')
                  ->minLength('password', $input['password'] ?? '', 8)
                  ->required('full_name', $input['full_name'] ?? '')
                  ->required('role', $input['role'] ?? '')
                  ->inList('role', $input['role'] ?? '', ['student', 'company']);

        if (!$validator->passes()) {
            Response::error($validator->getErrors(), 400);
        }

        // 3. Sanitize
        $email = Sanitizer::email($input['email']);
        $fullName = Sanitizer::string($input['full_name']);
        $role = $input['role'];
        $password = $input['password'];

        // 4. Delegate to service
        $result = $this->service->register($email, $password, $fullName, $role);

        // 5. Respond
        Response::success($result, 201);
    }

    // ... other methods
}
```

---

## 6. Service Pattern

Services contain business logic and coordinate between models:

```php
<?php
// services/ApplicationService.php

class ApplicationService {
    private ApplicationModel $applicationModel;
    private NotificationService $notificationService;
    private FeedService $feedService;

    public function __construct() {
        $this->applicationModel = new ApplicationModel();
        $this->notificationService = new NotificationService();
        $this->feedService = new FeedService();
    }

    public function submitApplication(int $studentId, int $postId, ?string $coverLetter): array {
        // Check if already applied
        if ($this->applicationModel->exists($studentId, $postId)) {
            Response::error('You have already applied to this post.', 409);
        }

        // Create application
        $applicationId = $this->applicationModel->create($studentId, $postId, $coverLetter);

        // Create feed activity
        $this->feedService->logActivity($studentId, 'application_submitted', $applicationId);

        // Notify the company
        $post = (new PostModel())->getById($postId);
        $this->notificationService->create(
            $post['company_id'],
            'New Application',
            "A student applied to your post: {$post['title']}",
            'new_application',
            $applicationId
        );

        return ['id' => $applicationId, 'status' => 'pending'];
    }

    public function updateStatus(int $applicationId, string $status, int $companyId): void {
        $application = $this->applicationModel->getById($applicationId);

        // Verify ownership
        $post = (new PostModel())->getById($application['post_id']);
        if ($post['company_id'] !== $companyId) {
            Response::error('Access denied.', 403);
        }

        // Update status
        $this->applicationModel->updateStatus($applicationId, $status);

        // Notify student
        $type = $status === 'accepted' ? 'application_accepted' : 'application_rejected';
        $message = "Your application for \"{$post['title']}\" has been {$status}.";
        $this->notificationService->create(
            $application['student_id'],
            'Application ' . ucfirst($status),
            $message,
            $type,
            $applicationId
        );
    }
}
```

---

## 7. Model Pattern

Models handle all database queries using PDO prepared statements:

```php
<?php
// models/PostModel.php

class PostModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getActiveWithPagination(int $page, int $limit, ?string $type = null): array {
        $offset = ($page - 1) * $limit;
        $where = 'WHERE status = "active"';
        $params = [];

        if ($type) {
            $where .= ' AND type = ?';
            $params[] = $type;
        }

        $stmt = $this->db->prepare(
            "SELECT p.*, cp.company_name, u.avatar_url as company_avatar
             FROM posts p
             JOIN users u ON p.company_id = u.id
             JOIN company_profiles cp ON u.id = cp.user_id
             $where
             ORDER BY p.created_at DESC
             LIMIT ? OFFSET ?"
        );
        $params[] = $limit;
        $params[] = $offset;
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare(
            'INSERT INTO posts (company_id, title, description, type, requirements, location, is_remote, deadline)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['company_id'],
            $data['title'],
            $data['description'],
            $data['type'],
            $data['requirements'] ?? null,
            $data['location'] ?? null,
            $data['is_remote'] ?? 0,
            $data['deadline'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }
}
```

---

## 8. Error Handling

All errors are caught and returned as consistent JSON:

```php
// In index.php, wrap dispatch in try-catch
try {
    $router->dispatch($method, $uri);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    Response::error('A database error occurred.', 500);
} catch (Exception $e) {
    error_log("Application error: " . $e->getMessage());
    Response::error('An internal error occurred.', 500);
}
```

---

## 9. Session Data Structure

After login, the session stores:

```php
$_SESSION = [
    'user_id' => 5,
    'email' => 'user@example.com',
    'full_name' => 'Ahmed Benali',
    'role' => 'student',           // 'student' | 'company' | 'admin'
    'logged_in_at' => '2026-04-09 10:30:00',
];
```

---

## 10. CORS Configuration

```php
<?php
// config/cors.php

$allowedOrigins = [
    'http://localhost',
    'http://localhost:3000',
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
}

header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
```
