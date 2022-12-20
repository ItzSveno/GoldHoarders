<?php declare(strict_types=1);

namespace Model;

use PDO;
require __DIR__ . '../../config/config.php';
class Database {
    public function __construct() {
        $this->connection = new PDO("mysql:host=$host, dbname=$db", $user, $password);
    }
}