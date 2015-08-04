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
        $this->matricula = $this->session->userdata('matricula');
    }

    function registro_Anexo_a($idproyecto)
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

            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->set_relation('idproyec_alum','proyecto_alumno','titulo_proyecto');
            $crud->unset_texteditor('avances','full_text');
            $crud->unset_texteditor('condiciones','full_text');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades 
                               actividades académicas y/o proyectos de tesis durante el semestre actual:')
                 ->display_as('condiciones','Identificart las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                $barra = "<li><a href=directivo> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyecto </a></li>";
            } else {
                $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";}
            
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }

    function registro_Anexo_a_dir($idproyecto)
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_a');
            $crud->set_subject('Anexo A');

            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->set_relation('idproyec_alum','proyecto_alumno','titulo_proyecto');
            $crud->unset_texteditor('avances','full_text');
            $crud->unset_texteditor('condiciones','full_text');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades 
                               actividades académicas y/o proyectos de tesis durante el semestre actual:')
                 ->display_as('condiciones','Identificart las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";
            } else {
                $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";}
            
            
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }





    function _example_output( $output = null, $barra = null)
    {
        $output->titulo_tabla = "Anexo A";
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
