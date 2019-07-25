<?= form_open('ecommerce/ReporteVentasNetas/ReporteVenta') ?>

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
                            <input type="text" class="form-control pull-right" value="<?= set_value('desde')?>" name="desde">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <label>Hasta:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" value="<?= set_value('hasta')?>" name="hasta">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <div class="col-sm-12 col-xs-12">
                    <label>Medio Pago</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="tipo_pago">
                        <option value="">TODOS</option>
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
            <div class="col-sm-3 col-xs-12">
                <div style="margin-top: 23px;">
                    <div class="col-sm-4 col-xs-12">
                        <button type="submit" class="btn btn-warning">Consultar</button>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <button type="button" id="exportar_ventas" style="" class="btn boton-filtro">
                            Exportar a Excel 
                            <i class="fa fa-table"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="box-body">
        <div class="table-responsive">
            <?php if (isset($reservas)): ?>
                <table id="tbl_reportes" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="200" height="20"><strong>Fecha</strong></th>
                            <th width="50" height="20"><strong>Hora</strong></th>
                            <th width="200" height="20"><strong>Fecha Vuelo</strong></th>
                            <th width="100" height="20"><strong>Dias<br>Restantes</strong></th>
                            <th width="100" height="20"><strong>Geo</strong></th>
                            <th width="100" height="20"><strong>Nac</strong></th>
                            <th width="180" height="20"><strong>Origen</strong></th>
                            <th width="150" height="20"><strong>Destino</strong></th>
                            <th width="150" height="20"><strong>Monto</strong></th>
                            <th width="150" height="20"><strong>Tkts</strong></th>
                            <th width="150" height="20"><strong>MedioPago</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sum=0; ?>
                        <?php if (count($reservas)>0): ?>
                            <?php foreach ($reservas as $key => $reserva): ?>
                                <?php $sum=$sum+$reserva->total_pagar; ?>
                                <tr style="text-align: center;">
                                    <td><?= $reserva->fecha?></td>
                                    <td><?= $reserva->hora?></td>
                                    <td><?= $reserva->fecha_vuelo?></td>
                                    <td><?= $reserva->diferencia?></td>
                                    <td><?= $reserva->geo_pais?></td>
                                    <td><?= $reserva->codigo_pais?></td>
                                    <td><?= $reserva->origen?></td>
                                    <td><?= $reserva->destino?></td>
                                    <td><?= $reserva->cant_pasajero?></td>
                                    <td><?= $reserva->total_pagar?></td>
                                    <td><?= $reserva->cc_code?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><label>MEDIO PAGO</label></td>
                            <td><label>TOTAL</label></td>
                            <td colspan="8" style="text-align: right;">
                                <label>TARIFA TOTAL</label>
                            </td>
                            <td><label><?= $sum?></label></td>
                        </tr>
                        <?php foreach ($resumen as $key => $res): ?>
                            <tr>
                                <td style="text-align: center;"><?= $res->cc_code?></td>
                                <td style="text-align: right;"><?= $res->total?></td>
                                <td colspan="9" style="border-color: #ffffff;"></td>
                            </tr>
                        <?php endforeach ?>
                    </tfoot>
                </table>
            <?php endif ?>
        </div>
    </div>
    
</div>

<?php form_close() ?>