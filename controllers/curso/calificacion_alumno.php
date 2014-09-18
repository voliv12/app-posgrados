<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calificacion_alumno extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        $this->matricula = $this->session->userdata('matricula');
    }

    function index()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('Alumno_Matricula', $this->matricula);
            $crud->set_table('calificaciones');
            $crud->set_subject('calificación');
            $crud->display_as('Alumno_Matricula','Nombre del alumno')
                 ->display_as('boletacalific','Boleta de Calificación');
            $crud->set_field_upload('boletacalific','assets/uploads/alumnos/Boletas');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_delete();
            
            $output = $crud->render();

            $this->_example_output($output);
        }
             else { redirect('login');
             }
    }

 function _example_output($output = null)
    {
        $output->titulo_tabla = "Boleta de Calificaciones";
        $output->barra_navegacion = " <li><a href='principal'> Menú principal </a></li> <li> <a href='alumno'> Menú CVU </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }

}
