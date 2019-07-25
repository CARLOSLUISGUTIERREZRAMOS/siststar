
    <?= form_open('web/Descuento/Registrar') ?>
        <div class="row">

            <div class="col-md-2">
                <div class="form-group">
                    <label>Código de descuento:</label>

                    <div class="input-group">
                        <input style="text-transform:uppercase;" name="codigo_descuento"  type="text" class="form-control text-right" placeholder="Ingrese el código" required>
                        <small>*Debe ser previamente configurado a través de la terminal críptica.</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Descuento:</label>
                    <div class="input-group">
                        <input name="porcentaje_descuento" type="number" class="form-control text-right" placeholder="Ingrese descuento" required>
                        <small>*Porcentaje descuento. Ejm: 25.50%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label>Elija el rango de fecha:</label>

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input name="rango_fecha" type="text" class="form-control pull-left" id="rango_aplica_descuento">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Establezca rutas: </label>
                    <select name="ruta[]" class="form-control select2" multiple="multiple" data-placeholder="Seleccione" style="width: 100%;" required>
                        <option value="LIMPCL">LIM-PCL</option>
                        <option value="PCLLIM">PCL-LIM</option>
                        <option value="LIMIQT">LIM-IQT</option>
                        <option value="IQTLIM">IQT-LIM</option>
                        <option value="LIMCJA">LIM-CJA</option>
                        <option value="CJALIM">CJA-LIM</option>
                        <option value="LIMCIX">LIM-CIX</option>
                        <option value="CIXLIM">CIX-LIM</option>
                        <option value="LIMCUZ">LIM-CUZ</option>
                        <option value="CUZLIM">CUZ-LIM</option>
                        <option value="LIMTPP">LIM-TPP</option>
                        <option value="TPPLIM">TPP-LIM</option>
                        <option value="TPPIQT">TPP-IQT</option>
                        <option value="IQTTPP">IQT-TPP</option>
                        <option value="IQTPCL">IQT-PCL</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Establezca clases: </label>
                    <select name="clase[]" class="form-control select2" multiple="multiple" data-placeholder="Seleccione" style="width: 100%;" required>
                        <option value="Y">Y</option>
                        <option value="L">L</option>
                        <option value="V">V</option>
                        <option value="X">X</option>
                        <option value="W">W</option>
                        <option value="J">J</option>
                        <option value="Q">Q</option>
                        <option value="M">M</option>
                        <option value="E">E</option>
                        <option value="Z">Z</option>
                        <option value="O">O</option>
                        <option value="R">R</option>
                        <option value="P">P</option>
                        <option value="H">H</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Establezca métodos de pago: </label>
                    <select name="cc_code[]" class="form-control select2" multiple="multiple" data-placeholder="Seleccione" style="width: 100%;" required>
                        <option value="VI">VISA</option>
                        <option value="MC">MASTERCARD</option>
                        <option value="DC">DINERS</option>
                        <option value="AX">AMEX</option>
                        <option value="PE">PAGO EFECTIVO</option>
                        <option value="SP">SAFETYPAY</option>
                        <option value="PP">PAYPAL</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="box-footer">
            
                <button type="submit" class="btn btn-success pull-right">Guardar</button>
            
        </div>
        

    <?= form_close() ?>

