<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Food Delivery |  <?php echo $this->renderSection('titulo') ?> </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo site_url('admin/')?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo site_url('admin/')?>vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->

    <link rel="stylesheet" href="<?php echo site_url('admin/')?>css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo site_url('admin/')?>images/favicon.png" />

    <!-- Esta section renderizara os estilos especificos da view que estender este layout -->
    <?php echo $this->renderSection('estilos') ?>
    <link rel="shortcut icon" href="../../images/favicon.png" />
</head>

<body>
  <div class="container-scroller">

    <!-- Esta section renderizara os conteudos especificos da view que estender este layout -->
    <?php echo $this->renderSection('conteudo') ?>

    
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src=" <?php echo site_url('admin/')?> vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?php echo site_url('admin/')?>  js/off-canvas.js"></script>
  <script src="<?php echo site_url('admin/')?>  hoverable-collapse.js"></script>
  <script src="<?php echo site_url('admin/')?>  js/template.js"></script>
  <!-- endinject -->
</body>

</html>
