<?php

//include "KIU_Model_class.php";
class Controller_kiu extends Model_kiu
{
    function Controller_kiu()
    {
        date_default_timezone_set('America/Lima');
    	$this->TimeStamp = date("c");
    }
    public function AirAvailRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
		$xml = $this->Model_AirAvailRQ($args);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
		return $array;
    }
    
    public function AirBookRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
        $xml = $this->Model_AirBookRQ($args);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
        return $array;
    }

    public function AirPriceRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
        $xml = $this->Model_AirPriceRQ($args);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
        return $array;
    }

    public function AirDemandTicketRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
		$xml = $this->Model_AirDemandTicketRQ($args);
                $json = json_encode($xml);
		$array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
		return $array;
                 
                 
    }
 
    public function TravelItineraryReadRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
		$xml = $this->Model_TravelItineraryReadRQ($args);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
		return $array;
    }

    public function AirCancelRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
    	$xml = $this->Model_AirCancelRQ($args);
    	$json = json_encode($xml);
    	$array = json_decode($json,TRUE);
            $err=array("ErrorCode"=>$this->ErrorCode, "ErrorMsg"=>$this->ErrorMsg);
    	return $array;
    }

    public function AirFareDisplayRQ($args, &$err) {
        $this->ErrorCode = 0;
        $this->ErrorMsg = '';
        $respuesta_model = $this->Model_AirFareDisplayRQ($args);
        $json = json_encode($respuesta_model[0]);
        $array = json_decode($json, TRUE);
        $err = array("ErrorCode" => $this->ErrorCode, "ErrorMsg" => $this->ErrorMsg);
        $salida = array();
        $salida[] = $array;
        $salida[] = $respuesta_model[1];
        $salida[] = $respuesta_model[2];
        $salida[] = $respuesta_model[3];
        return $salida;
    }
 }
 ?>