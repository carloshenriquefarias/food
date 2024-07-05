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
                    
                    <?php echo form_open_multipart('admin/produtos/upload/' . $produto->id, ['method' => 'post']); ?>     
                        
                        <div class="form-group">
                            <label>Mude aqui a imagem do seu produto</label>
                            <input type="file" name="foto_produto" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Escolha uma imagem">
                                <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-store btn-icon-prepend"></i>
                            Atualizar imagem   
                        </button>

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
    <script src="<?php echo site_url('admin/js/file-upload.js')?>"></script>
<?php echo $this->endSection(); ?>
