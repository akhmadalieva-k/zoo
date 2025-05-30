<?php

namespace core;

use Error;

class Route
{
    public static function Start()
    {
        $route = explode("/", $_SERVER["REQUEST_URI"]);
        $controllerName = strlen($route[1] > 0) ? $route[1] : "Home";
        $actionName = strlen($route[2] > 0) ? $route[2] : "Index";
        $param = strlen($route[3] > 0) ? $route[3] : null;

        $controllerClass = "controllers\\" .  ucfirst($controllerName) . "Controller";
        $action = ucfirst($actionName);

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $action)) {
                isset($param) 
                    ? $controller->$action($param) 
                    : $controller->$action();
            }
        } else {
            throw new Error("method or controller not exists");
        }
    }
}
