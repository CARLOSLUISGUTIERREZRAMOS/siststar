<div class="box box-danger">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="" class="table table-condensed table-hover">
                <form action="<?= base_url() . "trafico/Compartido/BuscarVuelos" ?>" method="POST">                
                    <input type="hidden" name="tipo2" value="<?= (isset($tipo2)) ? $tipo2 : "" ?>">
<!--                    <form action="<?= base_url() . 'trafico/Compartido/BuscarVuelos' ?>" method="POST">                -->
                        <div class="form-group">
                            <label>FECHA INICIAL - FECHA FINAL</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="daterangepicker" name="daterangepicker" value="<?= (isset($fec)) ? $fec: "" ?>">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" value="Buscar" name="btnBuscar"><i class="fa fa-search"></i></button>
                    <button class="btn btn-success" type="submit" value="Excel" name="btnExcel"><i class="fa fa-download"></i></button>
                    </form>
            </table>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tbl_users" class="table table-condensed table-hover">
                <thead>
                <th class="hidden">ID</th>
                <th>FECHA</th>
                <th>VUELO</th>
                <th>FROM</th>
                <th>TO</th>
                <th>PASAJEROS</th>
                <th class="hidden">TIPO</th>
                <th>DETALLE</th>
                <th>EDITAR</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($listaIngresados->result() as $row) {
                        ?>
                        <tr>
                            <td class="hidden"><?= $row->id ?></td>
                            <td><?php
                                $date = new DateTime($row->fecha);
                                echo trim($date->format('d/m/Y'));
                                ?></td>
                            <td><?= $row->vuelo ?></td>
                            <td><?= $row->origen ?></td>
                            <td><?= $row->destino ?></td>
                            <td><?= $row->pasajeros ?></td>
                            <td class="hidden"><?= $row->tipo ?></td>
                            <td class="mailbox-name"><a class="link" href="<?= base_url() ?>trafico/Compartido/VerDetalle?id=<?= $row->id ?>"><i class="fa fa-list"></i></a></td>
                            <td>
                                <button type="button" title="EDITAR" class="btn btn-primary btn_edit_refund" data-tdefault oggle="modal" data-target="#myModal2" value="<?= $row->id ?>"><i class="fa fa-fw fa-edit"></i></button>
                            </td>   
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php $this->load->view('trafico/v_modal_editar_vuelo'); ?>  
