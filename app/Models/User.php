<?php

namespace App\Models;

use App\Core\BaseModel;
use PDO;

/**
 * Class User
 *
 * Represents a user in the table.
 *
 * @package App\Models
 */
class User extends BaseModel
{
    private $conn;
    private $table;

    public $username;
    public $email;

    public $password;
    private $pass_hash;

    /**
    * Init User class.
    *
    * @param PDO $db
    */
    public function __construct(PDO $db)
    {
        $this->conn = $db;
        $this->table = $this->getTableName();
    }

    /**
     * Checks if user already exist based on $param.
     *
     * @param string $param User class param
     *
     * @return bool True if exist, false otherwise.
     */
    public function exist(string $param): bool
    {
        $param = strtolower($param);
        // Verify if param exist in $this
        if (!property_exists($this, $param)) {
            return;
        }

        $query = sprintf("SELECT COUNT(*) FROM %s WHERE %s = :%s", $this->table, $param, $param);
        $stmt = $this->conn->prepare($query);

        // Linking
        $stmt->bindParam(sprintf(":%s", $param), $this->$param);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    /**
    * Insert a new user into the database.
    */
    public function create(): bool
    {
        $query = sprintf("INSERT INTO %s (username, email, pass_hash) VALUES (:username, :email, :pass_hash)", $this->table);
        $stmt = $this->conn->prepare($query);

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
