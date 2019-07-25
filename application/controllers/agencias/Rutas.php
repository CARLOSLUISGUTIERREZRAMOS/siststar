<?php
class Rutas extends CI_Controller {
	public function __construct() {
        parent::__construct();
        isset($this->session->username) ? TRUE : header('Location: '.base_url());
        $this->load->helper('logsystemweb');
        $this->load->helper('funciones_generales');
        $this->load->helper('fechasHoras');
        $this->load->library('form_validation');
        $this->load->library('kiu/Agencias/Connection_kiu');
        $this->load->library('kiu/Agencias/Model_kiu');
        $this->load->library('kiu/Agencias/Controller_kiu');

        $this->load->model('agencias/Ruta_Model');
        $this->load->model('agencias/Clase_Model');
        $this->load->model('agencias/FarebaseRuta_Model');
        $this->load->model('agencias/Farebase_Model');

        $this->template->add_css('css/toastr/toastr.css');
        $this->template->add_js('js/toastr/toastr.js');
    }

    public function index(){
        $this->template->set("titulo", "LISTADO DE RUTAS DE AGENCIAS");
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker3.css');
        $this->template->add_css('css/agencia/rutas.css',1);
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
        $this->template->add_js('js/agencias/rutas.js',1);
        $data['rutas']=$this->Ruta_Model->obtener_rutas();
        $this->template->load(162,'agencias/rutas/v_ruta',$data);
    }

    public function MostrarDetalleTarifas(){
        $CodigoRuta=$_REQUEST['id'];
        $data['tarifas'] = $this->FarebaseRuta_Model->obtener_detalle_tarifas($CodigoRuta);
        $data['CodigoRuta']=$CodigoRuta;
        $view=$this->load->view('agencias/rutas/v_ruta_tarifas_contenido',$data,TRUE);
        echo $view;
    }

    public function EditarTarifas() {
        $post=$this->input->post(NULL, TRUE)['formData'];
        $data=json_decode(json_encode($post),true);
        $j=0;
        $t=count($data);
        foreach ($data as $element) {
            $emision0 = fecha_iso_8601($element['emision0']);
            $emision1 = fecha_iso_8601($element['emision1']);
            $vigencia0 = fecha_iso_8601($element['vigencia0']);
            $vigencia1 = fecha_iso_8601($element['vigencia1']);

            $a_data = array(
                    'Tarifa' => $element['tarifa'],
                    'EmisionInicio' => $emision0,
                    'EmisionFinal' => $emision1,
                    'Inicio' => $vigencia0,
                    'Final' => $vigencia1,
                    'EstadiaMin' => $element['estmin'],
                    'EstadiaMax' => $element['estmax'],
                    'estado_web' => $element['web']
            );
            $res=$this->FarebaseRuta_Model->update_farebase_ruta($a_data,$element['idruta'],$element['farebase']);
            // $log_data = array(
            //     'Codigo_Usuario' => $array_usuario['Codigo_Usuario'],
            //     'Descripcion'    => "Se editaron las tarifas del FareBase $farebase para la ruta $idruta."
            // );
            // $this->log_model->guardar_log($log_data);
            $j++;
        }
        if ($j==$t) {
            echo "Tarifas actualizadas correctamente.";
            // $data['rutas']=$this->Ruta_Model->obtener_rutas();
            // $view=$this->load->view('agencias/rutas/v_ruta_contenido',$data);
            // echo $view;
        }
        else{
            header($_SERVER['SERVER_PROTOCOL'] . ' 402 Datos no procesados correctamente en el server Error');
            echo "Problemas al actualizar las tarifas.";
        }
    }

    /*
    * ProcesarDatos, proceso obtiene los farebases  desde KIU
    */
    public function ProcesarDatos(){
        $id=$_REQUEST['id'];
        $origen=$_REQUEST['origen'];
        $destino=$_REQUEST['destino'];
        
        $fecha = date('Y-m-d');
        $array = array(
                    "today" => $fecha,
                    "cod_origen" => $origen, 
                    "cod_destino" => $destino
                );
        $kiu_res=$this->controller_kiu->AirFareDisplayRQ($array,$err);
        $respuesta=  $kiu_res[3];
        // dd($respuesta);
        /*obtener objetos de de fare_bases*/
        $air_display = $respuesta->FareDisplayInfos->FareDisplayInfo;
        $array_ruta=$this->RecuperarFarebaseTemporal($id);
        $this->FarebaseRuta_Model->delete_farebase_ruta($id);
        
        /*NUEVO FAREBASES*/
        foreach ($air_display as $key => $nodo) {
            $this->NuevaFuncionFarebase($nodo,$origen,$destino,$id,$array_ruta);
        }
        echo 'ok';
    }

    /*
    * RecuperarFarebaseTemporal, recupera data para procesar estadías
    */
    public function RecuperarFarebaseTemporal($id){
        $temporal = $this->FarebaseRuta_Model->obtener_temporal_farebases($id);
        $array_ruta=array();
        foreach($temporal as $row){
            $array_ruta[$row->CodigoFareBase]=[
                                                (int)$row->Enero,
                                                (int)$row->Febrero,
                                                (int)$row->Marzo,
                                                (int)$row->Abril,
                                                (int)$row->Mayo,
                                                (int)$row->Junio,
                                                (int)$row->Julio,
                                                (int)$row->Agosto,
                                                (int)$row->Setiembre,
                                                (int)$row->Octubre,
                                                (int)$row->Noviembre,
                                                (int)$row->Diciembre,
                                                (int)$row->EstadiaMin,
                                                (int)$row->EstadiaMax
                                            ];
        }
        return $array_ruta;
    }

