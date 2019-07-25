<div class="table-responsive">
	<table id="table_main" class="table table-bordered table-striped">
		<thead>
			<tr>
                <th>RUC AGENCIA</th>
				<th>PNR</th>
				<th>Pasajero</th>
				<th>Registro</th>
                <th>Ruta</th>
                <th>Ticket</th>
                <th title="Forma Pago">F. Pago</th>
                <th title="Tatifa Neta">Tarifa</th>
				<th title="Impuesto General a las Ventas">IGV</th>
				<th title="Tarifa Unificada de Uso de Aeropuerto">TUUA</th>
				<th title="Total a Pagar sin Descuentos">Total</th>
                <th title="Monto Total a Pagar">Pagar</th>
            </tr>
		</thead>
		<tbody>
            <?php if (count($movimientos)>0): ?>
                <?php
                    $img_array=["VI"=>"vi.png","MC"=>"mc.png","AX"=>"ax.png","DC"=>"dc.jpg","PP"=>"pp.png","SP"=>"sp.jpg","PE"=>"pe.jpg","TC"=>"visa_net.png","LC"=>"lc.png"];
                    $img_name=["VI"=>"","MC"=>"","AX"=>"","DC"=>'style="height:50px;"',"PP"=>"","SP"=>'style="height:45px;"',"PE"=>'style="height:25px;"',"TC"=>'style="height:30px;"',"LC"=>'style="height:30px;"'];
                ?>
                <?php foreach ($movimientos as $key => $movimiento): ?>
                    <?php
                        if ($movimiento->Estado==1 && $movimiento->Ticket!='') {
                            $tarifa=  number_format($movimiento->Tarifa, 2, '.',',');
                            $igv=  number_format($movimiento->IGV, 2, '.',',');
                            $tuua=  number_format($movimiento->TUUA, 2, '.',',');
                            $importe=  number_format($movimiento->Importe, 2, '.',',');
                            $pagar=  number_format($movimiento->Total, 2, '.',',');
                        }
                        else{
                            $tarifa=  "0.00";
                            $igv=  "0.00";
                            $tuua=  "0.00";
                            $importe=  "0.00";
                            $pagar=  "0.00";
                        }
                    ?>
                    <tr>
                        <td class="texto_ruc">
                            <?= $movimiento->RUC ?> <br>
                            <b>Reserva ID: </b> <?= $movimiento->Registro?>
                        </td>
                        <td class="texto_centro">
                            <a id="<?= $movimiento->CodigoReserva ?>" name="<?= $movimiento->Registro?>|<?= $movimiento->Detalle?>|<?= $movimiento->Ticket?>" class="codigoreserva" style="cursor:pointer;">
                                <?= $movimiento->CodigoReserva ?>
                            </a>
                        </td>
                        <td class="">
                            <?= $movimiento->Pasajero ?> <br>
                            <b>Tipo Pax: </b> <?= $movimiento->Tipo_Pax?>
                            <?php if ($movimiento->RUC_PAS): ?>
                                <br>
                                <b>RUC: </b><?= $movimiento->RUC_PAS ?>
                            <?php endif ?>
                        </td>
                        <td class="texto_centro"><?= $movimiento->Fecha ?></td>
                        <td class="text_ruta">
                            <?= $movimiento->Ruta ?> <i class="fa fa-fw fa-long-arrow-right"></i> 
                            <span class="label label-default"><?= $movimiento->Vuelo_Salida?></span> <br>
                            <i class="fa fa-fw fa-calendar"></i> 
                            <i class="fa fa-fw fa-long-arrow-right"></i> 
                            <?= $movimiento->Fecha_Salida?> <?= $movimiento->Hora_Salida?>
                            <?php if ($movimiento->TipoVuelo=='R'): ?>
                                <br> <br>
                                <?= $movimiento->Destino.'-'.$movimiento->Origen ?> 
                                <i class="fa fa-fw fa-long-arrow-left"></i> 
                                <span class="label label-default"><?= $movimiento->Vuelo_Retorno?></span> <br>
                                <i class="fa fa-fw fa-calendar"></i> 
                                <i class="fa fa-fw fa-long-arrow-left"></i> 
                                <?= $movimiento->Fecha_Retorno?> <?= $movimiento->Hora_Retorno?>
                            <?php endif ?>
                        </td>
                        <td class="texto_centro">
                            <a id="<?= $movimiento->Ticket ?>" class="nro_ticket" style="cursor:pointer;" title="Click para ver el boleto"><?= $movimiento->Ticket ?></a>
                        </td>
                        <td class="texto_centro">
                            <?php
                                if ($movimiento->FormaPago=="LC") {
                                    $title='';
                                    $class='';
                                }
                                else{
                                    $title='Click';
                                    $class='btn-metodo-pago';
                                }
                                $name_img = $img_array[$movimiento->FormaPago];
                                $style_img=$img_name[$movimiento->FormaPago];
                            ?>
                            <a id="<?= $movimiento->Registro?>|<?= $movimiento->FormaPago?>" name="<?=$movimiento->Estado?>|<?=$movimiento->CodigoReserva?>" class="<?=$class?>" title="<?=$title?>">
                                <img src="<?= base_url('/')?>img/met_pago/ico_<?= $name_img?>" <?= $style_img?>>
                            </a>
                        </td>
                        <td class="texto_der"><?= $tarifa ?></td>
                        <td class="texto_der"><?= $igv ?></td>
                        <td class="texto_der"><?= $tuua ?></td>
                        <td class="texto_der"><?= $importe ?></td>
                        <td class="texto_der"><?= $pagar ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="texto_centro red">NO EXISTEN REGISTROS PARA SU CONSULTA</td>
                </tr>
            <?php endif ?>
		</tbody>
        <?php if (count($movimientos)>0): ?>
    		<tfoot>
                <tr>
                    <tr>
                        <td class="texto_der negrita" colspan="7">Total</td>
                        <td class="texto_der negrita"><?= number_format($totales->Tarifa,2,'.',',')?></td>
                        <td class="texto_der negrita"><?= number_format($totales->IGV,2,'.',',')?></td>
                        <td class="texto_der negrita"><?= number_format($totales->TUUA,2,'.',',')?></td>
                        <td class="texto_der negrita"><?= number_format($totales->Importe,2,'.',',')?></td>
                        <td class="texto_der negrita"><?= number_format($totales->Total,2,'.',',')?></td>
                    </tr>
                </tr>
    		</tfoot>
        <?php endif ?>
	</table>
</div>
<?php if (count($movimientos)>0): ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" style="margin-top: 20px; margin-bottom: 20px;">
                    <?php  ?>
                    Mostrando <?= $config->current+1?> a <?= $config->current+($config->total_rows>=$config->rows ? $config->rows : $config->total_rows) ?> de <?= $config->total_rows?> entradas
                </div>
            </div>
            <div class="col-md-6">
                <nav class="pull-right">
                    <?php echo $paginacion ?>
                </nav>
            </div>
        </div>
    </div>
<?php endif ?>