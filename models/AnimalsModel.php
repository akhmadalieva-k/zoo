<?php

namespace models;

use Exception;
use controllers\log\Logger;
use mysqli_sql_exception;

class AnimalsModel extends ModelBase
{
    public function GetDepartments(): array
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
                    TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, 
                    arrival_date, color, state, animal_description, 
                    class_id, birth_date, conservation_status_id, 
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
                     animal_name, animal_class, sex, 
                     TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, 
                     arrival_date, color, state, animal_description, 
                     class_id, birth_date, conservation_status_id,
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
        $sql = "INSERT INTO animals 
                    (species_lat, species_rus, 
                    animal_name, class_id, 
                    sex, birth_date, 
                    arrival_date, color, 
                    conservation_status_id, animal_description, department_id) 
                VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $types = "sssissssisi";
        $stmt = self::$conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Ошибка подготовки запроса");
            return false;
        }

        $stmt->bind_param($types, ...$params);

        $success = $stmt->execute();

        if (!$success) {
            throw new Exception("Ошибка выполнения запроса");
        }

        $stmt->close();
        return $success;
    }

    public function DeleteAnimal(int $id): bool
    {
        self::$conn->begin_transaction();
        try {
            $stmt = self::$conn->prepare("DELETE FROM animals 
                                          WHERE animal_id = ?");
            $stmt->bind_param("i", $id);
            $success = $stmt->execute();
            $this->DeleteLink($id);
            self::$conn->commit();
            return $success;
        } catch (mysqli_sql_exception $exception) {
            Logger::AddErrorLog("animalError", $exception->getMessage());
            self::$conn->rollback();
            return false;
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
            return false;
        }
    }

    public function UpdateAnimal(array $values): bool
    {
        $sql = "UPDATE animals SET
                    species_lat = ?, 
                    species_rus = ?, 
                    animal_name = ?,
                    class_id = ?, 
                    sex = ?, 
                    birth_date = ?, 
                    arrival_date = ?, 
                    color = ?, 
                    conservation_status_id = ?, 
                    animal_description = ?, 
                    department_id = ? 
                WHERE animal_id = ?";

        $types = "sssissssisii";
        $stmt = self::$conn->prepare($sql);
        if (!$stmt) {
            Logger::AddErrorLog("anotherError", "Ошибка подготовки запроса: " . self::$conn->error);
            return false;
        }

        $stmt->bind_param($types, ...$values);

        $success = $stmt->execute();

        if (!$success) {
            Logger::AddErrorLog("anotherError", "Ошибка выполнения запроса: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function GetAnimalLink(int $id): array|bool
    {
        $stmt = self::$conn->prepare("SELECT DISTINCT employee_id, employee_name
                                      FROM employee
                                      INNER JOIN employee_animal_link USING (employee_id)
                                      WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $dataLink = mysqli_fetch_assoc($result);
        if ($dataLink != 0) {
            return $dataLink;
        } else {
            return false;
        };
    }

    public function GetAnimalInfo(int $id): array
    {
        $stmt = self::$conn->prepare("SELECT 
                    animals.animal_id, species_lat, species_rus, 
                    animal_name, animal_class, sex, 
                    TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, 
                    arrival_date, color, state, animal_description, 
                    class_id, birth_date, conservation_status_id, 
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

    public function AddLink(int $employeeId, int $animalId): void
    {
        self::$conn->begin_transaction();

        try {
            $this->DeleteLink($animalId);

            $resultAnimal = $this->GetAnimalDepartmentById($animalId);

            $resultEmployee = $this->GetEmployeeDepartmentById($employeeId);

            if ($resultAnimal != $resultEmployee) {
                throw new mysqli_sql_exception("failed to add link");
            }
            $stmt = self::$conn->prepare("INSERT INTO employee_animal_link (employee_id, animal_id)
                                           VALUES (?, ?)");

            $stmt->bind_param("ii", $employeeId, $animalId);
            if ($stmt->execute()) {
            } else {
                throw new Exception("failed to add row in table employee_animal_link");
            }
            self::$conn->commit();
        } catch (mysqli_sql_exception $exception) {
            Logger::AddErrorLog("animalError", $exception->getMessage());
            self::$conn->rollback();
        } catch (Exception $ex) {
            Logger::AddErrorLog("animalError", $ex->getMessage());
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

    private function GetAnimalDepartmentById(int $animalId): array
    {
        $animalDepartment = self::$conn->prepare("SELECT department_id
                                                FROM animals
                                                WHERE animal_id = ?");
        $animalDepartment->bind_param("i", $animalId);
        if (!$animalDepartment->execute()) {
            throw new mysqli_sql_exception("failed to get animal department");
        }
        return mysqli_fetch_assoc($animalDepartment->get_result());
    }

    private function GetEmployeeDepartmentById(int $employeeId): array
    {
        $employeeDepartment = self::$conn->prepare("SELECT department_id
                                                FROM employee
                                                WHERE employee_id = ?");
        $employeeDepartment->bind_param("i", $employeeId);
        if (!$employeeDepartment->execute()) {
            throw new mysqli_sql_exception("failed to get employee department");
        }
        return mysqli_fetch_assoc($employeeDepartment->get_result());
    }
}
