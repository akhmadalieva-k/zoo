<?php
namespace controllers;

use ModelBase;
use views\ViewBase;

abstract class ControllerBase
{
    protected string $ViewName;

    public function __construct()
    {
        $this->ViewName = get_class($this);
        $this->ViewName = str_replace("Controller", "View", $this->ViewName) . ".php";
        $this->ViewName = str_replace("controllers\\", "", $this->ViewName);
    }

    public function Render(?array $data = null): void
    {
        ViewBase::Render($this->ViewName, $data);
    }
}