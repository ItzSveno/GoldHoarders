<?php

declare(strict_types=1);

namespace Model;

use PDO;

class Database
{
    static $connection;

    public static function getConnection(): PDO
    {
        $config = require_once(__DIR__ . '/../../../config/config.php');
        
        if (!isset($connection)) {
            $connection = new PDO("mysql:host=".$config['host'].", dbname=".$config['db']."", $config['user'], $config['password']);
        }

        return $connection;
    }
}
