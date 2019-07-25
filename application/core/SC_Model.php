<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class SC_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
//        $this->load->library('ConexionDB/connection_sqlserver');
//        $this->connection_sqlserver->conectasqlserver('comercial');
    }

    public function validaExiste($name_file) {

        $cantReg = mysql_num_rows(mysql_query("SELECT nombre_file FROM tbl_file WHERE nombre_file='$name_file'"));
        $resBool = ($cantReg == 0) ? true : false;
        return $resBool;
        
    }

    public function obtenUltimoRegistro($celdaEvalua,$tbl) {
        
        $query =   "WITH Tbl_Simulada AS   
		    ( 
                        SELECT $celdaEvalua, ROW_NUMBER() 
                        OVER(ORDER BY $celdaEvalua DESC) 
                        AS Row 
                        FROM $tbl
                    ) 
                    
                    SELECT $celdaEvalua,Row 
                    FROM Tbl_Simulada 
                    WHERE Row=1";
        
         $resultado[] = $this->connection_sqlserver->getConexion()->Execute($query);
         $resultado[] = $this->connection_sqlserver->getConexion()->ErrorMsg();
         $resultado[] = $query;
         
//         if(!$resultado[0]){
//              $error_object = ADODB_Pear_Error();
//              '<b>' . $error_object->message . '</b>'; 
//                return false;
//         }
         
         while (!$resultado[0]->EOF) {
            return $resultado[0]->fields[0];
        }
         
    }
    
    private function log_errores(){
        
    }

}
