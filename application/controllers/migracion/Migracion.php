<?php

class Migracion extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!isset($this->session->username)):
                header('Location: '.base_url());
        endif;
        
        isset($this->session->username) ? TRUE : header('Location: '.base_url("web/Ruta"));
        $this->load->helper('fechasHoras_helper');
        $this->load->model('migracion/Migracion_Model');
    }

    /**
    * Description of index
    * obtener inicio
    */
    function index() {
        // var_dump($this->Migracion_Model->ObtenerIdPais('PE'));die;
        $this->template->set('titulo', 'Migración de Data');
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
        $this->template->add_js('js/upload/upload.js');
        $this->template->add_js('js/upload/migracion.js');
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $this->template->load(140, 'migracion/v_migracion_data');
    }

    function CargarData()
    {
        if ($this->input->is_ajax_request()) {
            $desde = fecha_iso_8601($_POST['desde']).' '.$_POST['inicio'];
            $hasta = fecha_iso_8601($_POST['hasta']).' '.$_POST['fin'];
            $res=$this->Migracion_Model->ObtenerDataDeServidorAnterior($desde,$hasta);
            foreach ($res->result_array() as $key => $data) {
                try {
                    $this->Migracion_Model->MigrarDataReservaServidor($data);
                } catch (Exception $e) {
                    echo $e;
                }
            }
            echo 1;
        }
    }


    function ObtenerPaisData()
    {
        if ($this->input->is_ajax_request()) {
            $desde = fecha_iso_8601_c($_POST['desde'],1);
            $hasta = fecha_iso_8601_c($_POST['hasta'],0);
            $data = $this->Venta_Model->GetPorPaisData($desde,$hasta);
            $pais = $this->Venta_Model->GetPaisAsociado($desde,$hasta);
            echo json_encode([$data->result_array(),$pais->result_array()]);
        }
        else{
            echo 'error';
        }
    }

    /**
    * Description of ObtenerVentasRutas
    * obtener ventas por rutas
    */
    function ObtenerVentasRutas()
    {
    	define("id_formulario", 136);
    	$this->template->set('titulo', 'VENTAS POR RUTAS');
    	$this->template->add_js('js/moment/moment.min.js');
    	$this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js');
    	$this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
    	$this->template->add_js('js/web/ventaxruta.js');
    	$this->template->add_css('css/bootstrap-datepicker/datepicker3.css');
    	$this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker.min.css');
    	$res['lista_origen_ruta']=$this->Venta_Model->GetOrigen();
        $this->template->load(id_formulario,'web/reportes/v_ventasrutas',$res);
    }

    function ObtenerDestinoRuta()
    {
    	$ciudad_origen_codigo = $_POST['ciudad_origen'];
        $ciudad_condicion = array('ciudad_origen_codigo' => $ciudad_origen_codigo, 'ruta.estado' => 1);
        $ciudades_destino = $this->Venta_Model->GetRutas($ciudad_condicion);
        echo json_encode($ciudades_destino->result_array());
    }

    function ObtenerVentasRutaData()
    {
    	$date_inicio = date('Y-m-d',strtotime(str_replace('/', '-', $_POST['date_inicio'])));
    	$date_fin = date('Y-m-d',strtotime(str_replace('/', '-', $_POST['date_fin'])));
    	$origen= $_POST['origen'];
    	$destino= $_POST['destino'];
    	$tipo= $_POST['tipo'];
    	$ventas_rutas=$this->Venta_Model->GetSumaTotalPorRutasAgrupadas($date_inicio,$date_fin,$origen,$destino,$tipo);
    	echo json_encode($ventas_rutas->result_array());
    }


    /**
    * Description of ObtenerVentasDia
    * obtener ventas por dia
    */
    function ObtenerVentasDia()
    {
    	define("id_formulario", 137);
    	$this->template->set('titulo', 'VENTAS POR DÍA');
    	$this->template->add_js('js/web/ventaxdia.js');
    	$this->template->add_css('css/web/ventaxdia.css');
        $this->template->load(id_formulario,'web/reportes/v_ventasdia');
    }

    function ObtenerVentasDiaData()
    {
    	$dia = $_POST['dia'];
    	$mes = $_POST['mes'];
    	$anio= $_POST['anio'];
    	$canal= $_POST['canal'];
    	$ventas_diarias=$this->Venta_Model->GetSumaTotalANDcantidadVentaDiaria($dia,$mes,$anio,$canal);
    	echo json_encode($ventas_diarias->result_array());
    }

    /**
    * Description of ObtenerVentaMensual
    * obtener ventas vensuales
    */
    function ObtenerVentaMensual()
    {
        define("id_formulario", 139);
        $this->template->set('titulo', 'VENTAS MENSUAL');
        $this->template->add_js('js/web/ventaxmensual.js');
        $this->template->add_css('css/web/ventaxdia.css');
        $this->template->load(id_formulario,'web/reportes/v_ventamensual');
    }
}
