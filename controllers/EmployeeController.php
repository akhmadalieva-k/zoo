<?php

namespace controllers;

use models\EmployeeModel;

class EmployeeController extends ControllerBase
{
    private EmployeeModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new EmployeeModel();
    }

    public function Redact($id)
    {
        $data = $this->Model->GetById($id);
        $this->Render($data);
    }

    public function Save()
    {
        $this->Model->Update($_POST["value"]);
        $this->Redact($_POST["value"]["employee_id"]);
    }

    public function Delete()
    {
        $this->Model->Delete($_POST["employee_id_to_delete"]);
        Header('Location: http://localhost:84/employees/all');
    }
}