$('#tb_barang_hilang').DataTable();


function add_brg_hilang(){
	$.confirm({
		title:'Tambah Barang Hilang',
		content:function(){
			var self = this;
	        return $.post(URL+`produk/add_barang_hilang`).done(function(response){
	        	self.setContentAppend(response);
	        }).fail(function(){
	        	self.setContent('Something went wrong.');
	        });
		},buttons:{
			submit:{
				text:"SUBMIT",
				btnClass:"btn-primary",
				action:function(){
					var id = this.$content.find('select[name="id_barang"]').val();
					var serial_number = this.$content.find('input[name="serial_number"]').val();
					var keterangan = this.$content.find('textarea[name="keterangan"]').val();

					var data = {
						id_barang:id,
						serial_number:serial_number,
						keterangan:keterangan
					}

					$.confirm({
						title:"Tambah Barang Hilang",
						content:"Apakah data sudah benar?",
						buttons:{
							submit:{
								text:"Ya!",
								btnClass:"btn-primary",
								action:function(){
									startloading('Mohon tunggu...');
									$.post(URL+'produk/insert_barang_hilang',{data:data}).done(function(response){
											$.alert({
												title:"",
												content:response,
												buttons:{
													ok:{
														text:"OKE",
														action:function(){
															window.location.href = URL+'produk/barang_hilang/view';
														}
													}
												}
											});
											$('.jconfirm').remove();
											endloading();
											// window.location.href = URL+'produk/barang_hilang/view';
									}).fail(function(){
										$.alert(response);
										endloading();
									});
								}
							},cancel:{
								text:"CANCEL"
							}
						}
					});
					return false;
				}
			},cancel:{
				text:"CANCEL"
			}
		}
	});
}

function edit(x){
	$.confirm({
		title:'Tambah Barang Hilang',
		content:function(){
			var self = this;
	        return $.post(URL+`produk/edit_barang_hilang`,{id:x}).done(function(response){
	        	self.setContentAppend(response);
	        }).fail(function(){
	        	self.setContent('Something went wrong.');
	        });
		},buttons:{
			submit:{
				text:"SUBMIT",
				btnClass:"btn-primary",
				action:function(){
					var id = this.$content.find('select[name="id_barang"]').val();
					var serial_number = this.$content.find('input[name="serial_number"]').val();
					var keterangan = this.$content.find('textarea[name="keterangan"]').val();

					var data = {
						id_barang:id,
						serial_number:serial_number,
						keterangan:keterangan
					}

					$.confirm({
						title:"Edit Barang Hilang",
						content:"Apakah data sudah benar?",
						buttons:{
							submit:{
								text:"Ya!",
								btnClass:"btn-primary",
								action:function(){
									startloading('Mohon tunggu...');
									$.post(URL+'produk/rev_barang_hilang',{id_barang:x,data:data}).done(function(response){
											$.alert({
												title:"",
												content:response,
												buttons:{
													ok:{
														text:"OKE",
														action:function(){
															window.location.href = URL+'produk/barang_hilang/view';
														}
													}
												}
											});
											$('.jconfirm').remove();
											endloading();
											// window.location.href = URL+'produk/barang_hilang/view';
									}).fail(function(){
										$.alert(response);
										endloading();
									});
								}
							},cancel:{
								text:"CANCEL"
							}
						}
					});
					return false;
				}
			},cancel:{
				text:"CANCEL"
			}
		}
	});
}

function submit_barang_hilang(x){
	
}

function del(x,sn,id_item){
	
	$.confirm({
		title:"Barang sudah ditemukan?",
		content:"Apakah barang dengan serial number <h3 style='color:blue;'>"+sn+"</h3> sudah ditemukan?",
		buttons:{
			ok:{
				text:"Ya!",
				btnClass:"bg-blue",
				action:function(){
					startloading('Mohon tunggu...');
					$.post(URL+'produk/found_barang_hilang',{id_barang:x,id_item:id_item}).done(function(response){
						endloading();
						$.alert({
							title:"",
							content:response,
							buttons:{
								ok:{
									text:"OKE",
									action:function(){
										window.location.href = URL+'produk/barang_hilang/view';
									}
								}
							}
						});
					}).fail(function(){
						endloading();
					});
				}
			},close:{
				text:"Tidak",

			}

		}
	});
	
}