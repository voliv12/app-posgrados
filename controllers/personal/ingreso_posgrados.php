<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingreso_posgrados extends CI_Controller {

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

    function alumno_posgrdo()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('cat_posgrados_alumno')
                 ->set_subject('alumno a posgrado')
                 ->display_as('idcat_posgrados','Posgrado')
                 ->display_as('idalumno','Alumno')
                 ->display_as('inicio','Año de inicio')
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
                 ->columns('nivel','idcat_posgrados','matricula','idalumno','estatus','inicio','termino');

            $crud->set_relation('idcat_posgrados','cat_posgrados','nombre_posgrado');
            //$crud->set_relation('idcat_posgrados','cat_posgrados','{nivel} {nombre_posgrado}');
            $crud->set_relation('idalumno','alumno','{NombreA} - {ApellidoPA} - {ApellidoMA}');
             $crud->field_type('termino', 'hidden');
            //$crud->unset_fields('termino');
            //$crud->fields('idalumno','matricula','nivel','idcat_posgrados','estatus','inicio','beca');
            $crud->callback_before_insert(array($this,'acciones_callback'));
            $crud->callback_before_update(array($this,'acciones_callback'));
            

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



    function acciones_callback($post_array)
    {   

        if ($post_array['nivel'] == "Maestría" ){

            $gene = $post_array['inicio'] + 2;
            
        }else{
            $gene = $post_array['inicio'] + 3;
        }

        $post_array['termino'] = $gene;
        
        $post_array['matricula'] = strtoupper($post_array['matricula']); //Aprovecho éste callback para convertir a mayúsculas la Matricula
        return $post_array;
    }

}
