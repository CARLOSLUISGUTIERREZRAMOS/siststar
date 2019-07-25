<?php

class Compartido extends CI_Controller {

    public function __construct() {
        parent::__construct();
        (isset($this->session->username)) ? TRUE : header('Location: ' . base_url());
        $this->id_formulario = 140;
        $this->load->model("trafico/Compartido_Model");
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('js/bootstrap-daterangepicker/daterangepicker.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $this->template->add_css('css/bootstrap-daterangepicker/daterangepicker.css');
        $this->template->add_css('css/select2/select2.min.css');
        $this->template->add_js('js/select2/select2.full.min.js');
        $this->template->add_js('js/trafico/compartido.js');
        $this->template->add_css('css/datatables/dataTables.bootstrap.min.css');
        $this->template->add_js('js/datatables/jquery.dataTables.min.js');
        $this->template->add_js('js/datatables/dataTables.bootstrap.min.js');
    }

    function PorCobrar() {
        $tipo['tipo'] = "cobrar";
        $this->template->set("titulo", "Por Cobrar");
        $this->template->load($this->id_formulario, 'trafico/v_compartido', $tipo);
    }

    function PorPagar() {
        $tipo['tipo'] = "pagar";
        $this->template->set("titulo", "Por Pagar");
        $this->template->load($this->id_formulario, 'trafico/v_compartido', $tipo);
    }

    public function ListarIngresadosCobrar() {
        $data['cod_usuario'] = $this->session->username;
        $this->template->set("titulo", "VUELOS INGRESADOS POR COBRAR");
        $tipo = "cobrar";
        $data["listaIngresados"] = $this->Compartido_Model->ObtenerTodosVuelos($tipo);
//        echo $data["listaIngresados"];die;
        $data['tipo2'] = "cobrar";
        $this->template->load($this->id_formulario, 'trafico/v_ingresado', $data);
        $res = $this->Compartido_Model->ObtenerTodosVuelos($tipo);
    }

    public function ListarIngresadosPagar() {
        $data['cod_usuario'] = $this->session->username;
        $this->template->set("titulo", "VUELOS INGRESADOS POR PAGAR");
        $tipo = "pagar";
        $data["listaIngresados"] = $this->Compartido_Model->ObtenerTodosVuelos($tipo);
//        echo $data["listaIngresados"];die;
        $data['tipo2'] = "pagar";
        $this->template->load($this->id_formulario, 'trafico/v_ingresado', $data);
        $res = $this->Compartido_Model->ObtenerTodosVuelos($tipo);
    }

    public function agregar() {
        $fecRegistro = $_POST['fecRegistro'];
        $fecha = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['fecha'])));
        $vuelo = $_POST['vuelo'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $tipo = $_POST['tipo2'];
        $data_vuelo = array(
            'fecha' => $fecha,
            'vuelo' => $vuelo,
            'origen' => $from,
            'destino' => $to,
            'fecha_registro' => $fecRegistro,
            'ip' => ip2long($this->input->ip_address()),
            'usuario_registro' => $this->session->username,
            'tipo' => $tipo
        );
        $this->Compartido_Model->InsertarTablaVuelo($data_vuelo);
        $ultimoId = $this->Compartido_Model->ObtenerId($data_vuelo);
        if (isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['cboTipo'])) {
            $cantidad_nombres = count($_POST['nombres']);
            $cantidad_apellidos = count($_POST['apellidos']);
            $cantidad_tipo = count($_POST['cboTipo']);
            for ($i = 0; $i < $cantidad_nombres; $i++) {
                $nombres = strtoupper($_POST['nombres'][$i]);
                $apellidos = strtoupper($_POST['apellidos'][$i]);
                $tipo = $_POST['cboTipo'][$i];
                $data_detalle = array(
                    'vuelo_id' => $ultimoId,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'tipo' => $tipo
                );
                $rpta = $this->Compartido_Model->InsertarTablaDetalle($data_detalle);
//                var_dump($rpta);
            }
        }
