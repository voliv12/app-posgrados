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
    }

    function registroAlumno()
    {
        if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                $crud->set_table('alumno');
                $crud->set_subject('Alumno');
                $crud->columns( 'Matricula','Nivel','NombreA' , 'ApellidoPA','ApellidoMA');
                $crud->display_as('NombreA','Nombre')->display_as('ApellidoPA','Apellido Paterno')->display_as('ApellidoMA','Apellido Materno');
                $crud->add_action('CVU', '../assets/css/images/folderr.png', 'alumnoscvu/menu');
                $crud->unset_add ( ) ;
                //$crud-> field_type ( 'Contrasenia' , 'password' ) ;
                $crud->unset_edit_fields('Contrasenia');
                $crud->unset_delete();
                $crud->unset_print();
                $crud->unset_export();
                $crud->unset_edit();
                $output = $crud->render();

                $this->_example_output($output);
         } 
        else { 
                redirect('login');
                }    
    }

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Alumnos de Posgrado ICS";
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }
}