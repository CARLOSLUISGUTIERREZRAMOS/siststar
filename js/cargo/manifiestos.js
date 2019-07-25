$(function () {
    $.getScript("../../js/app/genericas.js");  //LLAMANDO AL FICHERO DONDE TENEMOS FUNCIONES GENERICAS
//    $('#consultaRango').daterangepicker('dd/mm/yyyy')
    $('#bloqueCreacion').hide();
    $('#btnCierreManifiesto').hide();
    $('#btnImprimir').hide();
    
    $('.select2').select2();
    $("#table_main").dataTable();
    $('#modal').modal('toggle');
    var Rut_destin;
    var Rut_origen;
    var num_pedidos = [];
    var num_pedidosComail = [];
    var booleanoChecked;
    var numVuelo;
    var numMatricula;
    var codConductor;
    var placa;
    var precintoI1;
    var precintoI2;
    var precintoI3;
    var totalBultos;
    var totalKilos;
    var totalVolumen;
    var totalPrecio;
    var numManifiesto;


    //BOTON 'MARCAR TODAS'

    $('body').on('click', '#chkAll', function () {
        if ($('input.chkCpa:checkbox').prop('checked')) {  //validamos si existe algun item checkbox seleccionado
            $("input.chkCpa:checkbox").prop('checked', false);  //.. de ser asi quitamos el check a todos
        } else { // Ingresa aqui cuando por que todos los elementos checkbox se encuentran sin seleccionar
            $("input.chkCpa:checkbox").prop('checked', true);    // aqui seleccionamos todos los elementos checkbox
        }
    });

    //BOTON PARA MOSTRAR MODAL

    $(document).on('click', '#btnVer', function () {

        var valRutDest = $('#Rut_destin').val();
        if (valRutDest == '') {
            funcionShowModal('Advertencia', 'Debes seleccionar la ruta destino', 'Entiendo');
            return false;
        }

        $('#estado').html('CREANDO');
        $("input.chkCpa:checkbox").prop('checked', false);
        Rut_origen = $('#Rut_origen').val();
//        Rut_destin = $('#Rut_destin').val();
//          $("#modal_generico").modal('show');
        $.ajax({
            type: 'POST',
            url: 'getData',
            data: 'Rut_origen=' + Rut_origen + '&Rut_destin=' + Rut_destin,
            success: function (data) {
                $("#tbody").html("");
                $('#tbody').append(data);
                $('.box-title').html('Relación de las guias pendientes de la ruta ' + Rut_origen + " - " + Rut_destin);
                $("#modalCpas").modal('show');

            }

        });
    });
    //---------------------------------------------------------------------/
    //***** SETIENDO LAS VARIABLES CUANDO SE DETECTE EL CAMBIO ************/

    $(document).on('change', '#vueloSelect', function () {
        numVuelo = $('#vueloSelect option:selected').text();
    });
    $(document).on('change', '#numMatricula', function () {
        numMatricula = $('#numMatricula option:selected').text();
    });
    $(document).on('change', '#codConductor', function () {
        codConductor = $('#codConductor').val();
    });
    $(document).on('change', '#placa', function () {
        placa = $('#placa option:selected').text();
    });

    //**********************************************************************
    //---------------------------------------------------------------------/

    //**********************************************************************
    //--------------------VALIDANDO Y GRABANDO EL MANIFIESTO----------------
    //**********************************************************************
    $('body').on('click', '#btnGuardarCerrarManif', function () {
        if(funcionValidaCamposVacios() === true){
           precintoI1 = $('#precintoI1').val();
           precintoI2 = $('#precintoI2').val();
           precintoI3 = $('#precintoI3').val();
           
           $.ajax({
            type: 'POST',
            url: 'grabarManifiesto',
            data: 'numVuelo='+numVuelo+'&numMatricula='+numMatricula+'&codConductor='+codConductor+'&placa='+placa+'&precintoI1='+precintoI1+'&precintoI2='+precintoI2+'&precintoI3='+precintoI3+'&totalKilos='+totalKilos+'&totalBultos='+totalBultos+'&totalVolumen='+totalVolumen+'&Rut_origen='+Rut_origen+'&Rut_destin='+Rut_destin+'&totalPrecio='+totalPrecio+'&num_pedidos='+num_pedidos+'&num_pedidosComail='+num_pedidosComail,
                success: function (data) {
                    
                    if(data === 'error'){
                        funcionShowModal('Advertencia', 'Ocurrio un error al registrar el manifiesto. Intentelo nuevamente', 'Entiendo');
                    }else{
                        numManifiesto = data
                        $('#numManifiesto').val(data);
                        $('#btnImprimir').show();
    
                        $('#btnCierreManifiesto').show();
                        
                        
                    }
                }
           });
            
        };
    });
    var funcionValidaCamposVacios = function () {
        if (typeof numVuelo === "undefined") {
            funcionShowModal('Advertencia', 'Debes elegir el numero de vuelo', 'Entiendo');
            return false;
        }
        if (typeof numMatricula === "undefined") {
            funcionShowModal('Advertencia', 'Debes elegir el numero de matricula', 'Entiendo');
            return false;
        }
        if (typeof codConductor === "undefined") {
            funcionShowModal('Advertencia', 'Debes elegir el conductor', 'Entiendo');
            return false;
        }
        if (typeof placa === "undefined") {
            funcionShowModal('Advertencia', 'Debes elegir el numero de placa', 'Entiendo');
            return false;
        }
        if($('#precintoI1').val() === ''){
            funcionShowModal('Advertencia', 'Debes establecer la casilla numero 1 del precinto', 'Entiendo');
            return false;
        }
        if($('#precintoI2').val() === ''){
            funcionShowModal('Advertencia', 'Debes establecer la casilla numero 2 del precinto', 'Entiendo');
            return false;
        }
        if($('#precintoI3').val() === ''){
            funcionShowModal('Advertencia', 'Debes establecer la casilla numero 3 del precinto', 'Entiendo');
            return false;
        }
        
        return true;
    };
    //**********************************************************************

    $('body').on('change', '#Rut_destin', function () {

        Rut_destin = $('#Rut_destin').val();
        $("#tbodyFirst").html("");
        $('#tblPrincipal_ManifiestoPre tbody').append('');
        
    });
    $('body').on('change', '#Rut_origen', function () {
        Rut_origen = $('#Rut_origen').val();
    });

    $(document).on('click', '#btnOk', function () {
        $('#bloqueCreacion').show();
//        $('#btnGuardarCerrarManif').
        funcionDesactivarActivarElemento(1,['btnGuardarCerrarManif']);
        var estadoChecked = $('#checkedEstado').val();

        num_pedidos.length = 0;
        num_pedidosComail.length = 0;
        funcionCapturaItemsChecked();
//        console.log(num_pedidos);
//        num_pedidosComail = funcionCapturaItemsChecked();
        if (num_pedidos.length == 0 && num_pedidosComail.length == 0) {
            funcionShowModal('MENSAJE DE ADVERTENCIA', 'Debes seleccionar como minimo un elemento', 'Entiendo');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'getDesc_bulto',
            data: 'Rut_origen=' + Rut_origen + '&Rut_destin=' + Rut_destin + '&num_pedidos=' + num_pedidos + '&num_pedidosComail='+num_pedidosComail+'&estadoChecked=' + estadoChecked, //array que contiene id de pedidos.
            success: function (data) {
//                    console.log(data);
                var splitInfo = data.split('*');

                $("#tbodyFirst").html("");
                $('#tblPrincipal_ManifiestoPre tbody').append(splitInfo[0]);
                
                totalBultos = splitInfo[1];
                totalKilos = splitInfo[2];
                totalVolumen = splitInfo[3];
                totalPrecio = splitInfo[4];
                
                $('#bultos').html('');
                $('#kilos').html('');
                $('#volumen').html('');
                $('#Total').val('');
                $('#Total').val(totalPrecio);
                
                $('#bultos').html(parseInt(totalBultos));
                $('#kilos').html(totalKilos);
                $('#volumen').html(totalVolumen);
                
                $("#modalCpas").modal('hide');
            }
        });
    });

    var funcionCapturaItemsChecked = function () {
        
        num_pedidos.length = 0;
        num_pedidosComail.length = 0;
//        
        var i = 0;
        var j = 0;
        $("input.chkCpa:checkbox:checked").each(function () {
            if($(this).attr('id')=='chkCpa'){
                num_pedidos[i] = $(this).val();
                i++;
            }else{
                num_pedidosComail[j] = $(this).val();
                j++;
            }
                       
            
        });
//        return num_pedidos;
    };

    $('body').on('click', '#btnImprimir', function () {
        
        var cond = true;
        $.ajax({
            type: 'POST',
            data: 'cond='+cond+'&Rut_destin=' + Rut_destin + '&Rut_origen=' + Rut_origen +'&num_pedidos='+num_pedidos+'&num_pedidosComail='+num_pedidosComail+'&numManifiesto='+numManifiesto,
            url: 'imprimir',
            success: function (data) {
                //subido desde PC HOME
                window.open('../manifiestos_salida/imprimir/');
            }
  
        });

    });

});
