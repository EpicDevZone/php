<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    //! This property stores the connection used to talk to MySQL.
    private PDO  $connection;  //?connection is object of the PDO class

    //! This keeps one Database object so the application reuses one connection.
    private static ?Database $instance = null;

    private function __construct()
    {
        //! These are the settings used to connect to the workshop database.
        $dsn = 'mysql:host=localhost;port=3306;dbname=php_workshop;charset=utf8mb4';

        try {
            $this->connection = new PDO($dsn, "root", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (PDOException $e) {
            die("database connection failed" . $e->getMessage());
        }
    }


    //! Create the database instance once and return the same instance every time.
    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getConnection(): PDO
    {
        //! Other classes use this method when they need to run a SQL query.
        return $this->connection;
    }
}
