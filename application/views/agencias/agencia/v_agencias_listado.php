<style type="text/css">
    .toast-top-right {
        top: 50px;
        right: 12px;
    }
</style>

<div class="box box-danger">
    <div class="box-body">
        <div class="table-responsive" id="table-data">
            <?php $this->load->view('agencias/agencia/v_contenido_agencia'); ?>
        </div>
    </div>
</div>

<div class="modal modal-default fade" id="modal-estado-agencia">
    <div class="modal-dialog" style="width: 300px;">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php
                        $image_properties = array(
                            'src' => 'img/logo_starperu.png',
                            'width' => '30%',
                            'height' => '30%',
                        );
                        echo img($image_properties);
                    ?>
                </div>
                <div class="panel-body" style="background: #f6f6f629;">
                    <div class="col-md-12">
                        <div class="row">
                            <p style="font-size: 16px;color: #03a9f4;"></p>
                        </div>
                        <div class="row">
                            <button class="btn btn-success btn-sm">
                                Sí, estoy seguro
                            </button>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


