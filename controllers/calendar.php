<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller
{

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

	public function index()
	{

		$this->load->view('calendar');
	}



	   function calendario()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('events');
            $crud->set_subject('evento');
            $crud->display_as('title','Titulo')
           	     ->display_as('body','Descripción')
           	     ->display_as('url','URL')
           	     ->display_as('class','Tipo')
           	     ->display_as('start','Fecha Inicio')
           	     ->display_as('end','Fecha Fin');
           	$crud->unset_texteditor('body','full_text');
           	$crud->unset_columns('class');
            $crud->unset_print();
            $crud->unset_export();
            $output = $crud->render();

            $this->_example_output($output);

        }else{
            redirect('login');
        }
    }



    function _example_output($output = null)
    {
        $output->titulo_tabla = "Calendarización de Eventos";
        $output->barra_navegacion = " <li><a href='administrador'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_personal', $datos_plantilla);
    }

}



/* End of file calendar.php */
/* Location: ./application/controllers/calendar.php */