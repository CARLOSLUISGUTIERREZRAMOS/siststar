
// ***** CONFIGURANDO EL DATERANGEPICKES********

//$('#daterangepicker').daterangepicker({
//    "locale": {
//        "format": "DD/MM/YYYY",
//        "separator": " - ",
//        "applyLabel": "Aplicar",
//        "cancelLabel": "Cancelar",
//        "fromLabel": "Desde",
//        "toLabel": "Hasta",
//        "customRangeLabel": "Custom",
//        "daysOfWeek": [
//            "Do",
//            "Lu",
//            "Ma",
//            "Mi",
//            "Ju",
//            "Vi",
//            "Sa"
//        ],
//        "monthNames": [
//            "Enero",
//            "Febrero",
//            "Marzo",
//            "Abril",
//            "Mayo",
//            "Junio",
//            "Julio",
//            "Agosto",
//            "Septiembre",
//            "Octubre",
//            "Noviembre",
//            "Diciembre"
//        ],
//        "firstDay": 1
//    }
//})
// ***** .CONFIGURANDO EL DATERANGEPICKES********
//
//$(document).ready(function() {
////    $('#table_main').DataTable({
////        fixedHeader: {
////            header: true,
////            footer: true
////        }
////    } );
//});
var setOrderColumnDataTable = function (numColumn, orden) {
    $("#table_main").dataTable({
//        "order": [[numColumn, orden]],
//        "ordering": false
    });
}



//___________________________       SOLO NUMERO         _____________________________\\
$(".soloNum").keydown(function (event) {
    //alert(event.keyCode);
    if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 190 && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) {
        return false;
    }
});
//____________________________________________________________________________________\\

var funcionHoy = function () {
    return $.datepicker.formatDate('dd/mm/yy', new Date());
};
var funcionDatePicker = function (bool) {
//    alert(funcionHoy());
    var date_input = $('input[name="date"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true, // Pinta la fecha del día actual
        autoclose: true,

//        defaultDate: new Date(funcionHoy()),
//        appendText: "(dd/mm/yyyy)"
    };
    date_input.datepicker(options);
};




var funcionGetDateToday = function () {
    return $.datepicker.formatDate('dd/mm/yy', new Date());
};

var funcionDesactivarActivarElemento = function (condicion, inputsArray) {
    //el parametro inputsArray debe venir como un array =>['nombreDeID']
    $.each(inputsArray, function (i, idInput) {
        switch (condicion) {
            case 0: //0 = Deshabilita Elementos
                $('#' + idInput + '').prop('disabled', true);
                break;
            case 1: // 1 = Habilita Elementos
                $('#' + idInput + '').prop('disabled', false);
                break;
        }
    });
};

var funcionOcultaMuestraElemento = function (action, inputsArray) {

    $.each(inputsArray, function (i, idInput) {

        switch (action) {
            case 0: //0 = Ocultar Elementos
                $('#' + idInput + '').hide();
                break;
            case 1: // 1 = Muestra Elementos
                $('#' + idInput + '').show();
                break;
        }

    });
};

var funcionLimpiaInputs = function (inputsArray) {
    $.each(inputsArray, function (i, idInput) {
        $('#' + idInput).val('');
    });
};

var funcionesClick = function (accion, idInput, setValue) {

    $('#' + idInput).click(function () {

        switch (accion) {
            case 'setDate':
                $(this).datepicker(accion, setValue);
                break;
            default :
                $(this).val(setValue);
        }
    });
};

var funcionDatePickerShow = function (idInput) {
    var date_input = $(idInput); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true
    };
    date_input.datepicker(options);
};

var funcionShowModal = function (titulo, msg, nameboton, tipomodal, btnplusbool, namebtnplus) {
    //@Parametro1 = Titulo en header de cabecera modal
    //@Parametro2 = Mensaje en el body de modal
    //@Parametro3 = Texto en el boton
    //@Parametro4 = Tipo Modal
    //@Parametro5 = Se muestra o no el boton izquierdo
    //@Parametro6 = El nombre del boton izquierdo

    $("#modal_generico").addClass(tipomodal);
    if (btnplusbool) {
        $('#btnLeft').html(namebtnplus);
        $('#btnLeft').show();
    } else {
        $('#btnLeft').hide();
    }

    $('#tituloModal').html(titulo);
    $('#msg').html(msg);
    $('#botonModal').html(nameboton);
    $("#modal_generico").modal({
        backdrop: 'static', // opcion que no permite salir con un clic fuera del
        keyboard: true
    });
};

var funcionDetenSiExisteCampoVacio = function (camposObjetos) {
    for (var data in camposObjetos) {
        if (camposObjetos[data] == '') {
            return false;
        }
    }
    return true;
};

var funcionFilledInputs = function (args, opc) {

    $.each(args, function (key, value) {
        switch (opc) {
            case 'VAL':
                $('#' + key).val(value);
                break;
            case 'TEXT':
                $('#' + key).text(value);
                break;
        }

    });
};
var funcionSpanShowHiddenActionMoment = function (action, text) {
    $('#actionMoment').append(text);
    funcionOcultaMuestraElemento(action, ['actionMoment']);
};

function muestraAlert() {
    alert('esto es llamado desde en controlador');
}
;