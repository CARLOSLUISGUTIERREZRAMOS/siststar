$(function () {
    var y=new Date();
    $("select[name=anio]").val(y.getFullYear());
    $("select[name=dia]").val(y.getDate());
    $("select[name=mes]").val(devuelveMes(y.getMonth()));
    h=[
        '00:00',
        '01:00',
        '02:00',
        '03:00',
        '04:00',
        '05:00',
        '06:00',
        '07:00',
        '08:00',
        '09:00',
        '10:00',
        '11:00',
        '12:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00',
        '17:00',
        '18:00',
        '19:00',
        '20:00',
        '21:00',
        '22:00',
        '23:00',
    ];
    cargarInicioTabla();
});

function devuelveMes(mes) {
    var m=mes+1;
    m.toString();
    if (m.length==1) {
        m='0'+m;
    }
    return m;
}

function cargarInicioTabla() {
    var t=$("#tabla-ventas tbody");
    t.append('<tr class="head">'+
                '<th ><strong>Hora</strong></th>'+
                '<th ><strong>VISA</strong></th>'+
                '<th ><strong>MasterCard</th>'+
                '<th ><strong>Diners</strong></th>'+
                '<th ><strong>Americam Express</strong></th>'+
                '<th ><strong>PayPal</strong></th>'+
                '<th ><strong>SafetyPay</strong></th>'+
                '<th ><strong>Pago Efectivo</strong></th>'+
                '<th ><strong>Total</strong></th>'+
            '</tr>');
    $.each(h,function (index,val) {
        t.append('<tr class="t">'+
                    '<td class="h">'+val+'</td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n">0.00</td>'+
                '</tr>');
    });
    t.append('<tr class="f">'+
                '<td class="h">Total</td>'+
                '<td class="n">0.00</td>'+
                '<td class="n">0.00</td>'+
                '<td class="n">0.00</td>'+
                '<td class="n">0.00</td>'+
                '<td class="n">0.00</td>'+
                '<td class="n">0.00</td>'+
                '<td class="n">0.00</td>'+
                '<td class="n">0.00</td>'+
            '</tr>');
}

function obterDataDiaria() {
    var formData=$("#form-datos").serialize();
    $("#btn-venta-dia").html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
    var tbody=$("#tabla-ventas tbody");
    $.ajax({
        url: URLs+'reportes/Ventas/ObtenerVentasDiaData',
        type: 'POST',
        data: formData,
        success: function(data,status,c) {
            var objeto = jQuery.parseJSON(data);
            cargarDataDefecto();
            cargarDataTabla(objeto);
            $("#btn-venta-dia").html('<i class="fa fa-building-o"></i> Ver Data');
        }
    });
    return false;
}

function cargarDataTabla(objetos) {
    var tipo=$("select[name=tipo]").val();
    var tbody=$("#tabla-ventas tbody").find("tr.t");
    var tfoter=$("#tabla-ventas tbody").find("tr.f");
    if (tipo==0) {
        var buscar="importe";
        var def='0.00';
    }
    else{
        var buscar="cantidad";
        var def='0';
    }
    var t1=0;
    var t2=0;
    var t3=0;
    var t4=0;
    var t5=0;
    var t6=0;
    var t7=0;
    var t8=0;
    for (var i = 0; i <= 23; i++) {
        var tr=$(tbody[i]).find("td");
        var res=objetos.filter(function(r) {
            return r.hora==i;
        });
        var t=0;
        if (res.length>0) {
            $.each(res,function(index,val) {
                t=t+parseFloat(val[buscar]);
                if (val.cc_code=='VI') {
                    t1=t1+parseFloat(val[buscar]);
                    $(tr[1]).html(val[buscar].toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='MC') {
                    t2=t2+parseFloat(val[buscar]);
                    $(tr[2]).html(val[buscar].toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='DC') {
                    t3=t3+parseFloat(val[buscar]);
                    $(tr[3]).html(val[buscar].toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='AX') {
                    t4=t4+parseFloat(val[buscar]);
                    $(tr[4]).html(val[buscar].toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='PP') {
                    t5=t5+parseFloat(val[buscar]);
                    $(tr[5]).html(val[buscar].toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='SP') {
                    t6=t6+parseFloat(val[buscar]);
                    $(tr[6]).html(val[buscar].toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='PE') {
                    t7=t7+parseFloat(val[buscar]);
                    $(tr[7]).html(val[buscar].toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
            });
            t8=t8+t;
            $(tr[8]).html('<strong>'+t.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
        }
        else{
            $(tr[8]).html(def);
        }
    }
    var f=$(tfoter[0]).find('td');
    $(f[1]).html('<strong>'+t1.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[2]).html('<strong>'+t2.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[3]).html('<strong>'+t3.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[4]).html('<strong>'+t4.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[5]).html('<strong>'+t5.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[6]).html('<strong>'+t6.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[7]).html('<strong>'+t7.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[8]).html('<strong>'+t8.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
}

function cargarDataDefecto() {
    var tbody=$("#tabla-ventas tbody").find("tr.t");
    var tfoter=$("#tabla-ventas tbody").find("tr.f");
    for (var i = 0; i <= 23; i++) {
        var tr=$(tbody[i]).find("td");
        $(tr[1]).html('');
        $(tr[2]).html('');
        $(tr[3]).html('');
        $(tr[4]).html('');
        $(tr[5]).html('');
        $(tr[6]).html('');
        $(tr[7]).html('');
        $(tr[8]).html('0.00');
    }
    var f=$(tfoter[0]).find('td');
    $(f[1]).html('0.00');
    $(f[2]).html('0.00');
    $(f[3]).html('0.00');
    $(f[4]).html('0.00');
    $(f[5]).html('0.00');
    $(f[6]).html('0.00');
    $(f[7]).html('0.00');
    $(f[8]).html('0.00');
}