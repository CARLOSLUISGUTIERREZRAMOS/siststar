<?php

class Compartido_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db_compartido = $this->load->database('db_compartido', TRUE);
//        $this->db_staradm = $this->load->database('db_staradm', TRUE);
    }

    public function Usuarios() {
        $this->db->select('codigo');
        $this->db->from('usuario');
        $respuesta = $this->db->get();
        return $respuesta;
    }

    public function InsertarTablaVuelo($data_vuelo) {
//return (empty($data['num_cuenta']))? "VACIO" :"NO VACIO";

        $this->db_compartido->insert('vuelo', $data_vuelo);
    }

    function ObtenerId($data_vuelo) {

        $id = $this->db_compartido->insert_id('vuelo', $data_vuelo);
        return $id;
    }

    public function InsertarTablaDetalle($data_detalle) {
        $tabla_detalle = $this->db_compartido->insert('detalle', $data_detalle);
    }

    public function ObtenerDetalleVuelo($id_vuelo) {
        $this->db_compartido->select('id,vuelo_id,nombres,apellidos,tipo');
        $this->db_compartido->from('detalle');
        $this->db_compartido->where('vuelo_id', $id_vuelo);
        $this->db_compartido->where('estado', '1');
        $respuesta = $this->db_compartido->get();
        return $respuesta;
    }

