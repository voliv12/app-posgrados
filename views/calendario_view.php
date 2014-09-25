<!DOCTYPE html>

<html lang="es">

<head>
    <title>Calendario codeigniter</title>
    <meta charset="utf-8" />
     <base href= "<?php echo $this->config->item('base_url'); ?>">
    <link href="assets/calendario_ci/css/estilos.css" rel="stylesheet" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/south-street/jquery-ui.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src=" http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>   
    <script src="assets/calendario_ci/js/funciones.js" type="text/javascript"></script>
</head>

<body>
<?=$calendario?>
<input type="hidden" value="<?=$this->uri->segment(3)?>" class="year" />
<input type="hidden" value="<?=$this->uri->segment(4)?>" class="month" />
</body>
</html>


