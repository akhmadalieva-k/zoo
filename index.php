<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function($className){
    $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    if(file_exists($file))
    {
        require $file;
    }
});

use controllers\log\Logger;
use core\Route;

try
{
    Route::Start();
}
catch (Error $e)
{
    Logger::AddErrorLog($e->getMessage());
    echo "error: " . $e->getMessage();
}
catch (Exception $ex)
{
    Logger::AddErrorLog($ex->getMessage());
    echo "exception: " . $ex->getMessage();
}