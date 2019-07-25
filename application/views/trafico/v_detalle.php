<div class="box box-danger">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 invoice-col">
                <address>  
                    <?php
                    foreach ($detalleVuelo->result() as $row) {
                        ?>
                        <strong>Fecha: </strong><span class="SpanDinamic"><?= $row->fecha ?></span><br>
                        <strong>Vuelo: </strong><span class="SpanDinamic"><?= $row->vuelo ?></span><br>
                        <strong>From: </strong><span class="SpanDinamic"><?= $row->origen ?></span><br>
                        <strong>To: </strong><span class="SpanDinamic"><?= $row->destino ?></span><br>
                        <?php
                    }
                    ?>
                </address>
            </div>
        </div>
        <div>
            <button type="button" title="AGREGAR" class="btn btn-success btn_agregar" value="<?= $_GET['id'] ?>"><i class="fa fa-plus"></i></button>
        </div>
        <div class="table-responsive">
            <table id="tbl_users" class="table table-condensed table-hover">
                <thead>
                <th class="hidden">ID_PASAJERO</th>
                <th class="hidden">ID_VUELO</th>
                <th>APELLIDOS</th>
                <th>NOMBRES</th>
                <th>TIPO</th>
                <th>EDITAR</th>
                <th>ELIMINAR</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($listaPasajeros->result() as $row) {
                        ?>
                        <tr>
                            <td class="hidden"><?= $row->id ?></td>
                            <td class="hidden"><?= $row->vuelo_id ?></td>
                            <td><?= $row->apellidos ?></td>
                            <td><?= $row->nombres ?></td>
                            <td><?= $row->tipo ?></td>
                            <td>
                                <button type="button" title="EDITAR" class="btn btn-primary btn_edit_refund" data-tdefault oggle="modal" data-target="#myModal" value="<?= $row->id ?>"><i class="fa fa-fw fa-edit"></i></button>
                            </td> 
                            <td><a class="btn btn-danger" href="<?= base_url() ?>trafico/Compartido/EliminarPasajeroDetalle?id=<?= $row->id ?>&vuelo_id=<?= $row->vuelo_id ?>"><i class="fa fa-trash"></i></a></td>                          

                        </tr>   
                        <?php
                    }
                    ?>

            </table>

        </div>
    </div>
</div>

<?php $this->load->view('trafico/v_modal_editar_trafico'); ?>  
<?php $this->load->view('trafico/v_modal_agregar_pasajero'); ?>  
