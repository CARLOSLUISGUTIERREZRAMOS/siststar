$(function () {
    $('.date-calendar').datepicker({
        language: "es",
        format: "dd/mm/yyyy",
        todayBtn: true,
        autoclose: true,
        todayHighlight: true
    });
    var y=new Date();
    var today=devuelveDia(y.getDate())+'/'+devuelveMes(y.getMonth())+'/'+y.getFullYear();
    $("input[name=desde]").datepicker('update',today);
    $("input[name=hasta]").datepicker('update',today);
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

function obterDataPais() {
    var formData=$("#form-datos").serialize();
    $("#btn-venta-pais").html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
    var tbody=$("#tabla-ventas tbody");
    $.ajax({
        url: URLs+'reportes/Ventas/ObtenerPaisData',
        type: 'POST',
        data: formData,
        success: function(data,status,c) {
            var objeto = jQuery.parseJSON(data);
            dibujarTablaDinamico(objeto[1]);
            cargarDataTabla(objeto[0],objeto[1]);
            $("#btn-venta-pais").html('<i class="fa fa-building-o"></i> Ver Data');
        }
    });
    return false;
}

function cargarDataTabla(objetos,pais) {
    var tbody=$("#tbl_reportes tbody").find("tr.t");
    var tfoter=$("#tbl_reportes tbody").find("tr.f");
    var t1=0;
    var t2=0;
    var t3=0;
    var t4=0;
    var t5=0;
    var t6=0;
    var t7=0;
    var t8=0;
    var t9=0;
    var t10=0;
    for (var i = 0; i < pais.length; i++) {
        var tr=$(tbody[i]).find("td");
        var res=objetos.filter(function(p) {
            return p.nombre_pais==pais[i].nombre_pais;
        });
        var t=0;
        var tk=0;
        if (res.length>0) {
            $.each(res,function(index,val) {
                t=t+parseFloat(val.importe);
                tk=tk+parseInt(val.cantidad);
                if (val.cc_code=='VI') {
                    t1=t1+parseFloat(val.importe);
                    $(tr[1]).html(val.importe.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='MC') {
                    t2=t2+parseFloat(val.importe);
                    $(tr[2]).html(val.importe.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='DC') {
                    t3=t3+parseFloat(val.importe);
                    $(tr[3]).html(val.importe.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='AX') {
                    t4=t4+parseFloat(val.importe);
                    $(tr[4]).html(val.importe.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='PP') {
                    t5=t5+parseFloat(val.importe);
                    $(tr[5]).html(val.importe.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='SP') {
                    t6=t6+parseFloat(val.importe);
                    $(tr[6]).html(val.importe.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
                else if (val.cc_code=='PE') {
                    t7=t7+parseFloat(val.importe);
                    $(tr[7]).html(val.importe.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
                }
            });
            t8=t8+t;
            t9=t9+tk;
            var prom=t/tk;
            t10=t10+prom;
            $(tr[8]).html('<strong>'+t.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
            $(tr[9]).html(tk.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2}));
            $(tr[10]).html('<strong>'+prom.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
        }
        else{
            $(tr[8]).html('0.00');
            $(tr[9]).html('0');
            $(tr[10]).html('0.00');
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
    $(f[9]).html('<strong>'+t9.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[10]).html('<strong>'+t10.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
}

function dibujarTablaDinamico(objeto) {
    var table=$("#tbl_reportes tbody");
    table.empty();
    if (objeto.length>0) {
        for (var i = 0; i < objeto.length; i++) {
            table.append('<tr class="t">'+
                            '<td>'+objeto[i].nombre_pais+'</td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td>0</td>'+
                            '<td>0.00</td>'+
                        '</tr>');
        }
    }
    else{
        table.append('<tr class="t">'+
                            '<td>-</td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td></td>'+
                            '<td>0</td>'+
                            '<td>0.00</td>'+
                        '</tr>');
    }
    table.append('<tr class="f">'+
                        '<td>Total</td>'+
                        '<td>0.00</td>'+
                        '<td>0.00</td>'+
                        '<td>0.00</td>'+
                        '<td>0.00</td>'+
                        '<td>0.00</td>'+
                        '<td>0.00</td>'+
                        '<td>0.00</td>'+
                        '<td>0.00</td>'+
                        '<td>0</td>'+
                        '<td>0.00</td>'+
                    '</tr>');
}