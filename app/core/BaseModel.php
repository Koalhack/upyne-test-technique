<?php

namespace App\Core;

class BaseModel
{
    public static function getTableName()
    {
        $class = static::class;
        return strtolower((new \ReflectionClass($class))->getShortName()) . 's';
    }
}
