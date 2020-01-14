<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {
	function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		
		

	}
	public function index(){

	}

////#######################   PENGAJUAN ########################
	public function trx($mode=null,$id=null){
		$this->load->model('model_transaksi');
		$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$var['user_id'] = $this->model_transaksi->user_type($session_id);

		if($mode=='view'){
				$var['s_active']='pengajuan';
				$var['mode']='view';
				$var['act_button']='pengajuan';
				$var['page_title']='PENGAJUAN';
				$var['tb_pengajuan'] = $this->model_transaksi->tb_pengajuan();
		}

		if($mode=='view_penerimaan'){
				$var['s_active']='penerimaan';
				$var['mode']='view';
				$var['act_button']='penerimaan';
				$var['page_title']='PENERIMAAN';
				$var['tb_pengajuan'] = $this->model_transaksi->tb_pengajuan();
		}

		if($mode=='add'){
				$var['s_active']='pengajuan';
				$var['mode']='add';
				$var['page_title']='TAMBAH PENGAJUAN';
				$this->load->model('model_produk');
				$var['items'] = $this->model_produk->tb_item();
		}

		if($mode=='edit'){
				$this->load->model('model_produk');
				$var['s_active']='pengajuan';
				$var['mode']='edit';
				$var['page_title']='EDIT PENGAJUAN';
				$var['id']=$id;
				$var['tb_pengajuan'] = $this->model_transaksi->tb_pengajuan($id);
				$var['list'] = $this->model_transaksi->list_item_pengajuan_edit($id);
				$var['items'] = $this->model_produk->tb_item();
		}

		$var['stat_user']=$var['user_id'][0]->user_type;
		$var['user'] = $_SESSION['user_type'];
		
		$var['js'] = 'js-pengajuan';
		$var['plugin'] = 'plugin_1';
		$var['content']='view-pengajuan';
		
		
		$this->load->view('view-index',$var);
	}

	public function pengajuan_view($id=null){
		if(empty($id)){
			$id = $this->input->post('id');
		}
		$this->load->model('model_transaksi');
		$var['list_item_pengajuan'] = $this->model_transaksi->list_item_pengajuan($id);
		if($var['list_item_pengajuan']){
			echo json_encode($var['list_item_pengajuan']);
		}
	}
	public function trx_pengajuan(){
		$this->load->model('model_transaksi');
		$var['add_pengajuan'] = $this->model_transaksi->trx_pengajuan();
	}
	public function del_it_pengajuan(){
		$id = $this->input->post('id');
		
		$this->db->where('id',$id);
		$this->db->update('item_pengajuan',array('is_delete'=>1));
	}

	public function del_pengajuan(){
		$id = $this->input->post('id');
		
		$this->db->where('id',$id);
		$this->db->update('pengajuan',array('is_delete'=>1));
	}
	public function accept_pengajuan(){
		$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$id = $this->input->post('id');
		
		$this->db->where('id',$id);
		$this->db->update('pengajuan',array('status'=>1,'stat_penerimaan'=>0,'approval'=>$session_id,'approve_date'=>date('Y-m-d H:i:s')));
	}

	public function reject_pengajuan(){
		$id = $this->input->post('id');
		
		$this->db->where('id',$id);
		$this->db->update('pengajuan',array('status'=>2));
	}

	public function verifikasi($id=null){
		$this->load->model('model_transaksi');
		$var['items'] = $this->model_transaksi->list_item_pengajuan($id);
		$this->load->view('view-verifikasi_part',$var);
	}
//##########################   PENERIMAAN    ###########################

	public function update_it_pn(){
		$id = $this->input->post('id');
		$jml = $this->input->post('jml');
		$id_item = $this->input->post('id_item');
		$qty = $this->input->post('qty');
		
		$this->db->where('id',$id);
		$this->db->update('item_pengajuan',array('qty_masuk'=>$jml));

		$q = $this->db->select('qty')->where('id', $id_item)->get('pos_item');
		$qtyDB = $q->row()->qty;

		$this->db->where('id',$id_item);
		$this->db->update('pos_item',array('qty'=>$qtyDB+$qty));
		

	}

	public function update_stat_penerimaan(){
		$id = $this->input->post('id');
		$data = array(
						'stat_penerimaan'=>1,
						'receiver'=>$_SESSION['id_user'],
						'receive_date'=>date('Y-m-d H:i:s'),
						'update_by'=>$_SESSION['id_user'],


					);
		
		$this->db->where('id',$id);
		$this->db->update('pengajuan',$data);
	}

	public function verifikasi_penerimaan(){
		$dt = $this->input->post('items');
		//print_r($dt);
		$c_it = count($dt);
		$c_itDB = count($dt);
		foreach ($dt as $key => $value) {
			$this->db->where('id',$value['id_it_pn']);
			$this->db->update('item_pengajuan',array('qty_masuk'=>$value['qty_masuk']));

			

			if($value['qty_masuk']==$value['qty']){
				$c_it--;
			}

			// $this->db->where('id',$val['id_item']);
			// $this->db->update('pos_item',array('qty'=>$qtyDB+$qty));
		}

		if($c_it==0){
			$data = array(
						'stat_penerimaan'=>1,
						'receiver'=>$_SESSION['id_user'],
						'receive_date'=>date('Y-m-d H:i:s'),
						'update_by'=>$_SESSION['id_user'],


					);
		
			$this->db->where('id',$dt[0]['id']);
			$u_pengajuan = $this->db->update('pengajuan',$data);

			if($u_pengajuan){

				foreach ($dt as $key => $value) {
					$q = $this->db->select('qty')->where('id', $value['id_item'])->get('pos_item');
					$qtyDB = $q->row()->qty;

					$this->db->where('id',$value['id_item']);
					$u_item = $this->db->update('pos_item',array('qty'=>$qtyDB+$value['qty_masuk']));
					if($u_item){
						$c_itDB--;
					}
				}

				if($c_itDB == 0){
					echo '{"status":1,"message":"Data telah lengkap, item sudah ditambahkan. Verifikasi sukses."}';
				}else{
					echo '{"status":-3,"message":"Error saat menambahkan ke item."}';
				}
				
			}else{
				echo '{"status":-1,"message":"Error saat memverifikasi penerimaan."}';
			}
		}else{
			echo '{"status":2,"message":"Sukses memverifikasi item(s)"}';
		}
		

		
	}
