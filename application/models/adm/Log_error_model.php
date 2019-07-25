<?php

class Log_Error_Model extends CI_Model{
    
    private $tbl;
    
    public function __construct() {
        parent::__construct();
        $this->tbl = 'log_error';
    }
    
    public function registrar($data){
         $this->db->insert($this->tbl, $data);
    }
    
    
}