<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3></h3>
			</div>
			<div class="box-body">
				<div class="table-responsive justify-content-md-center">
					<?php $this->load->view('agencias/rutas/v_ruta_contenido'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editar_tarifas" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">   
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="glyphicon glyphicon-remove-circle"></i></button>
                <h3 class="box-title">Mantenimiento de clases por ruta - <span id="ruta"></span></h3>
            </div>
            <div class="modal-body center">
                <div class="box-body table-responsive">
                    <table id="table_tarifas" class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2"><center>Farebase</center></th>
                                <th rowspan="2"><center>Tarifa</center></th>
                                <th colspan="2"><center>Emisión</center></th>
                                <th colspan="2"><center>Vigencia</center></th>
                                <th colspan="2"><center>Estadía</center></th>
                                <th rowspan="2"><center>Web</center></th>
                            </tr>
                            <tr>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Min</th>
                                <th>Max</th>
                            </tr>
                        </thead>
                        <tbody id="lista_tarifas">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                	<button type="button"  id="guardar_tarifas" class="btn btn-primary">Guardar</button>
                </center>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade" id="editar_temporadas" tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-lg">   
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="glyphicon glyphicon-remove-circle"></i></button>
                <h3 class="box-title">Mantenimiento de clases por ruta - <span id="ruta2"></span></h3>
            </div>
            <div class="modal-body center">
                <div class="box-body table-responsive">
                </div>
            </div>
            <div class="modal-footer">
                <center><button type="button"  id="guardar_temporadas" class="btn btn-primary">Guardar</button></center>
            </div>
        </div>
	</div>
</div>
    
<div class="modal fade" id="tarifas_descargadas" tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-lg">   
		<div class="modal-content ">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="glyphicon glyphicon-remove-circle"></i></button>
		        <h3 class="box-title">Rutas descargadas - <span id="ruta3"></span></h3>
		    </div>
		    <div class="modal-body center">
		        <div class="box-body table-responsive">
		            <div id="lista_descargadas"></div>    
		        </div>
		    </div>
		</div>
	</div>
</div>