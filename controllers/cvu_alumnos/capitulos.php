<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulos extends CI_Controller {

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

    function registroCapitulos()
    {   $crud = new grocery_CRUD();
        $crud->where('Alumno_Matricula', $this->matricula);
        $crud->set_table('caplibros');
        $crud->set_subject('Capitulos de Libros');
    
        $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
        $crud->columns( 'TituloLibCP','TituloCap','Anio','Autor');
        $crud->display_as('TituloCap','Titulo del Capitulo')->display_as('Anio','Año de Publicación')->display_as('TituloLibCP','Titulo del Libro')
             ->display_as('EditoresCL','Editores')->display_as('EditorialCL','Editorial')->display_as('VolumCL','Volumen')
             ->display_as('NumPagCL','N° Páginas')->display_as('NumCitas','N° Citas')->display_as('AutorCL','Autor/es')
             ->display_as('Resumen','Resumen')->display_as('DocCapLibro','Archivo');

        $crud-> unset_edit_fields ( 'Alumno_Matricula');
        $output = $crud->render();

        $this->_example_output($output);
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Libros";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

