<?php
Class Curriculum extends CI_controller{
        
    function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */           
        $this->noPersonal = $this->session->userdata('noPersonal');
    }                      

    function index()
    {   
        $this->load->model('curriculum_model');
        $datos['academico'] = $this->curriculum_model->informacion_personal($this->noPersonal);

        //print_r($datos); 
        foreach ($datos['academico'] as $academico) {
            $dat['academico'] = array(
                                        'nombre'    => $academico['nombre'],
                                        'categoria' => $academico['nombre_categoria'],
                                        'grado'     => $academico['grado']." ".$academico['nombre_grado'],
                                        'direccion' => $academico['direccion'],
                                        'rfc'       => $academico['rfc'],
                                        'curp'      => $academico['curp'],
                                        'correos'   => $academico['correos']
                                        );
        }
        
        $filename = $this->noPersonal."-CV-".date('dmY-his').".doc";
        header("Content-Type: application/xml; charset=UTF-8");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=$filename");
        $this->load->view('curriculum_view', $dat);
        return;         
    }                         
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */