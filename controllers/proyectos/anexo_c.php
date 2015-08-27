<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anexo_c extends CI_Controller {

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

    function registro_Anexo_C($idproyecto, $titulo)
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_c');
            $crud->set_subject('Anexo C');
            $crud->unset_edit();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->set_relation('idalumno','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum');
            $crud->unset_texteditor('motivo','full_text');
            
            $crud->display_as('desempeno_academico','desempeño académico')
                 ->display_as('plan_estudio','Cumplimiento del plan de estudios')
                 ->display_as('obtencion_grado','Obtención del grado dentro del tiempo oficial del Plan de estudios ')
                 ->display_as('avance_tesis','Cuál es el porcentage de avance de la tesis')
                 ->display_as('beca_CONACYT','En caso de que el estudiante cuente con una beca de CONACYT, y considerando 
                               las respuestas anteriores, así como, el art. 24 del reglamento de becas CONACYT sobre suspención, 
                               cancelación y conclusión de la beca, recomienda')
                 ->display_as('motivo','Describa el motivo')
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


    function registro_Anexo_c_dir($idproyecto, $titulo, $idalumno)
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_c');
            $crud->set_subject('Anexo C');
            
            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('idalumno', 'hidden',$idalumno );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum');
            $crud->unset_texteditor('motivo','full_text');
            
            $crud->display_as('desempeno_academico','desempeño académico')
                 ->display_as('plan_estudio','Cumplimiento del plan de estudios')
                 ->display_as('obtencion_grado','Obtención del grado dentro del tiempo oficial del Plan de estudios ')
                 ->display_as('avance_tesis','Cuál es el porcentage de avance de la tesis')
                 ->display_as('beca_CONACYT','En caso de que el estudiante cuente con una beca de CONACYT, y considerando 
                               las respuestas anteriores, así como, el art. 24 del reglamento de becas CONACYT sobre suspención, 
                               cancelación y conclusión de la beca, recomienda')
                 ->display_as('motivo','Describa el motivo')
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
        $output->titulo_tabla = "Anexo C: ".urldecode($titulo);
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
                       }    }

}
