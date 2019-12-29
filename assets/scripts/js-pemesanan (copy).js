var tmpItem = [];
var qtyItem = [];

var DataTableItem = $('#tb_item_pemesanan').DataTable({
				        responsive: {
				            details: {
				                type: 'column',
				                target: 'tr'
				            }
				        },
				        columnDefs: [ {
				            className: 'control',
				            orderable: false,
				            targets:   -1
				        } ],
				        order: [ 0, 'asc' ]
				    });
$(function() {
	// alert('');
	$('#tb_pemesanan').DataTable();
	

	$('#ch_stat').popover();

	$.each($('#item_select option'), function(index, val) {
			var v = $(this).val().split('|');
			tmpItem.push(v[1]);
			qtyItem.push(v[3]);
	});

	$("#bc").focus(function() {
		$("#bc").val('');
		$("#btn_add").prop('disabled',false);
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
});

var pemesanan_tb = $('#tb_pemesanan').DataTable();

function autoenter(){
	setTimeout(function(){
		if($('#auto_enter').is(':checked')==true){
			$('#qty').prop('disabled',true);
			$('#btn_add').prop('disabled',true);
			$('#bc').focus().val('');
		}else{
			$('#qty').prop('disabled',false);
			$('#btn_add').prop('disabled',false);
			$('#bc').focus().val('');
		}
	},10);
	
}

function enter(event) {
	var x = event.which || event.keyCode;
	if (x == 13) {
		//
		add_item();

	}
}

function add_item() {
	
	var valid = validate('req-add-item');

	if (valid && $('#qty').val() >= 1 ) {
		var match = false;
		if($('#item_select').val()!=null){
			
			var item_val = $('#item_select').val().split('|');
			var indexIt = $('#item_select').prop('selectedIndex');

			if(parseInt($('#qty').val())>item_val[3] && item_val[4]=='ITEM'){
				$.alert('Stock Item : ' + item_val[3] + '<br>Stock kurang dari jumlah permintaan.');
			}else{

					var qty = parseInt(($('#qty').val()=='')?'0':$('#qty').val());
					var disc = parseInt(($('#disc').val()=='')?'0':$('#disc').val());
					var extra_charge = parseInt(($('#extra').val()=='')?'0':$('#extra').val());
					var harga = parseInt(item_val[5]);
					var total = parseInt(parseInt(item_val[5])*qty);


					var net = parseInt((harga*qty)-((harga*qty)*(disc/100))+((harga*qty)*(extra_charge/100)));
					// alert(total);
					// alert('1');
					try {
						$.each($('#tb_item_pemesanan').find('tbody tr'), function(index, val) {

							var barcode = $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(1)').html();

							if (item_val[1] == barcode) {

								match = true;
								// var jml = $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(5)').html();
								var jml = DataTableItem.cell(index,5).data();
								
								// alert();
								// var harga_jual = clear_f_cur($('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(6)').html());
								var harga_jual = clear_f_cur(DataTableItem.cell(index,6).data());
								// alert(harga_jual);



								// $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(5)').html(parseInt(jml) + parseInt(qty));
								// $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(6)').html(f_cur(harga_jual));
								// $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(7)').html(f_cur((parseInt(jml)+qty) * parseInt(harga_jual)));
								// $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(8)').html(disc);
								// $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(9)').html(extra_charge);
								// var harga_total = (parseInt(jml)+qty) * parseInt(harga_jual);

								// $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(10)').html(f_cur(((parseInt(jml)+qty) * parseInt(harga_jual))-(harga_total*(disc/100))+(harga_total*(extra_charge/100))));
								DataTableItem.cell(index,5).data(parseInt(jml) + parseInt(qty)).draw(false);
								DataTableItem.cell(index,6).data(f_cur(harga_jual)).draw(false);
								DataTableItem.cell(index,7).data(f_cur((parseInt(jml)+qty) * parseInt(harga_jual))).draw(false);
								DataTableItem.cell(index,8).data(disc).draw(false);
								DataTableItem.cell(index,9).data(extra_charge).draw(false);
								var harga_total = (parseInt(jml)+qty) * parseInt(harga_jual);
								DataTableItem.cell(index,10).data(f_cur(((parseInt(jml)+qty) * parseInt(harga_jual))-(harga_total*(disc/100))+(harga_total*(extra_charge/100)))).draw(false);

							}

						});
					} catch (e) {
						console.log(e);
					} finally {

						var cItem = $('#tb_item_pemesanan').find('tbody tr').length - 1;
						//no = parseInt($('#tb_item_pemesanan').find('tbody tr:eq('+cItem+') td:eq(0)').html());



						if (match == false) {
							// // alert('2');
							// $('#tb_item_pemesanan').find('tbody').append(`
							// 			<tr>
							// 			<input type="hidden" class="id_item" value="` + item_val[0] + `">
							// 			<input type="hidden" class="id_it_pemesanan">
							// 			<td class="no_item"></td>
							// 			<td>` + item_val[1] + `</td>
							// 			<td>` + item_val[2] + `</td>
							// 			<td>` + item_val[4] + `</td>
							// 			<td>` + item_val[3] + `</td>
							// 			<td>` + qty + `</td>
							// 			<td>` + f_cur(harga) + `</td>
							// 			<td>` + f_cur(total) + `</td>
							// 			<td>` + disc + `</td>
							// 			<td>` + extra_charge + `</td>
							// 			<td>` + f_cur(net) + `</td>
							// 			<td>
							// 			<button onclick="del_item($(this))" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
							// 			<span class="glyphicon glyphicon-trash"></span>
							// 			</button>
							// 			</td>
							// 			</tr>
							// 			`);
							// $('#tb_item_pemesanan').DataTable();

							// DataTableItem.draw(false);
							// DataTableItem;
							// DataTableItem.row.node();
							DataTableItem.row.add([
													`<input type="hidden" class="id_item" value="` + item_val[0] + `">
													<input type="hidden" class="id_it_pemesanan">
													<p class="no_item"></p>`,
													item_val[1],
													item_val[2],
													item_val[4],
													item_val[3],
													qty,
													f_cur(harga),
													f_cur(total),
													disc,
													extra_charge,
													f_cur(net),
													`<button onclick="del_item($(this))" type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete">
														<span class="glyphicon glyphicon-trash"></span>
													</button>`,
													''
												]).draw(false);
							

							$.each($('#tb_item_pemesanan').find('tbody tr'), function(index, val) {
								$('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(0) p.no_item').html(index + 1);
							});
							//$('#qty').val('1');

						}
						$('#bc').focus().val('');
						$('#qty').val('');
						$('#item_select').prop('selectedIndex',0).select2();
					}
			}
		}else{
			$.alert('Anda belum memilih Item.');
			return false;

		}

	}

	// $('#tb_item_pemesanan').DataTable({
 //        responsive: {
 //            details: {
 //                type: 'column',
 //                target: 'tr'
 //            }
 //        },
 //        columnDefs: [ {
 //            className: 'control',
 //            orderable: false,
 //            targets:   -1
 //        } ],
 //        order: [ 0, 'asc' ]
 //    });
}



function validate(x) {
	var valid = $(":input[" + x + "]").length;
	var focus = [];
	try {
		$.each($(":input[" + x + "]"), function(index, val) {
			if ($(":input[" + x + "]:eq(" + index + ")").val() == '') {
				$(this).attr('data-original-title', 'Form masih Kosong');
				$(this).tooltip('show');
				$(this).removeAttr('data-original-title');
				focus.push($(this));
			} else {
				valid--;
			}
		});
	} catch (e) {

	} finally {
		if (valid == 0) {
			return true;
		} else {
			focus[0].focus();
			return false;

		}
	}
}


function submit(x,type=null) {
	var tmpIt = [];
	var itemSuccess = [];
	var itemError = [];

	$.each($('#tb_item_pemesanan tbody tr'), function(index, val) {
			tmpIt.push({
				barcode:val.getElementsByTagName('td')[1].innerHTML,
				name:parseInt(val.getElementsByTagName('td')[2].innerHTML),
				stock:parseInt(val.getElementsByTagName('td')[4].innerHTML),
				qty:parseInt(val.getElementsByTagName('td')[5].innerHTML),
				jenis_item:val.getElementsByTagName('td')[3].innerHTML,
				disc:parseInt(val.getElementsByTagName('td')[8].innerHTML),
				extra_charge:parseInt(val.getElementsByTagName('td')[9].innerHTML),
				sub:parseInt(val.getElementsByTagName('td')[6].innerHTML)
			});

			var stock = parseInt(val.getElementsByTagName('td')[4].innerHTML);
			var qty = parseInt(val.getElementsByTagName('td')[5].innerHTML);
			var jenis = parseInt(val.getElementsByTagName('td')[3].innerHTML);
			var disc = parseInt(val.getElementsByTagName('td')[8].innerHTML);
			var extra_charge = parseInt(val.getElementsByTagName('td')[9].innerHTML);
			var sub = parseInt(val.getElementsByTagName('td')[6].innerHTML);


			if(stock<qty && jenis=='ITEM'){
				itemError.push({
					barcode:val.getElementsByTagName('td')[1].innerHTML,
					name:val.getElementsByTagName('td')[2].innerHTML,
					stock:parseInt(val.getElementsByTagName('td')[4].innerHTML),
					qty:parseInt(val.getElementsByTagName('td')[5].innerHTML),
					jenis_item:val.getElementsByTagName('td')[3].innerHTML,
					disc:parseInt(val.getElementsByTagName('td')[8].innerHTML),
					extra_charge:parseInt(val.getElementsByTagName('td')[9].innerHTML),
					sub:parseInt(val.getElementsByTagName('td')[6].innerHTML)
				});
				$('#tb_item_pemesanan tbody tr:eq('+index+')').css({
					background:'#fd9c9c'
				});
			}else{
				itemSuccess.push({
					barcode:val.getElementsByTagName('td')[1].innerHTML,
					name:val.getElementsByTagName('td')[2].innerHTML,
					stock:parseInt(val.getElementsByTagName('td')[4].innerHTML),
					qty:parseInt(val.getElementsByTagName('td')[5].innerHTML),
					jenis_item:val.getElementsByTagName('td')[3].innerHTML,
					disc:parseInt(val.getElementsByTagName('td')[8].innerHTML),
					extra_charge:parseInt(val.getElementsByTagName('td')[9].innerHTML),
					sub:parseInt(val.getElementsByTagName('td')[6].innerHTML)
				});
			}
	});

	if(itemError.length>0){
		var msgErr ='<ul>';
		$.each(itemError,function(index,val){
			msgErr += '<li>Stock <b style="color:blue;">' + val.name + '('+ val.barcode +')</b> saat ini <b style="color:red;">kurang dari jumlah permintaan pemesanan.</b></li>';
		});
		msgErr += '</ul>';
		$.alert(msgErr);
	}else{
		let submit_pemesanan = function(){
			var valid = validate('req-submit');
			var cTableItem = $('#tb_item_pemesanan').find('tbody tr').length;
			if (cTableItem == 0) {
				$.alert('Isikan minimal 1 item');
			}
			if (valid && cTableItem > 0) {
				startloading('Mohon tunggu, sedang mengirim data...');
				var id = '';
				var id_cust = $('#list_customer').val();
				var duration = $('#duration').val();
				var nomor = $('#no_pemesanan').html();
				var items = [];
				try {
					$.each($('.id_item'), function(index, val) {

						var id_i = $('.id_item').eq(index).val();
						var id_ip = $('.id_it_pemesanan').eq(index).val();
						// var qty_i = $('.id_item').eq(index).parents('tbody tr').find('td:eq(5)').html();
						// var h_stock_i = $('.id_item').eq(index).parents('tbody tr').find('td:eq(4)').html();
						// var disc = $('.id_item').eq(index).parents('tbody tr').find('td:eq(8)').html();
						// var extra_charge = $('.id_item').eq(index).parents('tbody tr').find('td:eq(9)').html();
						// var sub = $('.id_item').eq(index).parents('tbody tr').find('td:eq(6)').html();

						var qty_i = DataTableItem.cell(index,5).data();
						var h_stock_i = DataTableItem.cell(index,4).data();
						var disc = DataTableItem.cell(index,8).data();
						var extra_charge = DataTableItem.cell(index,9).data();
						var sub = DataTableItem.cell(index,6).data();


						// alert(qty_i);
						// alert(id_i);
						// alert(id_ip);
						// alert(qty_i);
						// alert(h_stock_i);
						// alert(disc);
						// alert(extra_charge);
						// alert(sub);

						items.push({
							'id': id_ip,
							'id_item': id_i,
							'qty': qty_i,
							'h_stock': h_stock_i,
							'disc': disc,
							'extra_charge': extra_charge,
							'harga': clear_f_cur(sub)
						});

					});
				} catch (e) {

				} finally {

					var msg = '';
					if (x == 'edit') {
						id = $('.id_pemesanan').val();
						msg = 'mengubah'
					}
					if (x == 'add') {
						msg = 'menambah'
					}
					$.post(URL + 'transaksi/trx_pemesanan?type='+type, {
						mode: x,
						id_pemesan: id_cust,
						id: id,
						duration:duration,
						nomor: nomor,
						item: items,
						list_del:list_del
					}).done(function(data){
						endloading();
						var res = JSON.parse(data);

						if (res.status =='1'||res.status ==1) {
							
							$.alert({
								title: 'Success',
								content: 'Sukses ' + msg + ' data',
								buttons: {
									ok: function() {
										window.location.replace(URL + 'transaksi/pemesanan/view');
									}
								}
							});
						}else{
							$.alert({
								title: 'Success',
								content: res.message,
								buttons: {
									ok: function() {
										window.location.replace(URL + 'transaksi/pemesanan/view');
									}
								}
							});
						}
					}).fail(function(data,d,a){
						endloading();
						if (data.status ==404) {
							$.alert({
								title: 'Error',
								content: 'URL Not Found',
								buttons: {
									ok: function() {
										window.location.replace(URL + 'transaksi/pemesanan/view');
									}
								}
							});
						}else{
							$.alert({
								title: 'Error',
								content: a,
								buttons: {
									ok: function() {
										window.location.replace(URL + 'transaksi/pemesanan/view');
									}
								}
							});
						}
						console.log(data.responseText);
					});
				}
			}
		}

		if(tmpIt<1){
			$.alert('Item Pemesanan Kosong');
		}else{
			if(tmpIt.length==itemSuccess.length){
				submit_pemesanan();
			}
		}
	}

}

function del_item(x) {
	// x.parent().parent().remove();
	DataTableItem.row(x.parents('tr')).remove().draw();
	var l = DataTableItem.data().length;
	if(l>0){
		$.each($('#tb_item_pemesanan').find('tbody tr'), function(index, val) {
			$('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(0) p.no_item').html(index + 1);
		});
	}
}

var list_del = [];
function del_ip(x, el) {
	$.confirm({
		title: 'Hapus item',
		content: 'Anda yakin ingin menghapus item ini?',
		buttons: {
			confirm: function() {
				list_del.push(x);
				el.parent().parent().remove();
			},
			cancel: function() {

			}
		}
	});
}


function sh_pemesanan(x, y = null) {
	startloading('Mohon tunggu <br> Sedang mengambil data..');
	item_pj = [];
	try {
		//$('#tb_item_pemesanan').find('thead tr th:eq(4)').remove();
	} catch (e) {} finally {

		$.post(URL + 'transaksi/pemesanan_view', {
			id: x
		}, function(data) {
			endloading();
			if (data.length != 0) {
				var res = $.parseJSON(data);
				// $('.judul_pengajuan').html(res[0].judul);
				$('.no_pemesanan').html(res[0].no_pemesanan);
				$('.tgl_pemesanan').html(res[0].tgl_pemesanan);
				$('.nm_pemesan').html(res[0].nama_pemesan);
				$('.v_group').html(res[0].group);
				$('.v_lantai').html(res[0].lantai);

				var td = $('#modal_tb_item_pemesanan').find('tbody');
				td.html('');
				var no = 1;

				if (y == 'verifikasi') {
					$('.verifikasi').load(URL + 'transaksi/verifikasi', function() {
						$(this).show();
					});
				} else {
					$('.verifikasi').html('');
				}

				//$('#tb_item_pemesanan').find('thead tr').append('<th>Item Masuk</th>');
				$('#id_pemesanan_lg').val(res[0].id);

				$.each(res, function(index, el) {
					item_pj.push(res[index].barcode);
					td.append(`
<tr>
<input type="hidden" class="id_it_ps" value="` + res[index].id_it_ps + `">
<input type="hidden" class="id_item" value="` + res[index].id_item + `">
<td>` + no + `</td>
<td>` + res[index].barcode + `</td>
<td>` + res[index].item_name + `</td>
<td>` + res[index].h_stock + `</td>
<td>` + res[index].qty + `</td>
</tr>

`);
					if (res[index].qty == res[index].qty_masuk) {
						$('#modal_tb_item_pemesanan').find('tbody tr:eq(' + index + ')').addClass('IComplete bg-green');
					}
					no++;
				});
				$('#modal_view_pemesanan').modal('show');
			} else {
				$.alert('Tidak ada Item / data tidak ditemukan');
			}
		});
	}
}


// function sh_pemesanan(x){
// 	$.confirm({
// 		title:'Confirm',
// 		content:'jahsd',
// 		buttons:{
// 			ok:{
// 				text:'Oke',
// 				action:function(){
// 					alert('');
// 				}
// 			}
// 		}
// 	});
// }

$(function() {
	$('.btn-pop').popover();
});

function insert_kurir(x){
	var kurir = x.parent().find('input[name=kurir_id]').toArray();
	var id_pem = x.parent().find('input[name=id_pem]').val();
	var arr_kurir = [];

	var S1 = new Promise(function(resolve,reject){
		$.each(kurir,function(index,val){
			if($(val).prop('checked')==true){
				arr_kurir.push({
									'id_pemesanan':id_pem,
									'id_kurir':$(val).val()
								});
			}
		});
		resolve();
	});

	S1.then(function(value){
		console.log(arr_kurir);
		$.confirm({
			title: 'Pilih kurir',
			content: 'Anda yakin memilih kurir tersebut?',
			buttons: {
				confirm: function() {
					startloading('Mohon tunggu. Sedang memilih kurir...');
					$.post(URL + 'transaksi/insert_kurir',{data:arr_kurir}).done(function(data){
						endloading();
						var res = JSON.parse(data);

						$.alert({
							title: '',
							content: res.message,
							buttons: {
								ok: function() {
									window.location = URL + 'transaksi/pemesanan/view';
								}
							}
						});
					}).fail(function(e){
						endloading();
						var res = JSON.parse(e);

						$.alert({
							title: "Error",
							content: "Terjadi kesalahan, tekan OK untuk memuat ulang halaman.",
							buttons: {
								ok: function() {
									window.location = URL + 'transaksi/pemesanan/view';
								}
							}
						});
					});
						

					
				},
				cancel: function() {

				}
			}
		});
	},function(reason){
		console.log('Error : '+reason);
	});

	
}

function kurir_act(x) {
	alert('');
	var k_id = x.find('input[name=kurir_id]').val();
	var k_id_pem = x.parent().find('.id_pem').val();
	var k_name = x.find('b.kurir_name').html();

	$.confirm({
		title: 'Pilih kurir',
		content: 'Anda akan memilih kurir <b>' + k_name + '</b>',
		buttons: {
			confirm: function() {
				startloading('Mohon tunggu. Sedang memilih kurir...');
				$.post(URL + 'transaksi/add_kurir', {
					id_pem: k_id_pem,
					id_kurir: k_id
				}).done(function(data, textStatus, xhr) {
					endloading();
					var res = JSON.parse(data);

					$.alert({
						title: res.status.toUpperCase(),
						content: res.message,
						buttons: {
							ok: function() {
								window.location = URL + 'transaksi/pemesanan/view';
							}
						}
					});

				});
			},
			cancel: function() {

			}
		}
	});
}

function acc_order(x) {
	
	$.confirm({
		title: 'Terima pemesanan?',
		content: 'Anda akan menerima pemesanan ini',
		buttons: {
			confirm: function() {
				startloading('Mohon tunggu...');
				$.post(URL + 'transaksi/acc_order', {
					id: x
				}).done(function(data) {
					endloading();
					var res = JSON.parse(data);



					if(res.status=='success'){
						$.alert({
							title: "Success",
							content: res.message,
							buttons: {
								ok: function() {
									window.location = URL + 'transaksi/pemesanan/view';
								}
							}
						});
					}else{
						var err_msg = '<ul>';
						$.each(res.message,function(i,val){
							err_msg += '<li>' + res.message[i].message + '</li>';
						});
						err_msg += '</ul>';

						$.alert({
							title: "Error List(s)",
							content: err_msg,
							buttons: {
								ok: function() {
									//window.location = URL + 'transaksi/pemesanan/view';
								}
							}
						});
					}
				});
			},
			cancel: function() {

			}
		}
	});
}

$(function() {
	//console.log(arr_cs);
	if(m=='view'){

		var z = 500;
		var k = 0;
		var ins = setInterval(function() {

			$.post(URL + 'transaksi/ck_stat', {
				dt: arr_cs
			}, function(data, textStatus, xhr) {
				var dts = $.trim(data);
				if (dts.length > 0) {
					var res = $.parseJSON(dts);
					var ket = ['Waiting Approval', 'Order Received', 'Courir Assigned', 'Prepare Item', 'Courier On The Way', 'Done'];
					var ket_kurir = ['Prepare Item', 'Courier On The Way', 'Done','Cancel'];
					var btn = ['bg-red', 'bg-darken-2', 'bg-yellow', 'bg-aqua', 'bg-blue', 'btn-success','btn-danger'];
					// $('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(5)').find('ul.dropdown-menu').html('');
					// $.each(ket_kurir,function(index,val){
					// 	$('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(5)').find('ul.dropdown-menu').append('<li><a href="#" onclick="adm_ch_stat('+res.id+','+index+')">'+val+'</a></li>');
					// });
					//$('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(5)').find('ul dropdown-menu')
						// .removeAttr('class')
						// .addClass('btn ' + btn[res.status] + ' btn-xs btn-flat center-block csstooltip')
						// .html(ket[res.status] + '<span class="tooltiptext">Status Pemesanan : '+ket[res.status]+'</span>');

					$.get(URL + 'transaksi/pemesanan_btn_act/' + res.id + '/' + res.status, function(btn1) {
						$.post(URL + 'transaksi/ck_stat/get', {
							id: res.id
						}, function(data, textStatus, xhr) {
							var table = $('#tb_pemesanan').DataTable();
							var arr = $.parseJSON(data);

							var id_row = table.data();
							try {
								$.each(id_row, function(i, val) {
									// console.log(table.row(i).data()[1]);
									if (table.row(i).data()[1] == arr[1][0].no_pemesanan) {
										var c_l = table.data()[0].length - 1;
										table.cell(i, c_l).data(btn1).draw(false);
										table.cell(i, 6).data(arr[1][0].kurir_name).draw(false);
										table.cell(i, 7).data(arr[2][0].status).draw(false);
										//alert(pil_stat(arr[2][0].color,arr[2][0].status));
										//alert('');
										//$('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(6)').html('').load(URL + 'transaksi/pemesanan_btn_act/' + res.id + '/' + res.status);
										$('#tb_pemesanan').DataTable().draw(false);

										$('[data-toggle="pop-' + res.id + '"]').popover('toggle');

										setTimeout(function() {
											$('[data-toggle="pop-' + res.id + '"]').popover('toggle');
										}, 3000);
										// console.log(btn);
									}
								});
							} catch (e) {
								console.log(e);
							}

							//console.log(id_row);
							//table.columns( 1 ).search( arr[1][0].no_pemesanan ).draw();//row(1).data()[0];
							//table.cell(0,0).data('a').draw();
							arr_cs = arr[0];
							var ket = ['Waiting Approval', 'Order Received', 'Courir Assigned', 'Prepare Item', 'Courier On The Way', 'Done','Cancel'];
							toast('Nomor Pesanan : ' + arr[1][0].no_pemesanan, 'Status pesanan : ' + ket[arr[1][0].status], 'fa fa-truck');
						});
					}, 'html');

					// $('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(6)').html('').load(URL + 'transaksi/pemesanan_btn_act/' + res.id + '/' + res.status);
					// $('#tb_pemesanan').DataTable();

					// $('[data-toggle="pop-' + res.id + '"]').popover('toggle');

					// setTimeout(function() {
					// 	$('[data-toggle="pop-' + res.id + '"]').popover('toggle');
					// }, 3000);



				}
			});

		}, 5000);
	}
});

function pil_kurir(x) {

	//console.log(table.columns( 1 ).search( 'PSN-1513135850-2017' ).row(1).data()[0]);
	$('[data-toggle="popover"]').popover({
		html: true,
		content: function() {

			$('#popover-content').find('.id_pem').val($(this).val());
			return $('#popover-content').html();
		}
	});
	$(x).popover('toggle');

}

function ch_stat(x) {
	//console.log(table.columns( 1 ).search( 'PSN-1513135850-2017' ).row(1).data()[0]);
	$('[data-toggle="status_pop_content"]').popover({
		html: true,
		content: function() {

			$('#status_pop_content').find('.id_pem').val($(this).val());
			return $('#status_pop_content').html();
		}
	});
	$(x).popover('toggle');
}


function ch_stat_pem(x) {
	$(x).popover({
		html: true,
		content: function() {

			$('#stat_pem_popover').find('.id_pem').val($(x).val());
			return $('#stat_pem_popover').html();
		}
	});

	$(x).popover('toggle');
}


function adm_ch_stat(id,x){
	// alert(id + '>' + x);
	startloading('Mengubah Status Pemesanan...');
	$.ajax({ 
        url: URL + 'transaksi/ch_stat_from_admin', 
        type : "post",      
        dataType : "json",                                               
        data:{id:id,stat:x},
        error: function(result){                    
        	endloading();
        },
        success: function(result) {  
                location.reload()
        }

    }); 
}

function pil_stat(stat,id,c,stTxt){
	var ket_kurir = ['','','','Prepare Item', 'Courier On The Way', 'Done'];
	var btn1 = `	<div class="dropdown">
	                    <button class="btn-pop btn `+ c +` btn-sm btn-flat center-block csstooltip dropdown-toggle" type="button" data-toggle="dropdown">`+stTxt+`
						    `;
	if(stat!=5){
		btn1+=`<span class="caret"></span>`;
	}				
		btn1+=`</button>`;

	if(stat!=5){
		btn1+=`<ul class="dropdown-menu">`;
		$.each(ket_kurir,function(index,val){
			if(index>2){
				btn1+=`<li><a href="#" onclick="adm_ch_stat(`+id+`,`+index+`)">`+val+`</a></li>`;	
			}
		});
		btn1+= `</ul>`;
	}

	btn1+= `</div> `;
	return btn1;
}

function cancel_order(x){
	startloading('Mohon tunggu...');
	$.post(URL + 'mobile/cancel_pem',{id:x}).done(function(data){
		endloading();
		var res = JSON.parse(data);

		if(res.status==1){
			$.alert({
				title: 'Success',
				content: res.message,
				buttons: {
					ok: function() {
						window.location.replace(URL + 'transaksi/pemesanan/view');
					}
				}
			});
		}else{
			$.alert({
				title: 'Error',
				content: res.message,
				buttons: {
					ok: function() {
						window.location.replace(URL + 'transaksi/pemesanan/view');
					}
				}
			});
		}
	}).fail(function(data){
		endloading();
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

function hide_pop(x){
	x.parent().parent().popover('hide');
}

function ck_status(x){
	$.confirm({
		title:'',
	    content: function () {
	        var self = this;
	        return $.ajax({
	            url: URL + 'transaksi/log_status_detail',
	            dataType: 'json',
	            method: 'post',
	            data:{id_pemesanan:x}
	        }).done(function (response) {
	            self.setContent('<h4><b>Riwayat Status Pemesanan</b></h4>');
	            var clr = ['red','grey','#ff7237','#00c1c1','blue','green','red'];
	            $.each(response,function(index,val){
	            	self.setContentAppend('( '+ val.insert_date+' ) => <b style="color:'+clr[val.status]+';">'+val.status_txt+'</b><br>');
	            });
	            
	        }).fail(function(){
	            self.setContent('Terjadi kesalahan, coba beberapa saat lagi.');
	        });
	    },
	    buttons:{
	    	ok:{
	    		text:'CLOSE'
	    	}
	    }
	});
}