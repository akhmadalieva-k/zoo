<?php

namespace controllers;

use controllers\log\Logger;
use models\EmployeesModel;

class EmployeesController extends ControllerBase
{
    private EmployeesModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new EmployeesModel();
    }

    public function All() : void
    {
        $data["employees"] = $this->Model->GetAll();
        $data["departments"] = $this->Model->GetDepartments();
        $this->Render($data);
    }

    public function Select() : void
    {
        if($_POST["spec_id"] == "all"){
            Header('Location: http://localhost:84/employees/all');
        }
        else {
        $data["employees"] = $this->Model->SelectSpec($_POST["spec_id"]);
        $this->Render($data);
        }
    }

    public function Add() : void
    {
        // print_r($_POST);
        $params = [
            "employee_name" => $_POST['value']['employee_name'] ?? '',
            "specialization_id" => $_POST['value']['specialization_id'] ?? '',
            "department_id" => $_POST['value']['department_id'] ?? ''
        ];
        // print_r($params);
        // exit;
        if($this->Model->Add($params))
        {
            Logger::AddLog("create employee");
        };
        $this->All();
    }

    public function Update() : void
    {
        if($this->Model->Update($_POST["value"]))
        {
            Logger::AddLog("change employee");
        }
        Header('Location: http://localhost:84/employees/all');
    }

    public function Delete() : void
    {
        if($this->Model->Delete($_POST["employee_id_to_delete"]))
        {
            Logger::AddLog("delete employee");
        }
        Header('Location: http://localhost:84/employees/all');
    }
}