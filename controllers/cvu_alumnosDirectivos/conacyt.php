<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conacyt extends CI_Controller {

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

    function registroConacyt()
    {
        if ($this->session->userdata('logged_in'))
        {
                $this->session->keep_flashdata('matricula');
                $this->session->keep_flashdata('nombre');
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->session->flashdata('matricula'));
                $crud->set_table('apoyoconacyt');
                $crud->set_subject('Apoyo CONACYT');
                //$crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns('idSubProgCONACYT','TipoApoyo','NumApoyo','CFechaFin');
                $crud->set_relation('idSubProgCONACYT','subprogconacyt','Nombre');
                $crud->display_as('Alumno_Matricula','Nombre del alumno')->display_as('idSubProgCONACYT','Subprograma CONACYT')->display_as('NumApoyo','No. de Apoyo')->display_as('TipoApoyo','Tipo de Apoyo')
                     ->display_as('CFechaIni','Fecha de Inicio')->display_as('CFechaFin','Fecha de Finalización');
                $crud->set_relation('Alumno_Matricula','alumno','{NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
                $crud->unset_print();
                $crud->unset_export();
                $crud->unset_add();
                $crud->unset_edit();
                $crud->unset_delete();
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('idSubProgCONACYT','TipoApoyo','NumApoyo','CFechaFin');
                $output = $crud->render();

                $this->_example_output($output);
        }
        else {
                redirect('login');
                }
    }


    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Apoyos CONACYT";
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li>  |  <li> <a href='cvu_alumnosDirectivos/datos_personales/registroAlumno'> Listado de alumnos </a></li>  |  <li> <a href='alumnoscvu/menu/".$this->session->flashdata('matricula')."/".$this->session->flashdata('nombre')."'> Menú CVU alumno </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }
}

