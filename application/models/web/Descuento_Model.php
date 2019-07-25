<?php
use SebastianBergmann\ObjectEnumerator\Exception;

class Descuento_Model extends CI_Model{
    
    private $db_web;

    public function __construct() {
        parent::__construct();
//        $this->db_web_test = $this->load->database('db_web_test', TRUE);
        $this->db_web = $this->load->database('db_web_prod', TRUE);
    }
    
    function GetDescuentos(){
        return $this->db_web->get_where('descuento', array('estado' => 'Y'));
    }

    function GuardarDescuentoWeb($data){
            $this->db_web->insert('descuento', $data);
            
    }
    function DeleteDescuento($id){
        return $this->db_web->update('descuento', array('estado'=>'N'), "id = $id");
    }
}
