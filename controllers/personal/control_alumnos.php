<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control_alumnos extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        //$this->matricula = $this->session->userdata('matricula');
    }

    function registrar_alumno()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('alumno')
                 ->set_subject('Alumno')
                 ->required_fields('Matricula', 'NombreA', 'ApellidoPA', 'ApellidoMA', 'Nivel', 'Contrasenia')
                 ->display_as('NombreA','Nombre')
                 ->display_as('ApellidoPA','A Paterno')
                 ->display_as('ApellidoMA','A Materno')
                 ->display_as('Contrasenia', 'Contraseña')
                 ->change_field_type('Contrasenia', 'password')
                 ->columns('Matricula','NombreA','ApellidoPA','ApellidoMA','Nivel','curp','rfc','Direccion','Telefono','Correo')
                ;

            $crud->callback_before_insert(array($this,'encrypt_password_callback'));
            $crud->callback_before_update(array($this,'encrypt_password_callback'));
            $crud->callback_after_insert(array($this, 'crea_directorio'));

            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Control de Alumnos";
        $output->barra_navegacion = " <li><a href='administrador'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_personal', $datos_plantilla);
    }

    function crea_directorio($post_array, $primary_key)
    {
        $this->load->helper('path');
        $dir = 'assets/uploads/alumnos/'.$post_array['Matricula'];

        if(!is_dir($dir))
        {
          mkdir($dir, 0777);
        }else
        {
          echo "Error: El Directorio ya existe.";
        }

        return TRUE;
    }

    function encrypt_password_callback($post_array)
    {
        $this->load->library('encrypt');
        $post_array['Matricula'] = strtoupper($post_array['Matricula']); //Aprovecho éste callback para convertir a mayúsculas la Matricula
        $post_array['Contrasenia'] = $this->encrypt->sha1($post_array['Contrasenia']);

        return $post_array;
    }

}
