<?php

session_start();
error_reporting(E_ALL & ~E_NOTICE);
$app = require __DIR__ . '/../../bootstrap.php';
if (empty($_SESSION['admin_usuario_logado'])) {
    //$_SESSION['pagina_acessada'] = $_SERVER['PHP_SELF'];
    $expld = explode("/", $_SERVER['PHP_SELF']);
    header("Location: logon.php?p=" . end($expld));
}