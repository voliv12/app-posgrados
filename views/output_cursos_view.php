<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

</head>

<?php echo validation_errors(); ?>
<ol class="breadcrumb">
 	<?php echo $barra_navegacion; ?>
</ol>
<div class="container-fluid">
        <h4><a><?php echo $titulo_tabla; ?></a></h4>
</div>

<div style="width:100%;text-align:center;margin-left:0%;margin-top:0%">
<?php
	$opt_gen = array(
                  'todas' => "Todas",
                  '4' => '2015',
                  '3' => '2014',
                  '2' => '2013',
                  '1' => '2012',
                );

	$opt_per = array(
				        'todos'  => 'Todos los periodos',
				        '201601' => '201601: Ago 2015 - Ene 2016',
				        '201551' => '201551: Febrero - Julio 2015',
                '201501' => '201501: Ago 2014 - Ene 2015',
				        '201451' => '201451: Febrero - Julio 2014',
                '201401' => '201401: Ago 2013 - Ene 2014',
                '201351' => '201351: Febrero - Julio 2013',
                '201301' => '201301: Ago 2012 - Ene 2013',
                );

  $opt_pos = array(
                'DCS' => 'Doctorado',
                'MCS' => 'Maestría',
                );
?>

<!--form  role="form" action="curso/cursos/registrocurso" method="POST"-->
<form  role="form" <?php echo $action; ?> method="POST">
    <?php if(($this->session->userdata('perfil') == "Administrador") || ($this->session->userdata('perfil') == "Administrativo")){
            echo "Posgrado: ".form_dropdown('posgrado', $opt_pos);
    } ?>

    Generación: <?php echo form_dropdown('generacion', $opt_gen); ?>
    Periodo:	<?php echo form_dropdown('periodo', $opt_per); ?>

        <button type="submit" class="btn btn-default">Buscar</button>
</form>
</div>

    <div>
		<?php echo $output; ?>
    </div>

</html>