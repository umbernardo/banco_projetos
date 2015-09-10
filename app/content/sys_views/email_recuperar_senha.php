<?php /* @var $this CupMailer */ ?>
<p>
    Olá <?= $dados['usuario']->getNome() ?>, foi solicitado em nosso site a recuperação de sua senha. Caso você a tenha solicitado, clique no link abaixo, caso contrário, ignore esta mensagem.
</p>
<table rules="all" style="border-color: #666;" cellpadding="10">
    <tbody>
        <tr>
            <td>
                <strong>URL:</strong>
            </td>
            <td>
                <a href="<?= $dados['url'] ?>">Alterar senha</a>
            </td>
        </tr>
    </tbody>
</table>