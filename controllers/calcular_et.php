<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calcular_et extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        /* Standard Libraries */
        $this->load->database();
        $this->load->helper('url');

    }

    function index()
    {   if($this->session->userdata('logged_in'))
        {           extract($_POST);

                    $this->load->model('usuarios_model');
                    ///$gen = 2012;
                    //$pos  = 'MCS';
                    //$num_alum = $this->usuarios_model->numero_alumno($gen, $pos);  
                    $num_alum = $this->usuarios_model->numero_alumno($_POST['generacion'],$_POST['posgrado']);
                    $num_alum_grad = $this->usuarios_model->numero_alumno_grado($_POST['generacion'],$_POST['posgrado']);
                    if($num_alum_grad == 0){
                        $ET = 0;
                    }else{
                    $ET = $num_alum / $num_alum_grad;}   

                    


                    $datos['genera'] = $_POST['generacion'];                    
                    $datos['mensaje'] = "Total de alumnos = ".$num_alum.'<br>'.
                                        "Total de alumnos graduados = ".$num_alum_grad.'<br>'. 
                                        "Eficiencia terminal  = ".$ET ;
                    $datos_plantilla['contenido'] = $this->load->view('calcular_et_view', $datos, true);

                    if ($this->session->userdata('perfil') == "Administrador del Sistema")
                    {
                        $this->load->view('plantilla_personal', $datos_plantilla);
                    }else  if ($this->session->userdata('perfil') == "Coordinador de Posgrado")
                            {
                                $this->load->view('plantilla_directivo', $datos_plantilla);
                            } else  if ($this->session->userdata('perfil') == "Director Instituto")
                                    {
                                        $this->load->view('plantilla_director', $datos_plantilla);
                                    }
                                    else if ($this->session->userdata('perfil') == "Apoyo Administrativo")
                                        {
                                            $this->load->view('plantilla_administrativo', $datos_plantilla);
                                        } 

                
        }else
        {
            redirect('login');
        }
    }
}
