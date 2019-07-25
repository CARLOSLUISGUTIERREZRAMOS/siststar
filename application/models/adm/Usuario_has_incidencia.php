<?php

class usuario_has_incidencia extends CI_Model {

    protected $tbl;

    function __construct() {
        parent::__construct();
        $this->tbl = 'usuario_has_incidencia';
    }

    public function InsertaInvolucrados($data) {
        $res = $this->db->insert($this->tbl, $data);
        return $res;
    }

    public function RegistraFeedback($id_usuario_responsable, $ticket, $data) {

        $feedbackNull = $this->ValidaCampoVacioFeedback($id_usuario_responsable, $ticket);
//        return $feedbackIsset;
        if ($feedbackNull) {
//            return 1;
            return $this->ActualizaRegistro($data, $id_usuario_responsable, $ticket);
        } else{
//            return 2;
            return $this->InsertaRegistro($data);
        }
    }
    
   

    private function ValidaCampoVacioFeedback($id_usuario_responsable, $ticket) {

        $this->db->select('incidencia_ticket');
        $this->db->from($this->tbl);
//        $this->db->where('id_usuario_feedback', NULL);
        $this->db->where('feedback', NULL);
//        $this->db->where('fecha_feedback', NULL);
//        $this->db->where('id_usuario_feedback is NOT NULL',NULL, FALSE);
        $this->db->where('incidencia_ticket', $ticket, FALSE);
        $this->db->limit(1);
        $num_results = $this->db->count_all_results();
        return (bool)$num_results;
//        $this->db->get();
//        return $this->db->last_query();
        
    }

    

    /*
     * __Retorna un entero
     * Metodo que retorna el id del 
     * ultimo usuario que genero un 
     * feedback a una incidencia
     */

    function UltimoUsuarioFeedback($ticket) {

        $where = "feedback is  NOT NULL";
        $this->db->where($where);
        $this->db->where('incidencia_ticket', $ticket);
        $this->db->select('id_usuario_feedback');
        $this->db->order_by('id', 'DESC');
        $res = $this->db->get_where($this->tbl, $where, 1)->row();
        if (!is_null($res)) {
            return (int) $res->id_usuario_feedback;
//            return $this->db->last_query();
        }
    }

    private function ActualizaRegistro($data, $id_usuario_responsable, $ticket) {
        $id = $this->GetIDLastReg($ticket);
//        return $id;
        $this->db->where('id', $id);
//        $this->db->where('fecha_revisa', 'NOW()', FALSE);
        return $this->db->update($this->tbl, $data);
//        $this->db->update($this->tbl, $data);
//        return $this->db->last_query();
    }

//    private function GetIDLastReg($id_usuario_responsable, $ticket) {
    private function GetIDLastReg($ticket) {

        $this->db->select('id');
        $this->db->from('usuario_has_incidencia URI');
        $this->db->join('incidencia I','URI.incidencia_ticket = I.ticket');
        $this->db->where('feedback', NULL);
//        $this->db->where('id_usuario_responsable', $id_usuario_responsable, FALSE);
        $this->db->where('incidencia_ticket', $ticket, FALSE);
//        $this->db->get();
//        return $this->db->last_query();
        return (int) $this->db->get()->row()->id;
    }

    public function InsertaRegistro($data) {
        $res = $this->db->insert($this->tbl, $data);
        return $res;
    }

    public function GetCantMensajesNuevos($id_usuario) {
        $array_where = array('I.estado_id' => 0, 'I.id_usuario_responsable' => $id_usuario);
        $this->db->join('incidencia I', 'UI.incidencia_ticket = I.ticket');
        $query = $this->db->get_where('usuario_has_incidencia UI', $array_where);
        $count = $query->num_rows();
        return $count;
    }

    public function GetFeedback($condicion) {

        $this->db->where($condicion);
        $this->db->from('usuario_has_incidencia AS URI');
        $this->db->join('usuario U', 'URI.id_usuario_responsable = U.id_usuario');
        $this->db->select('feedback AS detalle,incidencia_ticket AS ticket,U.nombre,U.apellido,U.email,URI.fecha_feedback AS fecha');
//        $this->db->get();
        return $this->db->get()->row();
//        return $this->db->last_query();
    }

