<?php

if (!defined('BASEPATH'))
    exit('No esta permitido el acceso');

class StoreProcedures_v17 {

    private $HOST_NAME;
    private $BD_NAME;
    private $USER;
    private $PASS;

    public function __construct() {
        $this->HOST_NAME = "localhost";
        $this->BD_NAME = "db_staradm";
        $this->USER = "udb_sp_v17";
        $this->PASS = "p3ruST4R2O17";
    }

    public function call_storeProcedure($callSP) {
        $mysqli = new mysqli($this->HOST_NAME, $this->USER, $this->PASS, $this->BD_NAME);

        if (!$mysqli->multi_query("$callSP")) {
            $inf = array();
            $inf['msg'] = "Error en la llamada al Procedimiento Almacenado: (" . $mysqli->errno . ") " . $mysqli->error;
            $inf['ERROR'] = "1001";
            return $inf;
        }
        
        do {
            if ($res = $mysqli->store_result()) {
//          return  var_dump($res->fetch_all());
                return $res->fetch_all();
                printf("\n");
                $res->free();
            } else {
                if ($mysqli->errno) {
                    echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }
            }
        } while ($mysqli->more_results() && $mysqli->next_result());
    }

}
