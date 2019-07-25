$(function () {
    $('.date-calendar').datepicker({
        language: "es",
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });
    cargarFechasActuales();
    cargarListadoCarousel();
});

function cargarFechasActuales() {
    var y=new Date();
    var today=devuelveDia(y.getDate())+'/'+devuelveMes(y.getMonth())+'/'+y.getFullYear();
    $("input[name=desde]").datepicker('update',today);
    $("input[name=hasta]").datepicker('update',today);
}

function devuelveMes(mes) {
    var m=mes+1;
    m=m.toString();
    if (m.length==1) {
        m='0'+m;
    }
    return m;
}

function devuelveDia(dia) {
    var d=dia.toString();
    if (d.length==1) {
        d='0'+d;
    }
    return d;
}

$(document).on('click','#modal_starperu .btn-success',function (arg) {
    var form=$("#form-datos");
    var formData = new FormData(form[0]);
    var tipo=$("#tipo").val();
    var id = $(this).data('id') ? $(this).data('id') : 'n';
    var button =$(this);
    var btncancelar=$("#modal_starperu .btn-danger");
    button.html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
    button.attr('disabled',true);
    btncancelar.attr('disabled',true);
    $.ajax({
        url: URLs+'starperu/Star/GuardarRegistro',
        data: formData,
        type: 'POST',
        contentType: false,
        processData: false,
        success: function(resultado) {
            button.html('<span class="fa fa-plus"></span> Agregar');
            btncancelar.attr('disabled',false);
            button.attr('disabled',false);
            var data=JSON.parse(resultado);
            if (data.error_msg!=undefined) {
                mostrarMsgError(data.error_msg,1);
            }
            else{
                if (tipo==1) {
                    var length=objstar.length+1;
                    data.id=length;
                    objstar.unshift(data);//inserta en la primera posicion
                    // objstar.push(data);//inserta en la ultima posicion
                }
                else{
                    if (id!='n') {
                        data.id=objstar[id].id;
                        objstar[id]=data;
                    }
                    // id != 'n' ? (objstar[id]=data) : '';
                }
                enviarDataObjeto();
                cargarListadoCarousel();
                resetearFormulario();
                $("#modal_starperu").modal('hide');
            }
        }
    });
});

function enviarDataObjeto() {
    var json_tring=JSON.stringify(objstar).replace('#','');
    $.ajax({
        // url: URLs+'starperu/Star/ModificarObjetoJson',
        url:'https://www.starperu.com/es/server.php',
        data: 'objstar='+json_tring,
        type: 'GET',
        success: function(resultado) {
        }

    });
}

function cargarListadoCarousel() {
    var tbody=$("#tbl_imagenes tbody");
    tbody.empty();
    $.each(objstar,function (index,element) {
        var tr;
        tr='<tr>';
            tr+='<td>'+
                    '<img src="'+element.imagen+'" width="150">'+
                '</td>';
            tr+='<td>'+
                    '<span>'+(element.banner==1?element.desde:'-')+'</span><br>'+
                    '<span>'+(element.banner==1?element.inicio:'-')+'</span>'+
                '</td>';
            tr+='<td>'+
                    '<span>'+(element.banner==1?element.hasta:'-')+'</span><br>'+
                    '<span>'+(element.banner==1?element.fin:'-')+'</span>'+
                '</td>';
            tr+='<td>'+
                    (element.link ?  ('<a href="https://www.starperu.com/es/'+element.link+'.'+element.extension+'" target="_blank">'+element.link+'</a>') : 'Sin direccionamiento')+
                '</td>';
            tr+='<td>'+
                    '<span class="label label-danger">'+element.prioridad+'</span><br>'+
                '</td>';
            tr+='<td>'+
                    '<input type="checkbox" class="checkbox-check" value="'+index+'|'+element.estado+'" '+(element.estado==1? 'checked' : '')+' title="'+(element.estado==1?'Publicado' : 'Por publicar')+'">'+
                '</td>';
            tr+='<td>'+
                    '<button class="btn btn-sm btn-success editar-carousel" title="Editar Carousel" id="'+index+'">'+
                        '<span class="fa fa-edit fa-lg"></span>'+
                    '</button>'+
                    // '<button class="btn btn-sm btn-danger eliminar-carousel" title="Eliminar Carousel" id="'+index+'" style="margin-left: 5px">'+
                    //     '<span class="fa fa-trash fa-lg"></span>'+
                    // '</button>'+
                    (element.id!=1 ?('<button class="btn btn-sm btn-danger eliminar-carousel" title="Eliminar Carousel" id="'+index+'" style="margin-left: 5px">'+
                                            '<span class="fa fa-trash fa-lg"></span>'+
                                    '</button>') : '')+
                '</td>';
        tr+='</tr>';
        tbody.append(tr);
    });
}

function validarFormulario() {
    var form=$("#modal_starperu .panel-body");
    var b=0;
    var tipo=$("input[name=tipo]").val();
    $.each(form.find('input,select'),function (index,input) {
        var element=$(input);
        if (element.attr('data-req')==1) {
            if (element.val()!="") {
                b++;
            }
        }
    });
    if (tipo==1) {
        return b==5 ? true : false;
    }
    else{
        return b>=4 ? true : false;
    }
}

function disableBotonAgregar() {
    var button=$("#modal_starperu .btn-success");
    if (!validarFormulario()) {
        button.attr('disabled',true);
    }
    else{
        button.attr('disabled',false);
    }
}

