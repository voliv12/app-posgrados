<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gradonivel extends CI_Controller {

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

    function registroGrado()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('Alumno_Matricula', $this->matricula);
            $crud->set_table('nivelacademic');
            $crud->set_subject('Nivel o Grado Académico');
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->columns( 'Cedula','TituloNivel','NFecha','DocTitulo','DocCedula');
            $crud->display_as('NivelAc','Nivel/Grado Académico')->display_as('Cedula','No. Cédula')->display_as('TituloNivel','Titulo de Nivel/Grado')
                 ->display_as('NFecha','Fecha de Obtención')->display_as('Estatus','Estatus')->display_as('TituloTesis','Titulo de la Tesis')
                 ->display_as('Pais','País')->display_as('NSector','Sector')->display_as('NOrganizacion','Organización')->display_as('DocTitulo','Doc. comprobatorio Titulo')->display_as('DocCedula','Doc. comprobatorio Cédula');

            $crud-> unset_edit_fields ( 'Alumno_Matricula');
            $crud->required_fields('NivelAc','TituloNivel','NSector','NOrganizacion');
            $crud->set_field_upload('DocTitulo','assets/uploads/alumnos/'.$this->matricula);
            $crud->set_field_upload('DocCedula','assets/uploads/alumnos/'.$this->matricula);
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_delete();
            $crud->set_relation('Pais','paises','nombre');
            $crud->set_field_upload('DocArt','assets/uploads/alumnos/'.$this->matricula);
            $crud->set_rules('DocCedula','Doc. comprobatorio','max_length[26]');
            $crud->set_rules('DocTitulo','Doc. comprobatorio','max_length[26]');
            $output = $crud->render();

            $this->_example_output($output);
        }
             else { redirect('login');
             }
    }




    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Grado ó Nivel Académico";
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li> <li> <a href='alumnoscvu'> Menú CVU </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }

}

