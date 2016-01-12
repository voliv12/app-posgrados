<?php
//require_once APPPATH.'models/Generic_Dataset_Model.php';

class Usuarios_model extends CI_Model
{
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function buscar_tabla_alumno($usuario, $password)
    {
        $this->db->select('*');
        $this->db->from('alumno');
        $this->db->join('cat_posgrados_alumno','alumno.idalumno = cat_posgrados_alumno.idalumno');
        $this->db->where('matricula', $usuario);
        $this->db->where('Contrasenia', $password);
        $query = $this->db->get();

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }
    }

    function buscar_tabla_curso($idcurso)
    {
        $this->db->select('*');
        $this->db->from('cursos');
        $this->db->where('idcurso', $idcurso);
        $query = $this->db->get();

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }
    }

    function buscar_tabla_personal($usuario, $password)
    {
        $this->db->select('*');
        $this->db->from('personal');
        $this->db->join('perfil','personal.perfil = perfil.idperfil');
        //$this->db->join('cat_posgrados','personal.posgrado = cat_posgrados.idcat_posgrados');
        $this->db->where('NumPersonal', $usuario);
        $this->db->where('Contrasenia', $password);
        $query = $this->db->get();

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }
    }

    function buscar_coordinador($usuario)
    {
        $this->db->select('*');
        $this->db->from('personal');
        $this->db->join('perfil','personal.perfil = perfil.idperfil');
        $this->db->join('cat_posgrados','personal.posgrado = cat_posgrados.idcat_posgrados');
        $this->db->where('NumPersonal', $usuario);
        $query = $this->db->get();

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }
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

    function cosulta_posgrados($nivel)
    {
        $this->db->select('nombre_posgrado');
        $this->db->from('cat_posgrados');
        $this->db->where('nivel', $nivel);
        $query = $this->db->get();

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }
    }

       function buscar_fechas($anexo)
    {
        $this->db->select('*');
        $this->db->from('fecha_anexos');
        $this->db->where('nombre_anexo', $anexo);
        $query = $this->db->get();
        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }

    }


    function numero_alumno($gen, $pos)
    {
        $this->db->select('*');
        $this->db->from('cat_posgrados_alumno');
        $this->db->where('inicio', $gen);
        $this->db->where('nivel', $pos);
        //$query = $this->db->get();
        return $this->db->count_all_results();;
            

    }

    function numero_alumno_grado($gen, $pos)
    {
        $this->db->select('*');
        $this->db->from('cat_posgrados_alumno');
        $this->db->where('inicio', $gen);
        $this->db->where('nivel', $pos);
        $this->db->where('estatus', 'Graduado');

        //$query = $this->db->get();
        return $this->db->count_all_results();;
            

    }


    function buscar_generacion()
    {
        $this->db->select('*');
        $this->db->from('cat_generacion');
        $this->db->order_by('id_cat_generacion', 'DESC');
        $query = $this->db->get();
            if ($query->num_rows() == 0)
            {
                return FALSE;
            }else
            {
                return $query->result();
            }

    }

    function buscar_periodos()
    {
        $this->db->select('*');
        $this->db->from('cat_periodos');
        $this->db->order_by('codigo', 'DESC');
        $query = $this->db->get();
            if ($query->num_rows() == 0)
            {
                return FALSE;
            }else
            {
                return $query->result();
            }

    }

    function buscar_posgrados()
    {
        $this->db->select('*');
        $this->db->from('cat_posgrados');
        $query = $this->db->get();
            if ($query->num_rows() == 0)
            {
                return FALSE;
            }else
            {
                return $query->result();
            }

    }


    function buscar_posg($posg)
    {
        $this->db->select('idcat_posgrados');
        $this->db->from('cat_posgrados');
        $this->db->where('abrev_posgrado', $posg);
        $query = $this->db->get();
            if ($query->num_rows() == 0)
            {
                return FALSE;
            }else
            {
                return $query->row_array();
            }

    }

    function nombre_coordinador($idp)
    {
        $this->db->select('Nombre, apellidos');
        $this->db->from('personal');
        $this->db->where('posgrado', $idp);
        $query = $this->db->get();
            if ($query->num_rows() == 0)
            {
                return FALSE;
            }else
            {
                return $query->row_array();
            }

    }




    function buscar_idproyectos($acade)
    {
        $this->db->select('idproyecto_alumno');
        $this->db->from('proyecto_alumno_personal');
        $this->db->where('NumPersonal', $acade);
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

