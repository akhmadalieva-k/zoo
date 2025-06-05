<?php

namespace models;

use Exception;

class PageModel extends ModelBase
{
    public function GetAnimalLink(int $id) : array|bool
    {
        $stmt = self::$conn->prepare("SELECT DISTINCT employee_id, employee_name
                FROM employee
                INNER JOIN employee_animal_link USING (employee_id)
                WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $dataLink = mysqli_fetch_assoc($result);
        if($dataLink != 0)
        {
            return $dataLink;
        }
        else {
            return false;
        };
    }

    public function GetAnimalInfo(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT 
                    animals.animal_id, species_lat, species_rus, 
                    animal_name, animal_class, sex, 
                    TIMESTAMPDIFF(YEAR, birth_date, 
                    CURDATE()) AS age, arrival_date, 
                    color, state, animal_description, class_id, birth_date, conservation_status_id, 
                    animals.department_id, department_name 
                FROM animals
                INNER JOIN class
                    ON animals.class_id = class.id
                INNER JOIN conservation_status
                    ON animals.conservation_status_id = conservation_status.id 
                LEFT JOIN department ON department.department_id = animals.department_id
                WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_fetch_assoc($result);
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

    public function GetEmployeeList(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT employee_id, employee_name
                FROM employee
                WHERE department_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function AddLink(int $employeeId, int $animalId): bool
    {
        $stmt = self::$conn->prepare("INSERT INTO employee_animal_link (employee_id, animal_id)
                VALUES (?, ?)");
        $stmt->bind_param("ii", $employeeId, $animalId);
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("failed to add row in table employee_animal_link");
            return false;
        }
    }

    public function DeleteLink(int $animalId): bool
    {
        $stmt = self::$conn->prepare("DELETE FROM employee_animal_link
                WHERE animal_id = ?");
        $stmt->bind_param("i", $animalId);
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("failed to delete row in table employee_animal_link");
            return false;
        }
    }
}
