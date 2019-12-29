$(function(){
	$('.select2').select2();

	$('#tb_service').DataTable();

});

function ae_service(mode=null,data){
	
	var item = $('#items').html();

	if(mode=='edit'){
		var dt = data.val().split('|');
		var btnACT = 'bg-yellow';
		var txtACT = 'Update';
		var titlePrompt = 'Edit Service Barang';
		var disabled = 'disabled';
	}else{
		if(mode=='add'){
			var dt = [];
			for(var i=0; i<8; i++){
				dt[i] = '';
			}
		}
		var btnACT = 'bg-green';
		var txtACT = 'Submit';
		var titlePrompt = '+ Service Barang';
		var disabled = '';
	}
	

	$.confirm({
		title:titlePrompt,
		content:''+
				'<link rel="stylesheet" href="'+ URL +'assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">'+
  				'<script src="'+ URL +'assets/plugins/moment/min/moment.min.js"></script>'+
  				'<script src="'+ URL +'assets/plugins/moment/locale/id.js"></script>'+
  				'<script src="'+ URL +'assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>'+
				`
				<style>
					.dropdown-select2-style{
						z-index:999999999999;
					}
				</style>
				` +
				'<form action="" class="formService">' +
					'<div class="form-group">' +
					    '<label>Nama Produk</label>' +
				    	`<select class="form-control select2" name="id_item" `+disabled+`>`+
				    		item +
				    	`</select>`+
				    '</div>' +
				    `<script>
				    		$('select[name=id_item]').val(`+dt[1]+`);
				    		$('.select2').select2();
				    </script>`+
				    '<div class="form-group">' +
					    '<label>Nama Vendor Service</label>' +
					    '<input type="text" placeholder="Nama Vendor" name="nama_vendor" class="nama_vendor form-control" value="'+dt[2]+'" required />' +
				    '</div>' +
				    '<div class="form-group">' +
					    '<label>Tanggal Service</label>' +
					    '<input type="text" placeholder="Tanggal Service" name="tanggal_service" class="datetimepicker tanggal_service form-control" value="'+dt[3]+'" required />' +
				    '</div>' +
				    '<div class="form-group">' +
					    '<label>Estimasi Selesai</label>' +
					    '<input type="text" placeholder="Estimasi Selesai" name="estimasi_selesai" class="datetimepicker estimasi_selesai form-control" value="'+dt[4]+'" required />' +
				    '</div>' +
				    '<div class="form-group">' +
					    '<label>Detail Service</label><br>' +
					    '<textarea name="detail_service" style="width:100%">'+dt[5]+'</textarea>' +
				    '</div>' +
				    '<div class="form-group">' +
					    `<a href="#" onclick="list_sn()">List Serial Number Barang</a>`+
				    '</div>' +
			    '</form>' + 

			    `<script>
				    $(function(){`+
						`	$('.datetimepicker').datetimepicker({locale:'id',format: 'YYYY-MM-DD HH:mm:ss'});
							$('.select2').select2({dropdownCssClass:"dropdown-select2-style"});
							`+
					`});
				</script>
				<style>
			    	.jconfirm .jconfirm-box div.jconfirm-content-pane.no-scroll{overflow:unset;}
			    	.jconfirm .jconfirm-box{
			    		overflow:visible;
			    	}
			    </style>`,
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

					$.post('service/'+mode,{id:dt[0],data:datas}).done(function(data){
						var res = JSON.parse(data);
						if(res.status=='1'){
							$.alert({
								title:'',
								content:res.message,
								buttons:{
									ok:{
										text:"OK",
										action:function(){
											window.location = URL + 'service';
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

function del(id){
	$.confirm({
		title:'Hapus service?',
		content:`Anda yakin ingin menghapus data Service Barang?`,
		buttons:{
			close:{
				text:'Close'
			},
			save:{
				text:'Delete',
				btnClass:'bg-red',
				action:function(){
					$.post('service/delete',{id:id}).done(function(data){
						var res = JSON.parse(data);
						if(res.status=='1'){
							$.alert({
								title:'',
								content:res.message,
								buttons:{
									ok:{
										text:"OK",
										action:function(){
											window.location = URL + 'service';
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

function status_done(id,jml,id_it){
	$.confirm({
		title:'Ubah Status service ke "Selesai"?',
		content:`Apakah barang sudah selesai di Service?`,
		buttons:{
			close:{
				text:'Close'
			},
			save:{
				text:'SELESAI',
				btnClass:'bg-green',
				action:function(){
					$.post('service/done',{id:id,jml_barang:jml,id_item:id_it}).done(function(data){
						var res = JSON.parse(data);
						if(res.status=='1'){
							$.alert({
								title:'',
								content:res.message,
								buttons:{
									ok:{
										text:"OK",
										action:function(){
											window.location = URL + 'service';
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


function list_sn(){
	$.alert('');
}

function add_prod(x,mode){
	var prod = '';
	$.each(produk,function(index,item){
		prod+=`<option value=`+item.id+`>`+item.name+`</option>`;
	});
	var html = `<a class="list-group-item clearfix item_list anim from_client">
                  <div class="col-lg-4 clearfix">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <select class="form-control produk_barang" name="id_item">
                              `+prod+`
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <input type="text" name="serial_number" class="form-control" placeholder="Input Serial Number">
                        </div>
                    </div>
                  </div>

                  <div class="col-lg-7 clearfix">
                    <div class="row">
                      <div class="col-lg-12 form-group">
                          <textarea name="remark" rows="3" class="form-control" placeholder="Input Keterangan"></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-1 clearfix">
                    <div class="row">
                      <div class="col-lg-12 form-group">
                          <button class="btn btn-danger btn-lg btn-block" onclick="del_item($(this),'`+mode+`')"><span class="fa fa-trash"></span></button>
                      </div>
                    </div>
                  </div>
                </a>`;
    var added = x.parent().parent().find('div#list-barang');
    added.prepend(html);
    added.find('.anim').css({
    	backgroundColor:"green"
    }).animate({
    	backgroundColor: ""
    },500,function(){
    	added.find('.anim').removeAttr('style');
    	added.find('.anim').removeClass('anim');
    });

    $('.produk_barang').select2();
}

function submit_services(){
	var frmInput = $('#detail_service').find('input').toArray();
	var frmSelect = $('#detail_service').find('select').toArray();
	var detail = {};

	var frmItemList = $('#list-barang').find('.item_list.from_client').toArray();
	
	var items = [];

	frmInput.forEach(function(item,index){
		let i = $('#detail_service').find('input').eq(index);
		let name = i.attr('name');
		let value = i.val();

		detail[name] = value;
	});

	frmSelect.forEach(function(item,index){
		let i = $('#detail_service').find('select').eq(index);
		let name = i.attr('name');
		let value = i.val();

		detail[name] = value;
	});

	frmItemList.forEach(function(item,index){
		let frmItemID = $('.item_list.from_client').eq(index).find('select[name="id_item"]');
		let frmSN = $('.item_list.from_client').eq(index).find('input[name="serial_number"]');
		let frmRemark = $('.item_list.from_client').eq(index).find('textarea[name="remark"]');

		items.push({
			id_item:frmItemID.val(),
			serial_number:frmSN.val(),
			remark:frmRemark.val()
		});
	});

	let data = {detail:detail,items:items};


	if(frmItemList.length>0){
		$.confirm({
			title:"Simpan data",
			content:"Apakah anda yakin ingin menyimpan data service?",
			buttons:{
				save:{
					text:"Simpan",
					btnClass:"btn-blue",
					action:function(){
						startloading('Mohon tunggu...');
						$.post(URL+'service/submit_service',data).done(function(response){
							endloading();
							var res = JSON.parse(response);
							if(res.status==1){
								$.alert({
									title:"Sukses!",
									content:res.message,
									buttons:{
										ok:{
											text:"OKE",
											btnClass:"bg-blue",
											action:function(){
												location.href = URL+'service';
											}
										}
									}
								});
							}
						}).fail();
					}
				},close:{
					text:"Batal"				
				}
			}
		});
	}else{
		$.alert('Item produk masih kosong');
	}
}

function del_item(x,mode,acc=null){
	if(mode=='add'){
		x.parents().eq(3).remove();
	}

	if(mode=='edit'){
		if(acc=='acc'){
			$.alert({
				title:"Service selesai?",
				content:"Apakah service sudah selesai?",
				columnClass:"col-lg-7 col-lg-offset-3",
				buttons:{
					delete:{
						text:"Hapus",
						btnClass:"bg-black",
						action:function(){
							x.parents().eq(3).addClass('hapus').addClass('del')
							.removeClass('ada')
							.removeClass('done')
							.removeClass('fail');


						}
					},selesai:{
						text:"Ya, Sudah selesai!",
						btnClass:"bg-green",
						action:function(){
							x.parents().eq(3).addClass('done').removeClass('fail').removeClass('del');
							x.parents().eq(3).find('.status_it').html('Done').css('color','blue');
							x.attr("disabled","disabled");
						}
					},tidak:{
						text:"Tidak, gagal diservice!",
						btnClass:"bg-red",
						action:function(){
							x.parents().eq(3).addClass('fail').removeClass('done').removeClass('del');
							x.parents().eq(3).find('.status_it').html('Fail').css('color','red');
						}
					},close:{
						text:"Close",
						action:function(){
							
						}
					}
				}
			});
		}
	}
}

function submit_edit_services(id_service=null){
	var frmInput = $('#detail_service').find('input').toArray();
	var frmSelect = $('#detail_service').find('select').toArray();
	var detail = {};

	var frmItemList = $('#list-barang').find('.item_list.from_client').toArray();
	var frmItemListServer = $('#list-barang').find('.item_list.from_server.ada').toArray();
	var frmDeleted = $('#list-barang').find('.item_list.from_server.hapus.del').toArray();
	var frmDone = $('#list-barang').find('.item_list.from_server.done').toArray();
	var frmFail = $('#list-barang').find('.item_list.from_server.fail').toArray();

	
	var items = [];
	var itemsServer = [];
	var itemsDeleted = [];
	var itemsDone = [];
	var itemsFail = [];

	frmInput.forEach(function(item,index){
		let i = $('#detail_service').find('input').eq(index);
		let name = i.attr('name');
		let value = i.val();

		detail[name] = value;
	});

	frmSelect.forEach(function(item,index){
		let i = $('#detail_service').find('select').eq(index);
		let name = i.attr('name');
		let value = i.val();

		detail[name] = value;
	});

	frmItemList.forEach(function(item,index){
		let frmItemID = $('.item_list.from_client').eq(index).find('select[name="id_item"]');
		let frmSN = $('.item_list.from_client').eq(index).find('input[name="serial_number"]');
		let frmRemark = $('.item_list.from_client').eq(index).find('textarea[name="remark"]');

		items.push({
			id_item:frmItemID.val(),
			serial_number:frmSN.val(),
			remark:frmRemark.val()
		});
	});

	frmItemListServer.forEach(function(item,index){
		let frmIDProduk = $('.item_list.from_server.ada').eq(index).find('input[name="id"]');
		// let frmItemID = $('.item_list.from_server.ada').eq(index).find('select[name="id_item"]');
		let frmSN = $('.item_list.from_server.ada').eq(index).find('input[name="serial_number"]');
		let frmRemark = $('.item_list.from_server.ada').eq(index).find('textarea[name="remark"]');

		itemsServer.push({
			id:frmIDProduk.val(),
			// id_item:frmItemID.val(),
			serial_number:frmSN.val(),
			remark:frmRemark.val()
		});
	});

	frmDeleted.forEach(function(item,index){
		let frmIDProduk = $('.item_list.from_server.hapus.del').eq(index).find('input[name="id"]');
		let frmItemID = $('.item_list.from_server.hapus.del').eq(index).find('select[name="id_item"]');
		// let frmSN = $('.item_list.from_server.hapus.del').eq(index).find('input[name="serial_number"]');
		// let frmRemark = $('.item_list.from_server.hapus.del').eq(index).find('textarea[name="remark"]');

		itemsDeleted.push({
			id:frmIDProduk.val(),
			id_item:frmItemID.val()
			// serial_number:frmSN.val(),
			// remark:frmRemark.val()
		});
	});

	frmDone.forEach(function(item,index){
		let frmIDProduk = $('.item_list.from_server.done').eq(index).find('input[name="id"]');
		let frmItemID = $('.item_list.from_server.done').eq(index).find('select[name="id_item"]');
		// let frmSN = $('.item_list.from_server.hapus.del').eq(index).find('input[name="serial_number"]');
		// let frmRemark = $('.item_list.from_server.hapus.del').eq(index).find('textarea[name="remark"]');

		itemsDone.push({
			id:frmIDProduk.val(),
			id_item:frmItemID.val()
			// serial_number:frmSN.val(),
			// remark:frmRemark.val()
		});
	});

	frmFail.forEach(function(item,index){
		let frmIDProduk = $('.item_list.from_server.fail').eq(index).find('input[name="id"]');
		let frmItemID = $('.item_list.from_server.fail').eq(index).find('select[name="id_item"]');
		// let frmSN = $('.item_list.from_server.hapus.del').eq(index).find('input[name="serial_number"]');
		// let frmRemark = $('.item_list.from_server.hapus.del').eq(index).find('textarea[name="remark"]');

		itemsFail.push({
			id:frmIDProduk.val(),
			id_item:frmItemID.val()
			// serial_number:frmSN.val(),
			// remark:frmRemark.val()
		});
	});

	let data = {
		id_service:id_service,
		detail:detail,
		items:items,
		itemsserver:itemsServer,
		itemsdeleted:itemsDeleted,
		itemsdone:itemsDone,
		itemsfail:itemsFail
	}



	if(frmFail.length>0 || frmItemList.length>0 || frmItemListServer.length>0 || frmDone.length>0){
		$.confirm({
			title:"Simpan data",
			content:"Apakah anda yakin ingin menyimpan data service?",
			buttons:{
				save:{
					text:"Simpan",
					btnClass:"btn-blue",
					action:function(){
						startloading('Mohon tunggu...');
						$.post(URL+'service/submit_edit_service',data).done(function(response){
							endloading();
							var res = JSON.parse(response);
							if(res.status==1){
								$.alert({
									title:"Sukses!",
									content:res.message,
									buttons:{
										ok:{
											text:"OKE",
											btnClass:"bg-blue",
											action:function(){
												location.href = URL+'service';
											}
										}
									}
								});
							}
						}).fail();
					}
				},close:{
					text:"Batal"				
				}
			}
		});
	}else{
		$.alert('Item produk masih kosong');
	}
	
}

function add_vendor(){
	$.confirm({
		title:"Add Vendor",
		content:$('#add_vendor').html(),
		buttons:{
			submit:{
				text:"<span class='fa fa-plus'></span> Tambah Vendor",
				btnClass:"btn-primary",
				action:function(){
					
					var x = this;
					let data = {};
					var is_null = 0;

					let frmInput = x.$content.find('input').toArray();
					frmInput.forEach(function(item,index){
						let inp = x.$content.find('input').eq(index);
						let name = inp.attr('name');
						let value = inp.val();

						if(value==''){
							inp.stop();
							inp.css("background-color","red").animate({
								backgroundColor:""
							},500);
							is_null++;
						}

						data[name] = value;
					});

					let frmTextarea = x.$content.find('textarea').toArray();
					frmTextarea.forEach(function(item,index){
						let inp = x.$content.find('textarea').eq(index);
						let name = inp.attr('name');
						let value = inp.val();

						if(value==''){
							inp.stop();
							inp.css("background-color","red").animate({
								backgroundColor:""
							},500);
							is_null++;
						}

						data[name] = value;
					});

					if(is_null==0){
						startloading('Mohon tunggu...');
						$.post(URL+'service/add_vendor',{data:data}).done(function(response){
							endloading();
							var res = JSON.parse(response);
							$.alert({
								title:"Message",
								content:res.message
							});
						}).fail(function(){
							endloading();
							$.alert('Gagal menambahkan Vendor');
						});
					}else{
						endloading();
						return false;
					}
				}
			},close:{
				text:"Close"				
			}
		}
	});
}