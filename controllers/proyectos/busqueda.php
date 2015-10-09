<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Busqueda extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        $this->load->model('usuarios_model');
        //$this->matricula = $this->session->userdata('matricula');
    }

    function academico_proyecto($acade=null)
    {
        if ($this->session->userdata('logged_in'))
        {   
            $crud = new grocery_CRUD();
            $crud->where('proyecto_alumno.posgrado',  $this->session->userdata('abrev_posgrado'));
            


            /*if($acade != "todos"){ $crud->where('director_interno', $acade);}
                else { if($acade != "todos"){ $crud->where('codirector_interno', $acade);}}
                     else{ if($acade != "todos"){ 
                        $array_proyec[] = $this->usuarios_model->buscar_idproyectos($acade);
                        foreach($array_proyec as $proyecto){
                            $crud->where('codirector_interno', $proyecto);
                        }}}
                    */


                        
             if($acade != "todos"){ 
                        $array_proyec = $this->usuarios_model->buscar_idproyectos($acade);
                        //$i=0;
                        foreach($array_proyec as $valor){
                            $crud->where('idproyecto_alumno', $valor['idproyecto_alumno']);
                            //echo $valor['idproyecto_alumno'];
                            //$i++;
                        }
                        print_r($array_proyec);}



            $crud->set_table('proyecto_alumno');
            $crud->set_subject('proyecto');
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->display_as('idalumno','Nombre del alumno')
                 ->display_as('titulo_proyecto','Titulo del proyecto');
            $crud->set_relation('idalumno','alumno','{NombreA} {ApellidoPA} {ApellidoMA} ');
            $crud->set_relation('LGAC','cat_lgac','{abreviacion} - {Nombre}');
            $crud->set_relation('director_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation('codirector_interno','personal','{NumPersonal} - {Nombre} {apellidos}', array('nab' => 1) );
            $crud->set_relation_n_n('comite_interno', 'proyecto_alumno_personal', 'personal', 'idproyecto_alumno', 'NumPersonal', '{personal.NumPersonal} - {personal.Nombre} {personal.apellidos}','priority',array('nab' => 1));
            $crud->columns( 'titulo_proyecto','director_interno','director_externo','codirector_interno','LGAC');
            //$crud->add_action('Anexo C', '../assets/imagenes/c.png', '', '', array($this, 'anexo_c'));
            //$crud->add_action('Anexo B', '../assets/imagenes/b.png', '', '', array($this, 'anexo_b'));
            //$crud->add_action('Anexo A', '../assets/imagenes/a.png', '', '', array($this, 'anexo_a'));
            $crud->unset_edit();
            
            $barra = " <li><a href='directivo'> Menú principal </a></li>  ";
            $output = $crud->render();

            $this->_example_output($output, $barra);
        }
             else { redirect('login');
             }
    }



 

    function _example_output($output = null, $barra = null)
    {
        $output->titulo_tabla = "Registro de proyecto";
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_filtro_proyectos', $output, TRUE);
        if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
        {
            $this->load->view('plantilla_directivo', $datos_plantilla);
        } else if($this->session->userdata('perfil') == 'Académico de Posgrado')
                {
                 $this->load->view('plantilla_academico', $datos_plantilla);
                } else {
                        $this->load->view('plantilla_alumnos', $datos_plantilla);
                       }
    } 


}




