<?php if (count($tarifas)>0): ?>
    <?php foreach ($tarifas as $key => $tarifa): ?>
        <?php
            $checked= $tarifa->estado_web==1 ? 'checked' : '';
            $farebases[] = $tarifa->CodigoFareBase;
            $monto = number_format($tarifa->Tarifa,2,'.',',');
        ?>
        <tr>
            <td><?=$tarifa->CodigoFareBase?></td>
            <td>
                <input type="text" value="<?= $monto?>" class="form-control" id="<?=$CodigoRuta.'-'.$tarifa->CodigoFareBase.'-tarifa'?>" size="4"/>
            </td>
            <td>
                <input type="text" value="<?= $tarifa->EmisionInicio?>" class="form-control campo_fecha datepicker" id="<?=$CodigoRuta.'-'.$tarifa->CodigoFareBase.'-emision0'?>" readonly/>
            </td>
            <td>
                <input type="text" value="<?= $tarifa->EmisionFinal?>" class="form-control campo_fecha datepicker" id="<?=$CodigoRuta.'-'.$tarifa->CodigoFareBase.'-emision1'?>" readonly/>
            </td>
            <td>
                <input type="text" value="<?= $tarifa->Inicio?>" class="form-control campo_fecha datepicker" id="<?=$CodigoRuta.'-'.$tarifa->CodigoFareBase.'-vigencia0'?>" readonly/>
            </td>
            <td>
                <input type="text" value="<?= $tarifa->Final?>" class="form-control campo_fecha datepicker" id="<?=$CodigoRuta.'-'.$tarifa->CodigoFareBase.'-vigencia1'?>" readonly/>
            </td>
            <td>
                <input type="text" value="<?= $tarifa->EstadiaMin?>" class="form-control" id="<?=$CodigoRuta.'-'.$tarifa->CodigoFareBase.'-estmin'?>"  size="2"/>
            </td>
            <td>
                <input type="text" value="<?= $tarifa->EstadiaMax?>" class="form-control" id="<?=$CodigoRuta.'-'.$tarifa->CodigoFareBase.'-estmax'?>"  size="2"/>
            </td>
            <td>
                <input type="checkbox" id="<?=$CodigoRuta.'-'.$tarifa->CodigoFareBase.'-web'?>" <?= $checked?> />
            </td>
        </tr>
        
    <?php endforeach ?>
    <?php $str_fb = implode('*',$farebases); ?>
    <input type='hidden' id='idruta' value="<?= $CodigoRuta?>"/>
    <input type='hidden' id='farebases' value="<?= $str_fb?>"/>
<?php endif ?>