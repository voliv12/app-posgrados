<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Evencal Controller for Multiple Events Calendar
 *
 * Author       : Moch Zawaruddin Abdullah
 * Date Created : 25 May 2013
 * Version      : 1.0
 * Website		: zawaruddin.blogspot.com
 *
 * This application just for share, please contact me at zawaruddin017@gmail.com if you have an idea for improve this application. ^_^
 */

class Evencal extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('evencal_model', 'evencal');
		$this->load->library('calendar', $this->_setting());
		$this->load->helper('url');
        //$this->load->library('encrypt');
        $this->load->library('form_validation');
	}

	function index($year = null, $month = null, $day = null){
		 if($this->session->userdata('logged_in'))
        {
		$year  = (empty($year) || !is_numeric($year))?  date('Y') :  $year;
		$month = (is_numeric($month) &&  $month > 0 && $month < 13)? $month : date('m');
		$day   = (is_numeric($day) &&  $day > 0 && $day < 31)?  $day : date('d');

		$date      = $this->evencal->getDateEvent($year, $month);
		$cur_event = $this->evencal->getEvent($year, $month, $day);
		$data      = array(
						'notes' => $this->calendar->generate($year, $month, $date),
						'year'  => $year,
						'mon'   => $month,
						'month' => $this->_month($month),
						'day'   => $day,
						'events'=> $cur_event
					);
		$this->load->view('index', $data);
		}else
        {
            redirect('login');
        }
	}

	// for convert (int) month to (string) month in Indonesian
	function _month($month){
		if($this->session->userdata('logged_in'))
        {
		$month = (int) $month;
		switch($month){
			case 1 : $month = 'Enero'; Break;
			case 2 : $month = 'Febrero'; Break;
			case 3 : $month = 'Marzo'; Break;
			case 4 : $month = 'Abril'; Break;
			case 5 : $month = 'Mayo'; Break;
			case 6 : $month = 'Junio'; Break;
			case 7 : $month = 'Julio'; Break;
			case 8 : $month = 'Agosto'; Break;
			case 9 : $month = 'Septiembre'; Break;
			case 10 : $month = 'Octubre'; Break;
			case 11 : $month = 'Noviembre'; Break;
			case 12 : $month = 'Diciembre'; Break;
		}
		return $month;
		}else
        {
            redirect('login');
        }
	}

	// get detail event for selected date
	function detail_event(){
		if($this->session->userdata('logged_in'))
        {
		$this->form_validation->set_rules('year', 'Year', 'trim|required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('mon', 'Month', 'trim|required|is_natural_no_zero|less_than[13]|xss_clean');
		$this->form_validation->set_rules('day', 'Day', 'trim|required|is_natural_no_zero|less_than[32]|xss_clean');

		if ($this->form_validation->run() == FALSE){
			echo json_encode(array('status' => false, 'title_msg' => 'Error', 'msg' => 'Por favor, introduzca un valor válido'));
		}else{
			$data = $this->evencal->getEvent($this->input->post('year'), $this->input->post('mon'), $this->input->post('day'));
			if($data == null){
				echo json_encode(array('status' => false, 'title_msg' => 'No Existe Evento', 'msg' => 'No hay eventos en esta fecha'));
			}else{
				echo json_encode(array('status' => true, 'data' => $data));
			}
		}
		}else
        {
            redirect('login');
        }

	}

	// popup for adding event
	function add_event(){
		if($this->session->userdata('logged_in'))
        {
		$data = array(
					'day'   => $this->input->post('day'),
					'mon'   => $this->input->post('mon'),
					'month' => $this->_month($this->input->post('mon')),
					'year'  => $this->input->post('year'),
				);
		$this->load->view('add_event', $data);
		}else
        {
            redirect('login');
        }
	}

	// do adding event for selected date
	function do_add(){
		if($this->session->userdata('logged_in'))
        {
		$this->form_validation->set_rules('year', 'Year', 'trim|required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('mon', 'Month', 'trim|required|is_natural_no_zero|less_than[13]|xss_clean');
		$this->form_validation->set_rules('day', 'Day', 'trim|required|is_natural_no_zero|less_than[32]|xss_clean');
		$this->form_validation->set_rules('hour', 'Hour', 'trim|required|xss_clean');
		$this->form_validation->set_rules('minute', 'Minute', 'trim|required|xss_clean');
		$this->form_validation->set_rules('event', 'Event', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE){
			echo json_encode(array('status' => false, 'title_msg' => 'Error', 'msg' => 'Por favor, introduzca un valor válido'));
		}else{
			$this->evencal->addEvent($this->input->post('year'),
											 $this->input->post('mon'),
											 $this->input->post('day'),
											 $this->input->post('hour').":".$this->input->post('minute').":00",
											 $this->input->post('event'));
			echo json_encode(array('status' => true, 'time' => $this->input->post('time'), 'event' => $this->input->post('event')));
		}
		}else
        {
            redirect('login');
        }
	}

	// delete event
	function delete_event(){

		if($this->session->userdata('logged_in'))
        {
		$this->form_validation->set_rules('year', 'Year', 'trim|required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('mon', 'Month', 'trim|required|is_natural_no_zero|less_than[13]|xss_clean');
		$this->form_validation->set_rules('day', 'Day', 'trim|required|is_natural_no_zero|less_than[32]|xss_clean');
		$this->form_validation->set_rules('del', 'ID', 'trim|required|is_natural_no_zero|xss_clean');

		if ($this->form_validation->run() == FALSE){
			echo json_encode(array('status' => false));
		}else{
			$rows = $this->evencal->deleteEvent($this->input->post('year'),$this->input->post('mon'),$this->input->post('day'), $this->input->post('del'));
			if($rows > 0){
				echo json_encode(array('status' => true, 'row' => $rows));
			}else{
				echo json_encode(array('status' => true, 'row' => $rows, 'title_msg' => 'No Existe Evento', 'msg' => 'No hay eventos en esta fecha'));
			}
		}
		}else
        {
            redirect('login');
        }
	}

	// same as index() function
	function detail($year = null, $month = null, $day = null){
		if($this->session->userdata('logged_in'))
        {
		$year  = (empty($year) || !is_numeric($year))?  date('Y') :  $year;
		$month = (is_numeric($month) &&  $month > 0 && $month < 13)? $month : date('m');
		$day   = (is_numeric($day) &&  $day > 0 && $day < 31)?  $day : date('d');

		$date      = $this->evencal->getDateEvent($year, $month);
		$cur_event = $this->evencal->getEvent($year, $month, $day);
		$data 	   = array(
						'notes' => $this->calendar->generate($year, $month, $date),
						'year'  => $year,
						'mon'   => $month,
						'month' => $this->_month($month),
						'day'   => $day,
						'events'=> $cur_event
					);
		$this->load->view('index', $data);
		}else
        {
            redirect('login');
        }
	}

	// setting for calendar
	function _setting(){
		if($this->session->userdata('logged_in'))
        {

		return array(
			'start_day' 		=> 'monday',
			'show_next_prev' 	=> true,
			'next_prev_url' 	=> site_url('evencal/index'),
			'month_type'   		=> 'long',
            'day_type'     		=> 'short',
			'template' 			=> '{table_open}<table class="date">{/table_open}
								   {heading_row_start}&nbsp;{/heading_row_start}
								   {heading_previous_cell}<caption><a href="{previous_url}" class="prev_date" title="Previous Month">&lt;&lt;Prev</a>{/heading_previous_cell}
								   {heading_title_cell}{heading}{/heading_title_cell}
								   {heading_next_cell}<a href="{next_url}" class="next_date"  title="Next Month">Next&gt;&gt;</a></caption>{/heading_next_cell}
								   {heading_row_end}<col class="weekday" span="5"><col class="weekend_sat"><col class="weekend_sun">{/heading_row_end}
								   {week_row_start}<thead><tr>{/week_row_start}
								   {week_day_cell}<th>{week_day}</th>{/week_day_cell}
								   {week_row_end}</tr></thead><tbody>{/week_row_end}
								   {cal_row_start}<tr>{/cal_row_start}
								   {cal_cell_start}<td>{/cal_cell_start}
								   {cal_cell_content}<div class="date_event detail" val="{day}"><span class="date">{day}</span><span class="event d{day}">{content}</span></div>{/cal_cell_content}
								   {cal_cell_content_today}<div class="active_date_event detail" val="{day}"><span class="date">{day}</span><span class="event d{day}">{content}</span></div>{/cal_cell_content_today}
								   {cal_cell_no_content}<div class="no_event detail" val="{day}"><span class="date">{day}</span><span class="event d{day}">&nbsp;</span></div>{/cal_cell_no_content}
								   {cal_cell_no_content_today}<div class="active_no_event detail" val="{day}"><span class="date">{day}</span><span class="event d{day}">&nbsp;</span></div>{/cal_cell_no_content_today}
								   {cal_cell_blank}&nbsp;{/cal_cell_blank}
								   {cal_cell_end}</td>{/cal_cell_end}
								   {cal_row_end}</tr>{/cal_row_end}
								   {table_close}</tbody></table>{/table_close}');
	}else
        {
            redirect('login');
        }
	}
}