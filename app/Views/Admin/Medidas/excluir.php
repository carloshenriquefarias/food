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
                    
                    <?php echo form_open('admin/medidas/excluir/'. $medida->id, ['method' => 'post']); ?>

                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Atenção!</strong> Deseja realmente excluir esta medida <?php echo esc($medida->nome) ?>?
                        </div>
                        
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="mdi mdi-trash-can btn-icon-prepend"></i>
                            Excluir   
                        </button>

                        <button class="btn btn-light btn-sm">
                            <a href="<?php echo site_url('admin/medidas/show/'.$medida->id); ?>">
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