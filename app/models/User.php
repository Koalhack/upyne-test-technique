<?php

namespace App\Models;

use App\Core\BaseModel;

class User extends BaseModel
{
    private $conn;
    private $table;

    public $username;
    public $email;

    public $password;
    private $pass_hash;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->table = $this->getTableName();
    }

    public function exist()
    {
        $query = sprintf("SELECT COUNT(*) FROM %s WHERE username = :username AND email = :email", $this->table);
        $stmt = $this->conn->prepare($query);

        // Linking
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function create()
    {
        $query = sprintf("INSERT INTO %s (username, email, pass_hash) VALUES (:username, :email, :pass_hash)", $this->table);
        $stmt = $this->conn->prepare($query);

        print($query);

        // Cleanup
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Hashing password
        $this->pass_hash = password_hash($this->password, PASSWORD_BCRYPT);

        // Linking
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pass_hash", $this->pass_hash);

        return $stmt->execute();
    }
}
