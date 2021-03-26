<?php

final class Router
{
    private static $routes = null;

    final public static function init(array $routes = [])
    {
        self::addRoutes($routes);
    }

    final public static function addRoute(string $pattern, string $method, string $controller, string $controllerMethod, string $role)
    {
        self::$routes[] = array(
            'pattern'          => $pattern,
            'httpMethod'       => $method,
            'controller'       => $controller,
            'controllerMethod' => $controllerMethod,
            'role'             => $role
        );
    }

    final public static function addRoutes(array $routes = [])
    {
        foreach ($routes as $route) {
            self::addRoute($route[0], $route[1], $route[2], $route[3], $route[4]);
        }
    }

    final public static function matchedRoute()
    {
        $noMatchedMethod = false;

        $arguments = [];
        foreach (self::$routes as $route) {
            if (preg_match($route['pattern'], Http::$uri, $arguments)) {
                unset($arguments[0]);
                Http::$arguments = array_values($arguments);
                if ($route['httpMethod'] === Http::$method) {
                    if($route['role'] === 'all' || preg_match('/^' . $route['role'] . '$/i', Session::get('role'))) {
                        return $route;
                    }
                    return array(
                        'pattern'          => '',
                        'httpMethod'       => '',
                        'controller'       => 'Error',
                        'controllerMethod' => 'forbidden'
                    );
                }
                $noMatchedMethod = true;
            }
        }

        if ($noMatchedMethod) {
            return array(
                'pattern'          => '',
                'httpMethod'       => '',
                'controller'       => 'Error',
                'controllerMethod' => 'methodNotAllowed'
            );
        }

        return array(
            'pattern'          => '',
            'httpMethod'       => '',
            'controller'       => 'Error',
            'controllerMethod' => 'notFound'
        );
    }

    private function __construct()
    {
    }
}