    /*
    * NuevaFuncionFarebase, registra los farebases obtenidos desde KIU
    */
    public function NuevaFuncionFarebase($nodo,$origen,$destino,$idruta,$array_ruta) {
        $fare = (string)$nodo->FareReference;
        $clase = $nodo->attributes()->ResBookDesignator;
        $DepartureDate = $nodo->TravelDates->attributes()->DepartureDate;
        $ArrivalDate = OperarDiasMesAnios($DepartureDate, '+5 year');
        
        $valorClase = $this->Clase_Model->cantidad_clase($clase);
        if ($valorClase>0){
            $TipoViaje_Kiu = $nodo->attributes()->FareApplicationType;
            $TipoViaje = $this->GetTipoViaje($TipoViaje_Kiu);
            
            $tarifa = $nodo->PricingInfo->BaseFare[0]->attributes()->Amount; // suma el impuesto de combuistible
            $impuesto = $nodo->Taxes->Tax[0]->attributes()->Amount;
            if (!$impuesto){
                $impuesto=0.0;
            }

            $tarifa = ($TipoViaje == 'R') ? $tarifa / 2 : $tarifa;

            /*VERIFICA SI EL FARE ESTA REGISTRADO*/
            $valor_codigoFareBase = $this->Farebase_Model->contar_farebases($fare);

            if($valor_codigoFareBase==0){
                $array_insert = array(
                    "CodigoFareBase" => $fare,
                    "NombreFareBase" => $fare,
                    "CodigoClase" => $clase,
                    "TipoViaje" => $TipoViaje
                );
                $this->Farebase_Model->guardar_farebase($array_insert);
            }
            
            /*VERIFICA SI EXISTE DUPLICADO EL FAREBASE EN LA RUTA*/
            $valor_FARE_RUTA = $this->FarebaseRuta_Model->contar_farebases_ruta($fare,$idruta);
            if ($valor_FARE_RUTA==0){
                if (count($array_ruta)>0 && isset($array_ruta[$fare])) {
                    $enero      = $array_ruta[$fare][0];
                    $febrero    = $array_ruta[$fare][1];
                    $marzo      = $array_ruta[$fare][2];
                    $abril      = $array_ruta[$fare][3];
                    $mayo       = $array_ruta[$fare][4];
                    $junio      = $array_ruta[$fare][5];
                    $julio      = $array_ruta[$fare][6];
                    $agosto     = $array_ruta[$fare][7];
                    $setiembre  = $array_ruta[$fare][8];
                    $octubre    = $array_ruta[$fare][9];
                    $noviembre  = $array_ruta[$fare][10];
                    $diciembre  = $array_ruta[$fare][11];
                    $estadia_min= $array_ruta[$fare][12];
                    $estadia_max= $array_ruta[$fare][13] ;
                }
                else{
                    $enero      = 1;
                    $febrero    = 1;
                    $marzo      = 1;
                    $abril      = 1;
                    $mayo       = 1;
                    $junio      = 1;
                    $julio      = 1;
                    $agosto     = 1;
                    $setiembre  = 1;
                    $octubre    = 1;
                    $noviembre  = 1;
                    $diciembre  = 1;
                    $estadia_min= 0;
                    $estadia_max= 30;
                }
                
                $array_insert2 = array(
                    "CodigoRuta" => $idruta
                   ,"CodigoFareBase" => $fare
                   ,"Lunes" => '1'
                   ,"Martes" => '1'
                   ,"Miercoles" => '1'
                   ,"Jueves" => '1'
                   ,"Viernes" => '1'
                   ,"Sabado" => '1'
                   ,"Domingo" => '1'
                   ,"HoraCalculo" => date('Y-m-d H:i:s')
                   ,"Inicio" => $DepartureDate
                   ,"Final" => $ArrivalDate
                   ,"EmisionInicio" => $DepartureDate
                   ,"EmisionFinal" => $ArrivalDate
                   ,"Enero" => $enero
                   ,"Febrero" => $febrero
                   ,"Marzo" => $marzo
                   ,"Abril" => $abril
                   ,"Mayo" => $mayo
                   ,"Junio" => $junio
                   ,"Julio" => $julio
                   ,"Agosto" => $agosto
                   ,"Setiembre" => $setiembre
                   ,"Octubre" => $octubre
                   ,"Noviembre" => $noviembre
                   ,"Diciembre" => $diciembre
                   ,"EstadiaMin" => $estadia_min
                   ,"EstadiaMax" => $estadia_max
                   ,"Tarifa" => $tarifa
                   ,"Tarifa2" => $impuesto
                   ,"estado_web" => '1'
                );
                $this->FarebaseRuta_Model->guardar_farebase_ruta($array_insert2);
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
    
    public function MostrarDetalleTemporadas(){
        $id=$_REQUEST['id'];
        $data['temporadas'] = $this->FarebaseRuta_Model->obtener_detalle_temporadas($id);
        $data['id']=$id;
        $view=$this->load->view('agencias/rutas/v_ruta_temporadas_contenido',$data,TRUE);
        echo $view;
    }
}
