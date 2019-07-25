$(function () {
    funcionOcultaMuestraElemento(0, ["btnGrabar", "btnCancelar"]);
    $.getScript("../../js/app/genericas.js");  //LLAMANDO AL FICHERO DONDE TENEMOS FUNCIONES GENERICAS
    $("#table_main").dataTable();
//    setOrderColumnDataTable(1,'desc'); // COL 0 COL 1 ... COL 1(FECHA)
    funcionDatePicker();
    //<editor-fold defaultstate="collapsed" desc="VARIABLES">

    var orden = "DESC";
    var buscarBool;
    var buscarRangoBool = false;
    var todaysDate;
//    var dateLast; REFACT
    var numBtn = 1;
    var fecha;
    var compraCambComerc;
    var ventaCambComerc;
    var compraCambOfi;
    var ventaCambOfi;
    var creador;
    var creador_fecha;
    var modificador;
    var modificacion_fecha;
    var accionGrabar;
    //</editor-fold>
    
    
    //<editor-fold defaultstate="collapsed" desc="VALORES INCIALES QUE TRAE EL CONTROLADOR - CAPTURA">
//    $fechaHoy = funcionGetDateToday();  AUN SIN USAR
//    dateLast = $("#dateFrom").val(); REFACT
    fecha = $("#dateFrom").val();
    dateLimit = $('#dateLimit').val();
    tcambComCompraLast = $("#tcambComCompra").val();
    tcambComVentaLast = $("#tcambComVenta").val();
    tcambOfiCompraLast = $("#tcambOfiCompra").val();
    tcambOfiVentaLast = $("#tcambOfiVenta").val();
    name_modificador = $('#name_modificador').text();

    //</editor-fold>

    $('body').on('click', '#btnCrear', function () {
        accionGrabar = "INSERT";
        buscarBool = false;
        todaysDate = $.datepicker.formatDate('dd/mm/yy', new Date());  //CAPTURAMOS LA FECHA DE HOY CON LA FUNCION JQuery

        $("#dateFrom").val(todaysDate);
        funcionesClick('setDate', 'dateFrom', todaysDate); //ESTA FUNCION ESTABLECE EL VALOR DEL INPUT AL MOMENTO DE DAR CLICK
        $("#dateLimit").val(todaysDate);
        funcionesClick('setDate', 'dateLimit', todaysDate);

        var inputs = ["btnGrabar", "btnCancelar"];
        var inputsDeshabi = ["btnCrear", "btnEditar", "btnBuscar"];
        var inputsHabilitar = ["dateFrom", "dateLimit", "tcambComCompra", "tcambComVenta", "tcambOfiCompra", "tcambOfiVenta"];
        var inputsLimpiar = ["tcambComCompra", "tcambComVenta", "tcambOfiCompra", "tcambOfiVenta"];
        funcionLimpiaInputs(inputsLimpiar);

        funcionOcultaMuestraElemento(1, inputs);
        funcionDesactivarActivarElemento(0, ['btnInicio', 'btnAnterior', 'btnSiguiente', 'btnUltimo', 'btnCrear']);
        funcionDesactivarActivarElemento(0, inputsDeshabi);
        funcionDesactivarActivarElemento(1, inputsHabilitar);
    });

    $('body').on('click', '#btnCancelar', function () {
        $("#dateFrom").val(fecha);
        $("#tcambComCompra").val(compraCambComerc);
        $("#tcambComVenta").val(tcambComVentaLast);
        $("#tcambOfiCompra").val(tcambOfiCompraLast);
        $("#tcambOfiVenta").val(tcambOfiVentaLast);
        var inputs = ["btnGrabar", "btnCancelar"];
        var inputsEventCrear = ["btnCrear", "btnEditar", "btnBuscar"];
        var inputsDeshab = ["dateFrom", "dateLimit", "tcambComCompra", "tcambComVenta", "tcambOfiCompra", "tcambOfiVenta", "creador", "modificador"];

        funcionLimpiaInputs(["dateLimit"]);
        funcionOcultaMuestraElemento(0, inputs);
        funcionDesactivarActivarElemento(1, inputsEventCrear);
        funcionDesactivarActivarElemento(1, ['btnInicio', 'btnAnterior', 'btnSiguiente', 'btnUltimo', 'btnCrear']);
        funcionDesactivarActivarElemento(0, inputsDeshab);

    });

    $('body').on('click', '#btnAnterior', function () {
        numBtn = (orden != "ASC") ? numBtn + 1 : numBtn - 1;
        $('#name_modificador').val('');
        parametrosValor = 'orden=' + orden;
        funcionAjaxGetPreviousNext(numBtn, parametrosValor);
    });

    $('body').on('click', '#btnSiguiente', function () {
        numBtn = (orden != "ASC") ? numBtn - 1 : numBtn + 1;
        parametrosValor = 'orden=' + orden;
        funcionAjaxGetPreviousNext(numBtn, parametrosValor);
    });

    $('body').on('click', '#btnUltimo', function () {
        orden = "DESC";
        numBtn = 1;
        parametrosValor = 'orden=' + orden;
        funcionAjaxGetPreviousNext(numBtn, parametrosValor);
    });

    $('body').on('click', '#btnInicio', function () {
        orden = "ASC";
        numBtn = 1;
        parametrosValor = 'orden=' + orden;
        funcionAjaxGetPreviousNext(numBtn, parametrosValor);

    });

    $('body').on('click', '#btnEditar', function () {
        accionGrabar = "UPDATE";
        funcionDesactivarActivarElemento(0, ['btnInicio', 'btnAnterior', 'btnSiguiente', 'btnUltimo', 'btnCrear', 'btnBuscar']);
        funcionOcultaMuestraElemento(1, ['btnGrabar', 'btnCancelar']);
        funcionDesactivarActivarElemento(1, ['tcambComCompra', 'tcambComVenta', 'tcambOfiCompra', 'tcambOfiVenta']);

    })

    $('body').on('click', '#btnGrabar', function () {
        var url;
        //        alert(fecha);
        fecha = $('#dateFrom').val();

        var dateLimit = $('#dateLimit').val();
        var camposObjetos = new Object();
        
        camposObjetos.compraCambComerc = $('#tcambComCompra').val();
        camposObjetos.ventaCambComerc = $('#tcambComVenta').val();
        camposObjetos.compraCambOfi = $('#tcambOfiCompra').val();
        camposObjetos.ventaCambOfi = $('#tcambOfiVenta').val();
     
        if (!funcionDetenSiExisteCampoVacio(camposObjetos)) {
            funcionShowModal('MENSAJE STARPERU', 'Debe completar los campos de tipo de cambio', 'ENTIENDO');
            return false;
        }

        switch (accionGrabar) {
            case 'INSERT':
                url = '../tipo_cambio/insert';
                break;

            case 'UPDATE':
                url = '../tipo_cambio/edit';
                break;
        }

        $.ajax({
            type: 'POST',
            data: 'compra_ofi=' + camposObjetos.compraCambOfi + '&venta_ofi=' + camposObjetos.ventaCambOfi + "&compra_com=" + camposObjetos.compraCambComerc + "&venta_com=" + camposObjetos.ventaCambComerc + "&fecha=" + fecha + "&dateLimit=" + dateLimit,
            url: url,
            success: function (data) {
                var titulo = 'MENSAJE STARPERU: ';
                var nameboton = 'Continuar';
                funcionShowModal(titulo, data, nameboton);
                $('#botonModal').click(function(){
                        window.location.reload(true);
                })
            }
        })
    })

    $('#dateFrom').change(function () {

        if (buscarBool) {
            fecha = $("#dateFrom").val();
            var where = "WHERE CAST(fecha AS DATETIME) = " + " ' " + fecha + " ' ";
            parametrosValor = "where=" + where;
            funcionAjaxGetPreviousNext(1, parametrosValor);

        }

    });

    $('body').on('click', '#btnBuscar', function () {
            
        buscarBool = true;
        funcionDesactivarActivarElemento(1, ['dateFrom']);
        $('#dateFrom').focus();

    });
    $('body').on('click', '#btnBuscarRango', function () {
        
        buscarRangoBool = true;
        fecha = $('#dateFrom').val();
        dateLimit = $('#dateLimit').val();
        parametrosValor = "dateFrom=" + fecha + "&dateLimit=" + dateLimit;
        $.ajax({
            type: 'POST',
            data: parametrosValor,
            url: '../tipo_cambio/relacionBuscarRangoFechas',
            success: function (data) {
                $('#bodyTable').html('');
                $('#bodyTable').append(data);
            }
        });

    });


    var funcionAjaxGetPreviousNext = function (numBtn, parametrosValor) {

        $.ajax({
            type: 'POST',
            data: 'numBtnAnterior=' + numBtn + "&" + parametrosValor,
            url: '../tipo_cambio/firstInfo',
            success: function (data) {
                console.log(data);
                dataSegments = data.split("|");
                fecha = dataSegments[0];
                compraCambOfi = dataSegments[1];
                ventaCambOfi = dataSegments[2];
                compraCambComerc = dataSegments[3];
                ventaCambComerc = dataSegments[4];
                creador = dataSegments[5];
                modificador = dataSegments[6];
                modificacion_fecha = dataSegments[7];
                creador_fecha = dataSegments[8];

                var lista = {
                    "dateFrom": fecha,
                    "tcambOfiCompra": compraCambOfi,
                    "tcambOfiVenta": ventaCambOfi,
                    "tcambComCompra": compraCambComerc,
                    "tcambComVenta": ventaCambComerc,
                    "fechaModificacion": modificacion_fecha,
                    "fecha_creacion": creador_fecha
                };
                var lista2 = {
                    "name_creador": creador,
                    "name_modificador": modificador
                }
                funcionFilledInputs(lista, 'VAL');
                funcionFilledInputs(lista2, 'TEXT');
            }


        });

    }

    $('body').on('click', '#btnImprimir', function () {
        
        if (buscarRangoBool) {
            var cont_tbl = $('#bodyTable').html();
            $.ajax({
                type: 'POST',
                data: 'cont_tbl=' + cont_tbl,
                url: '../tipo_cambio/imprimir',
                success: function (data) {
//                    console.log(data);
                    window.open ('../tipo_cambio/imprimir/');
                }

            });
        }else{
            funcionShowModal('Mensaje Star Perú','Debe seleccionar un rango de fechas','Entiendo');
        }
       
    });
    
    
    $('body').on('click','#btnRefrescaCache',function(){
        window.location.reload(true); 
    });

});
