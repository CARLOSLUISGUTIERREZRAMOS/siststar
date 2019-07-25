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
                                        Día 
                                        <select name="dia" form="form-datos" class="form-control input-sm" style="width: 115px; display: inline-block;">
                                            <option value="1">01</option>
                                            <option value="2">02</option>
                                            <option value="3">03</option>
                                            <option value="4">04</option>
                                            <option value="5">05</option>
                                            <option value="6">06</option>
                                            <option value="7">07</option>
                                            <option value="8">08</option>
                                            <option value="9">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                    </label>
                                </td>
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
                                        Canal 
                                        <select name="canal" form="form-datos" class="form-control input-sm" style="width: 95px; display: inline-block;">
                                            <option value="">Todos</option>
                                            <option value="computer">Web</option>
                                            <option value="phone">Movil</option>
                                            <option value="tablet">Tablet</option>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm" id="btn-venta-ruta" onclick="obterDataDiaria()">
                                        <i class="fa fa-building-o"></i> Ver Data
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        <i class="fa fa-bar-chart-o"></i> Ver Gráfico
                                    </button>
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <form id="form-datos"></form>
                </div>
                <div class="box-body">
                    <table id="tabla-ventas" class="table table-striped table-bordered">
                        <tbody></tbody>
                    </table>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>