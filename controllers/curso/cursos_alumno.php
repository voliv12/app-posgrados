<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cursos_alumno extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        //$this->matricula = $this->session->userdata('matricula');
    }

    function alumnos($gen=null, $per=null)
    {
        if($this->session->userdata('logged_in'))
        {
            /*$this->session->set_flashdata('gen',$gen);
            $this->session->set_flashdata('per',$per);*/

            $crud = new grocery_CRUD();
            $crud->where('nivel', $this->session->userdata('abrev_posgrado'));
            $crud->set_table('alumnoscvu');
            $crud->set_primary_key('idalumno');
            $crud->set_subject('curso')
                 ->unset_add()
                 ->unset_print()
                 ->unset_delete()
                 ->unset_export()
                 ->unset_edit();
            $titulo = "Alumnos de Posgrado ICS";

             if ($this->session->userdata('perfil') == "Director Instituto"){
                $barra = " <li><a href='director'>Menú principal</a></li>";
                }else {$barra = " <li><a href='directivo'>Menú principal</a></li>";}

            $crud->field_type('idalumno', 'hidden');
            $crud->unset_columns('idalumno');
            $crud->add_action('Consultar Cursos', '../assets/imagenes/book.png','', '',array($this,'just_a_test'));
            $output = $crud->render();
            $this->_example_output($output, $barra, $titulo);
        }else{
            redirect('login');
        }
    }

    function just_a_test($primary_key , $row)
    {
        $nombre = $row->NombreA." ".$row->ApellidoPA." ".$row->ApellidoMA;
        if ($this->session->userdata('perfil') != "Director Instituto")
            {return site_url('curso/cursos_alumno/alumno_curso/'.$row->idalumno.'/'.$nombre.'/'.$row->matricula);}
            else {return site_url('curso/cursos_alumno/alumno_curso_director/'.$row->idalumno.'/'.$nombre.'/'.$row->matricula.'/'.$row->nivel);}

        
    }


    function alumno_curso($idalumno, $nombre, $matricula)
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('alum_cursos');
            $crud->set_primary_key('NRC');
            $crud->where('idalumno', $idalumno);
            $crud->where('posgrado', $this->session->userdata('abrev_posgrado'));

            $crud->set_subject('curso');
            $crud->set_relation('codigo','documentando','{codigo}  -  {descripcion}',array('nivelacad' => $this->session->userdata('abrev_posgrado')));
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->display_as('codigo','Experiencia Educativa')
                 ->display_as('nombre_curso','Nombre del Curso');
            $crud->unset_add()
                 ->unset_print()
                 ->unset_delete()
                 ->unset_edit();
            $crud->field_type('idalumno', 'hidden');
            $crud->field_type('idcurso', 'hidden');
            $crud->unset_columns('idalumno', 'idcurso');
            $titulo = "Cursos tomados por: ".$matricula.' - '.urldecode($nombre);
            $barra = " <li><a href='directivo'>Menú principal</a></li>  |  <li><a href='curso/cursos_alumno/alumnos'> alumnos </a></li>";
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);

        }else{
            redirect('login');
        }
    }


    function alumno_curso_director($idalumno, $nombre, $matricula, $nivel)
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('alum_cursos');
            $crud->set_primary_key('NRC');
            $crud->where('idalumno', $idalumno);
            $crud->where('posgrado', $nivel);

            $crud->set_subject('curso');
            $crud->set_relation('codigo','documentando','{codigo}  -  {descripcion}',array('nivelacad' => $this->session->userdata('abrev_posgrado')));
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->display_as('codigo','Experiencia Educativa')
                 ->display_as('nombre_curso','Nombre del Curso');
            $crud->unset_add()
                 ->unset_print()
                 ->unset_delete()
                 ->unset_edit();
            $crud->field_type('idalumno', 'hidden');
            $crud->field_type('idcurso', 'hidden');
            $crud->unset_columns('idalumno', 'idcurso');
            $titulo = "Cursos tomados por: ".$matricula.' - '.urldecode($nombre);
            $barra = " <li><a href='director'>Menú principal</a></li>  |  <li><a href='curso/cursos_alumno/alumnos'> alumnos </a></li>";
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);

        }else{
            redirect('login');
        }
    }


    function _example_output($output = null, $barra = null, $titulo = null)
    {

        $output->titulo_tabla = $titulo;//"Alumnos de Posgrado ICS";
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        if ($this->session->userdata('perfil') != "Director Instituto")
            {$this->load->view('plantilla_directivo', $datos_plantilla);}
            else {$this->load->view('plantilla_director', $datos_plantilla);}
    }


}