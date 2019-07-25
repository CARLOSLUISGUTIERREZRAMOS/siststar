<?php

if (!function_exists('ArmarTramaTipoCredito_DemandTicket')) {

    //TARJETA DE CREDITO
    function ArmarTramaTipoCredito_DemandTicket($miscellaneous, $PaymentType, $reserva_id, $pnr, $ruc, $cod_autcard, $card_number) {

        $trama = array(
            'PaymentType' => "$PaymentType",
            'CreditCardCode' => "$miscellaneous",
            'CreditCardNumber' => str_replace('*', '0', $card_number),
            'CreditSeriesCode' => $cod_autcard,
            'CreditExpireDate' => "9999",
            'Country' => "PE",
            'Currency' => "USD",
            'TourCode' => "",
            'BookingID' => trim($pnr),
            'InvoiceCode' => "ACME",
            'VAT' => $ruc
        );
        return $trama;
    }

}

//PAGO EFECTIVO Y SAFETYPAY
if (!function_exists('ArmarTramaTipoMiscelaneo_DemandTicket')) {

    function ArmarTramaTipoMiscelaneo_DemandTicket($miscellaneous, $PaymentType, $reserva_id, $pnr, $ruc) {

        $trama = array(
            'PaymentType' => "$PaymentType",
            'MiscellaneousCode' => "$miscellaneous", // SafetyPay => SP | PagoEfectivo = PE
            'InvoiceCode' => "ACME",
            'Country' => "PE",
            'Currency' => "USD",
            'TourCode' => "",
            'BookingID' => trim($pnr),
            'InvoiceCode' => "ACME",
            'Text' => $reserva_id,
            'VAT' => $ruc // En caso tenga =>  ''
        );
        return $trama;
    }

}
if (!function_exists('ArmaTrama_TravelItinerary')) {

    function ArmaTrama_TravelItinerary($ticket, $email_pax) {

        $trama = array('IdTicket' => $ticket, 'Email' => $email_pax);

        return $trama;
    }

}

if (!function_exists('ArmaTrama_TravelItinerary_segforma')) {

    function ArmaTrama_TravelItinerary_segforma($pnr, $email_pax, $ticket) {

        $args = array(
            'IdReserva' => "$pnr",
            'Email' => "$email_pax",
            'IdTicket' => "$ticket"
        );

        return $args;
    }

}

