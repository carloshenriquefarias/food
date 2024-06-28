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
                    <h4 class="card-title"><?php echo esc($medida->nome)?></h4>
                    
                    <p class="card-text">
                        <strong>Nome:</strong> <?php echo esc($medida->nome)?>                        
                    </p>

                    <p class="card-text">
                        <strong>Ativo:</strong> <?php echo ($medida->ativo ? 'Sim' : 'Não')?>                        
                    </p>

                    <!-- O metodo humanize deixa no formato: criado ha '1 semana atras' -->
                    <p class="card-text">
                        <strong>Criado:</strong> <?php echo $medida->criado_em->humanize()?> 
                    </p>

                    <?php if ($medida->deletado_em === null): ?>
                        <p class="card-text">
                            <strong>Atualizado:</strong> <?php echo $medida->atualizado_em->humanize(); ?>
                        </p>
                    <?php else: ?>
                        <p class="card-text text-danger">
                            <strong>Excluído:</strong> <?php echo $medida->deletado_em->humanize(); ?>
                        </p>
                    <?php endif; ?>              
                    
                </div>

                <div class="card-footer bg-primary">

                    <?php if ($medida->deletado_em === null): ?>
                        <a 
                            href="<?php echo site_url('admin/medidas/editar/'.$medida->id); ?>" 
                            class="btn btn-dark btn-sm"
                        >
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            Editar
                        </a>    
                        
                        <a 
                            href="<?php echo site_url('admin/medidas/modalExcluir/'.$medida->id); ?>" 
                            class="btn btn-danger btn-sm"
                        >
                            <i class="mdi mdi-trash-can btn-icon-prepend"></i>
                            Excluir
                        </a> 

                        <a 
                        href="<?php echo site_url('admin/medidas/'); ?>" 
                        class="btn btn-light btn-sm"
                        >
                            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                            Voltar
                        </a> 
                    <?php else: ?>

                        <a data-toogle="tooltip" data-placement="top" title="Desfazer a exclusão" href="<?php echo site_url('admin/medidas/desfazerexclusao/' . $medida->id); ?>" class="btn btn-dark btn-sm" style="text-decoration: none;">
                            <i class="mdi mdi-undo btn-icon-prepend"></i>
                            Recuperar
                        </a>

                        <a 
                        href="<?php echo site_url('admin/medidas/'); ?>" 
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