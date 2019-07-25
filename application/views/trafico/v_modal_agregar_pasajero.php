<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">AGREGAR PASAJEROS</h4>
            </div>
            <div class="modal-body">
                <?php
                $attributes = array('class' => 'form-horizontal');
                echo form_open('trafico/Compartido/AgregarPasajero', $attributes)
                ?>
                <input type="hidden" id="id" name="id">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <button type="button" class="btn btn-success" id="add"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-lg-3">Apellidos</label>
                                    <label class="col-lg-3">Nombres</label>
                                    <label class="col-lg-3">Tipos</label>
                                </div>
                            </div> 
                            <div id="input_dinamico">

                            </div>
                        </div>
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

