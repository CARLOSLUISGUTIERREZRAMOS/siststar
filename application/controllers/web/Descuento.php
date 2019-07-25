<?php

class Descuento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isset($this->session->username) ? TRUE :  header('Location: '.base_url());
        $this->template->add_js('js/select2/select2.full.min.js');
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('js/bootstrap-daterangepicker/daterangepicker.js');
        $this->load->model('web/Descuento_Model');
        $this->template->add_js('js/web/descuento.js');
        $this->template->add_css('css/modalCarga.css');
    }
    public function Index(){
        
        $this->template->add_css('css/bootstrap-daterangepicker/daterangepicker.css');
        $this->template->add_css('css/select2/select2.min.css');
        $this->template->set('titulo', 'Modulo Descuento');
        $data['v_agregar'] = $this->load->view('web/descuento/v_descuento',FALSE,TRUE); 
        $data_lista['res_all_desc'] = $this->Descuento_Model->GetDescuentos();
        $data['v_lista'] = $this->load->view('web/descuento/v_lista',$data_lista,TRUE); 
        $this->template->load(138,'web/descuento/v_main',$data);
    }

    function Listar(){
        $this->template->set('titulo', 'Listado - Códigos de descuento');
        $data['res_all_desc'] = $this->Descuento_Model->GetDescuentos();
        $this->template->load(138,'web/descuento/v_lista',$data);
        
    }

    function Registrar(){
        $json_post = json_decode(json_encode($_POST));
        $data = [];
        $data['codigo'] = $json_post->codigo_descuento;
        $data['monto'] = $json_post->porcentaje_descuento;
        $array_fecha_ini_fin = explode(' - ',$json_post->rango_fecha);
        $data['fecha_inicio'] = (new DateTime(str_replace('/','-',$array_fecha_ini_fin[0])))->format('Y-m-d');
        $data['fecha_fin'] = (new DateTime(str_replace('/','-',$array_fecha_ini_fin[1])))->format('Y-m-d');

        /* echo "<pre>";
        var_dump($json_post);
        echo "</pre>"; */
        $data['ruta'] = implode(',',$json_post->ruta);
        $data['clase'] = implode(',',$json_post->clase);
        $data['metodos_pago'] = implode(',',$json_post->cc_code);
        $data['fecha_registro'] = date('Y-m-d H:i:s');
        $data['usuario_registro'] = strtoupper($this->session->username);
        
        $this->Descuento_Model->GuardarDescuentoWeb($data);
         header('Location: '.base_url().'web/Descuento');

    }

    function EliminarDescuento(){

        $id = $_POST['id_del'];
        $res = $this->Descuento_Model->DeleteDescuento($id);
        echo $res;
    }

}