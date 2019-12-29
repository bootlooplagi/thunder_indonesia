var URL = $('#BASE_URL').val();
var TYPE = $('#type_pos').val();
// alert('');
var files;
$(function(){
    reset_form('#add-customer');
    $('#add-customer').on('hidden.bs.modal', function (e) {
        $(this).find('input[name=username]').removeAttr('readonly').attr('required','');
        $(this).find('input[name=password]').removeAttr('readonly').attr('required','');

        $('.pr').css('display','none');
        $('.pr div input').prop('required',false);
        $('.pr div input').val('');
    });

    $('#tblCustomer').DataTable();



    

    // Add events
    

    
    
});

// Grab the files and set them to our variable
function prepareUpload(event){
    //console.log(event);
  files = event.target.files;
  uploadFiles(event);
}

function asdw() {
	alert();
}

function select_rule(x) {

    $(x).popover({
        html: true,
        content: function() {

            $('#pop_select_rule').find('.id_pem').val($(x).val());
            return $('#pop_select_rule').html();
        }
    });

    $(x).popover('toggle');
}

function v_form(x){

    $('.pr').css('display','none');
    $('.pr div input').prop('required',false);

    if($('#id_customer').val()==''){
        $('.pr div input').val('');
    }


    if(x=='Karyawan'){
        $('.v_username').css('display','inline');
            $('#u_username').prop('required',true);
        $('.v_nama').css('display','inline');
            $('#u_nama').prop('required',true);
        $('.v_email').css('display','inline');
            $('#u_email').prop('required',true);
        $('.v_group').css('display','inline');
            $('#u_group').prop('required',true);
        $('.v_lantai').css('display','inline');
            $('#u_lantai').prop('required',true);
        //$('.v_department').css('display','inline').prop('required',true);
    }else{
        $('.v_username').css('display','inline');
            $('#u_username').prop('required',true);
        //$('.v_password').css('display','inline');
            //$('#u_password').prop({'required':true,'disabled':false}).val('12345678');
        //$('.v_password').css('display','inline').prop('required',true);
        $('.v_nama').css('display','inline');
        $('#u_nama').prop('required',true);

        $('.v_group').css('display','inline');
        $('#u_group').prop('required',true);
        //$('.v_jabatan').css('display','inline').prop('required',true);
        //$('.v_department').css('display','inline').prop('required',true);
    }
}

$('#frm-customer').on('submit',function(event){
    
    if(form_validate($('#frm-customer'))){
        if(v_username($('#frm-customer').find('input[name=username]').val())==true){
            if($('#id_customer').val()==''){
                startloading('Sedang mengirim data registrasi...');
                $.post(URL +   'customer/add', $(this).serialize(), function(data, textStatus, xhr) {
                    endloading();
                    if(data=='duplicate'){
                        $.alert({
                            title:'Warning',
                            content:'Duplicate Username/Email',
                            buttons:{
                                ok:function(){
                                    //window.location.replace(URL+'customer/view');
                                }
                            }
                        });
                    }else{
                        if(data=='success'){
                            $.alert({
                                content:'Sukses Input Data',
                                buttons:{
                                    ok:function(){
                                        window.location.replace(URL+'customer/view');
                                    }
                                }
                            });
                        }else {
							if (data == 'error') {
								$.alert({
									content: 'Error Input Data',
									buttons: {
										ok: function () {
											window.location.replace(URL + 'customer/view');
										}
									}
								});
							}
						}

                    }
                });
            }else{
                startloading('Sedang mengirim data registrasi...');
                $.post(URL +   'customer/edit', $(this).serialize(), function(data, textStatus, xhr) {
                    endloading();
                    if(textStatus=='success'){
                        $.alert({
                            content:'Sukses Update Data',
                            buttons:{
                                ok:function(){
                                    window.location.replace(URL+'customer/view');
                                }
                            }
                        });
                    }
                });
            }
        }else{
            $.alert({
                title:'Warning',
                content:'Username hanya boleh menggunakan huruf dan angka',
            });
            endloading();
        }

    }
    
    event.preventDefault();
});

