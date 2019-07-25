<?php

class incidencia extends CI_Model {

    protected $tbl;

    function __construct() {
        parent::__construct();
        $this->load->helper('fechasHoras_helper');
        $this->tbl = 'incidencia';
    }

    function RegistraIncidencia($data) {
        /*
         * AQUI RETORNAMOS UN ARRAY CON DOS INDICES
         * INDICE 1:
         * ---> RETORNA UN BOOLEANO DE ACUERDO AL PROCESO DE REGISTRO
         * INDICE 2:
         * ---> RETORNA EL NUMERO DE TICKET QUE SE GENERO
         */
        $res_val = $this->db->insert($this->tbl, $data);
        $res['val_insert'] = (bool) $res_val;
        $res['ticket_int'] = $this->db->insert_id();
        return $res;
//        return $this->db->last_query();
    }

    function getIncidencia($ticket) {

        $where = array('ticket' => $ticket);
        $this->db->select('id_usuario_solicitante,detalle,fecha_genera,u.nombre,u.apellido,u.email');
        $this->db->join('usuario u', 'u.id_usuario =  I.id_usuario_solicitante');
        return $this->db->get_where('incidencia I', $where, 1)->row();
//        $this->db->get_where('incidencia I', $where, 1);
//        return $this->db->last_query();
    }

    function SetNotificar($ticket,$accion) {

        $this->db->set('notificacion', $accion);
        $this->db->where('ticket', $ticket, FALSE);
        $res_set_notificar = $this->db->update($this->tbl);
        return (bool)$res_set_notificar;
        
    }

    function GetIncidenciaPorFecha($fecha) {

        $this->db->select('I.ticket, I.fecha_genera, U.nombre nom_solicita,U.apellido ape_solicita, U2.nombre nom_resp,U2.apellido ape_resp,E.nombre nom_estado, I.estado_id, I.fecha_estimada_fin,I.importancia');
        $this->db->from('incidencia I');
        $this->db->join('usuario U', 'U.id_usuario = ' . 'I.id_usuario_solicitante');
        $this->db->join('usuario U2', 'U2.id_usuario = ' . 'I.id_usuario_responsable');
        $this->db->join('estado E', 'E.id = ' . 'I.estado_id');
        $condicion = "DATE_FORMAT(fecha_genera,'%Y-%m-%d') = '$fecha'";
        $this->db->where($condicion);
        return $this->db->get();
//        $this->db->get();
//        return $this->db->last_query();
    }

    function setEstado($ticket, $estado) {
        $this->db->set('estado_id', $estado);
        $this->db->where('ticket', $ticket, FALSE);
        $this->db->update($this->tbl);
    }

    function GetBandeja($id_usuario) {
//        $where = "estado = 0 OR estado = 1";
        $estados = array(0, 1, 2, 3, 4);
        $this->db->select('ticket,u.nombre,u.apellido,I.detalle,I.fecha_genera,I.estado_id,I.fecha_finaliza,I.fecha_estimada_fin,I.importancia,I.notificacion');
//        $this->db->select('u.nombre,u.apellido,I.detalle,I.fecha_genera,I.estado_id,I.fecha_finaliza,I.fecha_estimada_fin,');
        $this->db->from('incidencia I');
        
        $this->db->join('usuario u', 'I.id_usuario_solicitante = u.id_usuario');
//        $this->db->join('usuario_has_incidencia URI', 'I.ticket = URI.incidencia_ticket');
        $this->db->where('id_usuario_responsable', $id_usuario);
//        $this->db->where('id_usuario_responsable', $id_usuario);
        $this->db->where_in('I.estado_id', $estados);
        $this->db->order_by("ticket", "desc");
//        $this->db->get();
//        $this->db->distinct();
        return $this->db->get();
//        $this->db->get();
////        $estados = array(0,1);
////        $this->db->where_in('estado_id',$estados);
//        return $this->db->last_query();
    }

    public function InsertaResponsable($data) {
//        $res = $this->db->update($this->tbl, $data);
        return $res;
    }

