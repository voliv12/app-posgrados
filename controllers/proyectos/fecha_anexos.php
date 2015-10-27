<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fecha_anexos extends CI_Controller {

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

    function registro_fechas()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('fecha_anexos');
            $crud->unset_add();
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_delete();
            $crud->unset_edit_fields('nombre_anexo');
            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');

    }}

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Fecha de Anexos";
        if($this->session->userdata('perfil')== "Administrativo"){
            $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
        }else{
            $output->barra_navegacion = " <li><a href='directivo'>Menú principal</a></li>";
        }
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_administrativo', $datos_plantilla);
    }

}
