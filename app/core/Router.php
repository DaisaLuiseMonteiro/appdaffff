<?php

namespace App\Core;

use App\Core\Singleton;
require_once "../app/config/middlewares.php";

class Router extends Singleton
{

    public static function resolve()
    {
        global $routes;
        require_once "../routes/route.web.php";
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        $currentUri = trim(parse_url($requestUri, PHP_URL_PATH), '/');

        $routeKey = $requestMethod . ':/' . $currentUri;
        
        if (isset($routes[$routeKey])) {
            self::executeRoute($routes[$routeKey]);
            return;
        }
        
        foreach ($routes as $pattern => $route) {
            if (self::matchRoute($pattern, $routeKey)) {
                $params = self::extractParams($pattern, $routeKey);
                self::executeRoute($route, $params);
                return;
            }
        }
        
        self::sendJsonResponse(['error' => 'Route not found'], 404);
    }

    private static function matchRoute($pattern, $uri)
    {
        $regex = preg_replace('/\{[^}]+\}/', '([^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';
        
        return preg_match($regex, $uri);
    }

    private static function extractParams($pattern, $uri)
    {
        $params = [];
        
        preg_match_all('/\{([^}]+)\}/', $pattern, $paramNames);
        
        $regex = preg_replace('/\{[^}]+\}/', '([^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';
        
        if (preg_match($regex, $uri, $matches)) {
            array_shift($matches); 
            
            foreach ($paramNames[1] as $index => $paramName) {
                if (isset($matches[$index])) {
                    $params[$paramName] = $matches[$index];
                }
            }
        }
        
        return $params;
    }

    private static function executeRoute($route, $params = [])
    {
        try {
            if (isset($route['middlewares'])) {
                foreach ($route['middlewares'] as $middleware) {
                    if (!self::executeMiddleware($middleware)) {
                        return;
                    }
                }
            }

            $controllerClass = $route['controller'];
            $method = $route['method'];

            if (!class_exists($controllerClass)) {
                self::sendJsonResponse(['error' => 'Controller not found'], 500);
                return;
            }

            $controller = new $controllerClass();
            
            if (!method_exists($controller, $method)) {
                self::sendJsonResponse(['error' => 'Method not found'], 500);
                return;
            }

            if (!empty($params)) {
                $controller->$method($params);
            } else {
                $controller->$method();
            }

        } catch (Exception $e) {
            self::sendJsonResponse(['error' => 'Internal server error', 'message' => $e->getMessage()], 500);
        }
    }

    private static function executeMiddleware($middlewareName)
    {
        global $middlewares;
        
        if (isset($middlewares[$middlewareName])) {
            $middlewareFunction = $middlewares[$middlewareName];
            $result = $middlewareFunction();
            
            if ($result === false) {
                return false;
            }
        }
        
        return true;
    }

    private static function sendJsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}