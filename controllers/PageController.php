<?php

namespace controllers;

use controllers\log\Logger;
use models\PageModel;

class PageController extends ControllerBase
{
    private PageModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new PageModel();
    }

    public function Animal(int $id): void
    {
        $data["employee_link"] = $this->Model->GetAnimalLink($id);
        $data["animal"] = $this->Model->GetAnimalInfo($id);
        if (isset($data["animal"]["department_id"])) {
            $data["employee_list"] = $this->Model->GetEmployeeList($data["animal"]["department_id"]);
        }
        $this->Render($data);
    }

    public function Employee(int $id): void
    {
        $data["link"] = $this->Model->GetEmployeeLink($id);
        $data["employee"] = $this->Model->GetEmployeeInfo($id);
        $this->Render($data);
    }

    public function Add(): void
    {
        $id = $_POST["animal_id"];
        if ($this->Model->DeleteLink($_POST["animal_id"])) {
            Logger::AddLog("delete row in employee_animal_link");
        }
        if ($this->Model->AddLink($_POST["employee_id"], $_POST["animal_id"])) {
            Logger::AddLog("add row in employee_animal_link");
        }
        Header("Location: http://localhost:84/page/animal/$id");
    }
}
