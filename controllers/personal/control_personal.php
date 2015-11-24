<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control_personal extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

    function registrar_personal()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('personal');
            $crud->set_subject('Personal')
                 ->required_fields('NumPersonal', 'Nombre','apellidos','tipo_personal','perfil','contrasenia')
                 ->display_as('contrasenia', 'Contraseña')
                 ->columns('NumPersonal','Nombre','apellidos','tipo_personal','perfil','posgrado','nab');
            $crud->unset_edit_fields('contrasenia');
            $crud->add_action('Actualizar contraseña', '../assets/imagenes/refresh.png', 'personal/control_personal/cambiar_password');
            $crud->set_relation('perfil','perfil','nomperfil');
            $crud->set_relation('posgrado','cat_posgrados','nombre_posgrado');
            $crud->callback_before_insert(array($this,'encrypt_password_callback'));
            $crud->callback_before_update(array($this,'encrypt_password_callback'));
            $output = $crud->render();
            $output->titulo_tabla = "Registro de Personal";
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

     function cambiar_password($NumPersonal)
        {
             if ($this->session->userdata('logged_in') )
            {
                $crud = new grocery_CRUD();
                $crud->where('NumPersonal', $NumPersonal);
                $crud->set_table('personal');
                $crud->set_subject('Personal')
                 ->required_fields('contrasenia')
                 ->display_as('contrasenia', 'Contraseña')
                 ->change_field_type('contrasenia', 'password')
                 ->unset_edit_fields('NumPersonal', 'Nombre', 'perfil')
                 ->columns('Nombre','contrasenia');
                $crud->unset_add();
                $crud->unset_delete();
                $crud->callback_before_insert(array($this,'encrypt_password_callback'));
                $crud->callback_before_update(array($this,'encrypt_password_callback'));
                    if($this->session->userdata('perfil') == 'Administrador del Sistema')
                    {$barra = " <li><a href='administrador'>Menú principal</a></li> | <li><a href='personal/control_personal/registrar_personal'>Registro de Personal</a></li> ";
                    } else if($this->session->userdata('perfil') == 'Apoyo Administrativo')
                            {$barra = " <li><a href='administrativo'>Menú principal</a></li> | <li><a href='personal/control_personal/registrar_personal'>Registro de Personal</a></li> ";
                            } else {$barra = " <li><a href='directivo'>Menú principal</a></li> | <li><a href='personal/control_personal/registrar_personal'>Registro de Personal</a></li> ";
                                   }
                $output = $crud->render();
                $output->titulo_tabla = 'Contraseña del usuario';
                $this->_example_output($output, $barra);

            }else{redirect('login');}
        }

    function _example_output($output = null, $barra = null)
    {
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_personal', $datos_plantilla);
    }

    function encrypt_password_callback($post_array)
    {
        $post_array['Nombre'] = strtr(strtoupper($post_array['Nombre']),"áéíóúñ","ÁÉÍÓÚÑ");
        $post_array['apellidos'] = strtr(strtoupper($post_array['apellidos']),"áéíóúñ","ÁÉÍÓÚÑ");
        $this->load->library('encrypt');
        $post_array['contrasenia'] = $this->encrypt->sha1($post_array['contrasenia']);
        return $post_array;
    }

}
