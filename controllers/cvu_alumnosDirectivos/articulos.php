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
            $crud->columns( 'AnioPublica','Titulio','TipoArt','RevistaPublic','DocArt');
            $crud->display_as('AnioPublica','Año de Publicación')->display_as('Volumen','Volumen')->display_as('NumVoLumen','No. de Volumen')
                 ->display_as('Titulio','Titulo del Artículo')->display_as('ISSNAR','ISSN')->display_as('TipoArt','Tipo de Artículo')->display_as('RevistaPublic','Revista Publicación')
                 ->display_as('AutorArt','Autor/es')->display_as('DocArt','Doc. comprobatorio');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_delete();
            $crud-> unset_edit_fields ( 'Alumno_Matricula');
            $crud->unset_texteditor('AutorArt','full_text');
            $crud->required_fields('AnioPublica','Volumen','Titulio','TipoArt','RevistaPublic','AutorArt');
            $crud->set_field_upload('DocArt','assets/uploads/alumnos/'.$this->matricula);
            $crud->set_rules('DocArt','Doc. comprobatorio','max_length[26]');
            $crud->field_type('AnioPublica','dropdown',range(2000, 2030));
            $output = $crud->render();

            $this->_example_output($output);
        }
             else { redirect('login');
             }
    }




    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Artículos Publicados";
        $output->barra_navegacion = " <li><a href='directivo'> Menú principal </a></li> <li> <a href='alumnoscvu'> Menú CVU </a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }

}

