<?php

namespace models;

use Exception;
use controllers\log\Logger;

class AnimalsModel extends ModelBase
{

    private array $Allowed = [
        'animal_id',
        'class_id',
        'species_lat',
        'species_rus',
        'animal_name',
        'birth_date',
        'sex',
        'color',
        'state',
        'conservation_status_id',
        'ani    mal_description',
        '   animal_class',
        '   TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age'
    ];

    public function GetDepartments() : array
    {
        $sql = "SELECT * FROM department";
        
        $queryData = self::$conn->query($sql);
        return mysqli_fetch_all($queryData,  MYSQLI_ASSOC);
    }

    public function GetData(): array
    {
        $sql = "SELECT 
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
                ORDER BY animal_id";
        $queryData = self::$conn->query($sql);
        return mysqli_fetch_all($queryData, MYSQLI_ASSOC);
    }

    public function Select(int $condition): array
    {
        $sql = "SELECT animal_id, species_lat, species_rus, 
                     animal_name, animal_class, sex, TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, 
                     arrival_date, color, state, animal_description, class_id, birth_date, conservation_status_id,
                     animals.department_id, department_name 
                 FROM animals
                 INNER JOIN class
                     ON animals.class_id = class.id
                 INNER JOIN conservation_status
                     ON animals.conservation_status_id = conservation_status.id
                 LEFT JOIN department ON department.department_id = animals.department_id
                 WHERE class_id = ? 
                 ORDER BY animal_id";
        $stmt = self::$conn->prepare($sql);
        $stmt->bind_param("i", $condition);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function Add(array $params): bool
    {
        $allFields = [
            'species_lat' => 's',
            'species_rus' => 's',
            'animal_name' => 's',
            'class_id' => 'i',
            'sex' => 's',
            'birth_date' => 's',
            'arrival_date' => 's',
            'color' => 's',
            'conservation_status_id' => 'i',
            'animal_description' => 's',
            'department_id' => 'i'
        ];

        $fields = [];
        $placeholders = [];
        $values = [];
        $types = "";
        foreach ($allFields as $field => $type) {
            if (isset($params[$field]) && $params[$field] !== '') {
                $fields[] = $field;
                $placeholders[] = "?";
                $values[] = $params[$field];
                $types .= $type;
            }
        }

        if (empty($fields)) {
            Logger::AddErrorLog("Нет данных для вставки.");
            throw new Exception("Нет данных для вставки.");
            return false;
        }

        $sql = "INSERT INTO animals (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = self::$conn->prepare($sql);
        if (!$stmt) {
            Logger::AddErrorLog("Ошибка подготовки запроса: " . self::$conn->error);
            throw new Exception("Ошибка подготовки запроса");
            return false;
        }

        $stmt->bind_param($types, ...$values);

        $success = $stmt->execute();

        if (!$success) {
            Logger::AddErrorLog("Ошибка выполнения запроса: " . $stmt->error);
            throw new Exception("Ошибка выполнения запроса");
        }

        $stmt->close();
        return $success;
    }

    public function DeleteAnimal(int $id): bool
    {
        $sql = "DELETE FROM animals WHERE animal_id = ?";
        $stmt = self::$conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->get_result();
        return $success;
    }

    public function UpdateAnimal(array $values) : bool
    {
        $allFields = [
            'species_lat' => 's',
            'species_rus' => 's',
            'animal_name' => 's',
            'class_id' => 'i',
            'sex' => 's',
            'birth_date' => 's',
            'arrival_date' => 's',
            'color' => 's',
            'conservation_status_id' => 'i',
            'animal_description' => 's',
            'department_id' => 'i',
        ];

        $assignments = [];
        $bindValues = [];
        $bindTypes = "";

        foreach ($allFields as $field => $type) {
            if (isset($values[$field]) && $values[$field] !== '') {
                $assignments[] = "$field = ?";
                $bindValues[] = $values[$field];
                $bindTypes .= $type;
            }
        }
        if (!isset($values['animal_id']) || !is_numeric($values['animal_id'])) {
            Logger::AddErrorLog("animal_id отсутствует или некорректен");
            return false;
        }

        $bindValues[] = (int)$values['animal_id'];
        $bindTypes .= "i";
        $sql = "UPDATE animals SET " . implode(', ', $assignments) . " WHERE animal_id = ?";

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
}
