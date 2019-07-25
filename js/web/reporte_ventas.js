$(function () {
	$('.input-daterange').datepicker({
	    todayBtn: "linked",
	    language: "es",
	    autoclose: true,
	    todayHighlight: true
	});
	var y=new Date();
    var today=devuelveDia(y.getDate())+'/'+devuelveMes(y.getMonth())+'/'+y.getFullYear();
    if ($("input[name=desde]").val()=='') {
    	$("input[name=desde]").datepicker('update',today);
    }
    if ($("input[name=hasta]").val()=='') {
    	$("input[name=hasta]").datepicker('update',today);
    }

    $('#tbl_reportes').DataTable({
        'paging': true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        'ordering': false,
        'info': true,
        'autoWidth': false,
        'order': []
    });
});

function devuelveMes(mes) {
	var m=mes+1;
	m.toString();
	if (m.length==1) {
		m='0'+m;
	}
	return m;
}

function devuelveDia(dia) {
	var d=dia.toString();
	if (d.length==1) {
		d='0'+d;
	}
	return d;
}