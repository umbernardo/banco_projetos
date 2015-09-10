<?php

if ($_POST['acao'] == 'subir') {
    echo subir($_POST['id'], $_POST['posicao']);
}

if ($_POST['acao'] == 'descer') {
    echo descer($_POST['id'], $_POST['posicao']);
}

function subir($id, $posicao) {
    global $app;
    //reg anterior
    if ($posicao != 0) {
        $sql_anterior = 'update ' . $_POST['tabela'] . ' set `ordem` = "' . $posicao . '" where `ordem` = "' . ($posicao - 1) . '"';
        $app->db->query($sql_anterior);
        //reg atual
        $sql_atual = 'update ' . $_POST['tabela'] . ' set `ordem` = "' . ($posicao - 1) . '" where id = "' . $id . '"';
        $app->db->query($sql_atual);
        //erturn(print_r($_POST).'tabela:'.$_POST['tabela']);
    } else {
        return 'Este item já está em primeira posição.';
    }
}

function descer($id, $posicao) {
    global $app;
    if ($posicao != mysql_result(mysql_query('select max(ordem) from ' . $_POST['tabela'] . ''), 0)) {
        //reg anterior
        $sql_anterior = 'update ' . $_POST['tabela'] . ' set `ordem` = "' . $posicao . '" where `ordem` = "' . ($posicao + 1) . '"';
        $app->db->query($sql_anterior);
        //reg atual
        $sql_atual = 'update ' . $_POST['tabela'] . ' set `ordem` = "' . ($posicao + 1) . '" where id = "' . $id . '"';
        $app->db->query($sql_atual);
        //return(print_r($_POST).'tabela:'.$_POST['tabela']);
    } else {
        return 'Este item já está em ultima posição.';
    }
}