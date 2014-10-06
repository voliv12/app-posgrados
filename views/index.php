<html lang="es">
<head>
	<meta charset="utf-8">
	<base href= "<?php echo $this->config->item('base_url'); ?>"/>
	<title>Calendario de Eventos</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="../assets/css/colorbox.css"/>
	<script type="text/javascript" src="../assets/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.colorbox-min.js"></script>
	<style type="text/css">h1{background:#F2F2F2}</style>
</head>
<body>
	<h1><font color=#6E6E6E face="times new roman">Calendario de Eventos de Maestría y Doctorado del ICS </font></h1>
	
	<?php if ($this->session->userdata('tipo_usuario') == 'alumno')
			{
			echo '<div style="width:100%; text-align:center; padding-left: 40%;" class="span6"><a href="principal" class="menuprincipal"> Menú Principal</a></div></div>';
			}
		  elseif (($this->session->userdata('tipo_usuario') == 'personal') || ($this->session->userdata('perfil') == 'directivo' ))
				{
				echo '<div style="width:100%; text-align:center; padding-left: 40%;" class="span6"><a href="directivo" class="menuprincipal"> Menú Principal</a></div></div>';
				}
				else {
					 echo '<div style="width:100%; text-align:center; padding-left: 40%;" class="span6"><a href="administrativo" class="menuprincipal"> Menú Principal</a></div></div>';
					 }
			   
	?>

	<div id="evencal">
		<div class="calendar">
			<?php echo $notes?>
			<!--span>by <a href="http://zawaruddin.blogspot.com"><strong>zawaruddin.blogspot.com</strong></a></span-->
		</div>
		<div class="event_detail">
			<h3 class="s_date">Detalles del Evento <?php echo "$day $month $year";?></h3>
			<div class="detail_event">
				<?php
					if(isset($events)){
						$i = 1;
						foreach($events as $e){
						 if($i % 2 == 0){
								echo '<div class="info1"><h4>'.$e['time'].'<img src="'.base_url().'../assets/css/images/delete.png" class="delete" alt="" title="Eliminar este evento="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'</p></div>';
							}else{
								echo '<div class="info2"><h4>'.$e['time'].'<img src="'.base_url().'../assets/css/images/delete.png" class="delete" alt="" title="Eliminar este evento" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'</p></div>';
							}
							$i++;
						}
					}else{
						echo '<div class="message"><h4>No Existe Evento</h4><p>No hay eventos en esta fecha</p></div>';
					}
				?>
				<input type="button" name="add" value="Agregar Evento" val="<?php echo $day;?>" class="add_event"/>
			</div>
		</div>
	</div>

	<script>
		$(".detail").live('click',function(){
			$(".s_date").html("Detalles del Evento "+$(this).attr('val')+" <?php echo "$month $year";?>");
			var day = $(this).attr('val');
			var add = '<input type="button" name="add" value="Agregar Evento" val="'+day+'" class="add_event"/>';
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: "<?php echo site_url("evencal/detail_event");?>",
				data:{<?php echo "year: $year, mon: $mon";?>, day: day},
				success: function( data ) {
					var html = '';
					if(data.status){
						var i = 1;
						$.each(data.data, function(index, value) {
						    if(i % 2 == 0){
								html = html+'<div class="info1"><h4>'+value.time+'<img src="<?php echo base_url();?>../assets/css/images/delete.png" class="delete" alt="" title="Eliminar este evento" day="'+day+'" val="'+value.id+'" /></h4><p>'+value.event+'</p></div>';
							}else{
								html = html+'<div class="info2"><h4>'+value.time+'<img src="<?php echo base_url();?>../assets/css/images/delete.png" class="delete" alt="" title="Eliminar este evento" day="'+day+'" val="'+value.id+'" /></h4><p>'+value.event+'</p></div>';
							}
							i++;
						});
					}else{
						html = '<div class="message"><h4>'+data.title_msg+'</h4><p>'+data.msg+'</p></div>';
					}
					html = html+add;
					$( ".detail_event" ).fadeOut("slow").fadeIn("slow").html(html);
				}
			});
		});

<?php if ($this->session->userdata('tipo_usuario') != 'alumno'){ ?>
		$(".delete").live("click", function() {
			if(confirm('¿Esta seguro de eliminar este evento?')){
				var deleted = $(this).parent().parent();
				var day =  $(this).attr('day');
				var add = '<input type="button" name="add" value="Agregar Evento" val="'+day+'" class="add_event"/>';
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: "<?php echo site_url("evencal/delete_event");?>",
					data:{<?php echo "year: $year, mon: $mon";?>, day: day,del: $(this).attr('val')},
					success: function(data) {
						if(data.status){
							if(data.row > 0){
								$('.d'+day).html(data.row);
							}else{
								$('.d'+day).html('');
								$( ".detail_event" ).fadeOut("slow").fadeIn("slow").html('<div class="message"><h4>'+data.title_msg+'</h4><p>'+data.msg+'</p></div>'+add);
							}
							deleted.remove();
						}else{
							alert('error al eliminar este evento');
						}
					}
				});
			}
		});
		$(".add_event").live('click', function(){
			$.colorbox({
					overlayClose: false,
					href: '<?php echo site_url('evencal/add_event');?>',
					data:{year:<?php echo $year;?>,mon:<?php echo $mon;?>, day: $(this).attr('val')}
			});
		});

<?php } ?>
	</script>
</body>
</html>