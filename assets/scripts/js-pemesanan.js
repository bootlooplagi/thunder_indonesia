var tmpItem = [];
var qtyItem = [];
var del_date_server = [];

// var tmpH = '';

function hideForm(x){
	if($('#tf_free').is(':visible')===true){
		$('#tf_free').hide();
		$('#tf_sel').show();
	}else{
		$('#tf_free').show();
		$('#tf_sel').hide();
	}

	
	// let frm = $(x).prop('checked');
	
	// if(frm===true){
		
	// 	$('#tf_free').show();
	// 	$('#tf_sel').hide();
	// 	$(x).prop('checked',true);
	// }else{
		
	// 	$('#tf_sel').show();
	// 	$('#tf_free').hide();
	// 	$(x).prop('checked',false);
	// }
};

$('.dt_picker').datetimepicker({
        // inline: true,
        // sideBySide: true,
        // viewMode: 'years',
        format: 'YYYY-MM-DD HH:mm:ss'
    });

// $('.clockpicker').clockpicker({
// 	donetext:'Set Jam'
// });

$(function () {
	$('.loading_in_out').datetimepicker({
		format: 'YYYY-MM-DD HH:mm'
	});
	$('.dtpicker').datetimepicker({
		format: 'YYYY-MM-DD HH:mm'
	});
	$('.dtpicker_acara').datetimepicker({
		format: 'YYYY-MM-DD'
	});
});

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
				        } ]
				    });
