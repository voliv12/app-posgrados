<?php
//require_once APPPATH.'models/Generic_Dataset_Model.php';

class Curriculum_model extends CI_Model
{
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function informacion_personal($matricula)
    {
        $this->db->select('*');
        $this->db->from('alumno');
        $this->db->where('Matricula', $matricula);
        $query = $this->db->get();

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }
    }

    function get_articulos($matricula)
    {
        $this->db->select('*');
        $this->db->from('articulos');
        $this->db->where('Alumno_Matricula', $matricula);
        $query = $this->db->get();

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->result_array();
        }
    }

}

