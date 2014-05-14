<?php

Class Salir extends CI_controller{

     function __construct()
    {
        parent::__construct();
        /* Standard Libraries */
        $this->load->helper('URL');
    }

    function index()
    {
        $this->session->sess_destroy();
        //$this->load->helper('cookie');
        redirect('login');
        //header("Location: salir");
		//die();
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

