<?php
Class Curriculum extends CI_controller{

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->matricula = $this->session->userdata('matricula');
    }

    function index()
    {
        $this->load->model('curriculum_model');
        $row = $this->curriculum_model->informacion_personal($this->matricula);

        $datos['alumno'] = array(
                                    'nombre'     => $row->NombreA,
                                    'apaterno'   => $row->ApellidoPA,
                                    'amaterno'   => $row->ApellidoMA,
                                    'direccion'  => $row->Direccion,
                                    'telefono'   => $row->Telefono,
                                    'rfc'        => $row->rfc,
                                    'curp'       => $row->curp,
                                    'correo'     => $row->Correo
                                );

        $datos['congresos'] = $this->curriculum_model->get_tabla('congresos', $this->matricula);
        $datos['estancias'] = $this->curriculum_model->get_tabla('estancias', $this->matricula);
        $datos['divulgacion'] = $this->curriculum_model->get_divulgacion($this->matricula);

        // print_r($datos);

        $filename = "CVU-".$this->matricula."-".date('dmY').".doc";
        header("Content-Type: application/xml; charset=UTF-8");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=$filename");
        $this->load->view('curriculum_view', $datos);
        return;
    }
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */