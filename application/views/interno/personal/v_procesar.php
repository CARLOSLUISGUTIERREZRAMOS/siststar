<div class="box box-danger">
    <div class="box-header">
    </div>
    <div class="box-body">
        <?= form_open('interno/Personal/ProcesarExcelPersonal')?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nombre de Archivo </label>
                    <input class="form-control" type="text" name="name_archivo" placeholder="Ingrese nombre del archivo con formato xlsx">
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <div class="form-group">
                    <label>Numero de celda con primer registro </label>
                    <input type="number" class="form-control" name="celda_firstregister">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="PROCESAR">
                    
                </div>
            </div>
            <!-- /.col -->
        </div>
        <?= form_close()?>
    </div>
</div>
