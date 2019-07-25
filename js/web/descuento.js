
$(function () {
    $('.select2').select2()
    $('#rango_aplica_descuento').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    })
    $('#confirm-delete').on('click', '.btn-ok', function (e) {
        var $modalDiv = $(e.delegateTarget);
        var id = $(this).data('recordId');
        $modalDiv.addClass('loading');
        $.post("Descuento/EliminarDescuento", { id_del: id }).done(function (data) {
            
            setTimeout(function () {
                $modalDiv.modal('hide').removeClass('loading');
                if(data==1){
                    $("#fila" + id).remove();
                }else{
                    console.log('El registro no fue eliminado!')
                }
            }, 1000)
        });
    });

    $("#confirm-delete").on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('.title', this).text(data.recordTitle);
        $('.btn-ok', this).data('recordId', data.recordId);
    });
});
