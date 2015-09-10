<div class="container_12">
    <div class="box480">
        <div class="grid_6">
            <h1>Acesse sua conta</h1>
            <p>
                Cadastre seu projeto em nosso Banco de Projetos<br><br>
            </p>
        </div>
        <form action="<?= $this->url(array('login')) ?>" method="post" class="formulario form-contato">
            <div class="campo grid_6">
                <input type="text" class="" value="" id="Email" name="email" placeholder="E-mail (usado para o seu login)">
            </div>
            <div class="campo grid_6">
                <input type="password" class="" value="" id="Senha" name="senha" placeholder="Senha">
            </div>
            <div class="grid_3 left">
                <a href="<?=$this->url(array('recuperar-senha'))?>" class="btn-primario" type="submit">
                    Esqueci minha senha
                </a>
            </div>
            <div class="grid_2 right">
                <button class="btn-primario" type="submit">
                    Acessar
                </button>
            </div>
        </form>
    </div>
    <div class="grid_6">
        <h1>Não possui cadastro?</h1>
        <p style="height:150px;">
            • Faça seu cadastro gratuitamente<br><br>
            • Nota: Outros serão capazes de encontrá-lo pelo nome e projetos cadastrados. O seu email não será exibido ao público. Você pode alterar suas configurações de privacidade a qualquer momento.
        </p>
        <div class="grid_2 right">
            <a href="<?= $this->url(array('cadastro')) ?>" class="btn-primario">Cadastrar</a>
        </div>
    </div>
</div>



