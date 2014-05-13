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
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">


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
              <i class="icon-user"></i> <?php
                                            //$this->load->helper('text');
                                            //$count = count(explode(" ", $this->session->userdata('nombre')));
                                            //echo word_limiter($this->session->userdata('nombre'), $count - 1, " ");
                                            echo $this->session->userdata('nombre');
                                        ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">

              <li class="disabled"><a><?php echo $this->session->userdata('matricula'); ?></a></li>
              <li class="divider"></li>
               <!-- Button trigger modal -->
              <li><a data-toggle="modal" href="#myModal">Cambiar contraseña</a></li>
              <li><a href="salir">Cerrar sesión</a></li>
            </ul>
          </div>

          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </div>
          <!--<div class="nav-collapse">
            <ul class="nav">
              <li class="active divider-vertical"><a href="#">Inicio</a></li>
              <li class="divider-vertical"><a href="#contact">Contacto</a></li>

            </ul>
          </div>-->
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