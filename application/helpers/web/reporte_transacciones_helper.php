<?php

if (!function_exists('ArmarJsonReporteTransacciones')) {

    function ArmarJsonReporteTransacciones($DataTransaccionesDetalles) {
        $data_2 = [];
        $data_3 = array();
        foreach ($DataTransaccionesDetalles->Result() as $item) {
            $data_2[$item->id] = $item->id;
        }
        foreach ($data_2 as $key) {
            foreach ($DataTransaccionesDetalles->Result() as $item) {
                switch ($key) {
                    case $item->id:
                        $data_3[$key]['fecha_registro'] = $item->fecha_registro;
                        $data_3[$key]['pnr'] = $item->pnr;
                        $data_3[$key]['apellidos'] = $item->apellidos;
                        $data_3[$key]['nombres'] = $item->nombres;
                        $data_3[$key]['nombre_pais'] = $item->nombre_pais;
                        $data_3[$key]['nombre_pais'] = $item->nombre_pais;
                        break;
                }
            }
        }
        return json_decode(json_encode($data_3));
    }

}

if (!function_exists('modal_body_reserva_detalle')) {

    function modal_body_reserva_detalle($data_reserva_detalle) {
        $html = '';
        $html .= '<div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Tickets</th>
                  </tr>
                  </thead>
                  <tbody>';
        foreach ($data_reserva_detalle->Result() as $data) {
            $html .= '<tr>
                    <td>' . $data->nombres . '</td>
                    <td>' . $data->apellidos . '</td>
                    <td>' . $data->num_ticket . '</td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                    </td>
                  </tr>';
        }

        $html .= '</tbody>
                </table>
              </div>';

        return $html;
    }

}
if (!function_exists('GetCcCode')) {

    function GetCcCode($brand) {
        switch ($brand) {
            case 'visa':
                $cc_code = 'VI';
                break;
            case 'amex':
                $cc_code = 'AX';
                break;
            case 'mastercard':
                $cc_code = 'CA';
                break;
            case 'dinersclub':
                $cc_code = 'DC';
                break;
        }

        return $cc_code;
    }

}