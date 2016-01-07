<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Director extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->library('grocery_CRUD');
        $this->load->model('usuarios_model');
    }

    function index()
    {
        if($this->session->userdata('logged_in'))
        {   $menu_director->generaciones = $this->usuarios_model->buscar_generacion();
            $menu_director->posgrados = $this->usuarios_model->buscar_posgrados();
            $datos_plantilla['titulo'] = "Información de Posgrados";
            $datos_plantilla['contenido'] = $this->load->view('menu_director_view', $menu_director,TRUE);
            $this->load->view('plantilla_director', $datos_plantilla);

        }else
        {
            redirect('login');
        }

    }

}
