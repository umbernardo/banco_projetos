<?php /* @var $this CupMailer */ ?>
<table rules="all" style="border-color: #666;" cellpadding="10">
    <tbody>
        <?php
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
                <strong>IP:</strong>
            </td>
            <td>
                <?= $_SERVER['REMOTE_ADDR'] ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Data/Hora:</strong>
            </td>
            <td>
                <?= Date('d/m/Y H:i:s') ?>
            </td>
        </tr>
    </tbody>
</table>