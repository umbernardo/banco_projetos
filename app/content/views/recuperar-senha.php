<div class="container_12">
    <div class="box480">
        <div class="grid_6">
            <h1>Recuperar acesso a sua conta</h1>
            <p>
                Informe seu endereço de e-mail para que possamos enviar uma nova senha para você.<br><br>
            </p>
        </div>
        <form action="<?= $this->url(array('recuperar-senha')) ?>" method="post" class="formulario form-contato">
            <div class="campo grid_6">
                <input type="text" class="" value="" id="Email" name="email" placeholder="E-mail (usado para o seu login)">
            </div>
            <div class="grid_2 right">
                <button class="btn-primario" type="submit">
                    Recuperar
                </button>
            </div>
        </form>
    </div>
</div>



