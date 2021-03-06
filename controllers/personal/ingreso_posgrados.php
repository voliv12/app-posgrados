<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingreso_posgrados extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->posgrado = $this->session->userdata('abrev_posgrado');
    }

    function alumno_posgrado()
    {
        if($this->session->userdata('logged_in') )
        {
            $crud = new grocery_CRUD();
            $crud->where('nivel',$this->posgrado);
                if($this->session->userdata('perfil') == 'Director Instituto')
                {
                    $crud->unset_add();
                    $crud->unset_edit();
                    $crud->unset_delete();
                }
            $crud->set_table('cat_posgrados_alumno')
                 ->set_subject('Alumno a posgrado')
                 ->display_as('idalumno','Alumno')
                 ->display_as('inicio','Año de inicio')
                 ->display_as('termino','Año de término')
                 ->display_as('nivel','Posgrado')
                 ->change_field_type('inicio', 'dropdown',array('2012' => '2012',
                                                            '2013' => '2013',
                                                            '2014' => '2014' ,
                                                            '2015' => '2015',
                                                            '2016' => '2016',
                                                            '2017' => '2017',
                                                            '2018' => '2018',
                                                            '2019' => '2019',
                                                            '2020' => '2020',
                                                            '2021' => '2021',
                                                            '2022' => '2022',
                                                            '2023' => '2023',
                                                            '2024' => '2024',
                                                            '2025' => '2025'
                                                            ))
                 ->columns('matricula','nivel','idalumno','estatus','inicio','termino','beca');
            $crud->set_relation('idalumno','alumno','{NombreA}  {ApellidoPA}  {ApellidoMA}');
            $crud->field_type('termino', 'hidden');
            $crud->field_type('nivel', 'hidden');
            $crud->required_fields('idalumno', 'matricula','estatus','inicio','beca');
            $crud->callback_after_insert(array($this, 'crea_directorio'));
            $crud->callback_before_insert(array($this,'acciones_callback'));
            $crud->callback_before_update(array($this,'acciones_callback'));
            $output = $crud->render();
            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function alumno_posgrado_admin()
    {
        if($this->session->userdata('logged_in') )
        {
            $crud = new grocery_CRUD();
            $crud->set_table('cat_posgrados_alumno')
                 ->set_subject('Alumno a posgrado')
                 ->display_as('idalumno','Alumno')
                 ->display_as('inicio','Año de inicio')
                 ->display_as('termino','Año de término')
                 ->display_as('nivel','Posgrado')
                 ->change_field_type('inicio', 'dropdown',array('2012' => '2012',
                                                            '2013' => '2013',
                                                            '2014' => '2014' ,
                                                            '2015' => '2015',
                                                            '2016' => '2016',
                                                            '2017' => '2017',
                                                            '2018' => '2018',
                                                            '2019' => '2019',
                                                            '2020' => '2020',
                                                            '2021' => '2021',
                                                            '2022' => '2022',
                                                            '2023' => '2023',
                                                            '2024' => '2024',
                                                            '2025' => '2025'
                                                            ))
                 ->columns('matricula','nivel','idalumno','estatus','inicio','termino','beca');
            $crud->set_relation('idalumno','alumno','{NombreA}  {ApellidoPA}  {ApellidoMA}');
            $crud->field_type('termino', 'hidden');
            $crud->field_type('nivel', 'hidden');
            $crud->required_fields('idalumno', 'matricula','estatus','inicio','beca');
            $crud->callback_after_insert(array($this, 'crea_directorio'));
            $crud->callback_before_insert(array($this,'acciones_callback'));
            $crud->callback_before_update(array($this,'acciones_callback'));
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_delete();
            $output = $crud->render();
            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }


    function _example_output($output = null)
    {
        $output->titulo_tabla = "Ingresar Alumnos a Posgrado";
        if($this->session->userdata('perfil') == 'Administrador del Sistema')
        {
        $output->barra_navegacion = " <li><a href='administrador'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_personal', $datos_plantilla);
        } else if($this->session->userdata('perfil') == 'Apoyo Administrativo')
                {
                $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
                $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                $this->load->view('plantilla_administrativo', $datos_plantilla);
                } else if($this->session->userdata('perfil') == 'Director Instituto')
                        {
                        $output->barra_navegacion = " <li><a href='director'>Menú principal</a></li>";
                        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                        $this->load->view('plantilla_director', $datos_plantilla);
                        } 
                        else {
                                $output->barra_navegacion = " <li><a href='directivo'>Menú principal</a></li>";
                                $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
                                $this->load->view('plantilla_directivo', $datos_plantilla);
                               }
    }


    function crea_directorio($post_array, $primary_key)
        {
            $this->load->helper('path');
            $dir = 'assets/uploads/alumnos/'.$post_array['matricula'];
            if(!is_dir($dir))
            {
              mkdir($dir, 0777);
            }else{
                  echo "Error: El Directorio ya existe.";
                 }
            return TRUE;
        }


    function acciones_callback($post_array)
    {
        if($this->posgrado <> "DCS"){
            $gene = $post_array['inicio'] + 2;
        }else {
                $gene = $post_array['inicio'] + 3;
              }

        $post_array['nivel'] = $this->posgrado;

        $post_array['termino'] = $gene;

        $post_array['matricula'] = strtoupper($post_array['matricula']); //Aprovecho éste callback para convertir a mayúsculas la Matricula
        
        $data = array('posgrado' => $this->posgrado );
        $this->db->where('idalumno', $post_array['idalumno'])->update('alumno',$data);
        return $post_array;
    }

}
