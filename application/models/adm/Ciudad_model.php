<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Ciudad_Model extends CI_Model {

    private $cod_ciudad;
    private $nombre_ciudad;
    private $estado;
    
    public function __construct() {
        parent::__construct();
    }
    
    function retornaDataAll($estado){
        
        $query = $this->db->get_where('ciudad', array('estado' => "$estado") );
        return $query;
    }
    
    
}