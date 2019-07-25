<?php

class ReporteTransacciones extends CI_Controller {

    private $kiu;

    public function __construct() {
        parent::__construct();
        if (!isset($this->session->username)):
            header('Location: '.base_url());
        endif;
        $this->template->add_js('js/datatables/jquery.dataTables.min.js');
        $this->template->add_js('js/datatables/dataTables.bootstrap.min.js');
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('js/bootstrap-daterangepicker/daterangepicker.js');
        $this->template->add_js('js/web/reporte_transacciones.js',1);
        $this->template->add_css('css/datatables/dataTables.bootstrap.min.css');
        $this->template->add_css('css/bootstrap-daterangepicker/daterangepicker.css');
        $this->template->add_css('css/web/reporte_transacciones.css',1);
        $this->load->helper('fechasHoras');
        $this->load->helper('logsystemweb');
        $this->load->helper('web/reporte_transacciones');
        $this->load->helper('web/kiu');
        $this->load->model('web/ReporteTransacciones_Model');
        $this->load->model('web/Descuento_Model');
        $this->load->library('kiu/Controller_kiu');
        $this->kiu = new Controller_kiu();
    }

    function index() {
        $this->template->set('titulo', 'REPORTE DE TRANSACCIONES');
        $data['descuentos']=$this->Descuento_Model->GetDescuentos()->result();
        // dd($data['descuentos']);
        $this->template->load(134, 'web/ecommerce/v_reporte_transacciones',$data);
    }

    function Buscar() {

        $this->template->set('titulo', 'REPORTE DE TRANSACCIONES');
        $criterios_busqueda = [];
        $xss_post = $this->input->post(NULL, TRUE);
        $rango = isset($xss_post['rango_ini_fin']) ? $xss_post['rango_ini_fin'] : $xss_post['x_rango_ini_fin'];
        $cc_code = isset($xss_post['cc_code']) ? $xss_post['cc_code'] : $xss_post['x_cc_code'];
        $canal = isset($xss_post['canal']) ? $xss_post['canal'] : $xss_post['x_canal'];
        $num_documento = isset($xss_post['num_documento']) ? $xss_post['num_documento'] : $xss_post['x_num_documento'];
        $apellidos = isset($xss_post['apellidos']) ? $xss_post['apellidos'] : $xss_post['x_apellidos'];
        $pnr = isset($xss_post['pnr']) ? $xss_post['pnr'] : $xss_post['x_pnr'];
        $id = isset($xss_post['id']) ? $xss_post['id'] : $xss_post['x_id'];
        $email = isset($xss_post['email']) ? $xss_post['email'] : $xss_post['x_email'];
        $estado = isset($xss_post['estado']) ? $xss_post['estado'] : $xss_post['x_estado'];
        $nacionalidad = isset($xss_post['nacionalidad']) ? $xss_post['nacionalidad'] : $xss_post['x_nacionalidad'];
        $descuento_id = isset($xss_post['descuento_id']) ? $xss_post['descuento_id'] : $xss_post['x_descuento_id'];
        if ($estado != "") {
            if ($estado == 2) {
                $criterio_estado = '(s_estado=1 OR pe_estado=1 OR pp_estado=1 OR v_estado=1 OR vn_estado=1 OR tc_estado=1)';
            } else if ($estado >= 3 and $estado <= 6) {
                $r = [0, 0, 0, 4, 3, 2, 1];
                $criterio_estado = 'faltante=' . $r[$estado];
            } else {
                $criterio_estado = '';
                $criterios_busqueda['R.estado'] = $estado;
            }
        } else {
            $criterio_estado = '';
        }
        if (!empty($cc_code)):
            $criterios_busqueda['cc_code'] = $cc_code;
        endif;
        if (!empty($nacionalidad)):
            switch ($nacionalidad) {
                case '43':
                    $criterios_busqueda['nacionalidad'] = $nacionalidad;
                    break;
                case 'EX':
                    $criterios_busqueda['nacionalidad !='] = 43;
                    break;
            }
        endif;

        if (!empty($num_documento)):
            $criterios_busqueda['R.num_documento'] = $num_documento;
        endif;
        if (!empty($canal)):
            $criterios_busqueda['canal'] = $canal;
        endif;
        if (!empty($descuento_id)):
            $criterios_busqueda['descuento_id'] = $descuento_id;
        endif;


        $res_fecha = explode('-', $rango);
        $fecha_inicio = fecha_iso_8601(trim($res_fecha[0]));
        $fecha_fin = RestarSumarFecha('+' . fecha_iso_8601(trim($res_fecha[1])), 1);


        $data['PROCESO_BUSQUEDA'] = TRUE;
        $data['Transacciones'] = $this->ReporteTransacciones_Model->GetTransacciones($criterios_busqueda, $apellidos, $fecha_inicio, $fecha_fin, $id, $pnr, $criterio_estado,$email);
        $data['descuentos']=$this->Descuento_Model->GetDescuentos()->result();
        // var_dump($data['Transacciones']);die;
        $this->template->load(134, 'web/ecommerce/v_reporte_transacciones', $data);
    }

