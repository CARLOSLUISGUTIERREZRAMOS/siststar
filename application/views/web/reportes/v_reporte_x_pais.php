<?= form_open('reportes/Reporte_x_pais/reporte_por_pais') ?>




<div class="box">
    <div class="box-header">
        <label>Fecha Inicio :</label>
        <br>
        <label> Fecha Inicio</label>
        <input type="date" name="desde">
        <label> Fecha Fin</label>
        <input type="date" name="hasta">
        <div style="text-align: right;">
            <button>Ver Data</button>
            <button>Exportar</button>
            <button>Ver Grafico</button>

        </div>

    </div>

</div>
<div class="box-body">

    <table id="tbl_reportes" class="table">
        <tr>
            <th class="freq"><strong>País</strong></th>
            <th class="freq"><strong>Bbva</strong> </th>
            <th class="freq"><strong>PayP.</strong></th>
            <th class="freq"><strong>Scot.</strong></th>
            <th class="freq"><strong>Safe.</strong></th>
            <th class="freq"><strong>PagEf.</strong></th>
            <th class="freq"><strong>Visa</strong></th>
            <th class="freq"><strong>Mast.</strong></th>
            <th class="freq"><strong>Total</strong></th>
            <th class="freq"><strong>Ticket</strong></th>
            <th class="freq"><strong>Promedio</strong></th>
        </tr>
        <tr>
            <?php if (isset($pais)) { ?>

                <?php
                $data = [];
                $data_3 = [];
                foreach ($pais->Result() as $item) {
                    $data[$item->pais] = $item->pais;
                }
                foreach ($data as $key) {
                    foreach ($pais->Result() as $item) {
                        if ($data[$item->pais] === $item->pais) {
                            ?>
                            <td> </td>
                            <td>
                                <?php
                                if ($item->cc_code == "BA") {
                                    echo $total_pp = $item->importe;
                                    $total_ticket_pp = $item->cantidad;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($item->cc_code == "PP") {
                                    echo $total_pp = $item->importe;
                                    $total_ticket_pp = $item->cantidad;
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                if ($item->cc_code == "SC") {
                                    echo $total_vi = $item->importe;
                                    $total_ticket_vi = $item->cantidad;
                                }
                                ?>
                            </td>
                            <td><?php
                                if ($item->cc_code == "SP") {
                                    echo $total_vi = $item->importe;
                                    $total_ticket_vi = $item->cantidad;
                                }
                                ?>
                            </td>
                            <td><?php
                                if ($item->cc_code == "PE") {
                                    echo $total_vi = $item->importe;
                                    $total_ticket_vi = $item->cantidad;
                                }
                                ?>
                            </td>



                            <td><?php
                                if ($item->cc_code == "VI") {
                                    echo $total_vi = $item->importe;
                                    $total_ticket_vi = $item->cantidad;
                                }
                                ?></td>


                            <?php
                        }
                    }
                }
                ?>

                <td> <?php echo $total_importe = $total_vi + $total_pp ?></td>
                <td><?php echo $total_ticket_total = $total_ticket_pp + $total_ticket_vi ?></td>
                <td> <?php
                    $total = $total_importe / $total_ticket_total;
                    echo round($total, 2);
                    ?></td>


            </tr>
        <?php } ?>

    </table>
</div>
</div>

<?php form_close() ?>;