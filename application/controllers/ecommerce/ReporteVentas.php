<?php

/**
 * Description of ReporteVentas
 *
 * @author aespinoza
 */
class ReporteVentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker3.css');
        $this->template->add_css('css/datatables/dataTables.bootstrap.min.css');
        $this->template->add_css('css/web/venta_neta.css',1);
        $this->template->add_css('css/web/venta.css');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
        $this->template->add_js('js/datatables/jquery.dataTables.min.js');
        $this->template->add_js('js/datatables/dataTables.bootstrap.min.js');

        $this->load->model('web/Tarifaneta_Model');
    }

    function Index() {
        $this->template->add_js('js/web/reporte_ventas.js',1);
        $this->template->set('titulo', 'Reporte de Ventas');
        $this->template->load(138, "web/ecommerce/v_reporte_ventas");
    }
}