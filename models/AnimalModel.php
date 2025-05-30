<?php

namespace models;

class AnimalModel extends ModelBase
{
    public function GetById(int $id)
    {
        $sql = "SELECT animals.animal_id, species_lat, species_rus, animal_name, animal_class, sex, birth_date, TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, arrival_date, color, state, animal_description, department_name 
            FROM animals
            INNER JOIN class
            ON animals.class_id = class.id
            INNER JOIN conservation_status
            ON animals.conservation_status_id = conservation_status.id
            LEFT JOIN departments_state
            ON departments_state.animal_id = animals.animal_id
            LEFT JOIN department
            ON department.department_id = departments_state.department_id
            WHERE animals.animal_id = $id";
    
        $queryData = self::$conn->query($sql);
        
        return mysqli_fetch_assoc($queryData);
    }

    public function SaveAnimal(array $values)
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

    // public function DeleteAnimal(int $id)
    // {
    //     $sql = "DELETE FROM animals WHERE animal_id = $id";
    //     $queryData = self::$conn->query($sql);
    // }
}