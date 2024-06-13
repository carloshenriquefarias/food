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
                    <h4 class="card-title"><?php echo esc($usuario->nome)?></h4>
                    
                    <p class="card-text">
                        <strong>Nome:</strong> <?php echo esc($usuario->nome)?>                        
                    </p>

                    <p class="card-text">
                        <strong>Email:</strong> <?php echo esc($usuario->email)?>                        
                    </p>

                    <p class="card-text">
                        <strong>Ativo:</strong> <?php echo ($usuario->ativo ? 'Sim' : 'Não')?>                        
                    </p>

                    <p class="card-text">
                        <strong>Perfil:</strong> <?php echo ($usuario->is_admin ? 'Administrador' : 'Cliente')?>                        
                    </p>

                    <p class="card-text">
                        <strong>Criado:</strong> <?php echo $usuario->criado_em?>                        
                    </p>

                    <p class="card-text">
                        <strong>Atualizado:</strong> <?php echo $usuario->atualizado_em?>                        
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
  <!-- Aqui enviamos para o template principal os scripts -->

<?php echo $this->endSection(); ?>