<?php

namespace models;

class DepartmentsModel extends ModelBase
{
    public function GetAllDepartments()
    {
        $sql = "SELECT department_name FROM department";
        
        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData,  MYSQLI_ASSOC);
    }
}