<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyectos_academico extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        
    }

     function academicos()
    {   
        
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('tipo_personal', 'Académico' ); 
            $crud->set_table('personal');
            $crud->set_subject('Personal');
            $crud->unset_print();
            $crud->unset_edit();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete()
                 ->required_fields('NumPersonal', 'Nombre','apellidos','tipo_personal','perfil','contrasenia')
                 ->display_as('contrasenia', 'Contraseña')
                 ->columns('NumPersonal','Nombre','apellidos','tipo_personal','perfil','posgrado','nab');
            $crud->unset_edit_fields('contrasenia');
            //$crud->field_type('contrasenia', 'hidden');
            $crud->add_action('Proyectos como asesor', '../assets/imagenes/tres.png', 'proyectos/proyectos_academico/proyectos_asesor_academico');
            //$crud->add_action('Proyectos como asesor-UV', '../assets/imagenes/refresh.png', 'proyectos/proyectos_academico/proyectos_asesor_academico_nonab');
            $crud->add_action('Proyectos como codirector', '../assets/imagenes/dos.png', 'proyectos/proyectos_academico/proyectos_codireccion_academico');
            $crud->add_action('Proyectos como director', '../assets/imagenes/uno.png', 'proyectos/proyectos_academico/proyectos_direccion_academico');
            $crud->set_relation('perfil','perfil','nomperfil');
            $crud->columns( 'NumPersonal','Nombre','apellidos','tipo_personal', 'nab');
            $crud->set_relation('posgrado','cat_posgrados','nombre_posgrado');

            if ($this->session->userdata('perfil') != "Director Instituto"){
            $barra = " <li><a href='directivo'> Menú principal </a></li>  "; 
            }else {
                  $barra = " <li><a href='director'> Menú principal </a></li>  "; 
                  }



            $titulo = "Proyectos por academico";
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);
            

        }
             else { redirect('login');
             }
    }



    function proyectos_direccion_academico($primary_key)
    {
        $crud = new grocery_CRUD();
        if ($this->session->userdata('perfil') != "Director Instituto"){
            $barra = " <li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyectos_academico/academicos'> Proyectos por Académico </a></li>  "; 
             $crud->where('proyecto_alumno.posgrado',  $this->session->userdata('abrev_posgrado'));
             $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus');
            }else {
                  $barra = " <li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyectos_academico/academicos'> Proyectos por Académico </a></li>  ";
                  $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus','posgrado');
                  }
       
        if ($this->session->userdata('logged_in'))
        {
            
            $crud->where('director_interno', $primary_key);
            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->display_as('idalumn','Nombre del alumno')
                 ->display_as('titulo_proyecto','Titulo del proyecto');
            $crud->set_relation('idalumn','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno_NAB', 'proyecto_alumno_nab', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('nab' => 1));
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('tipo_personal' => 'Académico','nab' => 0));

            /*$crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            */
            $crud->unset_edit();

         
            $titulo = "Proyectos Como Director";
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);
        }
             else { redirect('login');
             }
    }


    function proyectos_codireccion_academico($primary_key)
    {
        $crud = new grocery_CRUD();
        if ($this->session->userdata('perfil') != "Director Instituto"){
            $barra = " <li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyectos_academico/academicos'> Proyectos por Académico </a></li>  "; 
             $crud->where('proyecto_alumno.posgrado',  $this->session->userdata('abrev_posgrado'));
             $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus');
            }else {
                  $barra = " <li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyectos_academico/academicos'> Proyectos por Académico </a></li>  ";
                  $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus','posgrado');
                  }
        if ($this->session->userdata('logged_in'))
        {
            
            $crud->where('codirector_interno', $primary_key );
            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->display_as('idalumn','Nombre del alumno')
                 ->display_as('titulo_proyecto','Titulo del proyecto');
            $crud->set_relation('idalumn','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno_NAB', 'proyecto_alumno_nab', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('nab' => 1));
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('tipo_personal' => 'Académico','nab' => 0));

            //$crud->columns( 'titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            /*$crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            */
            $crud->unset_edit();

            //$barra = " <li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyectos_academico/academicos'> Proyectos por Académico </a></li>  ";
            $titulo = "Proyectos Como Codirector";
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);
        }
             else { redirect('login');
             }
    }




    function proyectos_asesor_academico($primary_key)
    {
        $crud = new grocery_CRUD();
        if ($this->session->userdata('perfil') != "Director Instituto"){
            $barra = " <li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyectos_academico/academicos'> Proyectos por Académico </a></li>  "; 
             $crud->where('proyectos_asesor.posgrado',  $this->session->userdata('abrev_posgrado'));
             $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus');
            }else {
                  $barra = " <li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyectos_academico/academicos'> Proyectos por Académico </a></li>  ";
                  $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus','posgrado');
                  }

        if ($this->session->userdata('logged_in'))
        {
            $crud->set_table('proyectos_asesor');
            $crud->set_primary_key('idproyecto_alumno');
            $crud->where('proyectos_asesor.NumPersonal', $primary_key);
            $crud->set_subject('proyecto');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete(); 
            $crud->unset_fields('idproyecto_alumno_nab','NumPersonal','priority');  
            $crud->display_as('idalumn','Nombre del alumno')
                 ->display_as('titulo_proyecto','Titulo del proyecto');
            $crud->set_relation('idalumn','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno_NAB', 'proyecto_alumno_nab', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('nab' => 1));
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno','NumPersonal','{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('tipo_personal' => 'Académico','nab' => 0));
            //$crud->columns( 'titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            /*$crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            */
            $crud->unset_edit();

            //$barra = " <li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyectos_academico/academicos'> Proyectos por Académico </a></li>  ";
            $titulo = "Proyectos Como Asesor";
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);
        }
             else { redirect('login');
             }
    }





    

    function _example_output($output = null, $barra = null, $titulo = null)
    {
        $output->titulo_tabla = $titulo;
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
        {
            $this->load->view('plantilla_directivo', $datos_plantilla);
        } else if($this->session->userdata('perfil') == 'Director Instituto')
                {
                 $this->load->view('plantilla_director', $datos_plantilla);
                } 
                else if($this->session->userdata('perfil') == 'Académico de Posgrado')
                {
                 $this->load->view('plantilla_academico', $datos_plantilla);
                }     else {
                            $this->load->view('plantilla_alumnos', $datos_plantilla);
                           }
    }

}




