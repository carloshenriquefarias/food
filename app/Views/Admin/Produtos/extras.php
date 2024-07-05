<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
  <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>
    <link rel="stylesheet" href="<?php echo site_url('admin/vendors/select2/select2.min.css'); ?>">
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
                    
                    <?php echo form_open('admin/produtos/cadastrarextras/' . $produto->id, ['method' => 'post']); ?>

                        <div class="form-group col-md-6">
                            <label>Escolha os extras do produto (OPCIONAL)</label>
                            <select class="form-control js-example-basic-single" name="extra_id">
                                <option value="">Escolha...</option>
                                <?php foreach ($extras as $extra): ?>
                                    <option value="<?php echo $extra->id; ?>">
                                        <?php echo esc($extra->nome); ?>
                                    </option>
                                <?php endforeach; ?>                                    
                            </select>
                        </div>

                        <div class="form-row col-md-6">
                            <?php if(!empty($produtosExtras)): ?>
                                <p>Nenhum extra encontrado para este produto</p>
                                <?php else: ?>
                            <?php endif ?>
                        </div>
                                   
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-store btn-icon-prepend"></i>
                            Inserir extra no produto  
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
    <script src="<?php echo site_url('admin/vendors/select2/select2.min.js')?>"></script>
   
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: 'Digite o nome do extra',
                allowClear: false,
                language: {
                    noResults: function() {
                        return "Nenhum extra encontrado&nbsp;&nbsp;<a class='btn btn-primary btn-sm' href='<?php echo site_url('admin/extras/criar'); ?>'>Cadastrar</a>";
                    }
                },
                escapeMarkup: function (markup) {
                    return markup; // Permite HTML no resultado
                },
            });
        });
    </script>


<?php echo $this->endSection(); ?>