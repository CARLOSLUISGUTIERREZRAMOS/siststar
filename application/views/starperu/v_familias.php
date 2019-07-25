<div class="box box-danger">
    <div class="box-body">
        <div class="table-responsive">
            <div class="col-md-8 col-sm-offset-2">
                <ul class="timeline">
                    <?php foreach ($familias as $familia): ?>
                        <?php 
                            $variable=explode('<br>', $familia->condiciones);
                            if (count($variable)==1) {
                                $cant=$variable[0] ? 1 : 0;
                            }
                            else{
                                $cant=1;
                            }
                        ?>
                        <li class="time-label" id="grupo-familia-<?= $familia->codigo?>">
                            <span class="bg-green"><?= $familia->nombre ?></span>
                            <div class="cabecera">
                                <button class="btn btn-primary btn-xs nuevo-item" id="<?= $familia->codigo?>|<?= $cant?>">
                                    <i class="fa fa-plus"></i> Nuevo Item
                                </button>
                            </div>
                        </li>
                        
                        <?php foreach ($variable as $key => $condicion): ?>
                            <?php if ($condicion): ?>
                                <li id="li-<?= $familia->codigo?><?= $key?>" class="familia-hermanos-<?= $familia->codigo?>">
                                    <i class="fa fa-check-square bg-blue"></i>
                                    <div class="timeline-item">
                                        <div class="timeline-footer">
                                            <div class="form-inline">
                                                <div class="form-group" style="width: 90%">
                                                    <h2 class="timeline-header no-border "><?= $condicion?></h2>
                                                    <textarea class="mod-card-back-title hide" rows="1" dir="auto" id="<?= $familia->codigo?>|1"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <a class="btn btn-danger btn-xs pull-right iliminar-item" id="<?= $familia->codigo?>" name="<?= $familia->codigo?><?= $key?>">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</div>