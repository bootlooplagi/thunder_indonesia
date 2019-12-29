var tmpItem = [];
var item_pj = [];
var qtyItem = [];
var del_item_paket = [];
var indexFind = 0;
var st_btn_add = true;

$(document).ready(function(){
	
	$('#tb_paket').DataTable();
	//$('#item_select').prop('selectedIndex',0);
	$.each($('#item_select option'), function(index, val) {
			var v = $(this).val().split('|');
			tmpItem.push(v[1]);
			qtyItem.push(v[3]);
	});

	$('#modal_view_paket').on('hidden.bs.modal', function () {
	    $('.btn-sh_peng').prop('disabled',false);
	    $('.tmpCol').remove();
	});

	$('#modal_view_paket').on('shown.bs.modal', function () {
	    $('#bc_item').focus();
	});




	$("#bc").on("keydown paste cut", function() {
	   setTimeout(function(){
	   		if($('#bc').val().length>0){
				$.each(tmpItem, function(index, val) {
					 if(tmpItem[index]==$("#bc").val()){
					 	setTimeout(function(){
					 	$('#item_select').prop('selectedIndex',index).select2({containerCssClass : "select2-act",width:'100%'});
					 	},20);
					 	if($('#auto_enter').is(':checked')==true){

						 	$('#qty').val(1);
						 	add_item();
					 	}else{
					 		$('#qty').focus();
					 		setTimeout(function(){
					 			$('#btn_add').prop('disabled',false);
					 			st_btn_add = true;
					 		},10);
					 		
					 	}// $('#item_select').select2();
					 }else{
					 	
					 	$('#btn_add').prop('disabled','disabled');
					 	st_btn_add = false;
					 	$('#item_select').prop('selectedIndex',0).select2();

					 }
				});
	   		}else{
	   			$('#btn_add').prop('disabled',false);
	   			st_btn_add = true;
	   		}
		},10);
	});

	$("#bc").focus(function() {
		$("#bc").val('');
		$("#btn_add").prop('disabled',false);
		st_btn_add = true;
	});
});

function autoenter(x){
	setTimeout(function(){
		if(x.is(':checked')){
			$('#bc').attr('onpaste','on_paste($(this).val())');
			$('#qty').prop('disabled',true);
			$('#btn_add').prop('disabled',true);
			$('#bc').focus().val('');
		}else{
			$('#bc').removeAttr('onpaste');
			$('#qty').prop('disabled',false);
			$('#btn_add').prop('disabled',false);
			st_btn_add = true;
			$('#bc').focus().val('');
		}
	},10);
	
	
}

