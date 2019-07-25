$(function () {

    var num_ticket;
    var cod_aut_visa;
    var num_tarjeta;
    $('#error_msg').hide();
    $('.teclado').hide();
    $('.internet').hide();
    $('.banco').hide();
    $('.input-number').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#ruc_input').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
//    $("#monto_refund").inputmask('9999999,00');
//    
    $("#monto_refund").inputmask('currency', {
        rightAlign: true
    });
    
    $("body").on("click", "#btn_add_tkt", function () {
        $('#bloque_add_ticket').css("display", "block")
    });
     var contador = 0;
    var elem_ing = [];
    $('#add').click(function () {
        tkt_ingresado = $('.txt_ticket_ingresado').val();
        rfnd_ingresado = $('.txt_refund_ingresado').val();
        $(".html_tickets_add").append($("<div class='form-horizontal'>\n\
                                            <div class='form-group'>\n\
                                                <label for='inputEmail3' class='col-sm-8 control-label'>Ticket adicionado N° "+ (contador+1)+"</label>\n\
                                            <div class='col-sm-4'>\n\
                                                <input type='text' class='form-control' name ='elemento_ticket_ing_"+contador+"' value='"+tkt_ingresado+"'></div>\n\
                                            </div>\n\
                                            <div class='form-group'>\n\
                                                <label for='inputEmail3' class='col-sm-8 control-label'>Refund adicionado N° "+ (contador+1)+"</label>\n\
                                            <div class='col-sm-4'>\n\
                                                <input type='text' class='form-control' name ='elemento_refund_ing_"+contador+"' value='"+rfnd_ingresado+"'></div>\n\
                                            </div>\n\
                                        </div>)"));
        elem_ing[contador] = $.trim($('.html_tickets_add').text());
        
        contador++;
           if(contador>7){
            $('.input_tkt_rfnd').css("display", "none");
        }
        
    });
    $('.onlynumber').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#formulario_reembolso').submit(function (e) {
        console.log(contador);
        e.preventDefault();
        var last_name_pax = $('#last_name_pax').text();
        var first_name_pax = $('#first_name_pax').text();
        var boleto = $('#boleto').text();
        var numero_refund = $('#numero_refund').val();
        var origen_vta = $('#origen_vta').val();
        var med_pago = $('#med_pago').val();
        var monto_refund = $('#monto_refund').val();
        var email_pax = $('#email_pax').val();
        var entidad = $('#entidad').val();
        var ruc_input = $('#ruc_input').val();
        var tarjeta = $('#tarjeta').val();
        var numero_cuenta = $('#numero_cuenta').val();
//        $.ajax({
//            type: "POST",
//            url: '/siststar/refund/registro/RecibeDatosReembolso',
//            data: 'last_name_pax=' + last_name_pax + '&first_name_pax=' + first_name_pax +
//                    '&boleto=' + boleto +
//                    '&numero_refund=' + numero_refund + '&origen_vta=' + origen_vta +
//                    '&med_pago=' + med_pago + '&monto_refund=' + monto_refund + '&email_pax=' + email_pax +
//                    '&entidad=' + entidad + '&ruc_input=' + ruc_input + '&tarjeta=' + tarjeta + '&numero_cuenta=' + numero_cuenta,
//            success: function (data)
//            {
//                console.log(data);
//            }
//        });


    })

    $("#num_ticket").blur(function () {
        $('.SpanDinamic').empty();
        $('.teclado').hide();
        num_ticket = $(this).val();
        if (num_ticket != '') {
            $.ajax({
                type: "POST",
                url: '/siststar/refund/registro/BuscarRegistroEnVentaBoleto',
                data: 'num_ticket=' + num_ticket,
                success: function (data)
                {
//                    console.log(data);
//                    return false;
                    var JsonData = jQuery.parseJSON(data);
                    if (JsonData.success == 'false') {
                        $('#error_msg').show();
                    } else {
                        $('#error_msg').hide();
                        var cod_reserva = JsonData.pnr;
                        tarifa = JsonData.EQ;

                        $('#cod_reserva').html(cod_reserva);

                        if (JsonData.num_orden_compra != '') {
                            $('.internet').show();
                            $('#num_orden_compra').html(JsonData.num_orden_compra);
                            $('#NumeroOrdenCompra').val(JsonData.num_orden_compra);

                            $('#email').html(JsonData.email);
                            $('#cc_code').html(JsonData.cc_code);
                        }

                        $('#last_name_pax').html(JsonData.apellidos);
                        $('#first_name_pax').html(JsonData.nombres);
                        $('#tipo_doc').html(JsonData.tipo_doc);
                        $('#num_doc').html(JsonData.num_doc);
                        $('#ruc').html(JsonData.RUC);
                        $('#ruta').html(JsonData.RutaRef);
                        $('#ruc_input').val(JsonData.RUC);
//                        $('#cod_aut_visa').html(JsonData.cod_autorizacion_vi);
                        cod_aut_visa = JsonData.cod_autorizacion_vi;
                        num_tarjeta = JsonData.num_tarjeta;
                        $('#ruta_post').val(JsonData.RutaRef);
                        $('#clase').html(JsonData.Clase);
                        $('#farebase').html(JsonData.BaseTarifa);
                        $('#boleto').html(JsonData.Boleto);
                        $('#eq_tarifa').html(tarifa);
//                $('#subtotal').html(subtotal);
                        $('#igv').html(JsonData.IGV);
                        $('#tuua').html(JsonData.TUUA);
                        $('#total').html(JsonData.Total);
                        $('#fecha_transaccion_venta').html(JsonData.Fecha_Transaccion);
                        $('#fec_trans').val(JsonData.fec_trans);

                        $('#forma_pago').html(JsonData.FormaPago);
                        $('#tipo_agencia').html(JsonData.TipoAgencia);
                        $('#nombre_agente').html(JsonData.NomAgente);
                        $('#des_forma').html(JsonData.FormaDescripcion);
                    }

                    $('.teclado').show();
                }
            });
        }
    });

    $(".add").hide();
    $(".numcuenta").hide();
    $(".osce").hide();
    $(".med_pago").hide();
//    $("#cash").hide();

    $('#borrar').click(function () {
        $(".med_pago").hide();
    });

    $("#med_pago").change(function () {
        $(".med_pago").hide();
        $(".add").hide();
        $(".osce").hide();
        $(".numcuenta").hide();
        var id_medpag = $(this).val();
        switch (id_medpag) {
            case 'OS':
                $(".osce").show();
                $(".banco").hide();
//                alert(num_ticket);
                break;
            case 'PE':
                $(".banco").show();
                $(".numcuenta").show();
//                $(".banco").hide();
                break;
            case 'PP':
                $(".numcuenta").show();
//                $(".banco").hide();
                break;
            case 'SF':
                $(".banco").show();
                $(".numcuenta").show();
//                $(".banco").hide();
                break;
            case 'CA':
//                $(".").show();
                $(".numcuenta").show();
                $(".banco").show();
                break;
            case 'TJ':
                $(".add").show();
                $(".banco").hide();
                $(".numcuenta").show();
                $("#cod_aut").val(cod_aut_visa);
                $("#num_tarjeta").val(num_tarjeta);
                break;
            case 'frau':
                $("#card").show();

                break;
        }
    });

});