//    public function ObtenerTodosVuelos() {
////        $this->db_compartido->select('id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro');
////        $this->db_compartido->from('vuelo');
////        $this->db_compartido->order_by('fecha_registro','DESC');
////        $respuesta = $this->db_compartido->get();
////        return $respuesta;
//        $this->db_compartido->select('vuelo.id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro,count(*) as pasajeros');
//        $this->db_compartido->from('vuelo');
//        $this->db_compartido->join('detalle', 'vuelo.id=detalle.vuelo_id');
//        $this->db_compartido->where('vuelo.estado', '1');
//        $this->db_compartido->group_by('detalle.vuelo_id');
//        $this->db_compartido->order_by('fecha', 'DESC');
//        $respuesta = $this->db_compartido->get();
//        return $respuesta;
//    }

    public function ObtenerTodosVuelos($tipo) {

        $this->db_compartido->select('vuelo.id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro,vuelo.tipo,count(*) as pasajeros');
        $this->db_compartido->from('vuelo');
        $this->db_compartido->join('detalle', 'vuelo.id=detalle.vuelo_id');
        $this->db_compartido->where('vuelo.tipo', $tipo);
        $this->db_compartido->where('vuelo.estado', '1');
        $this->db_compartido->where('detalle.estado', '1');
        $this->db_compartido->group_by('detalle.vuelo_id');
        $this->db_compartido->order_by('fecha', 'DESC');
        $respuesta = $this->db_compartido->get();
//        return $this->db_compartido->last_query();
        return $respuesta;
    }

    public function ObtenerTodosVuelosPeruvian() {

        $this->db_compartido->select('vuelo.id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro,vuelo.tipo,count(*) as pasajeros');
        $this->db_compartido->from('vuelo');
        $this->db_compartido->join('detalle', 'vuelo.id=detalle.vuelo_id');
        $this->db_compartido->where('vuelo.tipo', 'cobrar');
        $this->db_compartido->where('vuelo.estado', '1');
        $this->db_compartido->group_by('detalle.vuelo_id');
        $this->db_compartido->order_by('fecha', 'DESC');
        $respuesta = $this->db_compartido->get();

        return $respuesta;
    }

    public function ObtenerVueloId($id) {
        $this->db_compartido->select('id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro');
        $this->db_compartido->from('vuelo');
        $this->db_compartido->where('id', $id);
        $respuesta = $this->db_compartido->get();
        return $respuesta;
    }

    public function EliminarPasajero($id) {
//        $this->db_compartido->delete('detalle', array('id' => $id));
        $this->db_compartido->set("estado", '0');
        $this->db_compartido->where('id', $id, FALSE);
        $this->db_compartido->update('detalle');
    }

    public function ActualizarRegistroTrafico($nombres, $apellidos, $id_pasajero, $tipo) {
        $this->db_compartido->set("nombres", $nombres);
        $this->db_compartido->set("apellidos", $apellidos);
        $this->db_compartido->set("tipo", $tipo);
        $this->db_compartido->where('id', $id_pasajero, FALSE);
        $this->db_compartido->update('detalle');
    }

    public function ActualizarVuelo($fecha, $vuelo, $origen, $destino, $id) {
        $this->db_compartido->set("fecha", $fecha);
        $this->db_compartido->set("vuelo", $vuelo);
        $this->db_compartido->set("origen", $origen);
        $this->db_compartido->set("destino", $destino);
        $this->db_compartido->where('id', $id, FALSE);
        $this->db_compartido->update('vuelo');
    }

    public function BuscaRangoFecha($desde, $hasta, $tipo) {
//        $this->db_compartido->select('id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro');
//        $this->db_compartido->from('vuelo');
//        $this->db_compartido->order_by('fecha', 'DESC');
//        $this->db_compartido->where("fecha BETWEEN '$desde' AND '$hasta'");
//        return $this->db_compartido->get();
//        $this->db_compartido->select('vuelo.id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro,count(*) as pasajeros');
//        $this->db_compartido->from('vuelo');
//        $this->db_compartido->join('detalle', 'vuelo.id=detalle.vuelo_id');
//        $this->db_compartido->where("fecha BETWEEN '$desde' AND '$hasta'");
//        $this->db_compartido->group_by('detalle.vuelo_id');
//        $this->db_compartido->order_by('fecha', 'DESC');
//        return $this->db_compartido->get();
        $this->db_compartido->select('vuelo.id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro,vuelo.tipo,count(*) as pasajeros');
        $this->db_compartido->from('vuelo');
        $this->db_compartido->join('detalle', 'vuelo.id=detalle.vuelo_id');
        $this->db_compartido->where('vuelo.tipo', $tipo);
        $this->db_compartido->where('vuelo.estado', '1');
        $this->db_compartido->where('detalle.estado', '1');
        $this->db_compartido->where("fecha BETWEEN '$desde' AND '$hasta'");
        $this->db_compartido->group_by('detalle.vuelo_id');
        $this->db_compartido->order_by('fecha', 'DESC');
        return $this->db_compartido->get();
    }

    public function BuscaRangoFechaPeruvian($desde, $hasta) {
        $this->db_compartido->select('vuelo.id,fecha,vuelo,origen,destino,fecha_registro,ip,usuario_registro,vuelo.tipo,count(*) as pasajeros');
        $this->db_compartido->from('vuelo');
        $this->db_compartido->join('detalle', 'vuelo.id=detalle.vuelo_id');
        $this->db_compartido->where('vuelo.tipo', 'cobrar');
        $this->db_compartido->where("fecha BETWEEN '$desde' AND '$hasta'");
        $this->db_compartido->group_by('detalle.vuelo_id');
        $this->db_compartido->order_by('fecha', 'DESC');
        return $this->db_compartido->get();
    }

    public function Excel($desde, $hasta, $tipo) {
        $this->db_compartido->select('V.id as id_vuelo,DATE_FORMAT(V.fecha, "%d/%m/%Y") AS fecha,V.vuelo as vuelo,V.origen as origen,V.destino as destino,DATE_FORMAT(V.fecha_registro, "%d/%m/%Y %H:%i:%s") AS fecha_registro,CAST(V.ip AS CHAR) AS ip,V.usuario_registro as usuario_registro,V.tipo as tipoCP,D.id as id_pasajero,D.vuelo_id as vuelo_id,D.nombres as nombres,D.apellidos as apellidos,D.tipo as tipo');
        $this->db_compartido->from('vuelo V');
        $this->db_compartido->join('detalle D', 'V.id = D.vuelo_id');
        $this->db_compartido->where("V.fecha BETWEEN '$desde' AND '$hasta'");
        $this->db_compartido->where("V.estado", '1');
        $this->db_compartido->where("D.estado", '1');
        $this->db_compartido->where("V.tipo", $tipo);
        return $this->db_compartido->get();
    }
