<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
  <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo esc($titulo)?></h4>                    
                    <h4 class="card-title"><?php echo esc($produto->nome)?></h4>

                    <div class="card" style="width: 18rem;">
                        <?php if($produto->imagem): ?>
                            <img class="card-img-top" src="<?php echo site_url("admin/produtos/imagem/$produto->imagem") ?>" alt="<?php echo esc($produto->nome) ?>">
                        <?php else: ?>
                            <img class="card-img-top" src="<?php echo site_url('admin/images/produto-sem-imagem.png') ?>" alt="Produto sem imagem">
                        <?php endif; ?>
                    </div>

                    <a 
                        href="<?php echo site_url('admin/produtos/editarimagem/'.$produto->id); ?>" 
                        class="btn btn-outline-primary btn-sm mt-3 mb-1"
                    >
                        <i class="mdi mdi-image btn-icon-prepend"></i>
                        Alterar imagem
                    </a>

                    <hr/>
                    
                    <p class="card-text">
                        <strong>Nome:</strong> <?php echo esc($produto->nome)?>                        
                    </p>

                    <p class="card-text">
                        <strong>Categoria:</strong> <?php echo esc($produto->categoria)?>                        
                    </p>

                    <p class="card-text">
                        <strong>Slug:</strong> <?php echo esc($produto->slug)?>                        
                    </p>

                    <p class="card-text">
                        <strong>Ativo:</strong> <?php echo ($produto->ativo ? 'Sim' : 'Não')?>                        
                    </p>

                    <!-- O metodo humanize deixa no formato: criado ha '1 semana atras' -->
                    <p class="card-text">
                        <strong>Criado:</strong> <?php echo $produto->criado_em->humanize()?> 
                    </p>

                    <?php if ($produto->deletado_em === null): ?>
                        <p class="card-text">
                            <strong>Atualizado:</strong> <?php echo $produto->atualizado_em->humanize(); ?>
                        </p>
                    <?php else: ?>
                        <p class="card-text text-danger">
                            <strong>Excluído:</strong> <?php echo $produto->deletado_em->humanize(); ?>
                        </p>
                    <?php endif; ?>              
                    
                </div>

                <div class="card-footer bg-primary">

                    <?php if ($produto->deletado_em === null): ?>
                        <a 
                            href="<?php echo site_url('admin/produtos/editar/'.$produto->id); ?>" 
                            class="btn btn-dark btn-sm"
                        >
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            Editar
                        </a>  
                        
                        <a 
                            href="<?php echo site_url('admin/produtos/extras/'.$produto->id); ?>" 
                            class="btn btn-success btn-sm"
                        >
                            <i class="mdi mdi-arrow-up btn-icon-prepend"></i>
                            Extras
                        </a>
                        
                        <a 
                            href="<?php echo site_url('admin/produtos/modalExcluir/'.$produto->id); ?>" 
                            class="btn btn-danger btn-sm"
                        >
                            <i class="mdi mdi-trash-can btn-icon-prepend"></i>
                            Excluir
                        </a> 

                        <a 
                        href="<?php echo site_url('admin/produtos/'); ?>" 
                        class="btn btn-light btn-sm"
                        >
                            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                            Voltar
                        </a> 
                    <?php else: ?>

                        <a data-toogle="tooltip" data-placement="top" title="Desfazer a exclusão" href="<?php echo site_url('admin/produtos/desfazerexclusao/' . $produto->id); ?>" class="btn btn-dark btn-sm" style="text-decoration: none;">
                            <i class="mdi mdi-undo btn-icon-prepend"></i>
                            Recuperar
                        </a>

                        <a 
                        href="<?php echo site_url('admin/produtos/'); ?>" 
                        class="btn btn-light btn-sm"
                        >
                            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                            Voltar
                        </a> 
                    <?php endif; ?> 
                </div>
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
  <!-- Aqui enviamos para o template principal os scripts -->

<?php echo $this->endSection(); ?>