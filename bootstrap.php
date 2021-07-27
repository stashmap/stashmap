<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/models"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'Ynv3sOyBVkKw',
    'password' => 'QudNn67688Bbq9q',
    'dbname'   => 'RU6SKG7wXctm',
    'host' => '127.0.0.1'
);

// obtaining the entity manager
$em = EntityManager::create($dbParams, $config);
