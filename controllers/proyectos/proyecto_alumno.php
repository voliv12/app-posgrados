<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyecto_alumno extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        $this->matricula = $this->session->userdata('matricula');
    }

    function registro_proyecto_alumno()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('Alumno_Matricula', $this->matricula);
            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            //$crud->set_relation('Posgrado','','{abreviacion} - {Nombre}');
            $crud->unset_delete();
            $crud->unset_edit_fields ( 'Alumno_Matricula');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('nab' => 1));
            $crud->columns( 'Alumno_Matricula','titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            //$crud->required_fields('AnioPublica','Volumen','Titulio','TipoArt','RevistaPublic','AutorArt');
            
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', 'proyectos/anexo_c/registro_Anexo_c');
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', 'proyectos/anexo_b/registro_Anexo_b');
            $crud->add_action('Anexo A', '../assets/imagenes/a.png', 'proyectos/anexo_a/registro_Anexo_a');
            $barra = " <li><a href='principal'> Menú principal </a></li>  ";
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }
    function registro_proyecto_direccion()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('director_interno', $this->session->userdata('numPersonal'));
            $crud->or_where('codirector_interno', $this->session->userdata('numPersonal'));
            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            $crud->unset_print();
            $crud->unset_export();
            //$crud->set_relation_n_n('Alumno_Matricula.proyecto_alumno', 'cat_posgrados_alumno', 'Alumno_Matricula.', 'idproyecto_alumno', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('nab' => 1));
            $crud->columns( 'Alumno_Matricula','titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('nab' => 1));
            
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c_dir'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b_dir'));
            $crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a_dir'));
            if ($this->session->userdata('perfil')=="Coordinador de Posgrado"){
                 $barra = " <li><a href='directivo'> Menú principal </a></li>  ";
             }else if($this->session->userdata('perfil')=="Académico de Posgrado") {
            $barra = " <li><a href='academico'> Menú principal </a></li>";}
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }

    function registro_proyectos()
    {
        if ($this->session->userdata('logged_in'))
        {   
            $crud = new grocery_CRUD();
            $crud->where('posgrado',  $this->session->userdata('abrev_posgrado'));
            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('nab' => 1));
            $crud->columns( 'Alumno_Matricula','titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            $crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            
            
            $barra = " <li><a href='directivo'> Menú principal </a></li>  ";
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }

    function anexo_a($primary_key , $row)
    {   $titulo = $row->titulo_proyecto;
        return site_url('proyectos/anexo_a/registro_Anexo_a/'.$primary_key.'/'.$titulo);
    }
    function anexo_b($primary_key , $row)
    {   $titulo = $row->titulo_proyecto;
        return site_url('proyectos/anexo_b/registro_Anexo_b/'.$primary_key.'/'.$titulo);
    }
    function anexo_c($primary_key , $row)
    {   $titulo = $row->titulo_proyecto;
        return site_url('proyectos/anexo_c/registro_Anexo_c/'.$primary_key.'/'.$titulo);
    }
    function anexo_a_dir($primary_key , $row)
    {   $titulo = $row->titulo_proyecto;
        $matricula = $row->Alumno_Matricula;
        return site_url('proyectos/anexo_a/registro_Anexo_a_dir/'.$primary_key.'/'.$titulo.'/'.$matricula);
    }
    function anexo_b_dir($primary_key , $row)
    {   $titulo = $row->titulo_proyecto;
        $matricula = $row->Alumno_Matricula;
        return site_url('proyectos/anexo_b/registro_Anexo_b_dir/'.$primary_key.'/'.$titulo.'/'.$matricula);
    }
    function anexo_c_dir($primary_key , $row)
    {   $titulo = $row->titulo_proyecto;
        $matricula = $row->Alumno_Matricula;
        return site_url('proyectos/anexo_c/registro_Anexo_c_dir/'.$primary_key.'/'.$titulo.'/'.$matricula);
    }





    function _example_output($output = null, $barra = null)
    {
        $output->titulo_tabla = "Registro de proyecto";
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
        {
            $this->load->view('plantilla_directivo', $datos_plantilla);
        } else if($this->session->userdata('perfil') == 'Académico de Posgrado')
                {
                 $this->load->view('plantilla_academico', $datos_plantilla);
                } else {
                        $this->load->view('plantilla_alumnos', $datos_plantilla);
                       }
    }

}




