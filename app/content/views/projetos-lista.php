<div class="pag-padrao pag-projetos">

    <div class="grid_12">
        <h1>Projetos cadastrados</h1>
        <h3 class="grid_8">Listando os projetos cadastrados nos últimos: </h3>

    </div>

    <div class="box960 list-news">
        <form method="post" action="<?= $this->url(array('projetos-lista')) ?>">
            <div class="grid_2">
                <select class="form-control" name="dias" id="">
                    <option value="30">30 dias</option>
                    <option value="60">60 dias</option>
                    <option value="90">90 dias</option>
                    <option value="180">180 dias</option>
                    <option value="360">1 ano</option>
                </select>
            </div>

            <div class="grid_4">
                <select class="form-control" name="status" id="">
                    <option value="n">Pesquisar por Status</option>
                    <?php
                    foreach (Projetos::getListaStatus() as $l => $m) {
                        ?>
                        <option value="<?= $l ?>"><?= $m ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="grid_2">
                <button type="submit" class="btn">Filtrar</button>
            </div>
        </form>
        <?php
        foreach ($projetos as $p) {
            ?>
            <a href="<?= $this->url(array('projeto-interna', $p->getId())) ?>" class="item grid_12" style="margin-top:40px;">
                <div class="foto grid_2 alpha"><span class="typcn typcn-document-text"></span><img src="<?= $this->publicAssetsUrl ?>images/projetos/icon-<?= $p->getStatusDb() ?>.jpg" alt=""></div>
                <div class="grid_10 omega">
                    <h2><?= $p->getNome(); ?></h2>
                    <b><?= $p->getDataInicio()->format('d/m/Y') ?></b>
                    <p><?= $p->getResumo(); ?></p>
                </div>
            </a>
            <?php
        }
        ?>

        <!--        <div class="paginacao right">
                    <ul>
                        <li class="first"><a href="javascript:;" class="typcn typcn-arrow-left"></a></li>
                        <li><a href="javascript:;">1</a></li>
                        <li class="current"><a href="javascript:;">2</a></li>
                        <li><a href="javascript:;">3</a></li>
                        <li><a href="javascript:;">4</a></li>
                        <li class="last"><a href="javascript:;" class="typcn typcn-arrow-right"></a></li>
                    </ul>
                </div>-->
    </div>

</div>
