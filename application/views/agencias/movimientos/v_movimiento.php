<div class="box box-primary">
	<!-- <div class="box-header">
		<h3 class="box-title">Reporte Transacciones - PERU COMPRAS</h3>
	</div> -->
    <?php //dd($this->session->s_estado); ?>
	<div class="box-body">
        <form class="formulario_busqueda" id="formulario_busqueda" onsubmit="return false;">
            <div class="form-group row">
                <div class="col-sm-2 col-xs-12" style="padding-right: 0; padding-left: 0;">
                    <div class="input-daterange input-group" id="datepicker">
                        <div class="col-xs-6">
                            <label >Desde:</label> 
                            <input type="text" readonly="" tabindex="1" id="fecha_desde" name="fecha_desde" value="<?=$this->session->s_desde ? date("d/m/Y", strtotime($this->session->s_desde)) : ''?>" class ="form-control campo_fecha" />                               
                        </div>
                        <div class="col-xs-6">
                            <label >Hasta:</label> 
                            <input type="text" readonly="" tabindex="2" id="fecha_hasta" name="fecha_hasta" value="<?=$this->session->s_hasta ? date("d/m/Y", strtotime($this->session->s_hasta)) : ''?>" class ="form-control campo_fecha" />                               
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div class="col-xs-7">
                        <label >Apellido:</label> 
                        <input type="text" tabindex="3" id="campo_apellido_osce" name="apellido" value="<?=$this->session->s_apellido ? $this->session->s_apellido : ''?>" class="form-control campo_apellido" />                               
                    </div>
                    <div class="col-xs-5">
                        <label >RUC AGENCIA:</label> 
                        <input type="text" tabindex="4" id="ruc" name="ruc" value="<?=$this->session->s_ruc ? $this->session->s_ruc : ''?>" class ="form-control  campo_ruc" />
                    </div>
                </div>
                <div class="col-sm-7 col-xs-12">
                    <div class="col-xs-2">
                        <label >PNR:</label> 
                        <input type="text" tabindex="5" id="pnr" name="pnr" value="<?=$this->session->s_pnr ? $this->session->s_pnr : ''?>" class ="form-control campo_pnr" />
                    </div>
                    <div class="col-xs-3 ">
                        <label >Forma Pago:</label>
                        <select id="forma_pago" name="forma_pago" value="" class="form-control campo_estado">
                            <option value="">TODOS</option>
                            <option <?= $this->session->s_forma_pago == 'VI' ? 'selected' : '' ?> value="VI">VISA</option>
                            <option <?= $this->session->s_forma_pago == 'MC' ? 'selected' : '' ?> value="MC">MASTERCARD</option>
                            <option <?= $this->session->s_forma_pago == 'DC' ? 'selected' : '' ?> value="DC">DINERS CLUB</option>
                            <option <?= $this->session->s_forma_pago == 'AX' ? 'selected' : '' ?> value="AX">AMEX</option>
                            <option <?= $this->session->s_forma_pago == 'LC' ? 'selected' : '' ?> value="AX">LINEA CREDITO</option>
                            <!-- <option <?= $this->session->s_forma_pago == 'PP' ? 'selected' : '' ?> value="PP">PAYPAL</option>
                            <option <?= $this->session->s_forma_pago == 'SP' ? 'selected' : '' ?> value="SP">SAFETYPAY</option>
                            <option <?= $this->session->s_forma_pago == 'PE' ? 'selected' : '' ?> value="PE">PAGO EFECTIVO</option> -->
                        </select> 
                    </div>
                    <div class="col-xs-3 ">
                        <label >Estado:</label>
                        <select id="estado" name="estado" value="" class="form-control campo_estado">
                            <option value="">TODOS</option>
                            <option <?=$this->session->s_estado == '1' ? 'selected' : ''?> value="1">ACTIVOS</option>
                            <option <?=$this->session->s_estado == '0' ? 'selected' : ''?> value="0">ANULADOS</option>
                        </select> 
                    </div>
                    <div class="col-xs-1 ">
                        <label></label>
                        <button type="submit"  id="buscar_movimiento" name="buscar_movimiento" class="btn btn-primary margen_izq_movimiento" >
                            <i class="glyphicon glyphicon-list-alt"></i> Aceptar
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-inline">
                <div class="row cabecera">
                    <div class="col-sm-4 col-xs-12">
                        <label >Mostrar</label>
                        <select id="mostrar" name="mostrar" class="form-control campo_estado" form="formulario_busqueda">
                            <option value="20">20</option>
                            <option <?=$this->session->s_rows == '50' ? 'selected' : ''?> value="50">50</option>
                            <option <?=$this->session->s_rows == '100' ? 'selected' : ''?> value="100">100</option>
                            <option <?=$this->session->s_rows == '500' ? 'selected' : ''?> value="500">500</option>
                            <option <?=$this->session->s_rows == '1000' ? 'selected' : ''?> value="1000">1000</option>
                        </select>
                        <label >entradas</label>
                    </div>
                </div>
                
            </div>
        </form>

        <div class="contenido-reporte">
            <?php $this->load->view('agencias/movimientos/v_contenido_movimiento')  ?>
        </div>
	</div>
</div>

<div class="modal fade" id="ticket_electronico" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">   
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="printable" data-dismiss="modal" data-backfrop="false" id="divPrint"><i class="glyphicon glyphicon-print"></i></button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="glyphicon glyphicon-remove-circle"></i></button>
                <h3 class="box-title">Emisión de Ticket - Star Perú - AGENCIAS</h3>
            </div>
            <div class="modal-body center">
                <div id="eticket" class="print">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detalle_transaccion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">   
        <div class="modal-content ">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <span>Detalle de la transacción</span>
                </div>
                <div class="panel-body">
                    <div id="cuerpo_detalle"></div>
                </div>
                <div class="panel-footer">
                    <button type="button"  id="reenviar_ticket" class="btn btn-primary">Reenviar ticket</button>
                    <button type="button"  id="cancelar_reserva" class="btn btn-primary">Cancelar reserva</button>
                    <button type="button"  id="liquidado" class="btn btn-primary">Liquidado</button>  
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detalle_transaccion_visa" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">   
        <div class="modal-content ">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <span>Transacción de metodos de pago - Star Perú - AGENCIAS</span>
                </div>
                <div class="panel-body">
                    <div class="table-responsive"></div>
                </div>
            </div>
        </div>
    </div>
</div>