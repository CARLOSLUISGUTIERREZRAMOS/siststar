$(function () {

    $('.status_refund_select').hide();
    var cantidad_items = $("#cant").val();
    for (var i = 1; i <= cantidad_items; i++) {
        $('#datemask_' + i).inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
    }
    $('#example1').DataTable({
//                "order": [[9, "desc"]],
        "ordering": false
    });

    $("body").on("click", ".btn_edit_refund", function () {
//    $('.btn_edit_refund').click(function () {
        var num_id = $(this).val();
        $('#myModal').modal('show');
        var num_refund = $(this).parents("tr").find("td").eq(0).html();
        
        var splitdata =  num_refund.split("<");
         var num_refund = splitdata[0];
        var nombre_pax = $(this).parents("tr").find("td").eq(2).html();
        var monto_refund = $(this).parents("tr").find("td").eq(3).html();
        data = monto_refund.split('.');
        $('#num_refund').val(num_refund);
        $('#nombre_pax').val(nombre_pax);
        var monto = $.trim(data[1] + '.' + data[2]);
        $('#monto_refund').val(monto);
        $('#num_id').val(num_id);

    });

    $("body").on("click", ".btn_save", function () {
        var num_item = $(this).val();
        var fec_prog = $('#datemask_' + num_item).val();
        var status = $('#status_' + num_item).val();

//       var data = $(this).parents("tr").find("td").eq(6).html();
        var num_refund = $(this).attr('id');
        var status_current = $(this).parents("tr").find("td").eq(5).text();
        $(this).parents("tr").attr('id')

        $.ajax({
            type: "POST",
            url: '/siststar/refund/prog_refund/programar_refund',
            data: 'fec_prog=' + fec_prog + '&status=' + status + '&num_refund=' + num_refund + '&status_current=' + status_current,
            success: function (data)
            {
//                console.log(data);
                window.location.href = "/siststar/refund/prog_refund";
            }
        });

    });



    $("body").on("click", ".btn_edit", function () {
//    $('.btn_edit').click(function () {
        var num_item = $(this).val();
        $('#status_' + num_item).prop('disabled', false);
        $('.status_refund_select').show();
//        $('.status_current').hide();
        $('li').attr("type", "square");
        $('#datemask_' + num_item).prop('disabled', false);
    });
//    $('#bloque_add_ticket').hide();
    $("body").on("click", "#btn_add_tkt", function () {
        $('#bloque_add_ticket').css("display", "block")
    });
    $('#txt_ticket_ingresado').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    var contador = 0;
    var elem_ing = [];
    $('#add').click(function () {
        tkt_ingresado = $('#txt_ticket_ingresado').val();
        $(".html_tickets_add").append($("<div class='direct-chat-text text-center' id='elemento_ing_"+contador+"'>" + tkt_ingresado + "</div>)"));
        elem_ing[contador] = $.trim($('.html_tickets_add').text());
        
        contador++;
        if(contador){
            $('#add').css("display", "block");
        }
    });
    $('.btn-save').click(function(){
        console.log(elem_ing);
    })

});

