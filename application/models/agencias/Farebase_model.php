<?php

if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class Farebase_Model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->db_agencia = $this->load->database('db_agencia', true);
    }
    
    function obtener_farebase(){
        try {
            $this->db_agencia->select("*");
            $this->db_agencia->from("farebase");
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function obtener_farebases($codigo_farebase){
        $a_data=array();
        try {
            $this->db_agencia->select("*");
            $this->db_agencia->from("farebase");
            $this->db_agencia->where("CodigoFareBase",$codigo_farebase);
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
       
    function guardar_farebase($a_data){   
        try {
            $this->db_agencia->insert('farebase', $a_data);
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function editar_farebase($a_data,$codigo_farebase){   
        try {
            $this->db_agencia->where("CodigoFarebase", $codigo_farebase);
            $this->db_agencia->update("farebase", $a_data);
        }catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function contar_farebases($fare) {
        try {
            $this->db_agencia->where("CodigoFareBase",$fare);
            $this->db_agencia->from("farebase");
            return $this->db_agencia->count_all_results();
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
}
?>