//        var_dump($tipo);die;

        if ($_POST['tipo2'] == 'cobrar') {
            header('Location: ' . base_url('trafico/Compartido/ListarIngresadosCobrar'));
//            redirect("trafico/Compartido/ListarIngresadosCobrar", 'refresh');
        } else {

            header('Location: ' . base_url('trafico/Compartido/ListarIngresadosPagar'));
//            redirect("", 'refresh');
        }
    }

    public function ListarIngresados() {
        $data['cod_usuario'] = $this->session->username;
        $this->template->set("titulo", "VUELOS INGRESADOS");
        $data["listaIngresados"] = $this->Compartido_Model->ObtenerTodosVuelos();
        $this->template->load($this->id_formulario, 'trafico/v_ingresado', $data);
        $res = $this->Compartido_Model->ObtenerTodosVuelos();
    }

    public function VerDetalle() {
        $id_vuelo = $_GET['id'];
        $data['cod_usuario'] = $this->session->username;
        $data["detalleVuelo"] = $this->Compartido_Model->ObtenerVueloId($id_vuelo);
        $this->template->set("titulo", "DETALLE DE VUELO");
        $data["listaPasajeros"] = $this->Compartido_Model->ObtenerDetalleVuelo($id_vuelo);
        $this->template->load($this->id_formulario, 'trafico/v_detalle', $data);
//        $res=$this->Compartido_Model->ObtenerDetalleVuelo($id_vuelo);         
    }

    public function ListarIngresados2() {
        $data['cod_usuario'] = $this->session->username;
        $this->template->set("titulo", "VUELOS INGRESADOS POR COBRAR");
        $data["listaIngresados"] = $this->Compartido_Model->ObtenerTodosVuelos('cobrar');
        $this->template->load($this->id_formulario, 'trafico/v_ingresado_2', $data);
//        $res = $this->Compartido_Model->ObtenerTodosVuelos();
    }

    public function VerDetalle2() {
        $id_vuelo = $_GET['id'];
        $data['cod_usuario'] = $this->session->username;
        $data["detalleVuelo"] = $this->Compartido_Model->ObtenerVueloId($id_vuelo);
        $this->template->set("titulo", "DETALLE DE VUELO");
        $data["listaPasajeros"] = $this->Compartido_Model->ObtenerDetalleVuelo($id_vuelo);
        $this->template->load($this->id_formulario, 'trafico/v_detalle_2', $data);
//        $res=$this->Compartido_Model->ObtenerDetalleVuelo($id_vuelo);         
    }

    public function EliminarPasajeroDetalle() {
        $id = $_GET['id'];
        $vuelo_id = $_GET['vuelo_id'];
        $id_pasajero = $this->Compartido_Model->EliminarPasajero($id);
        return header('Location: ' . base_url("trafico/Compartido/VerDetalle?id=$vuelo_id"));
    }

    public function ModificarTrafico() {
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $id_vuelo = $_POST['id_vuelo'];
        $id_pasajero = $_POST['id_pasajero'];
        $tipo = $_POST['cboTipo'];
        $res = $this->Compartido_Model->ActualizarRegistroTrafico($nombres, $apellidos, $id_pasajero, $tipo);
        return header('Location: ' . base_url("trafico/Compartido/VerDetalle?id=$id_vuelo"));
    }

    public function ModificarVuelo() {
        $fecha = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['fecha'])));
        $vuelo = $_POST['vuelo'];
        $origen = $_POST['origen'];
        $destino = $_POST['destino'];
        $id = $_POST['id'];
        $vuelo_tipo = $_POST['vuelo_tipo'];
        $res = $this->Compartido_Model->ActualizarVuelo($fecha, $vuelo, $origen, $destino, $id);
