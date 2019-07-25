$(function () {

    $.getScript("../js/app/genericas.js");
    funcionOcultaMuestraElemento(0, ['btn_cancelar', 'btn_aceptar', 'tabla_tax_corpac']);

    $('#form_corpac').inputmask('9.99', {numericInput: true});
    $('#form_manipuleo').inputmask('9.99', {numericInput: true});
    $('#form_min_corpac').inputmask('9.99', {numericInput: true});
    $('#form_min_manipuleo').inputmask('9.99', {numericInput: true});
    $('#form_igv_venta').inputmask('9.99', {numericInput: true});
    $('#form_igv_compra').inputmask('9.99', {numericInput: true});


    $("form").submit(function (event) {

        event.preventDefault();
        var action = $(this).attr('action');
        var dataSerializada = $("form :input").serialize();
        console.log(dataSerializada );
        
    });
    

    $('#btn_cancelar, #btn_form_cancel').click(function () {
        location.reload();
    });
    $('#select_origen').select2({
        disabled: true
    });

    $('#buscar').click(function () {

        funcionOcultaMuestraElemento(1, ['btn_cancelar', 'btn_aceptar']);
        $('#select_origen').select2({
            disabled: false
        });

    });

    $('#btn_crear').click(function () {
        funcionOcultaMuestraElemento(1, ['bloque_nuevoTax']);
        $('#select_origen').select2({
            disabled: false
        });
    });

    $('#btn_aceptar').click(function () {
        $('.table tbody').empty();
        if (typeof origen === 'undefined') {
            funcionShowModal('Advertencia', 'Debe seleccionar la localidad de origen', 'Entiendo', 'modal-warning');
            return false;

        }

        $.post("tarifas_tax_corpac/buscarTaxes", {'origen': origen}, function (data) {
            var CAR_TAXES = JSON.parse(data);
            var newRow =
                    "<tr>"
                    + "<td>" + CAR_TAXES.Fec_ini + "</td>"
                    + "<td>" + CAR_TAXES.Fec_fin + "</td>"
                    + "<td>" + CAR_TAXES.Corpac + "</td>"
                    + "<td>" + CAR_TAXES.QFuel + "</td>"
                    + "<td>" + CAR_TAXES.Manipuleo + "</td>"
                    + "<td>" + CAR_TAXES.Igv_venta + "</td>"
                    + "</tr>";

            $('.table tbody').append(newRow);
            funcionOcultaMuestraElemento(1, ['tabla_tax_corpac']);
        })

    });

    $('#select_origen').change(function () {
        origen = $(this).val();

    })


    var origen;
});
