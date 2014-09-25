<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Calendario extends CI_CONTROLLER
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('calendario_model');
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		$this->load->library('form_validation');

		//si la fecha a la que queremos acceder es menor que la anterior no dejamos pasar

	}

	public function cal($year = null, $month = null)
    {

        if(!$year)
        {
            $year = date('Y');
        }
        if(!$month)
        {
            $month = date('m');
        }

        //si el año y el mes al que queremos acceder es menor que el actual no dejamos
        /*if($this->uri->segment(3).'/'.$this->uri->segment(4) < date('Y').'/'.date('m'))
    	{
    		redirect(base_url('calendario/cal/'.date('Y').'/'.date('m')));
    	}*/

      	//como vemos en genera calendario le pasamos el año y el mes para que sepa que debe mostrar
        $data =  array('titulo' => 'Calendario con ci','calendario' => $this->calendario_model->genera_calendario($year, $month));
        $this->load->view('calendario_view', $data);
    }

    public function calen()
    {

    	//limpiamos el campo comentario y procesamos el formulario para marcar un evento
    		$this->form_validation->set_rules('comentario', 'comentario', 'trim|min_length[2]|max_length[100]|xss_clean');
    		$dia = strlen($this->input->post('dia'))==1 ? '0'.$this->input->post('dia') : $this->input->post('dia');
        	$year = strlen($this->input->post('year'))==1 ? '0'.$this->input->post('year') : $this->input->post('year');
        	$month = strlen($this->input->post('month'))==1 ? '0'.$this->input->post('month') : $this->input->post('month');
        	$fecha = "$year-$month-$dia";
        	$comentario = $this->input->post('comentario');

            $evento = $this->calendario_model->insert_calendario($fecha, $comentario);
            if($evento)
            {
            	echo $comentario;
            }else{
            	echo 'error';
            }
    }



}

//end controller