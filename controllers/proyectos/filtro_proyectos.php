<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filtro_proyectos extends CI_Controller {

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
                redirect('proyectos/busqueda/academico_proyecto/'.$_POST['Academico']);
            }else{
                redirect('curso/cursos/registrocurso_admin/'.$_POST['generacion']."/".$_POST['periodo']."/".$_POST['posgrado']);
            }
        }else{
            redirect('login');
        }
    }








}