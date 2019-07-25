<?php
if (!defined('BASEPATH')){exit('No direct script access allowed');}
if (!function_exists('helpCiudad_generaSelect')) {
    //creamos la funcion y no explico mas sobre que es cada linea por que eso ya es otro tema.
    function helpCiudad_generaSelect($data_ciudades) {
        $cant_ciudad = count($data_ciudades);
        $select = '';
        if($cant_ciudad>1){
            $select .= '<option value="">SELECCIONAR</option>'."\n";
            
        }else{
            $select .= '<option value="">NO HAY CIUDADES</option>'."\n";
        }
        foreach ($data_ciudades as $fila){
           $select .= '<option value="'.$fila['cod_ciudad'].'">'.$fila['nombre_ciudad'].'</option>';                    
        }
        $data["select_ciudad"] = $select;
        return $data;
    }
}
if (!function_exists('helpArea_generaSelect')) {
    //creamos la funcion y no explico mas sobre que es cada linea por que eso ya es otro tema.
    function helpArea_generaSelect($data_areas) {
        $cant_areas = count($data_areas);
        $select = '';
        if($cant_areas>1){
            $select .= '<option value="">SELECCIONAR</option>'."\n";
            
        }else{
            $select .= '<option value="">NO HAY CIUDADES</option>'."\n";
        }
        foreach ($data_areas as $fila){
           $select .= '<option value="'.$fila['codigo_area'].'">'.utf8_encode($fila['nombre_area']).'</option>';                    
        }
        $data["select_area"] = $select;
        return $data;
    }
}

    function helpCargo_generaSelect($data_cargos) {
        $cant_cargos = count($data_cargos);
        $select = '';
        if($cant_cargos>=1){
            $select .= '<option value="">SELECCIONAR</option>'."\n";
            
        }else{
            $select .= '<option value="">NO HAY CARGOS</option>'."\n";
        }
        foreach ($data_cargos as $fila){
           $select .= '<option value="'.$fila['id_cargo'].'">'.utf8_encode($fila['nombre_cargo']).'</option>';                    
        }
        $data["select_cargo"] = $select;
        return $data;
    }
    function helpGenericSelect($data){
        $cant = count($data);
        $select = '';
        if($cant>=1){
            $select .= '<option value="">SELECCIONAR</option>'."\n";
            
        }else{
            $select .= '<option value="">NO HAY REGISTROS</option>'."\n";
        }
        foreach ($data as $fila){
           $select .= '<option value="'.$fila[1].'">'.$fila[0]." ".$fila[2]." ".$fila[3]." ".$fila[4]." ".$fila[5]." ".$fila[6]." ".$fila[7]." ".$fila[8].'</option>';                    
        }
        $data["select"] = $select;
        return $data;
    }
    function generar_select_general($array,$selected=null){
         
        $select="";
        foreach($array as $value){
            $id = $value[0];
            $item = $value[1];
            
                if($item==$selected){
                $select.='<option value="'.$id.'" selected>'.utf8_encode($item).'</option>';
                }
            
            else{
                $select.='<option value="'.$id.'">'.utf8_encode($item).'</option>'; 
            }
            
        }
        return $select;
    }
    function generar_select_meses(){
        $mes = date('m');
        $array_meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Setiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
        $i=1;
        
        $select_meses = '<select name="mes1" id="mes1">';
        for($i=1;$i<=12;$i++){
            if($mes==$i){
                $select_meses .= '<option value='.$i.' selected>'.$array_meses[$i].'</option>';    
            }else{
                $select_meses .= '<option value='.$i.'>'.$array_meses[$i].'</option>';    
            }    
        }
        $select_meses .= '</select>';
        return  $select_meses;
    }
    
    function genera_select_anios(){
        $anio = date('Y');
        $selec_anio = '<select id="anio">';
        for($i=2017; $i<$anio+3;$i++){
            if($i==$anio){
                $selec_anio .= '<option value="'.$i.'" selected>'.$i.'</option>';
            }else{
                $selec_anio .= '<option value="'.$i.'">'.$i.'</option>';
            }
        }
        $selec_anio .= '<select/>';
        return $selec_anio;
    }
    
    function genera_select($arg1,$arg2){
        $optiondetallecarga = '';
        for($i=0; $i<count($arg1);$i++){
             $optiondetallecarga .= "<option value=\"$arg1[$i]\">".utf8_encode($arg2[$i])."</option>";
        }
        return $optiondetallecarga;
    }
    
    function genera_select_ciudades($cod_ciudad){
        $options = '';
        for($i=0;$i<count($cod_ciudad);$i++){
        
            if($cod_ciudad[$i] == 'IQT'){
                $options .= "<option value=\"$cod_ciudad[$i]\">IQUITOS</option>";
            }else if($cod_ciudad[$i]  == 'CUZ'){
                $options .= "<option value=\"$cod_ciudad[$i]\">CUZCO</option>";
            }else if($cod_ciudad[$i]  == 'LIM'){
                $options .= "<option value=\"$cod_ciudad[$i]\">LIMA</option>";
            }
        }
        return $options;
    }
//    function genera_select_RutaOrigen_detectadaGeoIp($ciudad){
//        $ciudadM = strtoupper($ciudad);
//        $option = '';
//        switch(trim($ciudadM)){
//            case 'LIMA': 
//                $cod_ciudad = 'LIM';
//                $option .= "<option value='$cod_ciudad'>$ciudadM</option>";
//                break;
//        }
//        return $option;
//    }
    
    