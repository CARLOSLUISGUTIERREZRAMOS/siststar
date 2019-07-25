$(function () {
    var y=new Date();
    $("select[name=anio]").val(y.getFullYear());
    $("select[name=mes]").val(devuelveMes(y.getMonth()));
    $("#btn-venta-mensual").attr('href',URLs+'reportes/Ventas/ReporteMensual/'+devuelveMes(y.getMonth())+'/'+y.getFullYear());
});

$(document).on('change','select[name=mes]',function (argument) {
    $("#btn-venta-mensual").attr('href',URLs+'reportes/Ventas/ReporteMensual/'+this.value+'/'+$("select[name=anio]").val());
})

$(document).on('change','select[name=anio]',function (argument) {
    $("#btn-venta-mensual").attr('href',URLs+'reportes/Ventas/ReporteMensual/'+$("select[name=mes]").val()+'/'+this.value);
})

function devuelveMes(mes) {
    var m=mes+1;
    m.toString();
    if (m.length==1) {
        m='0'+m;
    }
    return m;
}