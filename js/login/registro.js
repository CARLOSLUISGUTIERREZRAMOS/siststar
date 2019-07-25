$(function () {

    //VALIDAMOS SI EL ELEMENTO CON CLASE .select2 existe en el DOM
    if ($('.select2').length)
    {
        $('.select2').select2();
    }
    //VALIDAMOS SI EL ELEMENTO data-mask existe en el DOM
    if ($('[data-mask]').length)
    {
        $('[data-mask]').inputmask();
    }

    $('#modal-success').modal('show');
    $('#modalVolver').click(function(){
       
    })
    

});