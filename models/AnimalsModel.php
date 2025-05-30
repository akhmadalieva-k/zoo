<?php

namespace models;

use Exception;

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

    public function GetData() : array
    {
        $sql = "SELECT 
                    animal_id, species_lat, species_rus, 
                    animal_name, animal_class, sex, 
                    TIMESTAMPDIFF(YEAR, birth_date, 
                    CURDATE()) AS age, arrival_date, 
                    color, state, animal_description, class_id, birth_date, conservation_status_id  
                FROM animals
                INNER JOIN class
                    ON animals.class_id = class.id
                INNER JOIN conservation_status
                    ON animals.conservation_status_id = conservation_status.id 
                ORDER BY animal_id";
        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData, MYSQLI_ASSOC);
    }

    public function Select(int $condition)
    {
        $sql = "SELECT animal_id, species_lat, species_rus, 
                    animal_name, animal_class, sex, TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, 
                    arrival_date, color, state, animal_description,  class_id, birth_date, conservation_status_id 
                FROM animals
                INNER JOIN class
                    ON animals.class_id = class.id
                INNER JOIN conservation_status
                    ON animals.conservation_status_id = conservation_status.id
                WHERE class_id = $condition 
                ORDER BY animal_id";
        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData, MYSQLI_ASSOC);
    }

    public function Add(array $params)
    {
        $sql = "INSERT INTO animals 
        (species_lat, species_rus, animal_name, class_id, sex, birth_date, arrival_date, color, conservation_status_id, animal_description) 
        VALUES ('";
        $columns = implode("', '", $params) . "')";

        $sql .= $columns;

        $queryData = self::$conn->query($sql);

        // return mysqli_fetch_all($queryData);
    }

    // public function GetById(int $id)
    // {
    //     $sql = "SELECT animal_id, species_lat, species_rus, animal_name, animal_class, sex, TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, arrival_date, color, state, animal_description FROM animals
    //         INNER JOIN class
    //         ON animals.class_id = class.id
    //         INNER JOIN conservation_status
    //         ON animals.conservation_status_id = conservation_status.id
    //         WHERE animal_id = $id 
    //         ORDER BY animal_id";
    //     $queryData = self::$conn->query($sql);
    //     return mysqli_fetch_assoc($queryData);
    // }

    public function DeleteAnimal(int $id)
    {
        $sql = "DELETE FROM animals WHERE animal_id = $id";
        $queryData = self::$conn->query($sql);
    }

    public function UpdateAnimal(array $values)
    {
        $sql = "UPDATE animals 
        SET species_lat = '$values[species_lat]', 
            species_rus = '$values[species_rus]', 
            animal_name = '$values[animal_name]', 
            class_id = $values[class_id], 
            sex = '$values[sex]', 
            birth_date = '$values[birth_date]', 
            arrival_date = '$values[arrival_date]', 
            color = '$values[color]', 
            conservation_status_id = $values[conservation_status_id], 
            animal_description = '$values[animal_description]'  
        WHERE animal_id = $values[animal_id]";
        // print_r($sql);
        // exit;
        $queryData = self::$conn->query($sql);
    }
}