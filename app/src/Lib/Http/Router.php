<?php

namespace App\Lib\Http;

use App\Lib\Controllers\AbstractController;
use App\Lib\Http\Response;

class Router
{
    private const CONTROLLER_NAMESPACE = 'App\\Controllers\\';
    private const ROUTES_FILE = __DIR__ . '/../../../config/routes.json';

    public static function route(Request $request): Response
    {
        $routes = json_decode(
            file_get_contents(self::ROUTES_FILE),
            true
        );

        foreach ($routes as $route) {

            // vérification méthode
            if ($request->getMethod() !== $route['method']) {
                continue;
            }

            // vérification URI exacte
            if ($request->getUri() !== $route['path']) {
                continue;
            }

            $controllerClass = self::CONTROLLER_NAMESPACE . $route['controller'];

            if (!class_exists($controllerClass)) {
                return new Response(
                    json_encode(['error' => 'Controller not found']),
                    500,
                    ['Content-Type' => 'application/json']
                );
            }

            $controller = new $controllerClass();

            if (!$controller instanceof AbstractController) {
                return new Response(
                    json_encode(['error' => 'Invalid controller']),
                    500,
                    ['Content-Type' => 'application/json']
                );
            }

            return $controller->process($request);
        }

        return new Response(
            json_encode(['error' => 'Route not found']),
            404,
            ['Content-Type' => 'application/json']
        );
    }
}