    public function GetAllFeedback($condicion) {

        $this->db->where($condicion);
        $this->db->from('usuario_has_incidencia AS URI');
        $this->db->join('incidencia I', 'URI.incidencia_ticket = I.ticket');
        $this->db->join('usuario U', 'I.id_usuario_responsable = U.id_usuario');
        $this->db->select('feedback,id_usuario_feedback,fecha_feedback,id_usuario_solicitante,U.nombre');
        return $this->db->get();
//        return $this->db->last_query();
    }

    public function GetBandeja($id_usuario) {
//        $where = "estado = 0 OR estado = 1";
        $estados = array(0, 1, 2, 3, 4);
        $this->db->select('u.nombre,u.apellido,I.detalle,I.fecha_genera,URI.incidencia_ticket,I.estado_id,URI.id_usuario_feedback,I.fecha_finaliza,I.fecha_estimada_fin');
        $this->db->from('usuario_has_incidencia URI');
        $this->db->group_by("URI.incidencia_ticket");
        $this->db->join('incidencia I', 'URI.incidencia_ticket = I.ticket');
        $this->db->join('usuario u', 'I.id_usuario_solicitante = u.id_usuario');
        $this->db->where('id_usuario_responsable', $id_usuario);
        $this->db->where_in('I.estado_id', $estados);
        return $this->db->get();
////        $estados = array(0,1);
////        $this->db->where_in('estado_id',$estados);
//        return $this->db->last_query();
    }

    public function GetDestinatarios($id_usuario_remite) {

        $this->db->select('id_usuario,nombre,apellido');
        $this->db->from('usuario');
        $this->db->where('estado', 'Y');
        $this->db->where('id_usuario !=', $id_usuario_remite);
        $query = $this->db->get();
//        return $this->db->last_query();
        return $query;
    }
    
     function SetFechaRevisa($ticket) {
        
        $this->db->set('fecha_revisa', 'NOW()', FALSE);
//        $this->db->where('id_usuario_feedback', $usuarioLee, FALSE);
        $this->db->where('incidencia_ticket', $ticket, FALSE);
        $this->db->update($this->tbl);
        
    }

    /*
     * MEJORAR LOGICA
     * Metodo utilizado para validar la lectura de una incidencia.
     * Retorna un booleano.
     */

    public function CambiarEstadoFeedback($condicion, $set) {
        /*
         * @Param $set
         * array de elemeento a setiar en query
         */
        $this->db->set($set);
        $this->db->where($condicion);
        return $this->db->update($this->tbl);
    }

    function ListaIncidenciasGeneradas($id_usuario, $estados, $condicion = NULL) {

        /*
         * LISTA DE ACUERDO A SECCION
         * Logica implementada para listar de acuerdo 
         * a la sección en donde nos encontremos
         */
        if (!is_null($condicion)) {
            $this->db->where($condicion);
        }
        /*
         * .LISTA DE ACUERDO A SECCION
         */

        $this->db->where('I.id_usuario_solicitante', $id_usuario);
//        $this->db->where('URI.id_usuario_feedback !=', $id_usuario);
        $this->db->where_in('I.estado_id', $estados, FALSE);
        $this->db->select('URI.id,ticket,detalle,I.fecha_genera AS FechaCreacion,URI.fecha_revisa,I.fecha_finaliza,I.estado_id,E.nombre AS nom_estado,U.nombre AS nom_usuario,URI.feedback,URI.fecha_feedback,I.importancia');
        $this->db->from('usuario_has_incidencia URI');
        $this->db->group_by("URI.incidencia_ticket");
        $this->db->join('incidencia I', 'I.ticket = URI.incidencia_ticket');
        $this->db->join('estado E', 'I.estado_id = E.id ');
        $this->db->join('usuario U', 'I.id_usuario_responsable = U.id_usuario');
        return $this->db->get();
//        $this->db->get();
//       return $this->db->get('usuario_has_incidencia URI');
//        return $this->db->last_query();
    }

    /*
     * Esta función permitirá vrificar si existe el numero de ticket en esta tabla,
     * de no encontrarse se generará un item.
     * @Parametro = ticket
     * El parametro recibido en esta función vendrá inmediatamente despúes de la generación
     * del ticket.
     */

    function BuscarTicket($ticket) {

        $this->db->select('incidencia_ticket');
        $this->db->from($this->tbl);
        $this->db->where('incidencia_ticket', $ticket);
        $this->db->limit(1);
        $num_results = $this->db->count_all_results();
//        return $this->db->last_query();
        return $num_results;
    }

}