$(function() {
	// alert(jenis);
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
			var item_durasi = $('#sel_durasi').val().split('|');

			var indexIt = $('#item_select').prop('selectedIndex');

			if(parseInt($('#qty').val())>item_val[3] && item_val[4]=='ITEM' && item_val[6]==0){
				$.alert('Stock Item : ' + item_val[3] + '<br>Stock kurang dari jumlah permintaan.');
			}else{

					var qty = parseInt(($('#qty').val()=='')?'0':$('#qty').val());
					var disc = parseInt(($('#disc').val()=='')?'0':$('#disc').val());
					var extra_charge = parseInt(($('#extra').val()=='')?'0':$('#extra').val());
					var harga = parseInt(item_durasi[1]);
					var total = parseInt(parseInt(item_durasi[1])*qty);
					var durasi_name = item_durasi[2];


					var net = parseInt((harga*qty)-((harga*qty)*(disc/100))+((harga*qty)*(extra_charge/100)));
					// alert(total);
					// alert('1');
					try {
						$.each($('#tb_item_pemesanan').find('tbody tr'), function(index, val) {

							var barcode = $('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(1)').html();
							var hrg = clear_f_cur(DataTableItem.cell(index,6).data());


							if (item_val[1] == barcode && harga==hrg) {

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
								DataTableItem.cell(index,10).data(durasi_name).draw(false);
								var harga_total = (parseInt(jml)+qty) * parseInt(harga_jual);
								DataTableItem.cell(index,11).data(f_cur(((parseInt(jml)+qty) * parseInt(harga_jual))-(harga_total*(disc/100))+(harga_total*(extra_charge/100)))).draw(false);
								DataTableItem.cell(index,14).data(item_durasi[0]).draw(false);
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
													`<input type="hidden" class="id_item" value="` + item_val[0] + `"><input type="hidden" class="id_it_pemesanan"><p class="no_item"></p>`,
													item_val[1],
													item_val[2],
													item_val[4],
													item_val[3],
													qty,
													f_cur(harga),
													f_cur(total),
													disc,
													extra_charge,
													durasi_name,
													f_cur(net),
													`<button onclick="del_item($(this))" type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete">
														<span class="glyphicon glyphicon-trash"></span>
													</button>`,
													'',
													item_durasi[0]
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

function add_item_free(){
	// $.each($('#tb_item_pemesanan tbody tr'), function(index, val) {
	// 	console.log($.parseHTML(DataTableItem.cell(index,0).data())[0].value);
	// });
	var freeF = $('#frmFree');
	DataTableItem.row.add([
		`<input type="hidden" class="id_item" value="FREE">
		<input type="hidden" class="id_it_pemesanan">
		<p class="no_item"></p>`,
		freeF.find('#frBarcode').val(),
		freeF.find('#frNamaBarang').val(),
		'ITEM BEBAS',
		'-',
		freeF.find('#frQty').val(),
		freeF.find('#frHarga').val(),
		parseInt(freeF.find('#frQty').val())*parseInt(freeF.find('#frHarga').val()),
		freeF.find('#frDiscount').val(),
		'-',
		freeF.find('#frDurasi').val(),
		(parseInt(freeF.find('#frQty').val())*parseInt(freeF.find('#frHarga').val()))-((parseInt(freeF.find('#frQty').val())*parseInt(freeF.find('#frHarga').val()))*(parseInt(freeF.find('#frDiscount').val())/100)),
		`<button onclick="del_item($(this))" type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete">
			<span class="glyphicon glyphicon-trash"></span>
		</button>`,
		'',
		'item_durasi[0]'
	]).draw(false);
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

	if(is_nego==1){
		$.confirm({
			title:'Simpan Data?',
			content:"Apakah harga yang anda isi sudah benar?<br>Data akan dikirimkan ke E-mail Customer. <br>Klik <b>Kirim</b> untuk melanjutkan",
			buttons:{
				ok:{
					text:'Simpan & Kirim',
					btnClass:'btn-primary',
					action:function(){
						next_submit(x,type,1)
					}
				},save:{
					text:'Simpan',
					btnClass:'btn-warning',
					action:function(){
						next_submit(x,type)
					}
				},
				cancel:{
					text:'Batal'
				}
			}
		});
	}

	if(is_nego==0){
		$.confirm({
			title:'Simpan data?',
			content:"Apakah data yang anda isi sudah benar?<br>Klik <b>Simpan</b> untuk melanjutkan",
			buttons:{
				ok:{
					text:'Simpan',
					btnClass:'btn-primary',
					action:function(){
						next_submit(x,type)
					}
				},
				cancel:{
					text:'Batal'
				}
			}
		});
	}

	var next_submit = function(x,type,send=null){
		var tmpIt = [];
		var itemSuccess = [];
		var itemError = [];
		var tmpFree = [];

		var valid_submit = validate('req-s-pem');

		if(valid_submit==true){
			var tb_item_pm = $('#tb_item_pemesanan').dataTable();
			var c_item = tb_item_pm.fnGetData().length;

			if(c_item>0){
				$.each($('#tb_item_pemesanan tbody tr'), function(index, val) {
						
					if($.parseHTML(DataTableItem.cell(index,0).data())[0].value=='FREE'){
						// tmpFree.push({
						// 	barcode:DataTableItem.cell(index,1).data(),
						// 	name:parseInt(DataTableItem.cell(index,2).data()),
						// 	// stock:parseInt(DataTableItem.cell(index,4).data()),
						// 	qty:parseInt(DataTableItem.cell(index,5).data()),
						// 	harga:parseInt(DataTableItem.cell(index,6).data())
						// 	jenis_item:'FREE',
						// 	disc:parseInt(DataTableItem.cell(index,8).data()),
						// 	is_free:1
						// 	// extra_charge:parseInt(DataTableItem.cell(index,9).data()),
						// 	// sub:parseInt(DataTableItem.cell(index,6).data()),
						// 	// durasi:DataTableItem.cell(index,14).data()
						// });
						tmpFree.push({
							barcode:DataTableItem.cell(index,1).data(),
							name:DataTableItem.cell(index,2).data(),
							// stock:parseInt(DataTableItem.cell(index,4).data()),
							qty:parseInt(DataTableItem.cell(index,5).data()),
							harga:parseInt(DataTableItem.cell(index,6).data()),
							// jenis_item:'FREE',
							disc:parseInt(DataTableItem.cell(index,8).data()),
							is_free:1
							// extra_charge:parseInt(DataTableItem.cell(index,9).data()),
							// sub:parseInt(DataTableItem.cell(index,6).data()),
							// durasi:DataTableItem.cell(index,14).data()
						});
						// console.log(tmpFree);
						// console.log(items);

					}else{
						tmpIt.push({
							barcode:DataTableItem.cell(index,1).data(),
							name:parseInt(DataTableItem.cell(index,2).data()),
							stock:parseInt(DataTableItem.cell(index,4).data()),
							qty:parseInt(DataTableItem.cell(index,5).data()),
							jenis_item:DataTableItem.cell(index,3).data(),
							disc:parseInt(DataTableItem.cell(index,8).data()),
							extra_charge:parseInt(DataTableItem.cell(index,9).data()),
							sub:parseInt(DataTableItem.cell(index,6).data()),
							durasi:DataTableItem.cell(index,14).data(),
						});

						var stock = parseInt(DataTableItem.cell(index,4).data());
						var qty = parseInt(DataTableItem.cell(index,5).data());
						var jenis = parseInt(DataTableItem.cell(index,3).data());
						var disc = parseInt(DataTableItem.cell(index,8).data());
						var extra_charge = parseInt(DataTableItem.cell(index,9).data());
						var sub = parseInt(DataTableItem.cell(index,6).data());
						var durasi = parseInt(DataTableItem.cell(index,14).data());

						if(stock<qty && jenis=='ITEM'){
							itemError.push({
								barcode:DataTableItem.cell(index,1).data(),
								name:DataTableItem.cell(index,2).data(),
								stock:parseInt(DataTableItem.cell(index,4).data()),
								qty:parseInt(DataTableItem.cell(index,5).data()),
								jenis_item:DataTableItem.cell(index,3).data(),
								disc:parseInt(DataTableItem.cell(index,8).data()),
								extra_charge:parseInt(DataTableItem.cell(index,9).data()),
								sub:parseInt(DataTableItem.cell(index,6).data()),
								durasi:parseInt(DataTableItem.cell(index,14).data())
							});

							$('#tb_item_pemesanan tbody tr:eq('+index+')').css({
								background:'#fd9c9c'
							});
						}else{
							itemSuccess.push({
								barcode:DataTableItem.cell(index,1).data(),
								name:DataTableItem.cell(index,2).data(),
								stock:parseInt(DataTableItem.cell(index,4).data()),
								qty:parseInt(DataTableItem.cell(index,5).data()),
								jenis_item:DataTableItem.cell(index,3).data(),
								disc:parseInt(DataTableItem.cell(index,8).data()),
								extra_charge:parseInt(DataTableItem.cell(index,9).data()),
								sub:parseInt(DataTableItem.cell(index,6).data()),
								durasi:parseInt(DataTableItem.cell(index,14).data())
							});
						}
					}
				});
			}

			// console.log(itemSuccess);

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
						var tanggal_acara = $('input[name="tanggal_acara"]').val();
						//var tanggal_acara_awal = $('input[name="tanggal_acara_awal"]').val();
						//var tanggal_acara_akhir = $('input[name="tanggal_acara_akhir"]').val();
						var nama_event = $('input[name="nama_event"]').val();
						var alamat_venue = $('textarea[name="alamat_venue"]').val();
						var loading_in = $('input[name="loading_in"]').val();
						var loading_out = $('input[name="loading_out"]').val();
						var pic = $('input[name="pic"]').val();
						var no_hp_pic = $('input[name="no_hp_pic"]').val();
						// var duration = $('#duration').val();
						var nomor = $('#no_pemesanan').html();
						var items = [];
						try {
							$.each(DataTableItem.rows().data(),function(index,val){
							// $.each($('.id_item'), function(index, val) {
								// if($.parseHTML(DataTableItem.cell(index,0).data())[0].value=='FREE'){
								

								var id_i = $.parseHTML(DataTableItem.cell(index,0).data())[0].value;//$('.id_item').eq(index).val();
								var id_ip = $.parseHTML(DataTableItem.cell(index,0).data())[1].value;//$('.id_it_pemesanan').eq(index).val();
								// var qty_i = $('.id_item').eq(index).parents('tbody tr').find('td:eq(5)').html();
								// var h_stock_i = $('.id_item').eq(index).parents('tbody tr').find('td:eq(4)').html();
								// var disc = $('.id_item').eq(index).parents('tbody tr').find('td:eq(8)').html();
								// var extra_charge = $('.id_item').eq(index).parents('tbody tr').find('td:eq(9)').html();
								// var sub = $('.id_item').eq(index).parents('tbody tr').find('td:eq(6)').html();

								if(id_i=='FREE'){
									
									
								}else{
									
									var qty_i = DataTableItem.cell(index,5).data();
									var h_stock_i = DataTableItem.cell(index,4).data();
									var disc = DataTableItem.cell(index,8).data();
									var extra_charge = DataTableItem.cell(index,9).data();
									var sub = DataTableItem.cell(index,6).data();
									var net = clear_f_cur(DataTableItem.cell(index,11).data());
									var durasi_id = DataTableItem.cell(index,14).data();


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
										'harga': clear_f_cur(sub),
										'total_harga':clear_f_cur(net),
										'durasi':clear_f_cur(durasi_id)
									});


								}

							});
						} catch (e) {

						} finally {

							var msg = '';
							// var id=10;
							// alert($('.id_pemesanan').val());
							if (x == 'edit') {
								id = $('.id_pemesanan').val();
								msg = 'mengubah'
							}
							if (x == 'add') {
								msg = 'menambah'
							}

							var arrInp_date = $('#tb_ls_tanggal tbody tr.local');
							var arrInp_date_svr = $('#tb_ls_tanggal tbody tr.server');

							if(arrInp_date.length>0||arrInp_date_svr.length>0){
								var tgl_acara = [];

								arrInp_date.toArray().forEach(function(item,index){
									tgl_acara.push({
										tanggal_awal:arrInp_date.eq(index).find('td:eq(0)').html(),
										tanggal_akhir:arrInp_date.eq(index).find('td:eq(1)').html()
									})
								});
							}else{
								$.alert('Anda belum memasukkan tanggal Acara.');
								endloading();
								return false;

							}

							// alert(id);
							$.post(URL + 'transaksi/trx_pemesanan?type='+type, {
								mode: x,
								id_pemesan: id_cust,
								id: id,
								tanggal_acara:tanggal_acara,
								//tanggal_acara_awal:tanggal_acara_awal,
								//tanggal_acara_akhir:tanggal_acara_akhir,
								nama_event:nama_event,
								alamat_venue:alamat_venue,
								loading_in:loading_in,
								loading_out:loading_out,
								pic:pic,
								no_hp_pic:no_hp_pic,

								// duration:duration,
								nomor: nomor,
								item: items,
								itemFree: tmpFree,
								list_del:list_del,
								kirim:send,
								ls_tgl_acara:tgl_acara,
								ls_tgl_acara_del:del_date_server
							}).done(function(data){
								endloading();
								var res = JSON.parse(data);

								if (res.status =='1'||res.status ==1) {
									
									$.alert({
										title: 'Success',
										content: 'Sukses ' + msg + ' data',
										buttons: {
											ok: function() {
												window.location.replace(URL + redirect);
											}
										}
									});
								}else{
									$.alert({
										title: 'Success',
										content: res.message,
										buttons: {
											ok: function() {
												window.location.replace(URL + redirect);
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
												window.location.replace(URL + redirect);
											}
										}
									});
								}else{
									$.alert({
										title: 'Error',
										content: a,
										buttons: {
											ok: function() {
												window.location.replace(URL + redirect);
											}
										}
									});
								}
								console.log(data.responseText);
							});
						}
					}
				}

				if(tmpIt<1 && tmpFree<1){
					console.log(tmpFree);
					$.alert('Item Pemesanan Kosong');
				}else{
					if(tmpIt.length==itemSuccess.length){
						submit_pemesanan();
					}
				}
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

	console.log(DataTableItem.rows().data());
}

var list_del = [];
function del_ip(x, el) {
	$.confirm({
		title: 'Hapus item',
		content: 'Anda yakin ingin menghapus item ini?',
		buttons: {
			confirm: function() {
				list_del.push(x);
				// el.parent().parent().remove();
				DataTableItem.row(el.parents('tr')).remove().draw();
				var l = DataTableItem.data().length;
				if(l>0){

					$.each($('#tb_item_pemesanan').find('tbody tr'), function(index, val) {
						$('#tb_item_pemesanan').find('tbody tr:eq(' + index + ') td:eq(0) p.no_item').html(index + 1);
					});
				}
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
				$('.pic').html(res[0].pic);
				$('.nama_event').html(res[0].nama_event);
				$('.alamat_venue').html(res[0].alamat_venue);
				$('.loading_in').html(res[0].loading_in);
				$('.loading_out').html(res[0].loading_out);
				$('.ls_tanggal_acara tbody').empty();

				res[0].ls_tanggal_acara.forEach(function(item,index){
					$('.ls_tanggal_acara tbody').append(`
						<tr>
							<td>`+res[0].ls_tanggal_acara[index].tanggal_awal+`</td>
							<td>`+res[0].ls_tanggal_acara[index].tanggal_akhir+`</td>
						</tr>
					`);
				});

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
				var total_akhir = 0;

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
								<td>` + res[index].disc + `%</td>
								<td>` + res[index].extra_charge + `%</td>
								<td>` + res[index].name_durasi + `</td>
								<td><input type="checkbox" `+res[index].is_out+` onclick="out_set(`+res[index].id_it_pn+`,$(this))"></td>
								<td><input type="checkbox" `+res[index].is_in+` onclick="in_set(`+res[index].id_it_pn+`,$(this))"></td>
								<!-- <td class="t_right">` + f_cur(res[index].harga) + `</td>
								<td class="t_right">` + f_cur(parseInt(res[index].total_harga)) + `</td>
								<td class="t_right">` + f_cur(parseInt(res[index].harga_akhir)) + `</td> -->
								</tr>
					`);

					total_akhir+=parseInt(res[index].harga_akhir);
					if (res[index].qty == res[index].qty_masuk) {
						$('#modal_tb_item_pemesanan').find('tbody tr:eq(' + index + ')').addClass('IComplete bg-green');
					}
					no++;
				});
				$('#total_akhir').html(f_cur(total_akhir));
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
									window.location = URL + redirect;
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
									window.location = URL + redirect;
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
								window.location = URL + redirect;
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
									window.location = URL + redirect;
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
									//window.location = URL + redirect;
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

// $(function() {
// 	//console.log(arr_cs);
// 	if(m=='view'){

// 		var z = 500;
// 		var k = 0;
// 		var ins = setInterval(function() {

// 			$.post(URL + 'transaksi/ck_stat', {
// 				dt: arr_cs
// 			}, function(data, textStatus, xhr) {
// 				var dts = $.trim(data);
// 				if (dts.length > 0) {
// 					var res = $.parseJSON(dts);
// 					var ket = ['Waiting Approval', 'Order Received', 'Courir Assigned', 'Prepare Item', 'Courier On The Way', 'Done'];
// 					var ket_kurir = ['Prepare Item', 'Courier On The Way', 'Done','Cancel'];
// 					var btn = ['bg-red', 'bg-darken-2', 'bg-yellow', 'bg-aqua', 'bg-blue', 'btn-success','btn-danger'];
// 					// $('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(5)').find('ul.dropdown-menu').html('');
// 					// $.each(ket_kurir,function(index,val){
// 					// 	$('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(5)').find('ul.dropdown-menu').append('<li><a href="#" onclick="adm_ch_stat('+res.id+','+index+')">'+val+'</a></li>');
// 					// });
// 					//$('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(5)').find('ul dropdown-menu')
// 						// .removeAttr('class')
// 						// .addClass('btn ' + btn[res.status] + ' btn-xs btn-flat center-block csstooltip')
// 						// .html(ket[res.status] + '<span class="tooltiptext">Status Pemesanan : '+ket[res.status]+'</span>');

// 					$.get(URL + 'transaksi/pemesanan_btn_act/' + res.id + '/' + res.status, function(btn1) {
// 						$.post(URL + 'transaksi/ck_stat/get', {
// 							id: res.id
// 						}, function(data, textStatus, xhr) {
// 							var table = $('#tb_pemesanan').DataTable();
// 							var arr = $.parseJSON(data);

// 							var id_row = table.data();
// 							try {
// 								$.each(id_row, function(i, val) {
// 									// console.log(table.row(i).data()[1]);
// 									if (table.row(i).data()[1] == arr[1][0].no_pemesanan) {
// 										var c_l = table.data()[0].length - 1;
// 										table.cell(i, c_l).data(btn1).draw(false);
// 										table.cell(i, 6).data(arr[1][0].kurir_name).draw(false);
// 										table.cell(i, 7).data(arr[2][0].status).draw(false);
// 										//alert(pil_stat(arr[2][0].color,arr[2][0].status));
// 										//alert('');
// 										//$('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(6)').html('').load(URL + 'transaksi/pemesanan_btn_act/' + res.id + '/' + res.status);
// 										$('#tb_pemesanan').DataTable().draw(false);

// 										$('[data-toggle="pop-' + res.id + '"]').popover('toggle');

// 										setTimeout(function() {
// 											$('[data-toggle="pop-' + res.id + '"]').popover('toggle');
// 										}, 3000);
// 										// console.log(btn);
// 									}
// 								});
// 							} catch (e) {
// 								console.log(e);
// 							}

// 							//console.log(id_row);
// 							//table.columns( 1 ).search( arr[1][0].no_pemesanan ).draw();//row(1).data()[0];
// 							//table.cell(0,0).data('a').draw();
// 							arr_cs = arr[0];
// 							var ket = ['Waiting Approval', 'Order Received', 'Courir Assigned', 'Prepare Item', 'Courier On The Way', 'Done','Cancel'];
// 							toast('Nomor Pesanan : ' + arr[1][0].no_pemesanan, 'Status pesanan : ' + ket[arr[1][0].status], 'fa fa-truck');
// 						});
// 					}, 'html');

// 					// $('#tb_pemesanan').find('tbody tr.id-' + res.id + ' td:eq(6)').html('').load(URL + 'transaksi/pemesanan_btn_act/' + res.id + '/' + res.status);
// 					// $('#tb_pemesanan').DataTable();

// 					// $('[data-toggle="pop-' + res.id + '"]').popover('toggle');

// 					// setTimeout(function() {
// 					// 	$('[data-toggle="pop-' + res.id + '"]').popover('toggle');
// 					// }, 3000);



// 				}
// 			});

// 		}, 5000);
// 	}
// });

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


function ch_stat_pem(x,s) {
	$(x).popover({
		html: true,
		content: function() {

			$('#stat_pem_popover').find('.id_pem').val($(x).val());
			// alert(s);
			for(var i=s; i>-1; i--){
				$('#stat_pem_popover').find('#act_'+i).hide();
			}
			for(var i=s+1; i<5; i++){
				$('#stat_pem_popover').find('#act_'+i).show();
			}
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
        	endloading(); 
            $.alert({
            	title:'Sukses',
            	content:result.message,
            	buttons:{
            		ok:{
            			text:"OKE",
            			action:function(){
            				location.reload();
            			}
            		}
            	}
            });
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
						window.location.replace(URL + redirect);
					}
				}
			});
		}else{
			$.alert({
				title: 'Error',
				content: res.message,
				buttons: {
					ok: function() {
						window.location.replace(URL + redirect);
					}
				}
			});
		}
	}).fail(function(data){
		endloading();
	});
}


function conf_to_prod(x){
	startloading('Mohon tunggu...');
	$.post(URL + 'transaksi/confirm_to_production',{id:x}).done(function(data){
		endloading();
		var res = JSON.parse(data);

		if(res.status==1){
			$.alert({
				title: 'Success',
				content: res.message,
				buttons: {
					ok: function() {
						window.location.replace(URL + redirect);
					}
				}
			});
		}else{
			$.alert({
				title: 'Error',
				content: res.message,
				buttons: {
					ok: function() {
						window.location.replace(URL + redirect);
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

	$.post(URL+'transaksi/ch_durasi',{id:v[0]}).done(function(response){
		var res;
		$('#sel_durasi').empty();
		if(response=='null'){
			res = [];
		}else{
			res = JSON.parse(response);
			

			res.forEach(function(item,index){
				$('#sel_durasi').append(`<option value="`+item.id+`|`+item.harga+`|`+item.name+`">`+item.name+` - Rp `+f_cur(item.harga)+`</option>`);
			});
		}
		
		
	}).fail(function(){

	});
}

function hide_pop(x){
	x.parent().parent().popover('hide');
}

function select_customer(x){
	$('.loading-user').fadeIn(function(){
		$.post(URL+'transaksi/user_info_pemesanan',{id:x.val()}).done(function(data){
			$('.loading-user').fadeOut(function(){
				$('#user_info').html(data);	
			});
			
		}).fail(function(e){

		});
	});
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
	            self.setContentAppend('<h4 style="width:100%;background-color:#ffb04b;"><b>Penawaran</b></h4>');
	            var clr = ['red','grey','#ff7237','#00c1c1','blue','green','red'];

	            var penawaran = [];
	            var pemesanan = [];
	            
	            $.each(response,function(index,val){
	            	if(val.jenis=='penawaran'){
	            		penawaran.push('( '+ val.insert_date+' ) => <b style="color:'+clr[val.status]+';">'+val.status_txt+'</b><br>');
	            	}
	            	if(val.jenis=='pemesanan'){
	            		pemesanan.push('( '+ val.insert_date+' ) => <b style="color:'+clr[val.status]+';">'+val.status_txt+'</b><br>');
	            	}
	            });

	            $.each(penawaran,function(index,val){
	            	self.setContentAppend(val);
	            });

	            

	            if(jenis=='pemesanan'){
	            	self.setContentAppend('<h4 style="width:100%;background-color:grey;color:white;"><b>Pemesanan</b></h4>');
		            $.each(pemesanan,function(index,val){
		            	self.setContentAppend(val);
		            });
	            }
	            
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

function edit_harga_nego(x){
	// alert(x.parent().parent().html());
	var selector = x.parent().parent();
	var tmpNet = x.parent().parent().find('.net').attr('data-net');
	var sel = DataTableItem.cell(x.parent().parent(),11);
	sel.data(`	<input class="form-control" style="width:100px" type="number" name="ttl_nego" value=`+tmpNet+` />
											<button type="button" onclick="save_total_nego($(this))" class="btn btn-success btn-sm" data-toggle="tooltip" title="Edit Harga">
                                                <span class="glyphicon glyphicon-check"></span>
                                            </button>`);
	x.css('display','none');
	selector.find('input[name="ttl_nego"]').select();
}

function save_total_nego(x){

	x.parent().parent().find('button.btn-edit-nego').show();
	var tmpNet = x.parent().parent().find('input[name="ttl_nego"]').val();
	x.parent().parent().find('.net').attr('data-net',tmpNet);
	var sel = DataTableItem.cell(x.parent().parent(),11);
	sel.data(f_cur(tmpNet));
}

function add_driver(x=null,y=null){
	var id_pemesanan = new String;
	if(x!=null){
		id_pemesanan = x.parent().find('input[name=id_pem]').val();
	}else{
		if(y!=null){
			id_pemesanan = y;
		}else{
			$.alert('');
		}
	}


	$.alert({

		containerFluid: true,
		columnClass:'col-lg-6 col-lg-offset-3',
		content:function(){
			var self = this;
			return $.post(URL + 'transaksi/sh_driver?id_pemesanan='+id_pemesanan).done(function(response){
				self.setContent("");
	            self.setContentAppend(response);
	            self.setTitle(`Pilih Driver atau 
	            				<script src="`+URL+`assets/scripts/autocomplete.js"></script>
	            				<div class="autocomplete">
								    <input id="myInput" type="text" name="myCountry" placeholder="Input Nama Freelancer">
							  	</div>&nbsp;<i style="display:none" id="Spin_Driver" class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i><input id="submit_ac" id-pem=`+id_pemesanan+` type="submit" value="Pilih" style="display:none;"/>`);
			}).fail();
		}
	});
}



function add_crew(x=null,y=null){
	// var id_pemesanan = x.parent().find('input[name=id_pem]').val();
	var id_pemesanan = new String;
	if(x!=null){
		id_pemesanan = x.parent().find('input[name=id_pem]').val();
	}else{
		if(y!=null){
			id_pemesanan = y;
		}else{
			$.alert('');
		}
	}

	$.alert({

		containerFluid: true,
		columnClass:'col-lg-6 col-lg-offset-3',
		content:function(){
			var self = this;
			return $.post(URL + 'transaksi/sh_driver/crew?id_pemesanan='+id_pemesanan).done(function(response){
				self.setContent("");
	            self.setContentAppend(response);
	            self.setTitle(`	<script src="`+URL+`assets/scripts/freelance.js"></script>
					            Pilih Driver atau 
					            <div class="autocomplete">
					                <input id="myInput" type="text" name="myCountry" placeholder="Input Nama Freelancer">
					            </div>
					            <input id="submit_ac" id-pem=`+id_pemesanan+` type="submit" value="Pilih" style="display:none;"/>`);
			}).fail();
		},buttons:{
			submit:{
				text:"Submit",
				btnClass:"btn-primary",
				action:function(){
					var crew_selected = [];
					var arr = $('.driver_list.card.selected').toArray();
					var el = $('.driver_list.card.selected');
					var stringMessage = '';

					$.each(arr,function(index,item){
						crew_selected.push({
							id_kurir:el.eq(index).attr('data-id'),
							id_pemesanan:id_pemesanan
						});
						stringMessage+=`<li>`+el.eq(index).attr('data-name')+`</li>`;
					});

					if(crew_selected.length > 0){
						$.confirm({
							title:"Pilih Kurir?",
							content:`Anda yakin ingin memilih Crew : <br>
									<ul>`+stringMessage+`</ul>`,
							buttons:{
								ok:{
									text:"Ya!",
									btnClass:"btn-success",
									action:function(){
										startloading('Mohon tunggu...');
										$.post(URL+'transaksi/insert_kurir',{data:crew_selected}).done(function(response){
											endloading();
											var res1 = JSON.parse(response);
											$.alert({
												title:"",
												content:res1.message,
												buttons:{
													ok:{
														text:"OKE",
														action:function(){
															window.location.href = URL+`transaksi/pemesanan/view`;
														}
													}
												}
											});
										}).fail();
									}	
								},no:{
									text:"Tidak"
								}
							}
						});
					}else{
						$.alert('Anda belum memilih Crew.<br><b style="color:red;">Permintaan dibatalkan.</b>');
					}

				}
			},close:{

			}
		}
	});
}

function add_driver_to_produksi(id=null,name=null,id_pemesanan=null){
	var arr_kurir = [];

	arr_kurir.push({
					'id_pemesanan':id_pemesanan,
					'id_kurir':id,
					'is_driver':1
				});
	$.confirm({
		title:"",
		content:"Pilih Driver <b>"+name+"</b>?",
		buttons:{
			ok:{
				text:"Ya!",
				btnClass:"btn-primary",
				action:function(){
					startloading('Mohon tunggu. Sedang memilih kurir...');
					$.post(URL + 'transaksi/insert_kurir',{data:arr_kurir,is_driver:1}).done(function(data){
						endloading();
						var res = JSON.parse(data);

						$.alert({
							title: '',
							content: res.message,
							buttons: {
								ok: function() {
									window.location = URL + redirect;
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
									window.location = URL + redirect;
								}
							}
						});
					});
				}
			},cancel:{
				text:"CANCEL"
			}
		}
	});
}

function pilih_freelance(id=null,name=null,id_pemesanan=null){
	add_driver_to_produksi(id,name,id_pemesanan);
}

function add_freelance(name=null,id_pemesanan=null){
	$.confirm({
		title:"Konfirmasi",
		content:"Anda yakin ingin menambahkan Freelance dengan nama <b>"+name+"</b>?",
		buttons:{
			ok:{
				text:"Ya!",
				btnClass:"btn-primary",
				action:function(){
					startloading('Mohon tunggu...');
					$.post(URL+'customer/add_freelance',{name:name}).done(function(response){
						endloading();
						var res = JSON.parse(response);

						if(res.status==1){
							countries.push({
					            id:res.id,
					            name:name
					        });
							$.alert({
								title:"Tambah Freelance",
								content:res.message,
								buttons:{
									add:{
										text:"Pilih Driver "+name,
										action:function(){
											add_driver_to_produksi(res.id,name,id_pemesanan);
											$('#myInput').val('');
											$('#submit_ac').hide();
										},
										btnClass:"bg-green"
									},close:{
										text:"Pilih Driver lain",
										btnClass:"bg-yellow",
										action:function(){
											$('#myInput').val('');
											$('#submit_ac').hide();
										}
									}
								}
							});
						}

						
					}).fail(function(){
						endloading();
					});
				}
			},cancel:{
				text:"Tidak"
			}
		}
	});
}


function select_crew(x,id,name){
	if(x.hasClass('selected')){
		x.removeClass('selected');
		x.css('box-shadow','0 4px 8px 0 rgba(0,0,0,0.2)');	
	}else{
		x.addClass('selected');
		x.css('box-shadow','rgb(81, 51, 247) 0 0px 14px 6px');	
	}
	
}

function add_freelance_to_dialog(name,id_pemesanan){
	$.confirm({
		title:"Konfirmasi",
		content:"Anda yakin ingin menambahkan Freelance dengan nama <b>"+name+"</b>?",
		buttons:{
			ok:{
				text:"Ya!",
				btnClass:"btn-primary",
				action:function(){
					startloading('Mohon tunggu...');
					$.post(URL+'customer/add_freelance',{name:name}).done(function(response){
						endloading();
						var res = JSON.parse(response);



						if(res.status==1){
							var html = `<div class="col-md-3">
				                <div class="driver_list card" data-id=`+res.id+` data-name="`+name+`"" onclick="select_crew($(this),`+res.id+`)">
				                  <img src="`+URL+`images/img_avatar.png?token=`+new Date().getTime()+`" alt="Avatar" style="width:100%;background-color:grey;">
				                  <div class="containerz bg-yellow">
				                    <center ><h6><b>`+name+`</b></h6> </center>
				                  </div>
				                </div>
				            </div>`;

							$('#content-dialog').append(html);

							countries.push({
					            id:res.id,
					            name:name
					        });

							$.alert({
								title:"Tambah Freelance",
								content:res.message
							});
						}

						
					}).fail(function(){
						endloading();
					});
				}
			},cancel:{
				text:"Tidak"
			}
		}
	});
}


function ver_crew(id){
	$.confirm({
		title:'List Crew',
		content:function(){
			var self = this;
			return $.post(URL+'transaksi/chk_crew/'+id).done(function(data){
				self.setContent(data);
				self.setContentAppend('<br>Jika sudah benar, silahkan klik Verifikasi dan melanjutkan pemesanan.');
			}).fail(function(){

			});
		},buttons:{
			verifikasi:{
				text:'Verifikasi',
				btnClass:'btn btn-primary',
				action:function(){
					$.post(URL+'transaksi/verifikasi_crew',{id:id}).done(function(data){
						$.alert({
							title:'',
							content:'Sukses mengubah status pemesanan.',
							buttons:{
								submit:{
									text:'OK',
									action:function(){
										window.location.href = URL+`transaksi/pemesanan/view`;
									}
								}
							}
						});
					}).fail();
				}
			},cancel:{

			}
		}
	});
}

function save_detail_acara(){
	var validate = 0;
	var arr_input = $('.frm-rincian_acara').find('input,textarea').toArray();
	arr_input.forEach( function(element, index) {
		var value = $('.frm-rincian_acara').find('input,textarea').eq(index).val();
		if(value==''){
			$('.frm-rincian_acara').find('input,textarea').eq(index).attr('data-original-title', 'Form masih Kosong');
			$('.frm-rincian_acara').find('input,textarea').eq(index).tooltip('show');
			validate++;
		}
	});

	if(validate==0){
		
		$.confirm({
			title:'',
			content:"Ketika <b>SUBMIT</b>, maka rincian acara akan di \"Hold\" dan jika anda ingin mengubah, klik <b>EDIT</b> dan list item otomatis akan di reset.",
			buttons:{
				ok:{
					text:"OK, Lanjutkan!",
					btnClass:'btn btn-primary',
					action:function(){
						$('.frm-rincian_acara').find('input,textarea').attr('disabled','disabled');
						$('.simpan').hide();
						$('.edit').show();
					}
				},close:{
					text:"Cancel"
				}
			}
		});
	}

}

function edit_detail_acara(){
	$('.frm-rincian_acara').find('input,textarea').prop('disabled',false);

	$.confirm({
		title:'',
		content:"Anda yakin ingin mengubah? Item di List akan direset.",
		buttons:{
			ok:{
				text:"OK, Lanjutkan!",
				btnClass:'btn btn-primary',
				action:function(){
					
				}
			},close:{
				text:"Cancel"
			}
		}
	});

}

var out_remark = new String();

function out_set(id,x){
	out_remark = '';
	x.prop('disabled',true);
	var status = x.is(':checked');
	if(status==true){
		status=1;
	}else{
		status=0;
	}

	$.post(URL+'transaksi/getRemarkOut/',{id:id}).done(function(data){
		out_remark = data;
		$.confirm({
			title:"",
			content:"<textarea style='width:100%;' name='remarks' placeholder='Isikan Remark'>"+out_remark+"</textarea>",
			buttons:{
				submit:{
					text:'OKE',
					btnClass:'btn btn-primary',
					action:function(){
						var self = this;
						var remark = self.$content.find('textarea[name="remarks"]').val();
						$.post(URL+'transaksi/chk_list_out/',{id:id,status:status,remark:remark}).done(function(data){
							x.prop('disabled',false);
							
						}).fail(function(e){
							x.prop('disabled',false);
						});
					}
				}
			}
		});
	}).fail();


}

var in_remark = new String();

function in_set(id,x){
	in_remark = '';
	x.prop('disabled',true);
	var status = x.is(':checked');
	if(status==true){
		status=1;
	}else{
		status=0;
	}

	$.post(URL+'transaksi/getRemarkIn/',{id:id}).done(function(data){
		in_remark = data;
		$.confirm({
			title:"",
			content:"<textarea style='width:100%;' name='remarks' placeholder='Isikan Remark'>"+in_remark+"</textarea>",
			buttons:{
				submit:{
					text:'OKE',
					btnClass:'btn btn-primary',
					action:function(){
						var self = this;
						var remark = self.$content.find('textarea[name="remarks"]').val();
						$.post(URL+'transaksi/chk_list_in/',{id:id,status:status,remark:remark}).done(function(data){
							x.prop('disabled',false);
							
						}).fail(function(e){
							x.prop('disabled',false);
						});
					}
				}
			}
		});
	}).fail();


}


function armada(id_pemesanan){
	$.confirm({
		title:'LIST ARMADA',
		content:function(){
			var self = this;
			return $.post(URL+'transaksi/getArmada/'+id_pemesanan).done(function(data){
				var ls_armada = ``;
				try{
					var res = JSON.parse(data);

					if(res.status==1){
						res.result.forEach(function(item,index){
							ls_armada+=`
								<tr>
									<td></td>
									<td>`+item.nama_armada+`</td>
									<td>`+item.plat_nomor+`</td>
									<td>`+item.jenis_armada+`</td>
									<td><button class="btn btn-sm btn-danger" onclick="delete_armada(`+item.id+`,this)"><span class="fa fa-trash"></span></button></td>
								</tr>
							`;
						});
					}else{
						ls_armada+=`
							<tr>
								<td colspan=5 style="text-align:center">DATA KOSONG</td>
							</tr>
						`;
					}
				}catch(e){
					ls_armada+=`
						<tr>
							<td colspan=5 style="text-align:center">Terjadi Error. Hubungi Administrator.</td>
						</tr>
					`;
				}

				self.setContent(`

					<table class="table table-hover table-bordered">
						<thead>
							<tr style="background-color:blue;">
								<th>#</th>
								<th>Nama Armada</th>
								<th>Plat Nomor</th>
								<th>Jenis Armada</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr style="background-color:#ccc;" id="toInsert">
								<td><input type="hidden" name="id_pemesanan" value=`+id_pemesanan+`><button disabled="disabled" class="btn btn-sm btn-success"><span class="fa fa-plus"></span></button></td>
								<td><input type="text" name="nama_armada"></td>
								<td><input type="text" name="plat_nomor"></td>
								<td><input type="text" name="jenis_armada"></td>
								<td><button class="btn btn-sm btn-success" onclick="insert_armada($(this))"><span class="fa fa-plus"></span></button></td>
							</tr>
							`+ls_armada+`
						</tbody>
					</table>
				`);
			}).fail();
		},
		columnClass:'col-md-10 col-md-offset-1',
	});
}

function insert_armada(el){
	var arrInp = el.closest('tr').find('input');

	let val = new Object();
	var kosong = 0;
	arrInp.toArray().forEach(function(item,index){
		if(arrInp.eq(index).val()==''){
			arrInp.eq(index).animate({
				backgroundColor: "#aa0000"
	        }, 100 ).animate({
				backgroundColor: "#fff"
	        }, 300 );

	        kosong++;
		}else{
			val[arrInp.eq(index).prop('name')] = arrInp.eq(index).val();
		}
	});

	if(kosong==0){
		$.post(URL+'transaksi/insertArmada',val).done(function(data){
			try{
				var res = JSON.parse(data);

				if(res.status==1){
					$.alert('Berhasil menambah data Armada.');
					el.closest('#toInsert').after(`<tr>
										<td></td>
										<td>`+res.result.nama_armada+`</td>
										<td>`+res.result.plat_nomor+`</td>
										<td>`+res.result.jenis_armada+`</td>
										<td><button class="btn btn-sm btn-danger" onclick="delete_armada(`+res.result.id+`,this)"><span class="fa fa-trash"></span></button></td>
									</tr>`);
					el.closest('tr').find('input').val('');
				}else{
					$.alert('<b style="color:red;">Error menambah data Armada.</b>');
				}
			}catch(e){
				$.alert('<b style="color:red;">Error menambah data Armada.</b>');
				console.log(e);
			}
		}).fail();
	}

}


function delete_armada(id_armada,el){
	$.confirm({
		title:'Hapus data?',
		content:'Anda yakin ingin menghapus data ini?',
		buttons:{
			ok:{
				text:'OKE',
				btnClass:'btn btn-danger',
				action:function(){
					$.post(URL+'transaksi/hapusArmada',{id_armada:id_armada}).done(function(data){
					try{
						var res = JSON.parse(data);

						if(res.status==1){
							$(el).closest('tr').remove();
							$.alert('Berhasil menghapus data Armada.');
						}else{
							$.alert('<b style="color:red;">Error menghapus data Armada.</b>');
						}
					}catch(e){
						$.alert('<b style="color:red;">Error menghapus data Armada.</b>');
					}
				}).fail();
				}
			},close:{
				text:'Batal'
			}
		}
	});
}


function make_new_item(e){
	var mk_tb_item = $('#tb_item_pemesanan').DataTable();

	e.preventDefault();
	var form = `
		<form>
			<div class="form-group">
				<label>Nama Item</label>
				<input type="text" class="form-control" name="item_name" style="text-align:center;">
			</div>

			<div class="form-group">
				<label>Harga Beli / Sewa (Per Hari)</label>
				<input type="text" class="form-control" name="harga_beli" style="text-align:center;">
			</div>

			<div class="form-group">
				<label>Harga Jual / Sewa (Per Hari)</label>
				<input type="text" class="form-control" name="harga_jual" style="text-align:center;">
			</div>
		</form>
	`;



	$.confirm({
		title:'<h4>Tambah Item baru (External)?</h4>',
		content:form,
		theme:'modern',
		type:'green',
		animation:'scale',
		buttons:{
			submit:{
				text:'Tambahkan',
				btnClass:'btn btn-primary',
				action:function(){
					var self = this;
					var dt = self.$content;

					var data_new = {
						jenis_item:"ITEM",
						is_external:1,
						pos_type:"KANTOR",
						item_name:dt.find('input[name="item_name"]').val(),
						harga_beli:dt.find('input[name="harga_beli"]').val(),
						harga_jual:dt.find('input[name="harga_jual"]').val()
					};

					var c_kosong = 0;

					Object.entries(data_new).forEach(function(item,index){
						if(item[1]==''){
							dt.find('input[name="'+item[0]+'"]').animate({backgroundColor:'red'},200).animate({backgroundColor:'white'},200);
							c_kosong++;
						}
					});

					if(c_kosong>0){
						return false;
					}else{
						$.post(URL+'produk/addExternal',{data:data_new}).done(function(data){
							try{
								var res = JSON.parse(data);

								if(res.status==1){
									$('#item_select').append(`
										<option value="`+res.result.id+`|`+res.result.barcode+`|`+res.result.item_name+`|`+res.result.qty+`|ITEM|`+res.result.harga_jual+`">`+res.result.item_name+` - `+res.result.barcode+`</option>
									`);
									$('#item_select').select2({containerCssClass : "select2-bg-color",width:'100%'});
									$('.select2-bg-color').animate({
										backgroundColor:'green'
									},400).animate({
										backgroundColor:'white'
									},400);

									$('.select2-bg-color span').animate({
										color:'white'
									},400).animate({
										color:'black'
									},400);
								}else{
									$.confirm({
										title:'',
										content:res.message,
										theme:'modern',
										type:'red',
										animation:'scale',
										icon:'fa fa-exclamation-triangle',
										buttons:{
											ok:{
												text:'OKE'
											}
										}
									});
								}
							}catch(e){
								$.confirm({
									title:'',
									content:'Gagal menambah item. Err Code : 837856',
									theme:'modern',
									type:'red',
									animation:'scale',
									icon:'fa fa-exclamation-triangle',
									buttons:{
										ok:{
											text:'OKE'
										}
									}
								});
							}
						}).fail(function(){
							$.confirm({
								title:'',
								content:'Gagal menambah item. Err Code : 7736457',
								theme:'modern',
								type:'red',
								animation:'scale',
								icon:'fa fa-exclamation-triangle',
								buttons:{
									ok:{
										text:'OKE'
									}
								}
							});
						});
					}


				}
			},cancel:{
				text:'Cancel'
			}
		}
	});
}

function anim_input(el){
	el.animate({
		backgroundColor:'red'
	},200).animate({
		backgroundColor:'white'
	},200);

	el.animate({
		color:'white'
	},200).animate({
		color:'black'
	},200);
}

function add_date(el){
	var t_awal = el.closest('#ls_tanggal_acara').find('input[name="tanggal_acara_awal"]').val();
	var t_akhir = el.closest('#ls_tanggal_acara').find('input[name="tanggal_acara_akhir"]').val();

	var dt = {
				tanggal_awal:t_awal,
				tanggal_akhir:t_akhir
			};

	var c = 0;
	if(t_awal==''){
		anim_input(el.closest('#ls_tanggal_acara').find('input[name="tanggal_acara_awal"]'));
		c++;
	}
	if(t_akhir==''){
		anim_input(el.closest('#ls_tanggal_acara').find('input[name="tanggal_acara_akhir"]'));
		c++;
	}

	if(c>0){
		return false;
	}

	var new_tanggal = `
		<tr class="local">
			<td>`+dt.tanggal_awal+`</td>
			<td>`+dt.tanggal_akhir+`</td>
			<td><button class="btn btn-danger" onclick="del_date($(this))"><span class="fa fa-trash"></span></button></td>
		</tr>
    `;

    el.closest('#ls_tanggal_acara').find('#tb_ls_tanggal tbody').append(new_tanggal);
    el.closest('#ls_tanggal_acara').find('input[name="tanggal_acara_awal"]').val('');
    el.closest('#ls_tanggal_acara').find('input[name="tanggal_acara_akhir"]').val('');
}


function del_date(el,server=null,id=null){
	if(server=='server'){
		del_date_server.push(id);
		el.parent().parent().remove();
	}else{
		el.parent().parent().remove();
	}

	console.log(del_date_server);
}