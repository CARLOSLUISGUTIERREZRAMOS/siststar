<div class="box box-danger">       

    <div class="box-header with-border">
        <h3 class="box-title">Subida de archivo</h3>
    </div>
    <form  action="<?= base_url() . 'file' ?>" role="form" id="form_conversion" enctype="multipart/form-data" method="post">
        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputFile"><ul><li>Solo archivos tipo excel</li><li><span> <b>Solo</b> con formato .xlsx</span></li></ul></label><br>
                <input type="file" id="my-file" name="archivo" >
                <p class="help-block">Después del envio te redireccionaremos a un listado de archivos.</p>
            </div>
        </div>
        <!-- /.box-body -->
        <p class="file-return"></p>
        <input type="hidden" name="condicion" id="condicion" value="1">
        <input type="hidden" name="ubicacionDescarga" id="ubicacionDescarga" value="<?= $ubicacionDescarga ?>"> <!-- Comprobemos que tan seguro es-->
        <input type="hidden" name="controller_file" id="controller_file" value="<?= $controller_file ?>"> <!-- Comprobemos que tan seguro es-->
        <input type="hidden" name="listaArchivosSubidos" id="listaArchivosSubidos" value="<?= $listaArchivosSubidos ?>"> <!-- Comprobemos que tan seguro es-->
        <input type="hidden" name="area" id="area" value="<?= $area ?>"> <!-- Comprobemos que tan seguro es-->
        <div class="box-footer">
            <button type="submit" class="btn btn-danger">Subir archivo</button>
        </div>
        <div id="mensaje"></div>
    </form>


</div>
