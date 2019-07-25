$(function () {
    
   
    $('.nuevaTarifa').hide();
    $('.detallebox').hide();
    $.getScript("../js/app/genericas.js");
    bool = true;
    $('#reservation').daterangepicker()
    $('#secuencial').val(1);
    funcionSpanShowHiddenActionMoment(0, null);

    funcionOcultaMuestraElemento(0, ['btnGrabar']);
    funcionOcultaMuestraElemento(0, ['btnConfirma']);
    funcionOcultaMuestraElemento(0, ['btnCancelarMod']);
    funcionOcultaMuestraElemento(0, ['btnAdiciona']);
    funcionOcultaMuestraElemento(0, ['help_entidad']);

    $('body').on('click', '#btnCrear', function () {
        creando = true;
        $('.nuevaTarifa').show();
        $('.detallebox').hide();
        $('#crea_importe').inputmask('9.99', {numericInput: true});
        $('#crea_minimo').inputmask('9.99', {numericInput: true});

        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        funcionSpanShowHiddenActionMoment(1, ' CREANDO ... ');
        getCliente();
        funcionGetSegmento();
        funcionesGetTipoCarga();
        funcionOcultaMuestraElemento(1, ['btnGrabar']);
        funcionDesactivarActivarElemento(0, ['btnCrear']);
        funcionDesactivarActivarElemento(0, ['btnBuscar']);
        funcionActivaAllinputs(1);
        funcionSetVal('secuencial', 1);

    });

    var getCliente = function () {
        var listOptions = {
            '0': 'SELECCIONE',
            '1': 'NORMAL',
            '2': 'ENTIDAD'
        };
        funcionSetSelectDefault('tipo_cliente', listOptions, 0);
    };

    $('body').on('click', '#btnBuscar', function () {
        $('.detallebox').show();
        funcionDesactivarActivarElemento(0, ['btnBuscar']);
        funcionSpanShowHiddenActionMoment(1, 'BUSCANDO ... ');
        $('#secuencial').val(1);
        funcionActivaAllinputs(1);
        getCliente();
        funcionDesactivarActivarElemento(0, ['btnCrear']);
        funcionDesactivarActivarElemento(0, ['btnImprimir']);
//        funcionOcultaMuestraElemento(1, ['btnCancelar']);
        funcionOcultaMuestraElemento(1, ['btnConfirma']);
        funcionGetSegmento();
        funcionesGetTipoCarga();
    });

    $('body').on('click', '#btnCancelar', function () {
        location.reload();
    });

    $('body').on('click', '#btnConfirma', function () {
        funcionGetDatosTblRangFec();
    });

    $('#btnGrabar').click(function () {
        
        var crea_rangoFechas;
        var crea_importe;
        var crea_minimo;
        var enBaseA;
        
        if (typeof origen === "undefined" || typeof destino === "undefined" || typeof  t_carga === "undefined") {

                funcionShowModal('Advertencia', 'Complete los campos solicitados', 'Entiendo', 'modal-warning');
                return false;
                
        }
        codigo_agencia = boolVerificaCampoVacio('codAgenciaCampo1');
        
        if (codigo_agencia === true) {
            funcionShowModal('Advertencia!', 'Debes establecer la entidad', 'Entiendo', 'modal-warning');
            return false;
        }
        
        crea_rangoFechas = $('#daterangepicker').val();
        crea_importe = $('#crea_importe').val();
        crea_minimo = $('#crea_minimo').val();
        enBaseA = $('input:radio[name=enBaseA]:checked').val();
        if(crea_importe === '' || crea_minimo === '' || typeof  enBaseA === 'undefined'){
            funcionShowModal('ADVERTENCIA', 'Debe completar todos los campos solicitados', 'Entiendo', 'modal-warning');
            return false;
        }
         $.ajax({
                type: 'POST',
                data: 'tipo_cliente=' + tipo_cliente + '&codigo_agencia= ' + codigo_agencia 
                       + ' &origen= ' + origen + ' &destino= ' + destino
                       + ' &t_carga=' + t_carga 
                       +'&rangoFechas='+crea_rangoFechas + '&importe=' + crea_importe + '&minimo=' 
                       + crea_minimo + ' &enBaseA=' + enBaseA,
                url: 'tarifas_carga/registrarNuevaTarifa',
                
                success: function (data) {
                    
                    switch (data){
                        case 'EXISTE':
                            funcionShowModal('ERROR CON LA CREACIÓN DE TARIFA', 'Ya existe esta tarifa para los datos ingresados', 'Entiendo', 'modal-danger');
                            break;
                        case '0': 
                            funcionShowModal('ERROR CON LA CREACIÓN DE TARIFA', 'Ocurrio un error, no se registro tarifa.', 'Entiendo', 'modal-danger');
                           
                            break;
                        case '1':
                            funcionShowModal('REGISTRO EXITOSO', 'Se registro una nueva tarifa', 'Entiendo', 'modal-success',true);
                             $('#botonModal').click(function(){
                               location.reload(); 
                            });
                            break;
                            default : funcionShowModal('ADVERTENCIA', 'Se registraron má registros de los esperado', 'Entiendo', 'modal-warning');
                    }
//                    location.reload();
                    
                   
                }
            });
        
    });

    $('body').on('blur', '#select_tipo_carga', function () {
        if (tipo_cliente === '1' && creando === false) {
            funcionGetDatosTblRangFec();
        }
    });

    $('#tipo_cliente').change(function () {
        if ($(this).val() === 1) {
            codigo_entidad = 00000000;
        }
    });

    var funcionGetDatosTblRangFec = function () {

        var name_tcliente = $('#tipo_cliente option:selected').text();
        var name_tcarga = $('#select_tipo_carga option:selected').text();
        t_carga = $('#select_tipo_carga').val();
        var name_codagencia = $('#codAgenciaCampo1').val();
        codigo_entidad = boolVerificaCampoVacio('codAgenciaCampo1');
        tipo_cliente = boolVerificaCampoVacio('tipo_cliente');
        origen = boolVerificaCampoVacio('select_ruta_origen');
        destino = boolVerificaCampoVacio('select_ruta_destino');
        campo4 = boolVerificaCampoVacio('select_tipo_carga');

        if (codigo_entidad === true) {
            funcionShowModal('Advertencia!', 'Debes establecer la entidad', 'Entiendo', 'modal-warning');
            return false;
        }
        if (tipo_cliente === true) {
            funcionShowModal('Advertencia!', 'Debes seleccionar el TIPO DE CLIENTE', 'Entiendo', 'modal-warning');
            return false;
        } else if (origen === true) {
            funcionShowModal('Advertencia!', 'Debes seleccionar la RUTA DE ORIGEN', 'Entiendo', 'modal-warning');
            return false;
        } else if (destino === true) {
            funcionShowModal('Advertencia!', 'Debes seleccionar la RUTA DE DESTINO', 'Entiendo', 'modal-warning');
            return false;
        } else if (campo4 === true) {
            funcionShowModal('Advertencia!', 'Debes seleccionar el TIPO DE CARGA', 'Entiendo', 'modal-warning');
            return false;
        } else {
            
            $.ajax({
                type: 'POST',
                data: 'tipo_cliente=' + tipo_cliente + '&ruta_origen=' + origen + '&ruta_destino=' + destino + '&tipo_carga=' + campo4 + '&codigo_entidad=' + codigo_entidad,
                url: 'tarifas_carga/getDatosTblRangoFechas',
                success: function (data) {
                    var tar = JSON.parse(data);
                    fec_inicio = tar.fec_inicio
                    fec_fin = tar.fec_fin;
                    Importe = tar.Importe;
                    import_min = tar.import_min;
                    tipo_tarif = tar.tipo_tarif;
                    if(typeof fec_inicio === 'undefined' && typeof fec_fin === 'undefined' 
                            && typeof Importe === 'undefined' && typeof  import_min === 'undefined' 
                            && typeof tipo_tarif === 'undefined'){
                        funcionShowModal('Mensaje', 'No se encontraron resultados', 'Entiendo', 'modal-warning');
                        return false;}
                    var newRow =
                            "<tr>"
                            + "<td>" + fec_inicio + "</td>"
                            + "<td>" + fec_fin + "</td>"
                            + "<td>" + Importe + "</td>"
                            + "<td>" + import_min + "</td>"
                            + "<td>" + tipo_tarif + " - Por kilos</td>"
                            + "<td><button id=" + tar.codigo_entidad + " type='button' title='Ver entidades' class='btn btn-sm  edita'><i class='fa fa-pencil'></i></button></td>"
                            + "</tr>";

                    if (msg === '') {
                        funcionShowModal('Información', 'No se encontraron registros', 'Entiendo', 'modal-warning');
                    } else {
                        $('.detalleDe_tcliente').text(name_tcliente);
                        $('.detalleDe_ruta').text(origen + '-' + destino);
                        $('.detalleDe_carga').text(name_tcarga);
                        $('.detalleDe_codagencia').text(name_codagencia);
                        $('#tbl_detalle tbody').html(newRow);
                        $('#id_rangoFechas').iCheck('enable');
                        $('.tarifa_en').iCheck('enable');
                        funcionSpanShowHiddenActionMoment(0, 'BUSCANDO ... ');
                    }
                }
            });
            
        }
    };

    $('#tipo_cliente, #select_tipo_carga, #select_ruta_origen,#select_ruta_destino').change(function () {

        origen = $('#select_ruta_origen').val();
        destino = $('#select_ruta_destino').val();
        t_carga = $('#select_tipo_carga').val();

        $('.detalleDe_tcliente').empty();
        $('.detalleDe_ruta').empty();
        $('.detalleDe_carga').empty();
        $('.detalleDe_codagencia').empty();
        $('#tbl_detalle tbody').empty();
    });

    //EVENTO AL DAR CLIC EN EL BOTON DE AYUDA ENTIDAD

    $('#help_entidad').click(function () {

        if (origen.length != 3 || destino.length != 3 || t_carga.length != 3) {
            funcionShowModal('Error al encontrar entidades', 'Verifique la información ingresada', 'Entiendo', 'modal-danger');
            return false;
        }
        $.ajax({
            type: "POST",
            data: 'origen=' + origen + '&destino=' + destino + '&t_carga=' + t_carga,
            url: "tarifas_carga/getEntidades",
            success: function (data) {
//                console.log(data);
                if (data === 'SINDATA') {
                    funcionShowModal('Mensaje', 'No se encontraron resultados', 'Entiendo', 'modal-danger');
                } else {
                    $('#tbl_entidades tbody').empty();
                    $('#tbl_entidades tbody').append(data);
                    $('#exampleModal').modal('show');
                    $('.selEntidad').click(function () {
                        var valores = "";
                        codigo_entidad = $(this).attr('id');
                        var nombreEntidad = $(this).parents("tr").find(".fila").html();
                        $('#exampleModal').modal('hide');
                        //**** ITERACION PARA CAPTURAR VARIAS CELDAS **/
//                   $(this).parents("tr").find(".fila").each(function(){
//                      valores += $(this).html() + "\n";
//                   });
                        $('#codAgenciaCampo1').val(codigo_entidad);
                        $('#codAgenciaCampo2').val(nombreEntidad);
//                   console.log(codigoEntidad + "-" +nombreEntidad);
                    });
                }
            }
        });

    });

    //ESTABLECEMOS EL COD.AGENCIA POR DEFAULT SI SE ELIGIO EL TIPO CLIENTE NORMAL[1]
    $('body').on('change', '#tipo_cliente', function () {
        $('#tbl_detalle tbody').empty();
        tipo_cliente = $(this).val();
        switch (tipo_cliente) {
            case '0':
                codigo_entidad = $('#codAgenciaCampo1').val('');
                break;
            case '1':
                codigo_entidad = $('#codAgenciaCampo1').val('00000000');
                funcionDesactivarActivarElemento(0, ['codAgenciaCampo1']);
                $('#codAgenciaCampo2').val('');
                funcionOcultaMuestraElemento(0, ['help_entidad']);
                break;
            case '2':
                $('#codAgenciaCampo1').val('');
                codigo_entidad = false;
                funcionOcultaMuestraElemento(1, ['help_entidad']);
                break;
        }

    });

    $('body').on('click', '.edita', function () {

        $('#modalEditaTarifa').modal('show');
//        var id_detalle = $(this).attr('id');
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'}).val(fec_fin);
        $('#edit_tarifa').inputmask('9.99', {numericInput: true}).val(Importe);
        $('#edit_minimo').inputmask('9.99', {numericInput: true}).val(import_min);
        $('#edit_ttarifa').inputmask('9', {numericInput: true}).val(tipo_tarif);
        $("input[name = 'origen' ]").val(origen);
        $("input[name = 'destino' ]").val(destino);
        $("input[name = 'tcliente' ]").val(tipo_cliente);
        $("input[name = 'tcarga' ]").val(t_carga);
        $("input[name = 'codigo_agencia' ]").val(codigo_entidad);

    });

    $("form").submit(function (event) {

        event.preventDefault();

//       var data = $("form :input").serializeArray();
        var post_url = $(this).attr('action');
        var form_data = $("form :input").serialize();

        $.post(post_url, form_data, function (res) {

            if (res === '0') {
                funcionShowModal('Error', 'Ocurrio un error en la modificación', 'Entiendo', 'modal-danger');
            } else {

                var resplit = res.split('|');
                var val = resplit[0];
                var cant_reg = resplit[1];

                if (val === '1') {
                    funcionShowModal('Actualización exitosa', 'Se actualizo ' + cant_reg + ' registro(s)', 'Entiendo', 'modal-success');
                    $('#tbl_detalle tbody').empty();
                    funcionGetDatosTblRangFec();
                    $('#modalEditaTarifa').modal('hide');
                }
            }
        });

    });

    var funcionesGetTipoCarga = function () {
        valData = null;
        AlterSwitch = 2;
        metodoControlador = 'getTipoCarga';

        resultado = funcionAjax(valData, metodoControlador, AlterSwitch);

    };

    var boolVerificaCampoVacio = function (idElemento) {

        var bool;
        var valor;

        valor = $('#' + idElemento).val();
        bool = (valor === '0' || valor == 'SELECCIONE' || valor === "undefined" || valor === '') ? true : valor;

        return bool;

    };

    var funcionGetSegmento = function () {

        valData = null;
        AlterSwitch = 1;
        metodoControlador = "getSegmento";
        resultado = funcionAjax(valData, metodoControlador, AlterSwitch);
//        return resultado;
    };

    var funcionSetSelectDefault = function (idInput, listOptions, selectedOption) {

        var select = $('#' + idInput);
        var options = select.prop('options');

        $('option', select).remove();

        $.each(listOptions, function (val, text) {
            options[options.length] = new Option(text, val);
        });
        select.val(selectedOption);

    };

    //<editor-fold defaultstate="collapsed" desc="FUNCION AJAX">
    var funcionAjax = function (valData, metodoControlador, AlterSwitch) {

        $.ajax({
            type: "POST",
            data: valData,
            url: "tarifas_carga/" + metodoControlador,
            success: function (data) {
                switch (AlterSwitch) {
                    case 1:
                        $('#select_ruta_origen').empty();
                        $('#select_ruta_origen').append(optionDefault);
                        $('#select_ruta_origen').append(data);

                        $('#select_ruta_destino').empty();
                        $('#select_ruta_destino').append(optionDefault);
                        $('#select_ruta_destino').append(data);
                        break;
                    case 2:
                        $('#select_tipo_carga').empty();
                        $('#select_tipo_carga').append(optionDefault);
                        $('#select_tipo_carga').append(data);
                        break;
                }
            }
        });


    };

    //</editor-fold>

    var funcionActivaAllinputs = function (arg) {

        funcionDesactivarActivarElemento(arg, ['tipo_cliente']);
        funcionDesactivarActivarElemento(arg, ['select_ruta_origen']);
        funcionDesactivarActivarElemento(arg, ['select_ruta_destino']);
        funcionDesactivarActivarElemento(arg, ['select_tipo_carga']);
        funcionDesactivarActivarElemento(arg, ['secuencial']);
        funcionDesactivarActivarElemento(arg, ['codAgenciaCampo1']);


    };

    var funcionSetVal = function (idInput, stringSet) {
        $('#' + idInput + '').val(stringSet);
    };

    var resultado;
    var tipo_cliente;
    var origen;
    var destino;
    var codigo_entidad;
    var t_carga;
    var fec_inicio;
    var fec_fin;
    var Importe;
    var import_min;
    var tipo_tarif;
    var optionDefault = '<option val="0">SELECCIONE</option>';
    var creando = false;

});
