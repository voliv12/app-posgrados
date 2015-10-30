<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cambiar_password extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        /* Standard Libraries */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        /* ------------------ */
        $this->numPersonal = $this->session->userdata('numPersonal');
        $this->idalumno   = $this->session->userdata('idalumno');
    }

    function index()
    {   if($this->session->userdata('logged_in'))
        {
                $this->form_validation->set_rules('password','Contraseña','trim|required|min_length[5]|matches[passconf]');
                $this->form_validation->set_rules('passconf','Confirmar contraseña','trim|required|min_length[5]');

                if ($this->form_validation->run() == FALSE)
                {
                    $datos['mensaje'] = "Contraseña muy corta (mínimo 5 carácteres) ó las contraseñas que introdujo no coinciden. Intentelo de nuevo.";
                    $datos_plantilla['contenido'] = $this->load->view('success_login', $datos, true);

                    if ($this->session->userdata('perfil') == "Administrador del Sistema")
                    {
                        $this->load->view('plantilla_personal', $datos_plantilla);
                    }else  if ($this->session->userdata('perfil') == "Coordinador de Posgrado")
                            {
                                $this->load->view('plantilla_directivo', $datos_plantilla);
                            } else  if ($this->session->userdata('perfil') == "Director Instituto")
                                    {
                                        $this->load->view('plantilla_director', $datos_plantilla);
                                    }
                                    else  if ($this->session->userdata('perfil') == "Apoyo Administrativo")
                                        {
                                            $this->load->view('plantilla_administrativo', $datos_plantilla);
                                        }  else  if ($this->session->userdata('perfil') == "Académico de Posgrado")
                                                {
                                                    $this->load->view('plantilla_academico', $datos_plantilla);
                                                } else
                                                    {
                                                        $this->load->view('plantilla_alumnos', $datos_plantilla);
                                                    }
                }else
                {   extract($_POST);

                    $datos['mensaje'] = "La contraseña ha sido cambiada con éxito.".$num_alum;
                    $datos_plantilla['contenido'] = $this->load->view('success_cambio_pass', $datos, true);

                    if ($this->session->userdata('perfil') == "Administrador del Sistema")
                    {   $nuevo_pass = array('contrasenia' => $this->encrypt->sha1($password));
                        $this->db->where('NumPersonal', $this->numPersonal);
                        $this->db->update('personal', $nuevo_pass);
                        $this->load->view('plantilla_personal', $datos_plantilla);
                    }else  if ($this->session->userdata('perfil') == "Coordinador de Posgrado")
                            {   $nuevo_pass = array('contrasenia' => $this->encrypt->sha1($password));
                                $this->db->where('NumPersonal', $this->numPersonal);
                                $this->db->update('personal', $nuevo_pass);
                                $this->load->view('plantilla_directivo', $datos_plantilla);
                            } else  if ($this->session->userdata('perfil') == "Director Instituto")
                                    {   $nuevo_pass = array('contrasenia' => $this->encrypt->sha1($password));
                                        $this->db->where('NumPersonal', $this->numPersonal);
                                        $this->db->update('personal', $nuevo_pass);
                                        $this->load->view('plantilla_director', $datos_plantilla);
                                    }
                                    else  if ($this->session->userdata('perfil') == "Apoyo Administrativo")
                                        {   $nuevo_pass = array('contrasenia' => $this->encrypt->sha1($password));
                                            $this->db->where('NumPersonal', $this->numPersonal);
                                            $this->db->update('personal', $nuevo_pass);
                                            $this->load->view('plantilla_administrativo', $datos_plantilla);
                                        }  else  if ($this->session->userdata('perfil') == "Académico de Posgrado")
                                                {   $nuevo_pass = array('contrasenia' => $this->encrypt->sha1($password));
                                                    $this->db->where('NumPersonal', $this->numPersonal);
                                                    $this->db->update('personal', $nuevo_pass);
                                                    $this->load->view('plantilla_academico', $datos_plantilla);
                                                } else
                                                    {   $nuevo_pass = array('Contrasenia' => $this->encrypt->sha1($password));
                                                        $this->db->where('idalumno', $this->idalumno);
                                                        $this->db->update('alumno', $nuevo_pass);
                                                        $this->load->view('plantilla_alumnos', $datos_plantilla);
                                                    }


                    
                }
        }else
            {
                redirect('login');
            }
    }
}
