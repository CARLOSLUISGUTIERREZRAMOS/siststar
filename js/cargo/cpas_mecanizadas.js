$(function () {
  // To make Pace works on Ajax calls

//    cache: false

    //<editor-fold defaultstate="collapsed" desc="DECLARACION DE VARIABLES">
    var idtipocargainiciada = false;
    var bultosacumulados = 0;
    var tipocliente;
    var rutadestino;
    var entidad;
    var pesokg;
    var importe_min;
    var flete;
    var calculo_impuestos;
    var sumaimpuestos;
    var ruc_consignatario;
    var ruc_remitente;
    var tipo_tarif;
    var ancho;
    var largo;
    var espesor;
    var volumen;
    var calculo_corpac;
    var calculo_qfuel;
    var calculo_manipuleo;

    //</editor-fold>

    //<editor-fold defaultstate="collapsed" desc="INPUT'S SOLO NUMEROS">
    $("#pesokg").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#ancho").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#largo").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#espesor").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#nbultos").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#docidentidad_remitente").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#docidentidad_consignatario").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#ruc_remitente").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#ruc_consignatario").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#telefono_remitente").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#telefono_consignatario").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    //</editor-fold>


    $('[data-toggle="popover"]').popover();
    $('#divtotalguia').hide();
    //*********************************************************************************
    //**************** Deshabilitamos todos los campos del formulario ************** //
    //*********************************************************************************
    $(document).on('ready', function () {
        deshabilitartodosinputs();
    });
    //*******************************************************************************************    
    //************************** LIMPIANDO TODOS LOS INPUTS AL DAR CLICK EN EL BOTON ***********
    //*******************************************************************************************
    $('#btnclean').click(function () {
        limpiartodoslosinputs();
    });
    //************** Habilitamos todos los campos cuando se da click en el boton crear ******** //
    $("#crearpedido").click(function () {
        $("#table_main").dataTable();
        //******** OBTENEMOS LA RUTA DE ORIGEN CONSULTANDO AL CONTROLADOR *******/
        $.ajax({
            url: 'registro_cpas_mec/origenActual',
            success: function (msg) {
                $('#rutaorigen_actual').append(msg);
                var iata_codorigen = $('#rutaorigen_actual').val();
//                var name_codorigen = $("#rutaorigen_actual option:selected").text();
                $(document).data('iata_codorigen', iata_codorigen.trim());
            }
        })
        //************************************************************************/
        //HABILITAMOS TODOS LOS INPUTS DESPUES DE DAR CLICK EN EL ELEMENTO #crearpedido
        habilitarinputs();
    })
    //********** FIN- Habilitamos todos los campos cuando se da click en el boton crear ******* //
    //
    //************* LLENAMOS LOS 2 CAMPOS DEL TIPO CARGA AL ELEGIR EL ELEMENTO DEL dropdown ***********//
    $('body').on('click', '#tipocargaul', function () {
        $("#select_rutadestino").empty()
        var dato = $(this).text();
        data = dato.split('|');
        id_tipocarga = data[0];

        name_tipocarga = data[1];
        $(document).data('asdas', id_tipocarga);
        idtipocargainiciada = $(document).data('asdas');
        cargadetallecarga(idtipocargainiciada);
        $('#tipocargaid').text(id_tipocarga);
        $('#tipocarganombre').val(name_tipocarga);
        var num_entidad = $(document).data('num_entidad');
        var iata_codorigen = $(document).data('iata_codorigen');
        funcionDestino(id_tipocarga, num_entidad, iata_codorigen);

    });
    //********************************************** FIN **********************************************//

    //¨************* EVALUAMOS EL TIPO SELECCIONADO DEL SELECT TIPO DE CLIENTE Y LE ASIGNAMOS LA CAMPO ENTIDAD ******/
    $('body').on('change', '#tipocliente', function () {
        $("#ul_tipocarga").empty();
        $("#select_rutadestino").empty();
        $("#importe").val('');
        $("#importe_min").val('');

        $("#ruc_remitente").val('');
        $("#nomeape_remitente").val('');
        $("#telefono_remitente").val('');
        $("#domicilio_remitente").val('');

        tipocliente = $(this).val();
        if (tipocliente == 0) {
            funcionGetTipoCargaModel();
            $('#entidad').prop('disabled', true);
            $('#buscarentidad').prop('disabled', true);
            $('#entidad').val('00000000');
            $(document).data('num_entidad', '00000000');

        } else if (tipocliente == 1) {

            $('#entidad').val(' ');
            $('#entidad').prop('disabled', false);
            $('#buscarentidad').prop('disabled', false);
        } else if (tipocliente == 'null') {
            $('#entidad').prop('disabled', true);
            $('#entidad').val(' ');
        }
    })
    //*****    EVALUAMOS SI SE REALIZA CAMBIO EN EL INPUT DE ENTIDAD ****/
    $('body').on('change', '#entidad', function () {
        if ($('#entidad').val().length < 8 || $('#entidad').val().length > 8){
            funcionMostrarModalErrorMsg('Entidad no valida');
            entidad = '';
//            $('#tiposelect_tipocarga').empty();
            return false;
        }
        $("#select_rutadestino").empty();

        var valortipoentidad = $('#tipocliente').val();
        if (valortipoentidad == 1) {
            entidad = $('#entidad').val();
            if (entidad != "") {
                funcionGetTipoCargaModel();
            }
            var iata_codorigen = $(document).data('num_entidad', entidad);
        }
        campotbl = 'Codigo';
        camposinputswitch = 'entroxInputEntidad';
        funcionLLenaCampos_RemYconsig(entidad, campotbl, camposinputswitch);
        var id_tipocarga = $('#tipocargaul').text();
        data = id_tipocarga.split('|');
        id_tipocarga = data[0];
        var selects = funcionDestino(id_tipocarga, entidad, iata_codorigen);
        if (selects == undefined || selects == '') {
            $("#select_rutadestino").empty();
            $("#select_rutadestino").append("<option>NO EXISTEN RUTAS DESTINOS</option>");
        }
    })

    //********* EVENTO QUE DISPARA CUANDO DAN CLIC Y EL CAMPO TIPO CARGA SE ENCUENTRA VACIO ******/
    $('body').on('click', '#select_rutadestino', function () {
        var campo_tipocarganombre = $('#tipocarganombre').val();
        var campo_select_tipocliente = $('#tipocliente').val();
        var campo_entidad = $('#entidad').val();

        if (((campo_tipocarganombre == "") || (campo_tipocarganombre == " ")) && (campo_select_tipocliente == 'null') && (campo_entidad == " " || campo_entidad == "")) {
            funcionMostrarModalErrorMsg('Primero debes completar el Tipo de Cliente, La Entidad y el Tipo de Carga');
            return false;
        }
        if ((campo_tipocarganombre == "") || (campo_tipocarganombre == " ")) {
            funcionMostrarModalErrorMsg('Primero debe seleccionar el TIPO DE CARGA');
            return false;
        }
        if ((campo_select_tipocliente == 1 && campo_entidad == " ") || (campo_select_tipocliente == 1 && campo_entidad == "")) {
            funcionMostrarModalErrorMsg('Primero debe establecer la Entidad');
            return false;
        }
        if ((campo_select_tipocliente == 'null' && campo_entidad == " ") || (campo_select_tipocliente == 'null' && campo_entidad == "")) {
            funcionMostrarModalErrorMsg('Primero debe seleccionar el "TIPO CLIENTE" y establecer la "ENTIDAD" ');
            return false;
        }
    })
    var funcionMostrarModalErrorMsg = function (mensaje) {
        $("#modal_errorMensaje").modal('show');
        $('#msgErrorModal').text(mensaje);
    }
    //******** CAPTURAMOS DEL SELECT DESTINO EL CAMBIO DE UN ELEMENTO PARA TRAES LOS IMPORTES ********/
    $('body').on('change', '#select_rutadestino', function () {
//        var opcion_seleccionada = $("#select_rutadestino option:selected").val();
        var idtipocarga = $('#tipocargaid').text();
        rutadestino = $("#select_rutadestino option:selected").val();
        var rutaorigen = $(document).data('iata_codorigen');
        var num_entidad = $('#entidad').val();

        $.ajax({
            type: "POST",
            data: 'id_tipocarga=' + idtipocarga + "&num_entidad=" + num_entidad + "&rutaorigen=" + rutaorigen + "&rutadestino=" + rutadestino,
            url: 'registro_cpas_mec/getImporteyImporteMin',
            success: function (msg) {
                if(msg=="||"){
                    funcionMostrarModalErrorMsg('NO HAY TARIFA PARA ESTA ENTIDAD >> '+ entidad);
                    return false;
                }
                var data = msg.split('|');
                var importe = data[0];
                importe = funcionImporteFormat(importe);
                importe_min = parseFloat(data[1]);
                tipo_tarif = data[2].trim();
                flete = importe_min;

                $('#importe').val(importe);
                $('#importe_min').val(importe_min);
            }
        })
    })

    var funcionImporteFormat = function (importe) {
        var importedividido = importe.split('.');
        var importepuntoizq = importedividido[0];
        if (importepuntoizq == '') {
            importe = 0 + importe;
        }
        return importe;
    }
    //******************* FUNCION QUE NOS DEVUELVE LOS OPTION DEL SELECT DESTINO **************/
    var funcionDestino = function (id_tipocarga, num_entidad, iata_codorigen) {
        $.ajax({
            type: "POST",
            data: 'id_tipocarga=' + id_tipocarga + "&num_entidad=" + num_entidad + "&iata_codorigen=" + iata_codorigen,
            url: 'registro_cpas_mec/getRutasdestino',
            success: function (msg) {
                if(msg==''){
                    $("#select_rutadestino").empty();
                    $("#select_rutadestino").append('<option value=\'null\'">NO EXISTEN DESTINOS PARA ESTA ENTIDAD</option>');
                    return false;
                }
                var array_ciudadDestino = msg.split('|');
                var cant_option = msg.split('|').length;
                $(document).data('cant_option', cant_option);
                for (var i = 0; i < cant_option; i++) {
                    if (i == 0)
                        $("#select_rutadestino").append('<option value=\'null\'"> </option>');
                    ciudad = array_ciudadDestino[i].split('*');
                    $("#select_rutadestino").append('<option value=' + ciudad[0] + '>' + ciudad[1] + '</option>');
                }
            }
        })
    }
//************************************************************************************************//

//************************************************************************************************//
//******************* LLenamos los campos de Datos Remitente o con el RUC **************************//
//************************************************************************************************//
    $('#ruc_remitente').on('change', function () {
        if ($('#ruc_remitente').val().length < 11 || $('#ruc_remitente').val().length > 11)
            funcionMostrarModalErrorMsg('RUC no valido');

        ruc_remitente = $('#ruc_remitente').val();
        var campotbl = 'Ruc';
        var camposinputswitch = 'remitente';
        //LIMPIAMOS TODOS LOS INPUTS POR SI FUERON COMPLETADOS CON EL DOC.IDENTIDAD
        funcionLimpiaRemitente();
        //*************************************************************************
        funcionLLenaCampos_RemYconsig(ruc_remitente, campotbl, camposinputswitch);
    })
    $('#ruc_consignatario').on('change', function () {
        if ($('#ruc_consignatario').val().length < 11 || $('#ruc_consignatario').val().length > 11)
            funcionMostrarModalErrorMsg('RUC no valido');
        ruc_consignatario = $('#ruc_consignatario').val();
        var campotbl = 'Ruc';
        var camposinputswitch = 'consignatario';
        //LIMPIAMOS TODOS LOS INPUTS POR SI FUERON COMPLETADOS CON EL DOC.IDENTIDAD
        funcionLimpiaRemitente();
        //*************************************************************************
        funcionLLenaCampos_RemYconsig(ruc_consignatario, campotbl, camposinputswitch);
    })
    var funcionLLenaCampos_RemYconsig = function (arg, campotbl, camposinputswitch) {
        if (arg == '') {
            funcionLimpiaRemitente();
        }
        $.ajax({
            type: "POST",
            data: "arg=" + arg + "&campo=" + campotbl,
            url: 'registro_cpas_mec/getDatosRemitenteEntidad',
            success: function (msg) {
                
                datos = msg.split('|');
                ruc_remitente = datos[0];
                var razsocial = datos[1];
                var telefono = datos[2];
                var direccion = datos[3];
                switch (camposinputswitch) {
                    case 'remitente':
                        $('#nomeape_remitente').val(razsocial);
                        $('#domicilio_remitente').val(direccion);
                        $('#telefono_remitente').val(telefono);
                        break;
                    case 'consignatario':   
                        $('#nomeape_consignatario').val(razsocial);
                        $('#domicilio_consignatario').val(direccion);
                        $('#telefono_consignatario').val(telefono);
                        break;
                    case 'entroxInputEntidad':
                        $('#ruc_remitente').val(ruc_remitente);
                        $('#nomeape_remitente').val(razsocial);
                        $('#telefono_remitente').val(telefono);
                        $('#domicilio_remitente').val(direccion);
                        break;
                    default :
                        "No permitido";
                }


            }
        })

    }


//************************************************************************************************//
//******************* 1.LLenamos los campos de Datos Remitente con el DNI **************************//
//************************************************************************************************//

    $('#docidentidad_remitente').on('change', function () {
        if ($('#docidentidad_remitente').val().length < 8 || $('#docidentidad_remitente').val().length > 8)
            funcionMostrarModalErrorMsg('Documento de Identidad no valido');
        var docidentidad = $('#docidentidad_remitente').val();
        var camposinputswitch = "remitente";
        funcionGetDatosRemiteConsig(docidentidad, camposinputswitch);
    })
    $('#docidentidad_consignatario').on('change', function () {
        if ($('#docidentidad_consignatario').val().length < 8 || $('#docidentidad_consignatario').val().length > 8)
            funcionMostrarModalErrorMsg('Documento de Identidad no valido');
        var docidentidad = $('#docidentidad_consignatario').val();
        var camposinputswitch = "consignatario";
        funcionGetDatosRemiteConsig(docidentidad, camposinputswitch);
    })

//2.FUNCION -> LLenamos los campos de Datos Remitente con el DNI

    var funcionGetDatosRemiteConsig = function (docidentidad, camposinputswitch) {

        funcionLimpiaRemitente();

        $.ajax({
            type: "POST",
            data: "dni=" + docidentidad,
            url: "registro_cpas_mec/getDatosRemitentePersona",
            success: function (msg) {
                if (msg != true) {
                    var dato = msg.split('|');
                    var nomapes = dato[0];
                    var direccion = dato[1];
                    var telefono = dato[2];
                    switch (camposinputswitch) {
                        case 'remitente':
                            $('#nomeape_remitente').val(nomapes);
                            $('#direccion_remitente').val(direccion);
                            $('#telefono_remitente').val(telefono);
                            break;
                        case 'consignatario':
                            $('#nomeape_consignatario').val(nomapes);
                            $('#direccion_consignatario').val(direccion);
                            $('#telefono_consignatario').val(telefono);
                            break;
                        default :
                            "No permitido";
                    }

                } else {
                    var msg_err = 'El Doc.Identidad ingresado no es correcto o no se encuentra registrado'
                    $('#pMsgError').html(funcionLanzaErrorDiv(msg_err));
                    $('#pMsgError').hide(7000);
                }
            }
        })
    }
//****** USANDO EL MODAL PARA LISTAR LAS ENTIDADES ************/
    $('body').on('click', '#buscarentidad', function () {
        $("#select_rutadestino").empty();
        $("#modal_listadoentidad").modal('show');
    });
    //*************************************************************************************************** *********
    //FUNCION QUE NOS MUESTRA EL CODIGO DE LA ENTIDAD AL DAR CLICK EN LA FILA DE TABLA LISTADO DE ENTIDADES 
    //************************************************************************************************************/
    $(".entidadayuda").click(function () {
        $(this).parents("tr").find("#codigo_entidad").each(function () {
//            $(this).parents("tr").find("td").each(function(){
            entidad = $(this).html();
            
            var campotbl = 'Codigo';
            funcionLLenaCampos_RemYconsig(entidad, campotbl);
            $('#entidad').val('');

            $('#entidad').val(entidad);
            funcionGetTipoCargaModel();
            camposinputswitch = 'entroxInputEntidad';
            funcionLLenaCampos_RemYconsig(entidad, campotbl, camposinputswitch);
            $('#modal_listadoentidad').modal('hide');
        });
    });
    //**************************** LIMPIAMOS AL DAR CLIC EN EL DOC.ID O EN EL RUC ****************//
    $('#ruc_remitente').click(function () {
        $('#docidentidad_remitente').val('');
        var campos = 'remitente';
        funcionLimpiaRemitente(campos);
    });
    $('#ruc_consignatario').click(function () {
        $('#docidentidad_consignatario').val('');
        var campos = 'consignatario';
        funcionLimpiaRemitente(campos);
    });
    $('#docidentidad_remitente').click(function () {
        $('#ruc_remitente').val('');
        var campos = 'remitente';
        funcionLimpiaRemitente(campos);
    });
    $('#docidentidad_consignatario').click(function () {
        $('#ruc_consignatario').val('');
        var campos = 'consignatario';
        funcionLimpiaRemitente(campos);
    });
    //*******************************************************************************************//

    //****** FUNCION QUE LIMPIARA LOS ELEMENTOS DE LOS CAMPOS REMITENTE **********
    var funcionLimpiaRemitente = function (campos) {
//        $('#ruc_remitente').val('');
        switch (campos) {
            case 'remitente':
                $('#nomeape_remitente').val('');
                $('#telefono_remitente').val('');
                $('#domicilio_remitente').val('');
                break;
            case 'consignatario':
                $('#nomeape_consignatario').val('');
                $('#direccion_consignatario').val('');
                $('#telefono_consignatario').val('');
                break;
            default :
                'Proceso desconocido';
        }
    }
    //*****************************************************************************

    var cargadetallecarga = function (id_tipocarga) {
        $('#selectdetallecarga').empty();
        if (idtipocargainiciada) {

            $.ajax({
                type: 'POST',
                data: 'idtipocarga=' + idtipocargainiciada,
                url: "registro_cpas_mec/getDatosDetalleCarga",
                success: function (data) {
                    $("#selectdetallecarga").append(data);
                }
            })
            idtipocargainiciada
        } else {
            alert('Primero debes seleccionar el tipo de carga');
        }
    }

    //CONTENIDO***********************************************************************
    //***************************** AGREGANDO ITEM EN LA TABLA************************
    //********************************************************************************
    var cuentafilascontenido = function () {
        var filastotales = $('#tblcontenido tr').length;
        var cant_filas_contenido = filastotales;
        return cant_filas_contenido;
    }
    $('#nuevocontenido').click(function () {
        var cant_filas_contenido = cuentafilascontenido();
        var bultos = $('#nbultos').val();
        var detallecarga = $('#selectdetallecarga option:selected').text();
        var nglosas = $('#nglosas').val();
        var i = 1;
        var idtipocarga = $('#tipocargaid').text();

        if (bultos == "") {
            funcionMostrarModalErrorMsg("Debes indicar la cantidad de bultos");
            return false;
        } else if (nglosas == "") {
            funcionMostrarModalErrorMsg("Debes indicar la cantidad de glosa");
            return false;
        } else if (nglosas == "" && bultos == "") {
            funcionMostrarModalErrorMsg("Debes indicar la cantidad de bultos y la cantidad de glosa");
            return false;
        }

        var fila = '<tr id="row_' + cant_filas_contenido + '"><td class="celdaCentra" id="td_' + cant_filas_contenido + '">' + cant_filas_contenido + '</td><td class="celdaCentra">' + bultos + '</td><td class="celdaCentra">' + idtipocarga + '</td><td class="celdaCentra">' + detallecarga + "-" + nglosas + '</td><td class="celdaCentra"><button title="Descartar" id="' + cant_filas_contenido + '" type="button" class="btn btn-primary btn-sm btndel" aria-label="Left Align"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>';
        i++;
//       var clonarfila= $("#tblcontenido").find("tbody tr:last").clone();
        //***************** SUMAMOS LOS BULTOS EN CADA ITERACION*******************
        bultosacumulados += parseInt(bultos);
        $('#total_bultos').val(bultosacumulados); //Asignamos al input total bultos
        $("#total_bultos").css({"background-color": "#778899", "font-size": "200%", "color": "white", "font-weight": "bold", "text-align": "center"});

        //**************************************************************************
        $("#tblcontenido tbody").append(fila);
        $('#nbultos').val('');
        $('#nglosas').val('');
    })
    $('body').on('click', '.btndel', function () {
        var cantbultosdel = $(this).parents("tr").find("td").eq(1).text();
        bultosacumulados -= cantbultosdel;
        $('#total_bultos').val(bultosacumulados);
        var button_id = $(this).attr("id");
        $('#row_' + button_id + '').remove();

    })

    // <editor-fold defaultstate="collapsed" desc="CODIGO PLEGADO -HABILITAR /DESHABILITAR">

    var deshabilitartodosinputs = function () {
        //1. PRINCIPAL - IZQUIERDA

        $('#dscttotal').prop('disabled', true);
        $("#cpa_forma").prop('disabled', true); // deshabilitar
        $('#cpa_numero').prop('disabled', true);
        $('#nropedido').prop('disabled', true);
        $('#tipocliente').prop('disabled', true);
        $('#entidad').prop('disabled', true);
        $('#tipocargaid').prop('disabled', true);
        $('#tipocarganombre').prop('disabled', true);
        $('#tiposelect_tipocarga').prop('disabled', true);
        $('#buscarentidad').prop('disabled', true);
        $('#select_rutadestino').prop('disabled', true);
        $('#importe').prop('disabled', true);
        $('#importe_min').prop('disabled', true);
        $('#autorizacion').prop('disabled', true);
        $('#totaldsct').prop('disabled', true);

        $('#rutaorigen_actual').empty()
        //2. CAMPOS DERECHA - REMITENTE DESHABILITACION AL INICIO
        $('#docidentidad_remitente').prop('disabled', true);
        $('#ruc_remitente').prop('disabled', true);
        $('#nomeape_remitente').prop('disabled', true);
        $('#telefono_remitente').prop('disabled', true);
        $('#domicilio_remitente').prop('disabled', true);

        //3. CAMPOS DERECHA - REMITENTE DESHABILITACION AL INICIO
        $('#docidentidad_consignatario').prop('disabled', true);
        $('#ruc_consignatario').prop('disabled', true);
        $('#nomeape_consignatario').prop('disabled', true);
        $('#telefono_consignatario').prop('disabled', true);
        $('#domicilio_consignatario').prop('disabled', true);
        //*************Fin deshabilitacion de elementos del form*********//
        //
        //4. CAMPOS CONTENIDO - REMITENTE DESHABILITACION AL INICIO
        $('#selectdetallecarga').prop('disabled', true);
        $('#nbultos').prop('disabled', true);
        $('#nglosas').prop('disabled', true);

        //DETALLE CONTENIDO 
        $('#total_bultos').prop('disabled', true);
        $('#pesokg').prop('disabled', true);
        //DETALLE MEDIDAS VOLUMEN
        $('#ancho').prop('disabled', true);
        $('#largo').prop('disabled', true);
        $('#espesor').prop('disabled', true);
        $('#volumen').prop('disabled', true);
        $('#flete').prop('disabled', true);
        //DETALLE IMPORTE
        $('#corpac').prop('disabled', true);
        $('#manipuleo').prop('disabled', true);
        $('#qfuel').prop('disabled', true);
        $('#reparto').prop('disabled', true);
        $('#otroscargo').prop('disabled', true);
        $('#impuestos').prop('disabled', true);

    }

    var habilitarinputs = function () {
        $("#cpa_forma").prop('disabled', false); // deshabilitar
        $('#cpa_numero').prop('disabled', false);
        $('#tipocliente').prop('disabled', false);
        $('#tipocargaid').prop('disabled', false);
        $('#tiposelect_tipocarga').prop('disabled', false);
        $('#fechahoy').val($('#fechaoculta').val());
        $('#tipomoneda').val($('#tipomonedaoculta').val());
        $('#select_rutadestino').prop('disabled', false);
        $('#autorizacion').prop('disabled', false);
        $('#totaldsct').prop('disabled', false);
        //CAMPOS DERECHA - REMITENTE DESHABILITACION AL INICIO
        $('#docidentidad_remitente').prop('disabled', false);
        $('#ruc_remitente').prop('disabled', false);
        $('#nomeape_remitente').prop('disabled', false);
        $('#telefono_remitente').prop('disabled', false);
        $('#domicilio_remitente').prop('disabled', false);

        //CAMPOS DERECHA - REMITENTE DESHABILITACION AL INICIO
        $('#docidentidad_consignatario').prop('disabled', false);
        $('#ruc_consignatario').prop('disabled', false);
        $('#nomeape_consignatario').prop('disabled', false);
        $('#telefono_consignatario').prop('disabled', false);
        $('#domicilio_consignatario').prop('disabled', false);
        //CAMPOS CONTENIDO 
//        $('#selectdetallecarga').prop('disabled', false);
        $('#nbultos').prop('disabled', false);

        //DETALLE CONTENIDO 
        $('#pesokg').prop('disabled', false);
        //DETALLE MEDIDAS VOLUMEN
        $('#ancho').prop('disabled', false);
        $('#largo').prop('disabled', false);
        $('#espesor').prop('disabled', false);
    }

    // </editor-fold>


    // <editor-fold defaultstate="collapsed" desc="CODIGO PLEGADO - LIMPIANDO INPUTS">

    var limpiartodoslosinputs = function () {

        $("#cpa_forma").val(''); // deshabilitar
        $('#cpa_numero').val('');
        $('#tipocliente').val('');
        $('#tipocargaid').val('');
        $('#tipocarganombre').val('');
        $('#tiposelect_tipocarga').val('');
        $('#fechahoy').val('');
        $('#tipomoneda').val('');
        $('#select_rutadestino').val('');
        $('#importe').val('');
        $('#importe_min').val('');
        $('#autorizacion').val('');
        $('#totaldsct').val('');
        //CAMPOS DERECHA - REMITENTE DESHABILITACION AL INICIO
        $('#docidentidad_remitente').val('');
        $('#ruc_remitente').val('');
        $('#nomeape_remitente').val('');
        $('#telefono_remitente').val('');
        $('#domicilio_remitente').val('');

        //CAMPOS DERECHA - REMITENTE DESHABILITACION AL INICIO
        $('#docidentidad_consignatario').val('');
        $('#ruc_consignatario').val('');
        $('#nomeape_consignatario').val('');
        $('#telefono_consignatario').val('');
        $('#domicilio_consignatario').val('');
        //CAMPOS CONTENIDO 
        $('#selectdetallecarga').val('');
        $('#nbultos').val('');
        $('#nglosas').val('');

        //DETALLE CONTENIDO 
        $('#total_bultos').val('');
        $('#pesokg').val('');
        //DETALLE MEDIDAS VOLUMEN
        $('#ancho').val('');
        $('#largo').val('');
        $('#espesor').val('');
        $('#volumen').val('');
        $('#flete').val('');

        //DETALLE IMPORTE
        $('#corpac').val('');
        $('#manipuleo').val('');
        $('#qfuel').val('');
        $('#reparto').val('');
        $('#otroscargo').val('');
        $('#impuestos').val('');
        $('#dscttotal').val('');
    }
    // </editor-fold>


    //**************** DETECTAMOS EL INGRESO EN INPUT PESO KG *****************************
    $('body').on('change', '#pesokg', function () {
        if ((tipocliente === undefined) || tipocliente == 'null') {
            funcionMostrarModalErrorMsg('Primero debes completar el Tipo Cliente');
            $('#tipocliente').focus().attr('size', $('#tipocliente option').length);
        } else {
            pesokg = $('#pesokg').val();
            $('#flete').val(importe_min);
            $.ajax({
                type: 'POST',
                data: "rutadestino=" + rutadestino + "&tipo_tarif=" + tipo_tarif,
                url: "registro_cpas_mec/traerTaxes",
                success: function (data) {
                    var dato = data.split('|');
                    corpac_tax = funcionImporteFormat(dato[0]);
                    qfuel_tax = funcionImporteFormat(dato[1]);
                    manipuleo_tax = funcionImporteFormat(dato[2]);
                    impuestos_tax = dato[3];
                    //*** OPERANDO EL PESO POR LOS TAXES. 
                    var impuestos

                    switch (tipo_tarif) {
                        case "1":
                            calculo_corpac = parseFloat(corpac_tax) * parseFloat(pesokg);
                            calculo_qfuel = parseFloat(qfuel_tax) * parseFloat(pesokg);
                            calculo_manipuleo = parseFloat(manipuleo_tax) * parseFloat(pesokg);
                            calculo_manipuleo = parseFloat(funcionRedondeDosDec(calculo_manipuleo));
                            impuestos = parseFloat(impuestos_tax / 100);
                            sumaimpuestos = funcionSumaImpuesto(calculo_corpac, calculo_qfuel, calculo_manipuleo);

                            calculo_impuestos = funcionRedondeDosDec(funcionCalculaImpuesto(sumaimpuestos, impuestos));
                            total_guia = funcionCalculaTotalGuia(sumaimpuestos, calculo_impuestos);
                            if (volumen != undefined) {

                                var vol_format = funcionRedondeDosDec(volumen);
                                var res = funcionRedondeDosDec(total_guia + vol_format);
                                funcionLLenaSpanTotalGuia(res);
                            } else {
                                funcionLLenaSpanTotalGuia(total_guia);
                            }

                            break;
                        case "2":
                            calculo_corpac = corpac_tax;
                            calculo_qfuel = qfuel_tax;
                            calculo_manipuleo = manipuleo_tax;
//                            $('#total_guia').append('US$ ' + flete);
                            funcionLLenaSpanTotalGuia(flete);
                            break;
                    }

                    $('#corpac').val(calculo_corpac);
                    $('#qfuel').val(calculo_qfuel);
                    $('#manipuleo').val(calculo_manipuleo);
                    $('#impuestos').val(calculo_impuestos);
                    //****************************************
                    $('#span_corpac').text(corpac_tax).append(' %');
                    $('#span_qfuel').text(qfuel_tax).append(' %');
                    $('#span_manipuleo').text(manipuleo_tax).append(' %');
                    $('#span_impuestos').text(impuestos_tax).append(' %');

                    $('#divtotalguia').show();
                    funcionPosiciona('total_guia');

                }
            })
        }
    })
    var funcionLLenaSpanTotalGuia = function (arg1) {
        var arg1 = funcionRedondeDosDec(arg1)
        $('#total_guia').text('');
        $('#total_guia').append('US$ ' + arg1);
    }
    var funcionPosiciona = function (nombreID) {
        var focalizar = $("#" + nombreID + "").position().top;
        $('html,body').animate({scrollTop: focalizar}, 1000);
    }

    //<editor-fold defaultstate="collapsed" desc="FUNCIONES DE CALCULOS" >
    var funcionSumaImpuesto = function (calculo_corpac, calculo_qfuel, calculo_manipuleo) {
        var res_sumaImpuesto = parseFloat(calculo_corpac) + parseFloat(calculo_qfuel) + parseFloat(calculo_manipuleo) + flete;
        return parseFloat(funcionRedondeDosDec(res_sumaImpuesto));
    }
    var funcionCalculaImpuesto = function (sumaTotalImpuestos, impuestos) {
        var res_calculoImpuesto = parseFloat(sumaTotalImpuestos) * parseFloat(impuestos);
        return parseFloat(res_calculoImpuesto);
    }
    var funcionRedondeDosDec = function (num) {
        return num.toFixed(2);
    }
    var funcionCalculaVolumen = function (ancho, largo, espesor) {
        volumen = (ancho * largo * espesor) / 6000;
        return funcionRedondeDosDec(parseFloat(volumen));
    }
    var funcionCalculaTotalGuia = function (sumaimpuestos, calculo_impuestos, volumen) {
        var resultado_CalculaTotalGuia = 0;
        if (volumen === undefined) {
            var array_arg = [sumaimpuestos, calculo_impuestos];
        } else {
            var array_arg = [sumaimpuestos, calculo_impuestos, volumen];
        }
        resultado_CalculaTotalGuia = funcionSuma(array_arg);
        return resultado_CalculaTotalGuia;

    }
    var funcionSuma = function (argsArray) {
        var sumatoria_arg = 0;
        var cant_argumentos = argsArray.length;
        for (var i = 0; i < cant_argumentos; i++) {
            sumatoria_arg += parseFloat(argsArray[i]);
        }
        return sumatoria_arg;
    }
    //</editor-fold>

    $('#btnrefresca').click(function () {
        location.reload();
    })
    $('body').on('click', '#nbultos', function () {
        if (ruc_remitente == ' ' || ruc_remitente === undefined || $('#nomeape_remitente').val() == '' || $('#domicilio_remitente').val() == '') {
            funcionMostrarModalErrorMsg('Debes completar los datos del Remitente');
            return false;
        }
        if (ruc_consignatario == ' ' || ruc_consignatario === undefined || $('#nomeape_consignatario').val() == '' || $('#domicilio_consignatario').val() == '') {
            funcionMostrarModalErrorMsg('Debes completar los datos del Consignatario');
            return false;
        }

        $('#selectdetallecarga').prop('disabled', false);
        $('#nglosas').prop('disabled', false);
    })

    // ----- FUNCION CALCULO VOLUMEN ----//


    var funcionVerificaCamposLLenos_paraVolumen = function (input1, input2) {

        if (input1 != undefined && input2 != undefined) {
            return true;
        }
    }


    //<editor-fold defaultstate="collpased" desc="DETECTANDO CAMBIOS EN INPUT ANCHO, LARGO,ESPESOR">
    $('body').on('change', '#ancho', function () {
        ancho = $('#ancho').val();
        if (funcionVerificaCamposLLenos_paraVolumen(largo, espesor)) {
            volumen = funcionCalculaVolumen(ancho, largo, espesor);
            $('#volumen').val(volumen);
            reCalculaTotalGuia = funcionCalculaTotalGuia(funcionRedondeDosDec(sumaimpuestos), calculo_impuestos, volumen);
            funcionLLenaSpanTotalGuia(reCalculaTotalGuia);

        }
    })
    $('body').on('change', '#largo', function () {
        largo = $('#largo').val();
        if (funcionVerificaCamposLLenos_paraVolumen(ancho, espesor)) {
            volumen = funcionCalculaVolumen(ancho, largo, espesor);
            $('#volumen').val(volumen);
            reCalculaTotalGuia = funcionCalculaTotalGuia(funcionRedondeDosDec(sumaimpuestos), calculo_impuestos, volumen);
            funcionLLenaSpanTotalGuia(reCalculaTotalGuia);
        }
    })
    $('body').on('change', '#espesor', function () {
        espesor = $('#espesor').val();
        if (funcionVerificaCamposLLenos_paraVolumen(ancho, largo)) {
            volumen = funcionCalculaVolumen(ancho, largo, espesor);
            $('#volumen').val(volumen);
            reCalculaTotalGuia = funcionCalculaTotalGuia(funcionRedondeDosDec(sumaimpuestos), calculo_impuestos, volumen);
            funcionLLenaSpanTotalGuia(reCalculaTotalGuia);
        }
    })
    //</editor-fold> 

    var funcionGetTipoCargaModel = function () {

        $.ajax({
            type: "POST",
            url: "registro_cpas_mec/getTipoCarga",
            success: function (data) {
                $("#ul_tipocarga").append(data);
            }
        })
    }
    $('body').on('click', '#tiposelect_tipocarga', function () {
        if ((tipocliente === "1" || tipocliente===undefined) && (entidad === undefined || entidad == "")) {
            funcionMostrarModalErrorMsg('Establezca la Entidad');
            return false;
        }
    })
})
