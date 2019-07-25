<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel"><strong>EDITAR USUARIOS</strong></h4>
            </div>
            <div class="modal-body">
                <?php
                $attributes = array('class' => 'form-horizontal','id'=>'modal-form-usuario');
                echo form_open('agencias/Agencias/EditarUsuario', $attributes)
                ?>
                <input type="hidden" id="codigoEntidad" name="codigoEntidad">
                <input type="hidden" id="codigoPersonal" name="codigoPersonal">
                <div class="form-group row">
                    <label for="dni" class="col-sm-2 col-form-label">DNI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="dni" name="dni" maxlength="8" required="" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="apePat" class="col-sm-2 col-form-label">Apellido Paterno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="apePat" name="apePat" style="text-transform:uppercase;" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="apeMat" class="col-sm-2 col-form-label">Apellido Materno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="apeMat" name="apeMat" style="text-transform:uppercase;">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nombres" name="nombres" style="text-transform:uppercase;" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="telefono" class="col-sm-2 col-form-label">Tel. Oficina</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="telefono" name="telefono" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="celular" class="col-sm-2 col-form-label">Celular</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="celular" maxlength="9" name="celular" value=""  required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tipo" class="col-sm-2 col-form-label">Tipo</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="tipo" id="tipo" required="">
                            <option value="administrador" selected>Administrador</option>
                            <option value="counter">Counter</option>
                        </select>
                    </div>
                </div>
            </div>            
        </div>

        <div class="box-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Descartar Cambios</button>
            <button type="Submit" class="btn btn-primary  pull-right">Guardar</button>
        </div>
        <?= form_close() ?>
    </div>

</div>

