<?php

/* @var $app CupCake */
$app = require __DIR__ . '/../../bootstrap.php';
if (isset($_GET)) {
    foreach ($_GET['items'] as $key => $value) {
        $app->db->query('update ' . $_GET['tbl'] . ' set ordem = ' . $key . ' where id="' . $value . '";');
    }
    echo 'Salvo com sucesso !!';
    echo '<pre>';
    print_r($_GET);
    echo '</pre>';
}
