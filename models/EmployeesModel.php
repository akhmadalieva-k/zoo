<?php

namespace models;

use controllers\log\Logger;

class EmployeesModel extends ModelBase
{
    public function GetAll() : array
    {
        $sql = "SELECT DISTINCT employee.employee_id, employee.employee_name, 
                    specialization_name, employee.department_id, department_name
            FROM employee
            INNER JOIN specialization USING(specialization_id)
            LEFT JOIN department ON department.department_id = employee.department_id";

        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData, MYSQLI_ASSOC);
    }

    public function GetDepartments() : array
    {
        $sql = "SELECT * FROM department";

        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData,  MYSQLI_ASSOC);
    }

    public function SelectSpec(int $id) : array
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
        $allFields = [
            'employee_name' => 's',
            'specialization_id' => 'i',
            'department_id' => 'i'
        ];
        $fields = [];
        $placeholders = [];
        $param = [];
        $types = "";
        foreach ($allFields as $field => $type) {
            if (isset($params[$field]) && $params[$field] !== '') {
                $fields[] = $field;
                $placeholders[] = "?";
                $param[] = $params[$field];
                $types .= $type;
            }
        }
        // print_r($fields);
        // exit;
        if (empty($fields)) {
            Logger::AddErrorLog("Нет данных для вставки.");
            return false;
        }

        $sql = "INSERT INTO employee (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = self::$conn->prepare($sql);
        if (!$stmt) {
            Logger::AddErrorLog("Ошибка подготовки запроса: " . self::$conn->error);
            return false;
        }

        $stmt->bind_param($types, ...$param);

        $success = $stmt->execute();

        if (!$success) {
            Logger::AddErrorLog("Ошибка выполнения запроса: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function Update(array $params) : bool
    {
        $allFields = [
            'employee_name' => 's',
            'specialization_id' => 'i',
            'department_id' => 'i',
        ];
        $assignments = [];
        $bindValues = [];
        $bindTypes = "";
        foreach ($allFields as $field => $type) {
            if (isset($params[$field]) && $params[$field] !== '') {
                $assignments[] = "$field = ?";
                $bindValues[] = $params[$field];
                $bindTypes .= $type;
            }
        }
        if (!isset($params['employee_id']) || !is_numeric($params['employee_id'])) {
            Logger::AddErrorLog("employee_id отсутствует или некорректен");
            return false;
        }
        $bindValues[] = (int)$params['employee_id'];
        $bindTypes .= "i";
        $sql = "UPDATE employee SET " . implode(', ', $assignments) . " WHERE employee_id = ?";
        $stmt = self::$conn->prepare($sql);
        if (!$stmt) {
            Logger::AddErrorLog("Ошибка подготовки запроса: " . self::$conn->error);
            return false;
        }

        $stmt->bind_param($bindTypes, ...$bindValues);

        $success = $stmt->execute();

        if (!$success) {
            Logger::AddErrorLog("Ошибка выполнения запроса: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function Delete(int $id) : bool
    {
        $stmt = self::$conn->prepare("DELETE FROM employee
            WHERE employee_id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