function on_paste(x){
	   	setTimeout(function(){
			$.each(tmpItem, function(index, val) {
				 if(tmpItem[index]==$("#bc").val()){
				 	$('#qty').focus();
				 	$('#item_select').prop('selectedIndex',index).select2({containerCssClass : "select2-act",width:'100%'});
				 	$('#qty').val('1');
					add_item();
				 }
			});
	});
}
function sh_paket(x,y=null,z=null){
	if(z!=null){
		z.prop('disabled',true);	
	}
	
	item_pj=[];
	try{
		$('#tb_item_paket').find('thead tr th:eq(5)').remove();
	}catch(e){
	}finally{
		startloading('Mengambil data...');
		itVerifikasi = [];
		$.post(URL + 'transaksi/paket_view', {id: x}).done(function(data) {
			endloading();
			if(data.length!=0){
				var res = $.parseJSON(data);
				itVerifikasi = $.parseJSON(data);
				$('.nama_paket').html(res[0].nama_paket);
				$('.no_paket').html(res[0].no_paket);
				$('.tgl_paket').html(res[0].tgl_paket);

				$('#tb_item_paket').find('tbody');
				var td = $('#tb_item_paket').find('tbody');
				td.html('');
				var no=1;

				if(y=='verifikasi'){
					$('.verifikasi').load(URL + 'transaksi/verifikasi/' + x,function(){
						$(this).show();

					});
				}else{
					$('.verifikasi').html('');
				}

				$('#tb_item_paket').find('thead tr').append('<th>Item Masuk</th>');
				if(y=='verifikasi'){
					$('#tb_item_paket').find('thead tr').append('<th class="tmpCol">Action</th>');
				}
				
				$('#id_paket_penerimaan').val(res[0].id);


				$.each(res,function(index, el) {
					item_pj.push(res[index].barcode);
					if(y=='verifikasi'){
						td.append(`
									<tr>
										<input type="hidden" class="id_it_pn" value="`+res[index].id_it_pn+`">
										<input type="hidden" class="id_item" value="`+ res[index].id_item +`">
										<td>`+ no +`</td>
										<td>`+ res[index].barcode +`</td>
										<td>`+ res[index].item_name +`</td>
										<td>`+ res[index].h_stock +`</td>
										<td>`+ res[index].qty +`</td>
										<td class="jml_it">`+ res[index].qty_masuk +`</td>
										<td class="tmpCol"><button type="button" onclick="clear_it(`+res[index].id_it_pn+`,$(this))" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Clear Item">
	                                                  <span class="glyphicon glyphicon-refresh"></span>
	                                                </button></td>
									</tr>

							`);
						
						$('#modal_view_paket').find('.modal-footer').html(`
								<button type="button" onclick="verifikasi_penerimaan()" class="bg-green btn btn-default">OK</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>`);
					}else{
						td.append(`
									<tr>
										<input type="hidden" class="id_it_pn" value="`+res[index].id_it_pn+`">
										<input type="hidden" class="id_item" value="`+ res[index].id_item +`">
										<td>`+ no +`</td>
										<td>`+ res[index].barcode +`</td>
										<td>`+ res[index].item_name +`</td>
										<td>`+ res[index].h_stock +`</td>
										<td>`+ res[index].qty +`</td>
										<td class="jml_it">`+ res[index].qty_masuk +`</td>
									</tr>

							`);
					}
					if(res[index].qty==res[index].qty_masuk){
						$('#tb_item_paket').find('tbody tr:eq('+ index +')').addClass('IComplete bg-green');

					}
					no++;
				});
				$('#modal_view_paket').modal('show');

			}else{
				$.alert('Tidak ada Item / data tidak ditemukan');
			}
		}).fail(function(){
			endloading();
			$.alert('Error saat mengambil data.');
		});	
	}	
}

function add_item(){
	var valid = validate('req-add-item');

	if(valid && $('#qty').val()>=1){
		var match = false;
		if($('#item_select').val()!=null){
			var item_val = $('#item_select').val().split('|');
			var indexIt = $('#item_select').prop('selectedIndex');

			
			var qty = $('#qty').val();

			try{
				$.each($('#tb_item_paket').find('tbody tr'), function(index, val) {
					var barcode = $('#tb_item_paket').find('tbody tr:eq('+ index +') td:eq(1)').html();
					if(item_val[1]==barcode){
						match=true;
						var jml = $('#tb_item_paket').find('tbody tr:eq('+ index +') td:eq(5)').html();
						var h_satuan = clear_f_cur($('#tb_item_paket').find('tbody tr:eq('+ index +') td:eq(4)').html());
						//alert(h_satuan +'>'+jml+'>'+qty);
						$('#tb_item_paket').find('tbody tr:eq('+ index +') td:eq(5)').html(parseInt(jml)+parseInt(qty));
						$('#tb_item_paket').find('tbody tr:eq('+ index +') td:eq(6)').html(f_cur(parseInt(h_satuan)*(parseInt(jml)+parseInt(qty))));
					}
				});
			}catch(e){

			}finally{
				
				var cItem = $('#tb_item_paket').find('tbody tr').length -1;
				//no = parseInt($('#tb_item_paket').find('tbody tr:eq('+cItem+') td:eq(0)').html());

				
				
				if(match==false){
					//var qty_ttl = $('#tb_item_paket').find('tbody tr td:eq(4)').html();
				 	$('#tb_item_paket').find('tbody').append(`
						<tr>
							<input type="hidden" class="id_item" value="`+ item_val[0] +`">
							<input type="hidden" class="id_it_paket">
							<td class="no_item"></td>
							<td>`+ item_val[1] +`</td>
							<td>`+ item_val[2] +`</td>
							<td>`+ item_val[3] +`</td>
							<td>`+ f_cur(item_val[4]) +`</td>
							<td>`+ qty +`</td>
							<td>`+ f_cur((parseInt(qty)*parseInt(item_val[4]))) +`</td>
							
							<td>
								<button onclick="del_item($(this))" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
									<span class="glyphicon glyphicon-trash"></span>
								</button>
							</td>
						</tr>
					`);

					$.each($('#tb_item_paket').find('tbody tr'), function(index, val) {
						 $('#tb_item_paket').find('tbody tr:eq('+index+') td:eq(0)').html(index+1);
					});
				}
				$('#bc').focus().val('');
				$('#qty').val('');
				$('#item_select').prop('selectedIndex',0).select2();
			}
			
		}else{
			$.alert('Anda belum memilih Item.');
			return false;

		}
		
	}
}