function resetearFormulario() {
    var form=$("#form-datos");
    var frame=$(".table-imagen");
    var msg=$(".mensajes-error .col-md-12");
    var button=$("#modal_starperu .btn-success");
    form[0].reset();
    frame.html('');
    frame.addClass('hide');
    msg.empty();
    button.html('<span class="fa fa-plus"></span> Agregar');
    button.data('id','');
    $("#tipo").val(1);
    $("select[name=banner]").val(1).trigger('change');
    cargarFechasActuales();
}

$(document).on('click','.btn-agregar-nuevo',function (arg) {
    resetearFormulario();
    disableBotonAgregar();
    $("#modal_starperu").modal({backdrop: 'static', keyboard: false});
});

$(document).on('keyup change','.input-key',function (e) {
    var input=$(this);
    disableBotonAgregar();
    if (input.attr('data-req')==1) {
        if (this.value!="") {
            input.parent().removeClass("has-error");
        }
    }
});

$(document).on('click','.editar-carousel',function (arg) {
    resetearFormulario();
    var id=this.id;
    var objeto=objstar[id];
    var frame=$(".table-imagen");
    var button=$("#modal_starperu .btn-success");
    $("select[name=banner]").val(objeto.banner).trigger('change');
    $("input[name=desde]").datepicker('update',objeto.desde);
    $("input[name=hasta]").datepicker('update',objeto.hasta);
    $("input[name=inicio]").val(objeto.inicio);
    $("input[name=fin]").val(objeto.fin);
    $("input[name=link]").val(objeto.link);
    $("input[name=url_img]").val(objeto.imagen);
    $("select[name=promocion]").val(objeto.promocion);
    $("select[name=estado]").val(objeto.estado);
    $("select[name=extension]").val(objeto.extension);
    $("select[name=prioridad]").val(objeto.prioridad);
    $("input[name=tipo]").val(2);
    $("input[name=estado_img]").val(2);
    frame.html('<br><div class="col-md-12"><img src="'+objeto.imagen+'" width="100%" style="height: 300px;"></div>');
    frame.removeClass('hide');
    disableBotonAgregar();
    button.data('id',id);
    button.html('<span class="fa fa-save"></span> Guardar Cambios');
    $("#modal_starperu").modal({backdrop: 'static', keyboard: false});
});

$(document).on('click','.eliminar-carousel',function (arg) {
    var id=this.id;
    $("#modal_eliminar_registro .btn-success").data('id',id);
    $("#modal_eliminar_registro").modal({backdrop: 'static', keyboard: false});
});

$(document).on('click','#modal_eliminar_registro .btn-success',function (arg) {
    var id=$(this).data('id');
    var url_img=objstar[id].imagen;
    var formData='url_img='+url_img+'&tipo='+2;
    var button=$(this);
    button.html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
    $.ajax({
        url: URLs+'starperu/Star/EliminarRegistroImagen',
        data: formData,
        type: 'POST',
        success: function(resultado) {
            button.html('<i class="fa fa-trash"></i> Sí, entendido');
            if (resultado=='ok') {
                objstar.splice(id,1);
                enviarDataObjeto();
                cargarListadoCarousel();
                $("#modal_eliminar_registro").modal('hide');
            }
        }

    });
});

$(document).on('change','select[name=promocion]',function (arg) {
    if (this.value==1) {
        $("input[name=link]").val('promociones');
        $("select[name=extension]").val('html');
    }
    else{
        $("input[name=link]").val('');
    }
});

$(document).on('change','select[name=banner]',function (arg) {
    if (this.value==1) {
        $(".fechas").removeClass('hide');
    }
    else{
        $(".fechas").addClass('hide');
    }
});

$(document).on('click','.checkbox-check',function (arg) {
    var val=this.value.split('|');
    var estado;
    if (val[1]==1) {
        this.value=val[0]+'|'+0;
        estado=0;
    }
    else{
        this.value=val[0]+'|'+1;
        estado=1;
    }
    objstar[val[0]].estado=estado;
    enviarDataObjeto();
});


function archivoFile(evt) {
    var files = evt.target.files; // FileList object
    var frame=$(".table-imagen");
    var tipo = $("input[name=tipo]").val();
    if (files.length==0) {
        frame.html('');
        $("#imagen").val('');
        disableBotonAgregar();
        $("input[name=estado_img]").val(2);
        tipo == 1 ? mostrarMsgError('Seleccione una imagen.',3) : '';
    }
    else{
        if (files[0].type =="image/jpeg" || files[0].type =="image/png" || files[0].type =="image/jpeg") {
            imgfile_url=URL.createObjectURL(files[0]);
            frame.html('<br><div class="col-md-12"><img src="'+imgfile_url +'" width="100%" style="height: 300px;"></div>');
            frame.removeClass('hide');
            disableBotonAgregar();
            $("input[name=estado_img]").val(1);
        }
        else{
            $("#imagen").val('');
            frame.addClass('hide');
            mostrarMsgError('No se aceptan archivos solo imagenes en formato PNG,JPG y JPEG.',1);
            disableBotonAgregar();
            $("input[name=estado_img]").val(2);
        }
    }
}


$("#imagen").change(function(event) {
    archivoFile(event);
});

function mostrarMsgError(msg,estado) {
    var frame=$(".mensajes-error .col-md-12");
    var color;
    if (estado==1) {
        color='d23b2994'; //error->rojo
    }
    else if (estado==2) {
        color='8BC34A '; //success->verde
    }
    else if (estado ==3) {
        color='FF9800'; //warning->naranja
    }
    frame.html('<div class="alert alert-warning alert-dismissible" role="alert" style="background-color: #'+color+' !important; border-color: #'+color+'">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '<span aria-hidden="true">&times;</span>'+
                    '</button>'+
                    '<strong>Alerta!</strong> '+msg+
                '</div>');
}
