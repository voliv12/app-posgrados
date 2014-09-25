<!DOCTYPE html>

<html lang="es">

<head>
    <title>Calendario codeigniter</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="http://localhost/posgrados/assets/calendario_ci/css/estilos.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/south-street/jquery-ui.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src=" http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script type="text/javascript" src="http://localhost/posgrados/assets/calendario_ci/js/funciones.js"></script>
</head>

<body>
<?=$calendario?>
<input type="hidden" value="<?=$this->uri->segment(3)?>" class="year" />
<input type="hidden" value="<?=$this->uri->segment(4)?>" class="month" />
</body>
</html>


