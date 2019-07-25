
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Criterios de Busqueda</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
    </div>
    <div class="box-body">
        <?= form_open('ecommerce/ReporteTransacciones/Buscar', ['id' => 'transacciones_form']) ?>
        <div class="row invoice-info">
            <div class="col-lg-2 invoice-col">
                <div class="form-group">
                    <label>Método de Pago</label>
                    <select class="form-control" name="cc_code">
                        <option value="">TODOS</option>
                        <option <?= set_value('cc_code') == 'VI' ? 'selected' : '' ?> value="VI">VISA</option>
                        <option <?= set_value('cc_code') == 'MC' ? 'selected' : '' ?> value="MC">MASTERCARD</option>
                        <option <?= set_value('cc_code') == 'DC' ? 'selected' : '' ?> value="DC">DINERS CLUB</option>
                        <option <?= set_value('cc_code') == 'AX' ? 'selected' : '' ?> value="AX">AMEX</option>
                        <option <?= set_value('cc_code') == 'PP' ? 'selected' : '' ?> value="PP">PAYPAL</option>
                        <option <?= set_value('cc_code') == 'SP' ? 'selected' : '' ?> value="SP">SAFETYPAY</option>
                        <option <?= set_value('cc_code') == 'PE' ? 'selected' : '' ?> value="PE">PAGO EFECTIVO</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-2 invoice-col">
                <div class="form-group">
                    <label>Estado</label>
                    <select class="form-control" name="estado">
                        <option value="">TODOS</option>
                        <option <?= set_value('estado') == "0" ? 'selected' : '' ?> value="0">Sin boletos</option>
                        <option <?= set_value('estado') == 1 ? 'selected' : '' ?> value="1">Con boletos</option>
                        <option <?= set_value('estado') == 2 ? 'selected' : '' ?> value="2" >
                            Pagado sin boletos
                        </option>
                        <option <?= set_value('estado') == 3 ? 'selected' : '' ?> value="3" >
                            Prox. al embarque < 4d
                        </option>
                        <option <?= set_value('estado') == 4 ? 'selected' : '' ?> value="4" >
                            Prox. al embarque < 3d
                        </option>
                        <option <?= set_value('estado') == 5 ? 'selected' : '' ?> value="5" >
                            Prox. al embarque < 2d
                        </option>
                        <option <?= set_value('estado') == 6 ? 'selected' : '' ?> value="6" >
                            Prox. al embarque < 24h
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 invoice-col">
                <div class="form-group">
                    <label>Nacionalidad</label>
                    <select class="form-control" name="nacionalidad">
                        <option value="">Todos</option>
                        <option <?= set_value('nacionalidad') == 43 ? 'selected' : '' ?> value="43">Nac.</option>
                        <option <?= set_value('nacionalidad') == 'EX' ? 'selected' : '' ?> value="EX">Ext.</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 invoice-col">
                <div class="form-group">
                    <label for="fecha">Inicio - Final</label>
                    <input type="text" id="rango_ini_fin" class="form-control pull-right rango_ini_fin" name="rango_ini_fin" value="<?= set_value('rango_ini_fin') ?>">
                </div>
            </div>
            <div class="col-lg-2 invoice-col">
                <div class="form-group">
                    <label for="apellido">Ap. Paterno</label>
                    <input type="text" name="apellidos" class="form-control" id="apellido" value="<?= set_value('apellidos') ?>">
                </div>
            </div>
            <div class="col-lg-1 col-xs-6 invoice-col">
                <div class="form-group">
                    <label for="pnr">PNR</label>
                    <input type="text" name="pnr" class="form-control" id="pnr" value="<?= set_value('pnr') ?>">
                </div>
            </div>
            <div class="col-lg-1 col-xs-6 invoice-col">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" name="id" class="form-control" id="id" value="<?= set_value('id') ?>">
                </div>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-lg-2 col-xs-6 invoice-col">
                <div class="form-group">
                    <label for="id">N° Doc</label>
                    <input type="text" class="form-control" id="num_documento" name="num_documento" placeholder="Ingrese DNI, CEX o PP" value="<?= set_value('num_documento') ?>">
                </div>
            </div>
            <div class="col-lg-2 col-xs-6 invoice-col">
                <div class="form-group">
                    <label for="canal">Canal</label>
                    <select class="form-control" name="canal">
                        <option value="">Todos</option>
                        <option <?= set_value('canal') == 'computer' ? 'selected' : '' ?> value="computer">Web</option>
                        <option <?= set_value('canal') == 'phone' ? 'selected' : '' ?> value="phone">Movil</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-xs-6 invoice-col">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" value="<?= set_value('email') ?>">
                </div>
            </div>
            <div class="col-lg-2 col-xs-6 invoice-col">
                <div class="form-group">
                    <label for="descuento_id">Descuentos</label>
                    <select class="form-control" name="descuento_id">
                        <option value="">Todos</option>
                        <?php foreach ($descuentos as $key => $descuento): ?>
                            <option <?= set_value('descuento_id') == $descuento->id ? 'selected' : '' ?> value="<?= $descuento->id ?>"><?= $descuento->codigo ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 invoice-col">
                <div class="form-group">
                    <label></label>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-fw fa-search"></i> Buscar</button>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?php if (isset($PROCESO_BUSQUEDA) && $PROCESO_BUSQUEDA === TRUE) { ?>
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <div class="box-body">
                <table align="center" class="table" style="margin-bottom: 15px; border-top: 2px solid #d2d6de; border-bottom: 2px solid #d2d6de;">
                    <tbody>
                        <tr>
                            <td>
                                <div style="width: 23px; height: 23px; background-color: #feb28082;"></div>
                            </td>
                            <td>No genero Ticket</td>
                            <td>
                                <div style="width: 23px; height: 23px; background-color: #2183e88a;"></div>
                            </td>
                            <td>Prox. al embarque < 4d</td>
                            <td>
                                <div style="width: 23px; height: 23px; background-color: #a9f5aa;"></div>
                            </td>
                            <td>Prox. al embarque < 3d</td>
                            <td>
                                <div style="width: 23px; height: 23px; background-color: #ffff9b;"></div>
                            </td>
                            <td>Prox. al embarque < 2d</td>
                            <td>
                                <div style="width: 23px; height: 23px; background-color: #fe00008a;"></div>
                            </td>
                            <td>Prox. al embarque < 24h</td>
                            <td>
                                <div style="width: 23px; height: 23px; background-color: #7869d8;"></div>
                            </td>
                            <td>Transaccion sospechosa</td>
                        </tr>
                    </tbody>
                </table>
                <table id="tbl_report_trans" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>COD</th>
                            <th>Apellidos/Nombres</th>
                            <th>PX</th>
                            <th>Ori/Des</th>
                            <th>Cardholder</th>
                            <th>Total</th>
                            <th>ETK</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tarifa = 0;
                        $total_pagar = 0;
                        $trans = 0;
                        $tikets = 0;
                        $img_array = ["VI" => "vi.png", "MC" => "mc.png", "AX" => "ax.png", "DC" => "dc.jpg", "PP" => "pp.png", "SP" => "sp.jpg", "PE" => "pe.jpg", "TC" => "visa_net.png"];
                        $img_name = ["VI" => "", "MC" => "", "AX" => "", "DC" => 'style="height:50px;"', "PP" => "", "SP" => 'style="height:45px;"', "PE" => 'style="height:25px;"', "TC" => 'style="height:30px;"'];
                        foreach ($Transacciones->Result() as $campo) {
                            $trans++;
                            $tikets = +$tikets + $campo->tik;
                            if ($campo->estado == 1) {
                                $tarifa = $tarifa + $campo->eq;
                                $total_pagar = $total_pagar + $campo->total_pagar;
                            }
                            if ($campo->s_estado == 1 || $campo->pe_estado == 1 || $campo->v_estado == 1 || $campo->vn_estado == 1 || $campo->pp_estado == 1 || $campo->tc_estado == 1) {
                                $pintar = 'style="background-color: #feb28082;"';
                            } else {
                                if ($campo->faltante > 0) {
                                    if ($campo->faltante == 4) {
                                        $pintar = 'style="background-color: #2183e88a;"';
                                    } else if ($campo->faltante == 3) {
                                        $pintar = 'style="background-color: #a9f5aa;"';
                                    } else if ($campo->faltante == 2) {
                                        $pintar = 'style="background-color: #ffff9b;"';
                                    } else if ($campo->faltante == 1) {
                                        $pintar = 'style="background-color: #fe00008a;"';
                                    } else {
                                        $pintar = '';
                                    }
                                } else {
                                    $pintar = '';
                                }
                            }
                            ?>
                            <tr <?= $pintar ?> >
                                <td><?= (new DateTime($campo->fecha_registro))->format('d/m/Y H:i') ?></td>
                                <td>
                                    <b>ID Reserva:</b> <?= $campo->id ?><br>
                                    <b>PNR:</b> <?= $campo->pnr ?><br>
                                </td>
                                <td>
                                    <?= $campo->apellidos . ' ,' . $campo->nombres ?><br>
                                    <b>Nacionalidad: </b><?= $campo->nacionalidad ?><br>
                                    <b>Ubicación: </b><?= $campo->geo_ciudad . ' - ' . $campo->geo_pais ?><br>
                                    <b>Email: </b><?= $campo->email ?><br>
                                    <?php if ($campo->ruc != 'NULL'): ?>
                                        <b>Ruc: </b><?= $campo->ruc ?><br>
                                        <?php
                                    endif;
                                    ?>
                                    <b>IP: </b><?= long2ip($campo->ip) ?><br>
                                    <?php if (!empty($campo->num_telefono)) { ?>
                                        <b>Tfno fijo: </b><?= $campo->num_telefono ?><br>
                                    <?php }
                                    if (!empty($campo->num_celular)) {
                                        ?>
                                        <b>N° Celular: </b><?= $campo->num_celular ?><br>

                                        <?php
                                    }
                                    ?>

                                </td>
                                <td>
                                    <b>A: </b><?= $campo->cant_adl ?><br>
                                    <b>N: </b><?= $campo->cant_chd ?><br>
                                    <b>B: </b><?= $campo->cant_inf ?><br>
                                </td>
                                <td>
                                    <?php
                                    if ($campo->cod_compartido_vuelo_ida === 'NO') {
                                        $name_cod_share_ida = '';
                                    } else {
                                        $name_cod_share_ida = $campo->cod_compartido_vuelo_ida;
                                    }
                                    if ($campo->cod_compartido_vuelo_retorno === 'NO') {
                                        $name_cod_share_ret = '';
                                    } else {
                                        $name_cod_share_ret = $campo->cod_compartido_vuelo_retorno;
                                    }
                                    if ($campo->tipo_viaje === 'R') {
                                        $img_rt = '<i class="fa fa-fw fa-exchange"></i>';
                                    } else {
                                        $img_rt = '<i class="fa fa-fw fa-long-arrow-right"></i>';
                                    }
                                    ?>
        <?= $campo->origen . ' - ' . $campo->destino . ' ' . $img_rt ?><br>
                                    <span class="label label-default pull-right"><?= $campo->num_vuelo_ida . ' ' . $name_cod_share_ida ?> </span><br>
                                    <i class="fa fa-fw fa-calendar"></i> <i class="fa fa-fw fa-long-arrow-right"></i><?= (new DateTime($campo->fechahora_salida_tramo_ida))->format('d/m/Y H:i') ?> <br>
        <?php if ($campo->tipo_viaje === 'R') { ?>
                                        <span class="label label-default pull-right"><?= $campo->num_vuelo_retorno . ' ' . $name_cod_share_ret ?></span><br>
                                        <i class="fa fa-fw fa-calendar"></i><i class="fa fa-fw fa-long-arrow-left"></i> <?= (new DateTime($campo->fechahora_salida_tramo_retorno))->format('d/m/Y H:i') ?> <br>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <!-- CARDHOLDER-->
        <?php if (empty($campo->cc_code)) { ?>
                                    <td>

                                        <div class="row invoice-info">
                                            <div class="col-md-12 invoice-col">
                                                <address>
                                                    <strong>RESERVA GENERADA DESDE KIU RES</strong><br>
                                                    Procesado desde el modulo "Pago de Reservas"<br>
                                                    <i class="fa fa-fw fa-clock-o"></i> Esperando pago
                                                </address>
                                            </div>
                                        </div>
                                    </td>
                                <?php } else {
                                    ?>
                                    <td style="text-align: center">
                                        <?php
                                        if ($campo->cc_code == "TC") {
                                            if ($campo->tc_card) {
                                                $name_img = $img_array[$campo->tc_card];
                                                $style_img = $img_name[$campo->tc_card];
                                            } else {
                                                if ($campo->tc_card_fallido) {
                                                    $name_img = $img_array[$campo->tc_card_fallido];
                                                    $style_img = $img_name[$campo->tc_card_fallido];
                                                } else {
                                                    $name_img = $img_array[$campo->cc_code];
                                                    $style_img = $img_name[$campo->cc_code];
                                                }
                                            }
                                        } else {
                                            $name_img = $img_array[$campo->cc_code];
                                            $style_img = $img_name[$campo->cc_code];
                                        }
                                        $estado = ($campo->tik != 0 AND $campo->estado == 1) ? 1 : 0;
                                        ?>
                                        <a id="<?= $campo->id ?>|<?= $campo->cc_code ?>" name="<?= $estado ?>|<?= $campo->id ?>|<?= $campo->pnr ?>" class="btn-metodo-pago" title="Click">
            <?= '<img src="' . base_url('/') . 'img/met_pago/ico_' . $name_img . '" ' . $style_img . ' >' ?>
                                        </a>
                                        <br>
                                        <span><?= $campo->actionholder ?></span><br>
                                        <label><?= $campo->cardholder ?></label>
                                    </td>
                                    <?php
                                }
                                ?>

                                <td>

        <?php if (!is_null($campo->monto)) { ?>

                                        <p>
                                            <span>$ <del><?= $campo->total ?></del></span>
                                        </p>
                                        <p>
                                            <span class="pull-right badge bg-aqua" title="Reserva generada con <?= $campo->monto ?>% de descuento ">
                                                <i class="fa fa-ticket"> <b><?= $campo->codigo ?> </b>  </i>   
                                            </span>
                                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i>  <?= $campo->monto ?>%</span>
                                        </p>
        <?php } ?>

                                    $ <?= $campo->total_pagar ?></td>
                                <td>
        <?php if ((int) $campo->estado === 1) { ?>
                                        <button class="btn btn-app btn_tkt" id='<?= $campo->id ?>'>
                                            <i class="fa  fa-tags"></i> Ver tickets
                                        </button>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    switch ($campo->dispositivo) {
                                        case 'phone':
                                            $fa_icon = 'fa-mobile-phone';
                                            $title = 'Compra realizada desde un móvil';
                                            break;
                                        case 'tablet':
                                            $fa_icon = 'fa-tablet';
                                            $title = 'Compra realizada desde una tablet';
                                            break;
                                        case 'computer':
                                            $fa_icon = ' fa-laptop';
                                            $title = 'Compra realizada desde una laptop o pc';
                                            break;
                                    }
                                    ?>
                                    <i class="fa fa-lg fa-fw <?= $fa_icon ?>" title="<?= $title ?>"></i>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot style="">
                        <tr>
                            <td colspan="6" style="text-align: right;"><b>Total tarifa:</b></td>
                            <td><b><?= '$ ' . $tarifa ?></b></td>
                            <td><b># Tickets:</b></td>
                            <td><b><?= $tikets ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: right;"><b>Total General:</b></td>
                            <td><b><?= '$ ' . $total_pagar ?></b></td>
                            <td><b>Transacciones:</b></td>
                            <td><b><?= $trans ?></b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-reservadetalle" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"><?php
                        $image_properties = array(
                            'src' => 'img/LogoStar.png',
                            'width' => '30%',
                            'height' => '30%',
                        );
                        echo img($image_properties);
                        ?>
                    </h4>
                </div>
                <div class="modal-body" id="campo_modal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal modal-danger fade" id="modal-cancelar_reserva_confirma" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"><?php
                        $image_properties = array(
                            'src' => 'img/LogoStar.png',
                            'width' => '30%',
                            'height' => '30%',
                        );
                        echo img($image_properties);
                        ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <p>Esta seguro de eliminar esta reserva... </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" id="btn_cancelar_del">Cerrar</button>
                    <button type="button" class="btn btn-outline" id="btn_acepto_del">SI</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-warning fade" id="modal_generar_boletos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Generación de boletos.</h4>
                </div>
                <div class="modal-body">
                    <p>¿Seguro de generar boletos para esta reserva?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline" id="btn_acepta_genboletos">Aceptar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade" id="modal-exito">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Mensaje de confirmación</h4>
                </div>
                <div class="modal-body">
                    <p id="mensaje_exito"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Entiendo</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-default fade" id="modal-boleto-enviado">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Boleto reenviado</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-danger fade" id="modal_inconsistencia">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Se encontro una inconsistencia...</h4>
                </div>
                <div class="modal-body">
                    <p id="texto_modal_danger"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Entiend</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal modal-default fade" id="modal_metodo_pago">
        <div class="modal-dialog" style="width: 700px;">
            <div class="modal-content">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center" style="padding-bottom: 0px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <?php
                        $image_properties = array(
                            'src' => 'img/logo_starperu.png',
                            'width' => '30%',
                            'height' => '30%',
                        );
                        echo img($image_properties);
                        ?>
                    </div>
                    <div class="panel-body" style="background: #f6f6f629;">
                        <div class="col-md-12">
                            <!-- <div class="row">
                                <div class="form-group">
                                    <label>Forzar medio de pago</label>
                                    <select name="medio_pago" class="form-control input-sm" style="max-width: 200px;">
                                        <option value="">SELECCIONAR</option>
                                        <option value="1">TARJETA</option>
                                        <option value="2">BANCO</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="row" id="form-panels">
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <?php
}
?>








