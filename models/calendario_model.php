<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendario_model extends CI_MODEL
{

	private $config = array();

	public function __construct()
    {
        parent::__construct();

        $this->config = array(
        	//día que queremos que empiece la semana
            'start_day' => 'lunes',

            //si queremos mostrar los links para avanzar y retroceder en el calendario
            'show_next_prev' => TRUE,

            //url de la función que le da los datos al calendario cuando pulsamos next o prev
            'next_prev_url' => 'http://localhost/calendario_ci/calendario/cal/'
        );

        $this->config['template'] = '
        //abrimos la tabla del calendario
        {table_open}<table id="calendario">{/table_open}

        //abrimos la cabecera del calendario
        {heading_row_start}<tr>{/heading_row_start}

        //enlace anterior
        {heading_previous_cell}<th><a id="links" class="previo" href="{previous_url}"><<</a></th>{/heading_previous_cell}

        //fecha entre los enlaces de la cabecera
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}

        //enlace siguiente
        {heading_next_cell}<th><a id="links" class="siguiente" href="{next_url}">>></a></th>{/heading_next_cell}

        //cerramos la cabecera del calendario
        {heading_row_end}</tr>{/heading_row_end}

        //días de la semana --> lunes => martes etc
        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td class="head_calendar">{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}
        //fin días de la semana


        {cal_row_start}<tr class="dias">{/cal_row_start}
        {cal_cell_start}<td class="dia">{/cal_cell_start}

        {cal_cell_content}
        <div class="num_dia">{day}</div>
        <div class="contenido">{content}</div>
        {/cal_cell_content}

        {cal_cell_content_today}
        <div class="hoy">{day}</div>
        <div class="contenido_hoy">{content}</div>
        {/cal_cell_content_today}

        {cal_cell_no_content}
        <div class="num_dia">{day}</div>
        {/cal_cell_no_content}

        //el día actual
        {cal_cell_no_content_today}
        <div class="highlight">{day}</div>
        {/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}
        {cal_cell_end}</td>{/cal_cell_end}
        {cal_row_end}</tr>{/cal_row_end}

        //cerramos el calendario
        {table_close}</table>{/table_close}
        ';
    }

    //cogemos los datos de la tabla eventos y la colocamos en cada día
    //del calendario
    public function get_datos_calendario($year, $month)
    {

        $this->db->like('fecha', "$year-$month", 'after');
        $query = $this->db->get('eventos');

        $datos_calendario = array();

        foreach ($query->result() as $row) 
        {
            //si el primer número encontrado a partir del octavo
            //encontrado en la fecha es un cero, es decir, los días 
            //01,02,03 etc le quitamos el 0 y mostramos el siguiente número
            //si no lo hacemos así nuestro calendario no mostrará los resultados
            //de los días del 1 al 9
            $index = ltrim(substr($row->fecha, 8, 2), '0');
            //datos calendario contiene la fila del comentario del evento de ese día
            $datos_calendario[$index] = $row->comentario;
           
        }
        //devolvemos los datos y así ya podemos pasarle estos datos al método genera_calendario($year, $month)
        return $datos_calendario;
    }

    public function insert_calendario($fecha, $comentario)
    {
        $data = array(
            'fecha' => $fecha,
            'comentario' => $comentario
        );
       return $this->db->insert('eventos',$data);
    }

    public function genera_calendario($year, $month)
    {
        //cargamos la librería calendar de codeigniter y le pasamos la 
        //configuración almacenada en el array config que hemos creado
        $this->load->library('calendar', $this->config);

        //en data obtenemos el resultado del método get_datos_calendario
        //y le pasamos para que funcione el año y el mes que realmente lo
        //recoge en la función cal del controlador como hemos visto antes
        $data = $this->get_datos_calendario($year, $month);

        //devolvemos nuestro calendario en funcionamiento
        return $this->calendar->generate($year, $month, $data);

    }
}
//end model