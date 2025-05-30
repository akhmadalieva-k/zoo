<?php

namespace controllers;

use models\AnimalModel;

class AnimalController extends ControllerBase
{
    private AnimalModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new AnimalModel();
    }

    public function Redact($id)
    {
        $data = $this->Model->GetById($id);
        $this->Render($data);
    }

    public function Save()
    {
        $this->Model->SaveAnimal($_POST["value"]);
        $this->Redact($_POST["value"]["animal_id"]);
    }

    // public function Delete()
    // {
    //     // print_r($_POST);
    //     $this->Model->DeleteAnimal($_POST["animal_id"]);
    //     echo "deleted";
    //     Header('Location: http://localhost:84/animals/all');
    // }
}