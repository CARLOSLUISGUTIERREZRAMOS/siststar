<div class="row">
    <div class="col-md-3">
        <!-- Opciones lateral izquierdo - Ubicacion-->
        <a href="<?= base_url() ?>utilitarios/incidencias/Inbox" class="btn btn-primary btn-block margin-bottom">Regresar a Bandeja de Entrada</a>
        <?php
        $data['CantNewMsjs'] = $CantNewMsjs;
        $this->CI = &get_instance();
        $this->CI->load->view('interno/incidencia/v_menu', $data);
        ?>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <form action="<?= base_url() ?>utilitarios/incidencias/RecibirIncidencia" method="POST">
            <div class="form-group">
                <label>Responsable: </label>
                <!-- MULTIPLES USUARIOS-->
                <!--<label>Responsables que deben atender esta incidencia: </label>-->
                <!--<select class="form-control select2" multiple="multiple" data-placeholder="Seleccione a los responsables"-->
                <!-- .MULTIPLES USUARIOS-->
                <select class="form-control select2" required style="width: 100%" name="user_resp" id="user_resp">
                    <option disabled selected value>  SELECCIONE RESPONSABLE  </option>

                    <?php
                    foreach ($UsuariosDest->result() as $usuario) {
                        ?>
                        <option value="<?= $usuario->id_usuario ?>"><?= $usuario->nombre . ' ' . $usuario->apellido ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="box box-primary" id="DivGeneracionIncidencia">
                <div class="box-header with-border">
                    <h3 class="box-title">Nueva Incidencia</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <textarea name="texto_incidencia" id="compose-textarea" class="form-control" style="height: 300px">
                        </textarea>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" id="btnEnvio" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>

                        </div>

                    </div>

                </div>
            </div>

            <div class="box box-danger box-solid" id="DivTicketCarga">
                <div class="box-header">
                    <h3 class="box-title">Generando Ticket</h3>
                </div>
                <div class="box-body">
                    Espere un momento por favor...
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- end loading -->
            </div>
        </form>

    </div>

