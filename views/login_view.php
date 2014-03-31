<!DOCTYPE html>
<html>
  <head>
    <base href= "<?php echo $this->config->item('base_url'); ?>">   
    <meta charset="utf-8">
    <title>Login &middot; Informacion Académica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="VOG" content="">
    
    <script type='text/javascript' src='js/jquery-1.8.2.js'></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>    
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    
    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

      <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Sistema de Información Acdémica</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php echo $this->session->userdata('nombre')?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="disabled"><a>Favor de iniciar sesión</a></li>
              <li class="divider"></li>             
            </ul>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Inicio</a></li>                          
              <li><a href="#contact">Contacto</a></li>           
            </ul>                          
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
<!--#######################################################-->      
      <h3 class="muted"> &nbsp; </h3>
    <div class="container">

      <form class="form-signin" action="login/validar_usuario" method="POST">       
        
          <h4 class="form-signin-heading">Autentificación</h4>
        <input type="text" name="noPersonal" class="input-block-level" placeholder="Número de personal">
        <input type="password" name="password" class="input-block-level" placeholder="Contraseña">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Recordarme
        </label>        
        <button class="btn btn-large btn-primary" type="submit">Entrar</button>
      </form>
        
      <hr>
      <div class="container-fluid">                     
             <?php echo $contenido; ?>                                   
     </div>
        
    </div> <!-- /container -->   
  </body>
</html>