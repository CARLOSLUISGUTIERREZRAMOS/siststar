<?php

class Venta_Model extends CI_Model{
    
	protected $db_web;
    protected $db_pasarela_prod;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('db_web_prod', TRUE);
        // $this->db_pasarela_prod = $this->load->database('db_pasarela_prod', TRUE);
    }
    
    public function GetRutas($condicion) {

        $this->db_web->select('ciudad.codigo,ciudad.nombre');
        $this->db_web->from('ruta');
        $this->db_web->join('ciudad', 'ciudad.codigo = ruta.ciudad_destino_codigo');
        $this->db_web->where($condicion);
        $res_query = $this->db_web->get();
        return $res_query;
    }

    public function GetOrigen()
    {
        $this->db_web->distinct('ruta.ciudad_origen_codigo');
        $this->db_web->select('ciudad.codigo,ciudad.nombre');
        $this->db_web->from('ruta');
        $this->db_web->join('ciudad', 'ciudad.codigo = ruta.ciudad_origen_codigo');
        $this->db_web->where('ruta.estado',1);
        $this->db_web->order_by('ciudad.codigo','asc');
        $res_query = $this->db_web->get();
        return $res_query;
    }


    /**
    * Description of GetSumaTotalPorRutasAgrupadas
    * obtener ventas por rutas
    */
    public function GetSumaTotalPorRutasAgrupadas($desde,$hasta,$origen,$destino,$tipo)
    {
        if ($desde) {
            $d=$desde.' 00:00:00';
        }
        else{
            $d=date('Y-m-d').' 00:00:00';
        }
        if ($hasta) {
            $h=$hasta.' 23:59:59';
        }
        else{
            $h=date('Y-m-d').' 23:59:59';
        }

        $this->db_web->select('CONCAT(origen," - ",destino) AS ruta, ROUND(SUM(total_pagar),2) AS total');
        $this->db_web->from('reserva');
        $this->db_web->where('fecha_registro >=',$d);
        $this->db_web->where('fecha_registro <=',$h);
        if ($tipo!='') {
            $this->db_web->where('tipo_viaje',$tipo);
        }

        if ($origen!='') {
            $this->db_web->where('origen',$origen);
        }
        if ($destino!='') {
            $this->db_web->where('destino',$destino);
        }
        $this->db_web->where('estado',1);
        $this->db_web->group_by('ruta');
        $this->db_web->order_by('total','desc');
        $res_query = $this->db_web->get();
        return $res_query;
    }

    /**
    * Description of GetSumaTotalANDcantidadVentaDiaria
    * obtener ventas por diarias por cantidad y total
    */
    public function GetSumaTotalANDcantidadVentaDiaria($dia,$mes,$anio,$canal)
    {
        $this->db_web->select('HOUR(fecha_registro) AS hora,cc_code, ROUND(SUM(total_pagar),2) AS importe, COUNT(total_pagar) as cantidad');
        $this->db_web->from('reserva');
        $this->db_web->where('DAY(fecha_registro)',$dia);
        $this->db_web->where('MONTH(fecha_registro)',$mes);
        $this->db_web->where('YEAR(fecha_registro)',$anio);
        if ($canal!='') {
            $this->db_web->where('dispositivo',$canal);
        }
        $this->db_web->where('estado',1);
        $this->db_web->group_by(['hora', 'cc_code']);
        $res_query = $this->db_web->get();
        return $res_query;
    }

    /**
    * Description of GetPorPaisData
    * obtener ventas por pais
    */
    public function GetPorPaisData($desde,$hasta)
    {
        $this->db_web->select('R.nacionalidad,P.nombre_pais, R.cc_code, ROUND(SUM(R.total_pagar),2) AS importe, SUM(R.cant_adl+R.cant_chd+R.cant_inf) as cantidad');
        $this->db_web->from('reserva R');
        $this->db_web->join('pais P', 'P.id = R.nacionalidad');
        $this->db_web->where('R.fecha_registro >=',$desde);
        $this->db_web->where('R.fecha_registro <=',$hasta);
        $this->db_web->where('R.estado',1);
        $this->db_web->group_by(['P.nombre_pais', 'R.cc_code']);
        $this->db_web->order_by('P.nombre_pais');
        $this->db_web->order_by('R.cc_code');
        $res_query = $this->db_web->get();
        return $res_query;
    }

    public function GetPaisAsociado($desde,$hasta)
    {
        $this->db_web->select('P.nombre_pais');
        $this->db_web->from('reserva R');
        $this->db_web->join('pais P', 'P.id = R.nacionalidad');
        $this->db_web->where('R.fecha_registro >=',$desde);
        $this->db_web->where('R.fecha_registro <=',$hasta);
        $this->db_web->where('R.estado',1);
        $this->db_web->group_by('P.nombre_pais');
        $this->db_web->order_by('P.nombre_pais');
        $res_query = $this->db_web->get();
        return $res_query;
    }

    /**
    * Description of GetSumaTotalANDcantidadVentaMensual
    * obtener ventas mensual de la tabla reservas de la DB_WEB
    */
    public function GetSumaTotalANDcantidadVentaMensual($mes,$anio,$medio)
    {
        $this->db_web->select('DATE_FORMAT(fecha_registro, "%w") nombre,DAY(fecha_registro) dia, ROUND(SUM(total_pagar), 2) importe, SUM(cant_adl+cant_chd+cant_inf) cantidad');
        $this->db_web->from('reserva');
        $this->db_web->where('MONTH(fecha_registro)',$mes);
        $this->db_web->where('YEAR(fecha_registro)',$anio);
        $this->db_web->where('estado',1);
        if ($medio) {
            $this->db_web->where('cod_compartido_vuelo_ida',$medio);
        }
        $this->db_web->group_by(["DATE_FORMAT(fecha_registro,'%U')","DATE_FORMAT(fecha_registro, '%w')","DAY(fecha_registro)"]);
        $this->db_web->order_by(1);
        $this->db_web->order_by(2);
        $res_query = $this->db_web->get();
        return $res_query;
    }

    /**
    * Description of GetSumaTotalANDcantidadVentaMensualPeruCompras
    * obtener ventas mensual de la tabla Reservas de la DB_WEB_PROD
    */
    public function GetSumaTotalANDcantidadVentaMensualPeruCompras($mes,$anio)
    {
        $this->db_pasarela_prod->select('DATE_FORMAT(Reserva.FechaRegistro, "%w") nombre, DAY(Reserva.FechaRegistro) dia, ROUND(SUM(Reserva_Detalle.TotalPagar), 2) importe, COUNT(*) cantidad');
        $this->db_pasarela_prod->from('Reserva');
        $this->db_pasarela_prod->join('Reserva_Detalle', 'Reserva.Registro = Reserva_Detalle.Registro');
        $this->db_pasarela_prod->where('Ticket <>','');
        $this->db_pasarela_prod->where('Reserva_Detalle.Flag',1);
        $this->db_pasarela_prod->where('Reserva_Detalle.EstadoRegistro',1);
        $this->db_pasarela_prod->where('Reserva.EstadoRegistro',1);
        $this->db_pasarela_prod->where('MONTH(Reserva.FechaRegistro)',$mes);
        $this->db_pasarela_prod->where('YEAR(Reserva.FechaRegistro)',$anio);
        $this->db_pasarela_prod->group_by(["DATE_FORMAT(Reserva.FechaRegistro,'%U')","DATE_FORMAT(Reserva.FechaRegistro, '%w')","DAY(Reserva.FechaRegistro)"]);
        $this->db_pasarela_prod->order_by(1);
        $this->db_pasarela_prod->order_by(2);
        $res_query = $this->db_pasarela_prod->get();
        return $res_query;
    }


    /**
    * Description of GetSumaTotalANDcantidadVentaMensualNeta
    * obtener ventas mensual neta
    */
    public function GetSumaTotalANDcantidadVentaMensualNeta($mes,$anio,$medio)
    {
        $this->db_web->select('DATE_FORMAT(fecha_registro, "%w") nombre,DAY(fecha_registro) dia, ROUND(SUM(eq), 2) importe, SUM(cant_adl+cant_chd+cant_inf) cantidad');
        $this->db_web->from('reserva');
        $this->db_web->where('MONTH(fecha_registro)',$mes);
        $this->db_web->where('YEAR(fecha_registro)',$anio);
        $this->db_web->where('estado',1);
        if ($medio) {
            $this->db_web->where('cod_compartido_vuelo_ida',$medio);
        }
        $this->db_web->group_by(["DATE_FORMAT(fecha_registro,'%U')","DATE_FORMAT(fecha_registro, '%w')","DAY(fecha_registro)"]);
        $this->db_web->order_by(1);
        $this->db_web->order_by(2);
        $res_query = $this->db_web->get();
        return $res_query;
    }

    /**
    * Description of GetVentaMensualExcel
    * obtener reporte de ventas mensuales
    */
    public function GetVentaMensualExcel($mes,$anio)
    {
        $this->db_web->select('*,DATEDIFF(fechahora_salida_tramo_ida,fecha_registro) diferencia');
        $this->db_web->from('reserva');
        $this->db_web->where('MONTH(fecha_registro)',$mes);
        $this->db_web->where('YEAR(fecha_registro)',$anio);
        $this->db_web->order_by('id','desc');
        // $this->db_web->limit(20);
        $res_query = $this->db_web->get();
        return $res_query;
    }

    /**
    * Description of GetVentaMensualDetalleExcel
    * obtener reporte de ventas mensuales inner join con detalle_reserva
    */
    public function GetVentaMensualDetalleExcel($mes,$anio)
    {
        $this->db_web->select('r.*,DATEDIFF(r.fechahora_salida_tramo_ida,r.fecha_registro) diferencia,rd.num_ticket');
        $this->db_web->from('reserva r');
        $this->db_web->join('reserva_detalle rd', 'r.id = rd.reserva_id','LEFT');
        $this->db_web->where('MONTH(fecha_registro)',$mes);
        $this->db_web->where('YEAR(fecha_registro)',$anio);
        $this->db_web->order_by('r.id','desc');
        // $this->db_web->limit(40);
        $res_query = $this->db_web->get();
        return $res_query;
    }
}