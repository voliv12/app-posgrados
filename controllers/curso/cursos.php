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
            $crud->set_table('cursos');
            $crud->set_subject('curso');
            $crud->display_as('documentando_codigo','Experiencia Educativa')
                 ->display_as('nrc','NRC')
                 ->display_as('Alumno_Matricula','Nombre del alumno')
                 ->display_as('nomcurso','Nombre del Curso')
                 ->display_as('nab_numpersonal','Maestro Interno')
                 ->display_as('personalext','Maestro Externo');
            $crud->set_relation('documentando_codigo','documentando','{nivelacad}  -  {descripcion}');
            $crud->set_relation('Alumno_Matricula','alumno','{NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
            $crud->set_relation('nab_numpersonal','nab','nompersonal');
            $crud->unset_print();
            $crud->unset_export();
            
            $crud->required_fields('nrc', 'documentando_codigo','nomcurso','alumno_Matricula', 'nab_numpersonal');
            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Registro de Curso ";
        $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_administrativo', $datos_plantilla);
    }

}
