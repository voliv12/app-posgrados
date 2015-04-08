<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyecto extends CI_Controller {

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

    function registroProyecto()
    {   
        if ($this->session->userdata('logged_in'))
        {
                $this->session->keep_flashdata('matricula');
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->session->flashdata('matricula'));
                $crud->set_table('proyectos');
                $crud->set_subject('Proyectos de Investigacion');
                //$crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns('TituloProyecto','Entidad','POrganizacion','DocProyect');
                $crud->display_as('Alumno_Matricula','Nombre del alumno')->display_as('TipoProyecto','Tipo de Proyecto')->display_as('PFinicio','Fecha de Inicio')->display_as('PFfin','Fecha de Finalización')
                     ->display_as('TituloProyecto','Titulo del Proyecto')->display_as('PSector','Sector')
                     ->display_as('POrganizacion','Organización')->display_as('OtrasInstituciones','Otras Instituciones')->display_as('Investigadores','Investigadores Participantes')
                     ->display_as('BecariosParticipantes','Becarios Participantes')->display_as('ProductoFinal','Principales Logros/Producto Final Obtenido')->display_as('DocProyect','Doc. comprobatorio');
                $crud->set_relation('Alumno_Matricula','alumno','{NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
                $crud->unset_print();
                $crud->unset_export();
                $crud->unset_add();
                $crud->unset_edit();
                $crud->unset_delete();
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('TipoProyecto','TituloProyecto','Entidad','POrganizacion','ProductoFinal');
                $crud->set_field_upload('DocProyect','assets/uploads/alumnos/'.$this->session->flashdata('matricula'));

                $crud->unset_texteditor('OtrasInstituciones','full_text');
                $crud->unset_texteditor('Investigadores','full_text');
                $crud->unset_texteditor('BecariosParticipantes','full_text');
                $crud->unset_texteditor('ProductoFinal','full_text');

                $crud->set_rules('DocProyect','Doc. comprobatorio','max_length[26]');

                $output = $crud->render();

                $this->_example_output($output);
        } 
        else { 
                redirect('login');
                }    
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Proyecto de Investigación";
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li>  |  <li> <a href='cvu_alumnosDirectivos/datos_personales/registroAlumno'> lista de Alumnos CVU </a></li>  |  <li> <a href='alumnoscvu/menu/".$this->session->flashdata('matricula')."'> Menú CVU </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }
}

