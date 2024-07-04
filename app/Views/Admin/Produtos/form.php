
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo old('nome', esc($produto->nome)) ?>" placeholder="Nome">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="ingredientes">Ingredientes</label>
        <textarea class="form-control" name="ingredientes" rows="5" id="ingredientes" placeholder="Ingredientes"><?php echo old('ingredientes', esc($produto->ingredientes)); ?></textarea>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="categoria">Escolha a categoria</label>
        <select class="form-control" name="categoria_id">
            <option value="">
                Escolha a categoria
            </option>

            <?php foreach ($categorias as $categoria): ?>
                <?php if ($produto->id && $categoria->id == $produto->categoria_id): ?>
                    <option value="<?php echo $categoria->id; ?>" selected>
                        <?php echo esc($categoria->nome); ?>
                    </option>
                <?php else: ?>
                    <option value="<?php echo $categoria->id; ?>">
                        <?php echo esc($categoria->nome); ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-row">

    <div class="form-group col-md-4">
        <label for="ativo">Ativo</label>
        <select class="form-control" name="ativo" id="ativo">
            <?php if ($produto->id): ?>
                <option value="1" <?php echo set_select('ativo', '1'); ?> <?php echo $produto->ativo ? 'selected' : ''; ?> >
                    Sim
                </option>
                <option value="0" <?php echo set_select('ativo', '0'); ?> <?php echo !$produto->ativo ? 'selected' : ''; ?> >
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

