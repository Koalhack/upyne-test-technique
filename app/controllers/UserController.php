<?php

namespace App\Controllers;

// Register the Composer autoloader...
require __DIR__ . '/../../vendor/autoload.php';

use App\Models\User;
use Config\Database;

class UserController
{
    public function createUser()
    {
        $database = new Database();
        $db = $database->connect();

        $user = new User($db);
        $user->username = "test";
        $user->email = "email@gmail.com";
        $user->password = "azerty12561";

        $user->create();
        print("test");
    }
}

new UserController()->createUser();
