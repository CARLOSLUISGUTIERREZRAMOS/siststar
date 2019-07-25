$(function () {
	$('.date-calendar').datepicker({
        language: "es",
        format: "dd/mm/yyyy",
        // daysOfWeekDisabled: "0,6",
        // daysOfWeekHighlighted: "0,6",
        todayBtn: true,
        autoclose: true,
        todayHighlight: true
    });
    var y=new Date();
    var today=devuelveDia(y.getDate())+'/'+devuelveMes(y.getMonth())+'/'+y.getFullYear();
    $("input[name=date_inicio]").datepicker('update',today);
    $("input[name=date_fin]").datepicker('update',today);
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

$(document).on('change','select[name=origen]',function (e) {
	if (this.value=='') {
	$("select[name=destino]").html('<option value="">TODOS</option>');
	}
	else{
		obtenerRutasDestino(this.value);
	}
});

function obtenerRutasDestino(id) {
	$.ajax({
        url: URLs+'reportes/Ventas/ObtenerDestinoRuta',
        type: 'POST',
        data: 'ciudad_origen=' + id,
        success: function(data,status,c) {
            $("select[name=destino]").empty();
            var rutas = jQuery.parseJSON(data);
            // $("select[name=destino]").append('<option value="">TODOS</option>');
            jQuery.each(rutas, function (i, val) {
                $("select[name=destino]").append($('<option>', {value: val.codigo, text: val.nombre}));
            });
        }
    });
    return false;
}

function obterDataRuta() {
	var formData=$("#form-datos").serialize();
	$("#btn-venta-ruta").html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
	var tbody=$("#tabla-ventas-rutas tbody");
	$.ajax({
        url: URLs+'reportes/Ventas/ObtenerVentasRutaData',
        type: 'POST',
        data: formData,
        success: function(data,status,c) {
            var rutas = jQuery.parseJSON(data);
            var tipo=$("select[name=tipo]").val();
            if(tipo=='R'){
                var tipo_text='RT';   
            }else if(tipo=='O'){
               var tipo_text='OW';   
            }else if(tipo==''){
               var tipo_text='OW & RT';   
            }
            tbody.empty();
            var total=0;
            jQuery.each(rutas, function (i, val) {
                tbody.append('<tr>'+
                				'<th style="text-align: center"><b>'+val.ruta+'</b></th>'+
	                            '<th style="text-align: center"><b>'+tipo_text+'</b></th>'+
	                            '<th style="text-align: right"><b>'+val.total+'</b></th>'+
	                        '</tr>');
                total=total+Math.round(val.total*100)/100;
            });
            tbody.append('<tr>'+
                                '<th colspan="2" style="text-align: right"><b>TOTAL:</b></th>'+
                                '<th style="text-align: right"><b>$ '+Math.round(total*100)/100+'</b></th>'+
                            '</tr>');
            $("#btn-venta-ruta").html('<i class="fa fa-building-o"></i> Ver Data');
        }
    });
    return false;
}

