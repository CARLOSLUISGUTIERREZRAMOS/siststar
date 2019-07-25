<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//Generación de Password
function help_enviarEmail($nombre, $apellido, $codigo, $password, $email) {
//    $linkSistStar = base_url();
//    $dirUrlImg = base_url() . 'img/LogoStar.png';
    $data['nombre'] = $nombre;
    $data['apellido'] = $apellido;
    $data['codigo'] = $codigo;
    $data['password'] = $password;
    $CI = &get_instance();
    $html_formato_email = $CI->load->view('templates/mail_credenciales', $data, TRUE);
    $remitente = "r2d2@starperu.com";
    $to = 'carlos.gutierrez@starperu.com'; //TEST
//    $to = $email; //PROD
    $subject = "CREDENCIALES DE ACCESO";
    $mail .= "</body></html>";
    $html_formato_email = utf8_decode($html_formato_email);
    $cabeceras = "Content-type: text/html\r\n";
    $cabeceras .= "From: | SISTSTAR | " . " <$remitente>\r\n";
    //DESACTIVAR LA LINEA DE ABAJO CUANDO EL APP ESTE EN EL SERVIDOR.
//        mail($to, $subject, $message, $cabeceras);
    mail($to, $subject, $html_formato_email, $cabeceras);
}

function help_enviaEmailTicket($ticket, $mailRem, $responsables) {
    $data['ticket'] = $ticket;
    $data['mailRemite'] = $mailRem;
    $data['responsables'] = $responsables;
    $data['tipo_rol'] = 'SOLICITANTE';
    $CI = &get_instance();

    $html_formato_email = $CI->load->view('templates/mail_ticket', $data, TRUE);

    $remitente = "r2d2@starperu.com";
    $to = $mailRem;
//    $to = 'carlos5t@hotmail.com';
    $subject = "[Ticket#$ticket]";
    $html_formato_email = utf8_decode($html_formato_email);
    $cabeceras = "Content-type: text/html\r\n";
    $cabeceras .= "From: SISTEMA DE TICKETS - SISTSTAR " . " <$remitente>\r\n";
    mail($to, $subject, $html_formato_email, $cabeceras);
//    return $mail;
}

function help_enviaEmailRefund($data_refund, $email_prog_refund) {
    $CI = &get_instance();
    $num_refund = $data_refund['numero_refund'];
    $email_pax_refund = $data_refund['email_pax_refund'];
    $html_formato_email = $CI->load->view('templates/mail_refund', $data_refund, TRUE);
//    $remitente = "reembolsos_r2d2@starperu.com";
    $remitente = "refund@starperu.com";
//   $to = "$email_prog_refund";
    $to = "reembolsos@starperu.com";
//   $to = "$email_programa_pago";
//    $to = 'carlos5t@hotmail.com';
    $subject = "[Num Refund # $num_refund]";
    $html_formato_email = utf8_decode($html_formato_email);
    $cabeceras = "Content-type: text/html\r\n";
    $cabeceras .= "From: SISTEMA DE REEMBOLSOS - STARPERU " . " <$remitente>\r\n";
    if (isset($email_pax_refund) && !empty($email_pax_refund)) {
        $cabeceras .= "Bcc: $email_prog_refund,carlos.gutierrez@starperu,$email_pax_refund" . "\r\n";
    } else {
        $cabeceras .= "Bcc: $email_prog_refund,carlos.gutierrez@starperu" . "\r\n";
    }

    mail($to, $subject, $html_formato_email, $cabeceras);
//    return $mail;
}

function help_enviaEmailTicket_responsable($ticket, $mailRem) {
    $data['ticket'] = $ticket;
    $data['mailRemite'] = $mailRem;
    $data['tipo_rol'] = 'REPONSABLE';
    $CI = &get_instance();

    $html_formato_email = $CI->load->view('templates/mail_ticket', $data, TRUE);

    $remitente = "r2d2@starperu.com";
    $to = $mailRem;
//    $to = 'carlos5t@hotmail.com';
    $subject = "[Ticket#$ticket]";
    $html_formato_email = utf8_decode($html_formato_email);
    $cabeceras = "Content-type: text/html\r\n";
    $cabeceras .= "From: SISTEMA DE TICKETS - SISTSTAR " . " <$remitente>\r\n";
    mail($to, $subject, $html_formato_email, $cabeceras);
//    return $mail;
}

function help_enviaEmailLineaCredito($data_linea) {
    $CI = &get_instance();
    $linea_send = $data_linea['linea_send'];
    $html_formato_email = $CI->load->view('agencias/email/v_mail_linea_credito', $data_linea, TRUE);
    $remitente = "cw360starperu@gmail.com";
    // $remitente = "ecel@starperu.com";
    // $to = "gabriela.monge@starperu.com";
    $to = $data_linea["email_send"];
    $subject = "[ASIGNACION DE LINEA DE CREDITO USD $linea_send]";
    $html_formato_email = utf8_decode($html_formato_email);
    $cabeceras = "Content-type: text/html\r\n";
    $cabeceras .= "From: ¡ASIGNACIÓN DE LINEA DE CRÉDITO! - STARPERU " . " <$remitente>\r\n";
    $cabeceras .= "Bcc: perfectohenry@gmail.com" . "\r\n";
    $a=mail($to, $subject, $html_formato_email, $cabeceras);
}

function help_enviaEmailResetearPassword($data) {
    $CI = &get_instance();
    // $linea_send = $data['email'];
    $html_formato_email = $CI->load->view('agencias/email/v_mail_resetear_password', $data, TRUE);
    $remitente = "cw360starperu@gmail.com";
    // $remitente = "ecel@starperu.com";
    // $to = "gabriela.monge@starperu.com";
    $to = $data["email"];
    $subject = utf8_decode("[CAMBIO DE CONTRASEÑA]");
    $html_formato_email = utf8_decode($html_formato_email);
    $cabeceras = "Content-type: text/html\r\n";
    $cabeceras .= utf8_decode("From: CAMBIO DE CONTRASEÑA - STARPERU " . " <$remitente>\r\n");
    $a=mail($to, $subject, $html_formato_email, $cabeceras);
}

function help_enviaEmailEstadoAgencia($data) {
    $CI = &get_instance();
    // $linea_send = $data['email'];
    $html_formato_email = $CI->load->view('agencias/email/v_mail_agencia_estado', $data, TRUE);
    $remitente = "cw360starperu@gmail.com";
    // $remitente = "ecel@starperu.com";
    // $to = "gabriela.monge@starperu.com";
    $to = $data["email"];
    $subject = $data['estado']==1 ? utf8_decode("ACTIVACIÓN DE LA AGENCIA") : utf8_decode("DESACTIVACIÓN DE LA AGENCIA");
    $html_formato_email = utf8_decode($html_formato_email);
    $cabeceras = "Content-type: text/html\r\n";
    $cabeceras .= utf8_decode("From: ESTADO DE LA AGENCIA - STARPERU " . " <$remitente>\r\n");
    $a=mail($to, $subject, $html_formato_email, $cabeceras);
}