//    public function TablaDetalleVuelo($desde, $hasta, $tipo) {
////        var_dump($desde,$hasta,$tipo);
//        $this->db_compartido->select('V.id as id_vuelo,DATE_FORMAT(V.fecha, "%d/%m/%Y") AS fecha,V.vuelo as vuelo,V.origen as origen,V.destino as destino,DATE_FORMAT(V.fecha_registro, "%d/%m/%Y %H:%i:%s") AS fecha_registro,CAST(V.ip AS CHAR) AS ip,V.usuario_registro as usuario_registro,V.tipo as tipoCP,D.id as id_pasajero,D.vuelo_id as vuelo_id,D.nombres as nombres,D.apellidos as apellidos,D.tipo as tipo');
//        $this->db_compartido->from('vuelo V');
//        $this->db_compartido->join('detalle D', 'V.id = D.vuelo_id');
//        $this->db_compartido->where('V.estado', '1');
//        $this->db_compartido->where('D.estado', '1');
//        $this->db_compartido->where('V.tipo', $tipo);
//        $this->db_compartido->where("V.fecha BETWEEN '$desde' AND '$hasta'");
//        return $this->db_compartido->get();
//    }
    public function TablaVuelo($desde, $hasta, $tipo) {
//        var_dump($desde,$hasta,$tipo);
        $this->db_compartido->select('V.id as id_vuelo,DATE_FORMAT(V.fecha, "%d/%m/%Y") AS fecha,V.vuelo as vuelo,V.origen as origen,V.destino as destino,DATE_FORMAT(V.fecha_registro, "%d/%m/%Y %H:%i:%s") AS fecha_registro,CAST(V.ip AS CHAR) AS ip,V.usuario_registro as usuario_registro,V.tipo as tipoCP,D.id as id_pasajero,D.vuelo_id as vuelo_id,D.nombres as nombres,D.apellidos as apellidos,D.tipo as tipo');
        $this->db_compartido->from('vuelo V');
        $this->db_compartido->join('detalle D', 'V.id = D.vuelo_id');
        $this->db_compartido->where('V.estado', '1');
        $this->db_compartido->where('D.estado', '1');
        $this->db_compartido->where('V.tipo', $tipo);
        $this->db_compartido->where("V.fecha BETWEEN '$desde' AND '$hasta'");
        $this->db_compartido->group_by('V.id');
        return $this->db_compartido->get();
    }

    public function TablaDetalle($desde, $hasta, $tipo) {
//        var_dump($desde,$hasta,$tipo);
        $this->db_compartido->select('V.id as id_vuelo,DATE_FORMAT(V.fecha, "%d/%m/%Y") AS fecha,V.vuelo as vuelo,V.origen as origen,V.destino as destino,DATE_FORMAT(V.fecha_registro, "%d/%m/%Y %H:%i:%s") AS fecha_registro,CAST(V.ip AS CHAR) AS ip,V.usuario_registro as usuario_registro,V.tipo as tipoCP,D.id as id_pasajero,D.vuelo_id as vuelo_id,D.nombres as nombres,D.apellidos as apellidos,D.tipo as tipo');
        $this->db_compartido->from('vuelo V');
        $this->db_compartido->join('detalle D', 'V.id = D.vuelo_id');
        $this->db_compartido->where('V.estado', '1');
        $this->db_compartido->where('D.estado', '1');
        $this->db_compartido->where('V.tipo', $tipo);
        $this->db_compartido->where("V.fecha BETWEEN '$desde' AND '$hasta'");
        return $this->db_compartido->get();
    }

}

?>