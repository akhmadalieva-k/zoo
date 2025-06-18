<?php

namespace controllers;

use controllers\log\Logger;
use Error;
use Exception;
use models\AnimalsModel;
use views\ViewBase;


class AnimalsController extends ControllerBase
{
    private AnimalsModel $Model;

    public function __construct()
    {
        parent::__construct();
        $this->Model = new AnimalsModel();
    }

    public function List(): void
    {
        try {
            if (!isset($_GET["class"])) {
                $data["departments"] = $this->Model->GetDepartments();
                $data["animals"] = $this->Model->GetData();
                $this->Render($data);
            } else {
                if ($_GET["class"] == 0) {
                    Header('Location: http://localhost:84/animals/list');
                } else {
                    $data["animals"] = $this->Model->Select($_GET["class"]);
                    $this->Render($data);
                }
            }
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("animalError", $e->getMessage());
        }
    }

    public function Add(): void
    {
        try {
            $params = [
                $_POST['value']['species_lat'] ?? '',
                $_POST['value']['species_rus'] ?? '',
                $_POST['value']['animal_name'] ?? '',
                (int) ($_POST['value']['class_id'] ?? 0),
                $_POST['value']['sex'] ?? '',
                $_POST['value']['birth_date'] ?? '',
                $_POST['value']['arrival_date'] ?? '',
                $_POST['value']['color'] ?? null,
                (int) ($_POST['value']['conservation_status_id'] ?? 0),
                $_POST['value']['animal_description'] ?? null,
                (int) ($_POST['value']['department_id'] ?? 0),
            ];
            if ($this->Model->Add($params)) {
                Logger::AddLog("add new animal");
            }
            Header('Location: http://localhost:84/animals/list');
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("animalError", $e->getMessage());
        }
    }

    public function Update(): void
    {
        try {
            $values = [
                $_POST['value']['species_lat'] ?? '',
                $_POST['value']['species_rus'] ?? '',
                $_POST['value']['animal_name'] ?? '',
                (int) ($_POST['value']['class_id'] ?? 0),
                $_POST['value']['sex'] ?? '',
                $_POST['value']['birth_date'] ?? '',
                $_POST['value']['arrival_date'] ?? '',
                $_POST['value']['color'] ?? null,
                (int) ($_POST['value']['conservation_status_id'] ?? 0),
                $_POST['value']['animal_description'] ?? null,
                (int) ($_POST['value']['department_id'] ?? 0),
                (int) ($_POST['value']['animal_id']) ?? null,
            ];
            if ($this->Model->UpdateAnimal($values)) {
                Logger::AddLog("change animal");
            }
            Header('Location: http://localhost:84/animals/list');
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("animalError", $e->getMessage());
        }
    }

    public function Delete(): void
    {
        try {
            if ($this->Model->DeleteAnimal($_POST["animal_id"])) {
                Logger::AddLog("delete animal");
            }
            Header('Location: http://localhost:84/animals/list');
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("animalError", $e->getMessage());
        }
    }

    public function AnimalPage(int $animalId): void
    {
        try {
            $data["employee_link"] = $this->Model->GetAnimalLink($animalId);
            $data["animal"] = $this->Model->GetAnimalInfo($animalId);
            if (isset($data["animal"]["department_id"])) {
                $data["employee_list"] = $this->Model->GetEmployeeList($data["animal"]["department_id"]);
            }
            ViewBase::Render("AnimalPageView.php", $data);
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("animalError", $e->getMessage());
        }
    }

    public function AddLink(): void
    {
        try {
            $animalId = $_POST["animal_id"];
            if ($_POST["employee_id"] == 0) {
                $this->Model->DeleteLink($animalId);
                Header("Location: http://localhost:84/animals/animalPage/$animalId");
            } else {
                $this->Model->AddLink($_POST["employee_id"], $_POST["animal_id"]);

                Logger::AddLog("add row in employee_animal_link");
                Header("Location: http://localhost:84/animals/animalPage/$animalId");
            }
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("animalError", $e->getMessage());
        }
    }
}
