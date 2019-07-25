<?php
$this->CI = &get_instance();
?>
<div class="row">
    <div class="col-md-3">
        <!-- Opciones lateral izquierdo - Ubicacion-->
        <a href="<?= base_url() ?>utilitarios/incidencias/Inbox" class="btn btn-primary btn-block margin-bottom">Regresar a Bandeja de Entrada</a>
        <?php
        $data['CantNewMsjs'] = $CantNewMsjs;
        $this->CI->load->view('interno/incidencia/v_menu', $data);
        ?>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
            <form action="<?= base_url() ?>utilitarios/incidencias/recibeFeedback" method="POST">
                <div class="box-header with-border">
                    <h3 class="box-title">Información de incidencia</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding direct-chat direct-chat-primary">

                    <div class="mailbox-read-info">
                        <h3 id="ticket">Re: [Ticket#<?= $ticket ?>]</h3>
                        <h5>De: <?= $campo->nombre . ' ' . $campo->apellido . ' < ' . $campo->email . ' >' ?>
                            <span class="mailbox-read-time pull-right"><?= $campo->fecha_genera ?></span></h5>
                    </div>

                    <!-- /.mailbox-read-info -->
                    <div class="mailbox-controls with-border text-center">
                        <?php
                        $ExisteError = $this->session->flashdata('ExisteError');

                        if (isset($ExisteError) && is_bool($ExisteError) && $ExisteError) {
                            ?>
                            <div class="info-box bg-red">
                                <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><b>OCURRIO UN ERROR</b></span>
                                     <ul class="text-left">
                                            <li>Verifica que la fecha elegida este seleccionada</li>
                                            <li>Si el error continua, comunique al departamento de sistemas</li>
                                        </ul>                            
                                    
                                </div>
                            </div>

                            <?php
                        }
                        ?>
                        <?php if ($TicketFinished) { ?>
                            <div class="callout callout-info">
                                <p>ESTE TICKET SE ENCUENTRA FINALIZADO</p>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="btn-group">

                                <button  data-toggle="tooltip" data-container="body" data-original-title="Actualizar" type="button" onClick="window.location.reload()" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                <!--SI EL BOTON RESPONDER SE MUESTRA DESACTIVADO, QUIERE DECIR QUE EL MISMO USUARIO QUE SE ENCUENTRA LEYENDO ES MISMO QUE HIZO LA ULTIMA RETROALIMENTACIÓN, CUMPLE LA 
                                PRIMERA CONDICION DEL IF-->
                                <?php if (isset($disabled_btn_responder) && $disabled_btn_responder === 'disabled') {
                                    ?>
                                    <button disabled type="button" class="btn btn-warning btn-sm">
                                        <i class="fa fa-spin fa-clock-o fa-lg"></i>&nbsp; Esperando respuesta..
                                    </button>
                                <?php } else {
                                    ?>
                                    <button id="responder_incidencia" type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Responder">
                                        <i class="fa fa-reply"></i></button>

                                    <?php
                                }
                                if (isset($btn_aceptacion) && $btn_aceptacion) {
                                    ?>
                                    <button onclick="location.href = '<?= base_url() ?>utilitarios/incidencias/AceptarSolucion_Solicitante?acepta=Y&ticket=<?= $ticket ?>&id=<?= $_GET['id'] ?>'" type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="¿Esta respuesta dio solucion a tu incidencia?">
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </button>
                                    <button id="responder_incidencia" type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="¿No es la respuesta deseada?">
                                        <i class="fa fa-thumbs-o-down"></i>
                                    </button>

                                    <?php
                                }
                            }
                            ?>

                        </div>
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.mailbox-controls -->

                    <div class="mailbox-read-message" id="div_campotextreply">
                        <textarea name="text_feedback" id="compose-textarea" class="form-control" style="height: 300px">
                        </textarea>
                        <!-- /.box-footer -->
                        <div class="box-footer mailbox-messages" id="bloque_volver_enviar">
                            <!-- CAMPOS OCULTOS-->

                            <input type="hidden" value="<?= $ticket ?>" name="ticket">

                            <!-- .CAMPOS OCULTOS-->
                            <?php
//                                                        var_dump($UsuarioLecturaEsSolicitante);die;
                            if(isset($UsuarioSesionRolSolicitante) && !$UsuarioSesionRolSolicitante && $fecha_estimada_is_null){
                                
                                $this->CI->load->view('interno/incidencia/v_calendario');
                            }
                            ?>
                            <div class="pull-right">
                                <button type="button" class="btn btn-default" id="ExitWrite"><i class="fa fa-reply"></i> Quitar bloque de escritura</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar respuesta</button>
                                <!--<button id="btn_enviar_feedback" type="button" class="btn btn-success"><i class="fa fa-envelope-o"></i> Enviar</button>-->
                            </div>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <div class="direct-chat-messages col-lg-12">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left"><?= ((int) $campo->id_usuario_solicitante === (int) $this->session->id_usuario) ? 'Tú: ' : "De:   $campo->nombre" ?></span>
                                <span class="direct-chat-timestamp pull-right"><?= formateaFechaGenerica($campo->fecha_genera) ?></span>
                            </div>
                            <div class="direct-chat-text">
                                <?= $campo->detalle ?>
                            </div>
                        </div>

                        <?php
                        if (isset($campo_feedback)) {

                            foreach ($campo_feedback->result() as $item) {
                                if (($item->id_usuario_solicitante != $item->id_usuario_feedback) && !is_null($item->feedback)) {
                                    ?>

                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-right"><?= ((int) $item->id_usuario_feedback === (int) $this->session->id_usuario) ? 'Tú' : $item->nombre; ?></span>
                                            <span class="direct-chat-timestamp pull-left"><?= formateaFechaGenerica($item->fecha_feedback) ?></span>
                                        </div>
                                        <div class="direct-chat-text">
                                            <?= $item->feedback ?>
                                        </div>
                                    </div>

                                <?php } else if (!is_null($item->feedback)) {
                                    ?>
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left"><?= ((int) $campo->id_usuario_solicitante === (int) $this->session->id_usuario) ? 'Tú: ' : "De:   $campo->nombre" ?></span>
                                            <span class="direct-chat-timestamp pull-right"><?= formateaFechaGenerica($item->fecha_feedback) ?></span>
                                        </div>
                                        <div class="direct-chat-text">

                                            <?= $item->feedback ?>
                                        </div>
                                    </div>                                    
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>

                    <!-- /.mailbox-read-message -->


                </div>
                <!-- /.box-body --> 
                <input type="hidden" id="fecha_set" name="fecha_set" value="">
            </form>
        </div>
        <!-- /. box -->
    </div>
</div>

