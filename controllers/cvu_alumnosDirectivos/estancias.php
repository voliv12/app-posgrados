<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estancias extends CI_Controller {

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

    function registroEstancias()
    {

        if ($this->session->userdata('logged_in'))
        {
                $this->session->keep_flashdata('matricula');
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->session->flashdata('matricula'));
                $crud->set_table('estancias');
                $crud->set_subject('Estancia de Investigación');
                //$crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns( 'Organizacion','LineaInvestiga','Logros','DocEstancia');
                $crud->display_as('Alumno_Matricula','Nombre del alumno')->display_as('Sector','Sector')->display_as('Organizacion','Organización')->display_as('EFinicio','Fecha de Inicio')->display_as('Logros','Principales Logros')
                     ->display_as('EFfin','Fecha de Finalización')->display_as('Pais','País')->display_as('LineaInvestiga','Lineas de Investigación')->display_as('DocEstancia','Doc. comprobatorio');
                $crud->set_relation('Pais','paises','nombre');
                $crud->set_relation('Alumno_Matricula','alumno','{NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
                $crud->unset_print();
                $crud->unset_export();
                $crud->unset_add();
                $crud->unset_edit();
                $crud->unset_delete();
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('Sector','Organizacion','Titulo','LineaInvestiga','Logros');
                $crud->set_field_upload('DocEstancia','assets/uploads/alumnos/'.$this->session->flashdata('matricula'));
                $crud->unset_texteditor('LineaInvestiga','full_text');
                $crud->unset_texteditor('Logros','full_text');


                $crud->set_rules('DocEstancia','Doc. comprobatorio','max_length[26]');

                $output = $crud->render();
                $this->_example_output($output);
        }
        else {
                redirect('login');
                }

    }


    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Estancias de Investigación";
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li>  |  <li> <a href='cvu_alumnosDirectivos/datos_personales/registroAlumno'> Listado de alumnos </a></li>  |  <li> <a href='alumnoscvu/menu/".$this->session->flashdata('matricula')."'> Menú CVU alumno </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }
}

