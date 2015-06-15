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
        $this->matricula = $this->session->userdata('matricula');
    }

    function registro_Anexo_C()
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('Alumno_Matricula', $this->matricula);
            $crud->set_table('anexo_c');
            $crud->set_subject('Anexo C');
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            //$crud->field_type('idproyecto_alumno', 'hidden',$idproyecto_alumno );
            $crud->display_as('desempeno_academico','desempeño académico')
                 ->display_as('plan_estudio','Cumplimiento del plan de estudios')
                 ->display_as('obtencion_grado','Obtención del grado dentro del tiempo oficial del Plan de estudios ')
                 ->display_as('avance_tesis','Cuál es el porcentage de avance de la tesis')
                 ->display_as('beca_CONACYT','En caso de que el estudiante cuente con una beca de CONACYT, y considerando 
                               las respuestas anteriores, así como, el art. 24 del reglamento de becas CONACYT sobre suspención, 
                               cancelación y conclusión de la beca, recomienda')
                 ->display_as('motivo','Describa el motivo');

            $output = $crud->render();

            $this->_example_output($output);
        }
             else { redirect('login');
             }
    }




    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de proyecto";
        $output->barra_navegacion = " <li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno'> Proyecto </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }

}
