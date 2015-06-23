<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filtro_cursos extends CI_Controller {

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

    function filtrar()
    {
        if($this->session->userdata('logged_in'))
        {
            if($this->session->userdata('perfil') == "Coordinador de Posgrado")
            {
                redirect('curso/cursos/registrocurso/'.$_POST['generacion']."/".$_POST['periodo']);
            }

            //echo 'curso/cursos/registrocurso/'.$_POST['generacion']."/".$_POST['periodo'];
        }else{
            redirect('login');
        }
    }








}
