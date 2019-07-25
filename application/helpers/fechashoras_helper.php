<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function dateddmmyy() {
    return date('d/m/Y');
}

function firstDay() {
    return date('01/m/Y');
}

function fecha_yyyymd() {
    return date('Y-m-d');
}

function TimeStamp() {
    return gmdate("Y-m-d\TH:i:s\Z", time() - (3600 * 5));
}

function TransmissionDateTime() {
    return gmdate("Y-m-d\TH:i:s", time() - (3600 * 5));
}

function AnioMesdia() {
    return gmdate("Ym");
}

function TimeStampIATA() {
    return gmdate("YmdHis", time() - (3600 * 5));
}

function CorrelationID() {
    $correlationID = '';
    for ($i = 0; $i < 18; $i++) {
        $correlationID .= rand(0, 9);
    }
    return $correlationID;
}

function DateFormatCarga($fecha_db) {

    if ($fecha_db == NULL) {
        return 'SIN DATA';
    }
    $fecha_hora_s_f = explode(" ", $fecha_db); //Solo nos quedamos con la fecha
    $fecha_partes = explode("-", $fecha_hora_s_f[0]);
    $fecha = $fecha_partes[2] . "/" . $fecha_partes[1] . "/" . $fecha_partes[0];

    return $fecha;
}

function DateTimeFormarCarga($fecha_db) {
    if ($fecha_db == NULL) {
        return 'NO EXISTE INFORMACIÓN';
    }
    $fecha_partida = explode(" ", $fecha_db);
    $date_partida = explode("-", $fecha_partida[0]);
    $date_ordenada = $date_partida[2] . "/" . $date_partida[1] . "/" . $date_partida[0];
    $time_split = explode(".", $fecha_partida[1]);
    $fecha_formar_cargo = $date_ordenada . " " . $time_split[0];

    return $fecha_formar_cargo;
}

function formatSQLServer($fecha) { //SQL NO NECESITA ESTE FORMATO PARA EL INSERT O EL UPDATE 
    $date_partida = explode("/", $fecha);
    $date_sql = $date_partida[2] . "-" . $date_partida[1] . "-" . $date_partida[0];

    return $date_sql;
}

function getTimeStampSQLs() {
    return date('Y-m-d H:i:s');
}

function getRangoDiasFechas($fec_inicio, $fec_fin) {

    $dias = ($fec_inicio - $fec_fin) / 86400;
    $dias = abs($dias);
    $dias = floor($dias) + 1; // Le sumo 1 para que se tome en cuenta el día de inicio

    return $dias;
}

function aumenta_o_restaDias($nDayAdd, $accion, $fecha, $formatDate = null) {

    //FORMATO DE FECHA SOPORTADO: (Y-m-d)
    $newDate = strtotime("$accion" . "$nDayAdd day", strtotime($fecha));
    switch ($formatDate) {
        case 'dd/mm/yyyy':
            $resDate = date('d/m/Y', $newDate);
            break;
        default :
            $resDate = date('Y/m/d', $newDate);
    }
    return $resDate;
}

function formateaFechaGenerica($fechaTimeStampDB) {  // Se recibe fecha en formato TimeStamp Ymd hms
    $date = new DateTime($fechaTimeStampDB);
    return $date->format('d/m/Y H:i:s');
}

function diferenciaDias($fechaCompara) {
    $fechaCompara = new DateTime($fechaCompara);
    $fechaHoy = new DateTime(TimeStamp());
    $interval = $fechaCompara->diff($fechaHoy);
    return $interval->format('%a'); //retorna la diferencia de días
}

function formateaFecha($celda_fecha, $proyecto) {
    $InvFecha = $celda_fecha->getValue();
    if (PHPExcel_Shared_Date::isDateTime($celda_fecha)) {
        $InvDate = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvFecha));
    }
    switch ($proyecto) {
        case 'CARGA':
            $mod_date = strtotime($InvDate);
            break;
        case 'IATA':
            $mod_date = strtotime($InvDate . "+ 1days");
            break;
    }

    //AQUI LE DAMOS VALOR AL OBJETO
    return date("Y-m-d", $mod_date);
}

