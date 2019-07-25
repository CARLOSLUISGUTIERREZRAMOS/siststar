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
                                        Inicio 
                                        <input type="text" name="date_inicio" form="form-datos" class="form-control input-sm date-calendar" style="width: 90px; display: inline-block;">
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        Final 
                                        <input type="text" name="date_fin" form="form-datos" class="form-control input-sm date-calendar" style="width: 90px; display: inline-block;">
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        Origen 
                                        <select name="origen" form="form-datos" class="form-control input-sm" style="width: 115px; display: inline-block;">
                                            <option value="">TODOS</option>
                                            <?php
                                            foreach ($lista_origen_ruta->result() as $row) {
                                                ?>
-                                                <option value="<?= $row->codigo ?>"><?= $row->nombre ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        Destino 
                                        <select name="destino" form="form-datos" class="form-control input-sm" style="width: 115px; display: inline-block;">
                                            <option value="">TODOS</option>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        Tipo 
                                        <select name="tipo" form="form-datos" class="form-control input-sm" style="width: 95px; display: inline-block;">
                                            <option value="">AMBOS</option>
                                            <option value="R">RT</option>
                                            <option value="O">OW</option>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm" id="btn-venta-ruta" onclick="obterDataRuta()">
                                        <i class="fa fa-building-o"></i> Ver Data
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        <i class="fa fa-bar-chart-o"></i> Ver GrÃ¡fico
                                    </button>
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <form id="form-datos"></form>
                </div>
                <div class="box-body">
                    <table id="tabla-ventas-rutas" border="0" class="table table-striped table-bordered" align="center">
                        <thead>
                            <tr style="background-color: #e2dfdb;">
                                <th style="text-align: center"><strong>Ruta</strong></th>
                                <th style="text-align: center"><strong>Tipo</strong></th>
                                <th style="text-align: center"><strong>Importe</strong> </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>