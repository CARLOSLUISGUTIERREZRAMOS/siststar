<?php

class Migracion_Model extends CI_Model{
    
	protected $db_web;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('db_web_prod', TRUE);
        $this->db_local= $this->load->database('db_local', TRUE);
        $this->db_pasarela_prod = $this->load->database('db_pasarela_prod', TRUE);
    }
    public function ObtenerDataDeServidorAnterior($desde,$hasta)
    {
        $this->db_pasarela_prod->select('*');
        $this->db_pasarela_prod->from('reserva');
        $this->db_pasarela_prod->where('fecha_hora >=',$desde);
        $this->db_pasarela_prod->where('fecha_hora <=',$hasta);
        $res_query = $this->db_pasarela_prod->get();
        return $res_query;
    }
    public function MigrarDataReservaServidor($objeto)
    {
        $data=[];
        $data['nombres']        =$objeto["nombre"];
        $data['apellidos']      =$objeto["apellido"];
        $data['tipo_documento'] =$objeto["tipo_documento"];
        $data['num_documento']  =$objeto["documento"];
        $data['ddi_telefono']   =$objeto["ddi_telefono"];
        $data['pre_telefono']   =$objeto["pre_telefono"];
        $data['num_telefono']   =$objeto["telefono"];
        $data['ddi_celular']    =$objeto["ddi_celular"];
        $data['pre_celular']    =$objeto["pre_celular"];
        $data['num_celular']    =$objeto["celular"];
        $data['email']          =$objeto["email"];
        
        $ciudad=explode(',',$objeto["ciudad"]);
        if ($objeto["pais"]) {
            $pais=$objeto["pais"];
        }
        else{
            $pais=$ciudad[1];
        }
        $data['geo_pais']       =$pais;
        $data['geo_ciudad']     =$ciudad[0];
        $data['nacionalidad']   =$this->ObtenerIdPais($ciudad[1]);
        
        $data['fecha_registro'] =$objeto["fecha_hora"];
        $data['fecha_limite']   =$objeto["fecha_limite"];
        $data['cant_adl']       =$objeto["adultos"];
        $data['cant_chd']       =$objeto["menores"];
        $data['cant_inf']       =$objeto["bebes"];
        
        if (strlen($objeto["vuelo_hora_depart"])==5) {
            $hora_ida=$objeto["vuelo_hora_depart"].':00';
        }
        else{
            $hora_ida=$objeto["vuelo_hora_depart"];
        }
        $data['fechahora_salida_tramo_ida'] =$objeto["vuelo_fecha_depart"].' '.$hora_ida;        
        $data['fechahora_llegada_tramo_ida']='0000-00-00 00:00:00';
        
        if ($objeto["vuelo_fecha_return"]) {
            if (strlen($objeto["vuelo_hora_return"])==5) {
                $hora_retorno=$objeto["vuelo_hora_return"].':00';
            }
            else{
                $hora_retorno=$objeto["vuelo_hora_return"];
            }
            $data['fechahora_salida_tramo_retorno'] =$objeto["vuelo_fecha_return"].' '.$hora_retorno;
            $data['fechahora_llegada_tramo_retorno']='0000-00-00 00:00:00';
        }
        $data['clase_ida']=$objeto["fare_depart"];
        if ($objeto["fare_return"]) {
            $data['clase_retorno']=$objeto["fare_return"];
        }
        else{
            $data['clase_retorno']='N';
        }

        $data['tipo_viaje']=$objeto["vuelo_vuelta"];
        $data['pnr']=$objeto["cod_reserva"];
        $data['origen']=$objeto["origen"];
        $data['destino']=$objeto["destino"];
        $data['ip']=$objeto["ip"];
        $data['cc_code']=$objeto["cc_code"];

        if (strlen($objeto["vuelo_ida"])==3) {
            $cod_comp_vuelo_ida='P9';
        }
        else{
            $cod_comp_vuelo_ida='NO';
        }
        $data['num_vuelo_ida']=$objeto["vuelo_ida"];
        $data['cod_compartido_vuelo_ida']=$cod_comp_vuelo_ida;

        if ($objeto["vuelo_retorno"]) {
            if (strlen($objeto["vuelo_retorno"])==3) {
                $cod_comp_vuelo_retorno='P9';
            }
            else{
                $cod_comp_vuelo_retorno='NO';
            }
            $data['num_vuelo_retorno']=$objeto["vuelo_retorno"];
            $data['cod_compartido_vuelo_retorno']=$cod_comp_vuelo_retorno;
        }

        $data['ruc']=$objeto["ruc"];
        $data['total']=$objeto["total"];
        $data['total_pagar']=$objeto["total_pagar"];
        $data['eq']=$objeto["EQ"];
        $data['pe']=$objeto["PE"];
        $data['hw']=$objeto["HW"];

        if ($objeto["movil"]==1) {
            $data['dispositivo']='phone';
        }
        else{
            $data['dispositivo']='computer';
        }

        if ($objeto["num_ticket1"]) {
            $data['estado']=1;
        }
        else{
            $data['estado']=0;
        }
        $this->db_local->insert('reserva',$data);
        $id=$this->db_local->insert_id();
        return; 
    }

    public function ObtenerIdPais($geo)
    {
        $this->db_pasarela_prod->select('*');
        $this->db_pasarela_prod->from('Pais');
        $this->db_pasarela_prod->where('Abreviatura',$geo);
        $this->db_pasarela_prod->limit(1);
        $res_query = $this->db_pasarela_prod->get();
        if (count($res_query->result_array())>0) {
            return (int)$res_query->result_array()[0]["CodigoPais"];
        }
        else{
            return 44;
        }
    }
    public function GetRutas($condicion) {

        $this->db_web->select('ciudad.codigo,ciudad.nombre');
        $this->db_web->from('ruta');
        $this->db_web->join('ciudad', 'ciudad.codigo = ruta.ciudad_destino_codigo');
        $this->db_web->where($condicion);
        $res_query = $this->db_web->get();
        return $res_query;
    }

    function ActualizarEstadoReserva($estado, $reserva_id, $cc_code = NULL) {
        $this->db_web->set('estado', $estado);
        $this->db_web->set('cc_code', $cc_code);
        $this->db_web->where('id', $reserva_id);
        return $this->db_web->update('reserva');
    }

}