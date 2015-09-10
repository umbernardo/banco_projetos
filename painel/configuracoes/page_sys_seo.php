<?php

//Deixar se as tags PHP pois sera adicionado automaticamente
$sys_opc_editar = "1";
$sys_opc_ativar = "1";
$sys_opc_apagar = "1";
$sys_opc_ordem = "1";
$sys_opc_id_unico = "";
$sys_opc_exibe_menu = "1";


$sys_join = '';
//Novo formato agora em array
//$sys_join = array('id_cat'=>'tbl_categoria|id_cat:id','id_marca'=>'tbl_marca|id_marca:id');
$thumb_size = array(array(88, 88));

$sys_this_page = "sys_seo"; //sem "tbl"
$sys_local = "page_" . $sys_this_page . ".php";
$sys_tabela = "tbl_" . $sys_this_page;
$sys_titulo = "SEO";
require_once('../includes/inc_checa_sessao.php');
require_once("../includes/inc_database.php");
require_once('../includes/inc_funcoeslib.php');
include('page_sys_padrao.php');
