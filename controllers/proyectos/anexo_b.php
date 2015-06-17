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

    function registro_Anexo_b($idproyecto)
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_b');
            $crud->set_subject('Anexo B');
            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->set_relation('idproyec_alum','proyecto_alumno','titulo_proyecto');
            $crud->unset_texteditor('avances_academicos','full_text');
            $crud->display_as('avances_academicos','Describa los avances académicos presentados por el estudiante durante el periodo, así como los acuerdos y las estrategias de apoyo establecidas durante las sesiones de Tutoría')
                 ->display_as('idproyec_alum','Titulo del Proyecto');


            $output = $crud->render();

            $this->_example_output($output);
        }
             else { redirect('login');
             }
    }

    function registro_Anexo_b_dir($idproyecto)
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
            $crud->set_relation('idproyec_alum','proyecto_alumno','titulo_proyecto');
            $crud->unset_texteditor('avances_academicos','full_text');
            $crud->display_as('avances_academicos','Describa los avances académicos presentados por el estudiante durante el periodo, así como los acuerdos y las estrategias de apoyo establecidas durante las sesiones de Tutoría')
                 ->display_as('idproyec_alum','Titulo del Proyecto');


            $output = $crud->render();

            $this->_example_output($output);
        }
             else { redirect('login');
             }
    }




    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de proyecto";
        $output->barra_navegacion = " <li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }

}
