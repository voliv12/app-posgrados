<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calificaciones extends CI_Controller {

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

    function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('calificaciones');
            $crud->set_subject('calificación');
            $crud->unset_print();
            $crud->unset_export();
            $crud->display_as('Alumno_Matricula','Nilvel - Nombre del alumno')
                 ->display_as('boletacalific','Boleta de Calificación');
            $crud->set_relation('Alumno_Matricula','alumno','{Nivel}  -  {NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
            $crud->set_field_upload('boletacalific','assets/uploads/alumnos/Boletas');
            $crud->set_rules('boletacalific','Boleta de Calificación','max_length[40]');
            $crud->required_fields('Alumno_Matricula', 'boletacalific','Semestre');
            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Boleta de calificación";
        $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_administrativo', $datos_plantilla);
    }

}
