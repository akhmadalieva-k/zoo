<?php

namespace controllers;

use models\AnimalsModel;


class AnimalsController extends ControllerBase
{
    private AnimalsModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new AnimalsModel();
    }

    public function All()
    {
        $data = $this->Model->GetData();
        $this->Render($data);
    }

    public function Select()
    {
        if ($_POST["class_id"] == "all"){
            // $this->All();
            Header('Location: http://localhost:84/animals/all');
        }
        else {
        $data = $this->Model->Select($_POST["class_id"]);
        $this->Render($data);
        }
    }

    public function Add()
    {
        $this->Model->Add($_POST["value"]);
        Header('Location: http://localhost:84/animals/all');
    }

    public function Update()
    {
        $this->Model->UpdateAnimal($_POST["value"]);
        Header('Location: http://localhost:84/animals/all');
    }

    public function Delete()
    {
        $this->Model->DeleteAnimal($_POST["animal_id"]);
        echo "deleted";
        Header('Location: http://localhost:84/animals/all');
    }
}