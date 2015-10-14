<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anexo_c extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        $this->idalumno = $this->session->userdata('idalumno');
    }

    function registro_Anexo_C($idproyecto, $nombre, $nombreAlumno,$director, $titulo, $coordina_posgrado )
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_c');
            $crud->set_subject('Anexo C');
            $crud->unset_edit();
            $crud->unset_add();
            $crud->unset_delete();

            $crud->field_type('idproyec_alum', 'hidden');
            $crud->field_type('idalumno', 'hidden');
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno','beca_CONACYT','motivo');
            //$crud->unset_texteditor('motivo','full_text');
            
            $crud->display_as('desempeno_academico','Desempeño académico')
                 ->display_as('plan_estudio','Cumplimiento del plan de estudios')
                 ->display_as('obtencion_grado','Obtención del grado dentro del tiempo oficial del Plan de estudios ')
                 ->display_as('avance_tesis','Cuál es el porcentaje de avance de la tesis')
                 ->display_as('beca_CONACYT','En caso de que el estudiante cuente con una beca de CONACYT, y considerando 
                               las respuestas anteriores, así como, el art. 24 del reglamento de becas CONACYT sobre suspención, 
                               cancelación y conclusión de la beca, recomienda')
                 ->display_as('motivo','Describa el motivo')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            $state_crud = $crud->getState();
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                if ($state_crud == 'read' ) {
                $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li> ";
                $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;} 
                   else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>"; 
                          $imprimir = null; }

            } else {
                        if ($state_crud == 'read' ) {
                        $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>"; 
                        $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                           else { $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>";
                                  $imprimir = null; }
                    }
            $output = $crud->render();

            $this->_example_output($output, $barra, $imprimir, $nombre, $nombreAlumno,$director, $titulo, $coordina_posgrado);
        }
             else { redirect('login');
             }
    }


    function registro_Anexo_c_dir($idproyecto, $idalumno, $nombre, $nombreAlumno,$director, $titulo, $coordina_posgrado )
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_c');
            $crud->set_subject('Anexo C');
            
            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('idalumno', 'hidden',$idalumno );
            $crud->set_relation('periodo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno','beca_CONACYT','motivo');
            //$crud->unset_texteditor('motivo','full_text');
            $crud->required_fields('periodo','desempeno_academico','plan_estudio','obtencion_grado','avance_tesis','beca_CONACYT','motivo','fecha');
            $crud->display_as('desempeno_academico','Desempeño académico')
                 ->display_as('plan_estudio','Cumplimiento del plan de estudios')
                 ->display_as('obtencion_grado','Obtención del grado dentro del tiempo oficial del Plan de estudios ')
                 ->display_as('avance_tesis','Cuál es el porcentaje de avance de la tesis')
                 ->display_as('beca_CONACYT','En caso de que el estudiante cuente con una beca de CONACYT, y considerando 
                               las respuestas anteriores, así como, el art. 24 del reglamento de becas CONACYT sobre suspención, 
                               cancelación y conclusión de la beca, recomienda')
                 ->display_as('motivo','Describa el motivo')
                 ->display_as('idproyec_alum','Titulo del Proyecto');

            $state_crud = $crud->getState();
            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {


                if ($state_crud == 'read' ) {
                $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyectos </a></li> "; 
                $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>";}
                   else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyectos </a></li>"; 
                          $imprimir = null;  }


            } else {

                if ($state_crud == 'read' ) {
                $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>  ";
                $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;} 
                   else { $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>";
                          $imprimir = null;  }
                
                }
            
 
            $output = $crud->render();

            $this->_example_output($output, $barra,  $imprimir, $nombre, $nombreAlumno,$director, $titulo, $coordina_posgrado);
        }
             else { redirect('login');
             }
    }




    function _example_output($output = null, $barra = null,  $imprimir = null, $nombre = null, $nombreAlumno = null, $director = null, $titulo = null, $coordina_posgrado = null)
    {   $output->boton_imprimir =  $imprimir;
        $output->titulo_tabla = '<b>'."Anexo C. Informe del Director de tesis ".'<br>'."Matricula y nombre del estudiante: ".'</b>'.ucwords(mb_strtolower(urldecode($nombre))).'<br><b>'."Nombre del Tutor académico/Director de tesis: ".'</b>'.ucwords(mb_strtolower(urldecode($director))).'<br><b>'."Tema de tesis: ".'</b>'.urldecode($titulo).'<br>';
        $output->firmas = '<p>'."Nombre y firma del tutorado: ".ucwords(mb_strtolower(urldecode($nombreAlumno))).'<br><br><br><br>'."Nombre y firma del Tutor Académico: ".ucwords(mb_strtolower(urldecode($director))).'<br><br><br><br>'."Vo. Bo. Del Coordinador de Posgrado del Programa Educativo: ".ucwords(mb_strtolower(urldecode($coordina_posgrado))).'<br><br><br><p>';
        $output->barra_navegacion = $barra;
        
        $datos_plantilla['contenido'] =  $this->load->view('output_view_anexos', $output, TRUE);
        if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
        {
            $this->load->view('plantilla_directivo', $datos_plantilla);
        } else if($this->session->userdata('perfil') == 'Académico de Posgrado')
                {
                 $this->load->view('plantilla_academico', $datos_plantilla);
                } else {
                        $this->load->view('plantilla_alumnos', $datos_plantilla);
                       }    }

}
