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
        //$this->matricula = $this->session->userdata('matricula');
    }

    function registrocurso()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('posgrado', $this->session->userdata('perfil'));
            $crud->set_table('cursos');
            $crud->set_subject('curso');
            $crud->display_as('codigo','Experiencia Educativa')
                 ->display_as('nombre_curso','Nombre del Curso')
                 ->display_as('nab_numpersonal','Académico NAB')
                 ->display_as('horas','Horas p/semana')
                 ->display_as('personalext','Académico Externo');
            $crud->set_relation('codigo','documentando','{nivelacad}  -  {descripcion}',array('nivelacad' => $this->session->userdata('perfil')));
            $crud->unset_print();
            $crud->unset_export();
            //$crud->unset_edit_fields();
            $crud->field_type('NRC', 'hidden');
            //$crud->field_type('nrc','invisible');
            $crud->field_type('posgrado','hidden', $this->session->userdata('perfil'));
            $crud->field_type('horas','dropdown',range(1,20));
            $crud->set_relation_n_n('academico_NAB', 'nab_cursos', 'nab', 'idcurso', 'numpersonal', '{nab.numpersonal} - {nab.nompersonal}', 'priority');
            $crud->set_relation_n_n('alumnos', 'alumno_cursos', 'alumno', 'idcurso', 'idalumno', '{NombreA} {ApellidoPA} {ApellidoMA}', 'priority');
            $crud->field_type('periodo', 'dropdown',  array('201401' => 'Agosto 2013 - Enero 2014',
                                                            '201451' => 'Febrero - Julio 2014',
                                                            '201501' => 'Agosto 2014 - Enero 2015' ,
                                                            '201551' => 'Febrero - Julio 2015',
                                                            '201601' => 'Agosto 2015 - Enero 2016',
                                                            '201651' => 'Febrero - Julio 2016',
                                                            '201701' => 'Agosto 2016 - Enero 2017',
                                                            '201751' => 'Febrero - Julio 2017',
                                                            '201801' => 'Agosto 2017 - Enero 2018',
                                                            '201851' => 'Febrero - Julio 2018',
                                                            '201901' => 'Agosto 2018 - Enero 2019',
                                                            '201951' => 'Febrero - Julio 2019',
                                                            '202001' => 'Agosto 2019 - Enero 2020',
                                                            '202051' => 'Febrero - Julio 2020'
                                                            ));
            $crud->columns('periodo','codigo','nrc','nombre_curso','fecha_inicio','fecha_fin','academico_NAB');
            $crud->unset_fields('alumnos');
            $crud->add_action('Alumnos', '../assets/css/images/alumnos.png', 'curso/cursos/alumno_curso');
            $crud->required_fields('periodo', 'codigo','horas','fecha_inicio','fecha_fin');
            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function alumno_curso($idcurso)
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('posgrado', $this->session->userdata('perfil'));
            $crud->where('idcurso', $idcurso);
            $crud->set_table('cursos');
            $crud->display_as('codigo','Experiencia Educativa');
            $crud->display_as('nombre_curso','Nombre del Curso');
            $crud->set_relation('codigo','documentando','{nivelacad}  -  {descripcion}',array('nivelacad' => $this->session->userdata('perfil')));
            $crud->unset_print();
            $crud->unset_export();
            $crud->set_relation_n_n('academico_NAB', 'nab_cursos', 'nab', 'idcurso', 'numpersonal', '{nab.numpersonal} - {nab.nompersonal}', 'priority');
            $crud->set_relation_n_n('alumnos', 'alumno_cursos', 'alumno', 'idcurso', 'idalumno', '{NombreA} {ApellidoPA} {ApellidoMA}', 'priority');
            $crud->columns('codigo','NRC','nombre_curso','alumnos');
            $crud->unset_fields('periodo','fecha_inicio','fecha_fin','horas','academico_NAB','academico_externo','posgrado');
            $crud->unset_add();
            $crud->unset_delete();
            $crud->field_type('codigo','readonly');
            $crud->field_type('NRC','readonly');
            $crud->field_type('nombre_curso','readonly');

            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function registrocurso_admin()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            //$crud->where('posgrado', $this->session->userdata('perfil'));
            $crud->set_table('cursos');
            $crud->set_subject('curso');
            $crud->display_as('documentando_codigo','Experiencia Educativa')
                 ->display_as('nrc','NRC')
                 ->display_as('nomcurso','Nombre del Curso')
                 ->display_as('nab_numpersonal','Académico NAB')
                 ->display_as('horas','Horas p/semana')
                 ->display_as('personalext','Académico Externo');
            $crud->set_relation('codigo','documentando','{nivelacad}  -  {descripcion}',array('nivelacad' => $this->session->userdata('perfil')));

            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->edit_fields('NRC');

            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

        function just_a_test($primary_key , $row)
    {
        return site_url('curso/alumno_cursos/registro_alumnocurso').'?idcurso ='.$row->idcurso;
    }

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Programación de Cursos";
        if($this->session->userdata('perfil') == 'Administrador')
        {
        $output->barra_navegacion = " <li><a href='administrador'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_personal', $datos_plantilla);
        } else if($this->session->userdata('perfil') == 'Administrativo')
                {

                $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
                $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                $this->load->view('plantilla_administrativo', $datos_plantilla);
                } else {

                        $output->barra_navegacion = " <li><a href='directivo'>Menú principal</a></li>";
                        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                        $this->load->view('plantilla_directivo', $datos_plantilla);
                       }
    }

}
