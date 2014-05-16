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

<div class="alert alert-success"><h4><?php echo $titulo_tabla; ?></h4></div>
    <div>
		<?php echo $output; ?>
    </div>

</html>
