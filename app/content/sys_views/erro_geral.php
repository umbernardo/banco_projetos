<?php /* @var $e Exception */ ?>
<?php /* @var $this SiteController */ ?>
<div class="container">
    <div class="row">
        <div class="span12">
            <div class="hero-unit center">
                <?php
                if (true === $this->config->debug) {
                    ?>
                    <h1><?= $e->getMessage() ?> <small><font face="Tahoma" color="red">Erro <?= $e->getCode() ?></font></small></h1>
                    <br />
                    <?php
                    $t = explode('#', $e->getTraceAsString());
                    foreach ($t as $j) {
                        ?>
                        <p>
                            <?= $j ?>
                        </p>
                        <?php
                    }
                    $this->dbg($e->getFile());
                    $this->dbg($e->getMessage());
                    $this->dbg($e->getCode());
                } else {
                    ?>
                    Ocorreu um erro interno em nossos servidores. Por favor tente novamente. Se o erro persistir entre em contato conosco.
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
