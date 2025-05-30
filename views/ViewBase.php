<?php

namespace views;

abstract class ViewBase
{
    public static function Render(string $view, array $data = null, string $templateView = "main_template.php")
    { 
        include_once(__DIR__ . "/" . $templateView);
    }
}