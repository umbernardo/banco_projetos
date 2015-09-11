<?php

/*
 * 
 * Definições de URL e Diretório (Sempre terminado e iniciado em Barra / )
 * 
 */
$baseUrl = '/banco_projetos/';
$urlSite = 'http://localhost' . $baseUrl;
define('BASE_URL', $baseUrl);
define('URL_SITE', $urlSite);
define('PAINEL_BASE_URL', $baseUrl . '/painel/');


/*
 * Ajuste de hora 
 */
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('Brazil/East');
}

return array(
    'site' => array(
        'titulo' => 'Banco de Projetos',
        'baseUrl' => $baseUrl,
        'url_site' => $urlSite,
    ),
    'database' => array(
        'host' => 'localhost',
        'user' => 'umbernar_usr_prj',
        'password' => '4uO,Kq[SccV.',
        'dbname' => 'umbernar_db_projetos',
//        'host' => 'localhost',
//        'user' => 'root',
//        'password' => '',
//        'dbname' => 'banco_projetos',
    ),
    'debug' => false,
);
