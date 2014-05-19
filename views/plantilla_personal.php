<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titulo; ?></title>
    <meta charset="utf-8"></meta>
    <title>Sistema de Información de Posgrado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href= "<?php echo $this->config->item('base_url'); ?>">

    <script src="assets/jquery-1.8.2.js" type="text/javascript"></script>
    <script src="assets/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>

    <script src="assets/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <link href=" assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href=" assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>

    <style>
      body {
        padding-top: 50px;
        /*background-color: #f5f5f5;*/
      }
    </style>
</head>
<body>
<div class="container">
     <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn-inverse btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#"><strong>Instituto de Ciencias de la Salud - Sistema de Información de Posgrados</strong></a>

          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i>
              <?php echo $this->session->userdata('nombre');?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a><i class="icon-barcode"> </i> <?php echo "Perfil ".$this->session->userdata('perfil');?></a></li>
              <li class="divider"></li>
              <li><a href="#"><i class="icon-refresh"></i> Cambiar Contraseña</a></li>
              <li class="divider"></li>
              <li><a href="salir"><i class="icon-off"></i> Cerrar sesión</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

</div>
<!-- End Topbar
================================================== -->

              <div class="container">
                <?php echo $contenido; ?>




<div class="footer">
<blockquote>
  <p>Instituto de Ciencias de la Salud</p>
  <small>UV -  <?php echo date('Y');?></cite>
  </small>
</blockquote>
</div>
    </div>

</body>
</html>