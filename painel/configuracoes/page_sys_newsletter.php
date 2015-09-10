<?php

require_once('../includes/inc_checa_sessao.php');
require_once("../includes/inc_database.php");
require_once('../includes/inc_funcoeslib.php');
require_once '../includes/plugins/php-excel.class.php';

$data = array('ID', 'Nome', 'Email');

$newsletter = $app->getServiceManager()->getService('DataHelper')->retornoRegistroPadrao('tbl_sys_newsletter', '', 1, 0, ' ', 'id');

if (empty($newsletter['registros'])) {
    die('Nenhum email cadastrado');
}

array_unshift($newsletter['registros'], $data);

$xls = new Excel_XML('UTF-8', false, 'Newsletter');
$xls->addArray($newsletter['registros']);
$xls->generateXML('newsletter');

