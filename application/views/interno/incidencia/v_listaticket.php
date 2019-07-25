<style type="text/css">

    a.link:link {color:#000;}
    a.link:visited {color:#000;}
    a.link:active {color:#000;}
    a.link:hover {color:#000;}
</style>
<?php
$this->CI = &get_instance();
?>

<div class="row">
    <div class="col-md-3">
        <a href="<?= base_url() ?>utilitarios/incidencias/" class="btn btn-primary btn-block margin-bottom">Nuevo</a>
        <?php
        $data['CantNewMsjs'] = $CantNewMsjs;
        $this->CI->load->view('interno/incidencia/v_menu', $data);
        ?>
    </div>

    <div class="col-md-9">
        <?php
        if (isset($Ticket) && !empty($Ticket)) {
            $data['Ticket'] = $Ticket;
            $this->CI->load->view('interno/incidencia/v_ticket_generado');
        }
        ?>

        <div class="box box-primary">
            <div class="box-header with-border">

                <div class="btn-group pull-right">
                    <button  data-toggle="tooltip" data-container="body" data-original-title="Actualizar" type="button" onClick="window.location.reload()" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></button>
                </div>
                <h3 class="box-title"><?= $titulobox ?></h3>
                <!-- /.btn-group -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="table-responsive">
                    <table id="listTickets" class="table table-condensed table-hover">
                        <thead>
                        <th>#Ticket</th>
                        <th>Descripción</th>
                        <th>Fecha de Generacion</th>
                        <th>Estado</th>
                        <th>Responsable</th>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($ListTicket)) {

                                foreach ($ListTicket->result() as $incidencia) {
                                    ?>
                                    <tr>
                                        <!-- CELDA TICKET-->
                                        <td><?= $incidencia->ticket ?></td>
                                        <!-- .CELDA TICKET-->
                                        <!-- CELDA DESCRIPCION-->
                                        <td>
                                            <?php
                                            $txt_sin_taghtml = strip_tags($incidencia->detalle);
                                            $txt_20primeraletras = substr($txt_sin_taghtml , 0, 20);
                                            $txt_incidencia = strtoupper($txt_20primeraletras);
                                            $ClassAlertDes = NULL;
                                            $Vinculo = NULL;
                                            $Titulo = NULL;
                                            $Vinculo = 'utilitarios/incidencias/LeerFeedback?ticket=' . $incidencia->ticket . '&id=' . $incidencia->id;
                                            if (!is_null($incidencia->feedback) && $incidencia->estado_id < 3) {
//                                            if (!is_null($incidencia->feedback) && $incidencia->estado_id > 0 && $incidencia->estado_id != 3) {
                                                $ClassAlertDes = 'fa fa-envelope-square text-green';
                                                $datetime = new DateTime($incidencia->fecha_feedback);
                                                $Titulo = 'Recibiste una respuesta el ' . $datetime->format('d/m/Y h:i:s');
                                            }
                                            ?>
                                            <a class="link" href="<?=base_url().$Vinculo?>"><?=$txt_incidencia;?></a>
                                            <div class="box-tools pull-right">
                                                <a data-toggle="tooltip" data-container="body" data-original-title="<?= $Titulo ?>"  href="<?= base_url() . $Vinculo ?>"><i class="<?= $ClassAlertDes ?>"></i></a>
                                            </div>
                                        </td>
                                        <!-- .CELDA DESCRIPCION-->
                                        <!-- CELDA FECHA GENERACION-->
                                        <td><?= formateaFechaGenerica($incidencia->FechaCreacion) ?></td>
                                        <!-- .CELDA FECHA GENERACION-->
                                        <!-- CELDA ESTADO-->
                                        <td>
                                            <?php
                                            switch ($incidencia->estado_id) {
                                                case 0:
                                                    $color_span = 'label-warning';
                                                    $data_original_tooltip = '';
                                                    break;
                                                case 1:
                                                    $color_span = 'label-success';
                                                    $data_original_tooltip = (!is_null($incidencia->fecha_revisa)) ? $incidencia->fecha_revisa : '';
                                                    break;
                                                case 2:
                                                    $color_span = 'label-warning';
                                                    $data_original_tooltip = NULL;
                                                    break;
                                                case 3:
                                                    $color_span = 'label-primary';
                                                    $data_original_tooltip = (!is_null($incidencia->fecha_finaliza)) ? formateaFechaGenerica($incidencia->fecha_finaliza) : '';
                                                    break;
                                                case 4:
                                                    $color_span = 'label-primary';
                                                    $data_original_tooltip = (!is_null($incidencia->fecha_finaliza)) ? $incidencia->fecha_finaliza : '';
                                                    break;
                                            }
                                            ?>
                                            <span data-toggle="tooltip" data-container="body" title="" data-original-title="<?= $data_original_tooltip ?>" class="label <?= $color_span ?>"><?= $incidencia->nom_estado ?></span>
                                        </td>                  
                                        <!-- CELDA .ESTADO-->
                                        <!-- CELDA RESPONSABLE-->
                                        <td><?= $incidencia->nom_usuario ?></td>
                                        <!-- .CELDA RESPONSABLE-->
                                    </tr>

                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
