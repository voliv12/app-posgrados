<?php
//require_once APPPATH.'models/Generic_Dataset_Model.php';

class Catalogos_model extends CI_Model
{
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function catalogo_generacion()
    {
        $this->db->select('*');
        $this->db->from('cat_generacion');
        $query = $this->db->get();

        //return $query->result_array();
        return $query->row();
    }

}

