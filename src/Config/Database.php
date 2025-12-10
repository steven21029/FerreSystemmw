<?php

namespace Config;

use PDO;
use PDOException;

class Database {

    private static $host = "localhost";
    private static $db   = "ferresystem_db";
    private static $user = "root";
    private static $pass = ""; 
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=utf8mb4",
                    self::$user,
                    self::$pass
                );

                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die(" Error de conexión: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
