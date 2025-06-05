<?php

namespace controllers;

use controllers\log\Logger;
use models\AnimalsModel;


class AnimalsController extends ControllerBase
{
    private AnimalsModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new AnimalsModel();
    }

    public function All() : void
    {
        $data["departments"] = $this->Model->GetDepartments();
        $data["animals"] = $this->Model->GetData();
        $this->Render($data);
    }

    public function Select() : void
    {
        if ($_POST["class_id"] == "all"){
            Header('Location: http://localhost:84/animals/all');
        }
        else {
        $data["animals"] = $this->Model->Select($_POST["class_id"]);
        $this->Render($data);
        }
    }

    public function Add() : void
    {
        $params = [
            'species_lat' => $_POST['value']['species_lat'] ?? '',
            'species_rus' => $_POST['value']['species_rus'] ?? '',
            'animal_name' => $_POST['value']['animal_name'] ?? '',
            'class_id' => (int) ($_POST['value']['class_id'] ?? 0),
            'sex' => $_POST['value']['sex'] ?? '',
            'birth_date' => $_POST['value']['birth_date'] ?? '',
            'arrival_date' => $_POST['value']['arrival_date'] ?? '',
            'color' => $_POST['value']['color'] ?? null,
            'conservation_status_id' => (int) ($_POST['value']['conservation_status_id'] ?? 0),
            'animal_description' => $_POST['value']['animal_description'] ?? null,
            'department_id' => (int) ($_POST['value']['department_id'] ?? 0),
        ];
        if($this->Model->Add($params))
        {
            Logger::AddLog("add new animal");
        }
        Header('Location: http://localhost:84/animals/all');
    }

    public function Update() : void
    {
        $values = [
            'animal_id' => $_POST['value']['animal_id'] ?? null,
            'species_lat' => $_POST['value']['species_lat'] ?? '',
            'species_rus' => $_POST['value']['species_rus'] ?? '',
            'animal_name' => $_POST['value']['animal_name'] ?? '',
            'class_id' => (int) ($_POST['value']['class_id'] ?? 0),
            'sex' => $_POST['value']['sex'] ?? '',
            'birth_date' => $_POST['value']['birth_date'] ?? '',
            'arrival_date' => $_POST['value']['arrival_date'] ?? '',
            'color' => $_POST['value']['color'] ?? null,
            'conservation_status_id' => (int) ($_POST['value']['conservation_status_id'] ?? 0),
            'animal_description' => $_POST['value']['animal_description'] ?? null,
            'department_id' => (int) ($_POST['value']['department_id'] ?? 0),
        ];
        if($this->Model->UpdateAnimal($values))
        {
            Logger::AddLog("change animal");
        }
        Header('Location: http://localhost:84/animals/all');
    }

    public function Delete() : void
    {
        if($this->Model->DeleteAnimal($_POST["animal_id"]))
        {
            Logger::AddLog("delete animal");
        }
        Header('Location: http://localhost:84/animals/all');
    }
}