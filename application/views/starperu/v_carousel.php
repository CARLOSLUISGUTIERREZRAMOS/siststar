<div class="box box-danger">
    <div class="box-header">
    	<button class="btn btn-success btn-sm btn-agregar-nuevo">
    		<span class="fa fa-plus"></span> Agregar nuevo
    	</button>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tbl_imagenes" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>IMAGEN</th>
                        <th>FECHA INICIO</th>
                        <th>FECHA FIN</th>
                        <th>LINK</th>
                        <th>PRIORIDAD</th>
                        <th>ESTADO</th>
                        <th>ACCION</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="modal modal-default fade" id="modal_starperu">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php
                        $image_properties = array(
                            'src' => 'img/logo_starperu.png',
                            'width' => '15%',
                            'height' => '15%',
                            'class' => 'pull-left',
                        );
                        echo img($image_properties);
                    ?>
                    <h4>Agregar Carousel de Imágenes</h4>
                </div>
                <div class="panel-body" style="background: #f6f6f629;">
                    <form id="form-datos" enctype="multipart/form-data"></form>
                    <div class="col-md-12">
                        <div class="row mensajes-error">
                            <div class="col-md-12">
                            </div>
                        </div>
                        <input type="hidden" name="tipo" value="1" id="tipo" form="form-datos">
                        <input type="hidden" name="url_img" id="url_img" form="form-datos">
                        <input type="hidden" name="estado_img" id="estado_img" form="form-datos">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Banner</label>
                                    <select name="banner" id="banner" class="form-control input-key" form="form-datos">
                                        <option value="1">Con fecha de caducidad</option>
                                        <option value="0">Sin vencimiento</option>
                                    </select>
                                </div>
                            </div>
                            <div class="fechas">
                            	<div class="col-md-4">
                                    <div class="form-group">
                                        <label> Fecha Inicio</label>
                                        <input type="text" name="desde" value="<?=date('d/m/Y')?>" readonly class="form-control input-key date-calendar" form="form-datos" autocomplete="off" data-req="1" style="background-color: white !important; cursor: pointer;">
                                        <input type="time" name="inicio" class="form-control input-key" value="<?=date('H:i:s')?>" min="00:00:01" max="23:59:59" step="1" form="form-datos" data-req="1">
                                    </div>
                            	</div>
                            	<div class="col-md-4">
    	                            <div class="form-group">
                                        <label> Fecha Fin</label>
                                        <input type="text" name="hasta" value="<?=date('d/m/Y')?>" readonly class="form-control input-key date-calendar" form="form-datos" autocomplete="off" data-req="1" style="background-color: white !important; cursor: pointer;">
                                        <input type="time" name="fin" class="form-control input-key" value="<?=date('H:i:s')?>" min="00:00:01" max="23:59:59" step="1" form="form-datos" data-req="1">
                                    </div>
                            	</div>
                                
                            </div>
                        <!-- </div>
                        <div class="row"> -->
                        	<div class="col-md-4">
	                            <div class="form-group">
	                                <label>Estado</label>
                                    <select name="estado" id="estado" class="form-control input-key" form="form-datos">
                                        <option value="1">Publicado</option>
                                        <option value="0">Por publicar</option>
                                    </select>
	                            </div>
                        	</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Campaña Promocional?</label>
                                    <select name="promocion" id="promocion" class="form-control input-key" form="form-datos">
                                        <option value="0">No</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Prioridad</label>
                                    <select name="prioridad" id="prioridad" class="form-control input-key" form="form-datos">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-4">
                                <label>Seleccionar Imagen</label>
                                <input type="file" name="imagen" id="imagen" class="form-control" form="form-datos" accept=".png,.jpeg,.jpg" data-req="1">
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label title="https://www.starperu.com/es/nombre-fichero.html">
                                            Nombre del fichero a direccionar
                                        </label>
                                        <input type="text" name="link" id="link" class="form-control input-key" form="form-datos" data-req="0">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Extensión</label>
                                            <select name="extension" id="extension" class="form-control input-key" form="form-datos">
                                                <option value="html">HTML</option>
                                                <option value="php">PHP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-imagen" class="hide">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-danger pull-right" data-dismiss="modal" style="margin-left: 5px;">
                                <span class="fa fa-remove"></span>
                                Cancelar
                            </button>
                            <button class="btn btn-sm btn-success pull-right">
                                <span class="fa fa-plus"></span>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_eliminar_registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><img src="http://35.238.63.231/star/img/Logotipo.png" alt=""></h5>
            </div>
            <div class="modal-body">
                <p id="TxtMsg">¿Esta seguro que desea eliminar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">
                    <i class="fa fa-trash"></i> Sí, entendido
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-minus-circle"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>