function getEspaniolNombreDia($nameDiaEn) {

    switch (strtoupper($nameDiaEn)) {
        case 'MON':
            $nombreDiaEs = 'Lunes';
            break;
        case 'TUE':
            $nombreDiaEs = 'Martes';
            break;
        case 'WED':
            $nombreDiaEs = 'Miércoles';
            break;
        case 'THU':
            $nombreDiaEs = 'Jueves';
            break;
        case 'FRI':
            $nombreDiaEs = 'Viernes';
            break;
        case 'SAT':
            $nombreDiaEs = 'Sábado';
            break;
        case 'SUN':
            $nombreDiaEs = 'Domingo';
            break;
        default :$nombreDiaEs = 'Desconocido';
    }
    return $nombreDiaEs;
}

function getEspaniolNombreMes($nameMesEn) {

    switch (strtoupper($nameMesEn)) {
        case 'JAN':
            $nameMesEs = 'Enero';
            break;
        case 'FEB':
            $nameMesEs = 'Febrero';
            break;
        case 'MAR':
            $nameMesEs = 'Marzo';
            break;
        case 'APR':
            $nameMesEs = 'Abril';
            break;
        case 'MAY':
            $nameMesEs = 'Mayo';
            break;
        case 'JUN':
            $nameMesEs = 'Junio';
            break;
        case 'JUL':
            $nameMesEs = 'Julio';
            break;
        case 'AUG':
            $nameMesEs = 'Agosto';
            break;
        case 'SEP':
            $nameMesEs = 'Septiembre';
            break;
        case 'OCT':
            $nameMesEs = 'Octubre';
            break;
        case 'NOV':
            $nameMesEs = 'Noviembre';
            break;
        case 'DEC':
            $nameMesEs = 'Diciembre';
            break;
        default :$nameMesEs = 'Desconocido';
    }
    return $nameMesEs;
}

function FSisCarDMY($arg) {
    $date = new DateTime($arg);
    $fecha = $date->format('d/m/Y');
    return $fecha;
}

function CalcularDiasRestantes($f_ini, $f_fin) {
    if (!is_null($f_ini) && !is_null($f_fin)) {
        $FechaGeneracion_Obj = new DateTime($f_ini);
        $FechaEstimadaFin_Obj = new DateTime($f_fin);
        $d = $FechaGeneracion_Obj->diff($FechaEstimadaFin_Obj);
        return (int) $d->format('%d') - 1;
    } else {
        return FALSE;
    }
}

if (!function_exists('fecha_iso_8601')) {

    function fecha_iso_8601($fecha_human) {
        $date = str_replace('/', '-', $fecha_human);
        $fecha2 = date("Y-m-d", strtotime($date));
        return $fecha2;
    }

}

if (!function_exists('fecha_iso_8601_c')) {
    function fecha_iso_8601_c($fecha,$s) {
        if ($fecha) {
            $date = str_replace('/', '-', $fecha);
        }
        else{
            $date = date('Y-m-d');
        }
        if ($s==1) {
            $h=' 00:00:00';
        }
        else{
            $h=' 23:59:59';
        }
        $fecha2 = date("Y-m-d", strtotime($date)).$h;
        return $fecha2;
    }
}

if (!function_exists('OperarAnios')) {

    function OperarDiasMesAnios($fechaiso,$accion) {
        $nuevafecha = strtotime($accion, strtotime($fechaiso));
        return date('Y-m-d', $nuevafecha);
    }

}

if (!function_exists('RestarSumarFecha')) {
    /*
     * @Fecha_Ymd => Parametro tipo string con formato d/m/y, fecha de salida elegida por el pasajeto
     * @Dias => Cantidad de dias a aumentar o restar.
     */

    function RestarSumarFecha($Fecha_Ymd, $Dias) {
//        return fecha_iso_8601($Fecha_Ymd);
        $FechaUnixOperado = strtotime("$Dias day", strtotime($Fecha_Ymd));
        return strftime("%Y-%m-%d", $FechaUnixOperado);
    }

}