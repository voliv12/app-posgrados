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
            $crud->add_action('Proyectos como asesor', '../assets/imagenes/refresh.png', 'proyectos/proyectos_academico/proyectos_asesor_academico');
            $crud->add_action('Proyectos como codirector', '../assets/imagenes/refresh.png', 'proyectos/proyectos_academico/proyectos_codireccion_academico');
            $crud->add_action('Proyectos como director', '../assets/imagenes/refresh.png', 'proyectos/proyectos_academico/proyectos_direccion_academico');
            $crud->set_relation('perfil','perfil','nomperfil');
            $crud->columns( 'NumPersonal','Nombre','apellidos','tipo_personal', 'nab');
            $crud->set_relation('posgrado','cat_posgrados','nombre_posgrado');

            $barra = " <li><a href='directivo'> Menú principal </a></li>  ";
            $output = $crud->render();

            $this->_example_output($output, $barra);
            

        }
             else { redirect('login');
             }
    }



    function proyectos_direccion_academico($primary_key)
    {
        $crud = new grocery_CRUD();
        $crud->where('proyecto_alumno.posgrado',  $this->session->userdata('abrev_posgrado'));
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

            $crud->columns( 'titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            /*$crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            */
            $crud->unset_edit();

            $barra = " <li><a href='directivo'> Menú principal </a></li>  ";
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }


        function proyectos_codireccion_academico($primary_key)
    {
        $crud = new grocery_CRUD();
        $crud->where('proyecto_alumno.posgrado',  $this->session->userdata('abrev_posgrado'));
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

            $crud->columns( 'titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            /*$crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            */
            $crud->unset_edit();

            $barra = " <li><a href='directivo'> Menú principal </a></li>  ";
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }




        function proyectos_asesor_academico($primary_key)
    {
        $crud = new grocery_CRUD();
        $crud->where('proyecto_alumno.posgrado',  $this->session->userdata('abrev_posgrado'));
        if ($this->session->userdata('logged_in'))
        {
            
            $crud->set_model('gcrud_query_model');
            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete();
            //########Para filtrar los resultados
                $crud->basic_model->set_join_str("proyecto_alumno_nab", "proyecto_alumno.idproyecto_alumno = proyecto_alumno_nab.idproyecto_alumno");
                $where_array = array("proyecto_alumno_nab.NumPersonal" => $primary_key);
                $crud->basic_model->set_where_str($where_array);
            //########################*/
                $crud->basic_model->set_join_str("proyecto_alumno_personal", "proyecto_alumno.idproyecto_alumno = proyecto_alumno_personal.idproyecto_alumno");
                $where_arr = array("proyecto_alumno_personal.NumPersonal" => $primary_key);
                $crud->basic_model->set_where_str($where_arr);
            //###########################    
            $crud->display_as('idalumn','Nombre del alumno')
                 ->display_as('titulo_proyecto','Titulo del proyecto');
            $crud->set_relation('idalumn','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno_NAB', 'proyecto_alumno_nab', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('nab' => 1));
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'noNab', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('tipo_personal' => 'Académico','nab' => 0));
            $crud->columns( 'titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            /*$crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            */
            $crud->unset_edit();

            $barra = " <li><a href='directivo'> Menú principal </a></li>  ";
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }

    function anexo_a($primary_key , $row)
    {   $this->db->where('idproyecto_alumno',$primary_key);
        $tituloR = $this->db->get('proyecto_alumno')->row();
        $titulo = $tituloR->titulo_proyecto;
        $this->db->where('idcat_LGAC',$row->LGAC);
        $BLGAC = $this->db->get('cat_lgac')->row();
        $lgac = $BLGAC->nombre;
        if ($row->director_interno == '0' ){$director = $row->director_externo;}
            else{ $this->db->where('NumPersonal',$row->director_interno);
                  $academic = $this->db->get('personal')->row();
                  $director = $academic->Nombre.' '.$academic->apellidos;

                }
        $this->db->where('idalumno',$row->idalumn);
        $alumno = $this->db->get('alumno')->row();
        $this->db->where('idalumno',$row->idalumn);
        $matri = $this->db->get('cat_posgrados_alumno')->row();
        $nombre =  $matri->matricula.' - '.$alumno->NombreA.' '.$alumno->ApellidoPA.' '.$alumno->ApellidoMA;

        $nombreAlumno =  $alumno->NombreA.' '.$alumno->ApellidoPA.' '.$alumno->ApellidoMA;
            if ($row->posgrado=='MCS'){
                $this->db->where('posgrado',1);
                $coordina = $this->db->get('personal')->row();
                $coordina_posgrado = $coordina->Nombre.' '.$coordina->apellidos;
            } else if ($row->posgrado=='DCS'){
                       $this->db->where('posgrado',2);
                       $coordina = $this->db->get('personal')->row();
                       $coordina_posgrado = $coordina->Nombre.' '.$coordina->apellidos;
                       }
        return site_url('proyectos/anexo_a/registro_Anexo_a/'.$primary_key.'/'.$nombre.'/'.$nombreAlumno.'/'.$director.'/'.$titulo.'/'.$lgac.'/'.$coordina_posgrado);
    }
    function anexo_b($primary_key , $row)
    {   $this->db->where('idproyecto_alumno',$primary_key);
        $tituloR = $this->db->get('proyecto_alumno')->row();
        $titulo = $tituloR->titulo_proyecto;

        if ($row->director_interno == '0' ){$director = $row->director_externo;}
            else{ $this->db->where('NumPersonal', $row->director_interno);
                  $academic = $this->db->get('personal')->row();
                  $director = $academic->Nombre.' '.$academic->apellidos;
                }

        $this->db->where('idalumno',$row->idalumn);
        $alumno = $this->db->get('alumno')->row();
        $this->db->where('idalumno',$row->idalumn);
        $matri = $this->db->get('cat_posgrados_alumno')->row();
        $nombre =  $matri->matricula.' - '.$alumno->NombreA.' '.$alumno->ApellidoPA.' '.$alumno->ApellidoMA;
        $idalumno = $row->idalumn;
        $nombreAlumno =  $alumno->NombreA.' '.$alumno->ApellidoPA.' '.$alumno->ApellidoMA;
            if ($row->posgrado=='MCS'){
                $this->db->where('posgrado',1);
                $coordina = $this->db->get('personal')->row();
                $coordina_posgrado = $coordina->Nombre.' '.$coordina->apellidos;
            } else if ($row->posgrado=='DCS'){
                       $this->db->where('posgrado',2);
                       $coordina = $this->db->get('personal')->row();
                       $coordina_posgrado = $coordina->Nombre.' '.$coordina->apellidos;
                       }
        return site_url('proyectos/anexo_b/registro_Anexo_b/'.$primary_key.'/'.$nombre.'/'.$nombreAlumno.'/'.$director.'/'.$titulo.'/'.$coordina_posgrado);
    }
    function anexo_c($primary_key , $row)
    {   $this->db->where('idproyecto_alumno',$primary_key);
        $tituloR = $this->db->get('proyecto_alumno')->row();
        $titulo = $tituloR->titulo_proyecto;

        if ($row->director_interno == '0' ){$director = $row->director_externo;}
            else{ $this->db->where('NumPersonal', $row->director_interno);
                  $academic = $this->db->get('personal')->row();
                  $director = $academic->Nombre.' '.$academic->apellidos;
                }

        $this->db->where('idalumno',$row->idalumn);
        $alumno = $this->db->get('alumno')->row();
        $this->db->where('idalumno',$row->idalumn);
        $matri = $this->db->get('cat_posgrados_alumno')->row();
        $nombre =  $matri->matricula.' - '.$alumno->NombreA.' '.$alumno->ApellidoPA.' '.$alumno->ApellidoMA;
        $idalumno = $row->idalumn;
        $nombreAlumno =  $alumno->NombreA.' '.$alumno->ApellidoPA.' '.$alumno->ApellidoMA;
            if ($row->posgrado=='MCS'){
                $this->db->where('posgrado',1);
                $coordina = $this->db->get('personal')->row();
                $coordina_posgrado = $coordina->Nombre.' '.$coordina->apellidos;
            } else if ($row->posgrado=='DCS'){
                       $this->db->where('posgrado',2);
                       $coordina = $this->db->get('personal')->row();
                       $coordina_posgrado = $coordina->Nombre.' '.$coordina->apellidos;
                       }
        return site_url('proyectos/anexo_c/registro_Anexo_c/'.$primary_key.'/'.$nombre.'/'.$nombreAlumno.'/'.$director.'/'.$titulo.'/'.$coordina_posgrado);
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




