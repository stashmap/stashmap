<?php

namespace Components;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


class EntityManagerGetter {

    public static $em = null;
    
    public static function getEntityManager() {
        if (self::$em) return self::$em;
        
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/models"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

        // database configuration parameters
        $dbParams = \Components\Config::get('db_params');

        $em = EntityManager::create($dbParams, $config);
        static::$em = $em;
        return $em;
    }
    
}
