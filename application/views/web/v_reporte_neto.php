<?= form_open('ecommerce/ReporteVentasNetas/recibiendopost') ?>

<div class="box">
    <div class="box-header" style="padding-bottom: 0px;margin-bottom: -20px">
        <div class="form-group row">
            <div class="col-sm-3 col-xs-12">
                <div class="input-daterange" id="datepicker">
                    <div class="col-sm-6 col-xs-12">
                        <label>Desde :</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" readonly="" value="<?= set_value('desde') ?>" name="desde">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <label>Hasta:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" readonly="" value="<?= set_value('hasta') ?>" name="hasta">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="col-sm-4 col-xs-12">
                    <label>Ruta</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="ruta" > 
                        <option  value="" >Todos</option>
                        <?php foreach ($ruta as $item) { ?>
                            <option <?= set_value('ruta') == $item['ciudad_origen_codigo'].'-'.$item['ciudad_destino_codigo'] ? 'selected' : '' ?> value="<?php echo $item['ciudad_origen_codigo'] . "-" . $item['ciudad_destino_codigo'] ?>"> <?php echo $item['ciudad_origen_codigo'] . " - " . $item['ciudad_destino_codigo']; ?></option> 
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <label>Tipo</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="tipo_viaje"> 
                        <option value="">Todos</option>
                        <option <?= set_value('tipo_viaje') == 'O' ? 'selected' : '' ?> value="O">OW</option>
                        <option <?= set_value('tipo_viaje') == 'R' ? 'selected' : '' ?> value="R">RT</option>
                    </select>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <label>Clase</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="clase"> 
                        <option value="">Todos</option>
                        <?php foreach ($clase as $item) { ?>
                            <option <?= set_value('clase') == $item['codigo'] ? 'selected' : '' ?> value="<?php echo $item['codigo']; ?>"> <?php echo $item['codigo']; ?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="col-sm-7 col-xs-12">
                    <label> Ubic.</label>
                    <span class="fechaida">
                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="nacionalidad" >
                            <option value="">Todos</option>
                            <?php foreach ($paises as $item) { ?>
                                <option <?= set_value('nacionalidad') == $item['id'] ? 'selected' : '' ?> value="<?php echo $item['id']; ?>"> <?php echo $item['nombre_pais']; ?></option> 
                            <?php } ?>
                        </select>
                    </span>
                </div>
                <div class="col-sm-5 col-xs-12">
                    <label>F.P</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="tipo_pago">
                        <option value="">Todos</option>
                        <option <?= set_value('tipo_pago') == 'VI' ? 'selected' : '' ?> value="VI">VISA</option>
                        <option <?= set_value('tipo_pago') == 'MC' ? 'selected' : '' ?> value="MC">MASTERCARD</option>
                        <option <?= set_value('tipo_pago') == 'DC' ? 'selected' : '' ?> value="DC">DINERS CLUB</option>
                        <option <?= set_value('tipo_pago') == 'AX' ? 'selected' : '' ?> value="AX">AMEX</option>
                        <option <?= set_value('tipo_pago') == 'PP' ? 'selected' : '' ?> value="PP">PAYPAL</option>
                        <option <?= set_value('tipo_pago') == 'SP' ? 'selected' : '' ?> value="SP">SAFETYPAY</option>
                        <option <?= set_value('tipo_pago') == 'PE' ? 'selected' : '' ?> value="PE">PAGO EFECTIVO</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <div style="margin-top: 23px;">
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-warning">Consultar</button>
                    </div>
                    <div class="col-xs-6">
                        <button type="button" id="exportar_ventas" style="" class="btn boton-filtro">Exportar </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box-body" style="margin-top: 10px">
        <div class="table-responsive">
            <?php if (isset($reserva)) { ?>
                <table id="tbl_reportes" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Contacto/PNR</th>
                            <th>Pax</th>
                            <th>Ruta</th>
                            <th>Fecha/Vuelo Salida</th>
                            <th>Fecha/Vuelo Retorno</th>
                            <th>Fecha Reserva</th>
                            <th>Clase Salida</th>
                            <th>Clase Retorno</th>
                            <th>Tipo</th>
                            <th>Ubic.</th>
                            <th>Nac.</th>
                            <th>Tarifa</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                                $suma = 0;
                                $o=0;
                                $r=0;
                            ?>
                            <?php foreach ($reserva as $reservas) { ?>
                                <?php 
                                    if ($reservas['tipo_viaje']=='O') {
                                        $o=$o+$reservas['cant_rutas'];
                                    } else {
                                        $r=$r+$reservas['cant_rutas']*2;
                                    }
                                ?>
                                <tr style="text-align: center;">
                                    <td>
                                        <?php
                                            echo $reservas['apellidos'] . $reservas['nombres'] . '<br>';
                                            echo '<p style="color:blue;">' . '<label>' . $reservas['pnr'] . '</label>' . '</p>'
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                            echo "A:" . $reservas['cant_adl'] . '<br>';
                                            echo "N:" . $reservas['cant_chd'] . '<br>';
                                            echo "B:" . $reservas['cant_inf']
                                        ?>
                                    </td>

                                    <td><?php echo $reservas['origen'] . "-" . $reservas['destino'] ?></td>

                                    <td>
                                        <?php
                                            $fecha_salida_ida = new DateTime($reservas['fechahora_salida_tramo_ida']);
                                            echo $fecha_salida_ida->format('Y-m-d') . '<br>';
                                            echo '<p style="color:green;">' . $reservas['num_vuelo_ida'] . '</p>'
                                        ?>
                                    </td>


                                    <td>
                                        <?php
                                            $fecha_salida = new DateTime($reservas['fechahora_salida_tramo_retorno']);
                                            echo $fecha_salida->format('Y-m-d') . '<br>';
                                            echo '<p style="color:green;">' . $reservas['num_vuelo_retorno'] . '</p>'
                                        ?>                                        
                                    </td>

                                    <td>
                                        <?php
                                            $fecharegistro = new DateTime($reservas['fecha_registro']);
                                            echo $fecharegistro->format('Y-m-d');
                                        ?>
                                    </td>

                                    <td><?php echo $reservas['clase_ida'] ?></td>
                                    <td><?php echo $reservas['clase_retorno'] ?></td>
                                    <td> <?php echo $reservas['tipo_viaje'] ?></td>
                                    <td><?php echo $reservas['geo_pais'] ?></td>
                                    <td><?php echo $reservas['codigo_pais'] ?></td>
                                    <td><?php echo $reservas['total'] ?></td>
                                    <?php $suma += $reservas['total'] ?>
                                </tr>
                            <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11" style="text-align: right;"><label>NUMERO DE RUTAS</label></td>
                            <td><label><?= $o+$r ?></label></td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: right;"><label>TARIFA NETA TOTAL</label></td>
                            <td><label><?php echo $suma ?></label></td>
                        </tr>
                    </tfoot>
                </table>
            <?php } ?>
        </div>
    </div>
    
</div>

<?php form_close() ?>

