<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogos extends CI_Controller {

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

    function divulgacion() //Catálogo Tipo de Divulgación
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('catalogodivulgacion')
                 ->set_subject('Tipo')
                 ->display_as('TipoParticipacion','Tipo Participación')
                ;

            $output = $crud->render();
            $output->titulo_tabla = "Catálogo Tipo Participación";

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

     function sub_conacyt() //Catálogo Subprograma CONACYT
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('subprogconacyt')
                 ->set_subject('Subprograma')
                ;

            $output = $crud->render();
            $output->titulo_tabla = "Catálogo Subprograma CONACYT";

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function _example_output($output = null)

    {
        $output->barra_navegacion = " <li><a href='administrador'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_personal', $datos_plantilla);
    }
}
