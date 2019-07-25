<div class="box box-danger">
    <div class="box-header">
        <!-- <h1>Configuración del código de descuento web.<h1> -->
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>DESCUENTO</th>
                        <th>FECHA INICIO</th>
                        <th>FECHA FIN</th>
                        <th>ENTIDAD PARTICIPA</th>
                        <th>RUTA</th>
                        <th>CLASE</th>
                        <th>FECHA DE REGISTRO</th>
                        <th>USUARIO REGISTRÓ</th>
                        <th>ESTADO WEB</th>
                        <th colspane="2">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($res_all_desc->Result() as $item) { ?>
                        <tr id="fila<?=$item->id?>">
                            <td><?= $item->codigo ?></td>
                            <td><?= $item->monto ?></td>
                            <td><?= $item->fecha_inicio ?></td>
                            <td><?= $item->fecha_fin ?></td>
                            <td><?= $item->metodos_pago ?></td>
                            <td><?= $item->ruta ?></td>
                            <td><?= $item->clase ?></td>
                            <td><?= $item->fecha_registro ?></td>
                            <td><?= $item->usuario_registro ?></td>
                            <td><?= ($item->estado_web === 'Y') ? '<p class="text-green">ACTIVO</p>' : '<p class="text-red">INACTIVO</p>'; ?></td>
                            <!-- <td><button class="btn btn-reddit"><i class="fa fa-fw fa-pencil"></i></button></td> -->
                            <td><button title="ELIMINAR" class="btn btn-danger" data-record-title="<?=$item->codigo?>" data-record-id="<?=$item->id?>" data-target="#confirm-delete" data-toggle="modal"><i class="fa fa-fw fa-trash"></i></button></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="confirm-delete">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel"><strong>ELIMINAR REGISTRO</strong></h4>
            </div>
            <div class="modal-body">
                        <p>¿Está seguro de eliminar el código de registro <strong class="title"> </strong>?</p>
            </div>
                <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button> -->
                <!-- <button type="submit" class="btn btn-danger pull-right btn_confirma">Estoy seguro</button> -->
                <div class="modal-footer">
                    <button type="button"  class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-ok" data-record-id="">Delete</button>
                </div>
        </div>
    </div>
</div>