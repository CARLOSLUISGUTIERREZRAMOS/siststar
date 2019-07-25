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
                        <strong>Desde: </strong><span class="SpanDinamic"><?= $row->origen ?></span><br>
                        <strong>Hacia: </strong><span class="SpanDinamic"><?= $row->destino ?></span><br>
                        <?php
                    }
                    ?>
                </address>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tbl_users" class="table table-condensed table-hover">
                <thead>
                <th class="hidden">ID</th>
                <th>APELLIDOS</th>
                <th>NOMBRES</th>
                <th>TIPO</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($listaPasajeros->result() as $row) {
                        ?>
                        <tr>
                            <td class="hidden"><?= $row->id ?></td>
                            <td><?= $row->apellidos ?></td>
                            <td><?= $row->nombres ?></td>
                            <td><?= $row->tipo ?></td>
                            <?php
                        }
                        ?>
            </table>
        </div>
    </div>
</div>

