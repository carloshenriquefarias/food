<?php echo $this->extend('Admin/layout/principal_autenticacao'); ?>

<?php echo $this->section('titulo'); ?>
  <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>
  <!-- Aqui enviamos para o template principal os estilos -->
<?php echo $this->endSection(); ?>


<?php echo $this->section('conteudo'); ?>
<div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">

              <?php if(session()->has('sucesso')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Perfeito!</strong> <?php echo session('sucesso') ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>

              <?php if(session()->has('info')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                  <strong>Informação!</strong> <?php echo session('info') ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>

              <?php if(session()->has('atencao')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Informação!</strong> <?php echo session('atencao') ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>

              <?php if(session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Erro!</strong> <?php echo session('error') ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>

              <div class="brand-logo">
                <img src=" <?php echo site_url('admin/') ?> images/logo.svg" alt="logo">
              </div>

              <h4>Bem vindo ao Food Delivery!</h4>

              <h6 class="font-weight-light">Para continuar, por favor insira suas credenciais!</h6>

              <?php echo form_open('login/criar') ?>
                <div class="form-group mt-3">
                  <label for="exampleInputEmail">E-mail</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="email" name="email" value=" <?php echo old('email') ?>" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Digite seu email">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Digite sua senha">                        
                  </div>
                </div>

                <div class="my-2 d-flex justify-content-between align-items-center">
                  
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>

                <div class="my-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Entrar</button>
                </div>

                <div class="mb-2 d-flex">
                  <button type="button" class="btn btn-facebook auth-form-btn flex-grow mr-1">
                    <i class="mdi mdi-facebook mr-2"></i>Facebook
                  </button>
                  <button type="button" class="btn btn-google auth-form-btn flex-grow ml-1">
                    <i class="mdi mdi-google mr-2"></i>Google
                  </button>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Ainda não tem uma conta? <a href="<?php echo site_url('registrar') ?>" class="text-primary">Criar conta</a>
                </div>
              <?php echo form_close() ?>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2020  All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
  <!-- Aqui enviamos para o template principal os scripts -->
<?php echo $this->endSection(); ?>

