<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Libro extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */ 
 
        $this->load->library('grocery_CRUD');
 
    }
 
    public function index()
    {
         
    }
     public function registroLibro()
    {   $crud = new grocery_CRUD();
        $crud->set_table('libros');
        $crud->set_subject('Libros');
        $output = $crud->render();
        
        $this->_example_output($output);   
    }
 
   
 
    function _example_output($output = null)
 
    {
        $output->titulo_tabla = "Registro de Libros";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);  
        $this->load->view('plantilla_view', $datos_plantilla);  
    }
}
 
