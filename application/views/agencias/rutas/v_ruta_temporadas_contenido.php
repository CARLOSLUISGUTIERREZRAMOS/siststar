<table id="table_temporadas" class="table table-bordered">
    <thead>
        <tr>
            <th><center>Farebase</center></th>
            <th><center>Tarifa</center></th>
            <th><center>Ene</center></th>
            <th><center>Feb</center></th>
            <th><center>Mar</center></th>
            <th><center>Abr</center></th>
            <th><center>May</center></th>
            <th><center>Jun</center></th>
            <th><center>Jul</center></th>
            <th><center>Ago</center></th>
            <th><center>Set</center></th>
            <th><center>Oct</center></th>
            <th><center>Nov</center></th>
            <th><center>Dic</center></th>
            <th><center>Marcar todos</center></th>
        </tr>
    </thead>
    <tbody id="lista_temporadas">
        <?php if (count($temporadas)>0): ?>
            <?php $farebases = array(); ?>
            <?php foreach ($temporadas as $key => $temporada): ?>
                <?php $farebases[] = $temporada->CodigoFareBase; ?>
                <tr>
                    <td><?= $temporada->CodigoFareBase?></td>
                    <td><?= number_format($temporada->Tarifa,2,'.',',')?></td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-0'?>" <?= $temporada->Enero == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-1'?>" <?= $temporada->Febrero == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-2'?>" <?= $temporada->Marzo == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-3'?>" <?= $temporada->Abril == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-4'?>" <?= $temporada->Mayo == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-5'?>" <?= $temporada->Junio == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-6'?>" <?= $temporada->Julio == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-7'?>" <?= $temporada->Agosto == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-8'?>" <?= $temporada->Setiembre == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-9'?>" <?= $temporada->Octubre == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-10'?>" <?= $temporada->Noviembre == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <input type="checkbox" id="<?= $id.'-'.$temporada->CodigoFareBase.'-11'?>" <?= $temporada->Diciembre == 1 ? 'checked' : ''?> />
                    </td>
                    <td>
                        <center>
                            <input type='checkbox' id="<?= $id.'-'.$temporada->CodigoFareBase.'-all'?>" class='todos'/>
                        <center>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php $str_fb = implode('*',$farebases); ?>
            <input type='hidden' id='idruta' value="<?= $id?>" />
            <input type='hidden' id='farebases' value="<?= $str_fb?>" />
        <?php endif ?>
    </tbody>
</table>