<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alumno_cursos extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');

    }


    function registro_alumnocurso_admin()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('alumno_cursos');
            $crud->set_subject('Alumno a curso');
            $crud->display_as('alumno_Matricula','Nombre del Alumno');
            $crud->display_as('idcurso','Nombre del curso');
            $crud->set_relation('alumno_Matricula','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->set_relation('idcurso','cursos','{posgrado}  -  {nombre_curso}  -  {NRC}');
            $crud->columns('alumno_Matricula','idcurso');

            $crud->unset_fields('priority');
            $crud->required_fields('alumno_Matricula');
            $crud->unset_print();
            $crud->unset_export();

            $output = $crud->render();
            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }


    function acciones_callback($post_array)
    {
        $post_array['idcurso'] =  $this->session->flashdata('curso');
    }

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Ingresar Alumnos a Cursos";
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

                        $output->barra_navegacion = " <li><a href='directivo'>Menú principal</a></li>   |  <li> <a href='alumno_cursos'> Menú CVU </a></li>";
                        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                        $this->load->view('plantilla_directivo', $datos_plantilla);
                       }
    }

}
