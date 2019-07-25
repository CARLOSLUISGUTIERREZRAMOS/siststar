<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3></h3>
            </div>
            <div class="box-body">
                <?php
                $ErrorCode = $this->session->flashdata('ErrorCode');
                if (isset($ErrorCode)) {
                    $ErrorMsg = $this->session->flashdata('ErrorMsg');
                    ?>
                    <div class="alert alert-danger alert-dismissible margin">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-warning"></i>  <?= $ErrorCode ?></h4>
                        <h5><?= $ErrorMsg ?></h5>
                    </div>
                    <?php
                }
                ?>
                <div class="table-responsive justify-content-md-center">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td class="text-bold">Codigo</td>
                                <td class="text-bold">Origen</td>
                                <td class="text-bold">Destino</td>
                                <td class="text-bold">Ultima Actualización</td>
                                <td class="text-bold">Acción</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($lista_rutas->result() as $row) {
                                echo form_open(base_url() . 'web/Farebase/TraerTarifasWebServicesKiu');
                                ?>
                                <tr>
                                    <td><?= $row->id; ?></td>
                                    <td><?= $row->ciudad_origen_codigo; ?></td>
                                    <td><?= $row->ciudad_destino_codigo; ?></td>
                                    <td width="150">
                                        <input type="text" name="today" value="<?=date('d/m/Y')?>" readonly class="form-control input-sm input-key date-calendar" autocomplete="off" style="background-color: white !important; cursor: pointer;">
                                    </td>
                                    <td width="150">
                                        <button type="submit" class="btn btn-primary" title="Descargar Tarifa"><i class="fa fa-download"></i></button>
                                        <a href="<?php echo base_url('web/Farebase/ListaRutaFareBase/'.$row->id);?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                    </td>

                                </tr>
                                <input type="hidden" value="<?= $row->id ?>" name="id_ruta">
                                <input type="hidden" value="<?= $row->ciudad_origen_codigo ?>" name="cod_origen">
                                <input type="hidden" value="<?= $row->ciudad_destino_codigo ?>" name="cod_destino">
                                <?php
                                echo form_close();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>