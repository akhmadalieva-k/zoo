<?php

namespace models;

use models\ModelBase;
use mysqli;

class HomeModel extends ModelBase
{
    public function GetDepartments() : array
    {
        $sql = "SELECT * FROM department";
        
        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData,  MYSQLI_ASSOC);
    }
}