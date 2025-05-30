<?php

namespace controllers;

use models\EmployeesModel;

class EmployeesController extends ControllerBase
{
    private EmployeesModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new EmployeesModel();
    }

    public function All()
    {
        $data = $this->Model->GetAll();
        $this->Render($data);
    }

    public function Select()
    {
        if($_POST["spec_id"] == "all"){
            $this->All();
        }
        else {
        $data = $this->Model->SelectSpec($_POST["spec_id"]);
        $this->Render($data);
        }
    }

    public function Add()
    {
        $this->Model->Add($_POST["value"]);
        $this->All();
    }
}