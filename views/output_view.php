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
<style type='text/css'>

</style>
</head>

<?php echo validation_errors(); ?>

<div class="container well">
        <h3><a><?php echo $titulo_tabla; ?></a></h3>
</div>
<h5><a href="alumno">Regresar a Menú</a></h5>

    <div>
		<?php echo $output; ?>
    </div>

</html>
