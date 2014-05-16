<?php

Class Salir extends CI_controller{

     function __construct()
    {
        parent::__construct();
        /* Standard Libraries */
        $this->load->helper('url');
    }

    function index()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

