<?php

namespace controllers;

use controllers\ControllerBase;
use models\HomeModel;

class HomeController extends ControllerBase
{
    private HomeModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new HomeModel();
    }

    public function Index() : void
    {
        $departments = $this->Model->GetDepartments();
        $headers = array("employees/list" => "сотрудники", "animals/list" => "животные");
        $data = array('headers' => $headers, 'departments' => $departments);
        $this->Render($data);
    }
}