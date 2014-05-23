<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resenia extends CI_Controller {

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

    function registroResenia()
    {   $crud = new grocery_CRUD();
        $crud->where('Alumno_Matricula', $this->matricula);
        $crud->set_table('resenia');
        $crud->set_subject('Reseña');
    
        $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
        $crud->columns( 'TituloRese','TituloObra','TipoPublica','TituloPublica');
        $crud->display_as('TituloRese','Titulo de la Reseña')->display_as('TituloObra','Titulo de la Obra')->display_as('TipoPublica','Tipo de Publicación')
             ->display_as('AnioRe','Año')->display_as('pagInc',' De la Pag')->display_as('pagFin','A la Pag')->display_as('TituloPublica','Titulo de la Publicación')
             ->display_as('Pais','País')->display_as('autorRese','Autor/es')->display_as('DocRese','Archivo');
        
        $crud-> unset_edit_fields ( 'Alumno_Matricula');
        $output = $crud->render();

        $this->_example_output($output);
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Reseñas";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

