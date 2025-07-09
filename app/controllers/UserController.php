<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\UserValidator;
use Config\Database;

class UserController
{
    private $validate;
    private $errors;

    public function createUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            // ─── Fields validation ───────────────────────────────────────────────────────────────
            $fields = array(
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'passwordConfirm' => trim($_POST['passwordConfirm'])
            );

            $this->validate = new UserValidator();

            $this->validate->emptyFields($fields);
            $this->validate->emailFormat($fields["email"]);
            $this->validate->passwordCheck($fields["password"], $fields["passwordConfirm"]);
            $this->validate->passwordSize($fields["password"]);

            $this->errors = $this->validate->errors;

            // ─── User DB insertion ───────────────────────────────────────────────────────────────
            if (empty($this->errors)) {
                // Init DB
                $database = new Database();
                $db = $database->connect();

                // Init User
                $user = new User($db);
                $user->username = $fields["username"];
                $user->email = $fields["email"];
                $user->password = $fields["password"];

                // Verify if user already exist
                $this->validate->userExist($user, "username");
                $this->validate->userExist($user, "email");
                $this->errors = $this->validate->errors;

                if (!empty($this->errors)) {
                    include 'view/user_form.php';
                    return;
                }

                // Create a user
                $user->create();

                //TODO: Find a better success message system
                $success = "Form submitted successfully!";
                include 'view/user_form.php';
                return;
            }
        }

        include 'view/user_form.php';
    }
}
