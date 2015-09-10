<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anexo_a extends CI_Controller {

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

    function registro_Anexo_a($idproyecto, $titulo, $nombre)
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_a');
            $crud->set_subject('Anexo A');
            $crud->unset_edit();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno');
            $crud->unset_texteditor('avances','full_text');
            $crud->unset_texteditor('condiciones','full_text');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades 
                               actividades académicas y/o proyectos de tesis durante el semestre actual')
                 ->display_as('condiciones','Identificart las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                $barra = "<li><a href=directivo> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>";
            } else {
                $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";}
            
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo, $nombre);
        }
             else { redirect('login');
             }
    }




    function registro_Anexo_a_dir($idproyecto, $idalumno, $nombre, $nombreAlumno,$director, $titulo, $lgac, $coordina_posgrado )
    {                       
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_a');
            $crud->set_subject('Anexo A');

            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('idalumno', 'hidden',$idalumno );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            
            $state_crud = $crud->getState();

            /*if ($state_crud == 'edit' || $state_crud == 'update'|| $state_crud == 'read' ) {
                $crud->callback_edit_field('idalumno',array($this,'edit_field_callback'));
            } else {
                $crud->field_type('idalumno', 'hidden', $idalumno );

            }*/

            $crud->unset_columns('idproyec_alum', 'idalumno');
            
            //$crud->unset_texteditor('avances','full_text');
            //$crud->unset_texteditor('condiciones','full_text');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades 
                               actividades académicas y/o proyectos de tesis durante el semestre actual')
                 ->display_as('condiciones','Identificart las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos');
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {


                if ($state_crud == 'read' ) {
                $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li> |   <li class='text-align:right'><a id='printBtn'  class='easyui-linkbutton'>Imprimir</a> </li>";} 
                   else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>"; }


            } else {

                if ($state_crud == 'read' ) {
                $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>  |   <li class='text-align:right'><a id='printBtn'  class='easyui-linkbutton'>Imprimir</a> </li>";} 
                   else { $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";}



                
                }

            
            $output = $crud->render();

            $this->_example_output($output, $barra, $nombre, $nombreAlumno,$director, $titulo, $lgac, $coordina_posgrado);
        }
             else { redirect('login');
             }
    }


    function _example_output( $output = null, $barra = null,  $idalum = null, $nombreAlumno = null, $director = null, $titulo = null, $lgac = null, $coordina_posgrado = null)
    {
        $output->titulo_tabla = '<b>'."Anexo A. Programa de trabajo del tutor académico y/o director de tesis ".'<br>'."Matricula y nombre del estudiante: ".'</b>'.ucwords(mb_strtolower(urldecode($idalum))).'<br><b>'."Nombre del Tutor académico/Director de tesis: ".'</b>'.ucwords(mb_strtolower(urldecode($director))).'<br><b>'."Tema de tesis: ".'</b>'.urldecode($titulo).'<br><b>'."Linea de Generación y Aplicación del Conocimiento: ".'</b>'.urldecode($lgac).'<br>';
        $output->firmas = '<p>'."Nombre y firma del tutorado: ".ucwords(mb_strtolower(urldecode($nombreAlumno))).'<br><br><br><br>'."Nombre y firma del Tutor Académico: ".ucwords(mb_strtolower(urldecode($director))).'<br><br><br><br>'."Vo. Bo. Del Coordinador de Posgrado del Programa Educativo: ".ucwords(mb_strtolower(urldecode($coordina_posgrado))).'<br><br><br><p>';
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view_anexos', $output, TRUE);
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
