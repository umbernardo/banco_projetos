<?php
require_once("includes/inc_database.php");
require_once('includes/inc_funcoeslib.php');
error_reporting(E_ALL & ~E_NOTICE);
extract($_GET, EXTR_OVERWRITE);
$mensagem = '';
if (isset($_SESSION['login_message'])) {
    $mensagem = $_SESSION['login_message'];
    unset($_SESSION['login_message']);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login - Painel</title>
        <link href="css/login.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<?php include "includes/inc_jscripts.php"; ?>
    </head>
    <body>
        <div class="formularioLoginBorda">
            <div id="formularioLogin" class="degradeFormulario">
                <form id="form_logon" name="form_logon" method="post" action="inc_autentica.php?p=<?= $_GET['p'] ?>">
                    <div class="clearfix">
                        <div id="formularioEsquerda">
                            <div>
                                <h1>Login</h1>
                            </div>
                            <div class="inputs">
                                <div class="blocoInput">
                                    <label>Usuário:</label>
                                    <input type="text" name="login">
                                </div>
                                <div class="blocoInput">
                                    <label>Senha:</label>
                                    <input type="password" name="senha">
                                </div>
                            </div>
                        </div>
                        <div id="formularioDireita">
                            <input type="submit" name="submit" value="Logar">
                        </div>
                    </div>
<?php
if (!empty($mensagem)) {
    ?>
                        }
                        <div class="blocoErro">
    <?= $mensagem; ?>
                        </div>
                            <?php
                        }
                        ?>
                </form>
            </div>
        </div>
    </body>
</html>