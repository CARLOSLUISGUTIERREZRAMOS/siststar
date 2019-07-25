$(function () {
    $('.rango_ini_fin').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

    $('#tbl_report_trans').DataTable({
        'paging': true,
//        'lengthChange': false,
//        'searching': false,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'order': []
    })
    $("body").on("click", ".btn_tkt", function () {
//    $('.btn_tkt').click(function (event) {
        event.preventDefault();
        var reserva_id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: 'BuscarTickets',
            data: 'reserva_id=' + reserva_id,
            success: function (data)
            {
                $('#campo_modal').html(data);
                $('#modal-reservadetalle').modal('show');
            }
        });
    });

    $("body").on("click", ".btn_cancelar_reserva", function () {
//    $('.btn_cancelar_reserva').click(function () {
        var reserva_id = $(this).attr('id');
        var pnr = $(this).attr('name');
        $("#modal_metodo_pago").modal('hide');
//        $('#modal-cancelar_reserva_confirma').modal('show');
        $.ajax({
            type: "POST",
            url: 'anular_reserva_kiu',
            data: 'reserva_id=' + reserva_id + '&pnr=' + pnr,
            success: function (data)
            {
                $('#modal-reservadetalle').modal('show');
                $('#campo_modal').html(data);
                $('#modal-reservadetalle').modal('show');
                setTimeout(function() {
                    $("#transacciones_form").submit();
                }, 3000);
            }
        });
    });

    $("body").on("click", ".btn_email", function () {
        var reserva_id = $(this).attr('id');
        $("#modal_metodo_pago").modal('hide');
        $.ajax({
            type: "POST",
            url: 'EnviarEmailPasajero',
            data: 'reserva_id=' + reserva_id,
            success: function (data)
            {
                $("#modal-boleto-enviado").modal();
                $("#modal-boleto-enviado p").html(data);
                setTimeout(function() {
                    $("#modal-boleto-enviado").modal('hide');
                }, 3000);
            }
        });

    });

    $("body").on("click", ".btn_generar_boletos", function () {
        $('#modal_generar_boletos').modal({
            keyboard: false
        });
        $("#modal_metodo_pago").modal('hide');
        $('#modal_generar_boletos').modal('show');

        var id_pnr = $(this).attr('id');
        var id_pnr_split = id_pnr.split('|');
        var cc_code = id_pnr_split[0];
        var id_reserva = id_pnr_split[1];
        var id = id_pnr_split[2];
        $("#btn_acepta_genboletos").data('obj',{'cc_code':cc_code,'id_reserva':id_reserva,'id':id});
    });

    $('#btn_acepta_genboletos').click(function () {
        $('#modal_generar_boletos').modal('hide');
        var obj=$("#btn_acepta_genboletos").data('obj');
        showGif();
        $.ajax({
            type: "POST",
            url: 'GenerarBoletos',
            data: 'id_reserva=' + obj.id_reserva+'&cc_code='+obj.cc_code+'&id='+obj.id,
            success: function (data){
                $("#btn_acepta_genboletos").data('id','');
                hideGif();
                console.log(data);
                var rs_controller_gentkt = data.split('|');
                var cod_res = rs_controller_gentkt[0];
                var msg_res = rs_controller_gentkt[1];

                switch (parseInt(cod_res)) {
                    case 1:
                        $('#mensaje_exito').text(msg_res);
                        $('#modal-exito').modal('show');
                        break;
                    case 2:
                        $('#texto_modal_danger').text(msg_res);
                        $('#modal_inconsistencia').modal('show');
                        break;
                    case 3:
                        $('#mensaje_exito').text(msg_res);
                        $('#modal-exito').modal('show');
                        break;
                    case 4:
                        $('#mensaje_exito').text(msg_res);
                        $('#modal-exito').modal('show');
                        break;
                    case 21120:
                        $('#texto_modal_danger').text(msg_res);
                        $('#modal_inconsistencia').modal('show');
                        break;
                    default:
                        $('#texto_modal_danger').text(data);
                        $('#modal_inconsistencia').modal('show');
                        break;
                        console.log(msg_res);
                }
                setTimeout(function() {
                    $("#transacciones_form").submit();
                    // location.reload();
                }, 4000);
            }
        });
    });

    function mostrarBotonesTransaccion(id,pnr) {
        var footer=$("#modal_metodo_pago .panel-footer");
        footer.html('<button id="'+id+'" name="'+pnr+'" type="button" class="btn btn-danger btn-xs btn_cancelar_reserva" title="">'+
                        'Eliminar boletos <span class="fa fa-trash-o"></span>'+
                    '</button> '+
                    '<button id="'+id+'" type="button" class="btn btn-primary btn-xs btn_email" title="">'+
                        'Reenviar boleto(s) <span class="fa fa-envelope-o"></span>'+
                    '</button>');
    }

    $(document).on('click','a.btn-metodo-pago',function (elem) {
        var cc=this.id;
        var name=this.name.split('|');
        if (name[0]==1) {
            mostrarBotonesTransaccion(name[1],name[2]);
        }
        else{
            $("#modal_metodo_pago .panel-footer").html('');
        }
        var cc_code=this.id.split('|')[1];
        $("select[name=medio_pago]").val("").trigger('change');
        $.ajax({
            type: "POST",
            url: 'DetalleMetodoPago',
            data: 'data=' + cc,
            success: function (data){
                var objeto=JSON.parse(data);
                var table=$("#modal_metodo_pago .table-responsive");
                table.empty();
                if (cc_code=='PP') {
                    mostrarTablaPaypal(objeto.paypal);
                    if (objeto.safetypay.length>0) {
                        mostrarTablaSafetypal(objeto.safetypay);
                    }
                    if (objeto.pagoefectivo.length>0) {
                        mostrarTablaPagoEfectivo(objeto.pagoefectivo);
                    }
                    if (objeto.visa.length>0) {
                        mostrarTablaVisa(objeto.visa);
                    }
                }
                else if (cc_code=='SP') {
                    mostrarTablaSafetypal(objeto.safetypay);
                    if (objeto.paypal.length>0) {
                        mostrarTablaPaypal(objeto.paypal);
                    }
                    if (objeto.pagoefectivo.length>0) {
                        mostrarTablaPagoEfectivo(objeto.pagoefectivo);
                    }
                    if (objeto.visa.length>0) {
                        mostrarTablaVisa(objeto.visa);
                    }
                }
                else if (cc_code=='PE') {
                    mostrarTablaPagoEfectivo(objeto.pagoefectivo);
                    if (objeto.paypal.length>0) {
                        mostrarTablaPaypal(objeto.paypal);
                    }
                    if (objeto.safetypay.length>0) {
                        mostrarTablaSafetypal(objeto.safetypay);
                    }
                    if (objeto.visa.length>0) {
                        mostrarTablaVisa(objeto.visa);
                    }
                }
                else{
                    mostrarTablaVisa(objeto.visa);
                    if (objeto.paypal.length>0) {
                        mostrarTablaPaypal(objeto.paypal);
                    }
                    if (objeto.safetypay.length>0) {
                        mostrarTablaSafetypal(objeto.safetypay);
                    }
                    if (objeto.pagoefectivo.length>0) {
                        mostrarTablaPagoEfectivo(objeto.pagoefectivo);
                    }
                }
                $("#modal_metodo_pago").modal();
            }
        });
    });

    function mostrarTablaPaypal(objetos) {
        var table=$("#modal_metodo_pago .table-responsive");
        // table.empty();
        var btn=0;
        $.each(objetos,function (index,val) {
            if (val.resultado_metodo=="Success" || val.resultado_metodo=="SuccessWithWarning") {
                btn=val.id;
            }
        });
        var t= '<table class="table" style="border: solid 1px #aba1a2a6;">'+
                    '<thead>'+
                        '<tr align="center" style="background: #e7e8ef;">'+
                            '<td colspan="6">PAYPAL</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<th>#</th>'+
                            '<th>Estado</th>'+
                            '<th>Codigo Error</th>'+
                            '<th>Mensaje</th>'+
                            '<th>$ transacción</th>'+
                            '<th></th>'+
                        '</tr>'+
                    '</thead>';
        t +='<tbody>';
        if (objetos.length>0) {
            $.each(objetos,function (index,val) {
                if (btn==val.id) {
                    // var button='<button id="'+val.pnr+'|'+val.reserva_id+'" name="'+val.cc_code+'|'+val.ruc+'" type="button" class="btn btn-success btn-xs btn_generar_boletos" title="Generar boleto(s)">'+
                    //                 '<span class="fa fa-fw fa-bolt"></span>'+
                    //             '</button>';
                    var button='<button id="'+val.cc_code+'|'+val.reserva_id+'|'+val.id+'" name="'+val.pnr+'|'+val.ruc+'" type="button" class="btn btn-success btn-xs btn_generar_boletos" title="Generar boleto(s)">'+
                                    '<span class="fa fa-fw fa-bolt"></span>'+
                                '</button>';
                    var style='style="background: #2eee2e2b;"';
                }
                else{
                    var button='';
                    var style='';
                }
                t+='<tr '+style+'>'+
                        '<td>'+(index+1)+'</td>'+
                        '<td>'+val.resultado_metodo+'</td>'+
                        '<td>'+val.cod_error+'</td>'+
                        '<td>'+val.mensaje+'</td>'+
                        '<td>'+val.monto_transaccion+'</td>'+
                        '<td>'+button+'</td>'+
                    '</tr>';
            });
        }
        else{
            t+='<tr>'+
                    '<td colspan="6">Sin Transacciones</td>'+
                '</tr>';
        }
        t +='   </tbody>'+
            '</table>';
        table.append(t);
    }

    function mostrarTablaSafetypal(objetos) {
        var table=$("#modal_metodo_pago .table-responsive");
        // table.empty();
        var btn=0;
        $.each(objetos,function (index,val) {
            if (val.codigo_estado=="102") {
                btn=val.id;
            }
        });
        var t= '<table class="table" style="border: solid 1px #aba1a2a6;">'+
                    '<thead>'+
                        '<tr align="center" style="background: #e7e8ef;">'+
                            '<td colspan="7">SAFETYPAY</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<th>#</th>'+
                            '<th>Estado</th>'+
                            '<th>Codigo Pago</th>'+
                            '<th>Descripción</th>'+
                            '<th>Fecha Operación</th>'+
                            '<th>Fecha Confirmación</th>'+
                            '<th></th>'+
                        '</tr>'+
                    '</thead>';
        t +='<tbody>';
        if (objetos.length>0) {
            $.each(objetos,function (index,val) {
                if (btn==val.id) {
                    // var button='<button id="'+val.pnr+'|'+val.reserva_id+'" name="'+val.cc_code+'|'+val.ruc+'" type="button" class="btn btn-success btn-xs btn_generar_boletos" title="Generar boleto(s)">'+
                    //                 '<span class="fa fa-fw fa-bolt"></span>'+
                    //             '</button>';
                    var button='<button id="'+val.cc_code+'|'+val.reserva_id+'|'+val.id+'" name="'+val.pnr+'|'+val.ruc+'" type="button" class="btn btn-success btn-xs btn_generar_boletos" title="Generar boleto(s)">'+
                                    '<span class="fa fa-fw fa-bolt"></span>'+
                                '</button>';
                    var style='style="background: #2eee2e2b;"';
                }
                else{
                    var button='';
                    var style='';
                }
                t+='<tr '+style+'>'+
                        '<td>'+(index+1)+'</td>'+
                        '<td>'+val.codigo_estado+'</td>'+
                        '<td>'+val.cod_pago+'</td>'+
                        '<td>'+val.descripcion_estado+'</td>'+
                        '<td>'+(val.fecha_operacion ? moment(val.fecha_operacion).format('DD-MM-YYYY H:m:s') : '')+'</td>'+
                        '<td>'+(val.fecha_confirmacion ? moment(val.fecha_confirmacion).format('DD-MM-YYYY H:m:s') : '')+'</td>'+
                        '<td>'+button+'</td>'+
                    '</tr>';
            });
        }
        else{
            t+='<tr>'+
                    '<td colspan="7">Sin Transacciones</td>'+
                '</tr>';
        }
        t +='   </tbody>'+
            '</table>';
        table.append(t);
    }

    function mostrarTablaPagoEfectivo(objetos) {
        var table=$("#modal_metodo_pago .table-responsive");
        // table.empty();
        var btn=0;
        $.each(objetos,function (index,val) {
            if (val.estado_cip=="cip.paid") {
                btn=val.id;
            }
        });
        var t= '<table class="table" style="border: solid 1px #aba1a2a6;">'+
                    '<thead>'+
                        '<tr align="center" style="background: #e7e8ef;">'+
                            '<td colspan="7">PAGO EFECTIVO</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<th>#</th>'+
                            '<th>Estado CIP</th>'+
                            '<th>Codigo CIP</th>'+
                            '<th>Monto</th>'+
                            '<th>Fecha Operación</th>'+
                            '<th>Fecha Confirmación</th>'+
                            '<th></th>'+
                        '</tr>'+
                    '</thead>';
        t +='<tbody>';
        if (objetos.length>0) {
            $.each(objetos,function (index,val) {
                if (btn==val.id) {
                    // var button='<button id="'+val.pnr+'|'+val.reserva_id+'" name="'+val.cc_code+'|'+val.ruc+'" type="button" class="btn btn-success btn-xs btn_generar_boletos" title="Generar boleto(s)">'+
                    //                 '<span class="fa fa-fw fa-bolt"></span>'+
                    //             '</button>';
                    var button='<button id="'+val.cc_code+'|'+val.reserva_id+'|'+val.id+'" name="'+val.pnr+'|'+val.ruc+'" type="button" class="btn btn-success btn-xs btn_generar_boletos" title="Generar boleto(s)">'+
                                    '<span class="fa fa-fw fa-bolt"></span>'+
                                '</button>';
                    var style='style="background: #2eee2e2b;"';
                }
                else{
                    var button='';
                    var style='';
                }
                t+='<tr '+style+'>'+
                        '<td>'+(index+1)+'</td>'+
                        '<td>'+val.estado_cip+'</td>'+
                        '<td>'+val.cip+'</td>'+
                        '<td>'+val.amount+'</td>'+
                        '<td>'+(val.fecha_operacion ? moment(val.fecha_operacion).format('DD-MM-YYYY H:m:s') : '')+'</td>'+
                        '<td>'+(val.fecha_confirmacion ? moment(val.fecha_confirmacion).format('DD-MM-YYYY H:m:s') : '')+'</td>'+
                        '<td>'+button+'</td>'+
                    '</tr>';
            });
        }
        else{
            t+='<tr>'+
                    '<td colspan="5">Sin Transacciones</td>'+
                '</tr>';
        }
        t +='   </tbody>'+
            '</table>';
        table.append(t);
    }

    function mostrarTablaVisa(objetos) {
        var table=$("#modal_metodo_pago .table-responsive");
        // table.empty();
        var btn=0;
        $.each(objetos,function (index,val) {
            if (val.status=="Authorized") {
                btn=val.id;
            }
        });
        var t= '<table class="table" style="border: solid 1px #aba1a2a6;">'+
                    '<thead>'+
                        '<tr align="center" style="background: #e7e8ef;">'+
                            '<td colspan="7">VISA</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<th>#</th>'+
                            '<th>Estado</th>'+
                            '<th>Card</th>'+
                            '<th>Card N°</th>'+
                            '<th>Descripción</th>'+
                            '<th>Monto Autorizado</th>'+
                            // '<th>Fecha Operación</th>'+
                            // '<th>Fecha Confirmación</th>'+
                            '<th></th>'+
                        '</tr>'+
                    '</thead>';
        t +='<tbody>';
        if (objetos.length>0) {
            $.each(objetos,function (index,val) {
                if (btn==val.id) {
                    // var button='<button id="'+val.pnr+'|'+val.reserva_id+'" name="'+val.cc_code+'|'+val.ruc+'" type="button" class="btn btn-success btn-xs btn_generar_boletos" title="Generar boleto(s)">'+
                    //                 '<span class="fa fa-fw fa-bolt"></span>'+
                    //             '</button>';
                    var button='<button id="'+val.cc_code+'|'+val.reserva_id+'|'+val.id+'" name="'+val.pnr+'|'+val.ruc+'" type="button" class="btn btn-success btn-xs btn_generar_boletos" title="Generar boleto(s)">'+
                                    '<span class="fa fa-fw fa-bolt"></span>'+
                                '</button>';
                    var style='style="background: #2eee2e2b;"';
                }
                else{
                    var button='';
                    var style='';
                }
                var card=val.brand ? (val.brand=='visa'? 'VI' : (val.brand=='mastercard'? 'MC' : (val.brand=='amex'? 'AX' : 'DC'))) : '';
                t+='<tr '+style+'>'+
                        '<td>'+(index+1)+'</td>'+
                        '<td>'+val.status+'</td>'+
                        '<td>'+card+'</td>'+
                        '<td>'+val.card+'</td>'+
                        '<td>'+val.action_description+'</td>'+
                        '<td>$ '+val.authorized_amount+'</td>'+
                        // '<td>'+val.fecha_operacion ? moment(val.fecha_operacion).format('DD-MM-YYYY H:m:s'): ''+'</td>'+
                        // '<td>'+val.fecha_confirmacion ? moment(val.fecha_confirmacion).format('DD-MM-YYYY H:m:s'): ''+'</td>'+
                        '<td>'+button+'</td>'+
                    '</tr>';
            });
        }
        else{
            t+='<tr>'+
                    '<td colspan="7">Sin Transacciones</td>'+
                '</tr>';
        }
        t +='   </tbody>'+
            '</table>';
        table.append(t);
    }

    $(document).on('change','select[name=medio_pago]',function (e) {
        if (this.value==1) {
            generarFormularioTarjeta();
        }
        else if (this.value==2) {
            generarFormularioBanco();
        }
        else{
            $("#form-panels").empty();
        }
    });

    function generarFormularioTarjeta() {
        var panel=$("#form-panels");
        var t= '<div class="panel panel-default">'+
                    '<div class="panel-heading">'+
                        '<span class="fa fa-ticket"></span> GENERAR BOLETO(S) DE PAGO'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<form id="form-datos"></form>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>CC CODE</label>'+
                                '<span class="pull-right">(**)</span>'+
                                '<select name="cc_code" class="form-control input-sm" form="form-datos">'+
                                    '<option value="VI">VISA</option>'+
                                    '<option value="DC">DYNERS</option>'+
                                    '<option value="MC">MASTER CARD</option>'+
                                    '<option value="AX">AMERICAN EXPRESS</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>PNR O CÓDIGO RESERVA</label>'+
                                '<span class="pull-right">(**)</span>'+
                                '<input type="text" data-req="1" name="pnr" class="form-control input-sm input-key" maxlength="6" form="form-datos">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>ID RESERVA</label>'+
                                '<span class="pull-right">(**)</span>'+
                                '<input type="text" data-req="1" name="reserva_id" class="form-control input-sm input-key" form="form-datos">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>N° TARJETA</label>'+
                                '<span class="pull-right">(**)</span>'+
                                '<div id="input--cc" class="creditcard-visa">'+
                                    '<input type="text" data-req="1" name="card" class="form-control input-sm input-key" maxlength="16" form="form-datos">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>CÓDIGO DE AUTORIZACIÓN</label>'+
                                '<span class="pull-right">(**)</span>'+
                                '<input type="text" data-req="1" name="authorization_code" class="form-control input-sm input-key" maxlength="6" form="form-datos">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>RUC</label>'+
                                '<span class="pull-right">(*)</span>'+
                                '<input type="text" data-req="0" name="ruc" class="form-control input-sm input-key" maxlength="11" form="form-datos">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label class="label label-danger">(**) CAMPOS OBLIGATORIOS</label><br>'+
                                '<label class="label label-default">(*) CAMPOS OPCIONALES</label>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<button class="btn btn-success pull-right" id="btn-generar-boleto-forzado">'+
                                    '<span class="fa fa-send"></span> GENERAR BOLETO(S)'+
                                '</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
        panel.html(t);
    }

    function generarFormularioBanco() {
        var panel=$("#form-panels");
        var t= '<div class="panel panel-default">'+
                    '<div class="panel-heading">'+
                        '<span class="fa fa-ticket"></span> GENERAR BOLETO(S) DE PAGO'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<form id="form-datos"></form>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>CC CODE</label>'+
                                '<span class="pull-right">(**)</span>'+
                                '<select name="cc_code" class="form-control input-sm" form="form-datos">'+
                                    '<option value="PP">PAYPAL</option>'+
                                    '<option value="SP">SAFETYPAY</option>'+
                                    '<option value="PE">PAGO EFECTIVO</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group" form="form-datos">'+
                                '<label>PNR O CÓDIGO RESERVA</label>'+
                                '<span class="pull-right">(**)</span>'+
                                '<input type="text" data-req="1" name="pnr" class="form-control input-sm input-key" maxlength="6">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>ID RESERVA</label>'+
                                '<span class="pull-right">(**)</span>'+
                                '<input type="text" data-req="1" name="reserva_id" class="form-control input-sm input-key" form="form-datos">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label>RUC</label>'+
                                '<span class="pull-right">(*)</span>'+
                                '<input type="text" data-req="0" name="ruc" class="form-control input-sm input-key" maxlength="11" form="form-datos">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label class="label label-danger">(**) CAMPOS OBLIGATORIOS</label><br>'+
                                '<label class="label label-default">(*) CAMPOS OPCIONALES</label>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<button class="btn btn-success pull-right" id="btn-generar-boleto-forzado">'+
                                    '<span class="fa fa-send"></span> GENERAR BOLETO(S)'+
                                '</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
        panel.html(t);
    }

    $(document).on('click','#btn-generar-boleto-forzado',function (e) {
        if (validarFormulario()==0) {
            var data=$("form-datos").serialize();
            showGif();
            $.ajax({
                type: "POST",
                url: 'DetalleMetodoPago',
                data: data,
                success: function (data){
                    hideGif();
                },
                error: function (error) {
                    hideGif();
                }
            });
        }
        else{
            $("#form-panels").prepend('<div class="alert alert-warning alert-dismissible" role="alert" style="background-color: #d23b2994 !important;">'+
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                                '<span aria-hidden="true">&times;</span>'+
                                            '</button>'+
                                            '<strong>Alerta!</strong> Ingrese información en los campos marcados de rojo.'+
                                        '</div>');
        }
    });

    $(document).on('keyup','.input-key',function (e) {
        var input=$(this);
        if (input.attr('data-req')==1) {
            if (this.value!="") {
                if (this.name=="card") {
                    input.parent().parent().removeClass("has-error");
                }
                else{
                    input.parent().removeClass("has-error");
                }
            }
        }
    });

    function validarFormulario() {
        var form=$("#form-panels").find('input');
        var i=0;
        $.each(form,function (e) {
            var input=$(this);
            if (input.attr('data-req')==1) {
                if (this.value=="") {
                    if (this.name=="card") {
                        input.parent().parent().addClass("has-error");
                    }
                    else{
                        input.parent().addClass("has-error");
                    }
                    i++;
                }
            }
        });
        return i;
    }

    // $(document).on('click','#modal_metodo_pago .panel-footer',function (arg) {
    //     $("#transacciones_form").submit();
    // });
});
    