<?php
require_once('../includes/inc_checa_sessao.php');
require_once("../includes/inc_database.php");
require_once('../includes/inc_funcoeslib.php');


if (!defined('PAINEL_BASE_URL')) {
    define('PAINEL_BASE_URL', str_replace(basename(__FILE__), '', str_replace('configuracoes/', '', BASE_URL)));
}

extract($_GET, EXTR_OVERWRITE);
extract($_POST, EXTR_OVERWRITE);


if ($_POST) {

    /* CRIAÇÃO DO ARQUIVO */
    $ourFileName = '../paginas/page_' . $_POST['nome'] . '.php';
    $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
    fwrite($ourFileHandle, '<?php ');
    foreach ((array) $_POST['opc'] as $key => $value) {
        fwrite($ourFileHandle, '$sys_opc_' . $key . ' = ' . $value . ';');
    }

    fwrite($ourFileHandle, '$sys_opc_id_unico = "' . $_POST['opc_id_unico'] . '";');

    if (!empty($_POST['joins'])) {
        fwrite($ourFileHandle, '$sys_join = ' . $_POST['joins'] . ';');
    } else {
        fwrite($ourFileHandle, '$sys_join' . " = array('id_cat'=>'tbl_categoria|id_cat:id','id_marca'=>'tbl_marca|id_marca:id');");
    }
    fwrite($ourFileHandle, '$thumb_size = ' . $_POST['thumb_size'] . ' ;');


    fwrite($ourFileHandle, $_POST['php_adicional']);

    fwrite($ourFileHandle, '$sys_this_page = "' . $_POST['nome'] . '";');
    fwrite($ourFileHandle, '$sys_local = "page_" . $sys_this_page . ".php";');
    fwrite($ourFileHandle, '$sys_tabela = "tbl_" . $sys_this_page;');
    fwrite($ourFileHandle, '$sys_titulo = "' . $_POST['titulo'] . '";');
    fwrite($ourFileHandle, "include('../configuracoes/page_sys_padrao.php');");



    fclose($ourFileHandle);
    /* ---------------------------------- */

    $nome_menu = ucfirst($_POST['titulo']);
    //Criação do menu

    $app->db->query("INSERT INTO `tbl_sys_menu` (
                    `id` ,
                    `nome` ,
                    `pagina` ,
                    `class` ,
                    `parent` ,
                    `ordem` ,
                    `ativo`
                    )
                    VALUES (
                    NULL , '" . utf8_decode($nome_menu) . "', 'page_" . $_POST['nome'] . '.php' . "', 'li_padrao', '1', '0', 'Sim'
                    );");


    $sql = "
      CREATE TABLE IF NOT EXISTS `tbl_" . $_POST['nome'] . "` (
      `id` int(11) NOT NULL AUTO_INCREMENT,";

    foreach ((array) $_POST['camposAdicionais'] as $key => $value) {
        $sql .= $value;
    }

    $sql .= "   
      `ordem` int(11) NOT NULL COMMENT 'invisible',
      `ativo` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Visível no site ?',
      PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    try {
        $query = $app->db->query(utf8_decode(stripslashes($sql)));
        if (false === $query) {
            header('Content-Type: text/html; charset=utf-8');
            die('A Query de criação do BD falhou : SQL : ' . $sql);
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

if ($a == "i" && $p == "s") {
    $_SESSION['mysql_id'] = inserir_banco($_POST, $sys_tabela);

    if (!empty($_SESSION['mysql_id'])) {
        $_SESSION['mysql_msg'] = "Item inserido com sucesso.";
        header("location:" . $sys_local);
        exit;
    } else {
        die("erro ao inserir");
    }
} else if ($a == "e" && $p == "s") {

    $_SESSION['mysql_id'] = alterar_banco($_POST, $sys_tabela);
    if (!empty($_SESSION['mysql_id'])) {
        $_SESSION['mysql_msg'] = "Item alterado com sucesso.";
        header("location:" . $sys_local);
        exit;
    } else {
        die("erro ao alterar");
    }
} else if ($a == "x" && !empty($item)) {
    try {
        $app->db->query("delete from " . $sys_tabela . " where id='" . decode($item) . "'");
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $_SESSION['mysql_msg'] == "Item excluído com sucesso";
    header("location:" . $sys_local);
    exit;
} else if ($a == "v" && $p == "s") {
    header("location:" . $sys_local);
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Painel - Administrativo Master</title>
        <link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>css/estilo_principal.css" />
        <?php include "../includes/inc_jscripts.php"; ?>
        <script type="text/javascript" src="<?= PAINEL_BASE_URL ?>scripts/datetimepicker.js"></script>
    </head>
    <body>
        <?php include('../includes/inc_menu_topo.php'); ?>

        <div id="body">
            <div class="body_tr"></div>	
            <?php include "../includes/inc_header.php"; ?>
            <div id="conteudo">
                <?php include "../includes/inc_menu_vert.php"; ?>
                <div class="conteudo_right">

                    <div class="content_title">Administrativo Master</div>
                    <div class="content">

                        <form method="post" enctype="multipart/form-data">
                            <div>
                                <label for="nome">Nome (em minúsculo por favor)</label>
                                <input type="text" name="nome" value="nome"/>
                            </div>
                            <div>
                                <label for="titulo">Título</label>
                                <input type="text" name="titulo" value="Nome que aparecerá na página" />
                            </div>
                            <label for="php">Opções</label>
                            <div>
                                <div class="geradorOpcoes">
                                    sys_opc_editar <input type="checkbox" checked value="1" name="opc[editar]"/>
                                </div>
                                <div class="geradorOpcoes">
                                    sys_opc_ativar <input type="checkbox" checked value="1" name="opc[ativar]"/>
                                </div>
                                <div class="geradorOpcoes">
                                    sys_opc_apagar <input type="checkbox" checked value="1" name="opc[apagar]"/>
                                </div>
                                <div class="geradorOpcoes">
                                    sys_opc_ordem <input type="checkbox" checked value="1" name="opc[ordem]"/>
                                </div>
                                <div class="geradorOpcoes">
                                    sys_opc_exibe_menu <input type="checkbox" checked value="1" name="opc[exibe_menu]"/>
                                </div>
                                <div class="geradorOpcoes">
                                    sys_opc_id_unico <input id="inptGeraMenuIdUnico" type="text" value="" name="opc_id_unico"/>
                                </div>
                            </div>
                            <div>
                                <label for="joins">Joins (Deixar em branco caso não tenha um)</label>
                                <input type="text" name="joins" value="array('id_cat'=>'tbl_categoria|id_cat:id','id_marca'=>'tbl_marca|id_marca:id')" />
                            </div>
                            <div>
                                <label for="thumb_size">Tamanho(s) imagem</label>
                                <input type="text" name="thumb_size" value="array(array(88,88))" />
                            </div>
                            <div>
                                <label for="sql">
                                    Multi-idiomas ? <input id="multiidiomas" type="checkbox"/> 
                                </label>

                            </div>
                            <label for="sql">Campos</label>
                            <div id="camposExtras">
                                <input class="inputAddCTX" type="text" name="camposAdicionais[]" value="`nome` varchar(255) NOT NULL COMMENT 'Nome' ,"/>
                            </div>

                            <input class="campo_sql" type="button" rel="varchar(255)" value="Texto" />
                            <input class="campo_sql" type="button" rel="longtext" value="Texto Longo (CK)" />
                            <input class="campo_sql" type="button" rel="tinytext" value="Foto"/>
                            <input class="campo_sql" type="button" rel="text" value="Galeria"/>
                            <input class="campo_sql" type="button" rel="mediumint(9)" value="Campo Join"/>
                            <input class="campo_sql" type="button" rel="enum('opcao1','opcao2')" value="Opções"/>
                            <div>
                                <label for="php_adicional">PHP Adicional</label>
                                <textarea name="php_adicional" rows="17"></textarea>
                            </div>
                            <div style="padding-top:15px" class="content">
                                <div class="save">
                                    <input type="submit" src="<?= PAINEL_BASE_URL ?>images/icon_save.png" value="Salvar">
                                </div>
                            </div>
                        </form>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('.campo_sql').click(function () {
                                var nome_campo = prompt("Nome campo", "");
                                var comentario_campo = prompt("Comentário campo", "");
                                var tipo = $(this).attr('rel');
                                if (tipo == 'tinytext') {
                                    nome_campo = 'imagem';
                                }
                                if ($('#multiidiomas').is(':checked') && $(this).val() !== 'Galeria' && $(this).val() !== 'Foto') {
                                    $var = '`' + nome_campo + '_pt' + '` ' + tipo + ' NOT NULL COMMENT ' + "'" + comentario_campo + " (Português)" + "' ,";
                                    $('#camposExtras').append("<input class=\"inputAddCTX\" type=\"text\" name=\"" + "camposAdicionais[]" + "\" value=\"" + $var + "\" />");
                                    $var = '`' + nome_campo + '_en' + '` ' + tipo + ' NOT NULL COMMENT ' + "'" + comentario_campo + " (Inglês)" + "' ,";
                                    $('#camposExtras').append("<input class=\"inputAddCTX\" type=\"text\" name=\"" + "camposAdicionais[]" + "\" value=\"" + $var + "\" />");
                                    $var = '`' + nome_campo + '_es' + '` ' + tipo + ' NOT NULL COMMENT ' + "'" + comentario_campo + " (Espanhol)" + "' ,";
                                    $('#camposExtras').append("<input class=\"inputAddCTX\" type=\"text\" name=\"" + "camposAdicionais[]" + "\" value=\"" + $var + "\" />");
                                } else {
                                    $var = '`' + nome_campo + '` ' + tipo + ' NOT NULL COMMENT ' + "'" + comentario_campo + "' ,";
                                    $('#camposExtras').append("<input class=\"inputAddCTX\" type=\"text\" name=\"" + "camposAdicionais[]" + "\" value=\"" + $var + "\" />");
                                }
                                bindInputAddCTX();
                            });

                            bindInputAddCTX();

                            function bindInputAddCTX() {
                                $('.inputAddCTX').blur(function () {
                                    if ($(this).val() === '') {
                                        $(this).remove();
                                    }
                                });
                            }


                        });

                    </script>
                    <br clear="all" />

                </div>
            </div>
            <br clear="all"/>

    </body>

</html>
