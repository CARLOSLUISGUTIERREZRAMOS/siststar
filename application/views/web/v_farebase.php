
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
                
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Codigo</td>
                                <td>Ruta</td>
                                <td>Tarifa</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($lista_ruta_farebase->result() as $row) {
                                ?>
                                <tr>
                                    <td><?= $row->farebase_id; ?></td>
                                    <td><?= $row->ruta_id; ?></td>
                                    <td><?= $row->tarifa; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
</div>