<table id="tbl_users" class="table table-condensed table-hover" style="width: 100%;">
    <div style="padding-bottom: 6px">
        <button  type="button" title="AGREGAR USUARIO" class="btn btn-success btn_agregar_usuario" data-tdefault oggle="modal" data-target="#myModal4" name="btnAgregarUsuario"  value="<?= $usuarios[0]['CodigoEntidad'] ?>">Agregar Usuario</button>
    </div>
    <thead >
        <tr>
            <th>#</th>
            <th class="hidden">Codigo Entidad</th>
            <th class="hidden">Codigo Personal</th>
            <th width="100">DNI</th>
            <th width="180">Apellidos</th>
            <th class="hidden">Apellido Paterno</th>
            <th class="hidden">Apellido Materno</th>
            <th width="200">Nombres</th>
            <th width="180">Email</th>
            <th width="180">Tel. Oficina</th>
            <th width="180">Celular</th>
            <th width="180">Tipo</th>
            <th width="180">Estado</th>
            <th width="180">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php   
        foreach ($usuarios as $key => $row) {
            ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td class="hidden"><?= $row->CodigoEntidad ?></td>
                <td class="hidden"><?= $row->CodigoPersonal ?></td>
                <td><?= $row->DNI ?></td>
                <td><?= $row->ApellidoPaterno . ' ' . $row->ApellidoMaterno ?></td>
                <td class="hidden"><?= $row->ApellidoPaterno ?></td>
                <td class="hidden"><?= $row->ApellidoMaterno ?></td>
                <td><?= $row->Nombres ?></td>
                <td><?= $row->Email ?></td>
                <td><?= ($row->TelefonoOficina) ? $row->TelefonoOficina : '-' ?></td>
                <td><?= $row->Celular ?></td>
                <td><?= $row->Tipo ?></td>
                <td><?= ($row->EstadoRegistro == 1) ? '<span class="label label-success">ACTIVO</span>' : '<span class="label label-danger">INACTIVO</span>'; ?></td>
                <td>
                    <?php
                    if ($row->EstadoRegistro == 1) {
                        $cssBtn = 'btn-danger';
                        $icon = ' fa-arrow-circle-up';
                        $title = 'Desactivar Usuario';
                        $color = 'green';
                    } else {
                        $cssBtn = 'btn-success';
                        $icon = ' fa-arrow-circle-down';
                        $title = 'Activar Usuario';
                        $color = 'red';
                    }
                    ?>
                    <span title="<?= $title ?>" id="<?= $row->CodigoPersonal ?>" name="<?= $row->EstadoRegistro ?>" style="cursor: pointer; color: <?= $color ?>; margin-right: 5px;" class="estado-usuario">
                        <i class="fa <?= $icon ?> fa-lg"></i>
                    </span>
                    <span class="resetear-password" id="<?= $row->CodigoPersonal ?>" title="Resetear Contraseña" style="cursor: pointer;">
                        <i class="fa fa-gear fa-lg"></i>
                    </span>
                    <span class="btn_editar_usuario" id="<?= $row->CodigoPersonal ?>" title="Editar Usuario" name="btnEditarUsuario"  style="cursor: pointer;">
                        <i class="fa fa-pencil fa-lg text-blue"></i>
                    </span>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<?php $this->load->view('/agencias/usuario/v_modal_editar_usuario'); ?>  
<?php $this->load->view('/agencias/usuario/v_modal_agregar_usuario'); ?>  