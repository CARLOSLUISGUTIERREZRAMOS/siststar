<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SC_Files extends CI_Controller {

    private $modelo;
    private $id_file;

    public function __construct() {
        parent::__construct();
           $this->template->add_js('js/app/genericas.js');
    }

    public function registraArchivo($userId, $name_file, $tipo, $num_coupons = null, $totalAmount = null,$area=null) {
        
        $this->load->model("$this->modelo");
        $data = array(
            'nombre_file' => $name_file,
            'usuario_upload' => $userId,
            'tipo' => $tipo,
            'area' => $area
        );

        $res = $this->tbl_file_model->insert($data);
        $this->id_file = $res['lastId'];
        if ( $tipo == 'XML' ) {
            $data_iata_detalle_fileprocess = array(
                'tbl_file_id_file' => $this->id_file,
                'num_coupons' => $num_coupons,
                'totalamount' => $totalAmount
            );
            $this->tbl_file_model->insert_iata_detalle_fileprocess($data_iata_detalle_fileprocess);
        }

        return $data;
    }

    public function descarga($nombre_archivo = null, $nombre_carpeta = null) {
        
        $nombreCarpetaSplit =explode('/',$nombre_carpeta );
        switch ($nombreCarpetaSplit[0]){
            case 'excel':
                define('RUTA_CARPETA', FCPATH . $nombreCarpetaSplit[0]."\\".$nombreCarpetaSplit[1]);
                break;
                default :define('RUTA_CARPETA', FCPATH . $nombreCarpetaSplit[0]);
                
        }
        //nombre_archivo debe ser de la forma = ejm: CT-PXMLF-1562018010420180306111346.zip
        

        $ruta = RUTA_CARPETA . "\\" . $nombre_archivo;
//        return $ruta;
        if (is_file($ruta)) {
            header('Content-Type: application/' . $nombre_carpeta);
            header('Content-Disposition: attachment; filename=' . $nombre_archivo);
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($ruta));
            readfile($ruta);
        }
    }

    //<editor-fold defaultstate="collapsed" desc="METODOS GETTER Y SETTER">
    
    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function getModelo() {
        return $this->modelo;
    }
    
    function getId_file() {
        return $this->id_file;
    }

    
    //</editor-fold>
}
