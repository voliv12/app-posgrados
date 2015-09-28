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
<ol style="float:right;" class="breadcrumb"  >
    <?php echo $boton_imprimir; ?>

</ol>
<div id= "titulo" class="container-fluid">
        <a><?php echo $titulo_tabla; ?></a>
</div>

    <div>
		<?php echo $output; ?>
    </div>
    <div id= "firma" class="container-fluid" style="visibility:hidden" >
    	<h4><a><?php echo $firmas; ?></a></h4>
    </div>

</html>
