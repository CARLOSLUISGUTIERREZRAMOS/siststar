$(function () {

    var num_manifi;
    var num_vuelo;
    var fecha;
    var origen;
    var destino;
    var estado;


    $.getScript("../../js/app/genericas.js");
//    alert(2);
    $('#tipo_busqueda').change(function () {
        funcionDesactivarActivarElemento(1, ['num_manifi']);
    });

    $('#buscaManifiMod').click(function () {
        num_manifi = $('#num_manifi').val();
//        console.log(num_manifi);

        $.ajax({
            type: 'POST',
            url: 'dataCabeceraManifiesto',
            data: 'num_manifi=' + num_manifi,
            success: function (data) {
                if (data == 0) {
                    funcionShowModal('Advertencia','El manifiesto no puede estar en estado volado o anulado.','Entiendo','modal-danger');
                } else {
//                    console.log(data); TEST
                    var dataSplit = data.split('°');
                    var cabecera = dataSplit[0];
                    var tbodyDetalleManif = dataSplit[1];
                    
                    var cabeceraSplit = cabecera.split('|');
                    
                    num_vuelo = cabeceraSplit[0];
                    fecha = cabeceraSplit[1];
                    origen = cabeceraSplit[2];
                    destino = cabeceraSplit[3];
                    estado = cabeceraSplit[4];
                    $('#num_vuelo').val(num_vuelo);
                    $('#fecha').val(fecha);
                    $('#origen').val(origen);
                    $('#destino').val(destino);
                    $('#estado_manifiesto').val(estado);
                    
                    $('#manifiesto_modificacion tbody').append(tbodyDetalleManif);
                }


            }
        });

    });

});


