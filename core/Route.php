<?php

namespace core;

use Error;

class Route
{
    public static function Start() : void
    {
        if (preg_match('/\.(ico|png|jpg|jpeg|css|js|svg|woff2?)/', $_SERVER["REQUEST_URI"])) {
            return;
        }
        $route = explode("/", explode('?', $_SERVER["REQUEST_URI"])[0]);
        $controllerName = !empty($route[1]) ? $route[1] : "Home";
        $actionName = !empty($route[2]) ? $route[2] : "Index";
        $param = !empty($route[3]) ? $route[3] : null;

        $controllerClass = "controllers\\" .  ucfirst($controllerName) . "Controller";
        $action = ucfirst($actionName);

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $action)) {
                isset($param) 
                    ? $controller->$action($param) 
                    : $controller->$action();
            }
            else {
                throw new Error("method not exists");
            }
        } else {
            throw new Error("controller not exists");
        }
    }
}


// server {
//         listen 84;
//         server_name localhost;

//         location / {
//                 root /var/nginx/test1;
//                 index index.php;
//                 try_files $uri $uri/ /index.php?$query_string;

//                 include /etc/nginx/modules/php.module;
//         }

// }
