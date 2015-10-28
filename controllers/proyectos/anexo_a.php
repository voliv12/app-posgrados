<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anexo_a extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        $this->idalumno = $this->session->userdata('idalumno');
        $this->load->model('usuarios_model');
    }

    function registro_Anexo_a($idproyecto, $nombre, $nombreAlumno,$director, $titulo, $lgac, $coordina_posgrado)
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_a');
            $crud->set_subject('Anexo A');
            $crud->unset_edit();
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_delete();

            $crud->unset_add();
            $crud->field_type('idproyec_alum', 'hidden');
            $crud->field_type('idalumno', 'hidden');
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades
                               actividades académicas y/o proyectos de tesis durante el semestre actual')
                 ->display_as('condiciones','Identificar las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos');

            $state_crud = $crud->getState();
                    
            if($this->session->userdata('perfil') == 'Director Instituto')
            {
                if ($state_crud == 'read' ) {
                $barra = "<li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li> ";
                $imprimir = "<li class='text-align:right'><a id='printBtn'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>";}
                   else { $barra = "<li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>";
                          $imprimir = null; }

            } else if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
                    {
                        if ($state_crud == 'read' ) {
                        $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li> ";
                        $imprimir = "<li class='text-align:right'><a id='printBtn'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>";}
                           else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>";
                                  $imprimir = null; }

                    } else {
                                if ($state_crud == 'read' ) {
                                $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";
                                $imprimir = "<li class='text-align:right'><a id='printBtn'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                                   else { $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";
                                          $imprimir = null; }
                            }

            $output = $crud->render();
            $this->_example_output($output, $barra, $imprimir,$nombre, $nombreAlumno,$director, $titulo, $lgac, $coordina_posgrado);
        }
             else { redirect('login');
                  }
    }




    function registro_Anexo_a_dir($idproyecto, $idalumno, $nombre, $nombreAlumno,$director, $titulo, $lgac, $coordina_posgrado )
    {
        if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_a');
            $crud->set_subject('Anexo A');
            $crud->unset_edit();
            $crud->unset_delete();
            
            $anexo = "Anexo A";
            $fecha_actual = strftime( "%Y-%m-%d", time() );
            $row = $this->usuarios_model->buscar_fechas($anexo);
            if ($fecha_actual < $row->fecha_inicio || $fecha_actual > $row->fecha_fin){
                $crud->unset_add();
            }
            

            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('idalumno', 'hidden',$idalumno );
            $crud->required_fields('semestre','periodo','avances','condiciones','fecha');
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno');
            $crud->display_as('avances','Determinar los avances que alacanzará en el desarrollo de sus actividades
                               actividades académicas y/o proyectos de tesis durante el semestre actual')
                 ->display_as('condiciones','Identificar las condiciones y actividades necesarias que requerirá el estudiante para logar los avances establecidos');

            $state_crud = $crud->getState();
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                if ($state_crud == 'read' ) {
                $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyectos </a></li> ";
                $imprimir = "<li class='text-align:right'><a id='printBtn'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                   else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyectos </a></li>";
                          $imprimir = null;  }


            } else {

                if ($state_crud == 'read' ) {
                $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>  ";
                $imprimir = "<li class='text-align:right'><a id='printBtn'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                   else { $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";
                          $imprimir = null;  }

                }
            $output = $crud->render();

            $this->_example_output($output, $barra, $imprimir, $nombre, $nombreAlumno, $director, $titulo, $lgac, $coordina_posgrado);
        }
             else { redirect('login');
             }
    }


    function _example_output( $output = null, $barra = null, $imprimir = null, $nombre = null, $nombreAlumno = null, $director = null, $titulo = null, $lgac = null, $coordina_posgrado = null)
    {   $output->boton_imprimir =  $imprimir;
        $output->titulo_tabla = '<b>'."Anexo A. Programa de trabajo del tutor académico y/o director de tesis ".'<br>'."Matricula y nombre del estudiante: ".'</b>'.ucwords(mb_strtolower(urldecode($nombre))).'<br><b>'."Nombre del Tutor académico/Director de tesis: ".'</b>'.ucwords(mb_strtolower(urldecode($director))).'<br><b>'."Tema de tesis: ".'</b>'.urldecode($titulo).'<br><b>'."Linea de Generación y Aplicación del Conocimiento: ".'</b>'.urldecode($lgac).'<br>';
        $output->firmas = '<p>'."Nombre y firma del tutorado: ".ucwords(mb_strtolower(urldecode($nombreAlumno))).'<br><br><br><br>'."Nombre y firma del Tutor Académico: ".ucwords(mb_strtolower(urldecode($director))).'<br><br><br><br>'."Vo. Bo. Del Coordinador de Posgrado del Programa Educativo: ".ucwords(mb_strtolower(urldecode($coordina_posgrado))).'<br><br><br><p>';
        $output->barra_navegacion = $barra;
        $datos_plantilla['contenido'] =  $this->load->view('output_view_anexos', $output, TRUE);
        if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
        {
            $this->load->view('plantilla_directivo', $datos_plantilla);
        } else if($this->session->userdata('perfil') == 'Director Instituto')
                {
                 $this->load->view('plantilla_director', $datos_plantilla);
                } else if($this->session->userdata('perfil') == 'Académico de Posgrado')
                    {
                     $this->load->view('plantilla_academico', $datos_plantilla);
                    }
                     else {
                            $this->load->view('plantilla_alumnos', $datos_plantilla);
                           }
    }

}
