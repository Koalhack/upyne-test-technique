<?php

namespace App\Services;

/**
 * Class Validator
 *
 * Manage inputs and datas errors handling
 *
 * @package App\Services
 */
class Validator
{
    public $errors = [];

    /**
    * Verify array of field if one or more is empty.
    *
    * @param array<string, string> $fields Fields ot verify if emptys.
    */
    public function emptyFields(array $fields)
    {
        foreach ($fields as $key => $value) {
            if (empty($value)) {
                $this->errors[$key] = "This field is required.";
            }
        }
    }

    /**
    * Verify if param if a valid E-mail format.
    *
    * @param string $email E-mail format string
    */
    public function emailFormat(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["emailFormat"] = "Invalid email format.";
        }
    }

    /**
    * Verify the password size
    *
    * @param string $password
    */
    public function passwordSize(string $password)
    {
        define("MAX_BCRYPT_PASSWORD", 72);
        define("MIN_PASSWORD", 6);

        $passwordLength = strlen($password);
        if ($passwordLength > MAX_BCRYPT_PASSWORD || $passwordLength < MIN_PASSWORD) {
            $this->errors["passwordLength"] = sprintf("Password must contain at least %d characters (max %d).", MIN_PASSWORD, MAX_BCRYPT_PASSWORD);
        }
    }

    /**
    * Basic passwords checks
    *
    * @param string $password
    * @param string $passwordConfirm
    */
    public function passwordCheck(string $password, string $passwordConfirm)
    {
        if ($password !== $passwordConfirm) {
            $this->errors["passwordCheck"] = "The two passwords must be the same.";
        }
    }
}
