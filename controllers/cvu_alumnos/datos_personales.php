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
        $this->idalumno = $this->session->userdata('idalumno');
    }

    function registroAlumno()
    {
        if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                $crud->where('idalumno', $this->idalumno);
                $crud->set_table('alumno');
                $crud->set_subject('Alumno');

                $crud-> unset_edit_fields ('NombreA' , 'ApellidoPA','ApellidoMA', 'Contrasenia','Nivel' ) ;
                $crud->columns( 'NombreA' , 'ApellidoPA','ApellidoMA','curp','rfc','Correo','Telefono');
                $crud->display_as('NombreA','Nombre')->display_as('ApellidoPA','Apellido Paterno')->display_as('ApellidoMA','Apellido Materno')->display_as('curp','CURP')->display_as('rfc','RFC')->display_as('Direccion','Dirección')->display_as('Telefono', 'Teléfono');
                $crud-> unset_add ( ) ;
                $crud->unset_delete();
                $crud->unset_print();
                $crud->unset_export();
                $crud->required_fields('curp','rfc','Correo','Telefono');
                $crud->set_rules('Correo','Correo','valid_email');
                $crud->set_rules('curp','CURP','max_length[18]');
                $crud->set_rules('rfc','RFC','max_length[13]');
                //$crud-> field_type ( 'Contrasenia' , 'password' ) ;
                $output = $crud->render();

                $this->_example_output($output);
         } 
        else { 
                redirect('login');
                }    
    }

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Datos personales";
        $output->barra_navegacion = " <li><a href='principal'> Menú principal </a></li>  |  <li> <a href='alumno'> Menú CVU </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}