function ck_it(){
	
	setTimeout(function(){
		$('#qty_item').attr('readonly','').val('');
		var bc = $('#bc_item').val();

		$.each(item_pj, function(index, val) {
			var jml = $('#tb_item_paket').find('tbody tr:eq('+ index +') td:eq(4)').html();
			 if(bc==item_pj[index]){
			 	$('#s_item').prop('selectedIndex',index+1);
			 	$('#qty_item').removeAttr('readonly').focus();
			 	indexFind=index;
			 }else{

			 }
		});
	},10);
	
}

function change_it(x){
	var dt_it = x.val().split('|');
	$('#bc_item').val(dt_it[1]);
	$('#qty_item').prop('readonly',false);
	$('#qty_item').focus();
	indexFind = x.prop('selectedIndex') -1;

}

function add_count(){
	//alert($('#item_select').val());
	var match = false;
	//var item_val = $('#item_select').val().split('|');
	var qty = $('#qty').val();

	try{
		$('#tb_item_paket').find('tbody tr:eq('+ index +') td:eq(4)').html(parseInt(jml)+parseInt(1));
	}catch(e){
		alert(e);
	}finally{

	}
}

function del_item(x){
	x.parent().parent().remove();
	$.each($('#tb_item_paket').find('tbody tr'), function(index, val) {
		$('#tb_item_paket').find('tbody tr:eq('+index+') td:eq(0)').html(index+1);
	});
}

function submit(x){
	var tmpIt = [];
	var itemSuccess = [];
	var itemError = [];

	$.each($('#tb_item_paket tbody tr'), function(index, val) {
			tmpIt.push({
				barcode:val.getElementsByTagName('td')[1].innerHTML,
				name:parseInt(val.getElementsByTagName('td')[2].innerHTML),
				stock:parseInt(val.getElementsByTagName('td')[3].innerHTML),
				item_price:parseInt(val.getElementsByTagName('td')[4].innerHTML),
				item_qty:parseInt(val.getElementsByTagName('td')[5].innerHTML)
			});

			var stock = parseInt(val.getElementsByTagName('td')[3].innerHTML);
			var item_price = parseInt(val.getElementsByTagName('td')[4].innerHTML);
			var item_qty = parseInt(val.getElementsByTagName('td')[5].innerHTML);

			itemSuccess.push({
				barcode:val.getElementsByTagName('td')[1].innerHTML,
				name:val.getElementsByTagName('td')[2].innerHTML,
				stock:parseInt(val.getElementsByTagName('td')[3].innerHTML),
				item_price:parseInt(val.getElementsByTagName('td')[4].innerHTML),
				item_qty:parseInt(val.getElementsByTagName('td')[5].innerHTML)
			});

	});

	let submit_paket = function(){
		var valid = validate('req-submit');
		var cTableItem = $('#tb_item_paket').find('tbody tr').length;
		if(cTableItem==0){
			$.alert('Isikan minimal 1 item');
		}
		if(valid && cTableItem>0){
			var id = '';
			var nama = $('#nama_paket').val();
			var harga = $('#harga_paket').val();
			var deskripsi = $('#deskripsi_paket').val();
			var nomor = $('#no_paket').html();
			var items = [];
			try{
				$.each($('.id_item'), function(index, val) {
					var id_i = $('.id_item').eq(index).val();
					var id_ip = $('.id_it_paket').eq(index).val();
					var item_price = $('.id_item').eq(index).parent().find('td:eq(4)').html();
					var item_qty = $('.id_item').eq(index).parent().find('td:eq(5)').html();
					var item_h_stock = $('.id_item').eq(index).parent().find('td:eq(3)').html();

					items.push({
						'id':id_ip,
						'id_item':id_i,
						'item_price':clear_f_cur(item_price),
						'item_qty':item_qty,
						'item_h_stock':item_h_stock
					});
				});
			}catch(e){

			}finally{
				if(x=='edit'){
					id=$('.id_paket').val();
				}
				startloading('Mengirim data...');
				
				$.post(URL + 'produk/paket_item/submit', {mode:x,id:id,no_paket:nomor,nama:nama,harga:clear_f_cur(harga),deskripsi:deskripsi,item:items,del:del_item_paket}).done(function(data, textStatus, xhr) {
					endloading();
					if(textStatus=='success'){
						$.alert({
							title:'Success',
							content:'Sukses menambah data',
							buttons:{
								ok:function(){
									window.location.replace(URL + 'produk/paket_item/view');
								}
							}
						});
						
					}
				}).fail(function(){
					endloading();
					$.alert('Error saat pengambilan data.');
				});
			}
		}				
	}

	if(tmpIt<1){
		$.alert('Item Kosong');
	}else{
		if(tmpIt.length==itemSuccess.length){
			submit_paket();
		}
	}

	//########################   BATAS UPDATE

}


