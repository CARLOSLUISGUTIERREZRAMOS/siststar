<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SISTSTAR V1.2</title>
        <link rel="icon" type="image/png" href="<?= base_url() . 'img/icostar.jpg' ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?= link_tag('css/bootstrap/bootstrap.min.css'); ?>
        <?= link_tag('css/font-awesome/css/font-awesome.min.css'); ?>
        <?= link_tag('css/Ionicons/ionicons.min.css'); ?>
        <?= link_tag('css/pace/pace.min.css'); ?>
        <?= link_tag('css/skins/_all-skins.min.css'); ?>
        <style type="text/css">
            .loading-style{
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 1050;
                display: none;
                overflow: hidden;
                -webkit-overflow-scrolling: touch;
                outline: 0;
                background: rgba(0,0,0,0.3);
                padding-left: 50%;
                padding-top: 20%;
                opacity: 1;
            }
            .loading-div>img{
                background: #f8f7f775;;
                border-radius: 100px;
            }
        </style>
        <?= link_tag('css/lte/AdminLTE.min.css'); ?>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <?= $styles ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed">

        <div class="pace  pace-inactive">
            <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
                <div class="pace-progress-inner"></div>
            </div>
            <div class="pace-activity"></div></div>

        <div class="wrapper">

            <!-- CABECERA PRINCIPAL-->
            <?php $this->template->load_header(); ?>

            <!-- MENU DE OPCIONES -->
            <?php $this->template->load_menu($this->session->id_usuario); ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        <?= $titulo ?>
                        <!--<small>Control panel</small>-->
                    </h1>
                    <!-- breadcrumb finalizado  -->
                    <ol class="breadcrumb"> 

                        <?php if (is_null($data_ubicacion)) { ?>
                            <li><a href="#"><i class="fa fa-home"></i> .</a></li>
                            <li class="active">Principal</li>
                            <?php
                        } else {
                            $data = explode('|', $data_ubicacion);
                            ?>
                            <li><a ><i class="<?= $data[0] ?>"></i><?= $data[1] ?></a></li>
                            <?php for ($i = 2; $i <= (count($data) - 1 ); $i++) { ?>
                                <li class="active"><?= $data[$i] ?></li> 
                            <?php } ?>
                        <?php } ?>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <?= $contents ?>
                </section>
                <!-- /.content -->
            </div>

            <!-- FOOTER -->
            <?php $this->template->load_footer(); ?>
            <!-- .FOOTER -->

            <!-- Control Sidebar Opciones -->
            <aside class="control-sidebar control-sidebar-dark">
                <div class="tab-content">
                    <div class="tab-pane" id="control-sidebar-home-tab">
                    </div>
                </div>
            </aside>
        </div>
        
        <div class="loading-style" style="display: none;">
            <div class="loading-div">
                <?=img('/img/loading.gif')?>
            </div>
        </div>
         <div class="modal fade" id="v_modal_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="" style="display: none;" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><img src="http://35.238.63.231/star/img/Logotipo.png" alt=""></h5>
                  </div>
                  <div class="modal-body">
                      <p id="TxtMsg">¿Seguro que desea guardar todos los cambios?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success"><i class="fa fa-save"></i> Sí, entendido</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-minus-circle"></i> Cancelar</button>
                  </div>
                </div>
              </div>
            </div>

        <?php echo script_tag('js/jquery/jquery.min.js'); ?>
        <?php echo script_tag('js/jquery/jquery-ui.min.js'); ?>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <?php echo script_tag('js/bootstrap/bootstrap.min.js'); ?>
        <!-- INPUT MASK -->
        <!-- .INPUT MASK -->
        <?php echo script_tag('js/pace/pace.min.js'); ?>

        <?php echo script_tag('js/lte/adminlte.min.js'); ?>
        <?php echo script_tag('js/app/layout.js'); ?>
        <?php echo script_tag('js/disenio/plantilla.js'); ?>
           <script type="text/javascript">
            URLs="<?php echo base_url('');?>";
            function showGif() {
                $("body").css({overflow:'hidden'});
                $(".loading-style").show();
            }
            function hideGif() {
                $("body").css({overflow:''});
                $(".loading-style").hide();
            }
            function sessionAjax() {
                var ajax_return=$.ajax({
                            async: false,
                            type: "POST",
                            url:  URLs+'interno/Ajax',
                            data: 'data=1',
                            success: function(msg){
                            }
                        });
                return ajax_return.responseText==1 ? true : false;
            }
        </script>
        <?php echo $scripts; ?>

    </body>
</html>


