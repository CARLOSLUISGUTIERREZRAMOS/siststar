<style type="text/css">
    a.link:link {color:#000;}
    a.link:visited {color:#dd4b39;}
    a.link:active {color:#dd4b39;}
    a.link:hover {color:#000;}
</style>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Criterios de busqueda</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <form action="<?= base_url() ?>utilitarios/admSisTickets/Buscar" method="post" role="form">
            <div class="row">

                <div class="col-lg-2">
                    <div class="form-group">
                        <label><i class="fa fa-ticket"></i> Número de ticket</label>
                        <input type="text" name="ticket" class="form-control">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Fecha de Generación</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-default" id="daterange-btn" name="fecha">
                                <span>
                                    <i class="fa fa-calendar"></i> Seleccione la fecha
                                </span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right btn-flat"><i class="fa fa-search"></i> Buscar </button>

                    </div>
                </div>
            </div>
            <div class="row">      

                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Solicitante</label>
                        <select class="form-control select2"  style="width: 100%" name="user_solic" id="user_solic">
                            <option disabled selected value>  SELECCIONE  </option>

                            <?php
                            foreach ($UsuariosDest->result() as $usuario) {
                                ?>
                                <option value="<?= $usuario->id_usuario ?>"><?= $usuario->nombre . ' ' . $usuario->apellido ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Responsable</label>
                        <select class="form-control select2" style="width: 100%" name="user_resp" id="user_resp">
                            <option disabled selected value>  SELECCIONE  </option>

                            <?php
                            foreach ($UsuariosDest->result() as $usuario) {
                                ?>
                                <option value="<?= $usuario->id_usuario ?>"><?= $usuario->nombre . ' ' . $usuario->apellido ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Importancia</label>
                        <select name="importancia"class="form-control">
                            <option disabled selected value>  SELECCIONE  </option>
                            <option value="BAJA">BAJA</option>
                            <option value="MEDIA">MEDIA</option>
                            <option value="ALTA">ALTA</option>
                        </select>
                    </div>
                </div>  
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="estado" id="estado">
                            <option disabled selected value>  SELECCIONE  </option>

                            <?php
                            foreach ($ListEstados->result() as $estado) {
                                ?>
                                <option value="<?= $estado->id ?>"><?= $estado->nombre ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!--<div>-->

            </div>
            <input type="hidden" name="fecha_daterange" id="fecha_daterange">

        </form>
        <!--<div class="row">-->
            <!--<button class="btn btn-default btn-block"><i class="fa fa-search"></i></button>-->

    </div>
    <!-- /.box-body -->
</div>
<div class="row">

    <div class="col-lg-12">
        <?php
        $ExisteError = $this->session->flashdata('ExisteError');

        if (isset($ExisteError) && $ExisteError === FALSE) {
            switch ($this->session->flashdata('ACCION')) {
                case "NOTIFICAR":
                    $msg = 'ENVIO DE NOTIFICACION EXITOSA AL USUARIO RESPONSABLE <br>';
                    $msg .= "<i class='fa fa-fw fa-user'></i> USUARIO NOTIFICADO: " . $this->session->flashdata('nombre_responsable') . ' ' . $this->session->flashdata('apellido_responsable');
                    break;
                case "ELEVAR":
                    $msg = "Cambio exitoso en el nivel importacia!";
                    break;
            }
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> <?= $msg ?></h4>
                <i class="fa fa-ticket"></i> Ticket: #<?= $this->session->flashdata('ticket') ?>.
            </div>

        <?php } else if (isset($ExisteError) && $ExisteError === TRUE) {
            ?>
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <div class="info-box-content">
                    <span class="info-box-text"><b>OCURRIO UN ERROR AL CAMBIAR EL ESTADO</b></span>
                    <ul class="text-left">
                        <!--<li>Verifica que la fecha elegida este seleccionada</li>-->
                        <li>Si el error continua, comunique al departamento de sistemas</li>
                    </ul>                            

                </div>
            </div>
            <?php
        }
        ?>
        <div class="box box-primary">
            <div class="box-header with-border">

            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                        <th>#Ticket</th>
                        <th>Fecha de Generación</th>
                        <th>Fecha de Solución</th>
                        <th>Días restantes</th>
                        <th>Solicitante</th>
                        <th>Responsable</th>
                        <th>Importancia</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ListTicket->result() as $item) {
//                                 var_dump($item->fecha_genera);die;
                                $dias_restantes = CalcularDiasRestantes($item->fecha_genera, $item->fecha_estimada_fin);
                                ?>
                                <tr bgcolor="<?= ($dias_restantes == 1 ) ? "#fcdfd7" : '' ?>">
                                    <td><?= $item->ticket ?></td>
                                    <td><?= formateaFechaGenerica($item->fecha_genera) ?></td>
                                    <td><?= FSisCarDMY($item->fecha_estimada_fin) ?></td>

                                    <td><?= (is_null($item->fecha_estimada_fin)) ? "<small class='label bg-red'>SIN FIJAR</small>" : "<small class='label label-info'>$dias_restantes </small>"; ?> </td>
                                    <td><?= $item->nom_solicita . " " . $item->ape_solicita ?></td>
                                    <td><?= $item->nom_resp . " " . $item->ape_resp ?></td>
                                    <td><small class="label bg-aqua-active"><?= $item->importancia ?></small></td>
                                    <?php
                                    switch ($item->estado_id) {
                                        case 0:
                                            $color_span = 'label-warning';
                                            $data_original_tooltip = '';
                                            break;
                                        case 1:
                                            $color_span = 'label-success';
                                            break;
                                        case 2:
                                            $color_span = 'label-warning';
                                            $data_original_tooltip = NULL;
                                            break;
                                        case 3:
                                            $color_span = 'label-primary';
                                            break;
                                        case 4:
                                            $color_span = 'label-primary';
                                            break;
                                    }
                                    ?>
                                    <td>
                                        <span class="label <?= $color_span ?>"><?= $item->nom_estado ?></span>
                                    </td>

                                    <td>
                                        <!--<div class="tools">-->
                                        <a href="<?= base_url() ?>utilitarios/admSisTickets/Notificar?ticket=<?= $item->ticket ?>" title="Notificar al usuario" type="button" class="btn btn-default btn-sm"><i class="fa fa-bullhorn"></i></a>&nbsp;
                                        <a href="#" id="<?= $item->ticket ?>" type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-default btn-sm item_selected_nimportancia" title="Elevar caso">
                                            <i class="fa fa-level-up"></i>
                                        </a>
                                        <!--</div>-->
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>    
                </div>    
            </div>


        </div>

    </div>
</div>

<div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">ELEVAR CASO</h4>
            </div>
            <form action="<?= base_url() ?>utilitarios/admSisTickets/CambiarNivelImportancia" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Seleccione el nivel de importancia</label>
                        <select class="form-control" name="nivel_importancia">
                            <option value="ALTA">NIVEL DE IMPORTANCIA ALTA</option>
                            <option value="MEDIA">NIVEL DE IMPORTANCIA MEDIA </option>
                            <option value="BAJA">NIVEL DE IMPORTANCIA BAJA</option>
                        </select>
                    </div>
                    <input type="hidden" value="" id="num_ticket" name="num_ticket">
                    <!--<input type="hidden" value="" id="ticket_hidden">-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar cambio</button>
                </div>

            </form>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

