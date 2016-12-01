<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cursos extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        $this->load->model('usuarios_model');
    }
    function registrocurso($gen=null, $per=null)
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('cursos.posgrado', $this->session->userdata('abrev_posgrado'));
            if($gen != "todas"){
                $crud->where('cursos.generacion', $gen);
            }
            if($per != "todos"){
                $crud->where('cursos.periodo', $per);
            }
            $crud->set_table('cursos');
            $crud->set_subject('curso');

            $crud->display_as('codigo','Experiencia Educativa')
                 ->display_as('nombre_curso','Nombre del Curso')
                 ->display_as('academico_NAB','Académico')
                 ->display_as('horas','Horas p/semana')
                 ->display_as('personalext','Académico Externo')
                 ->display_as('dia','Dia(s)')
                 ->display_as('generacion','Generación');
            $crud->set_relation('codigo','documentando','{codigo}  -  {descripcion}',array('nivelacad' => $this->session->userdata('abrev_posgrado')));
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->set_relation('generacion','cat_generacion','generacion',null,'generacion DESC');
            $crud->unset_print();
            //$crud->field_type('NRC', 'readonly');
            $crud->field_type('posgrado','hidden', $this->session->userdata('abrev_posgrado'));
            $crud->field_type('horas','dropdown',range(1,20));
            $crud->set_relation_n_n('academico_NAB', 'nab_cursos', 'personal', 'idcurso', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('tipo_personal' => 'Académico'));
            $crud->set_relation_n_n('alumnos', 'alumno_cursos', 'alumno', 'idcurso', 'idalumno', '{NombreA} {ApellidoPA} {ApellidoMA}', 'priority',array('posgrado' => $this->session->userdata('abrev_posgrado')));
            $crud->columns('generacion','periodo','codigo','NRC','nombre_curso','academico_NAB');
            $crud->required_fields('generacion','periodo', 'codigo','horas','fecha_inicio','fecha_fin');
            $crud->field_type('dia','multiselect',
                    array( "Lunes"=>"Lunes","Martes"=>"Martes","Miércoles"=>"Miércoles","Jueves"=>"Jueves","Viernes"=>"Viernes","Sábado"=>"Sábado","Domingo"=>"Domingo"));
            $crud->callback_add_field('hora_inicio',array($this,'hora_inicio'));
            $crud->callback_add_field('hora_fin',array($this,'hora_fin'));
            $barra = " <li><a href='directivo'>Menú principal</a></li>";
            $crud->callback_before_insert(array($this,'acciones_callback'));
            $crud->callback_before_update(array($this,'acciones_callback'));
            $output = $crud->render();
            $this->_example_output($output,$barra);
        }else{
            redirect('login');
        }
    }

    function registrocurso_admin($gen=null, $per=null, $pos=null)
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            if($gen != "todas"){
                $crud->where('cursos.generacion', $gen);
            }
            if($per != "todos"){
                $crud->where('cursos.periodo', $per);
            }
            if($pos != "todos"){
                $crud->where('cursos.posgrado', $pos);
            }
            if ($this->session->userdata('perfil') == "Director Instituto"){
                $crud->unset_edit();
            }
            $crud->set_table('cursos');
            $crud->set_subject('curso');
            $crud->display_as('codigo','Experiencia Educativa')
                 ->display_as('nombre_curso','Nombre del Curso')
                 ->display_as('academico_NAB','Académico')
                 ->display_as('horas','Horas p/semana')
                 ->display_as('generacion','Generación');
            $crud->set_relation('codigo','documentando','{nivelacad} {codigo} - {descripcion}');
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->set_relation('generacion','cat_generacion','generacion',null,'generacion DESC');
            $crud->set_relation_n_n('academico_NAB', 'nab_cursos', 'personal', 'idcurso', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('tipo_personal' => 'Académico'));
            $crud->set_relation_n_n('alumnos', 'alumno_cursos', 'alumno', 'idcurso', 'idalumno', '{NombreA} {ApellidoPA} {ApellidoMA}', 'priority');
            $crud->columns('generacion','periodo','codigo','NRC','nombre_curso','horas','fecha_inicio','fecha_fin','academico_NAB');
            $crud->unset_print();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->field_type('generacion','readonly');
            $crud->field_type('periodo','readonly');
            $crud->field_type('academico_externo','readonly');
            $crud->field_type('codigo','readonly');
            $crud->field_type('nombre_curso','readonly');
            $crud->field_type('posgrado','readonly');
            $crud->field_type('horas','readonly');
            $crud->field_type('fecha_inicio','readonly');
            $crud->field_type('fecha_fin','readonly');
            $crud->field_type('academico_externo','readonly');
            $crud->field_type('dia','readonly');
            $crud->field_type('hora_inicio','readonly');
            $crud->field_type('hora_fin','readonly');
            $crud->field_type('lugar','readonly');
            $crud->field_type('otro_lugar','readonly');
            $crud->field_type('horas','dropdown',range(1,20));
            $action = 'action="curso/cursos/registrocurso_admin"';
            $output = $crud->render();
            $this->_example_output($output,null);
        }else{
            redirect('login');
        }
    }

    function just_a_test($primary_key , $row)
    {
        return site_url('curso/alumno_cursos/registro_alumnocurso').'?idcurso ='.$row->idcurso;
    }

    function hora_inicio()
    {
        return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" id="hora_inicio" name="hora_inicio" style="width:50px"> (hh:mm) 0-23 hrs.';
    }

    function hora_fin()
    {
        return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" id="hora_fin" name="hora_fin" style="width:50px"> (hh:mm) 0-23 hrs.';
    }

    function acciones_callback($post_array)
    {
        $post_array['nombre_curso'] = strtr(strtoupper($post_array['nombre_curso']),"áéíóúñ","ÁÉÍÓÚÑ");
        $post_array['academico_externo'] = strtr(strtoupper($post_array['academico_externo']),"áéíóúñ","ÁÉÍÓÚÑ");
        return $post_array;
    }

    function _example_output($output = null, $barra = null )
    {
        $output->generaciones = $this->usuarios_model->buscar_generacion();
        $output->periodos = $this->usuarios_model->buscar_periodos();
        $output->posgrados = $this->usuarios_model->buscar_posgrados();
        $output->titulo_tabla = "Programación de Cursos";
        if($this->session->userdata('perfil') == 'Administrador del Sistema')
        {
            $output->barra_navegacion = " <li><a href='administrador'>Menú principal</a></li>";
        } else if($this->session->userdata('perfil') == 'Apoyo Administrativo')
                {
                $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
                }
                    else if($this->session->userdata('perfil') == 'Director Instituto')
                    {
                    $output->barra_navegacion = " <li><a href='director'>Menú principal</a></li>";
                    }
                        else {
                                $output->barra_navegacion = $barra;
                               }
        $datos_plantilla['contenido'] =  $this->load->view('output_cursos_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }
}