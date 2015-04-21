<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nab extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        //$this->matricula = $this->session->userdata('matricula');
    }

    function registroNab()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('nab');
            $crud->set_subject('Personal');
            $crud->display_as('numpersonal','Número de Personal')->display_as('nompersonal','Nombre del Personal');
            $crud->required_fields('numpersonal', 'nompersonal');
            $crud->unset_print();
            $crud->columns('numpersonal', 'nompersonal');
            $crud->field_type('priority','hidden');
            $crud->unset_export();
            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');

    }}

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Personal del Núcleo Académico Básico";
        if($this->session->userdata('perfil')== "Administrativo"){
            $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
        }else{
            $output->barra_navegacion = " <li><a href='directivo'>Menú principal</a></li>";
        }
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_administrativo', $datos_plantilla);
    }

}
