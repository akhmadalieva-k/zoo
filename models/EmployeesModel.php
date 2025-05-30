<?php

namespace models;

class EmployeesModel extends ModelBase
{
    public function GetAll()
    {
        $sql = "SELECT DISTINCT employee.employee_id, employee.employee_name, specialization_name, department_name
        FROM employee
        INNER JOIN specialization USING(specialization_id)
        LEFT JOIN departments_state USING(employee_id)
        LEFT JOIN department ON department.department_id = departments_state.department_id";

        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData);
    }

    public function SelectSpec(int $id)
    {
        $sql = "SELECT DISTINCT employee.employee_id, employee.employee_name, specialization_name, department_name
        FROM employee
        INNER JOIN specialization USING(specialization_id)
        LEFT JOIN departments_state USING(employee_id)
        LEFT JOIN department ON department.department_id = departments_state.department_id
        WHERE specialization.specialization_id = $id";

        $queryData = self::$conn->query($sql);

        return mysqli_fetch_all($queryData);
    }

    public function Add(array $params)
    {
        $sql = "INSERT INTO employee (employee_name, specialization_id)
            VALUES ('";
        $columns = implode("', '", $params) . "')";
        $sql .= $columns;

        $queryData = self::$conn->query($sql);
    }
    
}
