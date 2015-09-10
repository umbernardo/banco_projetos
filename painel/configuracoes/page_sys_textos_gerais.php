<?php

$sys_opc_editar = 1;
$sys_opc_ativar = 0;
$sys_opc_apagar = 0;
$sys_opc_ordem = 0;
$sys_opc_exibe_menu = 0;
$sys_opc_id_unico = "";
$sys_join = array('id_cat' => 'tbl_categoria|id_cat:id', 'id_marca' => 'tbl_marca|id_marca:id');
$thumb_size = array(array(88, 88));
$sys_this_page = "sys_textos_gerais";
$sys_local = "page_" . $sys_this_page . ".php";
$sys_tabela = "tbl_" . $sys_this_page;
$sys_titulo = "Textos Gerais";
require_once('../includes/inc_checa_sessao.php');
require_once("../includes/inc_database.php");
require_once('../includes/inc_funcoeslib.php');
include('page_sys_padrao.php');
