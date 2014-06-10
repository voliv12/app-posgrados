<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estancias extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
        $this->load->library('grocery_CRUD');
        $this->matricula = $this->session->userdata('matricula');
    }

    function registroEstancias()
    {   

        if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->matricula);
                $crud->set_table('estancias');
                $crud->set_subject('Estancia de Investigación');
                $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns( 'Sector','Organizacion','LineaInvestiga','Logros','DocEstancia');
                $crud->display_as('Sector','Sector')->display_as('Organizacion','Organización')->display_as('EFinicio','Fecha de Inicio')->display_as('Logros','Principales Logros')
                     ->display_as('EFfin','Fecha de Finalización')->display_as('EPais','País')->display_as('LineaInvestiga','Lineas de Investigación')->display_as('DocEstancia','Doc. comprobatorio');

                $crud->unset_print();
                $crud->unset_export();
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields('Sector','Organizacion','Titulo','LineaInvestiga','Logros');
                $crud->set_field_upload('DocEstancia','assets/uploads/alumnos/'.$this->matricula);

                $crud->unset_texteditor('LineaInvestiga','full_text');
                $crud->unset_texteditor('Logros','full_text');
                $output = $crud->render();

                $crud->set_rules('DocEstancia','Doc. comprobatorio','max_length[26]');
                

                $crud->field_type('EPais','dropdown',array( 
                        "Mexico","Afganistan","Africa del Sur","Albania","Alemania","Andorra","Angola",
                        "Antigua y Barbuda","Antillas Holandesas","Arabia Saudita","Argelia","Argentina","Armenia","Aruba",
                        "Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarusia","Belgica",
                        "Belice","Benin","Bermudas","Bolivia","Bosnia","Botswana","Brasil","Brunei Darussulam","Bulgaria",
                        "Burkina Faso","Burundi","Butan","Camboya","Camerun","Canada","Cape Verde","Chad","Chile","China",
                        "Chipre","Colombia","Comoros","Congo","Corea del Norte","Corea del Sur","Costa de Marfíl","Costa Rica",
                        "Croasia","Cuba","Dinamarca","Djibouti","Dominica","Ecuador","Egipto","El Salvador","Emiratos Arabes Unidos",
                        "Eritrea","Eslovenia","España","Estados Unidos","Estonia","Etiopia","Fiji","Filipinas","Finlandia","Francia",
                        "Gabon","Gambia","Georgia","Ghana","Granada","Grecia","Groenlandia","Guadalupe","Guam","Guatemala",
                        "Guayana Francesa","Guerney","Guinea","Guinea-Bissau","Guinea Equatorial","Guyana","Haiti","Holanda",
                        "Honduras","Hong Kong","Hungria","India","Indonesia","Irak","Iran","Irlanda","Islandia","Islas Caiman",
                        "Islas Faroe","Islas Malvinas","Islas Marshall","Islas Solomon","Islas Virgenes Britanicas","Islas Virgenes (U.S.)",
                        "Israel","Italia","Jamaica","Japon","Jersey","Jordania","Kazakhstan","Kenia","Kiribati","Kuwait","Kyrgyzstan",
                        "Laos","Latvia","Lesotho","Libano","Liberia","Libia","Liechtenstein","Lituania","Luxemburgo","Macao","Macedonia",
                        "Madagascar","Malasia","Malawi","Maldivas","Mali","Malta","Marruecos","Martinica","Mauricio","Mauritania",
                        "Micronesia","Moldova","Monaco","Mongolia","Mozambique","Myanmar (Burma)","Namibia","Nepal","Nicaragua",
                        "Niger","Nigeria","Noruega","Nueva Caledonia","Nueva Zealandia","Oman","Pakistan","Palestina","Panama",
                        "Papua Nueva Guinea","Paraguay","Peru","Polinesia Francesa","Polonia","Portugal","Puerto Rico","Qatar","Reino Unido",
                        "Republica Centroafricana","Republica Checa","Republica Democratica del Congo","Republica Dominicana","Republica Eslovaca",
                        "Reunion","Ruanda","Rumania","Rusia","Sahara","Samoa","San Cristobal-Nevis (St. Kitts)","San Marino",
                        "San Vincente y las Granadinas","Santa Helena","Santa Lucia","Santa Sede (Vaticano)","Sao Tome & Principe",
                        "Senegal","Seychelles","Sierra Leona","Singapur","Siria","Somalia","Sri Lanka (Ceilan)","Sudan","Suecia",
                        "Suiza","Sur Africa","Surinam","Swaziland","Tailandia","Taiwan","Tajikistan","Tanzania","Timor Oriental",
                        "Togo","Tokelau","Tonga","Trinidad & Tobago","Tunisia","Turkmenistan","Turquia","Ucrania","Uganda",
                        "Union Europea","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Yemen","Yugoslavia","Zambia","Zimbabwe"));
                    


                $output = $crud->render();
                $this->_example_output($output);
        } 
        else { 
                redirect('login');
                }    

    }
    

    function _example_output($output = null)
    {
        $output->titulo_tabla = "Registro de Estancias de Investigación";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

