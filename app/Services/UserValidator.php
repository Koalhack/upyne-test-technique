<?php

namespace App\Services;

use App\Services\Validator;

class UserValidator extends Validator
{
    public function userExist($user, $param)
    {
        if ($user->exist($param)) {
            $this->errors[$param] = sprintf("This %s is already in use.", $param);
        }
    }
}
