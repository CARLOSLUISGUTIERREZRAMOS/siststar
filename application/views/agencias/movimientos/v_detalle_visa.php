<table class="table" style="border: solid 1px #aba1a2a6;">
	<thead>
		<tr align="center" style="background: #e7e8ef;">
			<td colspan="7">VISA</td>
		</tr>
		<tr>
			<th>#</th>
			<th>Estado</th>
			<th>Card</th>
			<th>Card N°</th>
			<th>Descripción</th>
			<th>Monto Autorizado</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($visas)>0): ?>
			<?php foreach ($visas as $key => $visa): ?>
				<?php $color= $visa->status=='Authorized' ? '#2eee2e2b' : '' ?>
				<tr style="background: <?= $color?>;">
					<td><?= ($key+1) ?></td>
					<td><?= $visa->status?></td>
					<td><?= $visa->brand?></td>
					<td><?= $visa->card?></td>
					<td><?= $visa->action_description?></td>
					<td>$ <?= $visa->authorized_amount?></td>
				</tr>
			<?php endforeach ?>
		<?php else: ?>
			<tr align="center" style="background: #ADD23F;">
				<td colspan="7">SIN TRANSACCIONES</td>
			</tr>
		<?php endif ?>
	</tbody>
</table>