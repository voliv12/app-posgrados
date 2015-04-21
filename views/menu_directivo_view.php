<div class="row">
<div class="container well">
        <h1><a>Menú principal</a></h1>
        <i class="icon-arrow-down"></i> Seleccione una Opción.
</div>

<div class="container well">
    <h4><a>Administración de Alumnos y Cursos </a></h4>
        <div class="row">
            <p>
                <div class="span6"><a href="personal/control_alumnos/registrar_alumno" class="btn btn-block"><i class="icon-pencil"></i> Registro de Alumnos</a></div>
                <div class="span6"><a href="curso/cursos/registrocurso" class="btn btn-block"><i class="icon-list-alt"></i> Programación de Cursos</a></div>
            </p>
        </div>

        <div class="row">
            <p>
            <?php if ($this->session->userdata('perfil') <> 'DCS') { ?>
                                <div class="span6"><a href="personal/ingreso_posgrados/alumno_posgrdo" class="btn btn-block"><i class="icon-pencil"></i> Ingresar alumnos a Maestría</a></div>
            <?php } else { ?>
                            <div class="span6"><a href="personal/ingreso_posgrados/alumno_posgrdod" class="btn btn-block"><i class="icon-pencil"></i> Ingresar alumnos a Doctorado</a></div>
            <?php } ?>
            <div class="span6"><a href="curso/alumno_cursos/registro_alumnocurso" class="btn btn-block"><i class="icon-list-alt"></i> Ingresar alumnos a Cursos</a></div>
            </p>
        </div>

        <div class="row">
        <p>
        <div class="span6"><a href="cvu_alumnosDirectivos/datos_personales/registroAlumno" class="btn btn-block"><i class="icon-list"></i> Consulta de CVU de Alumnos</a></div>
        </p>
    </div>

</div>

<div class="container well">
    <h4><a>Núcleo Académico Básico (NAB)</a></h4>
        <div class="row">
            <p>
            <div class="span6"><a href="curso/nab/registroNab" class="btn btn-block"><i class="icon-user"></i> Núcleo Académico Básico</a></div>
            </p>
        </div>
</div>

<div class="container well">
    <h4><a>Calendario</a></h4>
    <div class="row">
        <p>
        <div class="span6"><a href="evencal" class="btn btn-block"><i class="icon-bullhorn"></i> Calendarización de Eventos</a></div>
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
</div>