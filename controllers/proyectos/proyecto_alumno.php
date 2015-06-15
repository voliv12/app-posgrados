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
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_edit_fields ( 'Alumno_Matricula');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('nab' => 1));
            //$crud->required_fields('AnioPublica','Volumen','Titulio','TipoArt','RevistaPublic','AutorArt');
            
            $crud->add_action('Anexo C', '../assets/imagenes/refresh.png', 'proyectos/anexo_c/registro_Anexo_c');
            $crud->add_action('Anexo B', '../assets/imagenes/refresh.png', 'proyectos/anexo_b/registro_Anexo_b');
            $crud->add_action('Anexo A', '../assets/imagenes/refresh.png', 'proyectos/anexo_a/registro_Anexo_a');
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
            //$crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->unset_print();
            $crud->unset_export();
            //$crud->unset_edit_fields ( 'Alumno_Matricula');
            //$crud->set_relation('Alumno_Matricula','alumnoscvu','{NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('nab' => 1));
            //$crud->required_fields('AnioPublica','Volumen','Titulio','TipoArt','RevistaPublic','AutorArt');
            
            $crud->add_action('Anexo C', '../assets/imagenes/refresh.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/refresh.png', '', '', array($this, 'anexo_b'));
            $crud->add_action('Anexo A', '../assets/imagenes/refresh.png', '', '', array($this, 'anexo_a'));
            if ($this->session->userdata('nomperfil')=="Coordinador de Posgrado"){
                 $barra = " <li><a href='directivo'> Menú principal </a></li>  ";
             }else if($this->session->userdata('nomperfil')=="Académico de Posgrado") {}
                    $barra = " <li><a href='academico'> Menú principal </a></li>  ";
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }

    function anexo_a($primary_key , $row)
    {
        return site_url('proyectos/anexo_a/registro_Anexo_a/'.$primary_key);
    }
    function anexo_b($primary_key , $row)
    {
        return site_url('proyectos/anexo_b/registro_Anexo_b/'.$primary_key);
    }
    function anexo_c($primary_key , $row)
    {
        return site_url('proyectos/anexo_c/registro_Anexo_c/'.$primary_key);
    }



    function _example_output($output = null, $barra = null)
    {
        $output->titulo_tabla = "Registro de proyecto";
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }

}




