<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Congresos extends CI_Controller {

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

    function registroCongreso()
    {
         if ($this->session->userdata('logged_in'))
        {
                $this->session->keep_flashdata('matricula');
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->session->flashdata('matricula'));
                $crud->set_table('congresos');
                $crud->set_subject('Congreso');

                //$crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns( 'Alumno_Matricula', 'Titulo_trab','NomCongreso','AutoresCon','AnioCon','DocCongre');
                $crud->display_as('Alumno_Matricula','Nombre del alumno')->display_as('Titulo_trab','Titulo del Trabajo')->display_as('NomCongreso','Nombre del Congreso')->display_as('AutoresCon','Autor/es')
                     ->display_as('TipoTrabajo','Tipo de Trabajo')->display_as('tipo','Tipo')->display_as('Pais','País')
                     ->display_as('AnioCon','Año')->display_as('Pais','País')->display_as('DocCongre','Doc. comprobatorio');
                $crud->set_relation('Alumno_Matricula','alumno','{NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
                $crud->unset_print();
                $crud->unset_export();
                $crud->unset_add();
                $crud->unset_edit();
                $crud->unset_delete();
                $crud->field_type('AnioCon','dropdown',range(2000, 2030));
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('Titulo_trab','NomCongreso','AutoresCon','AnioCon','TipoTrabajo','tipo');
                $crud->set_field_upload('DocCongre','assets/uploads/alumnos/'.$this->session->flashdata('matricula'));
                $crud->unset_texteditor('AutoresCon','full_text');
                $crud->set_rules('DocCongre','Doc. comprobatorio','max_length[26]');
                $crud->set_relation('Pais','paises','nombre');

                $output = $crud->render();
                $this->_example_output($output);
        }
        else {
                redirect('login');
                }
    }


    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Participación en Congresos";
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li>  |  <li> <a href='cvu_alumnosDirectivos/datos_personales/registroAlumno'> lista de Alumnos CVU </a></li>  |  <li> <a href='alumnoscvu/menu/".$this->session->flashdata('matricula')."'> Menú CVU </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }






}

