<?php
/**
 * SkillBridge — Router
 *
 * Lightweight router that:
 *  - Registers routes with HTTP method, URI pattern, controller@method, and middleware list.
 *  - Supports dynamic URI segments: {id}, {post_id}, etc.
 *  - Extracts segment values and passes them as method parameters.
 *  - Runs middleware (auth, role:X) before the controller method.
 */

declare(strict_types=1);

class Router
{
    /** @var array<int, array{method:string, pattern:string, action:string, middleware:string[]}> */
    private array $routes = [];

    // ── Route registration ─────────────────────────────────────────────────

    public function get(string $uri, string $action, array $middleware = []): void
    {
        $this->add('GET', $uri, $action, $middleware);
    }

    public function post(string $uri, string $action, array $middleware = []): void
    {
        $this->add('POST', $uri, $action, $middleware);
    }

    public function put(string $uri, string $action, array $middleware = []): void
    {
        $this->add('PUT', $uri, $action, $middleware);
    }

    public function patch(string $uri, string $action, array $middleware = []): void
    {
        $this->add('PATCH', $uri, $action, $middleware);
    }

    public function delete(string $uri, string $action, array $middleware = []): void
    {
        $this->add('DELETE', $uri, $action, $middleware);
    }

    private function add(string $method, string $uri, string $action, array $middleware): void
    {
        // Convert {param} placeholders to named regex capture groups
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $uri);
        $pattern = '@^' . $pattern . '$@D';

        $this->routes[] = compact('method', 'pattern', 'action', 'middleware');
    }

    // ── Dispatch ───────────────────────────────────────────────────────────

    public function dispatch(string $method, string $uri): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (!preg_match($route['pattern'], $uri, $matches)) {
                continue;
            }

            // ── Run middleware ──────────────────────────────────────────
            foreach ($route['middleware'] as $mw) {
                if ($mw === 'auth') {
                    AuthMiddleware::handle();
                } elseif (str_starts_with($mw, 'role:')) {
                    $role = substr($mw, 5);
                    RoleMiddleware::handle($role);
                }
            }

            // ── Resolve controller + method ─────────────────────────────
            [$controllerClass, $controllerMethod] = explode('@', $route['action'], 2);

            // Load the controller file if not already loaded
            $file = __DIR__ . '/../controllers/' . $controllerClass . '.php';
            if (file_exists($file)) {
                require_once $file;
            }

            if (!class_exists($controllerClass)) {
                Response::error("Controller '{$controllerClass}' not found.", 500);
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $controllerMethod)) {
                Response::error("Method '{$controllerMethod}' not found on '{$controllerClass}'.", 500);
            }

            // ── Extract dynamic URI params (named captures only) ────────
            $params = array_filter(
                $matches,
                fn($key) => !is_int($key),
                ARRAY_FILTER_USE_KEY
            );

            // ── Call controller method ──────────────────────────────────
            $controller->$controllerMethod(...array_values($params));
            return;
        }

        // No matching route found
        Response::error('Route not found.', 404);
    }
}
