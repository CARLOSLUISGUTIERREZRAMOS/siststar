 <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Carpetas </h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding" style="">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?= base_url()?>utilitarios/incidencias/Inbox"><i class="fa fa-inbox"></i> Tus Reponsabilidades
                            <span class="label label-primary pull-right"><?= $CantNewMsjs ?></span></a></li>
                    <li><a href="<?= base_url()?>utilitarios/incidencias/Enviados?estado=PROCESO"><i class="fa fa-ticket"></i> Tus Ticket's</a></li>
                    
                    
                    <li><a href="#"><i class="fa fa-trash-o"></i> Eliminados</a></li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>