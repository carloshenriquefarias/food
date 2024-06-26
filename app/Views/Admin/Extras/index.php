<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
  <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>
  <!-- Aqui enviamos para o template principal os estilos -->

    <link rel="stylesheet" href="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.css')?>"/>

<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $titulo?></h4>

                <div class="ui-widget">
                    <input id="query" name="query" placeholder="Pesquise por um extra" class="form-control bg-light mb-5"/>
                </div>

                <a href="<?php echo site_url('admin/extras/criar'); ?>" class="btn btn-primary btn-md float-right mr-5 text-white" style="text-decoration: none; color: white;">
                    <i class="mdi mdi-plus btn-icon-prepend" style="color: white;"></i>
                    Criar novo extra
                </a>
                
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data de criação</th>
                            <th>Preço</th>
                            <th>Ativo</th>
                            <th>Situação</th>
                        </tr>
                    </thead>

                    <?php foreach($extras as $extra): ?>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="<?php echo site_url('admin/extras/show/'.$extra->id); ?>">
                                        <?php echo $extra->nome; ?>
                                    </a>                                   
                                </td>

                                <td><?php echo $extra->criado_em->humanize() ?></td>
                                <td>R$ <?php echo esc(number_format($extra->preco, 2, ',', '.')); ?></td>

                                <td>
                                    <?php 
                                        echo ($extra->ativo && $extra->deletado_em === null ? '<label class="badge badge-primary">Sim</label>' : '<label class="badge badge-danger">Não</label>') 
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        echo ($extra->deletado_em == null ? '<label class="badge badge-primary">Disponivel</label>' : '<label class="badge badge-danger">Excluido</label>') 
                                    ?>

                                    <?php if ($extra->deletado_em !== null): ?>
                                        <a href="<?php echo site_url('admin/extras/desfazerexclusao/' . $extra->id); ?>" class="badge badge-dark ml-2" style="text-decoration: none;">
                                            <i class="mdi mdi-undo btn-icon-prepend"></i>
                                            Recuperar
                                        </a>
                                    <?php endif; ?>                                                                                                                                  
                                </td>
                            </tr>
                        </tbody>
                    <?php endforeach ?>

                </table>

                <div class="card-body" style="display: flex; justify-content: center;">
                    <div class="mt-3">
                        <?php echo $pager->links(); ?>
                    </div>
                </div>


                </div>
            </div>
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
  <!-- Aqui enviamos para o template principal os scripts -->
    <script src="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.js')?>"></script>

    <script src="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.js')?>"></script>
    <script>
        $(function() {
            $("#query").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "<?php echo site_url("admin/extras/procurar")?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            if(data.length < 1){
                                data = [{
                                    label: "extra não encontrada",
                                    value: -1
                                }];
                            }
                            response(data);
                        },
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    if(ui.item.value == -1) {
                        $(this).val('');
                        return false;
                    } else {
                        window.location.href = "<?php echo site_url("admin/extras/show")?>/" + ui.item.id;
                    }
                }
            });
        });
    </script>

<?php echo $this->endSection(); ?>