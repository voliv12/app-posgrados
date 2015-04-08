<div class="row">
<div class="container well">
        <h1><a>Menú principal</a></h1>
        <i class="icon-arrow-down"></i> Seleccione una Opción.
</div>
<div class="container well">
    <div class="row">
        <p>
        <div class="span6"><a href="cvu_alumnosDirectivos/datos_personales/registroAlumno" class="btn btn-block"><i class="icon-list"></i> Consulta de CVU de Alumnos</a></div>
        <div class="span6"><a href="evencal" class="btn btn-block"><i class="icon-bullhorn"></i> Calendarización de Eventos</a></div>
        </p>
    </div>
</div>

<div class="container well">
    <div class="row">
        <p>             
        <div class="span6"><a href="curso/cursos/registrocurso" class="btn btn-block"><i class="icon-list-alt"></i> Cursos</a></div>
        <div class="span6"><a href="curso/alumno_cursos/registro_alumnocurso" class="btn btn-block"><i class="icon-list-alt"></i> Registro alumnos a curso</a></div>
        </p>
    </div>
    <?php if ($this->session->userdata('perfil') <> 'DCS') { ?>
               <div class="row">    
                    <p>             
                    <div class="span6"><a href="personal/ingreso_posgrados/alumno_posgrdo" class="btn btn-block"><i class="icon-pencil"></i> Ingresar alumnos a Maestría</a></div>
                    </p>
                </div>
    <?php } else { ?>

                <div class="row">    
                    <p>             
                    <div class="span6"><a href="personal/ingreso_posgrados/alumno_posgrdod" class="btn btn-block"><i class="icon-pencil"></i> Ingresar alumnos a Doctorado</a></div>
                    </p>
                </div>
    <?php } ?>
   
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
</div>