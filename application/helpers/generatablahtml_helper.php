<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function helpv17Usuario_armaTabla($campos_usuario) {

    $tabla = '';
    foreach ($campos_usuario as $fila) {
        if ($fila["estado"] == "Y") {
            $color = "";
            $icono = "glyphicon-trash";
            $titulo = "Desactivar";
            $display = "inline";
            $class = "";
            $accion = "desactivar_usuario";
        } else if ($fila["estado"] == 'N') {
//                $color   = "red";
            $color = "";
            $icono = "glyphicon-cog";
            $titulo = "Reactivar";
            $display = "none";
            $class = "danger";
            $accion = "reactivar_usuario";
        }
//            $tabla.='<tr style="color:'.$color.';">'."\n";
        $tabla.='<tr class= "' . $class . '" style="color:' . $color . ';">' . "\n";
        $tabla.='<td><center id = "codigo_' . $fila["id_usuario"] . '">' . $fila["codigo"] . '</center></td>' . "\n";
        $tabla.='<td id = "nombre_' . $fila["id_usuario"] . '">' . $fila["nombre"] . '</td>' . "\n";
        $tabla.='<td id = "apellido_' . $fila["id_usuario"] . '">' . $fila["apellido"] . '</td>' . "\n";
//            $tabla.='<td><center>'.$fila["nombre_cargo"].'</center></td>'."\n";
//            $tabla.='<td><center>'.$fila["nombre_area"].'</center></td>'."\n";
//          $tabla.='<td>'.$fila["Gerencia"].'</td>'."\n";
//            $tabla.='<td><center>'.$fila["nombre_ciudad"].'</center></td>'."\n";
//            $tabla.='<td><center>'.$fila["ip_location"].'</center></td>'."\n";
        $tabla.='<td id = "email_' . $fila["id_usuario"] . '">' . $fila["email"] . '</td>' . "\n";
        $tabla.='<td><center><div style="display:' . $display . ';" class="glyphicon glyphicon-pencil editar" id="' . $fila["id_usuario"] . '" title="Editar"></div></center></td>' . "\n";
        $tabla.='<td><center><div class="glyphicon ' . $icono . ' ' . $accion . '" name = "' . $fila["estado"] . '" id="' . $fila["id_usuario"] . '" title="' . $titulo . '"></div></center></td>' . "\n";
        $tabla.='<td><center><div style="display:' . $display . ';" class="glyphicon glyphicon-random cambiar" name = "" id="' . $fila["id_usuario"] . '" title="Resetear Clave"></div></center></td>' . "\n";
        $tabla.='</tr>' . "\n";
    }
    $data["lista_usuario"] = $tabla;
    return $data;
}

function helpv17Formulario_armaTabla($arrayCampos) {
    $html = '';
    $cant_formularios = count($arrayCampos);
    $cociente = floor($cant_formularios / 3);
    $residuo = fmod($cant_formularios, 3);
    $primeraColumna = $cociente;
    $segundaColumna = $cociente;
    $terceraColumna = $cociente;
    if ($residuo > 1) {
        $primeraColumna = $primeraColumna + 1;
        $segundaColumna = $segundaColumna + 1;
    } elseif ($residuo == 1) {
        $primeraColumna = $primeraColumna + 1;
    }
    $valor1 = 0;
    $valor2 = $primeraColumna;
    $valor3 = $primeraColumna + $segundaColumna;

    $html.='<div class="form-group row ">' . "\n";
    $html.='<div class="col-xs-4" id="colbasica">' . "\n";
    $k = 0;
    while ($valor1 < $primeraColumna) {
        $k = $k + 1;

        $html.='<label class="control-label" for="paises">' . $arrayCampos[$valor1][0] . '</label>' . "\n";
        $html.='<div class="control-group">' . "\n";
        $html.='<div class="controls">' . "\n";
        $html.='<input type="checkbox" class="input-medium"  name="' . $k . '" id="permiso_' . $arrayCampos[$valor1][1] . '" value="0">' . "\n";
        $html.='</div>' . "\n";
        $html.='</div>' . "\n";

        $valor1 = $valor1 + 1;
    }
    $html.='</div>' . "\n";
    $html.='<div class="col-xs-4" id="colbasica">' . "\n";


    while ($valor2 < $primeraColumna + $segundaColumna) {
        $k = $k + 1;

        $html.='<label class="control-label" for="paises">' . $arrayCampos[$valor2][0] . '</label>' . "\n";
        $html.='<div class="control-group">' . "\n";
        $html.='<div class="controls">' . "\n";
        $html.='<input type="checkbox" class="input-medium"  name="' . $k . '" id="permiso_' . $arrayCampos[$valor2][1] . '" value="0">' . "\n";
        $html.='</div>' . "\n";
        $html.='</div>' . "\n";

        $valor2 = $valor2 + 1;
    }

    $html.='</div>' . "\n";
    $html.='<div class="col-xs-4" id="colbasica">' . "\n";

    while ($valor3 < $primeraColumna + $segundaColumna + $terceraColumna) {
        $k = $k + 1;
        $html.='<label class="control-label" for="paises">' . $arrayCampos[$valor3][0] . '</label>' . "\n";
        $html.='<div class="control-group">' . "\n";
        $html.='<div class="controls">';
        $html.='<input type="checkbox" class="input-medium"  name="' . $k . '" id="permiso_' . $arrayCampos[$valor3][1] . '" value="0">' . "\n";
        $html.='</div>' . "\n";
        $html.='</div>' . "\n";
        $valor3 = $valor3 + 1;
    }
    $html.='</div>' . "\n";
    $html.='</div>' . "\n";

    $data["lista_editar"] = $html;
    return $data;
}

