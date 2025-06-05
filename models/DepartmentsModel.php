<?php

namespace models;

use controllers\log\Logger;

class DepartmentsModel extends ModelBase
{
    public function GetEmployees(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT employee_id, employee_name
                FROM employee
                WHERE department_id = ?
                ORDER BY employee_name");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function GetAnimals(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT animal_id, species_lat, animal_name
                FROM animals
                WHERE department_id = ?
                ORDER BY animal_name");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function Add(string $name): bool
    {
        $stmt = self::$conn->prepare("INSERT INTO department (department_name)
                VALUES (?)");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
