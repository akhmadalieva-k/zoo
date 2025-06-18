<?php

namespace controllers;

use controllers\log\Logger;
use models\EmployeesModel;
use views\ViewBase;
use Exception;
use Error;

class EmployeesController extends ControllerBase
{
    private EmployeesModel $Model;

    public function __construct()
    {
        parent::__construct();

        $this->Model = new EmployeesModel();
    }

    public function List(): void
    {
        try {
            if (!isset($_GET["spec"])) {
                $data["employees"] = $this->Model->GetAll();
                $data["departments"] = $this->Model->GetDepartments();
                $this->Render($data);
            } else {
                if ($_GET["spec"] == 0) {
                    Header('Location: http://localhost:84/employees/list');
                } else {
                    $data["employees"] = $this->Model->SelectSpec($_GET["spec"]);
                    $this->Render($data);
                }
            }
        } catch (Exception $ex) {
            Logger::AddErrorLog("employeeError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("employeeError", $e->getMessage());
        }
    }

    public function Add(): void
    {
        try {
            $params = [
                $_POST['value']['employee_name'] ?? '',
                $_POST['value']['specialization_id'] ?? '',
                $_POST['value']['department_id'] ?? ''
            ];
            if ($this->Model->Add($params)) {
                Logger::AddLog("create employee");
            };
            Header('Location: http://localhost:84/employees/list');
        } catch (Exception $ex) {
            Logger::AddErrorLog("employeeError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("employeeError", $e->getMessage());
        }
    }

    public function Update(): void
    {
        try {
            $params = [
                $_POST['value']['employee_name'] ?? '',
                $_POST['value']['specialization_id'] ?? '',
                $_POST['value']['department_id'] ?? '',
                $_POST['value']['employee_id'] ?? null
            ];
            $employeeId = $_POST['value']['employee_id'];
            $department = $_POST['value']['department_id'];

            $this->Model->Update($params, $employeeId, $department);

            Logger::AddLog("change employee");
            Header('Location: http://localhost:84/employees/list');
        } catch (Exception $ex) {
            Logger::AddErrorLog("employeeError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("employeeError", $e->getMessage());
        }
    }

    public function Delete(): void
    {
        try {
            if ($this->Model->DeleteEmployee($_POST["employee_id_to_delete"])) {
                Logger::AddLog("delete employee");
            }
            Header('Location: http://localhost:84/employees/list');
        } catch (Exception $ex) {
            Logger::AddErrorLog("employeeError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("employeeError", $e->getMessage());
        }
    }

    public function EmployeePage(int $id): void
    {
        try {
            $data["link"] = $this->Model->GetEmployeeLink($id);
            $data["employee"] = $this->Model->GetEmployeeInfo($id);
            ViewBase::Render("EmployeePageView.php", $data);
        } catch (Exception $ex) {
            Logger::AddErrorLog("employeeError", $ex->getMessage());
        } catch (Error $e) {
            Logger::AddErrorLog("employeeError", $e->getMessage());
        }
    }
}
