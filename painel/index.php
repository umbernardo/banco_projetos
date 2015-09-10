<?php
require_once('includes/inc_checa_sessao.php');
require_once('includes/inc_funcoeslib.php');

if (!defined('PAINEL_BASE_URL')) {
    define('PAINEL_BASE_URL', BASE_URL);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Painel</title>
        <link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>css/estilo_principal.css" />
        <?php include "includes/inc_jscripts.php"; ?>
        <script type="text/javascript" src="<?= PAINEL_BASE_URL ?>scripts/datetimepicker.js"></script>
    </head>
    <body>
        <?php include('includes/inc_menu_topo.php'); ?>
        <div id="body">
            <div class="body_tr"></div>	
            <?php include "includes/inc_header.php"; ?>
            <div id="conteudo" class="clearfix">
                <?php include "includes/inc_menu_vert.php"; ?>
                <div class="alert alert-info pull-left">
                    <p>
                        Seja bem vindo <strong><?= utf8_encode($_SESSION['admin_usuario']) ?></strong>
                    </p>
                    <p>
                        &laquo; Utilize os menus laterais para efetuar atualizações no website
                    </p>
                </div>
            </div>
            <br clear="all"/>
    </body>
</html>
