<?php
$app = require __DIR__ . '/../../bootstrap.php';
session_start();

$tipo = $_GET['tipo'];
$id = $_GET['item'];
$exibir = $_GET['ativar'];

switch ($exibir) {
    case '0': $exibir = 'Não';
        break;
    case '1': $exibir = 'Sim';
        break;
}


if (!empty($tipo) && !empty($id) && !empty($exibir)) {
    try {
        $app->db->query("update tbl_" . $tipo . " set ativo = '" . $exibir . "' where id = '" . $id . "'");
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $_SESSION['mysql_id'] = $id;
    $_SESSION['mysql_msg'] = 'Visualização alterada com sucesso.';
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title></title>
            <style type="text/css">
                <!--
                body {margin: 0px;}
                -->
            </style>
        </head>
        <body>
            <script> parent.location = '<?= $_SERVER['HTTP_REFERER'] ?>'</script>
        </body>
    </html>
    <?php
} 
