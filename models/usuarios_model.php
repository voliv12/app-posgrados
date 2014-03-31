<?php
//require_once APPPATH.'models/Generic_Dataset_Model.php';

class Usuarios_model extends CI_Model
{        
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function buscar_en_BD($usuario, $password)
    {
        $this->db->select('*');
        $this->db->from('perfil');
        $this->db->join('academico','academico.noPersonal = perfil.academico_noPersonal');
        $this->db->where('academico_noPersonal', $usuario);
        $this->db->where('password', $password);
        $query = $this->db->get();
              
        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }
     }
     
     function listar_academicos()
    {
        $this->db->select('*');
        $this->db->from('academico');
        $this->db->join('categoria','academico.categoria = categoria.idCategoria'); 
        $this->db->order_by('academico.nombre');
        $query = $this->db->get();
        return $query->result_array();
     }     
     
     function contar_investigadores_tc()
    {
        $this->db->select('*');
        $this->db->from('academico');
        $this->db->join('categoria','academico.categoria = categoria.idCategoria');   
        $this->db->like('categoria.nombre_categoria','CARRERA'); //busco los ACADEMICOS DE CARRERA (investigadores)
        $this->db->like('categoria.nombre_categoria','T.C'); //que sean de TIEMPO COMPLETO
        return $this->db->count_all_results();                      
     }
     
     function contar_investigadores_mt()
    {
        $this->db->select('*');
        $this->db->from('academico');
        $this->db->join('categoria','academico.categoria = categoria.idCategoria');   
        $this->db->like('categoria.nombre_categoria','CARRERA'); //busco los ACADEMICOS DE CARRERA (investigadores)
        $this->db->like('categoria.nombre_categoria','M.T'); //que sean de MEDIO TIEMPO
        return $this->db->count_all_results();                      
     }
     
     function contar_tecnicos()
    {
        $this->db->select('*');
        $this->db->from('academico');
        $this->db->join('categoria','academico.categoria = categoria.idCategoria');   
        $this->db->like('categoria.nombre_categoria','TECNICO'); //busco los TECNICOS ACADEMICOS
        //$this->db->like('categoria.nombre','M.T'); //que sean de TIEMPO COMPLETO
        return $this->db->count_all_results();                      
     }
     
     function contar_por_depto($depto)
    {
        $this->db->select('*');
        $this->db->from('academico');        
        $this->db->where('departamento',$depto); //Busco a los investigadores por departamento       
        return $this->db->count_all_results();                      
     }
}