    function BuscarTickets() {
        $reserva_id = $_POST['reserva_id'];
        $ReservaDetalle = $this->ReporteTransacciones_Model->ObtenerTicketsReserva($reserva_id);
//        var_dump($ReservaDetalle);die;
        $res_tbl = modal_body_reserva_detalle($ReservaDetalle);
        echo $res_tbl;
    }

    function EnviarEmailPasajero() {
        $reserva_id = $_POST['reserva_id'];
        $email_pax = $this->ReporteTransacciones_Model->ObtenerEmailClienteReserva($reserva_id);
        $res_consulta_boletos = $this->ReporteTransacciones_Model->ObtenerTicketsReserva($reserva_id);
        $boletos = $res_consulta_boletos->row()->num_ticket;
        if (!isset($boletos)) {
            echo "ESTA RESERVA NO TIENE TICKET";
        } else {
            foreach ($res_consulta_boletos->Result() as $boleto) {

                $args = array(
                    'Email' => $email_pax,
                    'IdTicket' => $boleto->num_ticket
                );
                $res_kiu = $this->kiu->TravelItineraryReadRQ($args, $err);

                echo "Boleto enviado con exito";

                dispara_log_kiu($reserva_id, 'TravelItineraryReadRQ', $res_kiu[1], html_entity_decode($res_kiu[2]));
            }
        }
    }

    function anular_reserva_kiu() {
        $id_reserva = $_POST['reserva_id'];
        $cod_reserva = $_POST['pnr'];
        $tickets = array();
        $a_reserva = array();
        $lista_pasajeros = $this->ReporteTransacciones_Model->obtener_pasajeros_reserva($id_reserva);

        foreach ($lista_pasajeros as $pasajero) {
            array_push($tickets, $pasajero['num_ticket']);
        }

        $cant_tickets = count($tickets);
        $errores = '';

        for ($i = 0; $i < $cant_tickets; $i++) {
            $args = array(
                'IdReserva' => $cod_reserva,
                'IdTicket' => $tickets[$i]
            );
            $kiu = $this->kiu->AirCancelRQ($args, $err);
//            $this->reserva_model->eliminar_ticket($cod_reserva,$tickets[$i]);
//            print_r($kiu['POS']['Source']);die;
            if (isset($kiu['Error'])) {
                $errores .= "------------------------------------------" . "\n";
                $errores .= "Ticket - " . $tickets[$i] . "\n";
                $errores .= "Código: " . $kiu['Error']['ErrorCode'] . "\n";
                $errores .= "Mensaje: " . $kiu['Error']['ErrorMsg'] . "\n";
            }

            $id_detalle_reserva = $lista_pasajeros[$i]['id'];
            $a_detalle = array(
                'num_ticket' => ''
            );

            $this->ReporteTransacciones_Model->update_reserva_detalle($id_detalle_reserva, $a_detalle);
            $fila = $i + 1;
        }
//        die;
        $upd_bd = $this->ReporteTransacciones_Model->update_reserva($id_reserva, 3);
        $mensaje = '';
        if ($upd_bd && $errores == ''):
            $mensaje .= "Se anuló la reserva: " . $cod_reserva;
        elseif (!$upd_bd && $errores == ''):
            $mensaje .= "Se anuló la Reserva: $cod_reserva desde KIU pero ocurrió un error al actualizar la BD" . "\n";
        elseif ($upd_bd && $errores != ''):
            $mensaje .= "Se actualizó la BD pero no se pudo anular desde KIU" . "\n";
            $mensaje .= $errores;
        elseif (!$upd_bd && $errores != ''):
            $mensaje .= "No se pudo realizar la acción." . "\n";
            $mensaje .= $errores;
        endif;

        echo $mensaje;
    }

