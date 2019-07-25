$(function () {
    var y=new Date();
    $("select[name=anio]").val(y.getFullYear());
    $("select[name=mes]").val(devuelveMes(y.getMonth()));
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

function devuelveMesManual(mes){
    var mes=mes.toString();
    if (mes.length==1) {
        mes='0'+mes;
    }
    return mes;
}

function cargarInicioTabla() {
    var t=$("#tabla-ventas tbody");
    t.empty();
    t.append('<tr class="head">'+
                '<th ><strong>Lunes</strong></th>'+
                '<th ><strong>Martes</strong></th>'+
                '<th ><strong>Miercoles</strong></th>'+
                '<th ><strong>Jueves</th>'+
                '<th ><strong>Viernes</strong></th>'+
                '<th ><strong>Sábado</th>'+
                '<th ><strong>Domingo</strong></th>'+
                '<th ><strong>Total</th>'+
            '</tr>');
    for (var i = 1; i < 7; i++) {
        t.append('<tr class="t">'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n"></td>'+
                    '<td class="n">0.00</td>'+
                '</tr>');
    }
    t.append('<tr class="f">'+
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

function mostrarCalendario() {
    cargarInicioTabla();
    var tbody=$("#tabla-ventas tbody").find("tr.t");
    var year=$("select[name=anio]").val();
    var month=$("select[name=mes]").val();
    var actual=moment();
    var diasMes = [0,31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    if (month==2) {
        if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)){
            var diaMax=29;
        }
        else{
            var diaMax=28;
        }
    }
    else{
        var diaMax=diasMes[month];
    }

    var now=moment(year+'-'+devuelveMesManual(month)+'-01');
    var last=moment(year+'-'+devuelveMesManual(month)+'-'+diaMax);
    var primerDiaSemana=(now.day()==0)?7:now.day();
    var ultimoDiaMes=diaMax;
    var dia=0;
    var diaActual=0;
 
    var last_cell=primerDiaSemana+ultimoDiaMes;
 
    for(var i=1;i<=42;i++){
        if(i==primerDiaSemana){
            // determinamos en que dia empieza
            dia=1;
        }

        if(i<primerDiaSemana || i>=last_cell){
            // celda vacia
        }
        else{
            // mostramos el dia
            var f=year+'-'+devuelveMesManual(month)+'-'+devuelveMesManual(dia);
            if(dia==actual.date() && month==actual.month()+1 && year==actual.year())
                pintarFechaCalendario(i,tbody,dia,1,f);
            else
                pintarFechaCalendario(i,tbody,dia,0,f);
            dia++;
        }
        if(i%7==0){
            if(dia>ultimoDiaMes)
                break;
        }
    }
}

function pintarFechaCalendario(i,tbody,dia,hoy,f) {
    var n=moment(f).day();
    if (i>=1 && i<=7) {
        var td=$(tbody[0]).find('td');
    }
    else if (i>=8 && i<=14) {
        var td=$(tbody[1]).find('td');
    }
    else if (i>=15 && i<=21) {
        var td=$(tbody[2]).find('td');
    }
    else if (i>=22 && i<=28) {
        var td=$(tbody[3]).find('td');
    }
    else if (i>=29 && i<=35) {
        var td=$(tbody[4]).find('td');
    }
    else if (i>=36 && i<=42) {
        var td=$(tbody[5]).find('td');
    }
    if (n==0) {
        var html=$(td[6]);
    }
    else{
        var html=$(td[n-1]);
    }
    var h=hoy==1 ? 'warning': 'primary';
    html.append('<div class="pull-left">'+
                        '<span class="label label-'+h+'" title="Día">'+dia+'</span>'+
                    '</div>');
}

function obterDataMensual() {
    mostrarCalendario();
    var formData=$("#form-datos").serialize();
    $("#btn-venta-mensual").html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
    var tbody=$("#tabla-ventas tbody");
    $.ajax({
        url: URLs+'reportes/Ventas/ObtenerVentaMensualData',
        type: 'POST',
        data: formData,
        success: function(data,status,c) {
            var objeto = jQuery.parseJSON(data);
            cargarDataTabla(objeto);
            $("#btn-venta-mensual").html('<i class="fa fa-building-o"></i> Ver Data');
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
    for (var i = 0; i <= 5; i++) {
        var t=0;
        var tr=$(tbody[i]).find("td");
        for (var j = 0; j < 7; j++) {
            var td=$(tr[j]);
            var span=td.find('span').text();
            if (span) {
                var res=objetos.filter(function(r) {
                    return r.dia==span;
                });
                if (res.length>0) {
                    t=t+parseFloat(res[0][buscar]);
                    if (res[0].nombre==1) {
                        t1=t1+parseFloat(res[0][buscar]);
                    }
                    else if (res[0].nombre==2) {
                        t2=t2+parseFloat(res[0][buscar]);
                    }
                    else if (res[0].nombre==3) {
                        t3=t3+parseFloat(res[0][buscar]);
                    }
                    else if (res[0].nombre==4) {
                        t4=t4+parseFloat(res[0][buscar]);
                    }
                    else if (res[0].nombre==5) {
                        t5=t5+parseFloat(res[0][buscar]);
                    }
                    else if (res[0].nombre==6) {
                        t6=t6+parseFloat(res[0][buscar]);
                    }
                    else if (res[0].nombre==0) {
                        t7=t7+parseFloat(res[0][buscar]);
                    }
                    td.append('<div class="pull-right">'+
                                    '<span title="Monto">'+parseFloat(res[0][buscar]).toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</span>'+
                                '</div>');
                }
            }
        }
        t8=t8+t;
        if (t>0) {
            $(tr[7]).html('<strong>'+t.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
        }
        else{
            $(tr[7]).html(def);
        }
    }
    var f=$(tfoter[0]).find('td');
    $(f[0]).html('<strong>'+t1.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[1]).html('<strong>'+t2.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[2]).html('<strong>'+t3.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[3]).html('<strong>'+t4.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[4]).html('<strong>'+t5.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[5]).html('<strong>'+t6.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[6]).html('<strong>'+t7.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
    $(f[7]).html('<strong>'+t8.toLocaleString('en', {minimumFractionDigits: 0, maximumFractionDigits: 2})+'</strong>');
}