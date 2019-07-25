<?php

class Clase_Model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
//        $this->db_web_test = $this->load->database('db_web_test', TRUE);
        $this->db_web_test = $this->load->database('db_web_prod', TRUE);
    }
    
    function GetClase($cod_clase){
          $query = $this->db_web_test->get_where('clase', array('codigo' => $cod_clase )); 
          return (bool)$query->num_rows();
    }
}
