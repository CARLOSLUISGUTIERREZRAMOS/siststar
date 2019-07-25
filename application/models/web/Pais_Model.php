<?php

class Pais_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db_web_test = $this->load->database('db_web_test', TRUE);
    }

    function InsertarRegistros($data) {
        $res_insert = $this->db_web_test->insert('pais', $data);
        return $res_insert;
    }
      function InsertarRegistrosTblPivote($data) {
        $res_insert = $this->db_web_test->insert('pais_has_clase', $data);
        return $res_insert;
//        return $this->db_web_test->last_query();
    }

}
