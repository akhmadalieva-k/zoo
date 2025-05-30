<?php

namespace models;

use mysqli;
use Exception;
use Error;

abstract class ModelBase
{
    protected static ?mysqli $conn = null;

    public function __construct()
    {
        try {
            if (self::$conn === null) {
                self::$conn = new mysqli("localhost", "root", "kopets", "test");

                if (self::$conn->connect_error) {
                    throw new Exception("Ошибка подключения к базе: " . self::$conn->connect_error);
                } 
            }
        } catch (Exception $ex) {
            echo "Exception " . $ex->getMessage();
            exit;
        } catch (Error $e) {
            echo "Error " . $e->getMessage();
            exit;
        }
    }
}