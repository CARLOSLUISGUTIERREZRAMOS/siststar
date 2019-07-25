$(function () {
	$('.date-calendar').datepicker({
        language: "es",
        // format: "dd/mm/yyyy",
        todayBtn: "linked",
        orientation: "auto",
        autoclose: true,
        todayHighlight: true
    });

    $('.btn_ver_farebase').click(function () {

        var ruta_id = $(this).attr('id');
//        $.post("Farebase/test");

//        $.post("Farebase/test/", { ruta: ruta_id},function (data) {
//            $('#daaaa').html(data);
//        });
//        $.post("Farebase/test/", { ruta: ruta_id } );

    });
});