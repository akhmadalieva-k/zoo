<?php

namespace models;

class EmployeeModel extends ModelBase
{
    public function GetById(int $id)
    {
        $sql = "SELECT DISTINCT employee.employee_id, employee.employee_name, specialization_name, department_name
        FROM employee
        INNER JOIN specialization USING(specialization_id)
        LEFT JOIN departments_state USING(employee_id)
        LEFT JOIN department ON department.department_id = departments_state.department_id
        WHERE employee.employee_id = $id";

        $queryData = self::$conn->query($sql);

        return mysqli_fetch_assoc($queryData);
    }

    public function Update(array $params)
    {
        $sql = "UPDATE employee
            SET employee_name = '$params[employee_name]',
                specialization_id = $params[specialization_id]
                WHERE employee_id = $params[employee_id]";
        self::$conn->query($sql);
    }

    public function Delete(int $id)
    {
        $sql = "DELETE FROM employee
            WHERE employee_id = $id";
        self::$conn->query($sql);
    }
}