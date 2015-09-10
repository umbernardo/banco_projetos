<div class="box960">
    <?php $this->renderizarParcial('projetos/parc_menu'); ?>
    <div class="box720">
        <div class="grid_9">
            <h1>Atualizar seu cadastro</h1>

            <p>
                Atualize seu cadastro utilizando o formulário abaixo
                <br/><br/>
            </p>

        </div>
        <form action="<?= $this->url(array('projetos', 'meus-dados')) ?>" method="post" class="formulario form-contato">
            <div class="campo grid_6"><label>Dados pessoais</label></div>
            <div class="campo grid_6">
                <input type="text" class="" value="<?= $usuario->getNome() ?>" id="Nome" name="nome" placeholder="Nome">
            </div>
            <div class="campo grid_6">
                <input type="text" class="" value="<?= $usuario->getCpf() ?>" id="Cpf" name="cpf" placeholder="CPF">
            </div>
            <div class="campo grid_3">
                <input type="text" class="" value="<?= $usuario->getCidade() ?>" id="Cidade" name="cidade"
                       placeholder="Cidade">
            </div>
            <div class="campo grid_3">
                <input type="text" class="" value="<?= $usuario->getUf() ?>" id="Uf" name="uf" placeholder="UF">
            </div>
            <div class="campo grid_4">
                <input type="text" class="" value="<?= $usuario->getEndereco() ?>" id="Endereco" name="endereco"
                       placeholder="Endereço">
            </div>
            <div class="campo grid_2">
                <input type="text" class="" value="<?= $usuario->getNumero() ?>" id="Numero" name="numero"
                       placeholder="Número">
            </div>
            <div class="campo grid_6">
                <input type="text" class="" value="<?= $usuario->getComplemento() ?>" id="Complemento"
                       name="complemento" placeholder="Complemento">
            </div>
            <div class="grid_2">
                <button type="submit" class="btn-primario">Salvar</button>
            </div>
        </form>
    </div>
</div>
