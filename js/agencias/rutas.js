$(document).ready(function() {
    // $(".datepicker").datepicker();
    //DESCARGAR TARIFAS DE KIU
});

$(document).on('click','.procesar',function(){
    var session=sessionAjax();
    if (session) {
        var datos = $(this).attr('id');
        var datos=this.id.split('|');
        // var array = datos.split('-');
        var id = datos[0];
        var origen = datos[1];
        var destino = datos[2];
        
        var data = new FormData();
        data.append('id',id);
        data.append('origen',origen);
        data.append('destino',destino);
        
        $.ajax({
            type: "POST",
            url:  URLs+'agencias/Rutas/ProcesarDatos',
            data: data,
            processData: false,
            contentType: false,
            success: function(msg){
                $("#lista_descargadas").html(msg);
                // $("#ruta3").html(array[1]);
                $("#tarifas_descargadas").modal('show');
            }
        });
    }
    else{
        window.location.reload();
    }
});

//EDITAR TARIFAS Y VIGENCIAS
$(document).on('click','.tarifas',function(){
    var session=sessionAjax();
    if (session) {
        var string = this.id.split('|');
        var id = string[0];
        var ruta = string[1]+' - '+string[2];
        var data = new FormData();
        data.append('id',id);
        $.ajax({
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            url:  URLs+'agencias/Rutas/MostrarDetalleTarifas',
            success: function (msg){
                $("#lista_tarifas").html(msg);
                $('#lista_tarifas').find(".datepicker").datepicker({
                    todayBtn: "linked",
                    language: "es",
                    autoclose: true,
                    todayHighlight: true
                });
                $("#ruta").html(ruta);
                $("#editar_tarifas").modal('show');
            }
        });
    }
    else{
        window.location.reload();
    }
    
});

$("#guardar_tarifas").click(function(){
    var idruta = $("#idruta").val();
    var str_fb = $("#farebases").val();
    var farebases = str_fb.split('*');
    var data=[];
    for(var i=0;i<farebases.length;i++){
        var obj={};
        var cad = idruta+'-'+farebases[i]+'-';
        obj.web = 0;
        obj.idruta=idruta;
        obj.farebase=farebases[i];
        obj.tarifa = $("#"+cad+"tarifa").val();
        obj.emision0 = $("#"+cad+"emision0").val();
        obj.emision1 = $("#"+cad+"emision1").val();
        obj.vigencia0 = $("#"+cad+"vigencia0").val();
        obj.vigencia1 = $("#"+cad+"vigencia1").val();
        obj.estmin = $("#"+cad+"estmin").val();
        obj.estmax = $("#"+cad+"estmax").val();
        if($("#"+cad+"web").prop('checked')){
            obj.web=1;
        }
        data.push(obj);
    }
    $.ajax({
        type: "POST",
        url:  URLs+"agencias/Rutas/EditarTarifas",
        data: {"formData":data},
        success: function(msg){
            $("#editar_tarifas").modal('hide');
            // window.location.reload();
            alert(msg);
        },
        error : function (msg) {
            alert(msg);
        }
    });
});

//EDITAR TEMPORADAS
$(document).on('click','.temporadas',function(){
    var session=sessionAjax();
    if (session) {
        var string = this.id.split('|');
        var id = string[0];
        var ruta = string[1]+' - '+string[2];
        var data = new FormData();
        data.append('id',id);
        $.ajax({
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            url:  URLs+'/agencias/Rutas/MostrarDetalleTemporadas',
            success: function (msg){
                $("#editar_temporadas .table-responsive").html(msg);
                $("#ruta2").html(ruta);
                $("#editar_temporadas").modal('show');
            }
        });
    }
    else{
        window.location.reload();
    }
}); 

$(document).on('click','.todos',function(){
    var id = ($(this).attr('id').trim()).split('-');
    var id1 = id[0];
    var id2 = id[1];
    
    if($(this).prop('checked')){
        for(var j=0;j<12;j++){
            $("#"+id1+"-"+id2+"-"+j).prop('checked',true);
        }
    }
    else{
        for(var j=0;j<12;j++){
            $("#"+id1+"-"+id2+"-"+j).prop('checked',false);
        }
    }
    
});

$("#guardar_temporadas").click(function(){
    var idruta = $("#idruta").val();
    var str_fb = $("#farebases").val();
    var farebases = str_fb.split('*');
    
    for(var i=0;i<farebases.length;i++){
        var cad = idruta+'-'+farebases[i]+'-';
        var data = new FormData();
        data.append('idruta',idruta);
        data.append('farebase',farebases[i]);
        
        for(var j=0;j<12;j++){
            var mes = 0;
            if($("#"+cad+j).prop('checked')) mes=1;
            
            switch (j){
                case 0: data.append('Enero',mes);break;
                case 1: data.append('Febrero',mes);break;
                case 2: data.append('Marzo',mes);break;
                case 3: data.append('Abril',mes);break;
                case 4: data.append('Mayo',mes);break;
                case 5: data.append('Junio',mes);break;
                case 6: data.append('Julio',mes);break;
                case 7: data.append('Agosto',mes);break;
                case 8: data.append('Setiembre',mes);break;
                case 9: data.append('Octubre',mes);break;
                case 10: data.append('Noviembre',mes);break;
                case 11: data.append('Diciembre',mes);break;
            }
        }
        
        $.ajax({
            type: "POST",
            url:  "ruta_lista/editar_temporadas/",
            data: data,
            processData: false,
            contentType: false,
            success: function(msg){
                $("#editar_temporadas").modal('hide');
                window.location.reload();
            }
        });
    }
});