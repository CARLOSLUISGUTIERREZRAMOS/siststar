<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Area_Trabajo_Model extends CI_Model {

    private $codigo_area;
    private $nombre_area;
    private $estado;
    
    public function __construct() {
        parent::__construct();
    }
    
    function retornaDataAll($estado){
        
        $query = $this->db->get_where('area_trabajo', array('estado' => "$estado") );
        return $query;
    }
    
    
}