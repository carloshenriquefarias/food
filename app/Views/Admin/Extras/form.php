
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo old('nome', esc($extra->nome)) ?>" placeholder="Nome">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="descricao">Descrição</label>
        <textarea class="form-control" name="descricao" rows="5" id="descricao" placeholder="Descrição"><?php echo old('descricao', esc($extra->descricao)); ?></textarea>
    </div>
</div>

<div class="form-row">

    <div class="form-group col-md-4">
        <label for="ativo">Ativo</label>
        <select class="form-control" name="ativo" id="ativo">
            <?php if ($extra->id): ?>
                <option value="1" <?php echo set_select('ativo', '1'); ?> <?php echo $extra->ativo ? 'selected' : ''; ?> >
                    Sim
                </option>
                <option value="0" <?php echo set_select('ativo', '0'); ?> <?php echo !$extra->ativo ? 'selected' : ''; ?> >
                    Não
                </option>
            <?php else: ?>
                <option value="1">Sim</option>
                <option value="0" selected="">Não</option>
            <?php endif; ?>
        </select>
    </div>

</div>

<button type="submit" class="btn btn-primary btn-sm">
    <i class="mdi mdi-store btn-icon-prepend"></i>
    Salvar   
</button>

