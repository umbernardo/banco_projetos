<div class="box960">
    <?php $this->renderizarParcial('projetos/parc_menu'); ?>
    <div class="box720">
        <div class="grid_9">
            <h1>Meus Projetos</h1>
            <p>
                Lorem ipsum dolor sit amet, sapien etiam, nunc amet dolor ac odio mauris justo. Luctus arcu, urna praesent at id quisque ac. Arcu massa vestibulum malesuada, integer vivamus elit eu mauris eu, cum eros quis aliquam nisl wisi.
                <br/><br/>
            </p>  
        </div>
        <div class="menu-cadastro grid_9">
            <ul>
                <?php
                foreach ($projetos as $p) {
                    ?>
                    <li><a href="<?= $this->url(array('projeto-interna', $p->getId())) ?>"><?= $p->getNome() ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>