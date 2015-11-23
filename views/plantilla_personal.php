<!DOCTYPE html>
<html>
<head>
    <title><?php //echo $titulo; ?>SIP Personal</title>
    <meta charset="utf-8"></meta>
    <title>Sistema de Información de Posgrado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href= "<?php echo $this->config->item('base_url'); ?>">

    <script type='text/javascript' src="../assets/js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.ui.draggable.js"></script>
    <script type="text/javascript" src="../assets/js/DataTables-1.8.1/media/js/jquery.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.jeditable.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.validate.js"></script>
    <script type="text/javascript" src="../assets/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="../assets/js/highcharts.js"></script>
    <script type="text/javascript" src="../assets/js/exporting.js"></script>
    <script type="text/javascript" src="../assets/js/exporting.src.js"></script>

    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-responsive.min.css" >
    <link rel="stylesheet" href="../assets/js/themes/smoothness/jquery-ui-1.8.16.custom.css" type="text/css">
    <link rel="stylesheet" href="../assets/js/themes/base/jquery.ui.base.css" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
      body {
        padding-top: 50px;
        /*background-color: #f5f5f5;*/
      }
    </style>

<script type="text/javascript">
$(document).ready(function()
  {
 //############## Coordinado de posgrado  ###############
        $("#fecha_graduacion_field_box").hide();
    $("#field-estatus").change(function ()
    {
      if($("#field-estatus").val() == "Graduado"){ $("#fecha_graduacion_field_box").show(); }
      else{ $("#fecha_graduacion_field_box").hide(); }
    });


    $("#posgrado_field_box").hide();
    $("#field-perfil").change(function ()
    {
      if($("#field-perfil").val() == "3"){ $("#posgrado_field_box").show(); }
      else{ $("#posgrado_field_box").hide(); }
    });

    $("#nab_field_box").hide();
    $("#field-tipo_personal").change(function ()
    {
      if($("#field-tipo_personal").val() == "Académico"){ $("#nab_field_box").show(); }
      else{ $("#nab_field_box").hide(); }
    });

    $('#save-and-go-back-button').on('click' ,function(){
    if($("#field-tipo_personal").val() == "Administrativo" && $("#field-perfil").val() == "3"){
      alert('Personal Administrativo no puede ser Coordinador de Posgrado');
      window.history.reload();
    }
    });
    $('#form-button-save').on('click' ,function(e){
    if($("#field-tipo_personal").val() == "Administrativo" && $("#field-perfil").val() == "3"){
      alert('Personal Administrativo no puede ser Coordinador de Posgrado');
      e.preventDefault();
      window.history.reload();
    }
    });

    $('#save-and-go-back-button').on('click' ,function(){
    if($("#field-tipo_personal").val() == "Administrativo" && $("#field-perfil").val() == "5"){
      alert('Personal Administrativo no puede ser Académico de Posgrado');
      window.history.reload();
    }
    });
    $('#form-button-save').on('click' ,function(e){
    if($("#field-tipo_personal").val() == "Administrativo" && $("#field-perfil").val() == "5"){
      alert('Personal Administrativo no puede ser Académico de Posgrado');
      e.preventDefault();
      window.history.reload();
    }
    });


 });
</script>

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
              <li><a><i class="icon-barcode"> </i> <?php echo $this->session->userdata('perfil');?></a></li>
              <li class="divider"></li>
              <li><a data-toggle="modal" href="#myModal"><i class="icon-refresh"></i> Cambiar Contraseña</a></li>
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

<!--#######################Modal para cambiar contraseña################################-->
   <div id="myModal" class="modal hide fade in" style="display: none;">
      <div class="modal-header">
          <a data-dismiss="modal" class="close">×</a>
          <h3>Cambio de contraseña</h3>
       </div>
       <div class="modal-body">
           <form action="cambiar_password" method="POST">
               <!--label for="exampleInputEmail1">Nueva contraseña</label-->
               <input type="password" class="form-control" name="password" placeholder="Nueva contraseña"> </br>
               <input type="password" class="form-control" name="passconf" placeholder="Confirme nueva contraseña"></br>
           <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Cambiar</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
           </div>
          </form>
      </div>
  </div>
<!--#######################################################-->

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