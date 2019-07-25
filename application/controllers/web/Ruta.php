<?php

class Ruta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!isset($this->session->username)):
            header('Location: '.base_url());
        endif;
        define("id_formulario", 121);
        isset($this->session->username) ? TRUE : header('Location: '.base_url());
        $this->load->model('web/Ruta_Model');
    }
    
    function index() {
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker3.css');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js',1);
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
        $this->template->add_js('js/web/ruta.js',1);
        $this->template->set('titulo', 'Rutas');
        $res['lista_rutas'] = $this->Ruta_Model->ListarRutas();
        $this->template->load(id_formulario, 'web/v_ruta', $res);
    }
}
