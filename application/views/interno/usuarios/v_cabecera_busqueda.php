<div class="box box-danger">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tbl_users" class="table table-condensed table-hover">
                <thead>
                <th>CCODIGO</th>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>EMAIL</th>
                <th>FECHA REGISTRO</th>
                <th>ESTADO</th>
                <th>ACCION</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($listaUsuarios->result() as $row) {
                        ?>
                        <tr>

                            <td><?= $row->codigo ?></td>
                            <td><?= $row->nombre ?></td>
                            <td><?= $row->apellido ?></td>
                            <td><?= $row->email ?></td>
                            <td>
                                <?php
                                $date = new DateTime($row->fecha_registro);
                                echo $date->format('d/m/Y');
                                ?>
                            </td>
                            <td><?= ($row->estado === 'Y') ? "ACTIVO" : "INACTIVO"; ?></td>
                            <td>
                                <?php
                                if ($row->estado === 'Y') {
                                    $icon = 'fa-user-times';
                                    $cssBtn = 'btn-danger';
                                    $title = 'Dar de baja al usuario';
                                } else {
                                    $cssBtn = 'btn-success';
                                    $icon = 'fa-user-plus';
                                    $title = 'Dar de alta al usuario';
                                }
                                ?>
                                <a href="<?= base_url() ?>interno/AdmUsuarios/CambiarEstado?id=<?= $row->id_usuario ?>" title="<?= $title ?>"><i class="fa <?= $icon ?>"></i></a>
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