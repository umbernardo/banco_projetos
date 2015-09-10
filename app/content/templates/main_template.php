<?php
/* @var $this SiteController */
?>
<!DOCTYPE HTML>
<html>     
    <head>
        <?= $this->metatags() ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="content-language" content="pt-br" />
        <link href="<?= $this->publicAssetsUrl ?>css/main.css" rel="stylesheet">
        <link href="<?= $this->publicAssetsUrl ?>css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= $this->publicAssetsUrl ?>css/default.css" />
        <link rel="stylesheet" type="text/css" href="<?= $this->publicAssetsUrl ?>css/typicons.min.css" />
        <link rel="stylesheet" type="text/css" href="<?= $this->publicAssetsUrl ?>css/jasny-bootstrap.min.css">
    </head>
    <body class="page-<?= $this->paginaAtual ?>">
        <div id="fundo">
            <header id="top">
                <div class="container_12 top">
                    <div id="logo" class="grid_8"><a href="<?= $this->url(array('home')) ?>"><img src="<?= $this->publicAssetsUrl ?>images/layout/logo.png" alt=""></a></div> 
                    <div class="grid_4">
                        <form action="" method="" class="formulario form-busca">
                            <div class="grid_3 alpha omega">
                                <input type="text" name="txtBusca" placeholder="Buscar no site" />
                            </div>
                            <button type="submit" class="btnLupa"></button>
                        </form>
                    </div>
                    <nav>
                        <ul>
                            <li><a href="<?= $this->url(array('home')) ?>">Home </a></li>
                            <li><a href="<?= $this->url(array('sobre')) ?>">Sobre</a></li>
                            <li><a href="<?= $this->url(array('login')) ?>">Minha Conta</a></li>
                            <li><a href="<?= $this->url(array('cadastro')) ?>">Cadastre-se</a></li>
                            <li><a href="<?= $this->url(array('projetos/cadastro')) ?>">Cadastro de Projetos</a></li>
                            <li class="last"><a href="<?= $this->url(array('projetos-lista')) ?>">Visualizar Projetos</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <section id="corpo" class="container_12">
                <?php
                if ($this->existeMensagens()) {
                    $this->exibirMensagens();
                }
                echo $conteudo;
                ?>
                <div class="clear"></div> 
            </section> 
            <footer>
                <div class="container_12">
                    <div class="box960 bloco-1">
                        <div class="grid_3">
                            <a href="<?= $this->url(array('home')) ?>"><img src="<?= $this->publicAssetsUrl ?>images/layout/logo-rodape.png" alt=""></a>
                        </div>
                        <div class="box640 newsletter-rodape">
                            <div class="grid_9 ">
                                <h2>Minha conta</h2>
                                <p>Acesse sua conta, informe os dados abaixo:</p>
                            </div>
                            <form action="" method="" class="formulario form-news">
                                <div class="campo grid_3">
                                    <input type="text" name="txtNomeNews" placeholder="Nome" />
                                </div>
                                <div class="campo grid_3">
                                    <input type="text" name="txtEmailNews" placeholder="E-mail" />
                                </div>
                                <div class="grid_2">
                                    <button type="submit" class="btn-primario">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box960 menu-rodape">
                        <ul class="grid_5">
                            <li class="first">Banco de Projetos</li>
                            <li><a href="">Home</a></li>
                            <li><a href="">Sobre</a></li>
                            <li><a href="">Cadastrar Projetos</a></li>
                            <li><a href="">Visualizar Projetos</a></li>
                        </ul>
                        <ul class="last grid_6">
                            <li class="first">Localização</li>
                            <li class="first">
                                <address>
                                    Instituto Federal de Educação, Ciência e Tecnologia de São Paulo - IFSP Campus Campinas
                                    Rodovia D. Pedro I (SP-65), KM 143,6 - Bairro Amarais
                                    Campinas, SP - CEP 13069-901<br>
                                    Fone: (19) 3746-6128<br>
                                    e-Mail:campinas@ifsp.edu.br
                                </address>
                            </li>
                        </ul>
                    </div> 
                    <copyright class="grid_12">IFSP Banco de Projetos © Todos os direitos reservados</copyright>
                </div>
            </footer>
        </div>
    </body>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $this->publicAssetsUrl ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $this->publicAssetsUrl ?>js/plugins.js"></script>
    <script type="text/javascript" src="<?= $this->publicAssetsUrl ?>js/slider.js"></script>
    <script type="text/javascript" src="<?= $this->publicAssetsUrl ?>js/jasny-bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $this->publicAssetsUrl ?>js/funcoes.js"></script>
</html>