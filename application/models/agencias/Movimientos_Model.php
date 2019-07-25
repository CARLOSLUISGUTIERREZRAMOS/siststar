<?php

class Movimientos_Model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->db_agencia = $this->load->database('db_agencia', TRUE);
    }
    
    function GetMovimientos($desde,$hasta,$apellido,$ruc,$pnr,$estado,$forma_pago,$condicion){
        $this->db_agencia->select('
        	r.Registro, rd.Flag, e.RUC,r.RUC AS RUC_PAS,r.forma_pago AS FormaPago , rd.Detalle,CodigoReserva, LEFT(CONCAT(rd.Apellidos, ", ", rd.Nombres), 35) Pasajero,  
			Origen, Destino, TipoVuelo, DATE_FORMAT(r.FechaRegistro, "%d/%m/%Y %T") Fecha, Ticket, rd.CodigoTipo, r.Vuelo_Salida,DATE_FORMAT(r.Fecha_Salida, "%d/%m/%Y") Fecha_Salida,
			r.Hora_Salida,r.Vuelo_Retorno,DATE_FORMAT(r.Fecha_Retorno, "%d/%m/%Y") Fecha_Retorno, r.Hora_Retorno, r.Pais, r.IP,rd.Tipo_Pax,
			Case rd.EstadoRegistro When 0 Then 0 When 1 Then Round(rd.EQ, 2) End as Tarifa,
			Case rd.EstadoRegistro When 0 Then 0 When 1 Then Round(rd.PE, 2) End as IGV,
			Case rd.EstadoRegistro When 0 Then 0 When 1 Then Round(rd.HW, 2) End AS TUUA, 
			Case rd.EstadoRegistro When 0 Then 0 When 1 Then Round((rd.Total), 2) End as Importe,
			Case rd.EstadoRegistro When 0 Then 0 When 1 Then Round(rd.TotalPagar, 2) End as Total,
			rd.EstadoRegistro AS Estado,
			CONCAT(r.Origen,"-",r.Destino) AS Ruta',false);
        $this->db_agencia->from('reserva r');
        $this->db_agencia->join('reserva_detalle rd', 'r.Registro = rd.Registro', 'LEFT');
        $this->db_agencia->join('personal p', 'p.CodigoPersonal = r.CodigoPersonal', 'LEFT');
        $this->db_agencia->join('entidad e', 'e.CodigoEntidad = p.CodigoEntidad', 'LEFT');
        $this->db_agencia->group_start();
        $this->db_agencia->or_where('rd.Referencia =', NULL);
        $this->db_agencia->or_where('rd.Referencia =', '');
        $this->db_agencia->group_end();
        if ($condicion==1) {
        	$this->db_agencia->where('r.FechaRegistro >=', $desde.' 00:00:00');
            $this->db_agencia->where('r.FechaRegistro <=', $hasta.' 23:59:59');
            if ($estado!='') {
            	$this->db_agencia->where('rd.EstadoRegistro =', $estado);
            }
            if ($forma_pago!='') {
            	$this->db_agencia->where('r.forma_pago =', $forma_pago);
            }
        }
        else{
        	if ($pnr) {
        		$this->db_agencia->where('r.CodigoReserva =', $pnr);
        	}
        	if ($ruc) {
        		$this->db_agencia->where('e.RUC =', $ruc);
        	}
        	if ($apellido) {
        		$this->db_agencia->like('rd.Apellidos', $apellido);
        	}
        }
        // $this->db_agencia->order_by('r.Registro', 'DESC');
        $res = $this->db_agencia->get_compiled_select();
        return $res;
    }

    function GetDataConsultaLimit($strSubQuery,$desde,$filas)
    {
    	$this->db_agencia->select('nueva_query.*', false);
        $this->db_agencia->from('('.$strSubQuery.') nueva_query', false);
        $this->db_agencia->limit($filas,$desde);
        $this->db_agencia->order_by('Registro', 'DESC');
        $res = $this->db_agencia->get()->result();
        // $res = $this->db_agencia->get_compiled_select();
        return $res;
    }

    function GetTotalesMovimiento($strSubQuery)
    {
        $this->db_agencia->select('SUM(ROUND(Tarifa,2)) Tarifa, SUM(ROUND(IGV,2)) IGV, SUM(ROUND(TUUA,2)) TUUA, SUM(ROUND(Importe,2)) Importe, SUM(ROUND(Total,2)) Total', false);
        $this->db_agencia->from('('.$strSubQuery.') nueva_query', false);
        $this->db_agencia->where('Estado =',1);
        $this->db_agencia->group_start();
        $this->db_agencia->where('Ticket <>','');
        $this->db_agencia->or_where('Ticket !=', NULL);
        $this->db_agencia->group_end();
    	$res = $this->db_agencia->get()->row();
    	return $res;
    }

    function GetCount($strSubQuery)
    {
    	$this->db_agencia->select('nueva_query.*', false);
        $this->db_agencia->from('('.$strSubQuery.') nueva_query', false);
    	$res=$this->db_agencia->count_all_results();
    	return $res;
    }

    function ObtenerReserva($reserva) {
        try{
            $this->db_agencia->select("*");
            $this->db_agencia->from("reserva");
            $this->db_agencia->where("CodigoReserva",$reserva);
            $this->db_agencia->where("EstadoRegistro",1);
            $query = $this->db_agencia->get();
            $array_reserva = $query->row();
            
            $this->db_agencia->select("*");
            $this->db_agencia->from("entidad");
            $this->db_agencia->where("CodigoEntidad",$array_reserva->CodigoEntidad);
            $this->db_agencia->where("EstadoRegistro",1);
            $query = $this->db_agencia->get();
            $array_entidad = $query->row();
            
            $array=array(
                'reserva'=>$array_reserva,
                'entidad'=>$array_entidad
            );
            
            return $array;
            
        } catch (Exception $ex) {
            throw new Exception('Error inesperado.');
        }
    }

    function ObtenerVisa($reserva_id)
    {
    	try{
            $this->db_agencia->select("*");
            $this->db_agencia->from("visa");
            $this->db_agencia->where("reserva_id",$reserva_id);
            $query = $this->db_agencia->get()->result();
            return $query;
        } catch (Exception $ex) {
            throw new Exception('Error inesperado.');
        }
    }
}