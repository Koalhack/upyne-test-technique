<?php

namespace App\Services;

class Validator
{
    public $errors = [];

    public function emptyFields($fields)
    {
        foreach ($fields as $key => $value) {
            if (empty($value)) {
                $this->errors[$key] = "this field is required.";
            }
        }
    }

    public function emailFormat($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["emailFormat"] = "Invalid email format.";
        }
    }

    public function passwordSize($password)
    {
        define("MAX_BCRYPT_PASSWORD", 72);
        define("MIN_PASSWORD", 6);

        $passwordLength = strlen($password);
        if ($passwordLength > MAX_BCRYPT_PASSWORD || $passwordLength < MIN_PASSWORD) {
            $this->errors["passwordLength"] = "Password size must be between 6 and 72 characters.";
        }
    }

    public function passwordCheck($password, $passwordConfirm)
    {
        if ($password !== $passwordConfirm) {
            $this->errors["passwordCheck"] = "The two passwords must be the same.";
        }
    }
}
