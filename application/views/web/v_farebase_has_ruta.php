
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <button class="btn btn-primary btn-sm pull-right" onclick="mostrarConfirmacion()">
                    <i class="fa fa-save"></i> Guardar todos los cambios
                </button>
                <button type="button" class="btn btn-danger btn-sm">
                    <span class="badge">
                        <?php
                            if(count($lista_ruta_farebase->result())>0){
                                $ruta=$lista_ruta_farebase->result()[0]->ciudad_origen_codigo .' - '.$lista_ruta_farebase->result()[0]->ciudad_destino_codigo;
                                echo $ruta;
                                echo '<input type="hidden" value="'.$ruta.'"  id="ruta_name">';
                            }
                            else{
                                echo 'Sin Ruta';
                            }
                        ?>
                    </span>
                </button>
            </div>
            <div class="box-body">
                <?php
                $Msg = $this->session->flashdata('Msg');
                if (isset($Msg)) {
                    $Msg = $this->session->flashdata('Msg');
                    ?>
                    <div class="alert bg-light-blue alert-dismissible margin">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-warning"></i><?= $Msg ?></h4>
                    </div>
                    <?php
                }
                ?>
                <div id="MsgResultado"></div>
                <div class="table-responsive">
                    <!-- No borrar ID de Table -->
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td class="text-bold">Codigo</td>
                                <td class="text-bold">Ruta</td>
                                <td class="text-bold">Tarifa ADT</td>
                                <td class="text-bold">Emision Inicio - Fin</td>
                                <td class="text-bold">Vuelo Inicio - Fin</td>
                                <td class="text-bold">Estadias Mínimas y Máximas</td>
                                <td class="text-bold">Web</td>
                            </tr>
                        </thead>
                        <tbody class="tbody-listado">
                            <?php
                            foreach ($lista_ruta_farebase->result() as $row) {
                                echo validation_errors();
                                echo form_open('web/Farebase/ActualizarFarebase');
                                ?>

                                    <tr class="tr">
                                        <td><?= $row->farebase_id; ?></td>
                                        <td><?= $row->ciudad_origen_codigo .' - '.$row->ciudad_destino_codigo ?></td>
                                        <td><input type="text" value="<?= $row->tarifa_adt ?>" class="form-control" name="tarifa"></td>
                                        <td><input type="text" class="form-control pull-right rango_emision" name="fecha_emision_rango_ini_fin" value="<?= (new DateTime($row->emision_inicio))->format('d/m/Y').' - '.(new DateTime($row->emision_final))->format('d/m/Y')?>"></td>
                                        <td><input type="text" class="form-control pull-right rango_inicio" name="fecha_inivuelo_rango_ini_fin" value="<?= (new DateTime($row->inicio_vuelo))->format('d/m/Y').' - '.(new DateTime($row->final_vuelo))->format('d/m/Y')?>"></td>
                                        <td>
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Establecer estadías </h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div class="table-responsive">
                                                        <table id="detalleTable" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="7" class="text-center text-bold">Estadias minimas</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Lunes</td>
                                                                    <td>Martes</td>
                                                                    <td>Miercoles</td>
                                                                    <td>Jueves</td>
                                                                    <td>Viernes</td>
                                                                    <td>Sabado</td>
                                                                    <td>Domingo</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <td><input type="text" class="form-control" name="estadia_min_lunes" value="<?=$row->estadia_min_lunes?>"></td>
                                                            <td><input type="text" class="form-control" name="estadia_min_martes" value="<?=$row->estadia_min_martes?>"></td>
                                                            <td><input type="text" class="form-control" name="estadia_min_miercoles" value="<?=$row->estadia_min_miercoles?>"></td>
                                                            <td><input type="text" class="form-control" name="estadia_min_jueves" value="<?=$row->estadia_min_jueves?>"></td>
                                                            <td><input type="text" class="form-control" name="estadia_min_viernes" value="<?=$row->estadia_min_viernes?>"></td>
                                                            <td><input type="text" class="form-control" name="estadia_min_sabado" value="<?=$row->estadia_min_sabado?>"></td>
                                                            <td><input type="text" class="form-control" name="estadia_min_domingo" value="<?=$row->estadia_min_domingo?>"></td>
                                                            </tbody>
                                                        </table>
                                                        <div class="col-lg-4 col-lg-12">
                                                            <div class="input-group">
                                                                <span class="input-group-addon text-bold">Estadia Maxima</span>
                                                                <input type="number" class="form-control" name="estadia_maxima" value="<?=$row->estadia_maxima?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <select class="form-control" name="estado_web">
                                                <option value="1" <?= $row->estado_web == 1 ? 'selected' : '' ?> >SI</option>
                                                <option value="0" <?= $row->estado_web == 0 ? 'selected' : '' ?> >NO</option>
                                            </select>
                                        </td>
                                        <input type="hidden" value="<?= $row->farebase_id ?>" name="farebase">
                                        <input type="hidden" value="<?= $row->ruta_id ?>" name="ruta_id">
                                        <td>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
                                        </td>
                                    </tr>
                                <?php
                                echo form_close();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-primary pull-right" onclick="mostrarConfirmacion()">
                    <i class="fa fa-save"></i> Guardar todos los cambios
                </button>
            </div>
        </div>
    </div>
</div>
