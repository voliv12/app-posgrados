<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Libro extends CI_Controller {

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

    function registroLibro()
    {   $crud = new grocery_CRUD();
        $crud->where('Alumno_Matricula', $this->matricula);
        $crud->set_table('libros');
        $crud->set_subject('Libros');
    
        $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
        $crud->columns( 'NumISBN' , 'TituloLib','AutorLib','VolumenLib');
        $crud->display_as('NumISBN','Número ISBN')->display_as('IdentLib','Indentificador Libro')->display_as('VolumenLib', 'Volumen')
             ->display_as('EditoriaLib','Editorial')->display_as('NumPagLib','N°. Páginas')->display_as('AutorLib', 'Autor/es')
             ->display_as('TituloLib','Titulo del Libro')->display_as('AnioLib','Año de Publicación')->display_as('EdicionLib', 'Edición')->display_as('DocLibro', 'Archivo');
        $crud-> unset_edit_fields ( 'Alumno_Matricula');
        $output = $crud->render();

        $this->_example_output($output);
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Libros";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

