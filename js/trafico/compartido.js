$(function () {
    $('#datepicker').datepicker({
        format: "d/mm/yyyy",
        autoclose: true

    });
    $(document).ready(function () {
        $("#add").click(function () {
            var intId = $("#input_dinamico div").length + 1;
            var row = $("<div class=\"row\"></div>");
            var apellidos = $("<div class=\"col-lg-3\"><div class=\"form-group\"><input type=\"text\" id=\"apellido\" class=\"form-control\" name=\"apellidos[]\" style=\"text-transform:uppercase;\" required/>");
            var nombres = $("<div class=\"col-lg-3\"><div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"nombres[]\" style=\"text-transform:uppercase;\" required/>");
            var tipo = $("<div class=\"col-lg-3\"><div class=\"form-group\"><select class=\"form-control\" name=\"cboTipo[]\"><option>ADT</option><option>CHD</option><option>INF</option>");
            var fType = $("");
            var removeButton = $("<button class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i></button>");
            removeButton.click(function () {
                $(this).parent().remove();
            });
            row.append(apellidos);
            row.append(nombres);
            row.append(tipo);
            row.append(removeButton);
            $("#input_dinamico").append(row);
        });
    });


    $("body").on("click", ".btn_edit_refund", function () {
//    $('.btn_edit_refund').click(function () {
        var num_id = $(this).val();
        $('#myModal').modal('show');
        var id_pasajero = $(this).parents("tr").find("td").eq(0).html();
        var id_vuelo = $(this).parents("tr").find("td").eq(1).html();
        var apellidos = $(this).parents("tr").find("td").eq(2).html();
        var nombres = $(this).parents("tr").find("td").eq(3).html();
        var tipo = $(this).parents("tr").find("td").eq(4).html();

        $('#nombres').val(nombres);
        $('#apellidos').val(apellidos);
        $('#num_id').val(num_id);
        $('#id_vuelo').val(id_vuelo);
        $('#id_pasajero').val(id_pasajero);
        $('#cboTipo').val(tipo);
    });
    $("body").on("click", ".btn_edit_refund", function () {
//    $('.btn_edit_refund').click(function () {
//        var id = $(this).val();
        $('#myModal2').modal('show');

        var id = $(this).parents("tr").find("td").eq(0).html();
        var fecha = $(this).parents("tr").find("td").eq(1).html();
        var vuelo = $(this).parents("tr").find("td").eq(2).html();
        var origen = $(this).parents("tr").find("td").eq(3).html();
        var destino = $(this).parents("tr").find("td").eq(4).html();
        var tipo = $(this).parents("tr").find("td").eq(6).html();

        $('#datepicker').val(fecha);
        $('#vuelo').val(vuelo);
        $('#origen').val(origen);
        $('#destino').val(destino);
        $('#id').val(id);
        $('#vuelo_tipo').val(tipo);

    });
    $("body").on("click", ".btn_agregar", function () {
        var num_id = $(this).val();
        $('#myModal3').modal('show');
        $('#id').val(num_id);
    });
    //Date range picker
    $('#daterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
    $('#tbl_users').DataTable();

});