<table id="table_main" class="table table-bordered table-striped">
    <?php if ($reserva && $entidad): ?>
        <tr>
            <td colspan="2" class="negrita alinear_texto_centro">TITULAR</td>
            <td colspan="2" class="negrita alinear_texto_centro">RESERVA</td>
        </tr>

        <tr>
            <td class="negrita">Nombre</td>
            <td><?=$reserva->Nombres?></td>
            <td class="negrita">PNR</td>
            <td><?=$reserva->CodigoReserva?></td>
        </tr>

        <tr>
            <td class="negrita">Apellido</td>
            <td><?=$reserva->Apellidos?></td>
            <td class="negrita">Adultos</td>
            <td><?=$reserva->Adultos?></td>
        </tr>

        <tr>
            <td class="negrita">Teléfono</td>
            <td><?=$reserva->Apellidos?></td>
            <td class="negrita">Infantes</td>
            <td><?=$reserva->Ninos?></td>
        </tr>

        <tr>
            <td class="negrita">Email</td>
            <td><?=$reserva->Email?></td>
            <td class="negrita">Bebés</td>
            <td><?=$reserva->Bebes?></td>
        </tr>

        <tr>
            <td class="negrita">Nacionalidad</td>
            <td><?=$reserva->Pais?></td>
            <td class="negrita">Fecha Registro</td>
            <td><?=$reserva->FechaRegistro?></td>
        </tr>

        <tr>
            <td class="negrita">Doc. Identidad</td>
            <td><?=$reserva->Tipo_Doc.' '.$reserva->Documento?></td>
            <td class="negrita">Origen</td>
            <td><?=$reserva->Origen?></td>
        </tr>

        <tr>
            <td colspan="2" class="negrita alinear_texto_centro">DATOS ENTIDAD</td>
            <td class="negrita">Destino</td>
            <td><?=$reserva->Destino?></td>
        </tr>

        <tr>
            <td class="negrita">RUC</td>
            <td><?=$entidad->RUC?></td>
            <td class="negrita">Fecha Ida</td>
            <td><?=$reserva->Fecha_Salida?></td>
        </tr>

        <tr>
            <td class="negrita">Razon Social</td>
            <td><?=$entidad->RazonSocial?></td>
            <td class="negrita">Clase Ida</td>
            <td><?=$reserva->Clase_Salida?></td>
        </tr>

        <tr>
            <td class="negrita">Gestor</td>
            <td><?=$entidad->ApellidoPaterno.' '.$entidad->ApellidoMaterno.', '.$entidad->Nombres?></td>
            <td class="negrita">Fecha Retorno</td>
            <td><?=$reserva->Fecha_Retorno?></td>
        </tr>

        <tr>
            <td class="negrita">Celular</td>
            <td><?=$entidad->Celular?></td>
            <td class="negrita">Clase Retorno</td>
            <td><?=$reserva->Clase_Retorno?></td>
        </tr>

        <tr>
            <td class="negrita">Telef. Fijo</td>
            <td><?=$entidad->TelefoniaOficina?></td>
            <td class="negrita">Tarifa</td>
            <td class="fila_numero"><?=$reserva->Flete?></td>
        </tr>

        <tr>
            <td class="negrita">Anexo</td>
            <td><?=$entidad->Anexo?></td>
            <td class="negrita">TUUA</td>
            <td class="fila_numero"><?=$reserva->TUA?></td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td class="negrita">IGV</td>
            <td class="fila_numero"><?=$reserva->Impuesto?></td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td class="negrita">TOTAL</td>
            <td class="fila_numero"><?=$reserva->Total?></td>
        </tr>
        <input type="hidden" id="codigo_reserva" value="<?=$reserva->CodigoReserva?>">
        <input type="hidden" id="ticket" value="<?=$ticket?>">
        <input type="hidden" id="registro" value="<?=$registro?>">
        <input type="hidden" id="txt_ruc" value="<?=$entidad->RUC?>">
    <?php else: ?>
        <tr>
            <td class="texto_centro red">NO EXISTEN REGISTROS PARA SU CONSULTA</td>
        </tr>
    <?php endif ?>
</table>