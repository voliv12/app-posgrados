<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anexo_b extends CI_Controller {

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

    function registro_Anexo_b($idproyecto, $nombre, $nombreAlumno,$director, $titulo, $coordina_posgrado )
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_b');
            $crud->set_subject('Anexo B');
            $crud->unset_edit();
            $crud->unset_add();
            $crud->unset_delete();
            $crud->field_type('idproyec_alum', 'hidden');
            $crud->field_type('idalumno', 'hidden');
             $crud->field_type('idproyec_alum', 'hidden' );
            $crud->field_type('idalumno', 'hidden' );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno');
            //$crud->unset_texteditor('avances_academicos','full_text');
            $crud->display_as('avances_academicos','Describa los avances académicos presentados por el estudiante durante el periodo, así como los acuerdos y las estrategias de apoyo establecidas durante las sesiones de Tutoría')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            $state_crud = $crud->getState();
            if($this->session->userdata('perfil') == 'Director Instituto')
            {
                if ($state_crud == 'read' ) {
                $barra = "<li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li> ";
                $imprimir = "<li class='text-align:right'><a id='printBtn2'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>";} 
                   else { $barra = "<li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>"; 
                          $imprimir = null; }

            } else if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
                    {
                        if ($state_crud == 'read' ) {
                        $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li> ";
                        $imprimir = "<li class='text-align:right'><a id='printBtn2'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>";} 
                           else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>"; 
                                  $imprimir = null; }

                    } else {
                                if ($state_crud == 'read' ) {
                                $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>"; 
                                $imprimir ="<li class='text-align:right'><a id='printBtn2'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                                   else { $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";
                                          $imprimir = null; }
                            }
            $output = $crud->render();

            $this->_example_output($output, $barra, $imprimir, $nombre, $nombreAlumno,$director, $titulo, $coordina_posgrado);
        }
           else { redirect('login');
                }
        }

    function registro_Anexo_b_dir($idproyecto, $idalumno, $nombre, $nombreAlumno,$director, $titulo, $coordina_posgrado )
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_b');
            $crud->set_subject('Anexo B');
            $crud->required_fields('periodo','avances_academicos','fecha');
            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('idalumno', 'hidden',$idalumno );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno');
            //$crud->unset_texteditor('avances_academicos','full_text');
            $crud->display_as('avances_academicos','Describa los avances académicos presentados por el estudiante durante el periodo, así como los acuerdos y las estrategias de apoyo establecidas durante las sesiones de Tutoría')
                 ->display_as('idproyec_alum','Titulo del Proyecto');

            $crud->unset_edit();
            $crud->unset_delete();
            $anexo = "Anexo B";
            $fecha_actual = strftime( "%Y-%m-%d", time() );
            $row = $this->usuarios_model->buscar_fechas($anexo);
            if ($fecha_actual < $row->fecha_inicio || $fecha_actual > $row->fecha_fin){
                $crud->unset_add();
            }
            

            $state_crud = $crud->getState();
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {


                if ($state_crud == 'read' ) {
                $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyectos </a></li> "; 
                $imprimir = "<li class='text-align:right'><a id='printBtn2'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                   else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyectos </a></li>"; 
                          $imprimir = null;  }


            } else {

                if ($state_crud == 'read' ) {
                $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>  ";
                $imprimir = "<li class='text-align:right'><a id='printBtn2'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;} 
                   else { $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";
                          $imprimir = null;  }
                
                }

            $output = $crud->render();

            $this->_example_output($output, $barra, $imprimir,$nombre, $nombreAlumno, $director, $titulo, $coordina_posgrado);
        }
             else { redirect('login');
             }
    }




    function _example_output ($output = null, $barra = null,  $imprimir = null, $nombre = null, $nombreAlumno = null, $director = null, $titulo = null, $coordina_posgrado = null)
    {   $output->boton_imprimir =  $imprimir;
        $output->titulo_tabla = '<b>'."Anexo B. Informe del Tutor Académico ".'<br>'."Matricula y nombre del estudiante: ".'</b>'.ucwords(mb_strtolower(urldecode($nombre))).'<br><b>'."Nombre del Tutor académico/Director de tesis: ".'</b>'.ucwords(mb_strtolower(urldecode($director))).'<br><b>'."Tema de tesis: ".'</b>'.urldecode($titulo).'<br>';
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
                } else {
                        $this->load->view('plantilla_alumnos', $datos_plantilla);
                       }
    }
}
