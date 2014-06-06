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
    {   

        if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->matricula);
                $crud->set_table('libros');
                $crud->set_subject('Libros');
            
                $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns( 'NumISBN' , 'TituloLib','AutorLib','VolumenLib','DocLibro');
                $crud->display_as('NumISBN','Número ISBN')->display_as('IdentLib','Indentificador Libro')->display_as('VolumenLib', 'Volumen')
                     ->display_as('EditoriaLib','Editorial')->display_as('NumPagLib','No. Páginas')->display_as('AutorLib', 'Autor/es')
                     ->display_as('TituloLib','Titulo del Libro')->display_as('AnioLib','Año de Publicación')->display_as('EdicionLib', 'Edición')->display_as('DocLibro', 'Doc. comprobatorio');
                
                $crud->unset_print();
                $crud->unset_export();
                $crud->field_type('AnioLib','dropdown',range(2000, 2030));
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('NumISBN' , 'TituloLib','AutorLib','IdentLib','VolumenLib','EditoriaLib');
                $crud->set_field_upload('DocLibro','assets/uploads/alumnos/'.$this->matricula);
                $crud->set_rules('DocLibro','Doc. comprobatorio','max_length[26]');
                $output = $crud->render();

                $this->_example_output($output);
        } 
        else { 
                redirect('login');
                }    
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Libros";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

