$(function () {
//    $.getScript("../../../js/app/genericas.js");  //LLAMANDO AL FICHERO DONDE TENEMOS FUNCIONES GENERICAS
    var clipboard = new ClipboardJS('.btn');
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
    var id_file = $('#id_file').val();
    $('#textoError').hide();
    

    $('body').on('click', '#btnRegresar', function () {
        console.log('asd');
        window.location.href = "../../file/listaArchivosSubidos/EXCEL/CARGA";
    });
    
    $('body').on('click','#btnMostrarDetalleError',function(){
       
       $.ajax({
          type: 'POST',
          url: 'retornaDataError',
          data: 'id_file='+id_file,
            success: function (data) {
                $('#textoError').show();
                $('#textoError').html(data);
            }
       });
       
    });

    $('.btn-text-pop').popover({html:true});        
//    $('.btn-text-too').tooltip({html:true});
//    $('[data-toggle="popover"]').popover();   


    

});