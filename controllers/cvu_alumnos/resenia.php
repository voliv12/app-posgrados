<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resenia extends CI_Controller {

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

    function registroResenia()
    {   
        if ($this->session->userdata('logged_in'))
        {
                $crud = new grocery_CRUD();
                $crud->where('Alumno_Matricula', $this->matricula);
                $crud->set_table('resenia');
                $crud->set_subject('Reseña');
            
                $crud->field_type('Alumno_Matricula', 'hidden',$this->matricula );
                $crud->columns( 'TituloRese','TituloObra','TipoPublica','TituloPublica','DocRese');
                $crud->display_as('TituloRese','Titulo de la Reseña')->display_as('TituloObra','Titulo de la Obra')->display_as('TipoPublica','Tipo de Publicación')
                     ->display_as('AnioRe','Año')->display_as('pagInc',' De la Pag')->display_as('pagFin','A la Pag')->display_as('TituloPublica','Titulo de la Publicación')
                     ->display_as('RPais','País')->display_as('autorRese','Autor/es')->display_as('DocRese','Doc. comprobatorio');
                
                $crud->unset_print();
                $crud->unset_export();
                $crud->field_type('AnioRe','dropdown',range(2000, 2030));
                $crud-> unset_edit_fields ( 'Alumno_Matricula');
                $crud->required_fields( 'TituloRese','TituloObra','TipoPublica','TituloPublica');
                $crud->set_field_upload('DocRese','assets/uploads/alumnos/'.$this->matricula);
                $crud->set_rules('DocRese','Doc. comprobatorio','max_length[26]');
                

                $crud->field_type('RPais','dropdown',array( 
                        "México","Afganistan","Africa del Sur","Albania","Alemania","Andorra","Angola",
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
        $output->titulo_tabla = "Registro de Reseñas";
        $output->barra_navegacion = " <li><a href='alumno'>Menú principal</a></li>";
        $datos_plantilla['contenido'] =  $this->load->view('output_view', $output, TRUE);
        $this->load->view('plantilla_alumnos', $datos_plantilla);
    }
}

