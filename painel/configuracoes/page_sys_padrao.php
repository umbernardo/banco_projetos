<?php
/* @var $app \Cupcake\Core\CupCake */

ob_start();

require_once('../includes/inc_checa_sessao.php');
require_once("../includes/inc_database.php");
require_once('../includes/inc_funcoeslib.php');

if (!defined('PAINEL_BASE_URL')) {
    define('PAINEL_BASE_URL', str_replace('paginas/', '', str_replace(basename($_SERVER['SCRIPT_FILENAME']), '',
        str_replace(dirname($_SERVER['SCRIPT_FILENAME']), '', BASE_URL))));
}

extract($_GET, EXTR_OVERWRITE);
extract($_POST, EXTR_OVERWRITE);


//=================================================
global $sys_opc_editar;
global $sys_opc_exibe_menu;
global $sys_opc_ativar;
global $sys_opc_apagar;
global $sys_opc_ordem;
global $sys_opc_id_unico;
global $sys_join;
global $thumb_size;
global $sys_opc_corta_topo;
global $sys_include_adicional;
global $nomeCampoExibir;
/* ------------------------------------ */


if ($a == "i" && $p == "s") {
    $_SESSION['mysql_id'] = inserir_banco($_POST, $sys_tabela);

    if (!empty($_SESSION['mysql_id'])) {
        $_SESSION['mysql_msg'] = "Item inserido com sucesso.";
        header("location:" . $sys_local);
        exit;
    } else {
        $_SESSION['mysql_msg'] = "Ocorreu um erro ao inserir.";
    }
} else {
    if ($a == "e" && $p == "s") {

        $_SESSION['mysql_id'] = alterar_banco($_POST, $sys_tabela);
        if (!empty($_SESSION['mysql_id'])) {
            $_SESSION['mysql_msg'] = "Item alterado com sucesso.";
            header("location:" . $sys_local);
            exit;
        } else {
            $_SESSION['mysql_msg'] = "Ocorreu algum erro ao alterar.";
        }
    } else {
        if ($a == "x" && !empty($item)) {
            try {
                $app->db->query("delete from " . $sys_tabela . " where id='" . decode($item) . "'");
            } catch (PDOException $e) {
                die($e->getMessage());
            }

            $_SESSION['mysql_msg'] == "Item excluído com sucesso";
            header("location:" . $sys_local);
            exit;
        } else {
            if ($a == "v" && $p == "s") {
                header("location:" . $sys_local);
                exit;
            }
        }
    }
}
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?= $sys_titulo . ' - ' . PAINEL_BASE_URL ?></title>
        <link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>css/estilo_principal.css"/>
        <?php include "../includes/inc_jscripts.php"; ?>
        <script type="text/javascript" src="<?= PAINEL_BASE_URL ?>scripts/datetimepicker.js"></script>
    </head>
    <body>
    <?php include('../includes/inc_menu_topo.php'); ?>

    <div id="body">
        <?php include "../includes/inc_header.php"; ?>
        <div id="conteudo">
            <?php include "../includes/inc_menu_vert.php"; ?>
            <div class="conteudo_right">
                <?php
                if ($sys_opc_exibe_menu == "1") {
                    include('../includes/inc_menu_padrao.php');
                }

                if (!empty($sys_include_adicional)) {
                    include($sys_include_adicional);
                }

                echo '<div class="content_title">';
                if ($a == 'e' && decode($item) != $_SESSION['admin_usuario_id']) {
                    $form = "<form method=\"post\" name=\"form\" action=\"?a=e&p=s\" enctype=\"multipart/form-data\" class=\"content\">";
                    $where = " and id = '" . decode($item) . "' ";
                    echo "Editar " . $sys_titulo;
                } else {
                    if ($a == 'e' && decode($item) == $_SESSION['admin_usuario_id']) {
                        $form = "<form method=\"post\" name=\"form\" action=\"?a=e&p=s\" enctype=\"multipart/form-data\" class=\"content\">";
                        $where = " and id = '" . decode($item) . "' ";
                        echo "Editar : " . $sys_titulo;
                    } else {
                        if ($a == 'n') {
                            $form = "<form method=\"post\" name=\"form\" action=\"?a=i&p=s\" enctype=\"multipart/form-data\" class=\"content\">";
                            echo "Adicionar " . $sys_titulo;
                            $where = " limit 0,1 ";
                        } else {
                            echo $sys_titulo;
                        }
                    }
                }

                echo "</div>" . $form;

                if (!empty($item) || !empty($a)) {
                    $array_types = array();
                    $array_fields = array();
                    $array_types = array();
                    $array_comments = array();
                    $i = 0;

                    $query_desc = "show full columns from $sys_tabela  "; //"describe tabela_form"

                    try {
                        $query_desc = $app->db->query($query_desc);
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }

                    while ($dados_desc = $query_desc->fetch(PDO::FETCH_ASSOC)) {
                        $field = $dados_desc["Field"];
                        $type = $dados_desc["Type"];
                        $extra = $dados_desc["Extra"];
                        $comment = $dados_desc["Comment"];

                        $array_ids[] = $i;
                        $array_fields[] = $field;
                        $array_types[] = $type;
                        $array_comments[] = $comment;
                        $i++;
                    }
                    #===== end CRIA CAMPOS
                    #===============
                    $dados_query_sql = "SELECT * FROM $sys_tabela WHERE `id` = '" . decode($item) . "' LIMIT 1;";
                    $dados_query = $app->db->query($dados_query_sql);
                    $dados = $dados_query->fetch(PDO::FETCH_ASSOC);
                    #===============
                    #===== CRIA TABELA

                    $query = "show full columns from $sys_tabela ";
                    //echo $query;
                    try {
                        $query = $app->db->query($query);
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }

                    for ($i = 0; $i < count($array_ids); $i++) {
                        if (in_array($i, $array_ids)) {
                            if ($a == 'e') {
                                echo cria_campo($array_comments[$i], $array_fields[$i], $array_types[$i], $extra,
                                    $dados[$array_fields[$i]], $sys_join);
                            } else {
                                echo cria_campo($array_comments[$i], $array_fields[$i], $array_types[$i], $extra, '',
                                    $sys_join);
                            }
                        }
                    }
                    echo "<br clear=\"all\"/>
				<div class=\"content\" style=\"padding-top:15px\">
					<div class=\"save\">
						<a title=\"Clique para salvar\" onclick=\"document.form.submit()\" href=\"javascript:void(0)\">
						<img hspace=\"1\" vspace=\"1\"  src=\"" . PAINEL_BASE_URL . "images/icon_save.png\">Salvar </a>        
					</div>
				</div>
				
				
				</form>";
                } else {
                    if (!empty($_SESSION['mysql_msg'])) {
                        echo "<div class=\"mysql_msg_container\"><div class=\"mysql_msg\" >" . $_SESSION['mysql_msg'] . "</div></div>";
                    }

                    if (!empty($sys_opc_id_unico)) {
                        $where = 'where id = ' . $sys_opc_id_unico;
                    }

                    if ($_GET['sexo'] != '0' && !empty($_GET['sexo'])) {
                        $where .= ((empty($where)) ? ' where ' : ' and ') . 'sexo like "' . $sexo . '"';
                    }

                    if ($_GET['categoria'] != 0) {
                        $where .= ((empty($where)) ? ' where ' : ' and ') . 'id_cat = "' . $categoria . '"';
                    }

                    if ($_GET['marca'] != 0) {
                        $where .= ((empty($where)) ? ' where ' : ' and ') . 'id_marca = "' . $marca . '"';
                    }

                    $ssql = "SELECT * FROM $sys_tabela $where ORDER by ordem";
                    //echo '<pre>'.print_r($query,true).'</pre>';
                    /* @var $query PDOStatement */
                    $query = $app->db->query($ssql);
                    //$app->dbg($app->db->errorInfo());
                    $total = $query->rowCount();

                    $i = 0;
                    if ($total < 1) {
                        echo "<div class=\"noitem\">Nenhum item para listar.</div>";
                    }
                    echo "<ul class=\"sortable\">";

                    while ($dados = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo '<li id="items_' . $dados['id'] . '" title="Arraste para reordenar.">';
                        if ($i % 2) {
                            $cor_linha = '#474747';
                        } else {
                            $cor_linha = "#5f5f5f";
                        }

                        if (!empty($_SESSION['mysql_msg']) && $dados['id'] == $_SESSION['mysql_id']) { //atualizado
                            $cor_linha = '#333';
                            $_SESSION['mysql_id'] = "";
                            $_SESSION['mysql_msg'] = "";
                        }

                        echo "
					<div class=\"item_cad\" style=\" clear:both; " . $sty . "\" id=\"" . $dados['id'] . "\" >
						<div class=\"imgsys\">";

                        if ($sys_opc_ativar == '1') {
                            if ($dados['ativo'] == 'Sim') {
                                echo "<a href=\"" . PAINEL_BASE_URL . "includes/inc_exibir.php?tipo=" . $sys_this_page . "&ativar=0&item=" . $dados['id'] . "\" title=\"Clique para desativar\" class=\"icon_show\"></a>";
                            } else {
                                echo "<a href=\"" . PAINEL_BASE_URL . "includes/inc_exibir.php?tipo=" . $sys_this_page . "&ativar=1&item=" . $dados['id'] . "\" title=\"Clique para ativar\" class=\"icon_noshow\"></a>";
                            }
                        }

                        if ($sys_opc_editar == '1') {
                            echo "<a href=\"" . $sys_local . "?a=e&item=" . encode($dados['id']) . "\" title=\"Clique para editar\" class=\"icon_edit\"></a>";
                        }

                        if ($sys_opc_apagar == '1') {
                            echo "<a href=\"javascript:void(0)\" onclick=\"apagar('" . $sys_local . "?a=x&item=" . encode($dados['id']) . "')\"title=\"Clique para apagar\" class=\"icon_delete\"></a>";
                        }

                        echo "</div>
						<div class=\"namesys\"><strong></strong> - " . $dados['ordem'] . ' : ' . ((isset($nomeCampoExibir)) ? utf8_encode($dados[$nomeCampoExibir]) : utf8_encode(!empty($dados['nome_pt']) ? $dados['nome_pt'] : $dados['nome'])) . "</div><br clear=\"all\" />
						</div></li>";
                        $i++;
                    }
                    echo '</ul>';
                }
                ?>
            </div>
            <br clear="all"/>
        </div>
        <?php include "../includes/inc_footer.php"; ?>
    </div>
    <?php
    if ($sys_opc_ordem == '1') {
        ?>
        <script type="text/javascript">
            $(".sortable").sortable({
                update: function () {
                    var order = $(this).sortable('serialize');
                    //$("#info").load("salva_pos.php?"+order+"&tbl=<?php echo $sys_tabela ?>");
                    $.ajax({
                        url: "<?= PAINEL_BASE_URL ?>includes/inc_salva_pos.php?" + order + "&tbl=<?php echo $sys_tabela ?>",
                        success: function (data) {
                            console.log('ordem: ' + order);
                            console.log('dasdasd ' + data);
                            //$('.conteudo_right:first').append(data);
                            //location.reload(true);
                        }
                    });
                }
            });
            $(".sortable").disableSelection();
        </script>
        <?php
    }
    ?>
    </body>
    </html>
<?php
ob_end_flush();
