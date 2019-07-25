$(function () {

    var criterioelegido;
    var num_manifi;

    $('#tipo_busqueda').focus();
    $('#footerDetalle').hide();
    $.getScript("../../js/app/genericas.js");

    $('#tipo_busqueda').change(function () {
        criterioelegido = $(this).val();

        switch (criterioelegido) {
            case '1':
                funcionDesactivarActivarElemento(0, ['origen', 'destino']);
                funcionDesactivarActivarElemento(1, ['daterangepicker']);
                // Instruccion para desplegar el daterangepicker
                $("#daterangepicker").focus(function () {
                    $("#daterangepicker").show();
                });
                $("#daterangepicker").focus();
                // .Instruccion para desplegar el daterangepicker
                break;
            case '2':
                funcionDesactivarActivarElemento(0, ['daterangepicker']);
                funcionDesactivarActivarElemento(1, ['origen', 'destino']);
                $('#origen').select2('open');
                $('#destino').select2('open');
                $('#tablaDetalle tbody').empty();
                break;
            default :
                console.log('Esto no es valido');
        }

    });

    $('#btn_busca').click(function () {
        $('#table tbody').empty();
        $('.nMani').empty();
        $("#totales").removeClass("collapsed-box");
        $("#btnDinamic").removeClass("fa-plus");
        $('#btnDinamic').addClass('fa-minus');


        switch (criterioelegido) {
            case '1':
                param = $('#daterangepicker').val();
                data = 'rango_fecha=' + param;
                break;
            case '2':
                origen = $('#origen').val();
                destino = $('#destino').val();
                data = 'origen=' + origen + '&destino=' + destino;
                break;
            default :
                funcionShowModal('Advertencia', 'Asegurese de seleccionar algun criterio de busqueda', 'Entiendo', 'modal-warning');
                return false;
        }

        $.ajax({
            type: 'POST',
            url: 'recibeParametrosConsulta',
            data: data,
            success: function (data) {
//                console.log(data);
                $('#table tbody').append(data);
//                $("#table_main").DataTable();
            }
        });

    });

    $('body').on('click', '.nummanif', function () {
        $("#btnDinamic").removeClass("fa-minus");
        $('#btnDinamic').addClass('fa-plus');
        $('#totales').addClass('collapsed-box');
        num_manifi = $(this).attr('id');
        $('.nMani').empty();
        $('.nMani').append(' N° ' + num_manifi);
        $.ajax({
            type: 'POST',
            url: 'detalleManifiesto',
            data: 'num_manifi=' + num_manifi,
            success: function (data) {
                var info = data.split('|');
                var tablaDetalle = info[0];
                var bultos = info[1];
                var kilos = info[2];
                var volumen = info[3];
                $('#tablaDetalle tbody').empty();
                $('#tablaDetalle tbody').append(tablaDetalle);
                $('.bultos').html(bultos);
                $('.kilos').html(kilos);
                $('.volumen').html(volumen);
                
                var empty_tbody = $('#tablaDetalle tbody').is(':empty');
                if(!empty_tbody){
                    $('#footerDetalle').show();
                }
            }
        });

    });

//    $('#excel').click(function(){
//        funcionShowModal('Advertencia','Estos campos no son validos','Entiendo','modal-danger',false);
//    });
//    $('#modal_generico').on('show.bs.modal', function (e) {
//  if (!data) return e.preventDefault() // stops modal from being shown
//    $(this).modal('show');
//})


});