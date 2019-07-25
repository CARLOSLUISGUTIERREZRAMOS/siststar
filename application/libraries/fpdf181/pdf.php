<?php

require('fpdf.php');

class PDF extends FPDF {

    private $titulo;
    private $tituloAncho;
    private $movDerecha;
    private $formatoDoc;
    private $camposColumnasTbl;
    private $dataHeaderTbl;

    function __construct(Array $data) {
        /*
         * @Param $data['formatDoc'] esta variable ayuda a identificar si es que
         * deseamos aplicar un formato en particular en el PDF
         */
        $this->dataHeaderTbl = $data['dataHeaderTbl'];
        $this->formatoDoc = $data['formatDoc'];
//         var_dump($this->formatoDoc);
        parent::__construct($data['orientation']);
    }

// Cabecera de página
    function Header() {
        // Logo
        $this->Image(base_url() . '/img/LogoStar.png', 14, 8, 43);
        // Arial bold 15
        $this->SetFont('Courier', 'U', 15);
        // Movernos a la derecha
        $this->Cell($this->movDerecha);
//        $this->headerMoverDerechaDespuesDeLogo($numPix);
        // Título
        $this->Cell($this->tituloAncho, 10, $this->titulo, 0, 1, 'C');  //@Param4 = Borde 
        // Salto de línea
//        $this->Ln(15);

        switch ($this->formatoDoc) {
            case 'MANIFIESTOPRE':
                $this->formatManifiestosSalidaPre();
                break;
            default : 'NO APLICO FORMATO';
        }
        $this->formatManifiestosSalidaPre();

        $data = $this->armaCabeceraTbl($this->dataHeaderTbl);
//       echo "<pre>";
//       print_r($data);
//       echo "</pre>";die;
//        die;
                

        $this->setTitleColumns($data, 'Arial', 'B', 9);
        $this->Ln();
    }

    function debajoDelTituloPrincipal($texto, $x, $y) {

        $this->SetY($y);
        $this->SetX($x);
        // Arial 12
        $this->SetFont('Courier', 'b', 12);
        // Color de fondo
//        $this->SetFillColor(200, 220, 255);
        // Título
        $this->Cell(0, 6, $texto, 0, 1, 'P', false);
        // Salto de línea
        $this->Ln(4);
    }

    function formatManifiestosSalidaPre() {

        $textoDebajoDelTituloPrincipal = 'RUTA:  ' . $_SESSION['usuario']['Rut_origen'] . ' - ' . $_SESSION['usuario']['Rut_destin'];
        $this->debajoDelTituloPrincipal($textoDebajoDelTituloPrincipal, 120, 22); //@Params1 = Texto @Params2 = Eje X  @Params3 = Eje Y

        $date = new DateTime();
        $dateFormatHuman = $date->format('d/m/Y');
        $dateDateTimeHuman = $date->format('d/m/Y H:m:s');
        $this->setCaja('Fecha', $dateFormatHuman, 13, 30);
        $this->setCaja('Fecha / Hora', $dateDateTimeHuman, 190, 30);
        $this->setCaja('Manifestador', ' ', 13, 35);
        $this->setCaja('Vuelo', ' ', 100, 35);
        $this->setCaja(utf8_decode('Situación'), ' ', 190, 35);
    }

    function setCaja($nombreEtiqueta, $dataEtiqueta, $ejeX, $ejeY) {
        $this->SetY($ejeY);
        $this->SetX($ejeX);
        // Arial 12
        $this->SetFont('Courier', 'B', 11);

        // Título
        $this->Cell(0, 6, $nombreEtiqueta . ' : ' . $dataEtiqueta, 0, 1, 'P', false);
        // Salto de línea
        $this->Ln(4);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pag ' . $this->PageNo() . ' de {nb} ', 0, 0, 'C');
    }

    function setTitleColumns($data, $tipoLetra, $estilo, $tamanio) {
        $this->SetX(1);
        $this->SetFont($tipoLetra, $estilo, $tamanio);
//        
        for ($i = 0; $i < count($data); $i++) {
            $this->Cell($data['col' . $i]['ancho'], 5, $data['col' . $i]['name'], 1, 0, 'C'); //@Param 2 = ALTO
        }
//         $this->Ln(2);
    }

    function armaCabeceraTbl($dataHeader) {
        $k = 0;
        $j = 1;
        for ($i = 0; $i < count($dataHeader) / 2; $i++) {
            $data['col' . $i]['name'] = $dataHeader[$k];
            $data['col' . $i]['ancho'] = $dataHeader[$j];
            $k = $k + 2;
            $j = $j + 2;
        }
        return $data;
    }

    function generateBodyTbl($txtAlign, $tipoLetra, $estilo, $tamanio, $data, $data_tbl, $ejeX, $altoCelda, $numFinColumn) {

        $this->SetFont($tipoLetra, $estilo, $tamanio);

        for ($j = 1; $j <= count($data_tbl); $j++) {
//            echo $j."<br>";
            $this->SetX($ejeX);
            for ($k = 0; $k <= $numFinColumn; $k++) {
                $anchoCol = $data['col' . $k]['ancho'];
                $dataInfo = utf8_decode($data_tbl[$j][$k]);
                $this->Cell($anchoCol, $altoCelda, $dataInfo, 0, 0, $txtAlign); //@Param
//                $this->Cell($anchoCol, 5, 'CL', 1, 0, 'C');
            }
            $this->Ln();
        }
    }
    function tblBody(){ //TEST OTRA MANERA
           foreach($data_tbl as $row){
                 foreach($row as $f){
                     $pdf->Cell(4, 5, $f, 0, 0, ''); //@Param
                 }
                 $pdf->Ln();
             }
    }

    //<editor-fold defaultstate="collapsed" desc="GETT && SETT">
    function setMovDerecha($movDerecha) {
        $this->movDerecha = $movDerecha;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function getTituloAncho() {
        return $this->tituloAncho;
    }

    function setTituloAncho($tituloAncho) {
        $this->tituloAncho = $tituloAncho;
    }

    function setFormatoDoc($formatoDoc) {
        $this->formatoDoc = $formatoDoc;
    }

    function setCamposColumnasTbl($camposColumnasTbl) {
        $this->camposColumnasTbl = $camposColumnasTbl;
    }

    function setDataHeaderTbl($dataHeaderTbl) {
        $this->dataHeaderTbl = $dataHeaderTbl;
    }

    function getDataHeaderTbl() {
        return $this->dataHeaderTbl;
    }
    
    function Polygon($points, $style='D')
{
    //Draw a polygon
    if($style=='F')
        $op = 'f';
    elseif($style=='FD' || $style=='DF')
        $op = 'b';
    else
        $op = 's';

    $h = $this->h;
    $k = $this->k;

    $points_string = '';
    for($i=0; $i<count($points); $i+=2){
        $points_string .= sprintf('%.2F %.2F', $points[$i]*$k, ($h-$points[$i+1])*$k);
        if($i==0)
            $points_string .= ' m ';
        else
            $points_string .= ' l ';
    }
    $this->_out($points_string . $op);
}

    //</editor-fold>
}


