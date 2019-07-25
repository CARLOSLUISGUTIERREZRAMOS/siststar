$(function () {
    $("#table_main").dataTable();
    $('body').on('click', '#descargar_excel', function () {
        var nombre_excel = $(this).attr("name");
        $.ajax({
            type: 'POST',
            data: 'nombre_excel=' + nombre_excel,
            url: '../../conversion/descargar',
            success: function (data) {
                alert(data);
            }
        });
    });


});
