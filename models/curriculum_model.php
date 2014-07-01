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

    function get_tabla($tabla, $matricula) //Cualquier tobla sin relaciones
    {
        $this->db->select('*');
        $this->db->from($tabla);
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

    function get_tabla_paises($tabla, $matricula) //Cualquier tobla con relacion con PAISES
    {
        $this->db->select('*');
        $this->db->from($tabla);
        $this->db->where('Alumno_Matricula', $matricula);
        $this->db->join('paises', 'paises.id = '.$tabla.'.Pais');
        $query = $this->db->get();

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->result_array();
        }
    }

    function get_divulgacion($matricula)
    {
        $this->db->select('*');
        $this->db->from('divulgacion');
        $this->db->where('Alumno_Matricula', $matricula);
        $this->db->join('catalogodivulgacion', 'catalogodivulgacion.idCatalogoDivulgacion = divulgacion.idCatalogoDivulgacion');
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

