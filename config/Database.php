<?php

namespace Config;

use PDO;

class Database
{
    //TODO: Replace hard value by .env file (can't use phpdotenv module)
    private $host;
    private $dbName;
    private $user;
    private $pass;

    public $conn;

    public function __construct()
    {
        $this->host = getenv('DB_HOST', true) ?: "localhost";
        $this->dbName = "db";
        $this->user = "upyne";
        $this->pass = "123456";
    }

    public function connect()
    {
        $this->conn = null;
        try {
            // Connect to database
            $dsn = sprintf("mysql:host=%s;dbname=%s", $this->host, $this->dbName);
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->exec("set names utf8mb4");
        } catch (PDOException $exception) {
            die("Erreur de connexion : " . $exception->getMessage());
        }
        return $this->conn;
    }
}
