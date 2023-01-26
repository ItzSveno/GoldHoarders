<?php

declare(strict_types=1);

namespace Model;

use PDO;

require __DIR__ . '/../../config/config.php';
class Database
{
    static $connection;

    public static function getConnection(): PDO
    {
        if (!isset($connection)) {
            $connection = new PDO("mysql:host=$host, dbname=$db", $user, $password);
        }

        return $connection;
    }
}
