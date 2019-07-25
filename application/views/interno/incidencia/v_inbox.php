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
        <!-- Opciones lateral izquierdo - Ubicacion-->
        <a href="<?= base_url() ?>utilitarios/incidencias/" class="btn btn-primary btn-block margin-bottom">Nuevo</a>
        <?php
        $data['CantNewMsjs'] = $CantNewMsjs;
        $this->CI->load->view('interno/incidencia/v_menu', $data);
        ?>
        <!-- .Opciones lateral izquierdo -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
     
        <?php
        $resultado_eliminar = $this->session->flashdata('resultado_eliminar');
//        var_dump($resultado_eliminar);
        $this->CI = &get_instance();
        $data['icono_fa'] = 'fa fa-trash';
        if ($resultado_eliminar == 'success') {
            $data['msg'] = "Los ticket(s) fueron eliminados exitosamente";
            $this->CI->load->view('interno/incidencia/v_bloque_resultado',$data);
        } else if ($resultado_eliminar === 'error') {
            $data['msg'] = "Error al eliminar";
            $this->CI->load->view('interno/incidencia/v_bloque_resultado',$data);
        }
        ?>
        
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Listado de incidencias</h3>

                <div class="box-tools pull-right">
                    <div class="has-feedback">
                        <input type="text" class="form-control input-sm" placeholder="Buscar incidencia">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm del" data-toggle="modal" data-target="#modal-danger"><i class="fa fa-trash-o"></i></button>
                    </div>
                    <!-- /.btn-group -->
                    <button type="button" onClick="window.location.reload()" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <tbody>
                            <!-- Date dd/mm/yyyy -->
                            <?php
                            echo (empty($Bandeja->result())) ? '<tr><td>No tienes mensajes</td><tr>' : '';

                            foreach ($Bandeja->result() as $item) {
//                               
                                ?>
                                <tr class="ticket mailbox-messages" id="<?= $item->ticket ?>">
                                    <td><input type="checkbox" id="check" class="check" value="<?= $item->ticket ?>"></td>
                                    <td class="mailbox-star">
                                        <i class="<?= ($item->estado_id === '0') ? 'fa fa-envelope' : 'fa fa-envelope-o' ?> text-yellow"></i>

                                        <?php
//                                        
                                        if ($item->estado_id === '4') {
                                            ?>
                                            <i data-toggle="tooltip" data-container="body" data-original-title="Este ticket se encuentra en estado finalizado" class="fa fa-check-circle text-green"></i>
    <?php } else if ($item->notificacion === 'Y') { ?>

                                            <i data-toggle="tooltip" data-container="body" data-original-title="El administrador del sitio te notificó" class="fa fa-bullhorn text-red"></i>

                                        <?php }
                                        ?>
                                    </td>
                                    <td class="mailbox-name"><a class="link" href="<?= base_url() ?>utilitarios/incidencias/LeerFeedback?ticket=<?= $item->ticket ?>"><i class="fa fa-ticket"></i> <?= $item->ticket ?></a></td>
                                    <td class="mailbox-name"><a class="link" href="<?= base_url() ?>utilitarios/incidencias/LeerFeedback?ticket=<?= $item->ticket ?>"><?= $item->nombre . ' ' . $item->apellido ?></a></td>
                                    <td class="mailbox-subject" title="seguir leyendo"><a class="link" href="<?= base_url() ?>utilitarios/incidencias/LeerFeedback?ticket=<?= $item->ticket ?>"><?= strtoupper(substr(strip_tags($item->detalle), 0, 40)) . '...' ?></a>
                                    </td>
                                    <td class="mailbox-attachment">


                                        <span data-toggle="tooltip" data-container="body" title="" data-original-title="<?= formateaFechaGenerica($item->fecha_finaliza) ?>" class="label label-success"><?= ($item->estado_id == 3) ? 'ACEPTADO' : ''; ?></span>
                                    </td>
                                    <td class="mailbox-date">
                                        <?php
                                        echo formateaFechaGenerica($item->fecha_genera);
                                        $num_dias = CalcularDiasRestantes($item->fecha_genera, $item->fecha_estimada_fin);

                                        switch ($num_dias) {
                                            case ($num_dias < 31 && $num_dias > 14):
                                                $clase_label = 'label label-info';
                                                $msj_span = 'Quedan ' . $num_dias . ' días';
                                                break;
                                            case ($num_dias < 16 && $num_dias > 4):
                                                $clase_label = 'label label-success';
                                                $msj_span = 'Quedan ' . $num_dias . ' días';
                                                break;
                                            case ($num_dias < 6 && $num_dias > 2):
                                                $clase_label = 'label label-warning';
                                                $msj_span = 'Quedan ' . $num_dias . ' días';
                                                break;
                                            case ($num_dias < 3 && $num_dias > 1):
                                                $clase_label = 'label label-danger';
                                                $msj_span = 'Quedan ' . $num_dias . ' días';
                                                break;
                                            case ($num_dias > 0 && $num_dias < 2):
                                                $clase_label = 'label label-danger';
                                                $msj_span = 'Queda ' . $num_dias . ' día';
                                                break;
//                                            default : $num_dias = 'INDEFINIDOS';
                                        }
//                                        echo "°".var_dump($item->estado_id)."°";
                                        if ($num_dias != FALSE && $item->estado_id != '4') {
                                            ?>
                                            <span class="<?= $clase_label ?>"><?= $msj_span ?></span>

                                            <?php
                                        }
                                        if ($item->estado_id != '4') {
                                            switch ($item->importancia) {
                                                case 'BAJA':
                                                    break;
                                                case 'MEDIA':
                                                    break;
                                                case 'ALTA':
                                                    echo "<small class='label pull-right bg-red'><i class='fa fa-fw fa-exclamation-triangle'></i> MUY IMPORTANTE</small>";
                                                    break;
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
    <?php
}
?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    
    <!-- /.col -->
</div>

