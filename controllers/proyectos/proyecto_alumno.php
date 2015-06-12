<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyecto_alumno extends CI_Controller {

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

    function registro_proyecto_alumno()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('Alumno_Matricula', $this->matricula);
            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_edit_fields ( 'Alumno_Matricula');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            //$crud->required_fields('AnioPublica','Volumen','Titulio','TipoArt','RevistaPublic','AutorArt');
            $crud->add_action('Anexo C', '../assets/imagenes/refresh.png', 'proyectos/anexo_c/registro_Anexo_c');
            $crud->add_action('Anexo B', '../assets/imagenes/refresh.png', 'proyectos/anexo_b/registro_Anexo_b');
            $crud->add_action('Anexo A', '../assets/imagenes/refresh.png', 'proyectos/anexo_a/registro_Anexo_a');
            $output = $crud->render();

            $this->_example_output($output);
        }
             else { redirect('login');
             }
    }




    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de proyecto";
        $output->barra_navegacion = " <li><a href='principal'> Menú principal </a></li>  ";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }

}




