<?php

if (!defined('BASEPATH')) {
    exit("No direct script access allowed");
}

function concatenaciudad_cod($arrayCiudadesIata) {
    switch($arrayCiudadesIata){
        case 'CUZ':
               $nombreciudadYcod = $arrayCiudadesIata."*".'CUZCO';
            break;
        case 'HUU':
                $nombreciudadYcod = $arrayCiudadesIata."*".'HUÁNUCO';
            break;
        case 'IQT':
            $nombreciudadYcod = $arrayCiudadesIata."*".'IQUITOS';
            break;
        case 'LIM':
            $nombreciudadYcod = $arrayCiudadesIata."*".'LIMA';
            break;
        case 'PCL':
            $nombreciudadYcod = $arrayCiudadesIata."*".'PUCALPA';
            break;
        case 'PEM':
            $nombreciudadYcod = $arrayCiudadesIata."*".'PUERTO MALDONADO';
            break;
        case 'TPP':
            $nombreciudadYcod = $arrayCiudadesIata."*".'TARAPOTO';
            break;
        default : $nombreciudadYcod='';
    }
    return $nombreciudadYcod;
}

function getCodCiudades($String_Ciudad){
    
    $cod_ciudad = '';
    switch(trim($String_Ciudad)){
        case 'Lima':
            $cod_ciudad = 'LIM';
            break;
            
    }
    return $cod_ciudad;
    
}
