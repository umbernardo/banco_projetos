<?php

/* Desenvolvido por Ricardo Fiorani e Ricardo Bernardo */
//Inicialização do Framework em si
require dirname(__FILE__) . '/vendor/autoload.php';
$config = require_once(dirname(__FILE__) . '/app/config/config.php');
$_SITE = new SiteController($config);
global $_SITE;
$_SITE->inicializar();
