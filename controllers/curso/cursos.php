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
                 ->display_as('personalext','Académico Externo')
                 ->display_as('dia','Dia(s)')
                 ->display_as('generacion','Generación');
            $crud->set_relation('codigo','documentando','{nivelacad}  -  {descripcion}',array('nivelacad' => $this->session->userdata('perfil')));
            $crud->unset_print();
            $crud->unset_export();
            //$crud->unset_edit_fields();
            $crud->field_type('NRC', 'hidden');
            //$crud->field_type('nrc','invisible');
            $crud->field_type('posgrado','hidden', $this->session->userdata('perfil'));
            $crud->field_type('horas','dropdown',range(1,20));
            $crud->field_type('generacion','dropdown',array('2012'=> '2012',
                                                            '2013'=> '2013',
                                                            '2014'=> '2014',
                                                            '2015'=> '2015',
                                                            '2016'=> '2016',
                                                            '2017'=> '2017',
                                                            '2018'=> '2018',
                                                            '2019'=> '2019',
                                                            '2020'=> '2020',
                                                            '2021'=> '2021'
                                                        ));
            $crud->set_relation_n_n('academico_NAB', 'nab_cursos', 'nab', 'idcurso', 'numpersonal', '{nab.numpersonal} - {nab.nompersonal} {nab.apellidos}', 'priority');
            $crud->set_relation_n_n('alumnos', 'alumno_cursos', 'alumno', 'idcurso', 'idalumno', '{NombreA} {ApellidoPA} {ApellidoMA}', 'priority');
            $crud->field_type('periodo', 'dropdown',  array(
                                                            '201301' => '201301: Ago 2012 - Ene 2013',
                                                            '201351' => '201351: Feb - Jul 2013',
                                                            '201401' => '201401: Ago 2013 - Ene 2014',
                                                            '201451' => '201451: Feb - Jul 2014',
                                                            '201501' => '201501: Ago 2014 - Ene 2015' ,
                                                            '201551' => '201551: Feb - Jul 2015',
                                                            '201601' => '201601: Ago 2015 - Ene 2016',
                                                            '201651' => '201651: Feb - Jul 2016',
                                                            '201701' => '201701: Ago 2016 - Ene 2017',
                                                            '201751' => '201751: Feb - Jul 2017',
                                                            '201801' => '201801: Ago 2017 - Ene 2018',
                                                            '201851' => '201851: Feb - Jul 2018',
                                                            '201901' => '201901: Ago 2018 - Ene 2019',
                                                            '201951' => '201951: Feb - Jul 2019',
                                                            '202001' => '202001: Ago 2019 - Ene 2020',
                                                            '202051' => '202051: Feb - Jul 2020'
                                                            ));
            $crud->columns('generacion','periodo','codigo','nrc','nombre_curso','academico_NAB');
            $crud->unset_fields('alumnos');
            $crud->add_action('Alumnos', '../assets/css/images/alumnos.png', 'curso/cursos/alumno_curso');
            $crud->required_fields('generacion','periodo', 'codigo','horas','fecha_inicio','fecha_fin');
            $crud->field_type('dia','multiselect',
                    array( "Lunes"=>"Lunes","Martes"=>"Martes","Miércoles"=>"Miércoles","Jueves"=>"Jueves","Viernes"=>"Viernes","Sábado"=>"Sábado","Domingo"=>"Domingo"));
            $crud->callback_add_field('hora_inicio',array($this,'hora_inicio'));
            $crud->callback_add_field('hora_fin',array($this,'hora_fin'));
            $crud->order_by('generacion','DESC');
            $barra = " <li><a href='directivo'>Menú principal</a></li>";
            $crud->callback_before_insert(array($this,'acciones_callback'));
            $crud->callback_before_update(array($this,'acciones_callback'));

            $output = $crud->render();

            $this->_example_output($output,$barra);
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
            $crud->unset_fields('periodo','fecha_inicio','fecha_fin','horas','academico_NAB','academico_externo','posgrado','dia','hora_inicio','hora_fin','lugar');
            $crud->unset_add();
            $crud->unset_delete();
            $crud->field_type('codigo','readonly');
            $crud->field_type('NRC','readonly');
            $crud->field_type('nombre_curso','readonly');
            $barra = " <li><a href='directivo'>Menú principal</a></li>  |  <li> <a href='curso/cursos/registrocurso'>Cursos </a></li>";
            $output = $crud->render();

            $this->_example_output($output, $barra);

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
            $crud->display_as('codigo','Experiencia Educativa')
                 ->display_as('nombre_curso','Nombre del Curso')
                 ->display_as('academico_NAB','Académico NAB')
                 ->display_as('horas','Horas p/semana')
                 ->display_as('generacion','Generación');
            $crud->set_relation('codigo','documentando','{nivelacad}  -  {descripcion}');
            $crud->set_relation_n_n('academico_NAB', 'nab_cursos', 'nab', 'idcurso', 'numpersonal', '{nab.numpersonal} - {nab.nompersonal}', 'priority');
            $crud->set_relation_n_n('alumnos', 'alumno_cursos', 'alumno', 'idcurso', 'idalumno', '{NombreA} {ApellidoPA} {ApellidoMA}', 'priority');
            $crud->columns('generacion','periodo','codigo','NRC','nombre_curso','academico_NAB');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete();
            //$crud->edit_fields('NRC','codigo','nombre_curso','academico_NAB', 'academico_externo','alumnos');
            $crud->unset_edit_fields('fecha_inicio','fecha_fin','horas','academico_externo','dia','hora_inicio','hora_fin','lugar','otro_lugar');
            $crud->field_type('generacion','readonly');
            $crud->field_type('periodo','readonly');
            $crud->field_type('academico_NAB','readonly');
            $crud->field_type('alumnos','readonly');
            $crud->field_type('academico_externo','readonly');
            $crud->field_type('codigo','readonly');
            $crud->field_type('nombre_curso','readonly');
            $crud->field_type('posgrado','readonly');
            $crud->order_by('generacion','DESC');

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
        //$post_array['nombre_curso'] = strtoupper($post_array['nombre_curso']);
        $post_array['nombre_curso'] = strtr(strtoupper($post_array['nombre_curso']),"áéíóúñ","ÁÉÍÓÚÑ");
        $post_array['academico_externo'] = strtr(strtoupper($post_array['academico_externo']),"áéíóúñ","ÁÉÍÓÚÑ");

        return $post_array;
    }

    function _example_output($output = null, $barra = null)
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

                        //$output->barra_navegacion = " <li><a href='directivo'>Menú principal</a></li>  |  <li> <a href='curso/cursos/registrocurso'>Cursos </a></li>";
                        $output->barra_navegacion = $barra;
                        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                        $this->load->view('plantilla_directivo', $datos_plantilla);
                       }
    }

}
