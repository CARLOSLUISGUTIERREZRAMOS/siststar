<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="table-responsive">
                <div class="box-header with-border">
                    <table class="table table-striped" style="margin-bottom: 0px;">
                        <thead>
                            <tr>
                                <td>
                                    <label>
                                        Mes 
                                        <select name="mes" form="form-datos" class="form-control input-sm" style="width: 115px; display: inline-block;">
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Setiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        Año 
                                        <select name="anio" form="form-datos" class="form-control input-sm" style="width: 115px; display: inline-block;">
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>

                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        Tipo 
                                        <select name="tipo" form="form-datos" class="form-control input-sm" style="width: 115px; display: inline-block;">
                                            <option value="0">Venta</option>
                                            <option value="1">Ticket</option>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        Medio
                                        <select name="medio" form="form-datos" class="form-control input-sm" style="width: 125px; display: inline-block;">
                                            <option value="">TOTAL</option>
                                            <option value="NO">E-COMMERCE</option>
                                            <!-- <option value="PC">PERÚ COMPRAS</option> -->
                                            <option value="P9">Vta Peruvian</option>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <div class="movil">
                                        <button class="btn btn-success btn-sm" id="btn-venta-mensual" onclick="obterDataMensual()">
                                            <i class="fa fa-building-o"></i> Ver Data
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="movil">
                                        <button class="btn btn-warning btn-sm">
                                            <i class="fa fa-bar-chart-o"></i> Ver Gráfico
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <form id="form-datos"></form>
                </div>
                <div class="box-body">
                    <table id="tabla-ventas" class="table table-striped table-bordered">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>