<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anexo_c extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->idalumno = $this->session->userdata('idalumno');
        $this->load->model('usuarios_model');
    }

    function registro_Anexo_C($idproyecto, $nombre, $nombreAlumno,$director, $titulo, $lgac, $coordina_posgrado)
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
            $crud->unset_print();
            $crud->unset_export();
            $crud->field_type('idproyec_alum', 'hidden');
            $crud->field_type('idalumno', 'hidden');
            $crud->set_relation('periodo_anexo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno','beca_CONACYT','motivo');            
            $crud->display_as('periodo_anexo','Periodo')
                 ->display_as('desempeno_academico','Desempeño académico')
                 ->display_as('plan_estudio','Cumplimiento del plan de estudios')
                 ->display_as('obtencion_grado','Obtención del grado dentro del tiempo oficial del Plan de estudios ')
                 ->display_as('avance_tesis','Cuál es el porcentaje de avance de la tesis')
                 ->display_as('beca_CONACYT','En caso de que el estudiante cuente con una beca de CONACYT, y considerando 
                               las respuestas anteriores, así como, el art. 24 del reglamento de becas CONACYT sobre suspención, 
                               cancelación y conclusión de la beca, recomienda')
                 ->display_as('motivo','Describa el motivo')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            $state_crud = $crud->getState();
            
                if ($state_crud == 'add' )
                {
                    $nota = "Nota: Una vez guardada la información ya no será posible su modificación";
                }else{$nota = null;}


                if($this->session->userdata('perfil') == 'Director Instituto')
                {
                    if ($state_crud == 'read' ) {
                    $barra = "<li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>    ";
                    $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>";}
                       else { $barra = "<li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li> ";
                              $imprimir = null; }
                } else if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
                        {
                            if ($state_crud == 'read' ) {
                            $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li>   ";
                            $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>";}
                               else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyectos'> Proyectos </a></li> ";
                                      $imprimir = null; }

                        } else {
                                    if ($state_crud == 'read' ) {
                                    $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li> ";
                                    $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                                       else { $barra = "<li><a href='principal'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_alumno'> Proyecto </a></li>   ";
                                              $imprimir = null; }
                                }
            $barra2 ="<li><a href='proyectos/anexo_a/registro_Anexo_a/".$idproyecto."/".$nombre."/".$nombreAlumno."/".$director."/".$titulo."/".$lgac."/".$coordina_posgrado."'> Anexo A</a></li>  |  <li><a href='proyectos/anexo_b/registro_Anexo_b/".$idproyecto."/".$nombre."/".$nombreAlumno."/".$director."/".$titulo."/".$lgac."/".$coordina_posgrado."'> Anexo B</a></li>";
            $output = $crud->render();
            $this->_example_output($output, $barra, $barra2, $imprimir,$nombre, $nombreAlumno,$director, $titulo, $lgac, $coordina_posgrado, $nota);
        }
             else { redirect('login');
             }
    }


    function registro_Anexo_c_dir($idproyecto, $idalumno, $nombre, $nombreAlumno,$director, $titulo, $lgac, $coordina_posgrado)
    {
       if ($this->session->userdata('logged_in'))
        {
            $crud = new grocery_CRUD();
            $crud->where('idproyec_alum', $idproyecto);
            $crud->set_table('anexo_c');
            $crud->set_subject('Anexo C');
            $crud->field_type('idproyec_alum', 'hidden',$idproyecto );
            $crud->field_type('idalumno', 'hidden',$idalumno );
            $crud->set_relation('periodo_anexo','cat_periodos','{codigo}: {descripcion}',null,'codigo DESC');
            $crud->unset_columns('idproyec_alum', 'idalumno','beca_CONACYT','motivo');
            $crud->required_fields('periodo_anexo','desempeno_academico','plan_estudio','obtencion_grado','avance_tesis','beca_CONACYT','motivo','fecha');
            $crud->display_as('periodo_anexo','Periodo')
                 ->display_as('desempeno_academico','Desempeño académico')
                 ->display_as('plan_estudio','Cumplimiento del plan de estudios')
                 ->display_as('obtencion_grado','Obtención del grado dentro del tiempo oficial del Plan de estudios ')
                 ->display_as('avance_tesis','Cuál es el porcentaje de avance de la tesis')
                 ->display_as('beca_CONACYT','En caso de que el estudiante cuente con una beca de CONACYT, y considerando 
                               las respuestas anteriores, así como, el art. 24 del reglamento de becas CONACYT sobre suspención, 
                               cancelación y conclusión de la beca, recomienda')
                 ->display_as('motivo','Describa el motivo')
                 ->display_as('idproyec_alum','Titulo del Proyecto');
            $crud->unset_edit();
            $crud->unset_delete();
            $crud->unset_print();
            $crud->unset_export();
            $anexo = "Anexo C";
            $fecha_actual = strftime( "%Y-%m-%d", time() );
            $row = $this->usuarios_model->buscar_fechas($anexo);
    
                if ($fecha_actual < $row->fecha_inicio || $fecha_actual > $row->fecha_fin)
                {
                    $crud->unset_add();
                }
                

            $state_crud = $crud->getState();
            if ($state_crud == 'add' )
            {
                $nota = "Nota: Una vez guardada la información ya no será posible su modificación";
            }else{$nota = null;}

            if($this->session->userdata('perfil') == 'Coordinador de Posgrado')
            {
                if ($state_crud == 'read' ) {
                $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyectos </a></li>  |        ";
                $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                   else { $barra = "<li><a href='directivo'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyectos </a></li>  |         ";
                          $imprimir = null;  }


            } else if($this->session->userdata('perfil') == 'Director Instituto') 
                    {

                    if ($state_crud == 'read' ) {
                    $barra = "<li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>  |         ";
                    $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                       else { $barra = "<li><a href='director'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>  |       ";
                              $imprimir = null;  }
                    }else{
                            if ($state_crud == 'read' ) {
                            $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>  |        ";
                            $imprimir = "<li class='text-align:right'><a id='printBtn3'  class='easyui-linkbutton'><img src='../assets/imagenes/print.png' alt='Imprimir' title='Imprimir'></a> </li>" ;}
                            else { $barra = "<li><a href='academico'> Menú principal </a></li>  |  <li><a href='proyectos/proyecto_alumno/registro_proyecto_direccion'> Proyecto </a></li>  |         ";
                                   $imprimir = null;  }
                        }
            $barra2 = "<li><a href='proyectos/anexo_a/registro_Anexo_a_dir/".$idproyecto."/".$idalumno."/".$nombre."/".$nombreAlumno."/".$director."/".$titulo."/".$lgac."/".$coordina_posgrado."'> Anexo A</a></li>  |  <li><a href='proyectos/anexo_b/registro_Anexo_b_dir/".$idproyecto."/".$idalumno."/".$nombre."/".$nombreAlumno."/".$director."/".$titulo."/".$lgac."/".$coordina_posgrado."'> Anexo B</a></li>";
            $output = $crud->render();
            $this->_example_output($output, $barra, $barra2, $imprimir, $nombre, $nombreAlumno, $director, $titulo, $lgac, $coordina_posgrado, $nota);
        }
             else { redirect('login');
             }
    }




    function _example_output($output = null, $barra = null, $barra2 = null, $imprimir = null, $nombre = null, $nombreAlumno = null, $director = null, $titulo = null, $lgac = null, $coordina_posgrado = null, $nota = null)
    {   $output->nota =  $nota;
        $output->boton_imprimir =  $imprimir;
        $output->titulo_tabla = '<b>'."Anexo C. Informe del Director de tesis ".'<br>'."Matricula y nombre del estudiante: ".'</b>'.ucwords(mb_strtolower(urldecode($nombre))).'<br><b>'."Nombre del Tutor académico/Director de tesis: ".'</b>'.ucwords(mb_strtolower(urldecode($director))).'<br><b>'."Tema de tesis: ".'</b>'.urldecode($titulo).'<br>';
        $output->firmas = '<p>'."Nombre y firma del tutorado: ".ucwords(mb_strtolower(urldecode($nombreAlumno))).'<br><br><br><br>'."Nombre y firma del Tutor Académico: ".ucwords(mb_strtolower(urldecode($director))).'<br><br><br><br>'."Vo. Bo. Del Coordinador de Posgrado del Programa Educativo: ".ucwords(mb_strtolower(urldecode($coordina_posgrado))).'<br><br><br><p>';
        $output->barra_navegacion = $barra;
        $output->barra_anexos = $barra2;
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
                    }else {
                            $this->load->view('plantilla_alumnos', $datos_plantilla);
                           }    
    }

}
