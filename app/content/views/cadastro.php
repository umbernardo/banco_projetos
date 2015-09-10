<?php
/* @var $this SiteController */
/* @var $usuario Usuarios */
?>
<div class="container_12">
    <div class="box480">
        <div class="grid_6">
            <h1>Cadastre-se</h1>
            <p>
                Preencha o formulário abaixo e cadastre-se gratuitamente em nosso banco de projetos<br><br>
            </p>
        </div>
        <form action="<?= $this->url(array('efetuar-cadastro')) ?>" method="post" class="formulario form-contato">
            <div class="campo grid_6"><label>Dados pessoais</label></div>
            <div class="campo grid_6">
                <input type="text" class="" value="<?= $usuario->getNome() ?>" id="Nome" name="nome" placeholder="Nome">
            </div>
            <div class="campo grid_6">
                <input type="text" class="" value="<?= $usuario->getCpf() ?>" id="Cpf" name="cpf" placeholder="CPF">
            </div>
            <div class="campo grid_3">
                <input type="text" class="" value="<?= $usuario->getCidade() ?>" id="Cidade" name="cidade" placeholder="Cidade">
            </div>
            <div class="campo grid_3">
                <input type="text" class="" value="<?= $usuario->getUf() ?>" id="Uf" name="uf" placeholder="UF">
            </div>
            <div class="campo grid_4">
                <input type="text" class="" value="<?= $usuario->getEndereco() ?>" id="Endereco" name="endereco" placeholder="Endereço">
            </div>
            <div class="campo grid_2">
                <input type="text" class="" value="<?= $usuario->getNumero() ?>" id="Numero" name="numero" placeholder="Número">
            </div>
            <div class="campo grid_6">
                <input type="text" class="" value="<?= $usuario->getComplemento() ?>" id="Complemento" name="complemento" placeholder="Complemento">
            </div>
            <div class="campo grid_6"><label>Dados de acesso</label></div>
            <div class="campo grid_6">
                <input type="text" class="" value="<?= $usuario->getEmail() ?>" id="Email" name="email" placeholder="E-mail (usado para o seu login)">
            </div>
            <div class="campo grid_6">
                <input type="password" class="" value="" id="Senha" name="senha" placeholder="Senha">
            </div>
            <div class="grid_2 right">
                <button type="submit" class="btn-primario">Acessar</button> 
            </div>
        </form>
    </div>
    <div class="grid_6">

        <img src="<?= $this->publicAssetsUrl ?>images/cadastro/book.jpg" height="365" width="470" alt="">
        <div class="termos">
            <p>
                • Ao inscrever-se, você concorda com os nossos termos e que você leu nossa política em relação ao uso de dados e informações.
                <br><br>
                • Nota: Outros serão capazes de encontrá-lo pelo nome e projetos cadastrados. O seu email não será exibido ao público. Você pode alterar suas configurações de privacidade a qualquer momento.
            </p>
        </div>
    </div>
</div>



