$(function () {
	$('.input-daterange').datepicker({
	    todayBtn: "linked",
	    language: "es",
	    autoclose: true,
	    todayHighlight: true
	});
	var y=new Date();
    var today=devuelveDia(y.getDate())+'/'+devuelveMes(y.getMonth())+'/'+y.getFullYear();
    if ($("input[name=fecha_desde]").val()=='') {
    	$("input[name=fecha_desde]").datepicker('update',today);
    }
    if ($("input[name=fecha_hasta]").val()=='') {
    	$("input[name=fecha_hasta]").datepicker('update',today);
    }
});

function devuelveMes(mes) {
	var m=mes+1;
	m.toString();
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

function buscarMovimiento(select,page=null) {
	var formData=$("#formulario_busqueda").serialize()+'&select='+select;
	formData=formData+'&page='+(page ? page : '');
	$.ajax({
        url: URLs+'agencias/Movimientos/BusquedaMovimientos',
        data: formData,
        type: 'POST',
        success: function(html) {
        	$(".contenido-reporte").html(html);
        }
    });
}

function cambiarPaginacion(page) {
	buscarMovimiento(0,page);
}

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();
    document.body.innerHTML = originalContents;
    $('.modal-backdrop').remove();
    $('#ticket_electronico .close').click();
    document.getElementById("ticket_electronico").style.display="none";
}

$(document).on('submit','.formulario_busqueda',function (arg) {
	buscarMovimiento(0);
});

$(document).on('change','select[name=mostrar]',function (arg) {
	buscarMovimiento(1);
});

$(document).on('click','.nro_ticket',function(){
    var ticket = $(this).attr("id");
    $.ajax({
        type: "POST",
        url : URLs+"agencias/Movimientos/ObtenerEticket/"+ticket,
        data: "ticket="+ticket,
        success: function (msg){
            $("#eticket").html(msg);
            $('#ticket_electronico').modal('show');
        },
    });
});

$(document).on('click','.codigoreserva',function(){
    var reserva = $(this).attr("id");
    var name = $(this).attr("name").split('|');
    $.ajax({
        type: "POST",
        data: 'ticket='+name[2]+'&registro='+name[0]+'&detalle='+name[1],
        url: URLs+"agencias/Movimientos/ObtenerDetalleTransaccion/"+reserva,
        success: function(html) {
           $('#cuerpo_detalle').html(html);
           $('#detalle_transaccion').modal('show');
        }
    });      
});

$(document).on('click','#divPrint',function(){
    printDiv('eticket');
});

$('.modal-dialog').draggable({
	handle: ".panel-heading"
});

$(document).on('click','.btn-metodo-pago',function () {
	var id=this.id.split('|');
	var name=$(this).attr('name').split('|');
	$.ajax({
        type: "POST",
        data: 'reserva_id='+id[0],
        url: URLs+"agencias/Movimientos/ObtenerDetalleTransaccionVisa",
        success: function(html) {
           $('#detalle_transaccion_visa .panel-body .table-responsive').html(html);
           $('#detalle_transaccion_visa').modal('show');
        }
    });
});