<?php

if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class Ruta_Model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->db_agencia = $this->load->database('db_agencia', true);
    }

    function obtener_rutas(){
        try {
            $this->db_agencia->distinct();
            $this->db_agencia->select("rut.CodigoRuta,rut.CodigoCiudadOrigen,rut.CodigoCiudadDestino,MAX(far.HoraCalculo) AS HoraCalculo");
            $this->db_agencia->from("ruta As rut");
            $this->db_agencia->from("farebase_ruta AS far");
            $this->db_agencia->where("far.CodigoRuta`=`rut.CodigoRuta");
            $this->db_agencia->where("rut.EstadoRegistro", 1);
            $this->db_agencia->group_by("rut.CodigoRuta");
            $this->db_agencia->group_by("rut.CodigoCiudadOrigen");
            $this->db_agencia->group_by("rut.CodigoCiudadDestino");
            $query = $this->db_agencia->get()->result();
            return $query;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function obtener_ruta_id($id) {
        try {
            $this->db_agencia->select("CodigoCiudadOrigen,CodigoCiudadDestino");
            $this->db_agencia->from("ruta");
            $this->db_agencia->where("CodigoRuta",$id);
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
//    function generar_select_ciudad_ruta($data,$id_ciudad){
//        $array=$this->obtener_rutas2($id_ciudad);
//        $ciudades_disponibles=count($array);
//        $select='';
//        if($ciudades_disponibles>=1){
//             $select.='<option value="">SELECCIONAR</option>'."\n";
//        }else{
//            $select.='<option value="">NO HAY CIUDADES</option>'."\n";
//        }
//        foreach($array as $fila){ 
//            $select.='<option value="'.$fila["CodigoCiudadDestino"].'">'.$fila["ciudad"].'</option>'."\n";
//         }
//        $data["select_ciudad_ruta"]=$select;
//        return $data; 
//    }

    function eliminar_farebase_ruta($origen,$destino){   
        try {
            $this->db_agencia->where("CodigoRuta IN (SELECT CodigoRuta FROM Ruta WHERE CodigoCiudadOrigen='$origen' AND  CodigoCiudadDestino='$destino')");
            $this->db_agencia->delete('farebase_ruta');
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function contar_clase($clase){   
        try {
            $this->db_agencia->select("count(*) as clase_num");
            $this->db_agencia->from("clase");
            $this->db_agencia->where("CodigoClase",$clase);
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;  
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function seleccionar_ruta($origen,$destino){   
        try {
            $this->db_agencia->select("CodigoRuta");
            $this->db_agencia->from("ruta");
            $this->db_agencia->where("CodigoCiudadOrigen",$origen);
            $this->db_agencia->where("CodigoCiudadDestino",$destino);
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function contar_FareBase($fare){   
        try {
            $this->db_agencia->select("count(*) as valor_CodigoFareBase");
            $this->db_agencia->from("farebase");
            $this->db_agencia->where("CodigoFareBase",$fare);
            $query = $this->db_agencia->get();
            $a_data = $query->result_array();
            return $a_data;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function guardar_FareBase($a_data){   
        try {
            $this->db_agencia->insert('farebase', $a_data);
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function guardar_FareBase_Ruta($a_data){   
        try {
            $this->db_agencia->insert('farebase_ruta', $a_data);
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function procesar_data($origen,$destino,$result){
        $tabla.='<table id="table_main" class="table table-bordered table-striped">'."\n";
        $tabla.='<tr>'."\n";
        $tabla.='<th></th>'."\n";
        $tabla.='<th>Codigo FareBase</th>'."\n";
        $tabla.='<th>Fecha Inicio</th>'."\n";
        $tabla.='<th>Fecha Final</th>'."\n";
        $tabla.='<th>Tarifa</th>'."\n";
        $tabla.='</tr>'."\n";
           $tamaño = sizeof($result["FareDisplayInfos"]["FareDisplayInfo"]);
           	if ($tamaño > 0) 
	   {
		$this->eliminar_farebase_ruta($origen,$destino);
                $con=0;
		for ($i = 0; $i < $tamaño - 1; $i++) 
		{
                    	$FerchaArribo=" ";
                        $fare = $result["FareDisplayInfos"]["FareDisplayInfo"][$i]["FareReference"];
			$clase = substr($fare,0,1);
			$tarifa = $result["FareDisplayInfos"]["FareDisplayInfo"][$i]["PricingInfo"]["BaseFare_attr"]["Amount"]+29; // suma el impuesto de combuistible
			$impuesto = $result["FareDisplayInfos"]["FareDisplayInfo"][$i]["Taxes"]["Tax_attr"]["Amount"]; 
			$salida=$result["FareDisplayInfos"]["FareDisplayInfo"][$i]["DepartureLocation"];
			$llegada=$result["FareDisplayInfos"]["FareDisplayInfo"][$i]["ArrivalLocation"];
			$condiciones = $result["FareDisplayInfos"]["FareDisplayInfo"][$i]["FareRulesInfo"];
		
			if (!$impuesto) 
			{
				$impuesto=0.0;
			}
			
			$DepartureDate = $result["FareDisplayInfos"]["FareDisplayInfo"][$i]["TravelDates_attr"]["DepartureDate"];
			$ArrivalDate = $result["FareDisplayInfos"]["FareDisplayInfo"][$i]["TravelDates_attr"]["ArrivalDate"];
			
			if(($origen==$salida) and ($destino==$llegada))
			{
			 
				if($ArrivalDate)
			 	{
			 		$FechaArribo=$ArrivalDate;
				}
			 	else
			 	{
			 	
				 	$fecha=date('Y-m-d');
				 	$data= explode("-", $fecha);
				 	$anio = $data[0]+5;
					$mes = $data[1];
					$dia= $data[2];
				 	$FechaArribo =$anio."-".$mes."-".$dia ;
				 }
			
				if( strpos($fare, "OW")>0 )
				{
					$tipoViaje = "O";
				} 
				else
				{
				
					if( strpos($fare, "RT")>0 )
					{	
						$tipoViaje = "R";	
					} 
					else
					{ 
						$tipoViaje = "";
					}	
				}
			
				    $array=$this->contar_clase($clase);
                                    $valorClase=$array[0]["clase_num"];
			 	
				if ($valorClase>0)
				{
                                    $this->seleccionar_ruta($origen,$destino);
                                    $codigoRuta=$array[0]["CodigoRuta"];
						$array=$this->contar_FareBase($fare);
                                                $valor_codigoFareBase=$array[0]["valor_CodigoFareBase"];
								
						if($valor_codigoFareBase==0)
						{
							$CodClaseFare=substr($fare,0,1);
                                                        $a_data = array(
                                                            'CodigoFareBase' => $fare,
                                                            'NombreFareBase' => $fare,
                                                            'CodigoClase' => $CodClaseFare,
                                                            'TipoViaje' => $tipoViaje
                                                        );
                                                        $this->guardar_FareBase($a_data);
//							$query_Fare="INSERT INTO FareBase(CodigoFareBase,NombreFareBase,CodigoClase,TipoViaje) VALUES ('$fare','$fare','$CodClaseFare','$tipoViaje')";
//							echo "<tr><td>".$query_Fare."</td></tr>";
//							mysql_query($query_Fare, $conexion2) or die(mysql_error());
						}
						$con+=1;
                                                $a_data = array(
                                                            'CodigoRuta' => $codigoRuta,
                                                            'CodigoFareBase' => $fare,
                                                            'Lunes' => 1,
                                                            'Martes' => 1,
                                                            'Miercoles' => 1,
                                                            'Jueves' => 1,
                                                            'Viernes' => 1,
                                                            'Sabado' => 1,
                                                            'Domingo' => 1,
                                                            'HoraCalculo' => date("Y-m-d H:i:s"),
                                                            'Jueves' => $DepartureDate,
                                                            'Viernes' => $FechaArribo,
                                                            'Sabado' => $tarifa,
                                                            'Domingo' => $impuesto,
                                                            'HoraCalculo' => 1
                                                        );
                                                $tabla.="<tr><td>".$con."</td><td>".$fare."</td><td>".$DepartureDate."</td><td>".$FechaArribo."</td><td class='FilaNumero'>".number_format($tarifa,2,',','.')."</td></tr>"."\n";
                                                $this->guardar_FareBase_Ruta($a_data);
//						$query_insert = "INSERT INTO FareBase_Ruta(CodigoRuta,CodigoFareBase,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,Domingo,HoraCalculo,Inicio,Final,Tarifa,Tarifa2,estado_web) VALUES ('$codigoRuta','$fare',1,1,1,1,1,1,1,NOW(),'$DepartureDate','$FechaArribo',$tarifa,$impuesto,1)";
//						echo "<tr><td>".$con."</td><td>".$fare."</td><td>".$DepartureDate."</td><td>".$FechaArribo."</td><td class='FilaNumero'>".number_format($tarifa,2,',','.')."</td></tr>" ;
//						mysql_query($query_insert, $conexion2) or die(mysql_error());
//					}
				}			

			 }
		}
								
	}
        $tabla.='</table>'."\n";
        return $tabla;
    }
}
?>