<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datos_personales extends CI_Controller {

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

    function registroAlumno()
    {
        $crud = new grocery_CRUD();
        $crud->where('matricula', $this->matricula);
        $crud->set_table('alumno');
        $crud->set_subject('Alumno');
        $crud-> unset_edit_fields ( 'Matricula' , 'NombreA' , 'ApellidoPA','ApellidoMA', 'Contrasenia' ) ;
        $crud->columns( 'NombreA' , 'ApellidoPA','ApellidoMA','curp','rfc','Direccion','Telefono');
        $crud->display_as('NombreA','Nombre')->display_as('ApellidoPA','Apellido Paterno')->display_as('ApellidoMA','Apellido Materno')->display_as('curp','CURP')->display_as('rfc','RFC')->display_as('Direccion','Dirección')->display_as('Telefono', 'Teléfono');
        $crud-> unset_add ( ) ;
        $crud->unset_delete();
        $crud-> field_type ( 'Contrasenia' , 'password' ) ;
        $output = $crud->render();

        $this->_example_output($output);
    }

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Datos personales";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}