function del_ip(x,el){
	$.confirm({
		title:'Hapus item',
		content:'Anda yakin ingin menghapus item ini?',
		buttons:{
			confirm: function(){
				// startloading('Menghapus item..');
				
				// $.post(URL + 'transaksi/del_it_paket', {id:x}).done(function(data, textStatus, xhr) {
				// 	endloading();
				// 	el.parent().parent().remove();
				// }).fail(function(){
				// 	endloading();
				// 	$.alert('Error saat menghapus item.');
				// });
				del_item_paket.push({
										'id':x,
										'is_delete':1
									});
				el.parent().parent().remove();
			},
			cancel: function(){

			}
		}
	});
}

function del_paket(x,el){
	$.confirm({
		title:'Hapus item',
		content:'Anda yakin ingin menghapus item ini?',
		buttons:{
			confirm: function(){
				startloading('Menghapus data paket..');
				$.post(URL + 'produk/paket_item/delete', {id:x}).done(function(data, textStatus, xhr) {
					endloading();
					//el.DataTable().row( $(this).parents('tr') ).remove().draw();
					el.parent().parent().remove();

				}).fail(function(){
					endloading();
					$.alert('Error saat menghapus item.');
				});
			},
			cancel: function(){

			}
		}
	});
}

function reject_paket(x){
	startloading('Mengirim data...');
	$.post(URL + 'transaksi/reject_paket', {id:x}).done(function(data, textStatus, xhr) {
		endloading();
		if(textStatus=='success'){
			$.alert({
				title:'Success',
				content:'Berhasil menolak paket',
				buttons:{
					ok:function(){
						window.location.replace(URL + 'transaksi/trx/view');
					}
				}
			});
			
		}else{
			$.alert({
				title:'Warning',
				content:'Error mengubah data \n' + textStatus,
				buttons:{
					ok:function(){
						window.location.replace(URL + 'transaksi/trx/view');
					}
				}
			});
		}
	}).fail(function(){
		endloading();
		$.alert('Error saat menolak paket');
	});
}

function accept_paket(x){
	startloading('Mengirim data...');
	$.post(URL + 'transaksi/accept_paket', {id:x}).done(function(data, textStatus, xhr) {
		endloading();
		if(textStatus=='success'){
			$.alert({
				title:'Success',
				content:'Berhasil menerima paket.',
				buttons:{
					ok:function(){
						window.location.replace(URL + 'transaksi/trx/view');
					}
				}
			});
			
		}else{
			$.alert({
				title:'Warning',
				content:'Error mengubah data \n' + textStatus,
				buttons:{
					ok:function(){
						window.location.replace(URL + 'transaksi/trx/view');
					}
				}
			});
		}
	}).fail(function(){
		endloading();
		$.alert('Error saat menerima paket.');
	});
}

function validate(x){
	var valid = $(":input["+x+"]").length;
	var focus = [];
	try{
		$.each($(":input["+x+"]"), function(index, val) {
			if($(":input["+x+"]:eq("+index+")").val()==''){
				 $(this).attr('data-original-title','Form masih Kosong');
				 $(this).tooltip('show');
				 $(this).removeAttr('data-original-title');
				 focus.push($(this));
			}else{
				valid--;
			}
		});
	}catch(e){

	}finally{
		if(valid==0){
			return true;
		}else{
			focus[0].focus();
			return false;

		}
	}
}

function cItem(x){
	// setTimeout(function(){
	// 	$.each(tmpItem, function(index, val) {
	// 		 if(tmpItem[index]==x.val()){
	// 		 	$('#qty').focus();
	// 		 	$('#item_select').prop('selectedIndex',index).select2({containerCssClass : "select2-act",width:'100%'});
			 	
	// 		 }
	// 	});
	// },10);
}

