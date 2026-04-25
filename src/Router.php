<?php
// src/Router.php

class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Register a GET route
     */
    public function get($path, $handler) {
        $this->routes['GET'][$this->normalizePath($path)] = $handler;
    }

    /**
     * Register a POST route
     */
    public function post($path, $handler) {
        $this->routes['POST'][$this->normalizePath($path)] = $handler;
    }

    /**
     * Normalize paths by trimming trailing slashes and ensuring a leading slash
     */
    private function normalizePath($path) {
        $path = trim($path, '/');
        return '/' . $path;
    }

    /**
     * Dispatch the current request
     */
    public function dispatch() {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Extract path from URL, stripping query parameters
        $path = parse_url($requestUri, PHP_URL_PATH);

        // Compute base directory to support running in XAMPP subdirectories
        $scriptName = $_SERVER['SCRIPT_NAME']; // e.g. /KDS/public/index.php
        $baseDir = dirname($scriptName);      // e.g. /KDS/public or \KDS\public
        
        // Normalize slashes for Windows/XAMPP compatibility
        $baseDir = str_replace('\\', '/', $baseDir);
        $path = str_replace('\\', '/', $path);

        // Strip baseDir from path if present
        if ($baseDir !== '/' && strpos($path, $baseDir) === 0) {
            $path = substr($path, strlen($baseDir));
        }

        $normalizedPath = $this->normalizePath($path);

        // Check if route exists
        if (isset($this->routes[$requestMethod][$normalizedPath])) {
            $handler = $this->routes[$requestMethod][$normalizedPath];
            $this->executeHandler($handler);
        } else {
            // Send 404
            http_response_code(404);
            $this->render404();
        }
    }

    /**
     * Execute route handler
     */
    private function executeHandler($handler) {
        if (is_callable($handler)) {
            $handler();
        } elseif (is_string($handler)) {
            // Pattern: ControllerName@methodName
            $parts = explode('@', $handler);
            if (count($parts) === 2) {
                $controllerName = $parts[0];
                $methodName = $parts[1];

                $controllerFile = dirname(__DIR__) . "/src/Controllers/{$controllerName}.php";
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    if (class_exists($controllerName)) {
                        $controller = new $controllerName();
                        if (method_exists($controller, $methodName)) {
                            $controller->$methodName();
                            return;
                        }
                    }
                }
            }
            
            // Fallback error if controller class or method doesn't exist
            http_response_code(500);
            echo "Internal Server Error: Handler '{$handler}' could not be resolved.";
        }
    }

    /**
     * Renders a custom premium 404 page
     */
    private function render404() {
        $viewPath = dirname(__DIR__) . '/views/pages/404.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<h1>404 - Page Not Found</h1><p>The page you are looking for does not exist.</p>";
        }
    }
}
