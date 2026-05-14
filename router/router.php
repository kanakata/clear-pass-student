<?php

namespace Router;

class Router
{
    private static array $allowed_pages = [
        "/",
        "/dashboard",
        "/department",
        "/landing",
        "/login",
        "/logout",
        "/payDebt",
        "/payShipment",
        "/register",
        "/selectInstitution",
    ];

    public static function router(string $path)
    {
        $path = ($path === "/") ? "/landing" : $path;

        if (in_array($path, self::$allowed_pages)) {
            return self::web($path);
        }
    }

    private static function web(string $path)
    {
        $controllerName = self::createControllerName($path);
        $fullClass = "App\Controllers\\" . $controllerName;

        // if ($path === "/logout") return ;
        // if ($path === "/pricing-back") return;

        if (class_exists($fullClass)) {
            $controller = new $fullClass();
            return $controller->show();
        }
    }

    private static function createControllerName(string $path): string
    {

        $name = ucfirst(ltrim($path, '/'));
        $name = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));

        return $name . "Controller";
    }
}
