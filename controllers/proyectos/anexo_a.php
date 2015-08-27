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

    function registro_Anexo_a($idproyecto, $titulo)
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
            $crud->set_relation('idalumno','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            //$crud->field_type('idalumno', 'hidden',$this->idalumno );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum');
            $crud->unset_texteditor('avances','full_text');
            $crud->unset_texteditor('condiciones','full_text');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades 
                               actividades académicas y/o proyectos de tesis durante el semestre actual:')
                 ->display_as('condiciones','Identificart las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                $barra = "<li><a href=directivo> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>";
            } else {
                $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";}
            
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);
        }
             else { redirect('login');
             }
    }




    function registro_Anexo_a_dir($idproyecto, $titulo, $idalumno)
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_a');
            $crud->set_subject('Anexo A');

            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            
            $state_crud = $crud->getState();

            if ($state_crud == 'edit' || $state_crud == 'update'|| $state_crud == 'read' ) {
                $crud->callback_edit_field('idalumno',array($this,'edit_field_callback'));
            } else {
                $crud->field_type('idalumno', 'hidden', $idalumno );

            }





            $crud->unset_columns('idproyec_alum', 'idalumno');
            $crud->unset_texteditor('avances','full_text');
            $crud->unset_texteditor('condiciones','full_text');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades 
                               actividades académicas y/o proyectos de tesis durante el semestre actual:')
                 ->display_as('condiciones','Identificart las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos');
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";
            } else {
                $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";}
            //$crud->callback_before_insert(array($this,'acciones_callback'));
            //$crud->callback_before_update(array($this,'acciones_callback'));
            
            $output = $crud->render();

            $this->_example_output($output, $barra, $titulo);
        }
             else { redirect('login');
             }
    }

     function edit_field_callback($idalumno, $primary_key){

        $this->db->where('idalumno',$idalumno); //Where id is the primary key for company table
        $alumno = $this->db->get('alumno')->row();

        return '<div id="field-idalumno" class="readonly_label">'.$alumno->NombreA.' '.$alumno->ApellidoPA.' '.$alumno->ApellidoMA.'</div>';
     }


    function _example_output( $output = null, $barra = null, $titulo = null)
    {
        $output->titulo_tabla = "Anexo A: ".urldecode($titulo);
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
