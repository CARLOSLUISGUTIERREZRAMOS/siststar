$(document).ready(function(){
	toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "timeOut": "100000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});

$(document).on('dblclick','.asignar_credito',function (arg) {
	debugger
	var valor=$(this).attr('name');
	var id=this.id;
	var padre=this.parentElement;
	$(this).addClass('hide');
	var form=	'<div id="credito'+id+'">'+
					'<div class="row">'+
						'<input type="text" value="'+valor+'" style="width: 100px;margin: 0 -10px 5px -10px;" class="form-control input-linea input-sm input'+id+'">'+
					'</div>'+
					'<div class="row">'+
						'<button class="btn btn-success btn-sm btn-asignar" style="padding: 3px;" id="'+id+'">Asignar</button> '+
						'<button class="btn btn-danger btn-sm btn-cancelar" style="padding: 3px;" id="'+id+'">Cancelar</button> '+
					'</div>'+
				'</div>';
	$(padre).append(form);
});

$(document).on('click','.btn-cancelar',function (arg) {
	debugger;
	var span=$(this.parentElement.parentElement.previousElementSibling);
	var padre=$(this.parentElement.parentElement);
	padre.remove();
	span.removeClass('hide');
});

$(document).on('click','.btn-asignar',function (arg) {
	debugger;
	var id=this.id;
	var span=$(this.parentElement.parentElement.previousElementSibling);
	var padre=$(this.parentElement.parentElement);
	var value=$(".input"+id).val();
	showGif();
	$.ajax({
        type: 'POST',
        url: URLs+'agencias/Agencias/AsignarCredito',
        data: 'CodigoEntidad='+id+'&Linea='+value,
        success: function (data) {
            hideGif();
        	debugger
            var data=JSON.parse(data);
            span.attr('name',data.Linea);
            span.html('$ '+data.Linea);
            span.removeClass('hide');
            padre.remove();
            // toastr.options.timeOut="10000";
        },
        error: function (xhr, textStatus, errorThrown) {
            hideGif();
        	debugger
            alert("Error: " + errorThrown);
        }
    });
});

$(document).on('keypress','.input-linea',function (arg) {
	var regex = new RegExp("^[0-9.]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

$(document).on('click','.btn-estado-agencia',function (arg) {
	var id=this.id;
	var estado=$(this).attr('name');
	var msg=estado == 1 ? '¿Esta seguro que desea <strong>DESACTIVAR</strong> esta Agencia?' : '¿Esta seguro que desea <strong>ACTIVAR</strong>  esta Agencia?';
	$("#modal-estado-agencia .panel-body p").html(msg);
	$("#modal-estado-agencia .panel-body .btn-success").attr('id',id);
	$("#modal-estado-agencia").modal();
});

$(document).on('click','#modal-estado-agencia .panel-body .btn-success',function (arg) {
	debugger
	var id=this.id;
	showGif();
	$.ajax({
        type: 'POST',
        url: URLs+'agencias/Agencias/AgenciaEstado',
        data: 'CodigoEntidad='+id,
        success: function (data) {
            hideGif();
        	debugger
        	$("#modal-estado-agencia").modal('hide');
        	var data=JSON.parse(data);
        	toastr.success(data[1], "Mensaje de confirmación");
        	$("#table-data").html(data[0]);
            // toastr.options.timeOut="10000";
        },
        error: function (xhr, textStatus, errorThrown) {
            hideGif();
        	debugger
            alert("Error: " + errorThrown);
        }
    });
});