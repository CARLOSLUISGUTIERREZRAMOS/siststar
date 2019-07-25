<?php

/**
 * Description of Tarifaneta_Model
 *
 * @author aespinoza
 */
class Tarifaneta_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('db_web_prod', TRUE);
    }

    

    public function BuscarReserva($desde, $hasta, $clase, $condiciones) {
        $this->db_web->select('r.id, (r.cant_adl+r.cant_chd+r.cant_inf) AS cant_rutas,r.cc_code,p.codigo_pais,r.tipo_viaje,r.cant_adl,r.cant_chd,r.cant_inf,r.nombres,r.apellidos,r.pnr,r.geo_pais,r.origen,r.destino,r.fecha_registro,r.fechahora_salida_tramo_ida,r.num_vuelo_ida,r.num_vuelo_retorno,r.fechahora_salida_tramo_retorno,r.clase_ida,r.clase_retorno,r.nacionalidad,r.eq as total');
        $this->db_web->from('reserva r');
        $this->db_web->join('pais p', 'r.nacionalidad=p.id');
        $this->db_web->join('reserva_detalle rd', 'rd.reserva_id=r.id');
        $this->db_web->where(" (rd.num_ticket IS NOT NULL OR rd.num_ticket !='')");
        $this->db_web->where("r.fecha_registro BETWEEN '$desde' AND '$hasta'");
        if ($clase) {
            $this->db_web->where(" (r.clase_ida LIKE '%$clase%' OR r.clase_retorno LIKE '%$clase%')");
        }
        if ($condiciones) {
            $this->db_web->where($condiciones);
        }
        $this->db_web->group_by('r.id');
        $this->db_web->order_by('r.id', 'DESC');
        return $this->db_web->get()->result_array();
    }

    public function BuscarReservaVenta($desde, $hasta, $cc_code) {
        $this->db_web->select('r.id, r.geo_pais, p.codigo_pais, DATE(r.fecha_registro) AS fecha , TIME(r.fecha_registro) AS hora,DATE(r.fechahora_salida_tramo_ida) AS fecha_vuelo,
            DATEDIFF(r.fechahora_salida_tramo_ida,NOW()) AS diferencia, r.origen, r.destino, 
            (r.cant_adl + r.cant_chd + r.cant_inf) AS cant_pasajero, r.cc_code, r.total_pagar ');
        $this->db_web->from('reserva r');
        $this->db_web->join('pais p', 'r.nacionalidad=p.id');
        $this->db_web->join('reserva_detalle rd', 'rd.reserva_id=r.id');
        $this->db_web->where(" (rd.num_ticket IS NOT NULL OR rd.num_ticket !='')");
        $this->db_web->where("r.fecha_registro BETWEEN '$desde' AND '$hasta'");
        if ($cc_code) {
            $this->db_web->where("r.cc_code",$cc_code);
        }
        $this->db_web->group_by('r.id');
        $this->db_web->order_by('r.id', 'DESC');
        return $this->db_web->get()->result();
    }

    public function VentaAgrupadoMedioPago($desde, $hasta) {
        $this->db_web->select('r.id ,r.cc_code, r.total_pagar');
        $this->db_web->from('reserva r');
        $this->db_web->join('reserva_detalle rd', 'rd.reserva_id=r.id');
        $this->db_web->where(" (rd.num_ticket IS NOT NULL OR rd.num_ticket !='')");
        $this->db_web->where("r.fecha_registro BETWEEN '$desde' AND '$hasta'");
        $this->db_web->group_by('r.id');
        $query= $this->db_web->get_compiled_select();

        $this->db_web->select('new_query.cc_code, SUM(new_query.total_pagar) AS total',false);
        $this->db_web->from('('.$query.') new_query',false);
        $this->db_web->group_by('new_query.cc_code');
        $this->db_web->order_by(2, 'DESC');
        return $this->db_web->get()->result();
    }

    public function Ruta() {
        $this->db_web->select('ciudad_origen_codigo, ciudad_destino_codigo');
        $this->db_web->from('ruta');
        return $this->db_web->get()->result_array();
    }

    public function Clase() {
        $this->db_web->select('codigo');
        $this->db_web->from('clase');
        return $this->db_web->get()->result_array();
    }

    public function Paises() {
        $this->db_web->select('id, nombre_pais');
        $this->db_web->from('pais');
        return $this->db_web->get()->result_array();
    }

}
