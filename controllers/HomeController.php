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

    // public function GetData()
    // {
    //     $data = $this->Model->GetData();
    //     $this->Render($data);
    // }

    // public function GetAnimal(int $id) 
    // {
    //     $data = $this->Model->GetAnimal($id);
    //     $this->Render($data);
    // }
}