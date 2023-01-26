<?php

namespace GoldHoarders\ORM;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

readonly class EM {
    public static function getEntityManager(): EntityManager
    {
        $metaDataConfig = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__."/../models/"],
            isDevMode: true,
        );

        $config = require_once(__DIR__ . '/../../config/config.php');

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

        $connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $entityManager = new EntityManager($connection, $metaDataConfig);
        
        return $entityManager;
    }
}