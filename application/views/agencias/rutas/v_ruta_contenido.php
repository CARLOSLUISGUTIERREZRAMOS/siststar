<?php if (count($rutas)>0): ?>
	<table id="table_main" class="table table-bordered table-striped">
		<thead>
             <tr>
                <th><center>Código</center></th>
                <th><center>Origen</center></th>
                <th><center>Destino</center></th>
                <th><center>Actualizado</center></th>
                <th colspan="3"><center>Acción</center></th>
             </tr>
       </thead>
       <tbody>
			<?php $i=0; ?>
			<?php foreach ($rutas as $key => $ruta): ?>
				<?php 
					$i++; 
					$ruta_codigo = $ruta->CodigoRuta.'|'.$ruta->CodigoCiudadOrigen.'|'.$ruta->CodigoCiudadDestino;
				?>
				<tr>
					<td class="campo_cadena"><?= $ruta->CodigoRuta?></td>
					<td id="origen_<?=$i?>"><?= $ruta->CodigoCiudadOrigen?></td>
					<td id="destino_<?=$i?>"><?= $ruta->CodigoCiudadDestino?></td>
					<td class="campo_cadena"><?= $ruta->HoraCalculo?></td>
					<td>
						<center>
							<div class="glyphicon glyphicon-pencil tarifas" style="cursor:pointer" id="<?= $ruta_codigo?>" title="Editar tarifas y vigencias"></div>
						</center>
					</td>
					<td>
						<center>
							<div class="glyphicon glyphicon-calendar temporadas" style="cursor:pointer" id="<?= $ruta_codigo?>" title="Editar temporadas"></div>
						</center>
					</td>
					<td>
						<center>
							<div class="glyphicon glyphicon-retweet procesar" style="cursor:pointer" id="<?= $ruta_codigo?>" title="Descargar tarifa"></div>
						</center>
					</td>
				</tr>
			<?php endforeach ?>
       </tbody>
	</table>
<?php endif ?>