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
    {   
       if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->matricula);
                $crud->set_table('caplibros');
                $crud->set_subject('Capitulos de Libros');
            
                $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns( 'TituloLibCP','TituloCap','Anio','AutorCL','DocCapLibro');
                $crud->display_as('TituloCap','Titulo del Capitulo')->display_as('Anio','Año de Publicación')->display_as('TituloLibCP','Titulo del Libro')
                     ->display_as('EditoresCL','Editores')->display_as('EditorialCL','Editorial')->display_as('VolumCL','Volumen')
                     ->display_as('NumPagCL','No. Páginas')->display_as('NumCitas','No. Citas')->display_as('AutorCL','Autor/es')
                     ->display_as('Resumen','Resumen')->display_as('DocCapLibro','Doc. comprobatorio');

                $crud->unset_print();
                $crud->unset_export();
                $crud->field_type('Anio','dropdown',range(2000, 2030));
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('TituloLibCP','TituloCap','Anio','AutorCL','Resumen');
                $crud->set_field_upload('DocCapLibro','assets/uploads/alumnos/'.$this->matricula);

                $crud->unset_texteditor('AutorCL','full_text');
                $crud->unset_texteditor('Resumen','full_text');

                $crud->set_rules('DocCapLibro','Doc. comprobatorio','max_length[26]');

                $output = $crud->render();

                $this->_example_output($output);
        } 
        else { 
                redirect('login');
                }
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Capitulos de Libros";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

