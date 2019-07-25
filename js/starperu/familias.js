$(document).ready(function(){ 
	$(".cabecera").addClass('hide');
});

/**************************METODOS DE CLICK**********************************/
$(document).on('keyup','.mod-card-back-title',function (arg) {
	var el = this;
	if (this.value) {
	    el.style.cssText = 'height:' + el.scrollHeight + 'px';
	}
	else{
		el.style.cssText = 'height:34px';
	}
});

$(document).on('click','.timeline-header',function (arg) {
	var el=$(this);
	var brother=$(this.nextElementSibling);
	el.addClass('hide');
	brother.removeClass('hide');
	brother.focus();
	brother.val(el.text());
});

$(document).on('blur','.mod-card-back-title',function (arg) {
	var el=$(this);
	var exp=this.id.split('|');
	var id=exp[0];
	var estado=exp[1];
	if (this.value) {
		var brother=$(this.previousElementSibling);
		brother.html(el.val());
		brother.removeClass('hide');
		el.addClass('hide');
	}
	else{
		if (estado==1) {
			el.focus();
		}
		else{
			var li=$(this.parentElement.parentElement.parentElement.parentElement.parentElement);
			li.remove();
			verificarCantidadCondiciones(id);
		}
	}
	if (this.value) {
		modificarValorCondiciones(id);
	}
});

$(document).on('mouseover','.time-label',function (arg) {
	this.style.cssText = 'background: #e2e2e2';
	$(this.lastElementChild).removeClass('hide');
});
$(document).on('mouseout','.time-label',function (arg) {
	this.style.cssText = '';
	$(this.lastElementChild).addClass('hide');
});

$(document).on('click','.nuevo-item',function (arg) {
	debugger
	var exp=this.id.split('|');
	var estado=exp[1];
	var id=exp[0];
	if (estado==1) {
		var hermanos=$('.familia-hermanos-'+id);
		var despues=$(hermanos[hermanos.length-1]);
		var id_li=id+''+hermanos.length;
	}
	else{
		var despues=$('#grupo-familia-'+id);
		var id_li=id+'0';
		$(this).attr('id',id+'|1');
	}
	var elemento=	'<li id="li-'+id_li+'" class="familia-hermanos-'+id+'">'+
	                    '<i class="fa fa-check-square bg-blue"></i>'+
	                    '<div class="timeline-item">'+
	                        '<div class="timeline-footer">'+
	                            '<div class="form-inline">'+
	                                '<div class="form-group" style="width: 90%">'+
	                                    '<h2 class="timeline-header no-border hide"></h2>'+
	                                    '<textarea class="mod-card-back-title" rows="1" dir="auto" id="'+id+'|0" autofocus></textarea>'+
	                                '</div>'+
	                                '<div class="form-group">'+
	                                    '<a class="btn btn-danger btn-xs pull-right iliminar-item" id="'+id+'" name="'+id_li+'">Delete</a>'+
	                                '</div>'+
	                            '</div>'+
	                        '</div>'+
	                    '</div>'+
	                '</li>';
	despues.after(elemento);
	debugger
});

$(document).on('click','.iliminar-item',function (arg) {
	debugger
	var id=this.id;
	var name=$(this).attr('name')
	$("#li-"+name).remove();
	verificarCantidadCondiciones(id);
	modificarValorCondiciones(id);
});

/*************************FUNCIONES*********************/
function verificarCantidadCondiciones(id) {
	var li=$('.familia-hermanos-'+id);
	if (li.length==0) {
		var button=$("#grupo-familia-"+id+" button");
		button.attr('id',id+'|0');
	}
}

function modificarValorCondiciones(id) {
	var li=$('.familia-hermanos-'+id);
	var h='';
	$.each(li,function (index,elemet) {
		h+=this.lastElementChild.lastElementChild.lastElementChild.firstElementChild.firstElementChild.textContent+'<br>';
	});
	debugger
	$.ajax({
        url: URLs+'starperu/Star/GuardarCondicion',
        data: 'condiciones='+h+'&codigo='+id,
        type: 'POST',
        success: function(resultado) {
            console.log(resultado);
        }
    });
}
