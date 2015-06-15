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

    function registro_Anexo_a()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('Alumno_Matricula', $this->matricula);
            $crud->set_table('anexo_a');
            $crud->set_subject('Anexo A');
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades 
                               actividades académicas y/o proyectos de tesis durante el semestre actual:')
                 ->display_as('condiciones','Identificart las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos');


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
