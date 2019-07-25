<?php

/**
 * Description of ReporteVentas
 *
 * @author aespinoza
 */
class ReporteVentasNetas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($this->session->username)):
            header('Location: '.base_url());
        endif;
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker3.css');
        $this->template->add_css('css/datatables/dataTables.bootstrap.min.css');
        $this->template->add_css('css/web/venta_neta.css',1);
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
        $this->template->add_js('js/datatables/jquery.dataTables.min.js');
        $this->template->add_js('js/datatables/dataTables.bootstrap.min.js');
        $this->template->add_js('js/web/reporte_ventas.js',1);
        $this->template->add_js('js/moment/moment.min.js');


        $this->load->model('web/Tarifaneta_Model');
    }

    function Index() {
        $this->template->set('titulo', 'Reporte ');

        $llenar_select = array(
            'ruta' => $this->Tarifaneta_Model->Ruta(),
            'clase' => $this->Tarifaneta_Model->Clase(),
            'paises' => $this->Tarifaneta_Model->Paises()
        );
        $this->template->load(133, "web/v_reporte_neto", $llenar_select);
    }

    public function recibiendopost() {
        $this->template->set('titulo', 'Reporte ');

        /* RECIBIENDO POST */

        $desde_1 = $this->input->post('desde');
        $desde = date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', $desde_1)));

        $hasta_1 = $this->input->post('hasta');
        $hasta = date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', $hasta_1)));

        $ruta = $this->input->post('ruta');
        $tipo = $this->input->post('tipo_viaje');
        $clase = $this->input->post('clase');
        $ubicacion = $this->input->post('nacionalidad');
        $tipo_pago = $this->input->post('tipo_pago');

        $condiciones='';
        if (!empty($ruta)) {
            list($ruta_ida, $ruta_vuelta) = explode("-", $ruta);
            $condiciones['r.origen']=$ruta_ida;
            $condiciones['r.destino']=$ruta_vuelta;
        }

        if (!empty($tipo)) {
            $condiciones['r.tipo_viaje']=$tipo;
        }

        if (!empty($tipo_pago)) {
            $condiciones['r.cc_code']=$tipo_pago;
        }

        if (!empty($ubicacion)) {
            $condiciones['r.nacionalidad']=$ubicacion;
        }
        $data = array(
            'reserva' => $this->Tarifaneta_Model->BuscarReserva($desde, $hasta,$clase,$condiciones),
            'ruta' => $this->Tarifaneta_Model->Ruta(),
            'clase' => $this->Tarifaneta_Model->Clase(),
            'paises' => $this->Tarifaneta_Model->Paises());
        $this->template->load(133, "web/v_reporte_neto", $data);
    }

    public function ReporteVenta()
    {
        $this->template->set('titulo', 'Reporte de Ventas');
        $desde = date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', $this->input->post('desde'))));
        $hasta = date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', $this->input->post('hasta'))));
        $cc_code = $this->input->post('tipo_pago');
        $data['reservas']=$this->Tarifaneta_Model->BuscarReservaVenta($desde, $hasta, $cc_code);
        $data['resumen']=$this->Tarifaneta_Model->VentaAgrupadoMedioPago($desde, $hasta);
        $this->template->load(138, "web/ecommerce/v_reporte_ventas", $data);
    }

}
