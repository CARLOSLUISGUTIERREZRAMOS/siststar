<?php

/**
 * Description of reporte_x_pais
 *
 * @author aespinoza
 */
class Reporte_x_pais extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('reportes/Reporte_pais_model');
        
    }

    function index() {
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $this->template->add_js('js/datatables/jquery.dataTables.min.js');
        $this->template->add_js('js/datatables/dataTables.bootstrap.min.js');
        $this->template->add_css('css/datatables/dataTables.bootstrap.min.css');
        $this->template->add_js('js/web/reporte_ventas.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $this->template->add_js('js/moment/moment.min.js');

        $this->template->set('titulo', 'Reporte por pais ');
        $this->template->load(135, 'reportes/v_reporte_x_pais');
    }

    function reporte_por_pais() {


        $this->template->set('titulo', 'Reporte por pais ');


        $data = array(
            'pais' => $this->Reporte_pais_model->reporte_pais()
        );




        $this->template->load(135, 'reportes/v_reporte_x_pais', $data);
    }

}
    