    function SetLeido($ticket, $usuarioLee) {

        $estado_no_leido = $this->getEstadoTicket($ticket, $usuarioLee);
        if ($estado_no_leido === 0) {
//            $this->SetFechaRevisa($ticket);
            $this->db->set('estado_id', 1);
            $this->db->where('ticket', $ticket, FALSE);
            $this->db->update($this->tbl);
//            return $query;
        }
    }
    
    function BuscarIndicencia(){
        
    }

    function getEstadoTicket($ticket, $usuarioLee = NULL) {
        $this->db->select('I.estado_id');
        $this->db->from('usuario_has_incidencia UI');
        $this->db->where('UI.incidencia_ticket', $ticket, FALSE);
        $this->db->join('incidencia I', 'UI.incidencia_ticket = I.ticket');
        if (!is_null($usuarioLee)) {
            $this->db->where('id_usuario_responsable', $usuarioLee, FALSE);
        }
//        $this->db->get();
//          return $this->db->last_query();
        return (int) $this->db->get()->row()->estado_id;
    }

    function GetIDResponsable($ticket) {
        $where = array('ticket' => $ticket);
        $this->db->select('id_usuario_responsable');
        return (int) $this->db->get_where($this->tbl, $where, 1)->row()->id_usuario_responsable;
    }
    function GetDataResponsable($ticket) {
        $where = array('ticket' => $ticket);
        $this->db->select('U.nombre nombre_responsable, U.apellido apellido_responsable');
        $this->db->join('usuario U','U.id_usuario = I.id_usuario_responsable');
        return $this->db->get_where('incidencia I', $where, 1)->row();
    }

    function GetIDSolicitante($ticket) {

        $where = array('ticket' => $ticket);
        $this->db->select('id_usuario_solicitante');
        return (int) $this->db->get_where($this->tbl, $where, 1)->row()->id_usuario_solicitante;
    }

    function FinalizarIncidencia($ticket) {

        $this->db->set('fecha_finaliza', date("Y-m-d H:i:s"));
        $this->db->where('ticket', $ticket);
        $this->db->update($this->tbl);
    }

    function setTiempoEstimado($fecha_elegida, $ticket) {
        $this->db->set('fecha_estimada_fin', $fecha_elegida);
        $this->db->where('ticket', $ticket);
        return $this->db->update($this->tbl);
    }

    function GetFechaGeneracion($ticket) {

        $this->db->select('fecha_genera');
        $this->db->where('ticket', $ticket);
        $this->db->limit(1);
        $this->db->from($this->tbl);
        $res_fechaGeneracion = $this->db->get()->row()->fecha_genera;
        return $res_fechaGeneracion;
    }

    function GetFechaEstimadaFin($ticket) {

        $this->db->select('fecha_estimada_fin');
        $this->db->where('ticket', $ticket);
        $this->db->limit(1);
        $this->db->from($this->tbl);
        $res_fechaEstimadaFin = $this->db->get()->row()->fecha_estimada_fin;
        return $res_fechaEstimadaFin;
    }

    public function ComprobarLecturaUsuario($ticket, $id_usuario) {
        $this->db->where('ticket', $ticket, FALSE);
        $this->db->group_start();
        $this->db->where('id_usuario_responsable', $id_usuario, FALSE);
        $this->db->or_where('id_usuario_solicitante', $id_usuario, FALSE);
        $this->db->group_end();
        $this->db->from($this->tbl);
        $this->db->limit(1);
        return (bool) $this->db->get()->num_rows();
//        $this->db->get();
//        return $this->db->last_query();
//        return (bool)$this->db->get()->num_rows();
    }
    
    public function ModificarNivelImportanciaIncidencia($ticket,$nivel){
        $this->db->set('importancia', $nivel);
        $this->db->where('ticket', $ticket);
        return (bool)$this->db->update($this->tbl);
    }
    
     function Eliminar($tickets) {
        $this->db->set('estado_id',5);
        $this->db->where_in('ticket', $tickets,FALSE);
        return $this->db->update($this->tbl);
    }
    

}
