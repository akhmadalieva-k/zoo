<?php

namespace controllers;

use controllers\log\Logger;
use models\DepartmentsModel;

class DepartmentsController extends ControllerBase
{
    private DepartmentsModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new DepartmentsModel();
    }

    public function Department($id) : void
    {
        $data["employees"] = $this->Model->GetEmployees($id);
        $data["animals"] = $this->Model->GetAnimals($id);
        $this->Render($data);
    }

    public function Add() : void
    {
        if($this->Model->Add($_POST["department_name"]))
        {
            Logger::AddLog("add department");
        }
        Header('Location: http://localhost:84');
    }
}