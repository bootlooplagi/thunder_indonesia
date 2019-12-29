var URL = $('#BASE_URL').val();
var TYPE = $('#type_pos').val();

function del(id){
    $.confirm({
        title: 'Confirmation!',
        content: 'Delete data?',
        buttons: {
            confirm: function () {   
                startloading('Menghapus kategori..');             
                $.ajax({ 
                    url: URL + 'produk/kategori/del', 
                    type : "post",      
                    dataType : "json",                                               
                    data:{id:id},
                    error: function(result){   
                        endloading();                 
                        console.log(result.responseText);
                        $.alert('Server Error: delete failed');
                        return false;
                    },
                    success: function(result) {  
                        endloading();
                    	console.log(result);                                                                    
                        if(result.status=='success'){
                            
                            window.location = URL + 'produk/kategori/view';
                        }else{
                            $.alert(result.message);
                        }                       
                    }
                }); 
            },
            cancel: function () {               
            }            
        }
    });
}

function edit(el,id){
    var dt = el.val().split(',');
    var md = $('#add-kategori');
    md.find('#id_kat').val(id);
    md.find('#code').val(dt[0]);
    md.find('#name_txt').val(dt[1]);
    md.modal('show');
}


$(document).ready(function() {
    var t = $("#tblKategoriRestaurant").DataTable();
    $('#add-kategori').on('hidden.bs.modal', function (e) {
      $(this)
        .find("input,textarea,select")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();
    })
 
    $('#save').on( 'click', function () {
        var code = $('#code').val();
        var nama = $('#name_txt').val();

        if($('#add-kategori').find('#id_kat').val()==''){
            startloading('Menambah kategori...');
            $.ajax({ 
                url: URL + 'produk/kategori/add', 
                type : "post",                                                  
                data:{mode:'add',code:code,nama:nama},
                success: function(result) {  
                    endloading();

                    try{
                        var res = $.parseJSON(result);  
                        var cRow = $('.cKat').val();
                        if(res.status_add==1){
                            t.row.add( [
                                cRow,
                                res.code,
                                res.description,
                                res.update_by_username,
                                res.update_date,
                                `<button class="btn btn-warning" onclick="edit($(this),`+res.id+`)" value="`+res.code+`,`+res.description+`"><span class="glyphicon glyphicon-edit"></span></button>
                                        <button class="btn btn-danger" onclick="del(`+res.id+`)"><span class="glyphicon glyphicon-trash"></span></button>`
                            ] ).draw( false ); 
                            $('.cKat').val(parseInt(cRow) + 1);
                            $('#add-kategori').modal('hide');
                            $.alert({
                                title:'Pesan Sukses',
                                content:'Sukses menambahkan data Kategori.'
                            });
                        }else{
                            $.alert({
                                title:'Pesan Error',
                                content:res.message
                            });
                        }
                    }catch(e){
                        $.alert({
                            title:'Pesan Error',
                            content:'Error menambahkan data Kategori. Err Code : (652734)'
                        });
                    }

                },
                error: function(result){     
                    endloading();               
                    alert('error');
                }
                
            });
        }else{
            var id_kat = $('#add-kategori').find('#id_kat').val();
            startloading('Mengubah kategori...');
            $.ajax({ 
                url: URL + 'produk/kategori/edit', 
                type : "post",  
                dataType:"json",
                data:{mode:'edit',id:id_kat,code:code,nama:nama},
                success: function(result) {
                    endloading();
                    try {
                        if(result.status_edit==1){
                            $.alert({
                                title:'Pesan Sukses',
                                content:result.message,
                                buttons:{
                                    ok:{
                                        text:'OK',
                                        action:function(){
                                            window.location = URL + 'produk/kategori/view';
                                        }
                                    }
                                }
                            });
                        }else{
                            $.alert({
                                title:'Pesan Error',
                                content:'Error mengubah data. Err Code : 768234'
                            });
                        }
                    } catch(e) {
                        // statements
                        $.alert({
                            title:'Pesan Error',
                            content:'Error mengubah data. Err Code : 768234'
                        });
                    }
                    
                    
                },error:function(e){
                    endloading();
                }
            });
        }
    } );
} );