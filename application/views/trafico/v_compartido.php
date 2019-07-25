<?php
date_default_timezone_set('America/Lima');
?>

<?php echo form_open("trafico/Compartido/agregar"); ?>
<div class="box-body">
    <input type="hidden" id="fecRegistro" name="fecRegistro" value="<?= date("Y-m-d H:i:s") ?>">

    <input type="hidden" name="tipo2" value="<?= (isset($tipo)) ? $tipo : "" ?>"/>
    
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label>Fecha :</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" value="<?php echo date("d/m/Y"); ?>" name="fecha">
                </div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label><i class=""></i> Vuelo</label>
                <input type="text" name="vuelo" maxlength="4" class="form-control" required>
            </div>
        </div>
    </div>    
    <div class="row">      
        <div class="col-lg-3">
            <div class="form-group">
                <label>From</label>
                <select name="from"class="form-control" required>
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
                <label>To</label>
                <select name="to"class="form-control" required>
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
    <div class="row">
        <div class="col-lg-9">
            <label>Pasajeros</label>
            <button type="button" class="btn btn-default" id="add"><i class="fa fa-plus" aria-hidden="true"></i></button>
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
<div class="col-lg-12">
    <div class="form-group">
        <button class="btn btn-primary pull-center btn-flat" onclick="javascript:this.form.submit();this.disabled= true;"><i class=""></i> Grabar </button>                    
    </div>
</div>
</div>
<?php echo form_close() ?>

