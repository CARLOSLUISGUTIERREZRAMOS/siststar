<?php

/*
 * @author cgutierrez
 */

class Personal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('adm/personal_model');
        $this->load->model('adm/cargo_model');
    }

    function index() {

        $this->template->set('titulo', 'PERSONAL');
        $this->template->load(127, 'interno/personal/v_procesar');
    }

    function ProcesarExcelPersonal() {
        $this->load->helper('fechasHoras_helper');
        $this->load->helper('caracteres_espec_helper');
        $xss_post = $this->input->post(NULL, TRUE);


        $this->load->library('PHPExcel/Classes/PHPExcel.php'); // Libreria con la que manipularemos el excel
//        $ArchivoProcesar = FCPATH . "excel\PERSONAL\\" . $xss_post['name_archivo'] . '.xlsx';
        $ArchivoProcesar = FCPATH . "excel\PERSONAL\\empleados2019.xlsx";    
        $inputFileType = PHPExcel_IOFactory::identify($ArchivoProcesar);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($ArchivoProcesar);
        $sheet = $objPHPExcel->getSheet(0);
        $getHighestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
//        $CantRegEncontrados = $getHighestRow - ($xss_post['celda_firstregister'] - 1);
//        echo $getHighestRow;die;
        $data = array();
//        $i = 1;
        for ($ini = 6; $ini <= $getHighestRow; $ini++) {
            if ($sheet->getCell("A" . $ini)->getValue() == '') { //Detiene todo el proceso del for en el momento que encuentra una celda vacia
//                $last = $ini - 1;
//                $this->cantFilasExcel = $sheet->getCell("A" . $last)->getValue();
                break;
            }
            $codigo = $sheet->getCell("A" . $ini)->getValue();
            $res = $this->ProcesarNombresApellidos($sheet->getCell("B" . $ini)->getValue());
            $apellidos = $res['Apellidos'];
            $nombres = $res['Nombres'];
            $fec_nac = formateaFecha($sheet->getCell("D" . $ini), 'IATA');
            $correo = strtolower($this->armaCorreoElectronico($apellidos, $nombres));
            $cargo = $sheet->getCell("F" . $ini)->getValue();
//            $this->personal_model->GetCargo($cargo);
            
            echo "INSERT INTO personal(codigo,apellidos,nombres,fec_nac,correo,nombre_de_cargo) VALUES ('".$codigo."','".$apellidos."','".$nombres."','".$fec_nac."','".$correo."','".$cargo."');"."<br>";
            
//            $resVal = $this->RegistrarDataPersonal($codigo, $cargo, $apellidos, $nombres, $fec_nac, $correo);
//            $resVal = $this->RegistrarDataPersonal($codigo,$cargo);
//            var_dump($resVal);
//            echo "<br>";

//            $i++;
        }
//
//        echo "<pre>";
//        print_r(json_decode(json_encode($data)));
//        echo "</pre>";
    }

    private function RegistrarDataPersonal($codigo,$cargo) {
        $ExistenciaPersonal =  $this->personal_model->ValidarExistenciaPersonal($codigo);
        if($ExistenciaPersonal){
             if(is_null($this->personal_model->GetCargo($codigo))){
                 return $this->cargo_model->RetornaId($cargo);
             }
             
        }else{
            return 'actu';
            
        }
        
    }
    
    

    private function armaCorreoElectronico($apellidos, $nombres) {
        $split_apellido = explode(" ", $apellidos);
        $split_nombres = explode(" ", $nombres);
//            return $split_apellido[0];
        $ape = $split_apellido[0];
        $name = $split_nombres[0];
        $cadenaEmail = $name . "." . $ape . "@starperu.com";
        $stringParserEmail = (string) $cadenaEmail;
        return sanear_string($stringParserEmail);
    }

    function ProcesarNombresApellidos($NombresApellidos) {

        $splitData = explode(',', $NombresApellidos);
        $data['Apellidos'] = trim($splitData[0]);
        $data['Nombres'] = trim($splitData[1]);
        return $data;
    }

}
