
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo esc($usuario->nome) ?>" placeholder="Nome">
    </div>

    <div class="form-group col-md-2">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?php echo esc($usuario->cpf) ?>" placeholder="CPF">
    </div>

    <div class="form-group col-md-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control sp_celphones" name="telefone" id="telefone" value="<?php echo esc($usuario->telefone) ?>" placeholder="Telefone">
    </div>

    <div class="form-group col-md-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" value="<?php echo esc($usuario->email) ?>" placeholder="Email">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="password">Senha</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
    </div>

    <div class="form-group col-md-6">
        <label for="password_confirmation">Confirmar senha</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar senha">
    </div>

    <div class="form-group col-md-3">
        <label for="ativo">Perfil de acesso</label>
        <select class="form-control" name="is_admin" id="ativo">
            <?php if ($usuario->id): ?>
                <option value="1" <?php echo $usuario->is_admin ? 'selected' : ''; ?>>
                    Administrador
                </option>
                <option value="0" <?php echo !$usuario->is_admin ? 'selected' : ''; ?>>
                    Cliente
                </option>
            <?php else: ?>
                <option value="1">Sim</option>
                <option value="0" selected="">Não</option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="ativo">Ativo</label>
        <select class="form-control" name="ativo" id="ativo">
            <?php if ($usuario->id): ?>
                <option value="1" <?php echo $usuario->ativo ? 'selected' : ''; ?>>
                    Sim
                </option>
                <option value="0" <?php echo !$usuario->ativo ? 'selected' : ''; ?>>
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

<button class="btn btn-light btn-sm">
    <a href="<?php echo site_url('admin/usuarios/show/'.$usuario->id); ?>">
        <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
        Cancelar
    </a>  
</button>