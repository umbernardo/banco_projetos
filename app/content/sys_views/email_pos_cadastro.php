<?php /* @var $this CupMailer */ ?>
<p>
    Olá <?= $dados['nome'] ?>, obrigado por se cadastrar em nosso site.
</p>
<p>
    Segue abaixo seus dados para acesso :
</p>
<table rules="all" style="border-color: #666;" cellpadding="10">
    <tbody>
        <?php
        unset($dados['nome']);
        foreach ((array) $dados as $n => $c) {
            ?>
            <tr>
                <td>
                    <strong><?= $n ?>:</strong>
                </td>
                <td>
                    <?= $c ?>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td>
                <strong>URL para login:</strong>
            </td>
            <td>
                <a href="<?= $this->url(array('login'), $this->siteUrl) ?>">Clique Aqui</a>
            </td>
        </tr>
    </tbody>
</table>