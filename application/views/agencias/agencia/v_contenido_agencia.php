<table id="tbl_users" class="table table-condensed table-hover">
    <thead>
        <tr>
            <th width="40">RUC</th>
            <th width="200">Razon Social</th>
            <th width="200">Nombre Comercial</th>
            <th width="180">Dirección</th>
            <th width="20">Ciudad</th>
            <th width="150">Representante</th>
            <th width="100">Teléfono</th>
            <th width="100">Crédito</th>
            <th width="100">Estado</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($entidades as $row) {
            ?>
            <tr>

                <td><?= $row->RUC ?></td>
                <td><?= $row->RazonSocial ?></td>
                <td align="center"><?= ($row->NombreComercial) ? $row->NombreComercial : '-' ?></td>
                <td><?= $row->Direccion ?></td>
                <td><?= $row->CodigoCiudad ?></td>
                <td><?= $row->Nombres.' '.$row->ApellidoPaterno ?></td>
                <td align="center"><?= ($row->TelefoniaOficina) ? $row->TelefoniaOficina : '-' ?></td>
                <td align="center">
                    <span class="asignar_credito" style="cursor: pointer;" id="<?= $row->CodigoEntidad ?>" name="<?= $row->Linea ?>" title="Doble click para asignar Linea de Crédito">$ <?= $row->Linea ?></span>
                </td>
                <td><?= ($row->EstadoRegistro == 1) ? '<span class="label label-success">ACTIVO</span>' : '<span class="label label-danger">INACTIVO</span>'; ?></td>
                <td>
                    <?php
                    if ($row->EstadoRegistro == 1) {
                        $cssBtn = 'btn-success';
                        $icon = ' fa-arrow-circle-up';
                        $title = 'Desactivar Agencia';
                        $color = 'green';
                    } else {
                        $cssBtn = 'btn-danger';
                        $icon = ' fa-arrow-circle-down';
                        $title = 'Activar Agencia';
                        $color = 'red';
                    }
                    ?>
                    <button class="btn <?= $cssBtn ?> btn-sm btn-estado-agencia" style="margin-right: 5px;" title="<?= $title ?>" id="<?= $row->CodigoEntidad?>" name="<?= $row->EstadoRegistro?>">
                        <i class="fa <?= $icon ?> fa-lg"></i>
                        <!-- <span  style="cursor: pointer; color: ; ">
                        </span> -->
                    </button>
                    <a href="<?= base_url() ?>agencias/Agencias/Usuarios?CodigoEntidad=<?= $row->CodigoEntidad ?>" title="Visualizar Usuarios" class="btn btn-primary btn-sm">
                        <span class="fa fa-users fa-lg"></span>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>