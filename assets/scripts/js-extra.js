var URL = $('#BASE_URL').val();
var TYPE = $('#type_pos').val();

$(function(){
    $('#tb_extra_charge').DataTable();
    //alert('');
});

function del(id){
    $.confirm({
        title: 'Confirmation!',
        content: 'Delete data?',
        buttons: {
            confirm: function () {   
                startloading('Menghapus kategori..');             
                $.post(URL + 'transaksi/extra_charge_del',{id:id}).done(function(data){   
                    endloading();
                    var res = JSON.parse(data);
                    $.alert({
                        title:'',
                        content:res.message,
                        buttons:{
                            ok:{
                                text:"OK",
                                action:function(){
                                    window.location = URL + 'transaksi/extra_charge_view';
                                }
                            }
                        }
                    });
                }).fail(function(e){
                    $.alert(e.message);
                }); 
            }           
        }
    });
}

function edit(el,id){

}

function ae(mode=null,data=null,btnACT=null,txtACT=null){

    if(mode=='add'){
        var dt = [];
        dt[0]='';
        dt[1]='';
        dt[2]='';
        dt[3]='';
    }
    if(mode=='edit'){
        var dt = data.split('|');
    }
    //dt = data.split('|');

    $.confirm({
        title:'Tambah Extra Charge',
        content:''+
                '<form action="" class="formService">' +
                    '<div class="form-group">' +
                        '<label>CODE</label>' +
                        '<input type="text" placeholder="Masukkan Kode/Level" name="code" class="code form-control" value="'+dt[1]+'" required />' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label>CHARGE</label>' +
                        '<input type="text" placeholder="Masukkan Charge (%)" name="charge" class="datetimepicker charge form-control" value="'+dt[2]+'" required />' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label>DESCRIPTION</label><br>' +
                        '<textarea placeholder="Deskripsi" name="description" style="width:100%">'+dt[3]+'</textarea>' +
                    '</div>' +
                '</form>',
        buttons:{
            close:{
                text:'Close'
            },
            save:{
                text:txtACT,
                btnClass:btnACT,
                action:function(){
                    var form = this.$content.find('form input,form textarea,form select');
                    var datas = [{}];

                    form.each(function(index,val){
                        datas[0][$(val).attr('name')] = $(val).val();
                    });

                    $.post(URL + 'transaksi/extra_charge/'+mode,{id:dt[0],data:datas}).done(function(data){
                        var res = JSON.parse(data);
                        if(res.status=='1'){
                            $.alert({
                                title:'',
                                content:res.message,
                                buttons:{
                                    ok:{
                                        text:"OK",
                                        action:function(){
                                            window.location = URL + 'transaksi/extra_charge_view';
                                        }
                                    }
                                }
                            });
                        }else{
                            $.alert(res.message);
                        }
                    }).fail(function(e){
                        $.alert(e.message);
                    });         
                }
            }
        }
    });
}