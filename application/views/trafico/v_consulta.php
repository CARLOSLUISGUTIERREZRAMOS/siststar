<?php (isset($tabla)) ? $tabla : "" ?>
<div class="box box-danger">
    <div class="box-header">

        <div class="box-body">
            <div class="row">   
                <?php echo form_open("trafico/Compartido/BuscarVuelos"); ?>
                <table id="" class="table table-condensed table-hover">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>FECHA INICIAL - FECHA FINAL</label>                                                    
                            <div class="input-group input-group-sm">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="daterangepicker" name="daterangepicker" value="<?= (isset($fec)) ? $fec : "" ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>TIPO</label>
                            <select name="tipo2" class="form-control" required>
                                <option selected value>  SELECCIONE  </option>
                                <?php if (isset($tipo2)) { ?>
                                    <option value="cobrar" <?php echo ($tipo2 == 'cobrar') ? 'selected' : ''; ?> >Cobrar</option>
                                    <option value="pagar" <?php echo ($tipo2 == 'pagar') ? 'selected' : ''; ?>>Pagar</option> 
                                <?php } else { ?>
                                    <option value="cobrar">Cobrar</option>
                                    <option value="pagar">Pagar</option> 
                                <?php } ?>
                            </select>                                
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>TABLA</label>
                            <select name="tabla" class="form-control" required>
                                <option selected value>  SELECCIONE  </option>
                                <?php if (isset($tabla)) { ?>
                                    <option value="detalle" <?php echo ($tabla == 'detalle') ? 'selected' : ''; ?>>Detalle</option>
                                    <option value="vuelo" <?php echo ($tabla == 'vuelo') ? 'selected' : ''; ?>>Vuelo</option>                                                                        
                                <?php } else { ?>
                                    <option value="detalle">Detalle</option>
                                    <option value="vuelo">Vuelo</option>                           
                                <?php } ?>
                            </select>                                
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="text"></label>
                            <div class="form-group">
                                <button class="btn btn-primary" title="Buscar" type="submit" value="Buscar" name="btnBuscarConsultas2"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </table>
                <?php echo form_close() ?>
            </div>
            <div class="row">   
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="tbl_users" class="table table-condensed table-hover">
                            <thead>
                            <th class="hidden">CONSULTAS</th>
                            <th class="hidden">TIPO</th>
                            </thead>
                            <tbody>
                                <?php if (isset($tabla)) { ?>
                                    <?php if ($tabla == 'detalle' && isset($datos_tdetalle)) { ?>
                                    <td class="text" align="center"><h3><b>TABLA DETALLE</b></h3></td>
                                    <?php foreach ($datos_tdetalle->result() as $row) { ?>
                                        <tr>
                                            <td>INSERT INTO `` (`id`,`vuelo_id`,`nombres`,`apellidos`,`tipo`) 
                                                VALUES (<?= $row->id_pasajero ?>,<?= $row->vuelo_id ?>,'<?= $row->nombres ?>','<?= $row->apellidos ?>','<?= $row->tipo ?>');                                        
                                            </td>
                                            <td class="hidden"><?= $row->tipoCP ?></td>

                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <td class="text" align="center"><h3><b>TABLA VUELO</b></h3></td>
                                    <?php foreach ($datos_tvuelo->result() as $row) { ?>
                                        <tr>
                                            <td>INSERT INTO `` (`id`,`fecha`,`vuelo`,`origen`,`destino`,`fecha_registro`,`ip`,`usuario_registro`) 
                                                VALUES (<?= $row->id_vuelo ?>,'<?= $row->fecha ?>','<?= $row->vuelo ?>','<?= $row->origen ?>','<?= $row->destino ?>','<?= $row->fecha_registro ?>','<?= $row->ip ?>','<?= $row->usuario_registro ?>');
                                            </td>
                                            <td class="hidden"><?= $row->tipoCP ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>    
                            <?php } else { ?>
                                <td>    </td>
                            <?php } ?>    
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
