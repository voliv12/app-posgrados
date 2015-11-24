<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentando extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
    }

    function registrodoc()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('documentando');
            $crud->set_subject('Registro');
            $crud->display_as('codigo','Código')
                 ->display_as('descripcion','Descripción')
                 ->display_as('nivelacad','Nivel Académico')
                 ->display_as('creditos','Créditos');
            $crud->required_fields('codigo', 'descripcion', 'nivelacad','creditos');
            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Documentando";
        $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_administrativo', $datos_plantilla);
    }

}
