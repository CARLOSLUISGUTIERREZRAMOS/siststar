<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">MODIFICAR REGISTRO</h4>
            </div>
            <div class="modal-body">
                <?php
                $attributes = array('class' => 'form-horizontal');
                echo form_open('trafico/Compartido/ModificarTrafico', $attributes)
                ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
                        <div class="col-sm-10">
                            <input type="text" id="apellidos" name="apellidos" value="" class="form form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombres" class="col-sm-2 control-label">Nombres</label>
                        <div class="col-sm-10">
                            <input type="text" id="nombres" name="nombres" value="" class="form form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cboTipo" class="col-sm-2 control-label">Tipo</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="cboTipo" id="cboTipo">
                                <option>ADT</option>
                                <option>CHD</option>
                                <option>INF</option>
                        </div>
                    </div>                  
                    <input type="hidden" id="id_pasajero" name="id_pasajero">
                    <input type="hidden" id="id_vuelo" name="id_vuelo">

                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Descartar Cambios</button>
                    <button type="Submit" class="btn btn-primary  pull-right">Guardar</button>
                </div>
                <?= form_close() ?>
            </div>

        </div>
    </div>
</div>
</div>
</div>