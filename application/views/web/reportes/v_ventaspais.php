<div class="box box-default">
    <div class="box-header">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label> Fecha Inicio</label>
                    <input type="text" name="desde" class="form-control date-calendar" form="form-datos">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label> Fecha Fin</label>
                    <input type="text" name="hasta" class="form-control date-calendar" form="form-datos">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div style="text-align: left; margin-top: 23px;">
                        <button class="btn btn-primary" id="btn-venta-pais" onclick="obterDataPais()">
                            <i class="fa fa-building-o"></i> Ver Data
                        </button>
                        <button class="btn btn-warning">Exportar</button>
                        <button class="btn btn-success">Ver Grafico</button>
                    </div>
                </div>
            </div>
        </div>
        <form id="form-datos"></form>
    </div>
    <div class="box-body">
        <table id="tbl_reportes" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="190"><strong>País</strong></th>
                    <th><strong>VISA</strong></th>
                    <th><strong>MasterCard</strong></th>
                    <th><strong>Diners</strong></th>
                    <th><strong>Americam Express</strong></th>
                    <th><strong>PayPal</strong></th>
                    <th><strong>SafetyPay</strong></th>
                    <th><strong>Pago Efectivo</strong></th>
                    <th><strong>Total</strong></th>
                    <th><strong>Ticket</strong></th>
                    <th><strong>Promedio</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>-</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>0.00</td>
                    <td></td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td>0</td>
                    <td>0.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>