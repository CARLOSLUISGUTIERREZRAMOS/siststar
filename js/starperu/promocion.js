(function() {
	
});
CKEDITOR.replace('editor1');
// CKEDITOR.instances['editor1'].setData(datajson.replace(/1234567qwerty/g,'#'));
var publicado=objstar.filter(function(r) {
    return r.estado==1;
});

if (publicado.length>0) {
    var caducidad=publicado.filter(function(r) {
        return r.banner==1;
    });
    if (caducidad.length>0) {
        var promocion=caducidad.filter(function(r) {
            return r.promocion==1;
        });
        if (promocion.length>0) {
            var ban=0;
            $.each(promocion,function (index,elem) {
                var now=moment();
                var a=moment(elem.desde+' '+elem.inicio,'DD/MM/YYYY H:m:s', true);
                var b=moment(elem.hasta+' '+elem.fin,'DD/MM/YYYY H:m:s', true);
                if (now>=a && b>=now) {
                    ban++;
                    if (ban==1) {
						CKEDITOR.instances['editor1'].setData(datajson.replace(/1234567qwerty/g,'#'));
                    }
                }
            });
        }
    }
}

$(document).on('click','.btn-success',function (arg) {
	var txt_ck = CKEDITOR.instances['editor1'].getData();
	var texto = txt_ck.replace(/&nbsp;/g," ");
	texto = texto.replace(/&#39;/g,"\'");
	texto = texto.replace(/&quot;/g,'"');
	texto = texto.replace(/&ldquo;/g,'"');
	texto = texto.replace(/&rdquo;/g,'"');
	texto = texto.replace(/&eacute;/g,'é');
	texto = texto.replace(/&oacute;/g,'ó');
	texto = texto.replace(/&aacute;/g,'á');
	texto = texto.replace(/&uacute;/g,'ú');
	texto = texto.replace(/&iacute;/g,'í');
	texto = texto.replace(/&ntilde;/g,'ñ');
	texto = texto.replace(/#/g,'1234567qwerty');
    var button =$(this);
    button.html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
    button.attr('disabled',true);
    $.ajax({
        // url: URLs+'starperu/Star/GuardarPromocion',
        url:'https://www.starperu.com/es/server.php',
        data: 'datajson='+JSON.stringify(texto),
        type: 'POST',
        success: function(resultado) {
            button.html('<i class="fa fa-edit"></i> Guardar Cambios');
            button.attr('disabled',false);
            if (resultado=='ok') {
                mostrarMsgError('Cambios guardados exitosamente',2);
            }
            else{
                mostrarMsgError('hubo un error, refresque la página',1);
            }
        }

    });
});

function mostrarMsgError(msg,estado) {
    var frame=$(".col-md-12 .mensajes-error");
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