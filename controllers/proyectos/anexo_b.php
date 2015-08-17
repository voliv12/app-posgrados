<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anexo_b extends CI_Controller {

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

    function registro_Anexo_b($idproyecto, $titulo)
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_b');
            $crud->set_subject('Anexo B');
            $crud->unset_edit();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum');
            $crud->unset_texteditor('avances_academicos','full_text');
            $crud->display_as('avances_academicos','Describa los avances académicos presentados por el estudiante durante el periodo, así como los acuerdos y las estrategias de apoyo establecidas durante las sesiones de Tutoría')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                $barra = "<li><a href=directivo> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyecto </a></li>";
            } else {
                $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";}
            
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);
        }
             else { redirect('login');
             }
    }

    function registro_Anexo_b_dir($idproyecto, $titulo, $matricula)
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_b');
            $crud->set_subject('Anexo B');

            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('Alumno_Matricula', 'hidden',$matricula );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum');
            $crud->unset_texteditor('avances_academicos','full_text');
            $crud->display_as('avances_academicos','Describa los avances académicos presentados por el estudiante durante el periodo, así como los acuerdos y las estrategias de apoyo establecidas durante las sesiones de Tutoría')
                 ->display_as('idproyec_alum','Titulo del Proyecto');

            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                $barra = "<li><a href=directivo> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";
            } else {
                $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";}
            
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);
        }
             else { redirect('login');
             }
    }




    function _example_output($output = null, $barra = null, $titulo = null)
    {
        $output->titulo_tabla = "Anexo B: ".urldecode($titulo);
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
