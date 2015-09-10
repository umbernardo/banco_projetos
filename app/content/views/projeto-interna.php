<?php /* @var $projeto Projetos */ ?>
<div class="pag-projetos pag-padrao">

    <div class="grid_12">
        <h1>Projetos</h1>

    </div>

    <div class="list-news">

        <div class="grid_3 omega">
            <h5>Proponente</h5>
            <?= $projeto->getNomeDemandante() ?>
            <h5>Data de início</h5>
            <?= $projeto->getDataInicio()->format('d/m/Y') ?>
            <h5>Responsável</h5>
            <?= $projeto->getUsuario()->getNome() ?>
            <h5>E-mail do proponente</h5>
            <?= $projeto->getEmailDemandante() ?>
            <h5>Desenvolvedor</h5>
            <?php
            if ($projeto->temDesenvolvedor()) {
                echo $projeto->getDesenvolvedor()->getNome();
            } else {
                ?>
                <a class="btn-primario" href="<?= $this->url(array('ser-desenvolvedor', $projeto->getId())) ?>">
                    Desejo ser desenvolvedor
                </a>
                <?php
            }
            ?>
        </div>

    </div>
    <div class="box720 content-projetos">
        <div class="grid_9">
            <h4><?= $projeto->getNome() ?></h4>
            <!--<b>Data de Cadastro: 20 / 07 / 2014</b>-->
        </div>
        <div class="grid_9 texto">
            <p>
                <?= $projeto->getResumo() ?>
            </p>
        </div>
        <div class="grid_4 alpha omega">
            <?php
            if ($projeto->temArquivo()) {
                ?>
                <a target="_blank" style="margin:10px;"
                   href="<?= $this->url(array('uploads', 'projetos', $projeto->getArquivo())) ?>" class="btn-primario">Baixar
                    projeto</a>
                <?php
            }
            ?>
        </div>


    </div>

</div>
