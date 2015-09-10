<?php
if (session_id() == '') {
    session_start();
}


/* @var $app CupCore */
$app = require __DIR__ . '/../bootstrap.php';
include_once("includes/inc_funcoeslib.php");

$login = $_POST['login'];
$senha = md5($_POST['senha']);

$ip = $_SERVER['REMOTE_ADDR'];
$data = date('d/m/Y');
$hora = date("H:i");

$lang = 'br';

$msg1 = '&Eacute; necess&aacute;rio digitar um login.';
$msg2 = '&Eacute; necess&aacute;rio digitar uma senha.';
$msg3 = '&Eacute; necess&aacute;rio digitar um login e senha.';
$msg4 = 'Login ou senha inv&aacute;lidos.';
$msg5 = 'Login ou senha inv&aacute;lidos.';
$msg6 = 'Sua sess&atilde;o expirou.';
$msg7 = 'Login efetuado, redirecionando.';
$msg8 = 'Ocorreu um erro, tente novamente.';


if (empty($login)) {
    $_SESSION['login_message'] = $msg1;
} else if (empty($senha)) {
    $_SESSION['login_message'] = $msg2;
} else if (empty($login) && empty($senha)) {
    $_SESSION['login_message'] = $msg3;
} else {
    try {
        $query_login = $app->db->query("select * from tbl_sys_usuarios where login = '$login'");
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $exibe_query_login = $query_login->fetch(PDO::FETCH_ASSOC);
    $total_login = $query_login->rowCount();
    $dados_login = $exibe_query_login['login'];
    $dados_senha = $exibe_query_login['senha'];
    $dados_id = $exibe_query_login['id'];
    $dados_nome = $exibe_query_login['nome'];
    $dados_tipo = @$exibe_query_login['level'];
    $dados_data = $exibe_query_login['datas'];
    $dados_ip = $exibe_query_login['ips'];
    if ($total_login == 0) {
        $_SESSION['login_message'] = $msg4;
    } else if ($senha != $dados_senha) {
        $_SESSION['login_message'] = $msg5;
    } else if ($senha == $dados_senha) {
        $_SESSION['login_message'] = $msg5;
        $_SESSION['admin_usuario_logado'] = '1';
        $_SESSION['admin_usuario'] = $dados_nome;
        $_SESSION['admin_usuario_id'] = $dados_id;

        if (empty($_GET['p'])) {
            $_SESSION['login_message'] = "<script> parent.location = 'index.php'</script>";
        } else {
            $_SESSION['login_message'] = "<script> parent.location = '" . $_GET['p'] . "'</script>";
        }
    } else {
        $_SESSION['login_message'] = $msg8;
    }
}
?>
<script> parent.location = 'index.php'</script>