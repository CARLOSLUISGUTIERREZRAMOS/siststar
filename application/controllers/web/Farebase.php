<?php

class Farebase extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!isset($this->session->username)):
            header('Location: '.base_url());
        endif;
        define("id_formulario", 123);
        
        isset($this->session->username) ? TRUE : header('Location: '.base_url());
        $this->load->helper('fechashoras_helper');
        $this->load->model('web/FareBase_Model');
        $this->load->model('web/Clase_Model');
    }

    function test() {
        $id_ruta = $_GET['ruta'];
        $this->ListaRutaFareBase($id_ruta);
    }

    function ListaRutaFareBase($id_ruta) {
        $this->template->set('titulo', 'FareBase');
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('js/web/farebase.js');
        $this->template->add_js('js/bootstrap-daterangepicker/daterangepicker.js');
        $this->template->add_css('css/bootstrap-daterangepicker/daterangepicker.css');
        $res['lista_ruta_farebase'] = $this->FareBase_Model->GetRutasFareBase($id_ruta);
        $this->template->load(id_formulario, 'web/v_farebase_has_ruta', $res);
    }

    public function ActualizarFarebase() {


        $xss_post = $this->input->post(NULL, TRUE);
        $fec_emision_split = explode('-', $xss_post['fecha_emision_rango_ini_fin']);
        $fec_inivuelo_split = explode('-', $xss_post['fecha_inivuelo_rango_ini_fin']);
        $fecha_emision_ini = fecha_iso_8601(trim($fec_emision_split[0]));
        $fecha_emision_fin = fecha_iso_8601(trim($fec_emision_split[1]));
        $fecha_vuelo_ini = fecha_iso_8601(trim($fec_inivuelo_split[0]));
        $fecha_vuelo_fin = fecha_iso_8601(trim($fec_inivuelo_split[1]));
        $data = array(
            'tarifa_adt' => $xss_post['tarifa'],
            'inicio_vuelo' => $fecha_vuelo_ini,
            'final_vuelo' => $fecha_vuelo_fin,
            'emision_inicio' => $fecha_emision_ini,
            'emision_final' => $fecha_emision_fin,
            'estadia_min_lunes' => $xss_post['estadia_min_lunes'],
            'estadia_min_martes' => $xss_post['estadia_min_martes'],
            'estadia_min_miercoles' => $xss_post['estadia_min_miercoles'],
            'estadia_min_jueves' => $xss_post['estadia_min_jueves'],
            'estadia_min_viernes' => $xss_post['estadia_min_viernes'],
            'estadia_min_sabado' => $xss_post['estadia_min_sabado'],
            'estadia_min_domingo' => $xss_post['estadia_min_domingo'],
            'estadia_maxima' => $xss_post['estadia_maxima'],
            'estado_web' => $xss_post['estado_web'],
        );
        $res_upd = $this->FareBase_Model->UpdateFarebase($xss_post['farebase'], $xss_post['ruta_id'], $data);
        if ($res_upd) {
            $this->session->set_flashdata('Msg', 'Se actualizo el farebase ' . $xss_post['farebase']);
        } else {
            $this->session->set_flashdata('Msg', 'Error al actualizar');
        }
        $this->ListaRutaFareBase($xss_post['ruta_id']);
    }

    function TraerTarifasWebServicesKiu() {
        $this->load->library('kiu/Controller_kiu');
        $kiu = new Controller_kiu();
        $xss_post = $this->input->post(NULL, TRUE);
        $id_ruta = $xss_post['id_ruta'];
        $trama = array(
            'today' => fecha_iso_8601($xss_post['today'])
            , 'cod_origen' => $xss_post['cod_origen']
            , 'cod_destino' => $xss_post['cod_destino']
        );
        // dd(OperarDiasMesAnios('2019-07-23', '+5 year'));
        $res_AirFareDisplayRQ = $kiu->AirFareDisplayRQ($trama, $err);
        $xml = $res_AirFareDisplayRQ[3];
//            echo "<pre>";
//            var_dump($res_AirFareDisplayRQ);
//            echo "</pre>";die;
        (isset($xml->Error)) ? $this->ShowMsgError($xml, 'KIU') : $this->ProcesarTarifasWsKiu($xml, $id_ruta);
//        echo $this->ProcesarTarifasWsKiu($xml, $id_ruta);
    }
    
     function ActualizarTodoFarebase()
    {
        if ($this->input->is_ajax_request()) {
            $post=$this->input->post(NULL, TRUE)['formData'];
            $data=json_decode(json_encode($post),true);
            $j=0;
            foreach ($data as $element) {
                $fec_emision_split = explode('-', $element['fecha_emision_rango_ini_fin']);
                $fec_inivuelo_split = explode('-', $element['fecha_inivuelo_rango_ini_fin']);
                $fecha_emision_ini = fecha_iso_8601(trim($fec_emision_split[0]));
                $fecha_emision_fin = fecha_iso_8601(trim($fec_emision_split[1]));
                $fecha_vuelo_ini = fecha_iso_8601(trim($fec_inivuelo_split[0]));
                $fecha_vuelo_fin = fecha_iso_8601(trim($fec_inivuelo_split[1]));
                $d = array(
                    'tarifa_adt' => $element['tarifa'],
                    'inicio_vuelo' => $fecha_vuelo_ini,
                    'final_vuelo' => $fecha_vuelo_fin,
                    'emision_inicio' => $fecha_emision_ini,
                    'emision_final' => $fecha_emision_fin,
                    'estadia_min_lunes' => $element['estadia_min_lunes'],
                    'estadia_min_martes' => $element['estadia_min_martes'],
                    'estadia_min_miercoles' => $element['estadia_min_miercoles'],
                    'estadia_min_jueves' => $element['estadia_min_jueves'],
                    'estadia_min_viernes' => $element['estadia_min_viernes'],
                    'estadia_min_sabado' => $element['estadia_min_sabado'],
                    'estadia_min_domingo' => $element['estadia_min_domingo'],
                    'estadia_maxima' => $element['estadia_maxima'],
                    'estado_web' => $element['estado_web'],
                );
                $res_upd = $this->FareBase_Model->UpdateFarebase($element['farebase'], $element['ruta_id'], $d);
                $j++;
            }
            if (count($data)==$j) {
                echo 1;
            }
            else{
                echo 0;
            }
        }
        else{
            echo 'error';
        }
    }


    public function ShowMsgError($data, $tipo, $num_error = NULL) {

        switch ($tipo) {
            case 'KIU':
                $ErrorCode = 'Error Kiu # ' . (string) $data->Error->ErrorCode;
                $ErrorMsg = (string) $data->Error->ErrorMsg;
                break;
            case 'INTERNO':
                $ErrorCode = 'Error Interno # ' . $num_error;
                $ErrorMsg = (string) $data;
                break;
        }

        $this->session->set_flashdata('ErrorCode', $ErrorCode);
        $this->session->set_flashdata('ErrorMsg', $ErrorMsg);
        header('Location: '.base_url("web/Ruta"));
    }

    private function ProcesarTarifasWsKiu($xml, $id_ruta) {
        $msg = '';
        $DataEncontrada = $this->FareBase_Model->GetRutasFareBaseAll($id_ruta);
        $this->FareBase_Model->DeleteTblFareBaseRuta($id_ruta);
        $this->FareBase_Model->DeleteTblFareBaseCombinacionesClase($id_ruta);
        foreach ($xml->FareDisplayInfos->FareDisplayInfo as $nodo) {
            $FareReference = $nodo->FareReference;
            $DepartureDate = $nodo->TravelDates->attributes()->DepartureDate;
            $EmisionFinal_FecVueloFinal = OperarDiasMesAnios($DepartureDate, '+5 year');
            $Clase = $nodo->attributes()->ResBookDesignator;
            if ($this->Clase_Model->GetClase($Clase) === TRUE) {

                $TipoViaje_Kiu = $nodo->attributes()->FareApplicationType;
                $TipoViaje = $this->GetTipoViaje($TipoViaje_Kiu);

                $res = $this->ValidarExistenciaFareReference($FareReference);

                $data = (bool) $res->num_rows(); // Indica si existe el farebase en su respectiva tbl
                if (!$data) {
                    /* Si ingresa en esta condicion significa que no esta registrado el farebase y se 
                     * procede al registro
                     */
                    $data_insert = array('id' => $FareReference, 'clase_codigo' => $Clase, 'tipo_viaje' => $TipoViaje);
                    $res = $this->FareBase_Model->RegistraFareBase($data_insert);
                }

                foreach ($nodo->PricingInfo->BaseFare as $price) {
                    $Amount = (double) $price->attributes()->Amount;
                    switch ((string) $price->attributes()->App) {
                        case 'ADT':
                            $tarifa_adt = ($TipoViaje == 'R') ? $Amount / 2 : $Amount;
                            break;
                        case 'CHD':
                            $tarifa_chd = ($TipoViaje == 'R') ? $Amount / 2 : $Amount;
                            break;
                        case 'INF':
                            $tarifa_inf = ($TipoViaje == 'R') ? $Amount / 2 : $Amount;
                            ;
                            break;
                    }
                }
                $DataFareBaseRuta = array('farebase_id' => (string) $FareReference, 'ruta_id' => $id_ruta, 'tarifa_adt' => $tarifa_adt,
                    'tarifa_chd' => $tarifa_chd, 'tarifa_inf' => $tarifa_inf, 'inicio_vuelo' => (string) $DepartureDate,
                    'final_vuelo' => $EmisionFinal_FecVueloFinal, 'departure_date' => (string) $DepartureDate, 'emision_inicio' => $DepartureDate, 'emision_final' => $EmisionFinal_FecVueloFinal,
                    'fecha_descarga' => (new DateTime('NOW'))->format('c'));
                $DataInsertFareBaseRuta = $this->IncluirTaxesWsKiu($nodo->Taxes->Tax, $DataFareBaseRuta);
//                $this->IncluirDataExistenteFarebaseRuta($DataInsertFareBaseRuta, $DataEncontrada, $FareReference);
                $Combinations = $nodo->RulesInfo->Combinations;
                $this->ProcesarCombinaciones($FareReference, $id_ruta, $Combinations);
                $this->FareBase_Model->RegistraFareBaseRuta($DataInsertFareBaseRuta);
            }
        }
        $this->ListaRutaFareBase($id_ruta);
    }

    private function IncluirDataExistenteFarebaseRuta($dataupd, $DataEncontrada, $FareReference) {
        foreach ($DataEncontrada->result() as $row) {
            if ($row->farebase_id == (string) $FareReference) {
                $DataEncontrada = array(
//                            'inicio_vuelo' => $row->inicio_vuelo,
                    'final_vuelo' => $row->final_vuelo,
//                            'emision_inicio' => $row->emision_inicio,
                    'emision_final' => $row->emision_final,
                    'estadia_maxima' => $row->estadia_maxima,
                    'estadia_min_lunes' => $row->estadia_min_lunes,
                    'estadia_min_martes' => $row->estadia_min_martes,
                    'estadia_min_miercoles' => $row->estadia_min_miercoles,
                    'estadia_min_jueves' => $row->estadia_min_jueves,
                    'estadia_min_viernes' => $row->estadia_min_viernes,
                    'estadia_min_sabado' => $row->estadia_min_sabado,
                    'estadia_min_domingo' => $row->estadia_min_domingo,
                    'enero' => $row->enero,
                    'febrero' => $row->febrero,
                    'marzo' => $row->marzo,
                    'abril' => $row->abril,
                    'mayo' => $row->mayo,
                    'junio' => $row->junio,
                    'julio' => $row->julio,
                    'agosto' => $row->agosto,
                    'septiembre' => $row->septiembre,
                    'octubre' => $row->octubre,
                    'noviembre' => $row->noviembre,
                    'diciembre' => $row->diciembre,
                    'rango' => $row->rango,
                    'estado_web' => $row->estado_web,
                );
            }
        }
        array_push($dataupd, $DataEncontrada);
    }

    private function ObtenerDataTblFarebase($ruta_id) {

//        $this->FareBase_Model->GetFarebases($ruta_id);
    }

    private function IncluirTaxesWsKiu($Taxes, $DataFareBaseRuta) {

        foreach ($Taxes as $tax) {

            switch ((string) $tax->attributes()->TaxCode) {
                case 'PE':
                    switch ((string) $tax->attributes()->ApplyOnPax) {
                        case 'ADT':
                            $DataFareBaseRuta['tax_pe_adt'] = $tax->attributes()->Amount;
                            break;
                        case 'CHD':
                            $DataFareBaseRuta['tax_pe_chd'] = $tax->attributes()->Amount;
                            break;
                        case 'INF':
                            $DataFareBaseRuta['tax_pe_inf'] = $tax->attributes()->Amount;
                            break;
                    }
                    break;
                case 'HW':
                    switch ((string) $tax->attributes()->ApplyOnPax) {
                        case 'ADT':
                            $DataFareBaseRuta['tax_hw_adt'] = $tax->attributes()->Amount;
                            break;
                        case 'CHD':
                            $DataFareBaseRuta['tax_hw_chd'] = $tax->attributes()->Amount;
                            break;
                        case 'INF':
                            $DataFareBaseRuta['tax_hw_inf'] = $tax->attributes()->Amount;
                            break;
                    }
                    break;
            }
        }

        return $DataFareBaseRuta;
    }

    private function ProcesarCombinaciones($FareReference, $id_ruta, $Combinations) {

        foreach ($Combinations as $combination) {
            $cant_class_combination = count($combination);
            foreach ($combination as $item) {
                $class_combination = $item->attributes()->Class;
                $data = array('farebase_id' => $FareReference, 'ruta_id' => $id_ruta, 'clase_codigo' => $class_combination);
                if ($cant_class_combination > 0) {
                    $data = $this->FareBase_Model->RegistrarCombinaciones($data);
//                    echo $data . ";";
                }
            }
        }
    }

    private function GetTipoViaje($TipoViaje_Kiu) {
        switch ($TipoViaje_Kiu) {
            case 'OneWay':
                $TipoViaje = 'O';
                break;
            case 'Roundtrip':
                $TipoViaje = 'R';
                break;
            case 'OneWayOnly':
                $TipoViaje = 'O';
                break;
            default : $TipoViaje = 'U'; //Undefined | Indefinido para el sistema web actual
        }

        return $TipoViaje;
    }

    private function ValidarExistenciaFareReference($FareReference) {

        return $this->FareBase_Model->ValidarExisteFareReference_Model($FareReference);
    }

}
