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

$(document).on('click','.estado-usuario',function (arg) {
	var id=this.id;
	var estado=$(this).attr('name');
	var msg=estado == 1 ? '¿Esta seguro que desea <strong>DESACTIVAR</strong> al usuario?' : '¿Esta seguro que desea <strong>ACTIVAR</strong> al usuario?';
	$("#modal-estado-usuario .panel-body p").html(msg);
	$("#modal-estado-usuario .panel-body .btn-success").attr('id',id);
	$("#modal-estado-usuario").modal();
});

$(document).on('click','#modal-estado-usuario .panel-body .btn-success',function (arg) {
	debugger
	var id=this.id;
	showGif();
	$.ajax({
        type: 'POST',
        url: URLs+'agencias/Agencias/UsuarioEstado',
        data: 'CodigoPersonal='+id,
        success: function (data) {
            hideGif();
        	debugger
        	$("#modal-estado-usuario").modal('hide');
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
    location.reload();
});

$(document).on('click','.resetear-password',function (arg) {
	var id=this.id;
	$("#modal-resetear-password .panel-body .btn-success").attr('id',id);
	$("#modal-resetear-password").modal();
});

$(document).on('click','#modal-resetear-password .panel-body .btn-success',function (arg) {
	debugger
	var id=this.id;
	showGif();
	$.ajax({
        type: 'POST',
        url: URLs+'agencias/Agencias/ResetearPaswoord',
        data: 'CodigoPersonal='+id,
        success: function (data) {
            hideGif();
        	debugger
        	$("#modal-resetear-password").modal('hide');
        	// var data=JSON.parse(data);
        	toastr.success(data, "Mensaje de confirmación");
            // toastr.options.timeOut="10000";
        },
        error: function (xhr, textStatus, errorThrown) {
            hideGif();
        	debugger
            alert("Error: " + errorThrown);
        }
    });
    location.reload();
});
$(document).on("click", ".btn_agregar_usuario", function () {
    $('#myModal4').modal('show');
    var codigoEntidad = $(this).val();
    $('#codigoEntidad2').val(codigoEntidad);
});

$(document).on("click", ".btn_editar_usuario", function () {
    $('#myModal5').modal('show');
    var codigoEntidad = $(this).parents("tr").find("td").eq(1).html();
    var codigoPersonal = $(this).parents("tr").find("td").eq(2).html();
    var dni = $(this).parents("tr").find("td").eq(3).html();
    var apePat = $(this).parents("tr").find("td").eq(5).html();
    var apeMat = $(this).parents("tr").find("td").eq(6).html();
    var nombres = $(this).parents("tr").find("td").eq(7).html();
    var email = $(this).parents("tr").find("td").eq(8).html();
    var telefono = $(this).parents("tr").find("td").eq(9).html();
    var celular = $(this).parents("tr").find("td").eq(10).html();
    var tipo = $(this).parents("tr").find("td").eq(11).html();
    $('#codigoEntidad').val(codigoEntidad);
    $('#codigoPersonal').val(codigoPersonal);
    $('#dni').val(dni);
    $('#apePat').val(apePat);
    $('#apeMat').val(apeMat);
    $('#nombres').val(nombres);
    $('#email').val(email);
    $('#telefono').val(telefono);
    $('#celular').val(celular);
    $('#tipo').val(tipo);
});
$('#tbl_users').DataTable({
    "columnDefs": [{
    "targets": [13],
    "orderable": false,
        }],
})