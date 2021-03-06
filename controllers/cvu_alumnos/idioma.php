<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Idioma extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->matricula = $this->session->userdata('matricula');
    }

    function registroIdioma()
    {   
        if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->matricula);
                $crud->set_table('idioma');
                $crud->set_subject('Idioma');
                $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns( 'Idioma','tipoI','NivelConv','NivelLec','NivelEsc','DocIdioma');
                $crud->display_as('Idioma','Idioma')->display_as('Descripcion','Descripción')->display_as('tipoI','Tipo')->display_as('NivelConv','Nivel de Conversación')
                     ->display_as('NivelLec','Nivel de Lectura')->display_as('NivelEsc','Nivel de Escritura')->display_as('FechaEvalu','Fecha de Evaluación')->display_as('Puntos','Puntos/Porcentaje')->display_as('DocIdioma','Doc. comprobatorio');   
                $crud->unset_print();
                $crud->unset_export();
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('Idioma','tipoI','NivelConv','NivelLec','NivelEsc','tipo');
                $crud->set_field_upload('DocIdioma','assets/uploads/alumnos/'.$this->matricula);
                $crud->unset_texteditor('Descripcion','full_text');
                $crud->set_rules('DocIdioma','Doc. comprobatorio','max_length[26]');

                $output = $crud->render();
                $this->_example_output($output);
        } 
        else { 
                redirect('login');
                }    
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Idioma";
        $output->barra_navegacion = " <li><a href='principal'> Menú principal </a></li>  |  <li> <a href='alumno'> Menú CVU </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

