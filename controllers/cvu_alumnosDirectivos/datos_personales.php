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
        $this->perfil = $this->session->userdata('perfil');
    }

    function registroAlumno()
    {
        if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                //$crud->set_table('cat_posgrados_alumno');
                $crud->set_table('alumnoscvu');
                $crud->set_primary_key('matricula');
                $crud->set_subject('cat_posgrados_alumno')
                     ->display_as('idcat_posgrados','Maestría')
                     ->display_as('idcat_posgradosD','Doctorado')
                     ->display_as('idalumno','Alumno')
                     ->display_as('inicio','Año de inicio')
                     ->columns('matricula','idalumno','idcat_posgrados','idcat_posgradosD','estatus','inicio','termino');
               //$crud->set_relation('idcat_posgrados','cat_posgrados','nombre_posgrado',array('nivelP' => 'Maestría'));
                $crud->set_relation('idcat_posgrados','cat_posgrados','nombre_posgrado',array('abrev_posgrado' => $this->perfil));
                $crud->set_relation('idcat_posgradosD','cat_posgrados','nombre_posgrado',array('abrev_posgrado' => $this->perfil));
                $crud->add_action('CVU', '../assets/css/images/folderr.png', 'alumnoscvu/menu');
                //$crud->add_action('CVU','','', '../assets/css/images/folderr.png',array($this,'just_a_test'));
                $crud->unset_add ( ) ;
                $crud->set_relation('idalumno','alumno','{NombreA} - {ApellidoPA} - {ApellidoMA}');
                //$crud-> field_type ( 'Contrasenia' , 'password' ) ;
               // $crud->unset_edit_fields('Contrasenia');
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



    function just_a_test($primary_key , $row)
    {
        return site_url('alumnoscvu/menu').'?matricula='.$row->matricula;
    }  


    function _example_output($output = null)

    {
        $output->titulo_tabla = "Alumnos de Posgrado ICS";
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }
}
