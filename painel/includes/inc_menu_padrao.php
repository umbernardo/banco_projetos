<?php
global $sys_join;
global $sys_this_page;
//if ((!empty($sys_join)) or (stristr($sys_this_page, 'cat_') != FALSE)) {
//Alterado para não cair aqui (por enquanto)
if (1 == 0) {
    if (stristr($sys_this_page, 'cat_')) {
        $res = end(explode('cat_', $sys_this_page));
        $pagina_cat = 'page_cat_' . $res . '.php';
        $texto_cat = ucfirst($res) . '(s)';
        $pagina = 'page_' . $res . '.php';
    } else {
        $pagina = 'page_' . $sys_this_page . '.php';
        $pagina_cat = 'page_cat_' . $sys_this_page . '.php';
        $texto_cat = 'Categoria(s)';
    }
    ?>
    <div class="menu_nav">
        <div style="height:20px;">
            <ul class="ejrkej">
                <li class="kfjkjfe">
                    <a href="<?= $pagina ?>?a=n">Cadastrar novo</a>
                </li>                        
                <li class="kfjkjfe">
                    <a href="<?= $pagina ?>">Ver cadastrados</a>
                </li>
                <li class="kfjkjfe">
                    <a href="<?= $pagina_cat ?>?a=n">Cadastrar Categorias</a>
                </li>                        
                <li class="kfjkjfe">
                    <a href="<?= $pagina_cat ?>">Ver Categorias</a>
                </li>
            </ul>
        </div>
    </div>
    <br clear="all">
    <?php
} else {
    ?>
    <div class="menu_nav">
        <div style="height:20px;">
            <ul class="ejrkej">
                <li class="kfjkjfe">
                    <a href="<?php echo $sys_local; ?>?a=n">Cadastrar novo</a>
                </li>                        
                <li class="kfjkjfe">
                    <a href="<?php echo $sys_local; ?>">Ver cadastrados</a>
                </li>
            </ul>
        </div>
    </div>
    <br clear="all">
    <?php
}
?>