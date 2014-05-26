<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distincion extends CI_Controller {

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

    function registroDistincion()
    {   $crud = new grocery_CRUD();
        $crud->where('Alumno_Matricula', $this->matricula);
        $crud->set_table('premiodistincion');
        $crud->set_subject('Distinciones y Premios');
        $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
        $crud->columns( 'Titulos','Pais','Otorgante','Institucion-otorgante','AnioP');
        $crud->display_as('Titulos','Titulo de la Distinción')->display_as('AnioP','Año')->display_as('Pais','País')->display_as('Otorgante','Otorgante')
             ->display_as('Institucion-otorgante','Institución Otorgante')->display_as('Descripcion','Descripcion de la Distinción')->display_as('DocPremio','Doc. comprobatorio');

        $crud-> unset_edit_fields ( 'Alumno_Matricula');
        $crud->set_field_upload('DocPremio','assets/uploads/alumnos/'.$this->matricula);
        $output = $crud->render();

        $this->_example_output($output);
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Distinciones y Premios";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

