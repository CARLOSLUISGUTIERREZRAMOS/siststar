<?php
$date=Date('d-m-Y H:m:s');  
$cal=['','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SETIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0" );
header("Content-Type: application/force-download" );
header("Content-Type: application/octet-stream" );
header("Content-Type: application/download" );
header("Content-Type: application/vnd.ms-excel" );
header("content-disposition: attachment;filename=REPORTE_DE_VENTAS_MES_DE_$cal[$mes]_$date.xls" );

?>
<HTML lang="es-PE">
	<head>
		<TITLE>::. Exportacion de Datos .::</TITLE>
	</head>
	<body>
		<table BORDER=1 align="center" CELLPADDING=1 CELLSPACING=1>
			<TR>
				<TD width="100"><strong>ID_RESERVA</strong></TD>
				<TD><strong>CC_CODE</strong></TD>
				<TD><strong>COD_RESERVA</strong></TD>
				<TD><strong>NOMBRE</strong></TD>
				<TD><strong>APELLIDO</strong></TD>
				<TD width="150"><strong>FECHA_HORA</strong></TD>
				<TD width="150"><strong>PARTIDA</strong></TD>
				<TD><strong>DIFERENCIA</strong></TD>
				<TD><strong>HW</strong></TD>
				<TD><strong>PE</strong></TD>
				<TD><strong>EQ</strong></TD>
				<TD><strong>TOTAL</strong></TD>
				<TD width="150"><strong>NUM_TICKET1</strong></TD>
				<TD width="150"><strong>NUM_TICKET2</strong></TD>
				<TD width="150"><strong>NUM_TICKET3</strong></TD>
				<TD width="150"><strong>NUM_TICKET4</strong></TD>
				<TD width="150"><strong>NUM_TICKET5</strong></TD>
				<TD width="150"><strong>NUM_TICKET6</strong></TD>
				<TD width="150"><strong>NUM_TICKET7</strong></TD>
				<TD width="150"><strong>NUM_TICKET8</strong></TD>
				<TD width="150"><strong>NUM_TICKET9</strong></TD>
			</TR>
		<?php
			// if (count($reservas)>0) {
			if($reservas->count()>0){
				foreach ($reservas->get() as $l) { ?>
					<tr>
						<td><?=$l->id?></td>
						<td><?=$l->cc_code?></td>
						<td><?=$l->pnr?></td>
						<td><?=$l->nombres?></td>
						<td><?=$l->apellidos?></td>
						<td><?=$l->fecha_registro?></td>
						<td><?=$l->fechahora_salida_tramo_ida?></td>
						<td><?=$l->diferencia?></td>
						<td><?=number_format($l->hw,2)?></td>
						<td><?=number_format($l->eq,2)?></td>
						<td><?=number_format($l->pe,2)?></td>
						<td><?=number_format($l->total_pagar,2)?></td>
						<?php 
						if (count($l->detalles)>0) {
							$j=0;
							foreach ($l->detalles as $key => $detalle) {
								$j++; 
							?>
								<td><?=$detalle->num_ticket?></td>
							<?php
							}
							for ($i=($j+1); $i <=9 ; $i++) { ?>
								<td></td>
							<?php
							}
						}
						else{ ?>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						<?php 
						} 
						?>
					</tr>
		<?php 
				} 
			}
			else{
			?>
				<tr align="center"><td colspan="21">No hay registro</td></tr>
			<?php
			}
		?>
		</table>
	</body>
</html>