function helpv17Formulario_armaCRUD($res_retornaTblFormulario) {

    $tabla = '';

    foreach ($res_retornaTblFormulario as $fila) {
        if ($fila->estado == 'Y') {
            $color = '';
            $icono = "glyphicon-trash";
            $titulo = "Desactivar";
            $display = "inline";
            $class = "";
            $accion = "desactivar_formulario";
        } else if ($fila->estado == 'N') {
            $color = '';
            $icono = "glyphicon-cog";
            $titulo = "Reactivar";
            $display = "none";
            $class = "danger";
            $accion = "reactivar_formulario";
        }
//              $tabla.='<tr style="color:'.$color.';">'."\n";
        $tabla.='<tr class= "' . $class . '" style="color:' . $color . ';">' . "\n";
//              $tabla.='<td id = "codigo_'.$fila->id_formulario.'">'.$fila->nombre_formulario.'</td>'."\n";
        $tabla.='<td id = "codigo_' . $fila->id_formulario . '">' . $fila->nombre_formulario . '</td>' . "\n";
        $tabla.='<td id = "grupo_' . $fila->id_formulario . '">' . $fila->nombre_grupo . '</td>' . "\n";
        $tabla.='<td id = "ubicacion_' . $fila->id_formulario . '">' . $fila->ubicacion_formulario . '</td>' . "\n";
        $tabla.='<td><center><div style="display:' . $display . ';" class="glyphicon glyphicon-pencil editar" id="' . $fila->id_formulario . '" title="Editar"></div></center></td>' . "\n";
        $tabla.='<td><center><div class="glyphicon ' . $icono . ' ' . $accion . '" name = "' . $fila->estado . '" id="' . $fila->id_formulario . '" title="' . $titulo . '"></div></center></td>' . "\n";
//              $tabla.='<td><center><div style="display:'.$display.';" class="glyphicon glyphicon-random cambiar" name = "" id="'.$fila->id_formulario.'" title="Resetear Clave"></div></center></td>'."\n";
        $tabla.='</tr>' . "\n";
    }
    $data["lista_formulario"] = $tabla;
    return $data;
}

function helpCCOitinerario_armaCabecera($dataArrayItinerarios, $array_matriculas) {
    $aeronave = $dataArrayItinerarios[0][11];
    $select_aeronave = generar_select_general($array_matriculas, $aeronave);
    $aeronave = $dataArrayItinerarios[0][11];
    $ruta = '';
    $año = date('m');
    for ($i = 3; $i < 11; $i++) {
        $ruta .= $dataArrayItinerarios[0][$i] . " ";
    }

    echo '<div class="row">
                  <div class="col-md-3"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ruta:</b> ' . $ruta . '</div>
                  <div class="col-md-2"><b>Aeronave:</b> <select>' . $select_aeronave . '</select></div>
                  <div class="col-md-1"><b>Tipo:</b> ' . $dataArrayItinerarios[0][12] . '</div>
                  <div class="col-md-2"><b>Sale:</b> ' . $dataArrayItinerarios[0][17] . '</div>
                  <div class="col-md-2"><b>Llega:</b> ' . $dataArrayItinerarios[0][18] . '</div>
                  <div class="col-md-2"><b>HV Block:</b> ' . $dataArrayItinerarios[0][19] . '</div>
              </div>
              <div class="row">
                  <div class="col-md-2"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mes: </b>' . generar_select_meses() . '</div>
                  <div class="col-md-10"><b>Año: </b>' . genera_select_anios() . ' </div>
              </div>';
}

