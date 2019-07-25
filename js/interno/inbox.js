$(function () {
    var items_selected = [];
    $('#DivTicketCarga').hide();
    /***********************************
     * CALENDARIO 
     ***********************************/
    $('#calendar').on('changeDate', function (selected) {
        var fecha_elegida = new Date(selected.date);
        var dia = fecha_elegida.getDate();
        var mes = fecha_elegida.getMonth() + 1; // Se suma uno por defecto solo a los meses
        var anio = fecha_elegida.getFullYear();
        $("#fecha_set").val(anio + '-' + mes + '-' + dia);
    }).datepicker({
        startDate: new Date()
    }).datepicker();
//    }).datepicker("setDate", new Date());
    /***********************************/

    $('#listTickets').DataTable({
        "order": [[2, "desc"]]

    });
    //Datemask dd/mm/yyyy
    $('#tiempo_estimado').datepicker({
        autoclose: true
    })
    var userdest = $('.select2').select2();

    /*=============================================
     * CONTROL DE LECTURA Y RESPUESTA DE INCIDENCIA
     =============================================*/
    $('#div_campotextreply').hide();
    $('#bloque_volver_enviar').hide();
    $('#responder_incidencia').click(function () {
        $('#div_campotextreply').show();
        $('#bloque_volver_enviar').show();
    });
    $('#ExitWrite').click(function () {
        $('#div_campotextreply').hide();
//        $('#bloque_volver_enviar').show();
    });
    /*=============================================
     * .CONTROL DE LECTURA Y RESPUESTA DE INCIDENCIA
     =============================================*/
    //Add text editor
    var campotexto = $('#compose-textarea').html('...');
    campotexto.wysihtml5({
        toolbar: {
            "image": false,
            "link": false
        },
        locale: "es-ES"
    });

    $('#btnEnvio').click(function () {
//        valor_select_responsable = $('input[name=user_resp]').val($("#servicio option:selected").text());
        valor_select_responsable = $("#user_resp").val();
//        console.log(valor_select_responsable);
        if (valor_select_responsable !== null) {
            $(this).hide();
            $('#DivGeneracionIncidencia').hide();
            $('#DivTicketCarga').show();
        }
    });

    $(this).wysihtml5('resetDefaults')

    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('.mailbox-messages input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }
        $(this).data("clicks", !clicks);
    });
    /*
     * AGREGANDO 
     */
//    $('input').iCheck('uncheck')
    $('input').on('ifChecked', function () {
        items_selected.push($(this).val());
//        console.log('selected '+$(this).val());
//        console.log('array_push: '+items_selected);
    });
    /*
     * ELIMINANDO INDICES SELECCIONADOS DE UN ARRAY
     */
    $('input').on('ifUnchecked', function () {
//             $('input').iCheck('destroy');
        var item_desactivado = $(this).val();
        items_selected.splice(items_selected.indexOf(item_desactivado), 1);
//            console.log('Item desac'+item_desactivado);
//            console.log('Array unshift '+items_selected);
    });

    $('#btnLeft').click(function () {
        $('#modal_generico').modal('hide');
    });

    $('.del').click(function () {
        $("#modal_generico").addClass("modal modal-warning");
        $("#botonModal").html('Aceptar');
        $('#btnLeft').html('Cerrar');
//        console.log(items_selected); 
        if (items_selected.length < 1) {
            $('#tituloModal').html('MENSAJE DE ADVERTENCIA');
            $('#msg').html('No ha seleccionado ningun elemento');
            $('#modal_generico').modal('show');
            return false;
        }

        $('#tituloModal').html('MENSAJE DE CONFIRMACIÓN');
        $('#msg').html('¿Esta seguro de eliminar?');
        $('#modal_generico').modal('show');
        $("#botonModal").click(function () {

            $.ajax({
                type: "POST",
                url: '/siststar/utilitarios/incidencias/EliminarIncidencia',
                data: 'ticketsDel=' + items_selected,
                success: function (data)
                {
                    if (data == 1) {
                        window.location.href = '/siststar/utilitarios/incidencias/Inbox?res_del=success';
                    } else {
                        window.location.href = '/siststar/utilitarios/incidencias/Inbox?res_del=error';
                    }
                }
            });

        })

    });

//    $('#btnEnvio').click(function () {
//        var text_incidencia = campotexto.val();
//        var user_resp = userdest.val();
//        $.ajax({
//            type: "POST",
//            url: '/siststar/utilitarios/incidencias/postIncidencia',
//            data: 'text=' + text_incidencia + '&user_resp=' + user_resp,
//            success: function (data)
//            {
//               console.log(data);
//                var item = data.split('|');
//                var val = item[0];
//                var ticket = item[1];
//                if (val == 1) {
////                        funcionShowModal('TOME NOTA DEL NUMERO DE TICKET','NUMERO DE TICKET GENERADO: '+ ticket,'SALIR','modal-success');
//                    window.location.href = '/siststar/utilitarios/incidencias/Enviados?ticket=' + ticket+'&estado=PROCESO';
//                } else {
//                    funcionShowModal('NO SE GENERO TICKET', 'Error en el proceso. <br> Intentelo nuevamente o comuniquelo al área de sistemas', 'ENTIENDO', 'modal-danger');
//                }
//            }
//        });
//
//
//
//    })
//    funcionShowModal('TOME NOTA DEL NUMERO DE TICKET','NUMERO DE TICKET GENERADO: '+ ticket,'SALIR','modal-success');
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

});

