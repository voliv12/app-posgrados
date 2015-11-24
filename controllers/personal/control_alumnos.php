<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control_alumnos extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

    function registrar_alumno()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('alumno')
                 ->set_subject('Alumno')
                 ->required_fields('Matricula', 'NombreA', 'ApellidoPA', 'ApellidoMA', 'Contrasenia')
                 ->display_as('NombreA','Nombre')
                 ->display_as('ApellidoPA','A Paterno')
                 ->display_as('ApellidoMA','A Materno')
                 ->display_as('rfc','RFC')
                 ->display_as('curp','CURP')
                 ->display_as('Contrasenia', 'Contraseña')
                 ->change_field_type('Contrasenia', 'password')
                 ->columns('NombreA','ApellidoPA','ApellidoMA','curp','correo');
            $crud->unset_edit_fields('Contrasenia');
            $crud->field_type('posgrado','hidden');
            $crud->add_action('Actualizar contraseña', '../assets/imagenes/refresh.png', 'personal/control_alumnos/cambiar_password');
            $crud->callback_before_insert(array($this,'acciones_callback'));
            $crud->callback_before_update(array($this,'acciones_callback'));
            $crud->callback_after_insert(array($this, 'crea_directorio'));

            $output = $crud->render();
            $output->titulo_tabla = "Registro de Alumnos";

            if($this->session->userdata('perfil') == 'Administrador del Sistema')
                {
                $barra = " <li><a href='administrador'>Menú principal</a></li>";
                } else if($this->session->userdata('perfil') == 'Apoyo Administrativo')
                        {
                        $barra = " <li><a href='administrativo'>Menú principal</a></li>";
                        } else {

                                $barra = " <li><a href='directivo'>Menú principal</a></li>";
                               }
            $this->_example_output($output, $barra);

        }else{
            redirect('login');
        }
    }


     function cambiar_password($idalumno)
        {
             if ($this->session->userdata('logged_in') )
            {
                $crud = new grocery_CRUD();
                $crud->where('idalumno', $idalumno);
                $crud->set_table('alumno')
                 ->set_subject('Alumno')
                 ->required_fields('Contrasenia')
                 ->display_as('NombreA','Nombre')
                 ->display_as('ApellidoPA','A Paterno')
                 ->display_as('ApellidoMA','A Materno')
                 ->display_as('Contrasenia', 'Contraseña')
                 ->change_field_type('Contrasenia', 'password')
                 ->columns('NombreA','ApellidoPA','ApellidoMA','Contrasenia');
                $crud->unset_edit_fields('NombreA','ApellidoPA','ApellidoMA','curp', 'rfc','Direccion',   'Telefono', 'Correo');
                $crud->field_type('NombreA','readonly')->field_type('ApellidoPA','readonly')->field_type('ApellidoMA','readonly')->field_type('password','password');
                $crud->unset_add();
                $crud->unset_delete();
                $crud->callback_before_insert(array($this,'acciones_callback'));
                $crud->callback_before_update(array($this,'acciones_callback'));

                    if($this->session->userdata('perfil') == 'Administrador')
                    {
                    $barra = " <li><a href='administrador'>Menú principal</a></li> | <li><a href='personal/control_alumnos/registrar_alumno'>Registro de Alumnos</a></li>";
                    } else if($this->session->userdata('perfil') == 'Apoyo Administrativo')
                            {
                            $barra = " <li><a href='administrativo'>Menú principal</a></li> | <li><a href='personal/control_alumnos/registrar_alumno'>Registro de Alumnos</a></li>";
                            } else {
                                    $barra = " <li><a href='directivo'>Menú principal</a></li> | <li><a href='personal/control_alumnos/registrar_alumno'>Registro de Alumnos</a></li>";
                                   }

                $output->titulo_tabla = 'Contraseña del usuario';
                $output = $crud->render();
                $this->_example_output($output, $barra);
            }else
            {
                redirect('login');
            }
        }





    function _example_output($output = null, $barra = null)
    {

        if($this->session->userdata('perfil') == 'Administrador')
        {
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_personal', $datos_plantilla);
        } else if($this->session->userdata('perfil') == 'Administrativo')
                {
                $output->barra_navegacion = $barra;
                $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                $this->load->view('plantilla_administrativo', $datos_plantilla);
                } else {

                        $output->barra_navegacion = $barra;
                        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                        $this->load->view('plantilla_directivo', $datos_plantilla);
                       }
    }


    function acciones_callback($post_array)
    {
        $this->load->library('encrypt');
        $post_array['NombreA'] = strtr(strtoupper($post_array['NombreA']),"áéíóúñ","ÁÉÍÓÚÑ");
        $post_array['ApellidoPA'] = strtr(strtoupper($post_array['ApellidoPA']),"áéíóúñ","ÁÉÍÓÚÑ");
        $post_array['ApellidoMA'] = strtr(strtoupper($post_array['ApellidoMA']),"áéíóúñ","ÁÉÍÓÚÑ");
        $post_array['Contrasenia'] = $this->encrypt->sha1($post_array['Contrasenia']);
        return $post_array;
    }

}
