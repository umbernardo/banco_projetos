
<div class="box960">
    <?php $this->renderizarParcial('projetos/parc_menu'); ?>
    <div class="box720">
        <div class="grid_9">
            <h1>Cadastre seu projeto</h1>
            <p>
                Lorem ipsum dolor sit amet, sapien etiam, nunc amet dolor ac odio mauris justo. Luctus arcu, urna praesent at id quisque ac. Arcu massa vestibulum malesuada, integer vivamus elit eu mauris eu, cum eros quis aliquam nisl wisi.
                <br/><br/>
            </p>  

        </div>
        <form action="<?= $this->url(array('projetos', 'cadastro')) ?>" method="post" class="formulario form-contato" enctype="multipart/form-data">
            <div class="grid_9"><label>Dados do projeto</label></div>
            <div class="campo grid_9">
                <input type="text" class="form-control" value="" id="Nome" name="nome" placeholder="Nome / Título">
            </div>
            <div class="campo grid_5">
                <input type="text" class="form-control" value="" id="Inicio" name="dataInicio" placeholder="Data de início">
            </div>
            <input type="hidden" name="status" value="">
            <div class="grid_4">
                <select class="form-control" name="status" id="">
                    <?php
                    foreach (Projetos::getListaStatus() as $l => $m) {
                        ?>
                        <option value="<?= $l ?>"><?= $m ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="campo grid_9">
                <input type="text" class="form-control" value="" id="Demandante" name="nomeDemandante" placeholder="Demandante">
            </div>

            <div class="campo grid_9">
                <input type="text" class="form-control" value="" id="Instituicao" name="instituicaoDemandante" placeholder="Instituição do Demantante">
            </div>
            <div class="campo grid_9">
                <input type="text" class="form-control" value="" id="Contato" name="emailDemandante" placeholder="E-mail do demandante">
            </div>
            <div class="campo grid_9">
                <textarea id="Resumo" name="resumo" placeholder="Resumo do projeto"></textarea>
            </div>
            <div class="grid_9"><label>Anexe seu projeto ( .pdf )</label></div>
            <div class="campo grid_9">
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                    <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Procurar...</span><span class="fileinput-exists">Mudar</span><input type="file" name="..."></span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                </div>
            </div>

            <div class="grid_4 right">
                <button type="submit" class="btn-primario">Enviar</button> 
            </div>
        </form>      

    </div>
</div>