    function GenerarBoletos() {

        $id_reserva = $_POST['id_reserva'];
        $cc_code = $_POST['cc_code'];
        $id_proceso = $_POST['id'];
        $array_reserva = $this->ReporteTransacciones_Model->obtener_datos_reserva($id_reserva);
        $reserva = $array_reserva[0];
        $ruc = ($reserva['ruc'] === 'NULL') ? '' : $reserva['ruc'];
        switch ($cc_code) {
            case 'TC':
                $res_visa = $this->ReporteTransacciones_Model->ObtenerDataVisa($id_proceso);
                if ($res_visa === NULL) {
                    echo "No se encontro ningun registro para el código de reserva: " + $reserva['pnr'];
                    die;
                } else {
                    $cc_code = GetCcCode($res_visa->brand);
                    $trama_kiu = ArmarTramaTipoCredito_DemandTicket($cc_code, 5, $id_reserva, $reserva['pnr'], $ruc, substr($res_visa->purchase_number, 0, 3), $res_visa->card);
                    $cc_code = ($cc_code === 'CA') ? 'MC' : $cc_code;
                    $this->ReporteTransacciones_Model->Actualiza_cc_code_Reserva($id_reserva, $cc_code);
                }
                break;
            case 'VI':
                $res_visa = $this->ReporteTransacciones_Model->ObtenerDataVisa($id_proceso);
                $trama_kiu = ArmarTramaTipoCredito_DemandTicket($reserva['cc_code'], 5, $id_reserva, $reserva['pnr'], $ruc, substr($res_visa->purchase_number, 0, 3), $res_visa->card);
                $this->ReporteTransacciones_Model->Actualiza_cc_code_Reserva($id_reserva, $cc_code);

                break;
            case 'MC':
                $res_visa = $this->ReporteTransacciones_Model->ObtenerDataVisa($id_proceso);
                $trama_kiu = ArmarTramaTipoCredito_DemandTicket('CA', 5, $id_reserva, $reserva['pnr'], $ruc, substr($res_visa->purchase_number, 0, 3), $res_visa->card);
                $this->ReporteTransacciones_Model->Actualiza_cc_code_Reserva($id_reserva, $cc_code);
                break;
            case 'DC':
                $res_visa = $this->ReporteTransacciones_Model->ObtenerDataVisa($id_proceso);
                $trama_kiu = ArmarTramaTipoCredito_DemandTicket($reserva['cc_code'], 5, $id_reserva, $reserva['pnr'], $ruc, substr($res_visa->purchase_number, 0, 3), $res_visa->card);
                $this->ReporteTransacciones_Model->Actualiza_cc_code_Reserva($id_reserva, $cc_code);
                break;
            case 'AX':
                $res_visa = $this->ReporteTransacciones_Model->ObtenerDataVisa($id_proceso);
                $trama_kiu = ArmarTramaTipoCredito_DemandTicket($reserva['cc_code'], 5, $id_reserva, $reserva['pnr'], $ruc, $res_visa->authorization_code, $res_visa->card);
                $this->ReporteTransacciones_Model->Actualiza_cc_code_Reserva($id_reserva, $cc_code);
                break;
            case 'PP':
                $trama_kiu = ArmarTramaTipoMiscelaneo_DemandTicket('PP', 37, $id_reserva, $reserva['pnr'], $ruc);
                break;
            case 'SP':
                $trama_kiu = ArmarTramaTipoMiscelaneo_DemandTicket('SP', 37, $id_reserva, $reserva['pnr'], $ruc);
                break;
            case 'PE':
                $trama_kiu = ArmarTramaTipoMiscelaneo_DemandTicket('PE', 37, $id_reserva, $reserva['pnr'], $ruc);
                break;
        }

        $res_demand = $this->kiu->AirDemandTicketRQ($trama_kiu, $err);
        $res = $res_demand[0];
//                var_dump($res);

        if (isset($res['Error'])) {
            $error_code = $res['Error']['ErrorCode'];

//            var_dump($error_code);
            switch ($res['Error']['ErrorCode']) {
                case 22071: //TICKET YA EMITIDO
                    //Logica para capturar el ticket y actualizar la reserva con el mismo
                    $args = ArmaTrama_TravelItinerary_segforma($reserva['pnr'], "", "");
                    $res_itinerary = $this->kiu->TravelItineraryReadRQ($args, $err);
                    $xml_itinerary = $res_itinerary[3];
                    $res_rdetalle = $this->ReporteTransacciones_Model->GetIdReservaDetalle($id_reserva);
                    $i = 0;
                    foreach ($xml_itinerary->TravelItinerary->ItineraryInfo->Ticketing as $tkt) {
                        $tkt = $tkt->attributes()->eTicketNumber;
                        $res = $this->ReporteTransacciones_Model->UpdTicketsBeforeCreate($res_rdetalle[$i]['id'], $tkt);
                        $i++;
                    }
                    $res_upd_genboletos = $this->ReporteTransacciones_Model->update_reserva($id_reserva, 1);
                    echo 3;
                    echo "|Se recuperaron boleto(s) para el codigo de reserva " . $reserva['pnr'];
                    break;
                default: //TICKET YA EMITIDO
                    echo  $res['Error']['ErrorCode'] . " - " . $res['Error']['ErrorMsg'];
                    break;
            }
            die;
        }

        $array_tickets_number = $res['TicketItemInfo'];

        $args = array(
            'IdReserva' => $reserva['pnr'],
            'Email' => '',
            'IdTicket' => ''
        );
        $res_itinerary = $this->kiu->TravelItineraryReadRQ($args, $err);

        $res2 = $res_itinerary[0];
        if (isset($res2['Error'])) {
//            if ($res2['Error']['ErrorCode'] != 0) :
            $codigo_error = $res2['Error']['ErrorCode'];
            echo $res2['Error']['ErrorCode'] . " - " . $res2['Error']['ErrorMsg'];
            die;
//            endif;
        }

//        var_dump($res_itinerary);die;
        $pasajeros = $res2["TravelItinerary"]["CustomerInfos"]["CustomerInfo"];
        $ticketing = $res2["TravelItinerary"]["ItineraryInfo"]["Ticketing"];
        $itinerario = $res2["TravelItinerary"]["ItineraryInfo"]["ReservationItems"]["Item"];
        $lista_pasajeros = $this->ReporteTransacciones_Model->obtener_pasajeros_reserva($id_reserva);

        $cant_pasajeros = count($ticketing);


        if ($cant_pasajeros == 1) {
            $estatus_reserva = $ticketing['@attributes']["TicketingStatus"];
            $pasajero = $lista_pasajeros[0];
            if ($estatus_reserva == "3") {
                $ticket = $ticketing['@attributes']['eTicketNumber'];
                $id_detalle_reserva = $pasajero['id'];
//                var_dump($id_detalle_reserva);die;
//                /* ACTUALIZA TABLA RESERVA_DETALLE */
                $a_detalle = array(
                    'num_ticket' => $ticket
                );
                $this->ReporteTransacciones_Model->update_reserva_detalle($id_detalle_reserva, $a_detalle);

                /* ACTUALIZA TABLA RESERVA */
//                $a_reserva = array(
//                    'num_ticket1' => $ticket
//                );
            }
        } elseif (count($ticketing) > 1) {
            $fila = 0;
            $tickets = array();
            foreach ($lista_pasajeros as $pasajero) {
                $ticket = $ticketing[$fila]['@attributes']['eTicketNumber'];
                $tickets[$fila] = $ticket;
                $id_detalle_reserva = $pasajero['id'];

                /* ACTUALIZA TABLA RESERVA_DETALLE */
                $a_detalle = array(
                    'num_ticket' => $ticket
                );
                $this->ReporteTransacciones_Model->update_reserva_detalle($id_detalle_reserva, $a_detalle);
                $fila++;
//                $j = $fila + 1;
//                $a_reserva['num_ticket' . $j] = $ticket;
            }
        }
        $res_upd_genboletos = $this->ReporteTransacciones_Model->update_reserva($id_reserva, 1);
        if ($res_upd_genboletos == 1) {
            echo 1;
            echo '|Se generaron los boletos para el codigo de reserva ' . $reserva['pnr'];
            die;
        }
    }

    function DetalleMetodoPago() {
        $data = explode('|', $_POST["data"]);
        $cc_code = $data[1];
        $id = $data[0];
        $response=[];
        $response['paypal']=$this->ReporteTransacciones_Model->ObtenerDetalleMetodoPago($id, 'paypal')->result_array();
        $response['safetypay']=$this->ReporteTransacciones_Model->ObtenerDetalleMetodoPago($id, 'safetypay')->result_array();
        $response['pagoefectivo']=$this->ReporteTransacciones_Model->ObtenerDetalleMetodoPago($id, 'pagoefectivo')->result_array();
        $response['visa']=$this->ReporteTransacciones_Model->ObtenerDetalleMetodoPago($id, 'visa')->result_array();
        echo json_encode($response);
    }
}
