<?php

namespace App\Services;

use App\Services\Validator;
use App\Models\User;

/**
 * Class UserValidator
 *
 * Extends `Validator` class for user specific verification.
 *
 * @package App\Services
 */
class UserValidator extends Validator
{
    /**
    * Verify array of field if one or more is empty.
    *
    * @param User $user Use User model to verify if user exist.
    * @param string $param User param to use.
    */
    public function userExist(User $user, string $param)
    {
        if ($user->exist($param)) {
            $this->errors[$param] = sprintf("This %s is already in use.", $param);
        }
    }
}
