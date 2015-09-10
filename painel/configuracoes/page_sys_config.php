<?php
require_once('../includes/inc_checa_sessao.php');
require_once('../includes/inc_database.php');
require_once('../includes/inc_funcoeslib.php');

extract($_GET, EXTR_OVERWRITE);
extract($_POST, EXTR_OVERWRITE);



//=================================================
$sys_opc_editar = "1";
$sys_opc_ativar = "0";
$sys_opc_apagar = "0";
$sys_opc_ordem = "0";
$sys_opc_exibe_menu = "0";

$thumb_size = array(array(array(730, 90)));

$sys_this_page = "sys_config";
$sys_local = "page_" . $sys_this_page . ".php";
$sys_tabela = "tbl_" . $sys_this_page;
$sys_titulo = "Configurações";

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
        <title></title>
        <link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>css/estilo_principal.css" />
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
                    if ($sys_opc_exibe_menu != "0") {
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
                    } else if ($a == 'e' && decode($item) == $_SESSION['admin_usuario_id']) {
                        $form = "<form method=\"post\" name=\"form\" action=\"?a=e&p=s\" enctype=\"multipart/form-data\" class=\"content\">";
                        $where = " and id = '" . decode($item) . "' ";
                        echo "Editar : " . $sys_titulo;
                    } else if ($a == 'n') {
                        $form = "<form method=\"post\" name=\"form\" action=\"?a=i&p=s\" enctype=\"multipart/form-data\" class=\"content\">";
                        echo "Adicionar " . $sys_titulo;
                        $where = " limit 0,1 ";
                    } else {
                        echo $sys_titulo;
                    }

                    echo "</div>" . $form;

                    if (!empty($item) || !empty($a)) {

                        #===== CRIA CAMPOS 
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
                                    echo cria_campo($array_comments[$i], $array_fields[$i], $array_types[$i], $extra, $dados[$array_fields[$i]], '');
                                } else {
                                    echo cria_campo($array_comments[$i], $array_fields[$i], $array_types[$i], $extra, '', '');
                                }
                            }
                        }

                        #===== end CRIA TABELA

                        echo "<br clear=\"all\">
                    <div class=\"content\" style=\"padding-top:15px\">
                    <div class=\"save\">
                    <a title=\"Clique para salvar\" onclick=\"document.form.submit()\" href=\"javascript:void(0)\">
                    <img hspace=\"1\" vspace=\"1\"  src=\"" . PAINEL_BASE_URL . "images/icon_save.png\">Salvar </a>        
                    </div>
                    </div>


                    </form>
                    <div class=\"content_round_bottom\"><img src=\"images/menu_background_b_l.jpg\"></div>";
                    } else {


                        if (!empty($_SESSION['mysql_msg'])) {
                            echo "<div class=\"mysql_msg_container\"><div class=\"mysql_msg\" >" . $_SESSION['mysql_msg'] . "</div></div>";
                        }

                        $query = "SELECT * FROM $sys_tabela ORDER by id asc";
                        $query = $app->db->query($query);
                        $total = $query->rowCount();

                        $i = 0;
                        if ($total < 1) {
                            echo "<div class=\"noitem\">Nenhum item para listar.</div>";
                        }
                        while ($dados = $query->fetch(PDO::FETCH_ASSOC)) {

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
                    <div class=\"item_cad\" style=\" clear:both; " . $sty . "\" id=\"linha" . $dados['id'] . "\" >
                    <div class=\"imgsys\">";

                            if ($sys_opc_ativar == '1') {
                                if ($dados['ativo'] == 'Sim') {
                                    echo "<a href=\"inc_exibir.php?tipo=" . $sys_this_page . "&ativar=0&item=" . $dados['id'] . "\" target=\"iframex\" title=\"Clique para desativar\" class=\"icon_show\"></a>";
                                } else {
                                    echo "<a href=\"inc_exibir.php?tipo=" . $sys_this_page . "&ativar=1&item=" . $dados['id'] . "\" target=\"iframex\" title=\"Clique para ativar\" class=\"icon_noshow\"></a>";
                                }
                            }

                            if ($sys_opc_editar == '1') {
                                echo "<a href=\"" . $sys_local . "?a=e&item=" . encode($dados['id']) . "\" title=\"Clique para editar\" class=\"icon_edit\"></a>";
                            }

                            if ($sys_opc_apagar == '1') {
                                echo "<a href=\"javascript:void(0)\" onclick=\"apagar('" . $sys_local . "?a=x&item=" . encode($dados['id']) . "')\"title=\"Clique para apagar\" class=\"icon_delete\"></a>";
                            }

                            if ($sys_opc_ordem == '1') {
                                if ($i > 0) {
                                    echo "<a href=\"inc_ordem.php?t=" . $sys_this_page . "&item=" . $dados['id'] . "&o=" . $dados['ordem'] . "&m=mais\" target=\"iframex\" title=\"Clique para subir\" class=\"icon_up\"></a>";
                                }
                                if ($i != ($total - 1) && $total > 1) {
                                    echo "<a href=\"inc_ordem.php?t=" . $sys_this_page . "&item=" . $dados['id'] . "&o=" . $dados['ordem'] . "&m=menos\" target=\"iframex\" title=\"Clique para descer\" class=\"icon_down\"></a>";
                                }
                            }
                            echo "</div>
                    <div class=\"namesys\"><strong></strong> - " . utf8_encode($dados['nome']) . "</div><br clear=\"all\" />
                    </div>";
                            $i++;
                        }
                        echo "<div class=\"content_round_bottom\"><img src=\"images/menu_background_b_l.jpg\"></div>";
                    }
                    ?>
                </div><br clear="all" />
            </div>
            <?php include "../includes/inc_footer.php"; ?>
        </div>

    </body>
</html>