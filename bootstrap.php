<?php

/* Desenvolvido por Ricardo Fiorani e Ricardo Bernardo */
//Inicialização do Framework em si
require dirname(__FILE__) . '/vendor/autoload.php';
$config = require_once(dirname(__FILE__) . '/app/config/config.php');
$app = new SiteController($config);
global $app;
return $app;
