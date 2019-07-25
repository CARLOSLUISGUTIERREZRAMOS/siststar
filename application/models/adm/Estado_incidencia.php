<?php

class estado_incidencia extends CI_Model{
    
    
    public function __construct() {
        parent::__construct();
    }
    
    function GetAllEstados(){
        $this->db->select('id,nombre');
        $this->db->from('estado');
        $res = $this->db->get();
        return $res;
    }
    
}
