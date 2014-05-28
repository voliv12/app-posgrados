<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulos extends CI_Controller {

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

    function registroArticulo()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('Alumno_Matricula', $this->matricula);
            $crud->set_table('articulos');
            $crud->set_subject('Artículo');

            $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
            $crud->columns( 'AnioPublica','Volumen','Titulio','TipoArt','DocArt');
            $crud->display_as('AnioPublica','Año de Publicación')->display_as('Volumen','Volumen')->display_as('NumVoLumen','No. de Volumen')
                 ->display_as('Titulio','Titulo del Artículo')->display_as('TipoArt','Tipo de Artículo')->display_as('RevistaPublic','Revista Publicación')
                 ->display_as('AutorArt','Autor/es')->display_as('DocArt','Doc. comprobatorio');

            $crud-> unset_edit_fields ( 'Alumno_Matricula');
            $crud->required_fields('AnioPublica','Volumen','Titulio','TipoArt');
            $crud->set_field_upload('DocArt','assets/uploads/alumnos/'.$this->matricula);

            //Mensaje por si hay un error al insertar
            //$crud->set_lang_string('insert_error', 'El nombre del archivo es demasiado largo. Debe ser máximo de 20 caracteres');

            $output = $crud->render();

            $this->_example_output($output);
        }
             else { redirect('login');
             }
    }


    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Articulos Públicados";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