function helpPasarelaGeneraCabeceraClasesTarifarias($familias, $clase_familia) {

    $cant_clase_familia = count($clase_familia);
    $fila_familia = '<tr class="cabeceraFamiliaBackground">';
    $fila_clase = '<tr>';

    $j = 1;
    foreach ($familias as $item_familias) {
        $i = 0;

        foreach ($clase_familia as $item_clase) {
            if ($item_clase->CodigoFamilia == $item_familias->CodigoFamilia) {
                $res = ($item_clase->Extranjero) ? "checked" : '';
                $fila_clase .= '<td class="cabeceraTblAlignCenter"><input id="' . $item_clase->CodigoClase . '" class="chk_' . $j++ . '" type="checkbox" ' . $res . '><br>' . $item_clase->NombreClase . '</td>';

                $i++;
            }
        }
        $fila_familia .= '<td colspan="' . $i . '" class="cabeceraTblAlignCenter" id="' . $item_familias->CodigoFamilia . '">' . $item_familias->NombreFamilia . '</td>';
    }
    $fila_clase .= '</tr>';
    $fila_familia .= '</tr>';
    $array_fila_familia['fila_familia'] = $fila_familia;
    $array_fila_familia['fila_clase'] = $fila_clase;
    $array_fila_familia['cant_familias'] = $cant_clase_familia;
    return $array_fila_familia;
}

function genera_tabla_listaPaises($selectPaises) {
    $fila_pais = '';
    foreach ($selectPaises as $item_paises) {
        $fila_pais .= "<tr>";
        $fila_pais .= "<td>$item_paises->CodigoPais</td>";
        $fila_pais .= "<td>$item_paises->Abreviatura</td>";
        $fila_pais .= "<td>$item_paises->Pais</td>";
        $fila_pais .= "<td>$item_paises->Continente</td>";
        $fila_pais .= "<td>$item_paises->ddi</td>";
        $fila_pais .= "<td>$item_paises->Web</td>";
        $fila_pais .='<td><center><div class="glyphicon glyphicon-pencil editar" id="' . $item_paises->CodigoPais . '" title="Editar"></div></center></td>' . "\n";
        $fila_pais .= "</tr>";
    }
    $data["lista_paises"] = $fila_pais;
    return $data;
}

function genera_tabla_listaEntidadesAyuda($codigo, $ruc, $nombre, $direccion) {
    $fila_entidadayuda = '';
    $cant_reg = count($codigo);
    for ($i = 0; $i < $cant_reg; $i++) {
        $fila_entidadayuda .= "<tr style='cursor:pointer'>";
        $fila_entidadayuda .= "<td class='entidadayuda' id='codigo_entidad'>$codigo[$i]</td>";
        $fila_entidadayuda .= "<td class='entidadayuda'>$ruc[$i]</td>";
        $fila_entidadayuda .= "<td class='entidadayuda'>" . utf8_decode($nombre[$i]) . "</td>";
        $fila_entidadayuda .= "<td class='entidadayuda'>$direccion[$i]</td>";

        $fila_entidadayuda .= "</tr>";
    }
    return $fila_entidadayuda;
}


//OPCION 1 -- ANALIZAR EFICIENCIA
function generaTablaGenerica($cant_row, $data) {

    for ($i = 0; $i < $cant_row; $i++) {

        $col = '<tr class="td_center">';
        foreach ($data as $ingreso1) {
            foreach ($ingreso1 as $ingreso2) {

                $col .= '<td>' . trim($ingreso2) . '</td>';
            }
        }
        $col .= '</tr>';
    }


    return $col;
}
//OPCION 2 -- ANALIZAR EFICIENCIA
function armaTBODY_TCambioRangoFechas($data) {
    $filas = '';
    while (!$data->EOF) {
        $filas .= '<tr class="td_center">';
        $filas .= '<td>' . $data->fields[0] . '</td>';
        $filas .= '<td>' . DateFormatCarga($data->fields[1]) . '</td>';
        $filas .= '<td>' . $data->fields[2] . '</td>';
        $filas .= '<td>' . $data->fields[3] . '</td>';
        $filas .= '<td>' . $data->fields[4] . '</td>';
        $filas .= '<td>' . $data->fields[5] . '</td>';
        $filas .= '</tr>';
        $data->MoveNext();
    }
    return $filas;
}

//    function armaCabeceraTbl($dataHeader) {
//        $k = 0;
//        $j = 1;
//        for ($i = 0; $i < count($dataHeader) / 2; $i++) {
//            $data['col' . $i]['name'] = $dataHeader[$k];
//            $data['col' . $i]['ancho'] = $dataHeader[$j];
//            $k = $k + 2;
//            $j = $j + 2;
//        }
//        return $data;
//    }
