<?php

if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class Clase_Model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->db_agencia = $this->load->database('db_agencia', true);
    }

    
    function obtener_clases(){
        try {
            $this->db_agencia->select("cla.CodigoClase,cla.NombreClase,fam.NombreFamilia,cla.TipoClase");
            $this->db_agencia->from("clase As cla");
            $this->db_agencia->join("familia AS fam","cla.CodigoFamilia = fam.CodigoFamilia","left");
            $this->db_agencia->where("cla.TipoClase",1);
            $this->db_agencia->order_by("fam.CodigoFamilia",'asc');
            $this->db_agencia->order_by("cla.CodigoClase",'asc');
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function obtener_clases_extranjero(){
        try {
            $this->db_agencia->select("cla.CodigoClase,cla.NombreClase,fam.NombreFamilia,cla.Extranjero");
            $this->db_agencia->from("clase As cla");
            $this->db_agencia->join("familia AS fam","cla.CodigoFamilia = fam.CodigoFamilia","left");
            $this->db_agencia->where("cla.TipoClase",1);
            $this->db_agencia->order_by("fam.CodigoFamilia,cla.CodigoClase");
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function obtener_clases_select(){
        try {
            $this->db_agencia->select("CodigoClase,NombreClase");
            $this->db_agencia->from("clase");
            $this->db_agencia->where("TipoClase",1);
            $query = $this->db_agencia->get();
            $array = $query->result_array();
            $a_data = assoc_to_numeric($array, "CodigoClase", "NombreClase");
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function obtener_codigos_clases(){
        try{
            $this->db_agencia->select("CodigoClase");
            $this->db_agencia->from("clase");
            $this->db_agencia->where("TipoClase",1);
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
            
        } catch (Exception $ex) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function obtener_clase($id_clase){
        try {
            $this->db_agencia->select("*");
            $this->db_agencia->from("clase");
            $this->db_agencia->where("CodigoClase",$id_clase);
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function guardar_clase($a_data){   
        try {
            $this->db_agencia->insert('clase', $a_data);
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function cantidad_clase($clase) {
        try {
            $this->db_agencia->where("CodigoClase",$clase);
            $this->db_agencia->where("TipoClase",'1');
            $this->db_agencia->from("clase");
            return $this->db_agencia->count_all_results();
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function actualizar_clase($clase,$a_data) {
        try {
            $this->db_agencia->where('CodigoClase',$clase);
            $this->db_agencia->update('clase', $a_data);
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function validar_clase_pais($clase,$pais){
        try {
            $this->db_agencia->select("*");
            $this->db_agencia->from("pais_clase");
            $this->db_agencia->where("Clase",$clase);
            $this->db_agencia->where("CodigoPais",$pais);
            $query = $this->db_agencia->get();
            $row = $query->result_array();
            return $row[0]['EstadoRegistro'];
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
}
?>