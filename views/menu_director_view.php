<div class="row">
<div class="container well">
        <h1><a>Menú principal</a></h1>
        <i class="icon-arrow-down"></i> Seleccione una Opción.
</div>

<div class="container well">
    <h4><a>Administración de Alumnos y Cursos </a></h4>
        <div class="row">
            <p>
            <!--div class="span6"><a href="personal/control_alumnos/registrar_alumno" class="btn btn-block"><i class="icon-pencil"></i> Registro de Alumnos</a></div-->
            <div class="span6"><a href="personal/ingreso_posgrados/alumno_posgrado" class="btn btn-block"><i class="icon-pencil"></i> Alumnos Posgrado</a></div> 
            <div class="span6"><a href="cvu_alumnosDirectivos/datos_personales/registroAlumno" class="btn btn-block"><i class="icon-search"></i> Consulta de CVU de Alumnos</a></div>
               
            </p>
        </div>

        <div class="row">
            <p>
            <div class="span6"><a href="curso/cursos/registrocurso_admin/todas/todos" class="btn btn-block"><i class="icon-list-alt"></i> Programación de Cursos</a></div>
            <div class="span6"><a href="curso/cursos_alumno/alumnos" class="btn btn-block"><i class="icon-search"></i> Consultar Cursos por Alumno </a></div>
            <!--div class="span6"><a href="cvu_alumnosDirectivos/datos_personales/registroAlumno" class="btn btn-block"><i class="icon-search"></i> Consulta de CVU de Alumnos</a></div-->
            <!--div class="span6"><a href="curso/alumno_cursos/registro_alumnocurso" class="btn btn-block"><i class="icon-list-alt"></i> Ingresar alumnos a Cursos</a></div-->
            </p>
        </div>
</div>


<div class="container well">
    <h4><a>Posgrados</a></h4>
        <div class="row">
            <p>
            <div class="span6"><a data-toggle="modal" href="#myModal2"  class="btn btn-block"><i class="icon-ok"></i> Eficiencia Terminal</a></div>            
            </p>
        </div>

</div>





<div class="container well">
    <h4><a>Control de Proyectos</a></h4>
    <div class="row">
        <p>
        <div class="span6"><a href="proyectos/proyecto_alumno/registro_proyectos" class="btn btn-block"><i class="icon-search"></i> Consulta de Proyectos del Posgrado</a></div>
        <div class="span6"><a href="proyectos/proyecto_alumno/registro_proyecto_direccion" class="btn btn-block"><i class="icon-briefcase"></i> Proyectos Personales</a></div>
    </p>
    </div>
        <div class="row">
        <p>
        <div class="span6"><a href="proyectos/proyectos_academico/academicos" class="btn btn-block"><i class="icon-briefcase"></i> Proyectos por Académico</a></div>
        <!--div class="span6"><a href="proyectos/fecha_anexos/registro_fechas" class="btn btn-block"><i class="icon-calendar"></i>  Establecer Fecha  de Anexos</a></div-->
    </p>
    </div>

</div>
<!--div class="container well">
    <h4><a>Académicos</a></h4>
        <div class="row">
            <p>
            <div class="span6"><a href="curso/nab/registroNab" class="btn btn-block"><i class="icon-user"></i> Plantilla Académica</a></div>
            </p>
        </div>
</div-->

<div class="container well">
    <h4><a>Calendario</a></h4>
    <div class="row">
        <p>
        <div class="span6"><a href="http://www.uv.mx/ics/general/agenda-ics/" class="btn btn-block" target="_blank"><i class="icon-bullhorn"></i> Calendarización de Eventos</a></div>
        </p>
    </div>
</div>


<div class="container well">
    <h4><a>PIFI</a></h4>
        <div class="row">
            <p>
            <div class="span6"><a href="pifi/dbecapifi/registrobeca" class="btn btn-block"><i class="icon-list-alt"></i> Becas</a></div>
            <div class="span6"><a href="pifi/degresadopifi/registroegresado" class="btn btn-block"><i class="icon-user"></i> Egresados</a></div>
            </p>
        </div>

</div>

<?php
  $opt_pos = array(
                'MCS' => 'Maestría en Ciencias de la Salud',
                'DCS' => 'Doctorado en Ciencias de la Salud',
                'MPICD'=>'Maestría en Prevención Integral del Consumo de Drogas',
                );

  $opt_gen = array(
                  
                  '2015' => '2015',
                  '2014' => '2014',
                  '2013' => '2013',
                  '2012' => '2012',
                );

?>





   <div id="myModal2" class="modal hide fade in" style="display: none;">
      <div class="modal-header">
          <a data-dismiss="modal" class="close">×</a>
          <h3>Calcular Eficiencia Terminal</h3>
       </div>
       <div class="modal-body">
           <form action="calcular_et" method="POST">
               
            <?php if(($this->session->userdata('perfil') == "Administrador del Sistema") || ($this->session->userdata('perfil') == "Apoyo Administrativo") || ($this->session->userdata('perfil') == "Director Instituto")){
                echo "Posgrado: ".form_dropdown('posgrado', $opt_pos)."</br>";
            } ?>
            Generación: <?php echo form_dropdown('generacion', $opt_gen)."</br>"; ?>
            



           <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Calcular</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

           </div>
          </form>
      </div>
  </div>




</div>