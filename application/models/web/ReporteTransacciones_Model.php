<?php

/**
 * Description of ReporteTransacciones_Model
 *
 * @author cgutierrez
 */
class ReporteTransacciones_Model extends CI_Model {

    protected $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('db_web_prod', TRUE);
//        $this->db_web_test = $this->load->database('db_web_test', TRUE);
    }

   public function obtener_pasajeros_reserva($id_reserva) {
        try {
            $this->db->select("*");
            $this->db->from("reserva_detalle");
            $this->db->where("reserva_id", $id_reserva);
            $query = $this->db->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }

    function GetTransacciones($criterios_busqueda, $apellidos, $fecha_ini, $fecha_fin,$id,$pnr,$criterio_estado,$email) {
        $this->db->select('R.eq,R.cc_code,R.estado,R.fecha_registro,R.num_documento,R.id,R.pnr,R.apellidos,R.nombres,'
                . 'P.nombre_pais as nacionalidad,R.geo_ciudad,R.geo_pais,R.email,D.codigo,D.monto,R.ddi_telefono,R.pre_telefono,R.num_telefono,'
                . 'R.ddi_celular,R.pre_celular,R.num_celular,R.ip,R.cant_adl,R.cant_chd,R.cant_inf,'
                . 'COUNT(DISTINCT RD.num_ticket) tik,'
                . 'R.origen, R.destino,V.card,V.action_description,R.total_pagar,R.total,R.descuento_id,R.dispositivo,R.tipo_viaje,'
                . 'R.num_vuelo_ida,R.cod_compartido_vuelo_ida,R.num_vuelo_retorno,R.cod_compartido_vuelo_retorno,'
                . 'DATEDIFF(R.fechahora_salida_tramo_ida, NOW()) AS faltante,'
//                . 'R.fechahora_salida_tramo_ida,R.fechahora_salida_tramo_retorno,R.dispositivo,COUNT(RD.num_ticket) as cant_tickets,'
                . 'R.fechahora_salida_tramo_ida,R.fechahora_salida_tramo_retorno,ruc,PE.estado_cip,S.codigo_estado,'
                . '(CASE WHEN R.cc_code="PE" AND PE.estado_cip="cip.paid" AND R.estado=1 AND COUNT(DISTINCT RD.num_ticket)=0 THEN 1 ELSE 0 END) pe_estado,'
                . '(CASE WHEN R.cc_code="SP" AND S.codigo_estado="102" AND R.estado=1 AND COUNT(DISTINCT RD.num_ticket)=0 THEN 1 ELSE 0 END) s_estado,'
                . '(CASE WHEN R.cc_code="PP" AND (PP.resultado_metodo="Success" OR PP.resultado_metodo="SuccessWithWarning") AND R.estado=1 AND COUNT(DISTINCT RD.num_ticket)=0 THEN 1 ELSE 0 END) pp_estado,'
                . '(CASE WHEN (R.cc_code="VI" OR R.cc_code="MC" OR R.cc_code="DC" OR R.cc_code="AX" ) AND V.status="Authorized" AND R.estado=1 AND COUNT(DISTINCT RD.num_ticket)=0 THEN 1 ELSE 0 END) v_estado,'
                . '(CASE WHEN (R.cc_code="VI" OR R.cc_code="MC" OR R.cc_code="DC" OR R.cc_code="AX" ) AND V.status="Authorized" AND R.estado=0 AND COUNT(DISTINCT RD.num_ticket)=0 THEN 1 ELSE 0 END) vn_estado,'
                . '(CASE WHEN R.cc_code="TC" AND V.status="Authorized" AND R.estado=0 AND COUNT(DISTINCT RD.num_ticket)=0 THEN 1 ELSE 0 END) tc_estado, '
                . '(CASE '
                    . 'WHEN cc_code = "TC" AND PE.estado_cip="cip.paid" AND COUNT(DISTINCT RD.num_ticket)>0 THEN "PE" '
                    . 'WHEN cc_code = "TC" AND S.codigo_estado="102" AND COUNT(DISTINCT RD.num_ticket)>0 THEN "SP" '
                    . 'WHEN cc_code = "TC" AND (PP.resultado_metodo="Success" OR PP.resultado_metodo="SuccessWithWarning") AND COUNT(DISTINCT RD.num_ticket)>0 THEN "PP" '
                    . 'WHEN cc_code = "TC" AND V.status="Authorized" AND COUNT(DISTINCT RD.num_ticket)>0 THEN '
                        . 'CASE '
                            . 'WHEN V.brand = "visa" THEN "VI" '
                            . 'WHEN V.brand = "amex" THEN "AX" '
                            . 'WHEN V.brand = "mastercard" THEN "MC" '
                            . 'WHEN V.brand = "dinersclub" THEN "DC" '
                        . 'END '
                . 'END) tc_card,'
                . '(CASE 
                        WHEN cc_code = "PP" THEN PP.resultado_metodo
                        WHEN cc_code = "PE" THEN PE.cip
                        WHEN cc_code = "SP" THEN S.codigo_estado
                        WHEN cc_code = "VI" OR cc_code = "MC" OR cc_code = "DC" OR cc_code = "AX" THEN V.card '
                . 'END) cardholder, '
                . '(CASE 
                        WHEN cc_code = "TC" AND PE.estado_cip<>"cip.paid" THEN "PE"
                        WHEN cc_code = "TC" AND S.codigo_estado<>"102" THEN "SP"
                        WHEN cc_code = "TC" AND (PP.resultado_metodo<>"Success" OR PP.resultado_metodo<>"SuccessWithWarning") THEN "PP"
                        WHEN cc_code = "TC" AND V.STATUS<>"Authorized" THEN 
                            CASE
                                WHEN V.brand = "visa" THEN "VI"
                                WHEN V.brand = "amex" THEN "AX"
                                WHEN V.brand = "mastercard" THEN "MC"
                                WHEN V.brand = "dinersclub" THEN "DC"
                            END 
                 END) tc_card_fallido, '
                . '(CASE 
                        WHEN cc_code = "PP" THEN PP.mensaje
                        WHEN cc_code = "PE" THEN PE.estado_cip
                        WHEN cc_code = "SP" THEN S.descripcion_estado
                        WHEN cc_code = "VI" OR cc_code = "MC" OR cc_code = "DC" OR cc_code = "AX" THEN V.action_description '
                . 'END) actionholder,',FALSE);
        $this->db->from('reserva R');
        $this->db->join('reserva_detalle RD', 'R.id = RD.reserva_id');
        $this->db->join('descuento D', 'R.descuento_id = D.id','LEFT');
        $this->db->join('pais P', 'R.nacionalidad = P.id');
        $this->db->join('(SELECT * FROM paypal ORDER BY paypal.id DESC) PP', 'R.id = PP.reserva_id', 'LEFT');
        $this->db->join('(SELECT * FROM safetypay ORDER BY safetypay.id DESC) S', 'R.id = S.reserva_id', 'LEFT');
        $this->db->join('(SELECT * FROM visa ORDER BY visa.id DESC) V', 'R.id = V.reserva_id', 'LEFT');
        $this->db->join('(SELECT * FROM pagoefectivo ORDER BY pagoefectivo.id DESC) PE', 'R.id = PE.reserva_id', 'LEFT');
        // $this->db->join('paypal PP', 'R.id = PP.reserva_id', 'LEFT');
        // $this->db->join('safetypay S', 'R.id = S.reserva_id', 'LEFT');
        // $this->db->join('visa V', 'R.id = V.reserva_id', 'LEFT');
        // $this->db->join('pagoefectivo PE', 'R.id = PE.reserva_id', 'LEFT');
        $this->db->group_by("R.pnr");
        $this->db->group_by('id');
        $this->db->order_by('id', 'DESC');
        if (!empty($id) || !empty($pnr || !empty($email))) {
            if ($id) {
                $this->db->where('R.id', $id);
            }
            else if ($email) {
                $this->db->where('R.email', $email);
            }
            else{
                $this->db->where('R.pnr', $pnr);
            }
        }
        else{
            $this->db->where('R.fecha_registro >=', $fecha_ini);
            $this->db->where('R.fecha_registro <=', $fecha_fin);
            $this->db->where($criterios_busqueda);
            if (!empty($apellidos)):
                $this->db->like('R.apellidos', $apellidos);
            endif;
            if (!empty($criterio_estado)):
                $strSubQuery = $this->db->get_compiled_select();
                $this->db->select('nueva_query.*', false);
                $this->db->from('('.$strSubQuery.') nueva_query', false);
                $this->db->where($criterio_estado);
            endif;
        }
        $res = $this->db->get();
        // $res = $this->db->get_compiled_select();
        // return $this->db->last_query();
        return $res;
    }

       function ObtenerTicketsReserva($reserva_id) {

        $this->db->select('num_ticket,nombres,apellidos');
        $this->db->from('reserva_detalle');
        $this->db->where('reserva_id', $reserva_id);
        $res = $this->db->get();

        return $res;
    }


      function CambiarEstadoReserva($estado, $reserva) {

        $this->db->set('estado', $estado);
        $this->db->where('id', $reserva);
        return $this->db->update('reserva');
    }
 function update_reserva_detalle($reserva_detalle_id, $arg) {

        $this->db->set($arg);
        $this->db->where('id', $reserva_detalle_id);
        return $this->db->update('reserva_detalle');
    }

     function update_reserva($reserva_id, $arg) {

        $this->db->set('estado', $arg);
        $this->db->where('id', $reserva_id);
        return $this->db->update('reserva');
    }
    
      public function obtener_datos_reserva($id_reserva) {
        try {
            $this->db->select("*");
            $this->db->from("reserva");
            $this->db->where("id", $id_reserva);
            $query = $this->db->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
  
     public function ObtenerDataVisa($reserva_id) {
        try {
            $this->db->select('card,authorization_code,brand,purchase_number');
            $this->db->from('visa');
            $this->db->where('id', $reserva_id);
            $this->db->limit(1);
            $res_visa = $this->db->get()->row();
            
            return $res_visa;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
     function Actualiza_cc_code_Reserva($reserva_id,$nuevo_cc_code) {
        $this->db->set('cc_code',$nuevo_cc_code);
        $this->db->where('id', $reserva_id);
        return $this->db->update('reserva');
    }
      function ObtenerEmailClienteReserva($reserva_id) {
        $this->db->select('email');
        $this->db->from('reserva');
        $this->db->where('id', $reserva_id);
        $this->db->limit(1);
        $email_pax = $this->db->get()->row()->email;
        return $email_pax;
    }
     function GetDataCardCredit($reserva_id) {
        $this->db->select('card,authorization_code');
        $this->db->from('visa');
        $this->db->where('reserva_id', $reserva_id);
//        $this->db->where('reserva_id', $reserva_id);
        $this->db->limit(1);
        $email_pax = $this->db->get()->row()->email;
        return $email_pax;
    }
      //Actualización de ticket(s) cuando kiu los encuentras como ya emitidos.
    function UpdTicketsBeforeCreate($id_reserva_detalle,$tkt) {
        $this->db->set('num_ticket', $tkt);
        $this->db->where('id', $id_reserva_detalle);
        return $this->db->update('reserva_detalle');
    }
    function GetIdReservaDetalle($id_reserva) {
        $this->db->select('id');
        $this->db->from('reserva_detalle');
        $this->db->where('reserva_id', $id_reserva);
        $this->db->limit(9);
        return $this->db->get()->result_array();
    }

    function ObtenerDetalleMetodoPago($id,$tabla){
        $this->db->select($tabla.'.*, reserva.pnr,reserva.ruc,reserva.cc_code');
        $this->db->from($tabla);
        $this->db->join('reserva','reserva.id = '.$tabla.'.reserva_id');
        $this->db->where('reserva_id', $id);
        return $this->db->get();
    }

}
