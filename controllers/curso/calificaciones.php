<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calificaciones extends CI_Controller {

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

    function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('calificaciones');
            $crud->set_subject('calificación');
            $crud->unset_print();
            $crud->unset_export();
            $crud->display_as('Alumno_Matricula','Nombre del Alumno')
                 ->display_as('boletacalific','Boleta de Calificación');
            $crud->set_relation('Alumno_Matricula','alumno','{NombreA}  -  {ApellidoPA}  -  {ApellidoMA}');
            $crud->field_type('periodo', 'dropdown',  array('201401' => 'Agosto 2013 - Enero 2014',
                                                            '201451' => 'Febrero - Julio 2014',
                                                            '201501' => 'Agosto 2014 - Enero 2015' ,
                                                            '201551' => 'Febrero - Julio 2015',
                                                            '201601' => 'Agosto 2015 - Enero 2016',
                                                            '201651' => 'Febrero - Julio 2016',
                                                            '201701' => 'Agosto 2016 - Enero 2017',
                                                            '201751' => 'Febrero - Julio 2017',
                                                            '201801' => 'Agosto 2017 - Enero 2018',
                                                            '201851' => 'Febrero - Julio 2018',
                                                            '201901' => 'Agosto 2018 - Enero 2019',
                                                            '201951' => 'Febrero - Julio 2019',
                                                            '202001' => 'Agosto 2019 - Enero 2020',
                                                            '202051' => 'Febrero - Julio 2020'
                                                            ));

            //$crud->set_relation('Alumno_Matricula','alumnoscvu','NombreA');
            //$crud->set_relation('Alumno_Matricula','alumnoscvu','{matricula}  -  {NombreA}  -  {ApellidoPA}  -  {ApellidoMA}', array('estatus' => 'Activo'));
            $crud->set_field_upload('boletacalific','assets/uploads/alumnos/Boletas');
            $crud->set_rules('boletacalific','Boleta de Calificación','max_length[40]');
            $crud->required_fields('Alumno_Matricula', 'boletacalific','periodo');
            $output = $crud->render();

            $this->_example_output($output);
        }else{
            redirect('login');
        }
    }

    function _example_output($output = null)

    {
        $output->titulo_tabla = "Boleta de calificación";
        $output->barra_navegacion = " <li><a href='administrativo'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_administrativo', $datos_plantilla);
    }

}
