<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('helpConvertStdClassToArray')) {

    //creamos la funcion y no explico mas sobre que es cada linea por que eso ya es otro tema.
    function helpConvertStdClassToArray($stdClass) {
        $array = json_decode(json_encode($stdClass), true);
        return $array;
    }

}

function concatenaCero($arg) {
    if (substr($arg, 0, 1) == '.') {
        $importe = '0' . $arg;
    } else {
        $importe = $arg;
    }
    return $importe;
}

function muestraEnConsola($data) {
    echo "<script>console.log('" . $data . "')</script>";
    die;
}

function validaCelular($num_celular) {
    $cellPhone_p = preg_replace('/-/', "", $num_celular);
    return $cellPhone_p;
}

function descompone2Iteraciones($data1, $replace1, $replace1By, $replace2, $replace2By, $W, $Z) {
    /* @ LOS RANGOS PERSONALIZADOS SERAN LAS VARIABLES W Y Z QUE SERAN ENVIADAS
     * POR PARAMETRO EN ESTA FUNCION, LO ESTANDAR O NORMAL SERIA QUE INGRESEN CON
     * VALOR W=0 y Z=0 LO CUAL SERÍA TAL CUAL MUESTRA LA TABLA ANTES DE SER PROCESADA
     * PARA SU IMPRESION O PASAR A LA LOGICA DE FPDF.
     */
    $data_tbl = array();
    $fila_ree = str_replace($replace1, $replace1By, $data1);
    $split_fila = explode('*', $fila_ree);
    for ($i = 0; $i < count($split_fila); $i++) {

        $celdas = str_replace($replace2, $replace2By, $split_fila[$i]);
        $split_celdas = explode('°', $celdas);
        $p = 0;
        for ($j = $W; $j < count($split_celdas) - $Z; $j++) {
            $data_tbl[$i][$p] = $split_celdas[$j];
            $p++;
        }
    }
    return $data_tbl;
}

function encrypt_base64($string, $key) {
    $result = '';
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $char = chr(ord($char));
        $result.=$char;
    }
    return base64_encode($result);
}

function decrypt_base64($string, $key) {
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
       $char = substr($string, $i, 1);
       $char = chr(ord($char));
       $result.=$char;
    }
    return $result;
}

function generaPassword(){
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=8;
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}
