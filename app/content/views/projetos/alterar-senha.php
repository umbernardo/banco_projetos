<div class="box960">
    <?php $this->renderizarParcial('projetos/parc_menu'); ?>
    <div class="box720">
        <div class="grid_9">
            <h1>Alterar senha</h1>

            <p>
                Utilize o formulário abaixo para alterar sua senha.
                <br/><br/>
            </p>

        </div>
        <form action="<?= $this->url(array('projetos', 'alterar-senha')) ?>" method="post"
              class="formulario form-contato">
            <div class="campo grid_6">
                <input type="password" name="senha" placeholder="Senha atual">
            </div>
            <div class="campo grid_6">
                <input type="password" name="senha_nova" placeholder="Nova Senha">
            </div>
            <div class="campo grid_6">
                <input type="password" name="senha_confirmacao" placeholder="Repita a nova senha">
            </div>
            <div class="grid_6">
                <button type="submit" class="btn-primario">Salvar</button>
            </div>
        </form>
    </div>
</div>
