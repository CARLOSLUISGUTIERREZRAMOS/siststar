<?php

function dispara_log_kiu($id_reserva,$metodo_servicio,$rq,$rs)
{
    	$arch = fopen(realpath( '.' )."/logs/log_web_kiu_".date("Y-m-d").".txt", "a+"); 

	fwrite($arch, "[".date("Y-m-d H:i:s.u")." "
                .$_SERVER['REMOTE_ADDR']." "
                . "- $id_reserva ] [METODO: $metodo_servicio] "."\n".$rq."\n".$rs."\n");
	fclose($arch);
}

function crear_objeto_js($data,$name)
{
	$arch = fopen(realpath( '.' )."/js/starperu/".$name.".js", "w+");
	fwrite($arch, $data);
	fclose($arch);
}