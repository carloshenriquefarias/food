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
                    <?php if (session()->has('errors_model')): ?>
                        <ul>
                            <?php foreach (session('errors_model') as $error): ?>
                                <li class="text-danger"><?php echo esc($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <h4 class="card-title"><?php echo esc($titulo)?></h4>  
                    
                    <?php echo form_open('admin/produtos/atualizar/' . $produto->id, ['method' => 'post']); ?>
                        <?php echo $this->include('Admin/Produtos/form'); ?>

                        <button class="btn btn-light btn-sm">
                            <a href="<?php echo site_url('admin/produtos/show/'.$produto->id); ?>">
                                <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                                Cancelar
                            </a>  
                        </button>
                        
                    <?php echo form_close(); ?>
                                
                </div>         
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
    <script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js')?>"></script>
    <script src="<?php echo site_url('admin/vendors/mask/app.js')?>"></script>
<?php echo $this->endSection(); ?>