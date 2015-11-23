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
<div id= "titulo" class="container-fluid">
        <h4><a><?php echo $titulo_tabla; ?></a></h4>
</div>

<div class="alert alert-warning" role="alert" ><?php echo $nota; ?></div>

    <div>
		<?php echo $output; ?>
    </div>

</html>
