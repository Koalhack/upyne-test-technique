<?php

namespace App\Core;

/**
 * Class BaseModel
 *
 * Base Model for table management.
 *
 * @package App\Core
 */
class BaseModel
{
    /**
     * Get the name of table based on class name.
     *
     * @return string The "active" class name in lowercase and in plural.
     */
    public static function getTableName(): string
    {
        $class = static::class;
        return strtolower((new \ReflectionClass($class))->getShortName()) . 's';
    }
}
