<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbecapifi extends CI_Controller {

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

    function registrobeca()
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->set_table('becaspifi');
            $crud->set_subject('Datos');
            $crud->required_fields('idBecasPifi','AnioBP','mesB','NumInstitu','PInstitu','NumProna','PProna','NumOtra','POtra'); 
            $crud->columns( 'AnioBP','mesB','NumInstitu','NumProna');
            $crud->display_as('AnioBP','Año')->display_as('mesB','Mes')->display_as('NumInstitu','Número de becas otorgadas por la institución (U.V)')
                 ->display_as('PInstitu','Porcentaje de becas otorgadas por la institución (U.V)')->display_as('NumProna','Número de becas otorgadas por el PRONABES')->display_as('PProna','Porcentaje de becas otorgadas por el PRONABES')
                 ->display_as('NumOtra','Número de becas otorgadas por otros programas o instituciones')->display_as('POtra','Porcentaje de becas otorgadas por otros programas o instituciones');
            $crud->unset_print();
            $crud->unset_export();
            $crud->callback_field('PInstitu',array($this,'field_callback_1'));
            $crud->callback_field('POtra',array($this,'field_callback_2'));
            $crud->callback_field('PProna',array($this,'field_callback_3'));
            $crud->field_type('AnioBP','dropdown',range(2000, 2030));

            if ($this->session->userdata('perfil') != "Director Instituto"){
            $barra = " <li><a href='directivo'> Menú principal </a></li>  "; 
            }else {
                  $barra = " <li><a href='director'> Menú principal </a></li>  "; 
                  }
            
            $output = $crud->render();
            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }


function field_callback_1($value = '', $primary_key = null)
{
    return '<input type="text" maxlength="50" value="'.$value.'" name="PInstitu" >%';
}
function field_callback_2($value = '', $primary_key = null)
{
    return '<input type="text" maxlength="50" value="'.$value.'" name="PProna" >%';
}
function field_callback_3($value = '', $primary_key = null)
{
    return '<input type="text" maxlength="50" value="'.$value.'" name="POtra" >%';
}

    function _example_output($output = null, $barra = null )
    {
        $output->titulo_tabla = "Becas";
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_directivo', $datos_plantilla);
    }

}

