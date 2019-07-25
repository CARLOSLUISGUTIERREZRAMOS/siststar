<?php

class Ruta_Model extends CI_Model{
    
    protected $db_web_test;
    
    public function __construct() {
        parent::__construct();
        $this->db_web_test = $this->load->database('db_web_prod', TRUE);
        // $this->db_web_test = $this->load->database('db_web',TRUE);
    }

    function ListarRutas(){
        $this->db_web_test->select('id, ciudad_origen_codigo, ciudad_destino_codigo, tiempo');
        $this->db_web_test->from('ruta');
        $res = $this->db_web_test->get();
        return $res;
    }
    
}
