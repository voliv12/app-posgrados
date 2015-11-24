<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filtro_cursos extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

    function filtrar()
    {
        if($this->session->userdata('logged_in'))
        {
            if($this->session->userdata('perfil') == "Coordinador de Posgrado")
            {
                redirect('curso/cursos/registrocurso/'.$_POST['generacion']."/".$_POST['periodo']);
            }else{
                redirect('curso/cursos/registrocurso_admin/'.$_POST['generacion']."/".$_POST['periodo']."/".$_POST['posgrado']);
            }
        }else{
            redirect('login');
        }
    }








}
