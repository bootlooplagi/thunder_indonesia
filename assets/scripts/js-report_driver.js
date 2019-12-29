$(function () {
    $('#date_year').datetimepicker({
        viewMode: 'months',
        format: 'YYYY'
    });
});

function getReportDriver(x){
    var inp = x.parents().eq(2);

    var id_kurir = inp.find('select[name="sel_driver"]').val();
    var month = inp.find('select[name="sel_bulan"]').val();
    var year = inp.find('input[name="sel_date"]').val();

    if(id_kurir==null){
        $.alert('Anda belum memilih kurir.');
        return false;
    }
    if(month==null){
        $.alert('Anda belum memilih bulan.');
        return false;
    }



    startloading('Mohon tunggu...');
    $.post(URL+'report/tb_driver',{id_kurir:id_kurir,month:month,year:year}).done(function(response){
        endloading();
        $('#list_report_driver').html(response);
        $('.table-report').DataTable();        
    }).fail(function(){
        endloading();
    });
}