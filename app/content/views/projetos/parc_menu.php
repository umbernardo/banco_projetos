<div class="menu-cadastro grid_3">
    <h1>Minha conta</h1>
    <ul>
        <li><a href="<?=$this->url(array('projetos','meus-dados'))?>">Meus dados</a></li>
        <li><a href="<?=$this->url(array('projetos','alterar-senha'))?>">Alterar senha</a></li>
        <li><a href="<?= $this->url(array('projetos', 'home')) ?>">Meus projetos</a></li>
        <li><a href="<?= $this->url(array('projetos', 'cadastro')) ?>">Cadastrar projeto</a></li>
        <li><a href="">Projetos que participo</a></li>
        <li><a href="<?= $this->url(array('logout')) ?>">Logout</a></li>
    </ul>
</div>
