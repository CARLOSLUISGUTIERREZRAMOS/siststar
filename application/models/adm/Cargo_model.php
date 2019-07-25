<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Cargo_Model extends CI_Model {

    private $id_cargo;
    private $nombre_cargo;
    private $estado;

    public function __construct() {
        parent::__construct();
    }

    function retornaDataAll($estado) {

        $query = $this->db->get_where('cargo', array('estado' => "$estado"));
        return $query;
    }

    function RetornaId($NombreCargo) {
        $this->db->where('nombre_cargo', $NombreCargo);
        $query = $this->db->from('cargo');
        $res = (bool) $this->db->count_all_results();
        if ($res) {
            $this->db->where('nombre_cargo', $NombreCargo);
             $this->db->from('cargo');
            $query= $this->db->get();
            return $query->row()->id_cargo;
        }
    }
    
    
    
    
    
    

}
