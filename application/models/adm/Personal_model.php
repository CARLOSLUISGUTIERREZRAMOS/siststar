<?php

class personal_model extends CI_Model {

    protected $tbl;

    public function __construct() {
        parent::__construct();
        $this->tbl = "personal";
    }

    public function getCamposPersonalCumpleaniosHoy_M($fechaEvalua) {

        $date = new DateTime("now");
        $fec_hoy = $date->format('m-d');
//        $fec_hoy = $date->format('05-09'); TEST
        $this->db->select('codigo,apellidos, nombres,correo,nombre_de_cargo');
        $this->db->from($this->tbl);
//        $this->db->join('cargo','cargo.id_cargo = personal.cargo_id_cargo');
        $condicion = "DATE_FORMAT(fec_nac,'%m-%d') = '$fec_hoy'";
        $this->db->where($condicion);
        return $this->db->get();
//        return $this->db->last_query();
    }

    public function consultaCantidadCumpleañosHoy_M($fechaEvalua) {

        $this->db->select('codigo');
        $this->db->from('personal');
        $condicion = "DATE_FORMAT(fec_nac,'%m-%d') = '$fechaEvalua'";
        $this->db->where($condicion);
        $cant_personas_cumplen_anios_hoy = $this->db->count_all_results();
        return $cant_personas_cumplen_anios_hoy;
    }

    public function updateCorreoPersonal($codigoPersonal, $data) {
        $this->db->where('codigo', $codigoPersonal);
        $this->db->where(array('correo' => NULL));
        $this->db->update($this->tbl, $data);
//        return $this->db->last_query();
    }

    public function BuscarPersonal($firstName, $lastName) {

        /*
         * RETORNA UN TIPO BOOLEANO 
         * Descr: El valor del retorno depende si existe una coincidencia
         * con el nombre y del apellido que se ingresa en el 
         * formulario de registro.
         */

        $this->db->select('codigo');
        $this->db->limit(1);
        $this->db->where('apellidos', $lastName);
        $this->db->where('nombres', $firstName);
        $data = $this->db->get('personal')->num_rows();

        return (bool) $data;
    }

    function ValidarExistenciaPersonal($CodigoPersonal) {
        $this->db->where('codigo', $CodigoPersonal);
        $this->db->from('personal');
        return (bool)$this->db->count_all_results(); 
    }
    function GetCargo($CodigoPersonal){
        $this->db->select('cargo_id_cargo');
        $this->db->from('personal');
        $this->db->where('codigo',$CodigoPersonal);
        return $this->db->get()->row()->cargo_id_cargo;
    }

}
