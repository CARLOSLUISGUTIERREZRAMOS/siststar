<?php
use Models\web\excel\Excel_Model;
class Ventas extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!isset($this->session->username)):
            header('Location: '.base_url());
        endif;

        isset($this->session->username) ? TRUE : header('Location: '.base_url());
        $this->load->helper('fechasHoras_helper');
        $this->load->model('web/Venta_Model');
        // $this->load->model('Excel_Model');
        // $this->load->model('Detalle_Model');
        // $this->load->model('web/Excel');

    }

    /**
    * Description of ObtenerPais
    * obtener ventas por pais
    */
    function ObtenerPais()
    {
        define("id_formulario", 136);
        $this->template->set('titulo', 'VENTAS POR RUTAS');
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
        $this->template->add_js('js/web/ventaxpais.js');
        $this->template->add_css('css/bootstrap-datepicker/datepicker3.css');
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $res['lista_origen_ruta']=$this->Venta_Model->GetOrigen();
        $this->template->load(id_formulario,'web/reportes/v_ventaspais',$res);
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
    	$this->template->add_js('js/web/ventaxruta.js',1);
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
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('js/web/ventaxmensual.js');
        $this->template->add_css('css/web/ventaxmes.css');
        $this->template->load(id_formulario,'web/reportes/v_ventamensual');
    }

    function ObtenerVentaMensualData()
    {
        if ($this->input->is_ajax_request()) {
            $mes = $_POST['mes'];
            $anio= $_POST['anio'];
            $medio= $_POST['medio'];
            if ($medio=='PC') {
                $ventas_mensual=$this->Venta_Model->GetSumaTotalANDcantidadVentaMensualPeruCompras($mes,$anio);
            }
            else{
                $ventas_mensual=$this->Venta_Model->GetSumaTotalANDcantidadVentaMensual($mes,$anio,$medio);
            }
            echo json_encode($ventas_mensual->result_array());
        }
        else{
            echo "error";
        }
    }


    /**
    * Description of ObtenerVentaMensualNeta
    * obtener ventas vensuales netas
    */
    function ObtenerVentaMensualNeta()
    {
        define("id_formulario", 140);
        $this->template->set('titulo', 'VENTAS MENSUAL NETA');
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('js/web/venta_mensual_neta.js');
        $this->template->add_css('css/web/ventaxmes.css');
        $this->template->load(id_formulario,'web/reportes/v_ventamensual_neta');
    }

    function ObtenerVentaMensualNetaData()
    {
        if ($this->input->is_ajax_request()) {
            $mes = $_POST['mes'];
            $anio= $_POST['anio'];
            $medio= $_POST['medio'];
            $ventas_mensual_neta=$this->Venta_Model->GetSumaTotalANDcantidadVentaMensualNeta($mes,$anio,$medio);
            echo json_encode($ventas_mensual_neta->result_array());
        }
        else{
            echo "error";
        }
    }

    public function ObtenerVentaVensualExcel()
    {
        define("id_formulario", 144);
        $this->template->set('titulo', 'REPORTE DE VENTAS MENSUALES ECOMERCE');
        $this->template->add_js('js/web/ventaxmensualexcel.js');
        $this->template->add_css('css/web/ventaxmes.css');
        $this->template->load(id_formulario,'web/reportes/v_ventamensualexcel');
    }

    public function ReporteMensual($mes,$anio)
    {
        // $this->load->model('web/excel/Excel_Model');
        $reservas = Excel_Model::whereMonth('fecha_registro',$mes)->whereYear('fecha_registro',$anio)->with('detalles');
        // $reservas = Excel_Model::where('fecha_registro','>=',$anio.'-'.$mes.'-01 00:00:00')->where('fecha_registro','<=',$anio.'-'.$mes.'-23 23:59:59')->with('detalles');
        // dd($reservas->count());
        $data["reservas"]=$reservas;
        $data["mes"]=$mes;
        $this->load->view('web/reportes/v_ventamensualexceldata',$data);
    }

    function MailPueba()
    {
        $this->load->view('mail_prueba');
    }
}
