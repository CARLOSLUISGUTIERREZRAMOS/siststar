$(function(){
    
    $('#tbl_users').dataTable();
    
    $("#btnAccEstado").click(function(){
            
        $(this).removeClass('btn btn-danger');
        $(this).addClass('btn btn-success');
        
    });
    
});