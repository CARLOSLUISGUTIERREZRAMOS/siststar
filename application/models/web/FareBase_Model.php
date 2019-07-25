<?php

class FareBase_Model extends CI_Model {

    protected $db_web_test;

    public function __construct() {
        parent::__construct();
//        $this->db_web_test = $this->load->database('db_web', TRUE);
        $this->db_web_test = $this->load->database('db_web_prod', TRUE);
    }

    function GetRutasFareBase($id_ruta) {
        $this->db_web_test->select('farebase_has_ruta.ruta_id,farebase_id,ruta.ciudad_origen_codigo,ruta.ciudad_destino_codigo,'
                . 'tarifa_adt,inicio_vuelo,final_vuelo,emision_inicio,emision_final,estadia_min_lunes,estadia_min_martes,estadia_min_miercoles,'
                . 'estadia_min_jueves,estadia_min_viernes,estadia_min_sabado,estadia_min_domingo,estado_web,estadia_maxima');
        $this->db_web_test->from('farebase_has_ruta');
        $this->db_web_test->where('farebase_has_ruta.ruta_id', $id_ruta);
//        $this->db_web_test->where('estado_registro', 1);
        $this->db_web_test->join('ruta', 'ruta.id = farebase_has_ruta.ruta_id');
        $res = $this->db_web_test->get();
//        return $this->db_web_test->last_query();
        return $res;
    }
//    
    function GetRutasFareBaseAll($id_ruta){
        
        $this->db_web_test->select('*');
        $this->db_web_test->from('farebase_has_ruta');
        $this->db_web_test->where('ruta_id', $id_ruta);
        return $this->db_web_test->get();
      //        return $this->db_web_test->last_query();
        
    }

    function ValidarExisteFareReference_Model($FareReference) {
        $query = $this->db_web_test->get_where('farebase', array('id' => $FareReference), 1);
//        return $this->db_web_test->last_query();
        return $query;
    }

    function RegistraFareBase($data) {
        $res_insert = $this->db_web_test->insert('farebase', $data);
//        return $res_insert;
//        return $this->db_web_test->last_query();
    }

    function RegistraFareBaseRuta($data) {
        $res_insert = $this->db_web_test->insert('farebase_has_ruta', $data);
        return $res_insert;
    }

    function ActualizaFareBaseRuta($ruta_id, $farebase_id, $data) {
        $this->db_web_test->set($data);
        $this->db_web_test->where('ruta_id', $ruta_id);
        $this->db_web_test->where('farebase_id', $farebase_id);
        return $this->db_web_test->update('farebase_has_ruta');
    }

    function RegistrarCombinaciones($data) {
        $res_insert = $this->db_web_test->insert('farebase_combinaciones_clase', $data);
        return $res_insert;
    }

    public function ValidarExistenciaFareBaseRuta($ruta_id, $farebase_id) {
        $this->db_web_test->where('ruta_id', $ruta_id);
        $this->db_web_test->where('farebase_id', $farebase_id);
        $cantidad = $this->db_web_test->count_all_results('farebase_has_ruta', FALSE);
//        return $this->db_web_test->last_query();
//        return ((int) $cantidad > 0) ? TRUE : FALSE;
        return $cantidad;
    }
    

    function UpdateFarebase($farebase, $ruta, $data) {
        $this->db_web_test->where('farebase_id', $farebase);
        $this->db_web_test->where('ruta_id', $ruta);
        
        return (bool)$this->db_web_test->update('farebase_has_ruta', $data);
//        return $this->db_web_test->last_query();
//        return $this->load->last_query();
    }
    
    function DeleteTblFareBaseRuta($ruta_id){
        
        return $this->db_web_test->delete('farebase_has_ruta', array('ruta_id' => $ruta_id)); 
    }
    
    function DeleteTblFareBaseCombinacionesClase($ruta_id){
        
        return $this->db_web_test->delete('farebase_combinaciones_clase', array('ruta_id' => $ruta_id)); 
    }

}
