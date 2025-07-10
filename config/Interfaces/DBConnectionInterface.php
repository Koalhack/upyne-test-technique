<?php

namespace Config\Interfaces;

use PDO;

interface DBConnectionInterface
{
    /**
     * Establishes and returns a PDO connection.
     *
     * @return PDO The PDO connection instance.
     */
    public function connect(): PDO;
}
