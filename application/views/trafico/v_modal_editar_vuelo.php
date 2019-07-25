<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">MODIFICAR VUELO</h4>
            </div>
            <div class="modal-body">
                <?php
                $attributes = array('class' => 'form-horizontal');
                echo form_open('trafico/Compartido/ModificarVuelo', $attributes)
                ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha :</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" value="" name="fecha">
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label><i class=""></i> Vuelo</label>
                                <input type="text" id="vuelo" name="vuelo" class="form-control" required>
                            </div>
                        </div>
                    </div>    
                    <div class="row">      
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Desde</label>
                                <select id="origen" name="origen" class="form-control" required>
                                    <option selected value>  SELECCIONE  </option>
                                    <option value="CIX" >CHICLAYO</option>
                                    <option value="CJA" >CAJAMARCA</option>
                                    <option value="CUZ" >CUZCO</option>
                                    <option value="IQT" >IQUITOS</option>
                                    <option value="LIM" >LIMA</option>
                                    <option value="PCL" >PUCALLPA</option>
                                    <option value="TPP" >TARAPOTO</option>                                                                           
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Hacia</label>
                                <select id="destino" name="destino" class="form-control" required>
                                    <option disabled selected value>  SELECCIONE  </option>
                                    <option value="CIX" >CHICLAYO</option>
                                    <option value="CJA" >CAJAMARCA</option>
                                    <option value="CUZ" >CUZCO</option>
                                    <option value="IQT" >IQUITOS</option>
                                    <option value="LIM" >LIMA</option>
                                    <option value="PCL" >PUCALLPA</option>
                                    <option value="TPP" >TARAPOTO</option>                                                                           
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="vuelo_tipo" name="vuelo_tipo">
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