function enter(event){
	var cek = 0;
	var x = event.which || event.keyCode;
	if(x==13){
		//$('#qty').val('1');
		//add_item();
		if(st_btn_add){
			add_item();
		}else{
			$.alert('Tidak ditemukan Item dengan Barcode Tersebut.');
		}
	}	
}

function enter_it(event=null){
	if(event!=null){
		var x = event.which || event.keyCode;
	}
	var jml = $('#tb_item_paket').find('tbody tr:eq('+ indexFind +') td:eq(5)').html();
	var jmlAsli = $('#tb_item_paket').find('tbody tr:eq('+ indexFind +') td:eq(4)').html();
	var qty = $('#qty_item').val();
	if((x==13||x==null) && (qty>0)){
		if(parseInt(jml)<parseInt(jmlAsli)){
			try{
				if((parseInt(qty)+parseInt(jml))<=parseInt(jmlAsli)){
					$('#tb_item_paket').find('tbody tr:eq('+ indexFind +') td:eq(5)').html(parseInt(jml)+parseInt(qty));
					$('#qty_item').val('').focus();

					var tmpJml = $('#tb_item_paket').find('tbody tr:eq('+ indexFind +') td:eq(5)').html();
					var getID = $('#tb_item_paket').find('tbody tr:eq('+ indexFind +') input[type=hidden].id_it_pn').val();
					var getIDItem = $('#tb_item_paket').find('tbody tr:eq('+ indexFind +') input[type=hidden].id_item').val();
					postStatusPenerimaan(indexFind,getID,tmpJml,getIDItem,qty);


					
				}else{
					$.alert({
						title:'Warning!',
						content:'Jumlah Qty melebihi jumlah paket'
					});
				}
			}catch(e){

			}finally{
				var j1 = jmlAsli;
				var j2 = $('#tb_item_paket').find('tbody tr:eq('+ indexFind +') td:eq(5)').html();
				ck_completeItem=[];

				if(parseInt(j1)==parseInt(j2)){

					$('#tb_item_paket').find('tbody tr:eq('+ indexFind +')').addClass('IComplete bg-green');

				}
			}
		}else{
			$.alert({
				title:'Item Cukup',
				content:'Item sudah lengkap'
			});
		}
	}
}

var itVerifikasi = [];
function postStatusPenerimaan(id_rw,id,jml,id_item,qty){
	itVerifikasi[id_rw].qty_masuk = parseInt(itVerifikasi[id_rw].qty_masuk) + parseInt(qty);
}

function clear_it(id,x){
	var id_arr = x.parent().parent().index();
	itVerifikasi[id_arr].qty_masuk = 0;
	x.parent().parent().find('td.jml_it').html(0);
	$('#tb_item_paket').find('tbody tr:eq('+ id_arr +')').removeClass('IComplete bg-green');
}

function verifikasi_penerimaan(){
	startloading('Memverifikasi penerimaan...');
	$.post(URL + 'transaksi/verifikasi_penerimaan', {items:itVerifikasi}).done(function(data, textStatus, xhr) {
		endloading();
		var res = JSON.parse(data);
		$.confirm({
			title:'',
			content:res.message,
			buttons:{
				ok:function(){
					window.location.replace(URL + 'transaksi/trx/view_penerimaan');
				}
			}

		});
				
		
	}).fail(function(){
		endloading();
		$.alert('Error saat mengirim data verifikasi.');
	});
}

function verifikasiPenerimaan(id){
	startloading('Memverifikasi penerimaan...');
	$.post(URL + 'transaksi/update_stat_penerimaan', {id:id}).done(function(data, textStatus, xhr) {
		endloading();
		$.confirm({
			title:'Pesan Sukses',
			content:'Status Telah Terverifikasi',
			buttons:{
				ok:function(){
					window.location.replace(URL + 'transaksi/trx/view_penerimaan');
				}
			}

		});
				
		
	}).fail(function(){
		endloading();
		$.alert('Error saat mengirim data verifikasi.');
	});
}

function ch_select(x){
	var v = x.split("|");
	$('#bc').val(v[1]); 
	setTimeout(function(){
		$('#qty').focus();
		$('#btn_add').prop('disabled',false);
		st_btn_add = true;
	},100);
}


