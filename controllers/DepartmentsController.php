<?php

namespace controllers;

use models\DepartmentsModel;

class DepartmentsController extends ControllerBase
{
    private DepartmentsModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new DepartmentsModel();
    }

    public function All()
    {
        $data = $this->Model->GetAllDepartments();
        $this->Render($data);
    }
}