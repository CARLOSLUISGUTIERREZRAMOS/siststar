$(function () {

    $('.item_selected_nimportancia').click(function () {
        var data = $(this).attr('id');
        $('#num_ticket').val(data);
//        $("#select_nimp").change(function(){
//            $('#ticket_hidden').val(data);
//        })
    })
    var userdest = $('.select2').select2();
    $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    "format": "DD/MM/YYYY",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ]
                },

                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                var starDate = start.format('MMMM D, YYYY');
                var endDate = end.format('MMMM D, YYYY');
                var StarFormatSendPost = start.format('D-M-YYYY');
                var EndFormatSendPost = end.format('D-M-YYYY');
                $('#daterange-btn span').html(starDate + ' - ' + endDate)
                $('#fecha_daterange').val(StarFormatSendPost+'|'+EndFormatSendPost);
            }
    )
   
//    $('#datepicker').datepicker({
//        autoclose: true
//    })

});