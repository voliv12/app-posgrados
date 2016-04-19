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
                '201601' => '201701: Ago 2016 - Ene 2017',
                '201651' => '201651: Febrero - Julio 2016',
				        '201601' => '201601: Ago 2015 - Ene 2016',
				        '201551' => '201551: Febrero - Julio 2015',
                '201501' => '201501: Ago 2014 - Ene 2015',
				        '201451' => '201451: Febrero - Julio 2014',
                '201401' => '201401: Ago 2013 - Ene 2014',
                '201351' => '201351: Febrero - Julio 2013',
                '201301' => '201301: Ago 2012 - Ene 2013',
                );

  $opt_pos = array(
                'todos'=>'todos',
                'DCS' => 'Doctorado',
                'MCS' => 'Maestría',
                );
?>

<a data-toggle="modal" href="#FiltroCursos"><i class="icon-search"></i> Filtro combinado</a>

<!--#######################Modal para filtrar################################-->
   <div id="FiltroCursos" class="modal hide fade in" style="display: none;">
      <div class="modal-header">
          <a data-dismiss="modal" class="close">×</a>
          <h3>Filtrar Cursos</h3>
       </div>
       <div class="modal-body">
           <form  role="form" action="curso/filtro_cursos/filtrar" method="POST">
            <?php if(($this->session->userdata('perfil') == "Administrador del Sistema") || ($this->session->userdata('perfil') == "Apoyo Administrativo") || ($this->session->userdata('perfil') == "Director Instituto")){
                echo "Posgrado: ".form_dropdown('posgrado', $opt_pos)."</br>";
            } ?>
            Generación: <?php echo form_dropdown('generacion', $opt_gen)."</br>"; ?>
            Periodo:  <?php echo form_dropdown('periodo', $opt_per)."</br>"; ?>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Buscar</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
      </div>
  </div>
<!--#######################################################-->


<!--form  role="form" action="curso/cursos/registrocurso" method="POST"-->


</div>

    <div>
		<?php echo $output; ?>
    </div>

</html>