//##########################   PEMESANAN    ###########################
	public function pemesanan($mode=null,$id=null){
		$this->load->model('model_transaksi');
		$this->load->model('model_user');
		$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		// $var['user_id'] = $this->model_transaksi->user_type($session_id);
		// $var['stat_user']=$var['user_id'][0]->user_type;
		$var['user'] = $_SESSION['user_type'];
		$var['id_user'] = $_SESSION['id_user'];

		if($mode=='view'){
			$var['s_active']='pemesanan';
			$var['mode']='view';
			$var['act_button']='pemesanan';
			$var['page_title']='FILE PRODUKSI';
			

			$var['tb_pemesanan'] = $this->model_transaksi->tb_pemesanan_view('pemesanan');
						
			if(!empty($var['tb_pemesanan'])){
				$no = '';
				foreach ($var['tb_pemesanan'] as $key => $value) {
					//$crew_t = $this->model_transaksi->crew_assigned($value->id_pemesanan);
					$value->crew= $this->model_transaksi->crew_assigned($value->id_pemesanan);
					$value->crew_txt= '<h4><b>LIST CREW : </b></h4>';
					
					// print_r($value->crew);
					//$c_arr = json_decode(json_encode($value->crew),true);
					// print_r($c_arr[$key(array)ey]);
					if(!empty($value->crew)){
						foreach ($value->crew as $k_key => $k_value) {
							if($k_value->is_driver==1){
								$value->crew_txt .='<b>Driver</b><br>';
								$value->crew_txt .= $k_value->name . "<br><br>";
								//$no++;
							}
						}

						$value->crew_txt .='<b>Crew</b><br>';
						foreach ($value->crew as $k_key => $k_value) {
							if($k_value->is_driver!=1){
								$value->crew_txt .= $k_value->name ."<br>";
								//$no++;
							}

						}
					}else{
						$value->crew_txt = "Crew masih kosong. Silahkan memilih crew.";
					}
					
				}

			}
			


			// print_r($var['tb_pemesanan']);
			
			$var['list_kurir'] = $this->model_user->list_kurir();

			$var['stat_pemesanan'][0]=array('color'=>'bg-red','status'=>'Waiting Approval'); //Order Received
			$var['stat_pemesanan'][1]=array('color'=>'bg-darken-2','status'=>'Order Received');
			$var['stat_pemesanan'][2]=array('color'=>'bg-yellow','status'=>'Courir Assigned'); //Courir Assigned
			$var['stat_pemesanan'][3]=array('color'=>'bg-aqua','status'=>'Prepare Item'); //Packing Done
			$var['stat_pemesanan'][4]=array('color'=>'bg-blue','status'=>'Courier On The Way'); //Courier On The Way
			$var['stat_pemesanan'][5]=array('color'=>'btn-success','status'=>'Done');
			$var['stat_pemesanan'][6]=array('color'=>'btn-danger','status'=>'Cancel');


			$var['stat_kurir'][3]=array('color'=>'bg-aqua','status'=>'Prepare Item'); //Packing Done
			$var['stat_kurir'][4]=array('color'=>'bg-blue','status'=>'Courier On The Way'); //Courier On The Way
			$var['stat_kurir'][5]=array('color'=>'btn-success','status'=>'Done');
			//$var['stat_kurir'][5]=array('color'=>'btn-danger','status'=>'Cancel');
			// $var['stat_per_id'][2]=[];


			// $i=$var['ck_ls'][0]->status+1; //1
			// for($i; $i<=5; $i++){
			// 	array_push($var['send_data'][2], $var['stat_pemesanan'][$i]);
			// }
			
		}	

		if($mode=='view_penawaran'){
			$var['s_active']='penawaran';
			$var['mode']='view';
			$var['act_button']='penawaran';
			$var['page_title']='PENAWARAN';
			

			$var['tb_pemesanan'] = $this->model_transaksi->tb_pemesanan_view('penawaran');
			
			if(!empty($var['tb_pemesanan'])){
				foreach ($var['tb_pemesanan'] as $key => $value) {
					//$crew_t = $this->model_transaksi->crew_assigned($value->id_pemesanan);
					$value->crew= $this->model_transaksi->crew_assigned($value->id_pemesanan);
					$value->crew_txt= '<h4><b>LIST CREW : </b></h4>';
					
					// print_r($value->crew);
					//$c_arr = json_decode(json_encode($value->crew),true);
					// print_r($c_arr[$key(array)ey]);
					if(!empty($value->crew)){
						foreach ($value->crew as $k_key => $k_value) {
							//print_r($value->crew);
							$value->crew_txt .= ($k_key+1) . ". " .$k_value->name . "<br>";
							// print_r($c_arr);
						}
					}else{
						$value->crew_txt = "Crew masih kosong. Silahkan memilih crew.";
					}
					
				}

			}
			


			// print_r($var['tb_pemesanan']);
			
			$var['list_kurir'] = $this->model_user->list_kurir();

			$var['stat_pemesanan'][0]=array('color'=>'bg-yellow','status'=>'Pending'); //Order Received
			$var['stat_pemesanan'][1]=array('color'=>'bg-aqua','status'=>'On Progress');
			$var['stat_pemesanan'][2]=array('color'=>'bg-blue','status'=>'Negotiation'); //Courir Assigned
			$var['stat_pemesanan'][3]=array('color'=>'btn-success','status'=>'Done'); //Packing Done
			$var['stat_pemesanan'][4]=array('color'=>'btn-danger','status'=>'Decline'); //Courier On The Way
			// $var['stat_pemesanan'][5]=array('color'=>'btn-success','status'=>'Done');
			// $var['stat_pemesanan'][6]=array('color'=>'btn-danger','status'=>'Cancel');


			$var['stat_kurir'][3]=array('color'=>'bg-aqua','status'=>'Prepare Item'); //Packing Done
			$var['stat_kurir'][4]=array('color'=>'bg-blue','status'=>'Courier On The Way'); //Courier On The Way
			$var['stat_kurir'][5]=array('color'=>'btn-success','status'=>'Done');
			//$var['stat_kurir'][5]=array('color'=>'btn-danger','status'=>'Cancel');
			// $var['stat_per_id'][2]=[];


			// $i=$var['ck_ls'][0]->status+1; //1
			// for($i; $i<=5; $i++){
			// 	array_push($var['send_data'][2], $var['stat_pemesanan'][$i]);
			// }
			
		}

		if($mode=='add'){
			$var['s_active']=$_GET['type'];
			$var['mode']='add';
			$var['type']=$_GET['type'];

			$var['page_title']='TAMBAH ' . strtoupper($_GET['type']);
			
			
			$this->load->model('model_user');
			$this->load->model('model_produk');
			$this->load->model('model_transaksi');

			$var['list_customer'] = $this->model_user->list_customer();
			$var['items'] = $this->model_produk->tb_item_for_pemesanan();
			$var['extra'] = $this->model_transaksi->extra_charge();
			$var['durasi'] = $this->model_transaksi->durasi();
			$var['items_arr'] = json_decode(json_encode($var['items']),true);
			//print_r($var['items']);
			$var['it_bc'] = [];

			if(!array_key_exists('status', $var['items'])){
				foreach ($var['items_arr'] as $in => $value) {
					$var['it_bc'][$in]['id'] = $value['ID_ITEM'];
					$var['it_bc'][$in]['barcode'] = $value['barcode'];
					$var['it_bc'][$in]['nama_item'] = $value['nama_item'];
				}
			}

			//echo count($var['it_bc']);
			
		}

		if($mode=='edit'){
				$this->load->model('model_produk');
				$var['nego'] = !empty($_GET['nego']) ? $_GET['nego']:'';
				$var['s_active']=$_GET['type'];
				$var['mode']='edit';
				$var['page_title']='EDIT '. strtoupper($_GET['type']);
				$var['id']=$id;
				$var['it_bc'] = [];

				$this->load->model('model_user');
				$this->load->model('model_produk');
				$this->load->model('model_transaksi');

				$var['tb_pemesanan'] = $this->model_transaksi->tb_pemesanan($id);
				$var['list'] = $this->model_transaksi->list_item_pemesanan_edit($id);
				$var['list_customer'] = $this->model_user->list_customer();
				$var['ls_tgl_acara'] = $this->db->get_where('tanggal_acara',array('id_pemesanan'=>$id,'is_delete'=>0))->result();
				// $var['items'] = $this->model_produk->tb_item_is_av();
				$var['items'] = $this->model_produk->tb_item_for_pemesanan();
				$var['extra'] = $this->model_transaksi->extra_charge();
				//print_r($var['tb_pemesanan']);
		}


		$var['js'] = 'js-pemesanan';
		$var['plugin'] = 'plugin_1';
		$var['content']='view-pemesanan';
		
		$this->load->view('view-index',$var);
	}

	public function chk_crew($id_pemesanan){
		$this->load->model('model_transaksi');
		$var['crew_assigned'] = $this->model_transaksi->crew_assigned($id_pemesanan);
		$crew = '';

		if(!empty($var['crew_assigned'])){
			foreach ($var['crew_assigned'] as $k_key => $k_value) {
				if($k_value->is_driver==1){
					$crew .='<b>Driver</b><br>';
					$crew .= $k_value->name . "<br><br>";
					//$no++;
				}
			}

			$crew .='<b>Crew</b><br>';
			foreach ($var['crew_assigned'] as $k_key => $k_value) {
				if($k_value->is_driver!=1){
					$crew .= $k_value->name ."<br>";
					//$no++;
				}

			}
		}else{
			$crew = "";
		}

		echo $crew;
	}



	public function trx_pemesanan(){
		echo $this->input->post('idd');
		$this->load->model('model_transaksi');
		$var['add_pengajuan'] = $this->model_transaksi->trx_pemesanan();

		$kirim = !empty($_POST['kirim']) ? ($_POST['kirim']==1 ? 1:null):null;

		if($kirim==1){
			$this->load->library('mail');
			$this->load->model('model_customer');
			$this->load->model('model_transaksi');

			$customer = $this->model_transaksi->getCustomerFromPemesanan($_POST['id']);
			$id_customer = $customer->row()->id_pemesan;

			$customer = $this->model_customer->getCustomer($id_customer);
			
			$mail = $this->gen_excel($_POST['id'],'NEGOSIASI');

			if($mail){				
				echo $var['add_pengajuan'];
			}else{
				echo '{"status":"1","message":"Sukses mengubah data"}';
			}
			
		}else{
			echo $var['add_pengajuan'];
		}


	}

	public function pemesanan_view(){
		$this->load->model('model_transaksi');
		$var['list_item_pemesanan'] = $this->model_transaksi->list_item_pemesanan();
		$var['ls_tgl'] = $this->db->get_where('tanggal_acara',array('id_pemesanan'=>$_POST['id'],'is_delete'=>0))->result();

		$var['ls_tgl_acara'] = [];

		if(!empty($var['ls_tgl'])){
			foreach ($var['ls_tgl'] as $key => $value) {
				// echo $value->tanggal_awal;
				array_push($var['ls_tgl_acara'],array(
					'tanggal_awal'=>date('d M Y',strtotime($value->tanggal_awal)),
					'tanggal_akhir'=>date('d M Y',strtotime($value->tanggal_akhir))
				));
			}
		}

		// print_r($var['ls_tgl_acara']);

		if(!empty($var['list_item_pemesanan'])){
			foreach ($var['list_item_pemesanan'] as $key => $value) {
				$var['list_item_pemesanan'][$key]->ls_tanggal_acara = $var['ls_tgl_acara'];
			}
		}

		if($var['list_item_pemesanan']){
			echo json_encode($var['list_item_pemesanan']);
		}
	}

	public function getCrew($id_pemesanan=null){
		$arr_crew = $this->db->query("select c.id_kurir from crew_pemesanan as c join user as u where u.id=c.id_kurir and id_pemesanan=".$id_pemesanan)->result();
		$crews = [];
		foreach ($arr_crew as $key => $value) {
			array_push($crews, $value->id_kurir);
		}
	}

	public function del_it_pemesanan(){
		$id = $this->input->post('id');
		
		$this->db->where('id',$id);
		$this->db->update('item_pemesanan',array('is_delete'=>1));
	}

	public function add_kurir(){
		$id = $this->input->post('id_kurir');
		$id_pem = $this->input->post('id_pem');
		$data = array(
						'id'=>$id_pem,
						// 'status'=>2,
						'id_kurir'=>$id,
						'add_kurir_date'=>date('Y-m-d H:i:s'),
						'add_kurir_by'=>$_SESSION['id_user']
					);
		$this->db->where('id',$id_pem);
		$act = $this->db->update('pemesanan',$data);

		if($act){
			echo json_encode(array('status'=>'success','message'=>'Sukses Mengubah Data'));
		}else{
			echo json_encode(array('status'=>'error','message'=>'Error Mengubah Data, Silahkan coba kembali'));
		}
	}

	public function acc_order(){
		$id = $this->input->post('id');

		$this->load->model('model_transaksi');
		$ls_item = $this->model_transaksi->list_item_pemesanan($id);

		$stat = 0;

		$error_message = array('status'=>'error','message'=>[]);

		foreach ($ls_item as $key => $val) {
			if($val->jenis_item=='ITEM' || $val->jenis_item=='PAKET'){

				$jenis = $this->db->select('id,qty,barcode,item_name,jenis_item,is_external')->where('id',$val['id_item'])->get('pos_item');
				// print_r($jenis);
				if($jenis->row()->jenis_item=='ITEM'){
					$stock_item = $this->db->select('id,qty,barcode,item_name,jenis_item,is_external')->where('id',$val['id_item'])->get('pos_item');
					if(((int)$stock_item->row()->qty<=0 && $stock_item->row()->is_external==0)){
						array_push($error_message['message'],array('status'=>-1,'message'=>'Stock item <b>'.$val['item_name'].'</b> dengan barcode <b>'.$val['barcode'].'</b> <b style="color:red;">tidak tersedia</b>.'));
					}else{
						if((int)$stock_item->row()->qty<$val['qty'] && $stock_item->row()->is_external==0){
							array_push($error_message['message'],array('status'=>-2,'message'=>'Stock item <b>'.$val['item_name'].'</b> saat ini dengan barcode <b>'.$val['barcode'].'</b> <b style="color:red;">kurang dari jumlah pemesanan</b>.'));
						}else{
							$stat++;
												
						}
					}
				}

				// echo $jenis->row()->jenis_item;
				if($jenis->row()->jenis_item=='PAKET'){
					$stat_item = 0;
					$id_paket = $this->db->select('id,qty,barcode,item_name,jenis_item')->where('id',$val['id_item'])->get('pos_item');
					
					$this->load->model('Model_produk');
					$ls_item_paket = json_decode(json_encode($this->Model_produk->list_item_paket($id_paket->row()->id)),true);
					

					foreach ($ls_item_paket as $key => $val_item_paket) {

						//print_r($val_item_paket);
						if((int)$val_item_paket['stock']<=0){
							array_push($error_message['message'],array('status'=>-1,'message'=>'Stock item <b>'.$val_item_paket['item_name'].'</b> dengan barcode <b>'.$val_item_paket['barcode'].'</b> pada Paket "'.$val['item_name'].'" <b style="color:red;">tidak tersedia</b>.'));
						}else{
							if((int)$val_item_paket['stock']<($val_item_paket['item_qty']*(int)$val['qty'])){
								array_push($error_message['message'],array('status'=>-2,'message'=>'Stock item <b>'.$val_item_paket['item_name'].'</b> saat ini dengan barcode <b>'.$val_item_paket['barcode'].'</b> pada Paket "'.$val['item_name'].'" <b style="color:red;">kurang dari jumlah pemesanan</b>.'));
							}else{
								// echo "SUK";
								$stat_item++;
													
							}
						}
					}

					if($stat_item==count($ls_item_paket)){
						$stat++;
					}

				}
			}

			if($val->is_free==1){
				$stat++;
			}
		}


		//print_r($ls_item);
		//echo $stat.'>>'.count($ls_item);

			if($stat==count($ls_item)){
				
				if(1+2==4){ //DELETE SYNTAX UNTUK MEMFUNGSIKANNYA
					foreach ($ls_item as $k => $v) {
						if($v['jenis_item']=='ITEM'){
							$this->db->set('qty','qty-'.$v['qty'],false);
							$this->db->where('id',$v['id_item']);
							$act_item = $this->db->update('pos_item');	
						}

						
						if($v['jenis_item']=='PAKET'){
							$this->load->model('Model_produk');
							$ls_it_pkt = json_decode(json_encode($this->Model_produk->list_item_paket($v['id_item'])),true);
							
							foreach ($ls_it_pkt as $key => $v_pkt) {
								$this->db->set('qty','qty-'.($v['qty']*$v_pkt['item_qty']),false);
								$this->db->where('id',$v_pkt['ID_ITEM']);
								$act_item = $this->db->update('pos_item');
							}
								

						}				
					}
				}
			
			
				$data = array(
								'status'=>1
							);
				$this->db->where('id',$id);
				$act = $this->db->update('pemesanan',$data);

				if($act){
					echo json_encode(array('status'=>'success','message'=>'Sukses Mengubah Data'));

					$this->load->library('log_status');
					$jenis_pemesanan = $this->db->where('id',$id)->select('jenis')->get('pemesanan');

					$log = $this->log_status->add_log($id,1,$jenis_pemesanan->row()->jenis);
					$this->db->insert('log_status_pemesanan',$log);
				}else{
					echo json_encode(array('status'=>'error','message'=>array(0=>array('status'=>'error','message'=>'Error DB. Err Code (7676)'))));
				}
			}else{
				echo json_encode($error_message);
			}
		
		
	}

	public function ck_stat($get=null){
		$dt = $this->input->post('dt');

		$this->load->model('model_transaksi');
		$var['ck_stat'] = $this->model_transaksi->ck_stat();

		
		$dt_post = json_decode(json_encode($dt),true);
		$dt_arr = json_decode(json_encode($var['ck_stat']),true);


		//print_r($dt_arr);
		

		if($get=='get'){
			if($var['ck_stat']){
				$id = $this->input->post('id');
				$this->load->model('model_transaksi');
				$var['ck_ls'] = $this->model_transaksi->list_item_pemesanan_edit($id);
				//var_dump($var['ck_ls']);
				$stat[0]=array('color'=>'bg-red','status'=>'Waiting Approval'); //Order Received
				$stat[1]=array('color'=>'bg-darken-2','status'=>'Order Received');
				$stat[2]=array('color'=>'bg-yellow','status'=>'Courir Assigned'); //Courir Assigned
				$stat[3]=array('color'=>'bg-aqua','status'=>'Prepare Item'); //Packing Done
				$stat[4]=array('color'=>'bg-blue','status'=>'Courier On The Way'); //Courier On The Way
				$stat[5]=array('color'=>'btn-success','status'=>'Done');
				$stat[6]=array('color'=>'btn-danger','status'=>'Cancel');
				//print_r($var['ck_']);


				

				$var['send_data'][0]=$var['ck_stat'];
				$var['send_data'][1]=$var['ck_ls'];
				$var['send_data'][2]=[];
				


				$i=$var['ck_ls'][0]->status; 
				
				array_push($var['send_data'][2], $stat[$i]);

				echo json_encode($var['send_data']);
			}
		}else{
			foreach ($dt_post as $key => $value) {
				$d1 = $dt_post[$key]['id'] . '-' . $dt_post[$key]['status'];
				$d2 = $dt_arr[$key]['id'] . '-' . $dt_arr[$key]['status'];

				if($d1!=$d2){
					echo json_encode($dt_arr[$key]);
				}
			}
		}
	}

	public function pemesanan_btn_act($id=null,$status=null){
		$var['s']=$status;
		$var['id_pem']=$id;
		$var['user']=$_SESSION['user_type'];
		
		$this->load->view('view-pemesanan_btn_act',$var);
	}

	public function user_info_pemesanan(){
		$id = $_POST['id'];
		$var['user']=$this->db->where('id',$id)->select('*')->get('user');
		// print_r($var['user']->row()->name);

		$this->load->view('view-user_info',$var);
	}

	public function extra_charge_view(){
		$var['s_active']='extra';
		$var['page_title']='EXTRA CHARGE';
		$var['user'] = $_SESSION['user_type'];
		$var['content'] = 'view-extra_charge';
		$var['plugin'] = 'plugin_1';
		$var['js'] = 'js-extra';
		$this->load->model('model_transaksi');
		$var['tb_extra'] = $this->model_transaksi->extra_charge();

		$this->load->view('view-index',$var);
	}

	public function extra_charge($mode=null){
		$id = $this->input->post('id');
		$data = $this->input->post('data');


		$data[0]['insert_by']=$_SESSION['id_user'];
		$data[0]['update_by']=$_SESSION['id_user'];

		if($mode=='add'){
			$insert = $this->db->insert('extra_charge',$data[0]);
			$insert_last_id = $this->db->insert_id();
			if($insert){
				echo '{"status":1,"message":"Sukses Menambahkan Data Service"}';
			}else{
				echo '{"status":0,"message":"Error saat menambahkan data Service"}';
			}
		}

		if($mode=='edit'){
			$this->db->where('id',$id);
			$update = $this->db->update('extra_charge',$data[0]);

			if($update){
				echo '{"status":1,"message":"Sukses Mengubah Data Service"}';
			}else{
				echo '{"status":0,"message":"Error saat mengubah data Service"}';
			}
		}
	}

	public function extra_charge_del(){
		$id = $this->input->post('id');

		$data[0]['update_by'] = $_SESSION['id_user'];
		$data[0]['delete_by'] = $_SESSION['id_user'];
		$data[0]['delete_date'] = date('Y-m-d hh:mm:ss');
		$data[0]['is_delete'] = 1;

		$this->db->where('id',$id);
		$insert = $this->db->update('extra_charge',$data[0]);

		if($insert){
			echo '{"status":1,"message":"Sukses Menghapus Data Extra Charge"}';
		}else{
			echo '{"status":0,"message":"Error saat menghapus data Extra Charge"}';
		}
	}

	public function insert_kurir(){
		$data = $this->input->post('data');
		$is_driver = $this->input->post('is_driver');

		$ck_id = $this->db->query("select id from crew_pemesanan where is_delete=0 and id_pemesanan=".$data[0]['id_pemesanan']);

		if(!empty($ck_id)){
			if($is_driver==1){
				$update = $this->db->where('id_pemesanan',$data[0]['id_pemesanan'])->where('is_driver',1)->update('crew_pemesanan',array('is_delete'=>1));
			}else{
				$update = $this->db->where('id_pemesanan',$data[0]['id_pemesanan'])->where('is_driver',0)->update('crew_pemesanan',array('is_delete'=>1));
			}

			if($update){
				$insert = $this->db->insert_batch('crew_pemesanan',$data);
				$insert_id = $this->db->insert_id();
				if($insert){
					echo '{"status":1,"message":"Sukses menambahkan Crew"}';

					$this->load->library('log_status');
					$jenis_pemesanan = $this->db->where('id',$data[0]['id_pemesanan'])->select('jenis')->get('pemesanan');

					$log = $this->log_status->add_log($data[0]['id_pemesanan'],2,$jenis_pemesanan->row()->jenis);
					$this->db->insert('log_status_pemesanan',$log);
				}else{
					// $this->db->where('id',$data[0]['id_pemesanan']);
					// $update = $this->db->update('pemesanan',array('status'=>1));
					echo '{"status":0,"message":"Gagal menambahkan Crew"}';
				}
			}else{
				echo '{"status":-1,"message":"Gagal mengubah status pemesanan."}';
			}

		}else{
			foreach ($data as $key => $value) {
				$data[$key]['insert_by'] = $_SESSION['id_user'];
				$data[$key]['update_by'] = $_SESSION['id_user'];
			}
			

			$this->db->where('id',$data[0]['id_pemesanan']);
			$update = $this->db->update('pemesanan',array('status'=>2));

			if($update){
				$insert = $this->db->insert_batch('crew_pemesanan',$data);
				$insert_id = $this->db->insert_id();
				if($insert){
					echo '{"status":1,"message":"Sukses menambahkan Crew"}';

					$this->load->library('log_status');
					$jenis_pemesanan = $this->db->where('id',$data[0]['id_pemesanan'])->select('jenis')->get('pemesanan');

					$log = $this->log_status->add_log($data[0]['id_pemesanan'],2,$jenis_pemesanan->row()->jenis);
					$this->db->insert('log_status_pemesanan',$log);
				}else{
					$this->db->where('id',$data[0]['id_pemesanan']);
					$update = $this->db->update('pemesanan',array('status'=>1));
					echo '{"status":0,"message":"Gagal menambahkan Crew"}';
				}
			}else{
				echo '{"status":-1,"message":"Gagal mengubah status pemesanan."}';
			}
		}

	}

	public function verifikasi_crew(){
		$id_pemesanan = $_POST['id'];
	
		$update = $this->db->where('id',$id_pemesanan)->update('pemesanan',array('status'=>2));

		if($update){
			echo '{"status":1,"message":"Sukses menambahkan Crew"}';

			$this->load->library('log_status');
			$jenis_pemesanan = $this->db->where('id',$id_pemesanan)->select('jenis')->get('pemesanan');

			$log = $this->log_status->add_log($id_pemesanan,2,$jenis_pemesanan->row()->jenis);
			$this->db->insert('log_status_pemesanan',$log);
		}else{
			$this->db->where('id',$id_pemesanan)->update('pemesanan',array('status'=>1));
			echo '{"status":0,"message":"Gagal menambahkan Crew"}';
		}

	}

	public function ch_stat_from_admin(){
		$id_pem = $this->input->post('id');
		$stat = $this->input->post('stat');
		//KIRIM EMAIL
		//$id_pem = $this->input->post('id_pem');
		$data = array(
						'id'=>$id_pem,
						'status'=>$stat,
						'update_by'=>$_SESSION['id_user']
					);
		$this->db->where('id',$id_pem);
		$act = $this->db->update('pemesanan',$data);

		$msg = [];
		$st = [];

		$msg[0] = "Sukses Mengubah Data<br>";
		$msg[1] = "Email Terkirim<br>";
		$msg[2] = "Gagal mengubah data<br>";
		$msg[3] = "Gagal mengirim email<br>";
		$st[0] = 'error';
		$st[1] = 'success';

		$messageStat;
		$status;

		if($act){
			$status = $st[1];
			$messageStat = $msg[0];

			if($act && $stat==1){
				// $this->load->library('mail');
				$this->load->model('model_customer');
				$this->load->model('model_transaksi');

				$customer = $this->model_transaksi->getCustomerFromPemesanan($id_pem);
				$id_customer = $customer->row()->id_pemesan;

				$customer = $this->model_customer->getCustomer($id_customer);

				$mail = $this->gen_excel($id_pem,'APPROVE'); //GENERATE EXCEL AND SEND
				// $mail = $this->mail->sendNego($customer->row()->email,$customer->row()->name,'APPROVE PENAWARAN','THIS HTML');

				if($mail){
					$status = $st[1];
					$messageStat.=$msg[1];
					

					
				}else{
					$status = $st[1];
					$messageStat.=$msg[3];
				}
			}

			$this->load->library('log_status');
			$jenis_pemesanan = $this->db->where('id',$id_pem)->select('jenis')->get('pemesanan');

			$log = $this->log_status->add_log($id_pem,$stat,$jenis_pemesanan->row()->jenis);
			$this->db->insert('log_status_pemesanan',$log);
		}else{
			$status = $st[0];
			$messageStat = $msg[2];
			// echo json_encode(array('status'=>'error','message'=>'Error Mengubah Data, Silahkan coba kembali'));
		}

		echo json_encode(array('status'=>$status,'message'=>$messageStat));
	}

	public function cetak_pengajuan($id=null){
		$this->load->library('m_pdf');
        
        
        $this->load->model('model_transaksi');
        $val['items']=$this->model_transaksi->list_item_pengajuan($id);

        if(!empty($val['items'])){
        	$date = date_create($val['items'][0]->update_date);
			$val['date']=date_format($date,"d-M-Y");
        }
        
        $this->load->view('view-print_pengajuan',$val);
        $html = $this->load->view('view-print_pengajuan',$val,TRUE);


        

        // if(!empty($mode)){
	        $css = [];

	        // array_push($css, file_get_contents(base_url('assets/dist/css/AdminLTE.min.css')));
	        // array_push($css, file_get_contents(base_url('assets/plugins/bootstrap/dist/css/bootstrap.min.css')));

	        $pdfFilePath = "hasil.pdf";

	        $pdf = $this->m_pdf->load();
	       	// $mpdf = new Mpdf(['format' => 'Legal']);

	        $pdf->AddPage('P','','','','','','','','',20,20);
	        foreach ($css as $key => $v) {
	        	$pdf->WriteHTML($v, 1);
	        }
	        
	        $pdf->WriteHTML($html);

	        $pdf->Output($pdfFilePath, "D");
	        exit();

        // }
	}

	public function cetak_penerimaan($id=null){
		$this->load->library('m_pdf');
        
        
        $this->load->model('model_transaksi');
        $val['items']=$this->model_transaksi->list_item_pengajuan($id);

        if(!empty($val['items'])){
        	$date = date_create($val['items'][0]->update_date);
			$val['date']=date_format($date,"d-M-Y");
			$val['no_pengajuan']=$val['items'][0]->no_pengajuan;

	        $this->load->view('view-print_spb',$val);
	        $html = $this->load->view('view-print_spb',$val,TRUE);

	        $css = [];

	        // array_push($css, file_get_contents(base_url('assets/dist/css/AdminLTE.min.css')));
	        // array_push($css, file_get_contents(base_url('assets/plugins/bootstrap/dist/css/bootstrap.min.css')));

	        $pdfFilePath = "SPB_".$val['no_pengajuan'].".pdf";

	        $pdf = $this->m_pdf->load();
	       	// $mpdf = new Mpdf(['format' => 'Legal']);

	        $pdf->AddPage('P','','','','','','','','',20,20);
	        foreach ($css as $key => $v) {
	        	$pdf->WriteHTML($v, 1);
	        }
	        
	        $pdf->WriteHTML($html);

	        $pdf->Output($pdfFilePath, "D");
	        exit();

        }
	}

	public function confirm_to_production(){
		// $id = $this->input->post('id_kurir');
		$id = $this->input->post('id');
		$data = array(
						'jenis'=>'pemesanan',
						'status'=>0
					);
		$this->db->where('id',$id);
		$act = $this->db->update('pemesanan',$data);

		if($act){
			echo json_encode(array('status'=>1,'message'=>'Sukses Mengubah Data'));
		}else{
			echo json_encode(array('status'=>0,'message'=>'Error Mengubah Data, Silahkan coba kembali'));
		}
	}

	public function log_status_detail(){
		$id=$this->input->post('id_pemesanan');

		$this->db->where('id_pemesanan',$id);
		$log = $this->db->select('*')->get('log_status_pemesanan');

		if($log->num_rows()>0){
			echo json_encode($log->result());	
		}
		
	}

	public function sendNego(){
		$id_customer = !empty($_GET['id_customer']) ? $_GET['id_customer']:'';


		$this->load->library('mail');
		echo $this->mail->sendNego('bootlooplagi@gmail.com','Bootloop','Registrasi Akun Karyawan','hahahahha');
	}

	public function cetak_penawaran($type=null,$id=null){
		$this->load->library('m_pdf');
        
        $css = [];

        $pdfFilePath = "hasil.pdf";

        $pdf = $this->m_pdf->load();
       	// $mpdf = new Mpdf(['format' => 'Legal']);

        $pdf->AddPage('P','','','','','','','','',20,20);
        
        
        $pdf->WriteHTML('DOKUMEN INI ADALAH HASIL PENAWARAN');

        $pdf->Output($pdfFilePath, "F");

        $file = "hasil.pdf";

		if (!unlink($file)){
			echo ("Error deleting $file");
		}else{
		  	echo ("Deleted $file");
		}

			  

        // }
	}

	public function cetak_produksi($id=null){
		$this->load->library('m_pdf');

		$this->load->model('model_transaksi');
        
		$var['r']=$this->model_transaksi->list_item_pemesanan($id);

		$var['ls_tgl'] = $this->db->get_where('tanggal_acara',array('id_pemesanan'=>$id,'is_delete'=>0))->result();

		$var['ls_tgl_acara'] = [];

		if(!empty($var['ls_tgl'])){
			foreach ($var['ls_tgl'] as $key => $value) {
				// echo $value->tanggal_awal;
				array_push($var['ls_tgl_acara'],array(
					'tanggal_awal'=>date('d M Y',strtotime($value->tanggal_awal)),
					'tanggal_akhir'=>date('d M Y',strtotime($value->tanggal_akhir))
				));
			}
		}

        $css = [];

        $pdfFilePath = "Penawaran_".$var['r'][0]->no_pemesanan.".pdf";

        $pdf = $this->m_pdf->load();
       	// $mpdf = new Mpdf(['format' => 'Legal']);

        $pdf->AddPage('P','','','','','','','','',20,20);
        
        
        $pdf->WriteHTML($this->load->view('view-print_penawaran_produksi',$var,TRUE));

        $pdf->Output($pdfFilePath, "D");



		// $var['s']='';
  //       $this->load->view('view-print_penawaran_produksi',$var);

	}	

	public function cetak_surat_jalan($id=null){
		$this->load->library('m_pdf');

		$this->load->model('model_transaksi');
        
		$var['r']=$this->model_transaksi->list_item_pemesanan($id);

		$var['ls_tgl'] = $this->db->get_where('tanggal_acara',array('id_pemesanan'=>$id,'is_delete'=>0))->result();

		$var['ls_tgl_acara'] = [];

		if(!empty($var['ls_tgl'])){
			foreach ($var['ls_tgl'] as $key => $value) {
				// echo $value->tanggal_awal;
				array_push($var['ls_tgl_acara'],array(
					'tanggal_awal'=>date('d M Y',strtotime($value->tanggal_awal)),
					'tanggal_akhir'=>date('d M Y',strtotime($value->tanggal_akhir))
				));
			}
		}

        $css = [];

        $pdfFilePath = "Production.pdf";

        $pdf = $this->m_pdf->load();
       	// $mpdf = new Mpdf(['format' => 'Legal']);

        $pdf->AddPage('P','','','','','','','','',20,20);
        
        
        $pdf->WriteHTML($this->load->view('view-surat_jalan',$var,TRUE));

        $pdf->Output($pdfFilePath, "D");



		// $var['s']='';
  //       $this->load->view('view-print_penawaran_produksi',$var);

	}

	public function ck_cus($id_pem=null){

		$this->load->model('model_transaksi');

		$customer = $this->model_transaksi->getCustomerFromPemesanan($id_pem);

		print_r($customer->row()->id_pemesan);
	}

	public function sh_driver($crew=null){
		if(!empty($crew)){
			$var['mode']='crew';
			$var['id_pemesanan'] = $_GET['id_pemesanan'];
			$var['driver'] = null;
			$getDriver = $this->db->query("select * from user where is_delete=0 and is_active=1 and (user_type='Kurir' or user_type='Freelance')");

			$arr_crew = $this->db->query("select c.id_kurir from crew_pemesanan as c join user as u where u.id=c.id_kurir and id_pemesanan=".$var['id_pemesanan'] . " and c.is_delete=0")->result();
			$var['crews'] = [''];
			foreach ($arr_crew as $key => $value) {
				array_push($var['crews'], $value->id_kurir);
			}

			if($getDriver->num_rows()>0){
				$var['driver'] = $getDriver->result();
			}
		}else{
			$var['mode']='driver';
			$var['id_pemesanan'] = $_GET['id_pemesanan'];
			$var['driver'] = null;
			$getDriver = $this->db->query("select * from user where is_delete=0 and is_active=1 and user_type='Kurir'");
			if($getDriver->num_rows()>0){
				$var['driver'] = $getDriver->result();
			}
		}

		$this->load->view('view-sh_driver',$var);
	}

	public function getUser(){
		$users = $this->db->query("select * from user where is_delete=0 and is_active=1 and is_freelance=1");
		echo json_encode($users->result());
	}

	public function ch_durasi(){
		$id=$_POST['id'];
		$this->load->model('model_transaksi');
		$durasi = $this->model_transaksi->get_durasi($id);
		echo json_encode($durasi);
	}

	public function gen_excel($id=null,$type=null){
		$this->load->model('model_transaksi');
		$list = $this->model_transaksi->list_item_pemesanan($id);
		/**
		 * PHPExcel
		 *
		 * Copyright (c) 2006 - 2015 PHPExcel
		 *
		 * This library is free software; you can redistribute it and/or
		 * modify it under the terms of the GNU Lesser General Public
		 * License as published by the Free Software Foundation; either
		 * version 2.1 of the License, or (at your option) any later version.
		 *
		 * This library is distributed in the hope that it will be useful,
		 * but WITHOUT ANY WARRANTY; without even the implied warranty of
		 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
		 * Lesser General Public License for more details.
		 *
		 * You should have received a copy of the GNU Lesser General Public
		 * License along with this library; if not, write to the Free Software
		 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
		 *
		 * @category   PHPExcel
		 * @package    PHPExcel
		 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
		 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
		 * @version    ##VERSION##, ##DATE##
		 */

		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		date_default_timezone_set('Europe/London');

		/** PHPExcel_IOFactory */
		// require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';
		include_once APPPATH.'/third_party/excel/PHPExcel/IOFactory.php';




		// echo date('H:i:s') , " Load from Excel5 template" , EOL;
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		// $objPHPExcel = $objReader->load("templates/30template.xls");
		$objPHPExcel = $objReader->load(APPPATH.'/third_party/excel/TEMPLATE_PENAWARAN.xlsx');




		// echo date('H:i:s') , " Add new data to the template" , EOL;

		$styleArray = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array(
			        				'rgb' => '000000'
			        			)
			    	)
			);

			$styleArray1 = array(
			    'font'  => array(
			        'color' => array(
			        				'rgb' => '000000'
			        			)
			    	),
			    'borders' => array(
				   'outline' => array(
				      'style' => PHPExcel_Style_Border::BORDER_NONE
				   ),
				)
		);

		// $objPHPExcel->getActiveSheet()->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel(time()));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E10:G10');
		$objPHPExcel->getActiveSheet()->setCellValue('E10',$list[0]->nama_pemesan);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E11:G11');
		$objPHPExcel->getActiveSheet()->setCellValue('E11',$list[0]->nama_perusahaan);

		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E10:G10');
		// $objPHPExcel->getActiveSheet()->setCellValue('E10',$list[0]->nama_pemesan);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E13:G13');
		$objPHPExcel->getActiveSheet()->setCellValue('E13',$list[0]->fax);

		$baseRow = 17;
		$total_all = 0;
		$keyRow = $baseRow;

		foreach($list as $key => $value) {
			$row = $baseRow + $key;
			$total_all += $value->harga_akhir;
			
			// echo $row;
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$row.':'.'E'.$row);
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$row.':'.'I'.$row);

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$value->qty)
			                              ->setCellValue('D'.$row,$value->satuan)
			                              ->setCellValue('F'.$row,$value->item_name.' - ('.$value->name_durasi.')')
			                              ->setCellValue('J'.$row,$value->harga)
			                              ->setCellValue('K'.$row,$value->harga_akhir);

			
			        // 'size'  => 12,
			        // 'name'  => 'Verdana'
			    

			// $phpExcel->getActiveSheet()->getCell('A1')->setValue('Some text');
			$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($styleArray);
			                              // ->setCellValue('C'.$row, $dataRow['price'])
			                              // ->setCellValue('D'.$row, $dataRow['quantity'])
			                              // ->setCellValue('E'.$row, '=C'.$row.'*D'.$row);
			$keyRow++;
		}

		$objPHPExcel->getActiveSheet()->insertNewRowBefore($keyRow,1);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$keyRow.':'.'E'.$keyRow);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$keyRow.':'.'I'.$keyRow);
		$keyRow++;

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.$keyRow.':'.'K'.$keyRow);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$keyRow,$total_all);

		$r_terbilang = $keyRow+8;
		$this->load->library('tambahan');
		// echo $this->tambahan->terbilang(500000);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$r_terbilang.':'.'K'.$r_terbilang);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$r_terbilang,$this->tambahan->terbilang($total_all).' Rupiah');
		
		// $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
		

		// $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);


		// echo date('H:i:s') , " Write to Excel5 format" , EOL;
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$file = APPPATH.'../assets/doc_penawaran/'.$type.'_'.$list[0]->no_pemesanan.'_'.date('Y-m-d H_i_s').'.xlsx';

		//MPDF ##############################################################
		$this->load->library('m_pdf');
        
        $css = [];

        $pdfFilePath = "INVOICE.pdf";

        $pdf = $this->m_pdf->load();
       	// $mpdf = new Mpdf(['format' => 'Legal']);

        $pdf->AddPage('P','','','','','','','','',20,20);
        
        
        $pdf->WriteHTML('DOKUMEN PRODUKSI');

        $pdf->Output($pdfFilePath, "F");

        $file2 = "INVOICE.pdf";
        
		// if (!unlink($file)){
		// 	echo ("Error deleting $file");
		// }else{
		//   	echo ("Deleted $file");
		// }
		//MPDF ##############################################################


		// $attach = 'APPROVE_'.$list[0]->no_pemesanan.'.xlsx';
		$objWriter->save(str_replace('.php', '.xlsx', $file));
		// echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


		// Echo memory peak usage
		// echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

		// Echo done
		// echo date('H:i:s') , " Done writing file" , EOL;
		// echo 'File has been created in ' , getcwd() , EOL;
		sleep(3);
		$this->load->library('mail');
		if($type=='APPROVE'){
			$mail = $this->mail->sendNego($list[0]->email,$list[0]->nama_pemesan,'APPROVE PENAWARAN','Pemesanan dengan nomor <b>'.$list[0]->no_pemesanan.'</b> telah disetujui.<br>Silahkan download tabel penawaran dibawah untuk melihat rincian biaya.','',$file,$file2);

			return $mail;
		}

		if($type=='NEGOSIASI'){
			$mail = $this->mail->sendNego($list[0]->email,$list[0]->nama_pemesan,'NEGOSIASI PENAWARAN','Pemesanan dengan nomor <b>'.$list[0]->no_pemesanan.'</b> telah selesai dinegosiasi.<br>Silahkan download tabel penawaran dibawah untuk melihat rincian biaya. Terimakasih.','',$file,$file2);

			return $mail;
		}

	}

	public function chk_list_out(){
		$id = $_POST['id'];
		$status = $_POST['status'];
		$remark = $_POST['remark'];

		$this->db->where('id',$id)->update('item_pemesanan',array('is_out'=>$status,'out_date'=>date('Y-m-d H:i:s'),'out_remark'=>$remark));
	}

	public function chk_list_in(){
		$id = $_POST['id'];
		$status = $_POST['status'];
		$remark = $_POST['remark'];

		$this->db->where('id',$id)->update('item_pemesanan',array('is_in'=>$status,'in_date'=>date('Y-m-d H:i:s'),'in_remark'=>$remark));
	}

	public function getRemarkOut(){
		$id = $_POST['id'];
		echo $this->db->where('id',$id)->select('out_remark')->get('item_pemesanan')->row()->out_remark;
	}

	public function getRemarkIn(){
		$id = $_POST['id'];
		echo $this->db->where('id',$id)->select('in_remark')->get('item_pemesanan')->row()->in_remark;
	}

	public function getArmada($id_pemesanan=null){
		if(!empty($id_pemesanan)){
			$data = array(
						'id_pemesanan'=>$id_pemesanan,
						'is_delete'=>0
					);

			$ls_armada = $this->db->order_by('insert_date','desc')->get_where('pemesanan_armada',$data);

			if($ls_armada->num_rows()>0){
				echo json_encode(array(
					'status'=>1,
					'message'=>'Data Ditemukan',
					'result'=>$ls_armada->result()
				));
			}else{
				echo json_encode(array(
					'status'=>0,
					'message'=>'Data Kosong',
					'result'=>null
				));
			}
		}else{
			echo json_encode(array(
				'status'=>0,
				'message'=>'Parameter input tidak benar.', //id kosong
				'result'=>null
			));
		}
	}

	public function insertArmada(){
		$id_pemesanan = !empty($_POST['id_pemesanan'])?$_POST['id_pemesanan']:null;

		if(!empty($id_pemesanan)){
			// $armada = !empty($_POST['armada'])?$_POST['armada']:null;
			$_POST['insert_by'] = !empty($_SESSION['id_user'])?$_SESSION['id_user']:null;

			if(!empty($_SESSION['id_user'])){
				$insert = $this->db->insert('pemesanan_armada',$_POST);
				$insert_id = $this->db->insert_id();

				if($insert){
					$newData = $this->db->get_where('pemesanan_armada',array('id'=>$insert_id));

					if($newData->num_rows()>0){
						echo json_encode(array(
							'status'=>1,
							'message'=>'Berhasil menginput data Armada.', //id kosong
							'result'=>$newData->row()
						));
					}else{
						echo json_encode(array(
							'status'=>1,
							'message'=>'Error Menampilkan data. Status Penambahan data = SUKSES. Reload untuk menampilkan data.', //parameter salah
							'result'=>null
						));
					}

				}else{
					echo json_encode(array(
						'status'=>0,
						'message'=>'Gagal menginput data. Parameter salah. Err Code : 783475', //parameter salah
						'result'=>null
					));
				}
			}else{
				echo json_encode(array(
					'status'=>0,
					'message'=>'Gagal menginput data. Tidak ada sesi Login. Err Code : 787598', //parameter salah
					'result'=>null
				));
			}
		}else{
			echo json_encode(array(
				'status'=>0,
				'message'=>'Parameter input tidak benar.', //id kosong
				'result'=>null
			));
		}
	}

	public function hapusArmada(){
		$id = !empty($_POST['id_armada'])?$_POST['id_armada']:null;

		if(!empty($id)){
			// $armada = !empty($_POST['armada'])?$_POST['armada']:null;
			$delete = $this->db->where('id',$id)->update('pemesanan_armada',array('is_delete'=>1,'delete_by'=>$_SESSION['id_user'],'delete_date'=>date('Y-m-d H:i:s')));

			if($delete){
				echo json_encode(array(
					'status'=>1,
					'message'=>'Berhasil menghapus data Armada.', //id kosong
					'result'=>null
				));
			}else{
				echo json_encode(array(
					'status'=>0,
					'message'=>'Gagal menginput data. Parameter salah. Err Code : 9849568', //parameter salah
					'result'=>null
				));
			}
		}else{
			echo json_encode(array(
				'status'=>0,
				'message'=>'Parameter input tidak benar.', //id kosong
				'result'=>null
			));
		}
	}

	public function addDate(){
		// $id_pemesanan = !empty($_POST['id_pemesanan'])?$_POST['id_pemesanan']:null;

		// if(!empty($id_pemesanan)){
			// $armada = !empty($_POST['armada'])?$_POST['armada']:null;
			$_POST['insert_by'] = !empty($_SESSION['id_user'])?$_SESSION['id_user']:null;

			if(!empty($_SESSION['id_user'])){
				$insert = $this->db->insert('tanggal_acara',$_POST);
				$insert_id = $this->db->insert_id();

				if($insert){
					$newData = $this->db->get_where('tanggal_acara',array('id'=>$insert_id));

					if($newData->num_rows()>0){
						echo json_encode(array(
							'status'=>1,
							'message'=>'Berhasil menginput data Tanggal Acara.', //id kosong
							'result'=>$newData->row()
						));
					}else{
						echo json_encode(array(
							'status'=>1,
							'message'=>'Error Menampilkan data. Status Penambahan data = SUKSES. Reload untuk menampilkan data.', //parameter salah
							'result'=>null
						));
					}

				}else{
					echo json_encode(array(
						'status'=>0,
						'message'=>'Gagal menginput data. Parameter salah. Err Code : DT-783475', //parameter salah
						'result'=>null
					));
				}
			}else{
				echo json_encode(array(
					'status'=>0,
					'message'=>'Gagal menginput data. Tidak ada sesi Login. Err Code : DT-787598', //parameter salah
					'result'=>null
				));
			}
		// }else{
		// 	echo json_encode(array(
		// 		'status'=>0,
		// 		'message'=>'Parameter input tidak benar.', //id kosong
		// 		'result'=>null
		// 	));
		// }
	}
	
		
}
?>