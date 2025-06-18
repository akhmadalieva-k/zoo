<?php

namespace models;

use controllers\log\Logger;
use mysqli_sql_exception;
use Exception;

class EmployeesModel extends ModelBase
{
    public function GetAll(): array
    {
        $sql = "SELECT DISTINCT employee.employee_id, employee.employee_name, 
                    specialization_name, employee.department_id, department_name
            FROM employee
            INNER JOIN specialization USING(specialization_id)
            LEFT JOIN department ON department.department_id = employee.department_id";

        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData, MYSQLI_ASSOC);
    }

    public function GetDepartments(): array
    {
        $sql = "SELECT * FROM department";

        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData,  MYSQLI_ASSOC);
    }

    public function SelectSpec(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT DISTINCT employee.employee_id, employee.employee_name, 
                    specialization_name, department.department_id, department_name
                FROM employee
                INNER JOIN specialization USING(specialization_id)
                LEFT JOIN department ON department.department_id = employee.department_id
                WHERE specialization.specialization_id = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function Add(array $params): bool
    {
        $sql = "INSERT INTO employee (employee_name, specialization_id, department_id)
                VALUES (?, ?, ?)";
        $types = "sii";
        $stmt = self::$conn->prepare($sql);
        if (!$stmt) {
            Logger::AddErrorLog("anotherError", "Ошибка подготовки запроса: " . self::$conn->error);
            return false;
        }

        $stmt->bind_param($types, ...$params);

        $success = $stmt->execute();

        if (!$success) {
            Logger::AddErrorLog("anotherError", "Ошибка выполнения запроса: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function Update(array $params, int $employeeId, int $department): void
    {
        self::$conn->begin_transaction();
        try {
            $result = $this->GetEmployeeDepartment($employeeId);

            if ($result["department_id"] != $department) {
                $this->DeleteLink($employeeId);
            }
            $sql = "UPDATE employee 
                SET employee_name = ?,
                    specialization_id = ?, 
                    department_id = ?
                WHERE employee_id = ?";
            $types = "siii";
            $stmt = self::$conn->prepare($sql);
            if (!$stmt) {
                Logger::AddErrorLog("anotherError", "Ошибка подготовки запроса: " . self::$conn->error);
            }

            $stmt->bind_param($types, ...$params);

            $success = $stmt->execute();

            if (!$success) {
                Logger::AddErrorLog("anotherError", "Ошибка выполнения запроса: " . $stmt->error);
            }

            $stmt->close();
            self::$conn->commit();
        } catch (mysqli_sql_exception $exception) {
            Logger::AddErrorLog("animalError", $exception->getMessage());
            self::$conn->rollback();
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
        }
    }

    private function DeleteLink(int $employeeId): bool
    {
        $stmt = self::$conn->prepare("DELETE FROM employee_animal_link
                                            WHERE employee_id = ?");
        $stmt->bind_param("i", $employeeId);
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("failed to delete row in table employee_animal_link");
            return false;
        }
    }

    private function GetEmployeeDepartment(int $employeeId): array
    {
        $dep = self::$conn->prepare("SELECT department_id
                                        FROM employee
                                        WHERE employee_id = ?");
        $dep->bind_param("i", $employeeId);
        if (!$dep->execute()) {
            throw new mysqli_sql_exception("failed to get employee department");
        }
        return mysqli_fetch_assoc($dep->get_result());
    }

    public function DeleteEmployee(int $id): bool
    {
        self::$conn->begin_transaction();
        try {
            $stmt = self::$conn->prepare("DELETE FROM employee
                                          WHERE employee_id = ?");
            $stmt->bind_param("i", $id);
            $success = $stmt->execute();
            $this->DeleteLink($id);
            self::$conn->commit();
            return $success;
        } catch (mysqli_sql_exception $exception) {
            Logger::AddErrorLog("animalError", $exception->getMessage());
            self::$conn->rollback();
            return false;
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
            return false;
        }
    }

    public function GetEmployeeLink(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT animal_id, species_rus, animal_name
                FROM animals
                INNER JOIN employee_animal_link USING (animal_id)
                WHERE employee_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function GetEmployeeInfo(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT employee.employee_id, employee.employee_name, 
                    specialization_name, department.department_id, department_name
                FROM employee
                INNER JOIN specialization USING(specialization_id)
                INNER JOIN department ON department.department_id = employee.department_id
                WHERE employee.employee_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_fetch_assoc($result);
    }
}
