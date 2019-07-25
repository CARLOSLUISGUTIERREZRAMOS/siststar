<?php

if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class FarebaseRuta_Model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->db_agencia = $this->load->database('db_agencia', true);
    }
    
    function obtener_detalle_tarifas($id) {
        try {
            $this->db_agencia->select('CodigoFareBase,Tarifa,DATE_FORMAT(EmisionInicio, "%d/%m/%Y") EmisionInicio,DATE_FORMAT(EmisionFinal, "%d/%m/%Y") EmisionFinal,DATE_FORMAT(Inicio, "%d/%m/%Y") Inicio,DATE_FORMAT(Final, "%d/%m/%Y") Final,EstadiaMin,EstadiaMax,estado_web');
            $this->db_agencia->from("farebase_ruta");
            $this->db_agencia->where("CodigoRuta",$id);
            $query = $this->db_agencia->get()->result();
            return $query;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function obtener_detalle_temporadas($id) {
        try {
            $this->db_agencia->select("CodigoFareBase,Tarifa,Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Setiembre,Octubre,Noviembre,Diciembre");
            $this->db_agencia->from("farebase_ruta");
            $this->db_agencia->where("CodigoRuta",$id);
            $query = $this->db_agencia->get()->result();
            return $query;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function obtener_temporal_farebases($id) {
        try {
            $this->db_agencia->select("CodigoFareBase,Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Setiembre,Octubre,Noviembre,Diciembre,EstadiaMin,EstadiaMax");
            $this->db_agencia->from("farebase_ruta");
            $this->db_agencia->where("CodigoRuta",$id);
            $query = $this->db_agencia->get()->result();
            // $a_data = $query->result_array();
            return $query;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function update_farebase_ruta($a_data,$idruta,$farebase) {
        try {
            $this->db_agencia->where("CodigoRuta",$idruta);
            $this->db_agencia->where("CodigoFarebase",$farebase);
            $this->db_agencia->update("farebase_ruta",$a_data);
            return true;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function delete_farebase_ruta($idruta){
        try {
            $this->db_agencia->where("CodigoRuta",$idruta);
            $this->db_agencia->delete("farebase_ruta");
            return true;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function contar_farebases_ruta($fare,$idruta) {
        try {
            $this->db_agencia->where("CodigoFareBase",$fare);
            $this->db_agencia->where("CodigoRuta",$idruta);
            $this->db_agencia->from("farebase_ruta");
            return $this->db_agencia->count_all_results();
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function guardar_farebase_ruta($a_data){   
        try {
            $this->db_agencia->insert('farebase_ruta', $a_data);
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }

}