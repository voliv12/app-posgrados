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
        $this->idalumno = $this->session->userdata('idalumno');
    }

    function registro_proyecto_alumno()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('proyecto_alumno.idalumn', $this->idalumno);
            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            //$crud->field_type('idalumno', 'hidden',$this->idalumno );
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->set_relation('idalumn','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->unset_delete();
            $crud->unset_edit_fields ( 'idalumn');
            $crud->display_as('idalumn','Nombre del alumno')
                 ->display_as('titulo_proyecto','Titulo del proyecto');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('tipo_personal' => 'Académico','nab' => 0));
            $crud->set_relation_n_n('comite_interno_NAB', 'proyecto_alumno_nab', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('nab' => 1));
            $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus');
            

            $crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            
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
            $crud->unset_delete();
            $crud->display_as('idalumn','Nombre del alumno')
                 ->display_as('comite_interno','Comite interno UV')
                 ->display_as('titulo_proyecto','Titulo del proyecto');
            $crud->required_fields('titulo_proyecto','LGAC','posgrado','idalumn','director_interno', 'estatus');
            //$crud->set_relation_n_n('idalumno', 'cat_posgrados_alumno', 'alumno', 'cat_posgrados_alumno.idalumno', 'alumno.idalumno', '{NombreA}');
            $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus');
            $crud->set_relation('LGAC','cat_lgac','{Nombre}');
            $crud->set_relation('director_interno','personal','{Nombre} {apellidos} - {NumPersonal}', array('tipo_personal' => 'Académico') );
            $crud->set_relation('codirector_interno','personal','{Nombre} {apellidos} - {NumPersonal}', array('tipo_personal' => 'Académico'));
            $crud->set_relation_n_n('comite_interno_NAB', 'proyecto_alumno_nab', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('nab' => 1));
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('tipo_personal' => 'Académico','nab' => 0));
            //$crud->set_relation('idalumno','cat_posgrados_alumno','{matricula}');
            $crud->set_relation('idalumn','alumno','{NombreA} {ApellidoPA} {ApellidoMA} - {posgrado}');
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b_dir'));
            $crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a_dir'));
            
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c_dir'));
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
            $crud->where('proyecto_alumno.posgrado',  $this->session->userdata('abrev_posgrado'));
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
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('tipo_personal' => 'Académico','nab' => 0));
            $crud->set_relation_n_n('comite_interno_NAB', 'proyecto_alumno_nab', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.Nombre} {personal.apellidos} - {personal.NumPersonal}','priority', array('nab' => 1));
            $crud->columns( 'titulo_proyecto','idalumn','director_interno','director_externo','estatus');
            $crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            $crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            
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
    function anexo_a_dir($primary_key , $row)
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
        $this->db->where('nivel',$row->posgrado);
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

        return site_url('proyectos/anexo_a/registro_Anexo_a_dir/'.$primary_key.'/'.$idalumno.'/'.$nombre.'/'.$nombreAlumno.'/'.$director.'/'.$titulo.'/'.$lgac.'/'.$coordina_posgrado);
    }
    function anexo_b_dir($primary_key , $row)
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
        $this->db->where('nivel',$row->posgrado);
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

        return site_url('proyectos/anexo_b/registro_Anexo_b_dir/'.$primary_key.'/'.$idalumno.'/'.$nombre.'/'.$nombreAlumno.'/'.$director.'/'.$titulo.'/'.$coordina_posgrado);
    }
    function anexo_c_dir($primary_key , $row)
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
        $this->db->where('nivel',$row->posgrado);
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

        return site_url('proyectos/anexo_c/registro_Anexo_c_dir/'.$primary_key.'/'.$idalumno.'/'.$nombre.'/'.$nombreAlumno.'/'.$director.'/'.$titulo.'/'.$coordina_posgrado);
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