//        var_dump($origen,$destino);
//        return header('Location: ' . base_url("trafico/Compartido/ListarIngresados"));
        if ($vuelo_tipo == 'cobrar') {
            header('Location: ' . base_url('trafico/Compartido/ListarIngresadosCobrar'));
        } else {

            header('Location: ' . base_url('trafico/Compartido/ListarIngresadosPagar'));
        }
    }

    public function BuscarVuelos() {

        if (isset($_POST['daterangepicker']) && isset($_POST['tipo2'])) {

            $tipo = $_POST['tipo2'];
            $fec = $_POST['daterangepicker'];
            $fecha_from_to = explode(' - ', $fec);
//        var_dump($fecha_from_to);die;
            $fecha_from = $fecha_from_to[0];
            $fecha_to = $fecha_from_to[1];
            $desde = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_from)));
            $hasta = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_to)));

            if (isset($_POST['btnBuscar'])) {
                $data['listaIngresados'] = $this->Compartido_Model->BuscaRangoFecha($desde, $hasta, $tipo);
                $data['cod_usuario'] = $this->session->username;
                $data['tipo2'] = $tipo;
                $data['fec'] = $fec;
                if ($data['tipo2'] == 'cobrar') {
                    $this->template->set("titulo", "VUELOS INGRESADOS POR COBRAR");
                } else {
                    $this->template->set("titulo", "VUELOS INGRESADOS POR PAGAR");
                }
                $this->template->load($this->id_formulario, 'trafico/v_ingresado', $data);
            } else if (isset($_POST['btnBuscarConsultas2'])) {

                $tabla = $_POST['tabla'];
//                $data['datos_tabla'] = $this->Compartido_Model->TablaDetalleVuelo($desde, $hasta, $tipo);
//                $data['cod_usuario'] = $this->session->username;
                $data['tipo2'] = $tipo;
                $data['fec'] = $fec;
                $data['tabla'] = $tabla;

                if ($tabla == 'detalle') {
                    $data['datos_tdetalle'] = $this->Compartido_Model->TablaDetalle($desde, $hasta, $tipo);
                } else {
                    $data['datos_tvuelo'] = $this->Compartido_Model->TablaVuelo($desde, $hasta, $tipo);
                }
                
                
                if ($data['tipo2'] == 'cobrar') {
                    $this->template->set("titulo", "CONSULTAS POR COBRAR");
                } else {
                    $this->template->set("titulo", "CONSULTAS POR PAGAR");
                }
                $this->template->load($this->id_formulario, 'trafico/v_consulta', $data);
//            
//                
            } else {
                $rpta = $this->Compartido_Model->Excel($desde, $hasta, $tipo);
//                var_dump($desde, $hasta ,$tipo);
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=$desde a $hasta.xls");
                echo "
                    <table border='1'>
                        <thead>
                        <th>FECHA</th>
                        <th>VUELO</th>
                        <th>FROM</th>
                        <th>TO</th>
                        <th>FECHA REGISTRO</th>
                        <th>USUARIO_REGISTRO</th>
                        <th>TIPO</th>
                        <th>NOMBRES</th>
                        <th>APELLIDOS</th>
                        <th>TIPO</th>
                        </thead>
                        <tbody>
                ";
                foreach ($rpta->result() as $row) {
                    echo "<tr>";
                    echo "<td>" . $row->fecha . "</td>";
                    echo "<td>" . $row->vuelo . "</td>";
                    echo "<td>" . $row->origen . "</td>";
                    echo "<td>" . $row->destino . "</td>";
                    echo "<td>" . $row->fecha_registro . "</td>";
                    echo "<td>" . $row->usuario_registro . "</td>";
                    echo "<td>" . $row->tipoCP . "</td>";
                    echo "<td>" . $row->nombres . "</td>";
                    echo "<td>" . $row->apellidos . "</td>";
                    echo "<td>" . $row->tipo . "</td>";
                    echo "</tr>";
                }
                echo "
                        </tbody>
                    </table>
                ";
            }
        } else if (isset($_POST['daterangepicker2'])) {
            $fec = $_POST['daterangepicker2'];
            $fecha_from_to = explode(' - ', $fec);
//        var_dump($fecha_from_to);die;
            $fecha_from = $fecha_from_to[0];
            $fecha_to = $fecha_from_to[1];
            $desde = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_from)));
            $hasta = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_to)));

            $data['listaIngresados'] = $this->Compartido_Model->BuscaRangoFechaPeruvian($desde, $hasta);
            $data['cod_usuario'] = $this->session->username;
            $data['fec'] = $fec;
            $this->template->set("titulo", "VUELOS INGRESADOS POR COBRAR");
            $this->template->load($this->id_formulario, 'trafico/v_ingresado_2', $data);
        } else {

            $desde = (new DateTime())->format('Y-m-d');
            $hasta = (new DateTime())->format('Y-m-d');
            $data['listaIngresados'] = $this->Compartido_Model->BuscaRangoFechaPeruvian($desde, $hasta);
            $data['cod_usuario'] = $this->session->username;
//            $data['tipo'] = $tipo;
            $this->template->set("titulo", "DETALLE DE VUELO");
            $this->template->load($this->id_formulario, 'trafico/v_ingresado_2', $data);
        }
    }

    public function AgregarPasajero() {
        $id = $_POST['id'];
        if (isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['cboTipo'])) {
            $cantidad_nombres = count($_POST['nombres']);
            $cantidad_apellidos = count($_POST['apellidos']);
            $cantidad_tipo = count($_POST['cboTipo']);
            for ($i = 0; $i < $cantidad_nombres; $i++) {
                $nombres = $_POST['nombres'][$i];
                $apellidos = $_POST['apellidos'][$i];
                $tipo = $_POST['cboTipo'][$i];
                $data_detalle = array(
                    'vuelo_id' => $id,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'tipo' => $tipo
                );
                $rpta = $this->Compartido_Model->InsertarTablaDetalle($data_detalle);
//                var_dump($rpta);
            }
        }
        return header('Location: ' . base_url("trafico/Compartido/VerDetalle?id=$id"));
    }
    public function Consulta() {
        $data['cod_usuario'] = $this->session->username;
        $this->template->set("titulo", "CONSULTAS");
        $this->template->load($this->id_formulario, 'trafico/v_consulta', $data);
    }

}
