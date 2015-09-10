<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once('framework/inicializarFramework.php');
$config = require_once(__DIR__ . '/app/config/config.php');
$_SITE = new SiteController($config);
// Any way to access the EntityManager from  your application
$em = $_SITE->getEntityManager($config);
$platform = $em->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
        ));