function del(id,type=null){

    $.confirm({
        title: 'Confirmation!',
        content: 'Delete data?',
        buttons: {
            confirm: function () {
                startloading('Menghapus user...');
                $.ajax({
                    url: URL + 'customer/delete',
                    type : "post",

                    data:{id:id},
                    error: function(result){
                        endloading();
                        $.alert('Error saat menghapus user.');
                    },
                    success: function(result) {
                        endloading();
                        if(result=='success'){
                            $.alert({
                                title:'Sukses',
                                content:'Sukses menghapus Data',
                                buttons:{
                                    ok:function(){
                                        if(type=='user'){
                                            window.location = URL + 'customer/view';
                                        }
                                        if(type=='customer'){
                                            window.location = URL + 'customer/view_customer';
                                        }
                                    }
                                }
                            })
                        }
                    }
                });
            },
            cancel: function () {
            }
        }
    });
}
function activate(id){
    $.confirm({
        title: 'Confirmation!',
        content: 'Activate User?',
        buttons: {
            confirm: function () {
                startloading('Mengaktivasi user...');
                $.ajax({
                    url: URL + 'customer/activate',
                    type : "post",
                    data:{id:id},
                    error: function(result){
                        endloading();
                    },
                    success: function(result) {
                        endloading();
                        if(result=='success'){
                            $.alert({
                                title:'Sukses',
                                content:'Sukses megaktivasi User',
                                buttons:{
                                    ok:function(){
                                        window.location = URL + 'customer/view';
                                    }
                                }
                            })
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
    var v = el.val().split('|');
    $('#id_customer').val(v[0]);
    $('#u_nama').val(v[2]);
    $('#u_username').val(v[1]);

    $('#u_username').removeAttr('required').attr('readonly','');
    $('#u_password').removeAttr('required').attr({
        placeholder: 'Only Change Password',
        readonly: ''
    });
    $('#u_privilege').val(v[4]);
    $('#u_no_peg').val(v[5]);
    $('#u_department').val(v[6]);
    $('#u_jabatan').val(v[7]);
    $('#u_email').val(v[8]);
    $('#u_group').val(v[9]);
    $('#u_lantai').val(v[10]);


    if(v[4]=='Karyawan'){
        $('.v_username').css('display','inline');
            $('#u_username').prop('required',true);
        $('.v_nama').css('display','inline');
            $('#u_nama').prop('required',true);
        $('.v_email').css('display','inline');
            $('#u_email').prop('required',true);
        $('.v_group').css('display','inline');
            $('#u_group').prop('required',true);
        $('.v_lantai').css('display','inline');
            $('#u_lantai').prop('required',true);
        //$('.v_department').css('display','inline').prop('required',true);
    }else{
        $('.v_username').css('display','inline');
            $('#u_username').prop('required',true);
        //$('.v_password').css('display','inline');
            //$('#u_password').prop({'required':true,'disabled':false}).val('12345678');
        //$('.v_password').css('display','inline').prop('required',true);
        $('.v_nama').css('display','inline');
        $('#u_nama').prop('required',true);
        $('.v_group').css('display','inline');
        $('#u_group').prop('required',true);
        //$('.v_jabatan').css('display','inline').prop('required',true);
        //$('.v_department').css('display','inline').prop('required',true);
    }

    $('#add-customer').modal('show');
}






//CUSTOMER #####################################
function add_customer(){
    $.confirm({
        title:'Add Customer',
        content: ``+
                `<form class="formName">
                    <div class="form-group">
                        <label>Nama Customer</label>
                        <input class="name form-control" id="cust_name" placeholder="Masukkan Nama" type="text" name="cust_nama" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat Customer</label>
                        <input class="name form-control" id="cust_alamat" placeholder="Masukkan Alamat" type="text" name="cust_alamat" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input class="name form-control" id="cust_email" placeholder="Masukkan Email" type="text" name="cust_email" required>
                        
                    </div>

                    <!--
                    <div class="form-group">
                        <label>Nama Perusahaan</label>
                        <input class="name form-control" id="cust_k_nama_perusahaan" placeholder="Masukkan Nama Perusahaan" type="text" name="cust_k_nama_perusahaan" required>
                        
                    </div>
                    -->

                    <div class="form-group">
                        <label>Kategori Perusahaan</label>
                        <input class="name form-control" id="cust_k_kategori_perusahaan" placeholder="Masukkan Kategori Perusahaan" type="text" name="cust_k_kategori_perusahaan" required>
                        
                    </div>

                    <!--
                    <div class="form-group">
                        <label>PIC Perusahaan</label>
                        <input class="name form-control" id="cust_k_pic_perusahaan" placeholder="Masukkan PIC Perusahaan" type="text" name="cust_k_pic_perusahaan" required>
                        
                    </div>
                    -->
                    

                    <div class="form-group">
                        <label>Nomor Telp Kantor</label>
                        <input class="name form-control" id="cust_k_no_telp_kantor" placeholder="Masukkan No Telp Kantor" type="text" name="cust_k_no_telp_kantor" required>
                        
                    </div>
                    <div class="form-group">
                        <label>Fax</label>
                        <input class="name form-control" id="cust_k_fax" placeholder="Masukkan Fax" type="text" name="cust_k_fax" required>
                        
                    </div>
                    <div class="form-group">
                        <label>File Attachment</label>
                        <p id="file_uploaded_add" style="font-weight:bold; color:blue;"></p>
                        <input onchange="prepareUpload(event)" class="name form-control" id="cust_k_attach" type="file" name="cust_k_attach" required>
                        <input id="cust_k_attach_hide" type="hidden" name="cust_k_attach_hide" required>
                        
                    </div>
                    <div class="form-group">
                        <label>Nama PIC</label>
                        <input class="name form-control" id="cust_k_nama_pic" placeholder="Masukkan Nama PIC" type="text" name="cust_k_nama_pic" required>
                        
                    </div>
                    <div class="form-group">
                        <label>Telp PIC</label>
                        <input class="name form-control" id="cust_k_no_telp_pic" placeholder="Masukkan No Telp PIC" type="text" name="cust_k_no_telp_pic" required>
                        
                    </div>
                    <div class="form-group">
                        <label>Remark</label>
                        <textarea class="name form-control" id="cust_k_remark" placeholder="Masukkan Remark" type="text" name="cust_k_remark" required></textarea>
                        
                    </div>
                </form>
                `,
        buttons:{
            ok:{
                text:'OKE',
                action:function(){
                    startloading('Sedang mengirim data...');
                    var name = this.$content.find('input[name=cust_nama]').val();
                    var alamat = this.$content.find('input[name=cust_alamat]').val();
                    var email = this.$content.find('input[name=cust_email]').val();
                    var nama_perusahaan = this.$content.find('input[name=cust_k_nama_perusahaan]').val();
                    var kategori_perusahaan = this.$content.find('input[name=cust_k_kategori_perusahaan]').val();
                    var pic_perusahaan = this.$content.find('input[name=cust_k_pic_perusahaan]').val();
                    var no_telp_kantor = this.$content.find('input[name=cust_k_no_telp_kantor]').val();
                    var fax = this.$content.find('input[name=cust_k_fax]').val();
                    var attachment = this.$content.find('input[name=cust_k_attach_hide]').val();
                    var nama_pic = this.$content.find('input[name=cust_k_nama_pic]').val();
                    var no_telp_pic = this.$content.find('input[name=cust_k_no_telp_pic]').val();
                    var remark = this.$content.find('textarea[name=cust_k_remark]').val();
                    //var post_send = {};

                    $.post(URL+'customer/add_customer',{
                                                        name:name,
                                                        address:alamat,
                                                        email:email,
                                                        nama_perusahaan:nama_perusahaan,
                                                        kategori_perusahaan:kategori_perusahaan,
                                                        pic_perusahaan:pic_perusahaan,
                                                        no_telp_kantor:no_telp_kantor,
                                                        fax:fax,
                                                        attachment:attachment,
                                                        nama_pic:nama_pic,
                                                        no_telp_pic:no_telp_pic,
                                                        remark:remark
                                                    }).done(function(data){
                                                        endloading();
                                                        var res = JSON.parse(data);
                                                        $.alert({
                                                            title:'',
                                                            content:res.message,
                                                            buttons:{
                                                                ok:function(){
                                                                    window.location = URL + 'customer/view_customer';
                                                                }
                                                            }
                                                        });
                                                    });
                }
            },
            close:{
                text:'CLOSE'
            }
        }
    });
}

function edit_customer(
                        e_name=null,
                        e_address=null,
                        e_email=null,
                        e_id_user=null,
                        e_nama_perusahaan=null,
                        e_kategori_perusahaan=null,
                        e_pic_perusahaan=null,
                        e_no_telp_kantor=null,
                        e_fax=null,
                        e_attachment=null,
                        e_nama_pic=null,
                        e_no_telp_pic=null,
                        e_remark=null

                        ){
    var display = 'none';
    var filename = '<a href="'+URL+'assets/customer_attach/'+e_attachment+'">File : '+e_attachment+'</a><a href="#" onclick="del_att()" style="color:red;"> X</a>';
    if(e_attachment==''||e_attachment==null){
        display = 'block';
        filename = '';
    }
    
    $.confirm({
        title:'Edit Customer',
        content: ``+
                `<form class="formName">
                    <div class="form-group">
                        <label>Nama Customer</label>
                        <input class="name form-control" id="cust_name" placeholder="Masukkan Nama" type="text" name="cust_nama" value="`+e_name+`" required>
                        
                    </div>

                    <div class="form-group">
                        <label>Alamat Customer</label>
                        <input class="name form-control" id="cust_alamat" placeholder="Masukkan Alamat" type="text" name="cust_alamat" value="`+e_address+`" required>
                        
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input class="name form-control" id="cust_email" placeholder="Masukkan Email" type="text" name="cust_email" value="`+e_email+`" required>
                        
                    </div>

                    <!--
                    <div class="form-group">
                        <label>Nama Perusahaan</label>
                        <input class="name form-control" id="cust_k_nama_perusahaan" placeholder="Masukkan Nama Perusahaan" type="text" name="cust_k_nama_perusahaan" value="`+e_nama_perusahaan+`" required>
                        
                    </div>
                    -->

                    <div class="form-group">
                        <label>Kategori Perusahaan</label>
                        <input class="name form-control" id="cust_k_kategori_perusahaan" placeholder="Masukkan Kategori Perusahaan" type="text" name="cust_k_kategori_perusahaan" value="`+e_kategori_perusahaan+`" required>
                        
                    </div>

                    <!--
                    <div class="form-group">
                        <label>PIC Perusahaan</label>
                        <input class="name form-control" id="cust_k_pic_perusahaan" placeholder="Masukkan PIC Perusahaan" type="text" name="cust_k_pic_perusahaan" value="`+e_pic_perusahaan+`" required>
                        
                    </div>
                    -->

                    <div class="form-group">
                        <label>Nomor Telp Kantor</label>
                        <input class="name form-control" id="cust_k_no_telp_kantor" placeholder="Masukkan No Telp Kantor" type="text" name="cust_k_no_telp_kantor" value="`+e_no_telp_kantor+`" required>
                        
                    </div>
                    <div class="form-group">
                        <label>Fax</label>
                        <input class="name form-control" id="cust_k_fax" placeholder="Masukkan Fax" type="text" name="cust_k_fax" value="`+e_fax+`" required>
                        
                    </div>
                    <div class="form-group">
                        <label>File Attachment</label>
                        <p id="file_uploaded_add" style="font-weight:bold; color:blue;">`+filename+`</p>
                        <input onchange="prepareUpload(event)" style="display:`+display+`;" class="name form-control" id="cust_k_attach" type="file" name="cust_k_attach" required>
                        <input id="cust_k_attach_hide" type="hidden" name="cust_k_attach_hide" value="`+e_attachment+`" required>
                        
                    </div>
                    <div class="form-group">
                        <label>Nama PIC</label>
                        <input class="name form-control" id="cust_k_nama_pic" placeholder="Masukkan Nama PIC" type="text" name="cust_k_nama_pic" value="`+e_nama_pic+`" required>
                        
                    </div>
                    <div class="form-group">
                        <label>Telp PIC</label>
                        <input class="name form-control" id="cust_k_no_telp_pic" placeholder="Masukkan No Telp PIC" type="text" name="cust_k_no_telp_pic" value="`+e_no_telp_pic+`" required>
                        
                    </div>
                    <div class="form-group">
                        <label>Remark</label>
                        <textarea class="name form-control" id="cust_k_remark" placeholder="Masukkan Remark" type="text" name="cust_k_remark" required>`+e_remark+`</textarea>
                        
                    </div>
                </form>
                `,
        buttons:{
            ok:{
                text:'OKE',
                action:function(){
                    startloading('Sedang Mengirim Data...');
                    var name = this.$content.find('input[name=cust_nama]').val();
                    var alamat = this.$content.find('input[name=cust_alamat]').val();
                    var email = this.$content.find('input[name=cust_email]').val();
                    var nama_perusahaan = this.$content.find('input[name=cust_k_nama_perusahaan]').val();
                    var kategori_perusahaan = this.$content.find('input[name=cust_k_kategori_perusahaan]').val();
                    var pic_perusahaan = this.$content.find('input[name=cust_k_pic_perusahaan]').val();
                    var no_telp_kantor = this.$content.find('input[name=cust_k_no_telp_kantor]').val();
                    var fax = this.$content.find('input[name=cust_k_fax]').val();
                    var attachment = this.$content.find('input[name=cust_k_attach_hide]').val();
                    var nama_pic = this.$content.find('input[name=cust_k_nama_pic]').val();
                    var no_telp_pic = this.$content.find('input[name=cust_k_no_telp_pic]').val();
                    var remark = this.$content.find('textarea[name=cust_k_remark]').val();
                    //var post_send = {};

                    $.post(URL+'customer/edit_customer',{
                                                            name:name,
                                                            address:alamat,
                                                            email:email,
                                                            id:e_id_user,
                                                            nama_perusahaan:nama_perusahaan,
                                                            kategori_perusahaan:kategori_perusahaan,
                                                            pic_perusahaan:pic_perusahaan,
                                                            no_telp_kantor:no_telp_kantor,
                                                            fax:fax,
                                                            attachment:attachment,
                                                            nama_pic:nama_pic,
                                                            no_telp_pic:no_telp_pic,
                                                            remark:remark
                                                        }).done(function(data){
                                                            endloading();
                                                            var res = JSON.parse(data);
                                                            $.alert({
                                                                title:'',
                                                                content:res.message,
                                                                buttons:{
                                                                    ok:function(){
                                                                        window.location = URL + 'customer/view_customer';
                                                                    }
                                                                }
                                                            });
                                                        });
                }
            },
            close:{
                text:'CLOSE'
            }
        }
    });
}





function uploadFiles(event)
{

    var number_file = new Date().getTime();
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    // START A LOADING SPINNER HERE
    startloading('Sedang mengupload file...');

    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });

    $.ajax({
        url: URL+'upload/upload_attach?files&number='+ number_file,
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            endloading();
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                // submitForm(event, data);
                $('#file_uploaded_add').html('<a href="'+URL+'assets/customer_attach/'+data.message+'">File : '+data.message+'</a><a href="#" onclick="del_att()" style="color:red;"> X</a>');
                $('#cust_k_attach').val('').hide();
                $('#cust_k_attach_hide').val(data.message).hide();

                if(data.status==1){
                   $.alert({
                        title:'Sukses',
                        content:'File : ' + data.message + ' telah terupload.',
                        buttons:{
                            ok:function(){
                                
                            }
                        }
                    }); 
                }else{
                    $.alert({
                        title:'Error',
                        content:'File : ' + data.message + ' gagal di upload.',
                        buttons:{
                            ok:function(){
                                
                            }
                        }
                    });
                }
                
                // successUpload();

            }
            else
            {
                // Handle errors here
                endloading();
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            $.alert({
                title:'Error',
                content:'File gagal di upload.',
                buttons:{
                    ok:function(){
                        $('#cust_k_attach').val('');
                        $('#cust_k_attach_hide').val('');
                    }
                }
            });
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
            endloading();
        }
    });
}

function del_att(){
    $('#file_uploaded_add').html('');
    $('#cust_k_attach').show();
}