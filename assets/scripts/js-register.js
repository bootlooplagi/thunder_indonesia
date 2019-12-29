$(function(){
    $('#frm_reg').submit(false);
    $('#submit-reg').on('click',function(){
        var frm = $(this).parents().find('form');
        var input = frm.find('input').toArray();
        var count = frm.find('input').length;
        var null_count = 0;
        //console.log(input);
        //var a = ["a","b","c"];
        var Run_A = new Promise(function(resolve, reject) {
            resolve();
        });

        Run_A.then(function(v){
            input.forEach(function(it,i){
                var itm = frm.find('input:eq('+ i +')');
                if(itm.val().trim()==''){
                    itm.css({"color": "red", "border": "2px solid red"});
                    itm.val('');
                    null_count++;
                }else{
                    itm.css({"color": "", "border": ""});
                }
            });
        }).then(function(){
            if(null_count>0){
                $.confirm({
                    icon: 'glyphicon glyphicon-warning-sign',
                    title:'Ooops!',
                    content:'Mohon untuk mengisi semua field',
                    theme: 'modern',
                    type:'red'
                });
            }else{
                submit_reg();
            }
        });  
    });

    $('input').on('focus',function(){
        $(this).css({"color": "", "border": ""});
    });

});



function submit_reg(){
    
    //console.log(frm);

    //alert($('input[name=username]').val());
    startloading('Mohon Tunggu');

    var t_reg = setTimeout(function(){
        //alert('--1--');
        //endloading();
        reg.abort();


        var t_reg_ulang = setTimeout(function(){
            endloading();
            reg_ulang.abort();
        },10000);

        //startloading('Mohon tunggu. Sedang memverifikasi ulang..');
        var reg_ulang = $.ajax({
            url:URL + 'user/submit_register/verifikasi_ulang',
            type:'POST',
            data:{
                    
                    username:$('input[name=username]').val(),
                    name:$('input[name=name]').val(),
                    email:$('input[name=email]').val(),
                    group:$('input[name=group]').val(),
                    lantai:$('input[name=lantai]').val()
                },
            beforeSend:function(){
                startloading('Mohon tunggu. Sedang mengirim ulang..');
                t_reg_ulang;
            },
            success:function(data){
                clearTimeout(t_reg_ulang);
                var res = JSON.parse(data);
                var message = res.message;
                var status = res.status;
                if(status=='1'){
                    endloading();
                    $.confirm({
                        title:'Sukses!',
                        content:'Terimakasih <br>Pendaftaran Akun Karyawan berhasil<br>Username dan Password telah dikirim ke email anda<br>Silahkan cek email anda.',
                        buttons:{
                            ok:{
                                text:'OK',
                                action:function(){
                                    window.location = URL;
                                }
                            }
                        }
                    });
                }else{
                    endloading();
                    $.alert({
                        title:'Warning!',
                        content:message
                    });
                }
            },error:function(jqXHR,exception){
                endloading();
                clearTimeout(t_reg_ulang);
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Tidak terhubung.\n Cek koneksi anda.';
                } else if (jqXHR.status == 404) {
                    msg = 'Halaman tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                reg_ulang.abort();
                $.alert({
                    title:'Warning!',
                    content:msg
                });
            }
        })
    },15000);

    var reg = $.ajax({
        url:URL + 'user/submit_register',
        type:'POST',
        data:{
                username:$('input[name=username]').val(),
                name:$('input[name=name]').val(),
                email:$('input[name=email]').val(),
                group:$('input[name=group]').val(),
                lantai:$('input[name=lantai]').val()
            },
        beforeSend:function(){
            t_reg;
        },
        success:function(data){
            clearTimeout(t_reg);
            var res = JSON.parse(data);
            var message = res.message;
            var status = res.status;

            if(status=='1'){
                endloading();
                $.confirm({
                    title:'Sukses!',
                    content:'Terimakasih <br>Pendaftaran Akun Karyawan berhasil<br>Username dan Password telah dikirim ke email anda<br>Silahkan cek email anda.',
                    buttons:{
                        ok:{
                            text:'OK',
                            action:function(){
                                window.location = URL;
                            }
                        }
                    }
                });
            }else{
                endloading();
                $.alert({
                    title:'Warning!',
                    content:message
                });
            }
        },error:function(jqXHR, exception){
            //alert('--2--');
            //
            reg.abort();
            clearTimeout(t_reg);
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            endloading();
            $.alert({
                title:'Warning!',
                content:msg
            });
        }

    });
}