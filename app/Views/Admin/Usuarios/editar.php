<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
  <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo esc($titulo)?></h4>       
                    
                    <form class="forms-sample">
                        <?php echo $this->include('Admin/Usuarios/form'); ?>
                    </form>                                       
                </div>         
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
    <script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js')?>"></script>
    <script src="<?php echo site_url('admin/vendors/mask/app.js')?>"></script>
<?php echo $this->endSection(); ?>