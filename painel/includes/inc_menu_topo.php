<div class="menu_topo">
    <div class="fixed">
        <div class="wraper_topo">
            <div class="welcome">
                <a title="" href="#">

                </a>
                <span>
                    Olá, <?= utf8_encode($_SESSION['admin_usuario']) ?> &nbsp; - &nbsp;
                </span>
                <?php
                if (function_exists('date_default_timezone_set')) {
                    date_default_timezone_set("Brazil/East");
                }
                echo date("d/m/Y H:i:s", time());
                ?>
            </div>
            <div class="userNav">
                <ul>
                    <!--
                    <li class="iedit">
                        <a title="" href="<?= PAINEL_BASE_URL ?>configuracoes/page_sys_newsletter.php">
                            <span>Newsletter</span>
                        </a>
                    </li>
                                        <li class="iedit">
                                            <a title="" href="<?= PAINEL_BASE_URL ?>configuracoes/page_sys_seo.php">
                                                <span>SEO</span>
                                            </a>
                                        </li>-->
                    <li class="iedit">
                        <a title="" href="<?= PAINEL_BASE_URL ?>configuracoes/page_sys_config.php?a=e&item=MuQ1=A=s">
                            <span>Configurações</span>
                        </a>
                    </li>
                    <li class="idelete"><a title="" href="<?= PAINEL_BASE_URL ?>logoff.php">
                            <span>Sair</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="fix"></div>
        </div>
    </div>
</div>