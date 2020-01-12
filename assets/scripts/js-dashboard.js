$(function () {
    $('#datetimepicker12').datetimepicker({
        inline: true,
        // sideBySide: true,
        // viewMode: 'years',
        format: 'DD/MM/YYYY'
    });

    // $('#tb_item_disewa').DataTable();

    $.post(URL+'home/getevent').done(function(response){
    	reminder = [];
    	if(response==''||response==null){
    		reminder = [];
    	}else{
    		reminder = JSON.parse(response);
    	}
    	
    	setTimeout(function(){
			$('#event_list').empty();
			reminder.forEach( function(el, index) {
				$('.bootstrap-datetimepicker-widget table td.day[data-day="'+el.tanggal+'"]').addClass('bg-yellow pinned');

				setTimeout(function(){
					$('#event_list').empty();

					var arrEv = $('.bootstrap-datetimepicker-widget table td.day.pinned').toArray();
					arrEv.forEach( function(element, index) {
						var tglEvent = $('.bootstrap-datetimepicker-widget table td.day.pinned').eq(index).attr('data-day');
						var date = new Date(tglEvent);

						reminder.forEach( function(val, i) {
							if(val.tanggal==tglEvent){
								val.event.forEach( function(ev1, index1) {
									// console.log(reminder);
									// $('#event_list').append('<li class="list-group-item"><button class="btn btn-xs btn-warning">'+val.full_date + '</button> - ' + ev1+'</li>');
									$('#event_list').append('<li class="list-group-item"><button class="btn btn-xs btn-warning">'+val.full_date + '</button> - <a href="#" onclick="sh_pemesanan('+ev1.id+')">' + ev1.no_pemesanan+'</a></li>');
								});
							}
						});
					});

				},100);
			});
		},1);
    }).fail(function(){

    });

	$('.bootstrap-datetimepicker-widget table').on('click',function(){
		var elem;
		setTimeout(function(){
			$('#event_list').empty();
			reminder.forEach( function(el, index) {
				$('.bootstrap-datetimepicker-widget table td.day[data-day="'+el.tanggal+'"]').addClass('bg-yellow pinned');
			});
		},1);

		setTimeout(function(){
			$('#event_list').empty();

			var arrEv = $('.bootstrap-datetimepicker-widget table td.day.pinned').toArray();
			arrEv.forEach( function(element, index) {
				var tglEvent = $('.bootstrap-datetimepicker-widget table td.day.pinned').eq(index).attr('data-day');
				var date = new Date(tglEvent);

				reminder.forEach( function(val, i) {
					if(val.tanggal==tglEvent){
						val.event.forEach( function(ev1, index1) {
							// console.log(reminder);
							$('#event_list').append('<li class="list-group-item"><button class="btn btn-xs btn-warning">'+val.full_date + '</button> - <a href="#" onclick="sh_pemesanan('+ev1.id+')">' + ev1.no_pemesanan+'</a></li>');
						});
					}
				});
			});

		},100);
	});
});


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
						<td class="t_right">` + f_cur(res[index].harga) + `</td>
						<td class="t_right">` + f_cur(parseInt(res[index].total_harga)) + `</td>
						<td class="t_right">` + f_cur(parseInt(res[index].total_harga)) + `</td>
						</tr>
					`);
					total_akhir+=parseInt(res[index].total_harga);
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