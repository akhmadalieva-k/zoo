<?php

spl_autoload_register(function($className){
    $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    if(file_exists($file))
    {
        require $file;
    }
});

use core\Route;

try
{
    Route::Start();
}
catch (Error $ex)
{
    print_r($ex);
}
catch (Exception $ex)
{
    print_r($ex);
}