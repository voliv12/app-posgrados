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
        
    }

    function registroCapitulos()
    {   
       if ($this->session->userdata('logged_in'))
        {
                $this->session->keep_flashdata('matricula');
                $crud = new grocery_CRUD();
                $crud->set_table('caplibros');
                $crud->set_subject('Capitulos de Libros');
                $crud->where('Alumno_Matricula', $this->session->flashdata('matricula'));
                $crud->columns( 'Alumno_Matricula','TituloLibCP','TituloCap','AutorCL','DocCapLibro');
                $crud->display_as('Alumno_Matricula','Nombre del alumno')->display_as('TituloCap','Titulo del Capitulo')->display_as('Anio','Año de Publicación')->display_as('TituloLibCP','Titulo del Libro')
                     ->display_as('EditoresCL','Editores')->display_as('EditorialCL','Editorial')->display_as('VolumCL','Volumen')
                     ->display_as('NumPagCL','No. Páginas')->display_as('NumCitas','No. Citas')->display_as('AutorCL','Autor/es')
                     ->display_as('Resumen','Resumen')->display_as('DocCapLibro','Doc. comprobatorio');

                $crud->unset_print();
                $crud->unset_export();
                $crud->unset_add();
                $crud->unset_edit();
                $crud->unset_delete();
                $crud->set_relation('Alumno_Matricula','alumno','{NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
                $crud->field_type('Anio','dropdown',range(2000, 2030));
                $crud->required_fields('TituloLibCP','TituloCap','Anio','AutorCL','Resumen');
                $crud->set_field_upload('DocCapLibro','assets/uploads/alumnos/'.$this->session->flashdata('matricula'));

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
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li>  |  <li> <a href='cvu_alumnosDirectivos/datos_personales/registroAlumno'> lista de Alumnos CVU </a></li>  |  <li> <a href='alumnoscvu/menu/".$this->session->flashdata('matricula')."'> Menú CVU </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }
}

