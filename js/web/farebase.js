$(function () {
    $('.rango_emision').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
    $('.rango_inicio').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

});

function guardarTodoFareBase() {
    var tr=$(".tbody-listado").find('.tr');
    var data=[];
    tr.each(function (index,arg) {
        var obj={};
        obj.tarifa=$(arg).find('input[name=tarifa]').val();
        obj.fecha_emision_rango_ini_fin=$(arg).find('input[name=fecha_emision_rango_ini_fin]').val();
        obj.fecha_inivuelo_rango_ini_fin=$(arg).find('input[name=fecha_inivuelo_rango_ini_fin]').val();
        obj.estadia_min_lunes=$(arg).find('input[name=estadia_min_lunes]').val();
        obj.estadia_min_martes=$(arg).find('input[name=estadia_min_martes]').val();
        obj.estadia_min_miercoles=$(arg).find('input[name=estadia_min_miercoles]').val();
        obj.estadia_min_jueves=$(arg).find('input[name=estadia_min_jueves]').val();
        obj.estadia_min_viernes=$(arg).find('input[name=estadia_min_viernes]').val();
        obj.estadia_min_sabado=$(arg).find('input[name=estadia_min_sabado]').val();
        obj.estadia_min_domingo=$(arg).find('input[name=estadia_min_domingo]').val();
        obj.estadia_maxima=$(arg).find('input[name=estadia_maxima]').val();
        obj.estado_web=$(arg).find('select[name=estado_web]').val();
        obj.farebase=$(arg).find('input[name=farebase]').val();
        obj.ruta_id=$(arg).find('input[name=ruta_id]').val();
        data.push(obj);
    });
    $("#v_modal_error").find('.btn-success').html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
    $.ajax({
        
        url: URLs+'web/Farebase/ActualizarTodoFarebase',
        type: 'POST',
        data: {"formData":data},
        success: function(info,status,c) {
            $("#v_modal_error").find('.btn-success').html('<i class="fa fa-save"></i> Sí, entendido');
            $("#v_modal_error").modal('hide');
            if (info==1) {
                var alert='light-blue';
                var Msg='Se actualizarón todos los farebases de la ruta <span style="font-weight: bold">'+$("#ruta_name").val()+'</span>';
            }
            else if (info==0) {
                var alert='red';
                var Msg='Se actualizarón algunos farebase de la ruta <span style="font-weight: bold">'+$("#ruta_name").val()+'</span> guardar los cambios de nuevo o actualice la página';
            }
            $("html, body").animate({ scrollTop: 0 }, "slow");
            $("#MsgResultado").html('<div class="alert bg-'+alert+' alert-dismissible margin">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                                        '<h4><i class="icon fa fa-warning"></i>'+Msg+'</h4>'+
                                    '</div>');
        },
        error: function() {
            $("#v_modal_error").find('.btn-success').html('<i class="fa fa-save"></i> Sí, entendido');
            $("#v_modal_error").modal('hide');
        }
    });
    return false;
}

function mostrarConfirmacion() {
    $("#v_modal_error").modal();
    $("#v_modal_error").find('.btn-success').attr('onclick','guardarTodoFareBase()');
}
    