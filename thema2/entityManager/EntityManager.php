<?php

namespace ORM;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

readonly class EM {
    public static function getEntityManager(): EntityManager
    {
        $metaDataConfig = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__],
            isDevMode: true,
        );

        $config = require_once(__DIR__ . '/../../../config/config.php');

        $connection = DriverManager::getConnection(
            [
                'driver' => 'pdo_mysql',
                'host' => $config['host'],
                'dbname' => $config['db'],
                'user' => $config['user'],
                'password' => $config['password'],
            ],
            $metaDataConfig,
        );

        $entityManager = new EntityManager($connection, $metaDataConfig);
        
        return $entityManager;
    }
}