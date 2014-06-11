<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

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

    function registroReportes()
    {   
        if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->matricula);
                $crud->set_table('reportecnico');
                $crud->set_subject('Reporte');
            
                $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns( 'TituloRepor','Instancia','Objetivoreport','fechaReport','DocRecTec');
                $crud->display_as('TituloRepor','Titulo del Reporte')->display_as('Instancia','Instancia a la que se presenta el Reporte')->display_as('RDescripcion','Descripción del Reporte')
                     ->display_as('NumpagRepor','No. Páginas')->display_as('fechaReport','Fecha')
                     ->display_as('Objetivoreport','Objetivo del reporte')
                     ->display_as('Autores','Autor/es')->display_as('DocRecTec','Doc. comprobatorio');

                $crud->unset_print();
                $crud->unset_export();
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('TituloRepor','Instancia','Objetivoreport','fechaReport');
                $crud->set_field_upload('DocRecTec','assets/uploads/alumnos/'.$this->matricula);
                $crud->set_rules('DocRecTec','Doc. comprobatorio','max_length[26]');
                $output = $crud->render();

                $this->_example_output($output);
        } 
        else { 
                redirect('login');
                }    
    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Reporte Técnico";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

