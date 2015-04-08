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
        $this->perfil = $this->session->userdata('perfil');
    }

    function alumno_posgrdo()
    {
        if($this->session->userdata('logged_in') )
        {
            $crud = new grocery_CRUD();
            $crud->where('nivel','Maestría');
            $crud->set_table('cat_posgrados_alumno')
                 ->set_subject('alumno a posgrado')
                 ->display_as('idcat_posgrados','Maestría')
                 //->display_as('idcat_posgradosD','Doctorado')
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
                 ->columns('idcat_posgrados','matricula','idalumno','estatus','inicio','termino');

            
            $crud->set_relation('idcat_posgrados','cat_posgrados','nombre_posgrado',array('abrev_posgrado' => $this->perfil));
            //$crud->set_relation('idcat_posgradosD','cat_posgrados','nombre_posgrado',array('nivelp' => 'Doctorado'));
            $crud->set_relation('idalumno','alumno','{NombreA} - {ApellidoPA} - {ApellidoMA}');
            $crud->field_type('termino', 'hidden');
            $crud->field_type('nivel', 'hidden');
            $crud->field_type('idcat_posgradosD', 'hidden');
            $crud->callback_after_insert(array($this, 'crea_directorio'));
            $crud->callback_before_insert(array($this,'acciones_callback'));
            $crud->callback_before_update(array($this,'acciones_callback'));
            

            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }



//*******************************************************************************************************************
    function alumno_posgrdod()
    {
        if($this->session->userdata('logged_in') )
        {
            $crud = new grocery_CRUD();
            $crud->where('nivel','Doctorado');
            $crud->set_table('cat_posgrados_alumno')
                 ->set_subject('alumno a posgrado')
                 //->display_as('idcat_posgrados','Maestría')
                 ->display_as('idcat_posgradosD','Doctorado')
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
                 ->columns('idcat_posgradosD','matricula','idalumno','estatus','inicio','termino');

            
            //$crud->set_relation('idcat_posgrados','cat_posgrados','nombre_posgrado',array('nivelP' => 'Maestría'));
            $crud->set_relation('idcat_posgradosD','cat_posgrados','nombre_posgrado',array('abrev_posgrado' => $this->perfil));
            $crud->set_relation('idalumno','alumno','{NombreA} - {ApellidoPA} - {ApellidoMA}');
             $crud->field_type('termino', 'hidden');
            $crud->field_type('nivel', 'hidden');
            $crud->field_type('idcat_posgrados', 'hidden');
            $crud->callback_after_insert(array($this, 'crea_directorio'));
            $crud->callback_before_insert(array($this,'acciones_callback'));
            $crud->callback_before_update(array($this,'acciones_callback'));
            

            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }



//*********************************************************************************************************************





    function _example_output($output = null)
    {
        $output->titulo_tabla = "Control de Alumnos";
        $output->barra_navegacion = " <li><a href='directivo'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }


    function crea_directorio($post_array, $primary_key)
        {
            $this->load->helper('path');
            $dir = 'assets/uploads/alumnos/'.$post_array['matricula'];

            if(!is_dir($dir))
            {
              mkdir($dir, 0777);
            }else
            {
              echo "Error: El Directorio ya existe.";
            }

            return TRUE;
        }





    function acciones_callback($post_array)
    {   
        if($this->perfil <> "DCS"){
            $post_array['nivel'] = "Maestría";
            $gene = $post_array['inicio'] + 2;
        }else {
             $post_array['nivel'] = "Doctorado";
             $gene = $post_array['inicio'] + 3;
        }

        $post_array['termino'] = $gene;
        
        $post_array['matricula'] = strtoupper($post_array['matricula']); //Aprovecho éste callback para convertir a mayúsculas la Matricula
        return $post_array;
    }

}
