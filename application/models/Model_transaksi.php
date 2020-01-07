<?php 
class Model_transaksi extends CI_Model {
	function __construct(){
		parent::__construct();
		$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$this->load->library('log_status');

	}
	public function index(){
	}
	public function user_type($id=null){
		$query = $this->db->query('select * from user where id='.$id);

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}
	public function tb_pengajuan($id=null){
		$ex=null;
		if(!empty($id)){
			$ex = 'and p.id=' . $id;
		}
		$query = $this->db->query('select 	p.id,p.no_pengajuan,
										p.id_project,
										p.judul,
										p.tgl_pengajuan,
										p.`status`,
										u.username,
										u.user_type,
										p.stat_penerimaan,
										(select upj.name from pengajuan as pj join user as upj where pj.submiter=upj.id and pj.id=p.id) as submiter,
										(select upj.name from pengajuan as pj join user as upj where pj.approval=upj.id and pj.id=p.id) as approval,
										(select upj.name from pengajuan as pj join user as upj where pj.receiver=upj.id and pj.id=p.id) as receiver,
										p.submit_date,
										p.approve_date,
										p.receive_date
								from pengajuan as p
										join user as u 
								where p.is_delete="0" ' . $ex . '
										and p.update_by=u.id'
									);

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function list_item_pengajuan($id=null){
		
		$query = $this->db->query('	select 	p.id,p.no_pengajuan,
												p.judul,
												p.tgl_pengajuan,
												p.`status`,
												ip.qty,
												ip.qty_masuk,
												p.update_by,
												p.update_date,
												ip.id as id_it_pn,
												i.item_name,
												i.barcode,
												i.id as id_item,
												ip.h_stock,
												ip.update_date as update_it_date,
												i.satuan

									from pengajuan as p
											join item_pengajuan as ip
											join pos_item as i
											
									where p.id='.$id.' and ip.id_pengajuan=p.id and ip.id_item=i.id and ip.is_delete=0');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function list_item_pengajuan_edit($id=null){
		$query = $this->db->query('	select 	p.id,p.no_pengajuan,
												p.judul,
												p.tgl_pengajuan,
												p.`status`,
												ip.qty,
												p.update_by,
												p.update_date,
												ip.id as ID_IT_PENGAJUAN,
												i.id as ID_ITEM,
												i.item_name,
												i.barcode,
												ip.h_stock,
												i.qty as i_qty

									from pengajuan as p
											join item_pengajuan as ip
											join pos_item as i
											
									where p.id='.$id.' and ip.id_pengajuan=p.id and ip.id_item=i.id and ip.is_delete=0');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function trx_pengajuan(){
		$id = $this->input->post('id');
		$mode = $this->input->post('mode');
		$judul = $this->input->post('judul');
		$nomor = $this->input->post('nomor');
		//$id_submiter = $_SESSION['id_user'];
		$items = $this->input->post('item');
		$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';

		if($mode == 'add'){
			try{
				$this->db->insert('pengajuan',array(
										'no_pengajuan'=>$nomor,
										'judul'=>$judul,
										'submiter'=>$session_id,
										'insert_by'=>$session_id,
										'update_by'=>$session_id
									)
								);
			}catch(Exception $e){

			}finally{
				foreach ($items as $key => $value) {
					$items[$key]['id_pengajuan']=$this->db->insert_id();
					$items[$key]['insert_by']=$session_id;
					$items[$key]['update_by']=$session_id;
				}
				
				$this->db->insert_batch('item_pengajuan',$items);
			}
		}

		if($mode == 'edit'){
			try{
				$data = array(	
								'judul'=>$judul,
								'update_by'=>$session_id
							);

				$this->db->where('id', $id);
				$this->db->update('pengajuan', $data); 
			}catch(Exception $e){

			}finally{
				foreach ($items as $key => $value) {
					try{
						$items[$key]['id_pengajuan']=$id;
						$items[$key]['insert_by']=$session_id;
						$items[$key]['update_by']=$session_id;
					}catch(Exception $e){

					}finally{

						$this->db->query('insert into item_pengajuan (id,id_pengajuan,id_item,qty,h_stock,insert_by,update_by) 
							values("'. $items[$key]['id'] .'",'
									. $items[$key]['id_pengajuan'] .','
									. $items[$key]['id_item'] .','
									. $items[$key]['qty'] .','
									. $items[$key]['h_stock'] .','
									. $items[$key]['insert_by'] .','
									. $items[$key]['update_by'].') on duplicate key update qty='. $items[$key]['qty'] . ',h_stock='. $items[$key]['h_stock']);
					}
				}
				
				// $this->db->replace_batch('item_pengajuan',$items);

			}
		}
	}



	public function tb_pemesanan($id=null,$id_pemesan=null,$id_kurir=null){
		$ex=null;
		if(!empty($id)){
			$ex = 'and p.id=' . $id;
		}
		$pemesan=null;
		if(!empty($id_pemesan)){
			$pemesan = 'and p.id_pemesan=' . $id_pemesan;
		}
		$kurir=null;
		if(!empty($id_kurir)){
			$kurir = 'and (isnull(p.id_kurir) or p.id_kurir='. $id_kurir . ')';
		}


		$query = $this->db->query('select 	
										p.id as id_pemesanan,
										u_p.name as pemesan,
										u_p.id as id_pemesan,
										p.no_pemesanan, 
										p.tgl_pemesanan, 
										p.group,
										p.lantai,
										p.`status`,
										p.tanggal_acara,	
										p.tanggal_acara_awal,	
										p.tanggal_acara_akhir,	
										p.nama_event,
										p.alamat_venue,	
										p.loading_in,	
										p.loading_out,	
										p.pic,	
										p.no_hp_pic,
										(select u.id from user as u where u.id=p.id_kurir) as id_kurir,
										(select u.name from user as u where u.id=p.id_kurir) as kurir,
										(select r.rate from rating as r where r.id_pemesanan=p.id) as rating,
										p.duration,
										u_u.user_type,
										u_u.username,
										u_u.name as update_by

								from pemesanan as p
										join user as u_u
										join user as u_p
								where p.is_delete="0" 
										' . $ex . ' 
										' . $pemesan . ' 
										' . $kurir . ' 
										and p.update_by=u_u.id
										and p.id_pemesan=u_p.id order by p.tgl_pemesanan desc');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function tb_pemesanan_view($mode=null){
		if($mode=='pemesanan'){
			$mode='and p.jenis="pemesanan"';
		}else{
			$mode=null;
		}

		$query = $this->db->query('select 	
										p.id as id_pemesanan,
										u_p.name as pemesan,
										u_p.id as id_pemesan,
										p.no_pemesanan, 
										p.tgl_pemesanan, 
										p.loading_status,
										p.group,
										p.lantai,
										p.`status`,
										p.duration,
										p.jenis,
										(select r.rate from rating as r where r.id_pemesanan=p.id) as rating,
										(select count(id) from item_pemesanan where id_pemesanan=p.id) as jml_item,
										u_u.user_type,
										u_u.username,
										u_u.name as update_by
								from pemesanan as p
										join user as u_u
										join user as u_p
								where p.is_delete="0" 
										and p.update_by=u_u.id
										and p.id_pemesan=u_p.id '.$mode.' order by p.tgl_pemesanan desc');
		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}
	public function crew_assigned($id_pemesanan=null){
		$pemesanan=null;
		if(!empty($id_pemesanan)){
			$pemesanan = 'and id_pemesanan=' . $id_pemesanan;
		}
		$query = $this->db->query('	select 
											* 
									from 
											crew_pemesanan as c 
											join user as u on u.id=c.id_kurir
									where  
											c.is_delete=0 ' . $pemesanan);
		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}


	public function trx_pemesanan($is_mobile=null,$id_p=null){
		//echo $this->input->post('nomor');
		$id = $this->input->post('id');
		$id_pemesan = $this->input->post('id_pemesan');
		$id_user = $this->input->post('id_user');
		$tanggal_acara = $_POST['tanggal_acara'];
		$ls_tgl_acara = !empty($_POST['ls_tgl_acara'])?$_POST['ls_tgl_acara']:null;
		$ls_tgl_acara_del = !empty($_POST['ls_tgl_acara_del'])?$_POST['ls_tgl_acara_del']:null;
		// $tanggal_acara_awal = $_POST['tanggal_acara_awal'];
		// $tanggal_acara_akhir = $_POST['tanggal_acara_akhir'];
		$nama_event=$_POST['nama_event'];
		$alamat_venue=$_POST['alamat_venue'];
		$loading_in=$_POST['loading_in'];
		$loading_out=$_POST['loading_out'];
		$pic=$_POST['pic'];
		$no_hp_pic=$_POST['no_hp_pic'];
		// $duration = $this->input->post('duration');
		$insert_id_pemesanan;
		
		
		// if($is_mobile=='mobile'){
		// 	$id_pemesan = $id_p;
		// }

		if(!empty($id_pemesan)){
			$group;
			$lantai;


			$q_user = $this->db->query("	select
										(SELECT IFNULL(NULL, (select `group` from user where id=u.id)) as `Group`) as `group` ,
										(SELECT IFNULL(NULL, (select `lantai` from user where id=u.id)) as `lantai`) as `lantai` 
										
								from 
										user as u where u.id=" . $id_pemesan);

			if($q_user->num_rows()>0){
				$group = $q_user->row()->group;
				$lantai = $q_user->row()->lantai;
			}else{
				return '{"status":"-3","message":"User tidak ditemukan"}';
				return false;
			}

			$mode = $this->input->post('mode');
			
			if($is_mobile==null){
				//echo "A";
				$nomor = $this->input->post('nomor');
				if(!empty($nomor)){
					$nomor = $this->input->post('nomor');
				}else{
					return '{"status":"-2","message":"Error : Nomor Pemesanan Kosong."}';
					return false;
				}
				
			}else{
				if($is_mobile=='mobile'){
					$nomor = 'PSN-'.time().'-'.date('Y');
				}
				if($is_mobile!='mobile' && $is_mobile!=null){
					return '{"status":"-2","message":"Error : Nomor Pemesanan Kosong."}';
					return false;
				}
			}
			$items = $this->input->post('item');
			$itemFree = $this->input->post('itemFree');
			$list_del = $this->input->post('list_del');
			// print_r($items);

			$session_id;
			if(!empty($id_pemesan) && $is_mobile=='mobile'){
				$session_id = $id_pemesan;
			}else{
				$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
			}
			


			$mod_db = 0;
			$mod_item = 0;
			$mod_item_free = 0;

			try{
				if($mode == 'add'){
					try{
						$data = array(	
										'jenis'=>$_GET['type'],
										'id_pemesan'=>$id_pemesan,
										'no_pemesanan'=>$nomor,
										'tanggal_acara'=>$tanggal_acara,
										//'tanggal_acara_awal'=>$tanggal_acara_awal,
										//'tanggal_acara_akhir'=>$tanggal_acara_akhir,
										'nama_event'=>$nama_event,
										'alamat_venue'=>$alamat_venue,
										'loading_in'=>$loading_in,
										'loading_out'=>$loading_out,
										'pic'=>$pic,
										'no_hp_pic'=>$no_hp_pic,
										// 'duration'=>$duration,
										'group'=>$group,
										'lantai'=>$lantai,
										'insert_by'=>$session_id,
										'update_by'=>$session_id
									);
						$mod_db = $this->db->insert('pemesanan',$data);
						$insert_id_pemesanan = $this->db->insert_id();

						if(!empty($ls_tgl_acara)){
							foreach ($_POST['ls_tgl_acara'] as $key_acr => $value_acr) {
								$_POST['ls_tgl_acara'][$key_acr]['id_pemesanan']=$insert_id_pemesanan;
								$_POST['ls_tgl_acara'][$key_acr]['insert_by']=$_SESSION['id_user'];
								$insert_tgl_acara = $this->db->insert('tanggal_acara',$_POST['ls_tgl_acara'][$key_acr]);
							}
						}

						


					}catch(Exception $e){
						echo $e;
					}finally{
						if(!empty($items)){
							foreach ($items as $key => $value) {
								$items[$key]['id_pemesanan']=$insert_id_pemesanan;
								$items[$key]['insert_by']=$session_id;
								$items[$key]['update_by']=$session_id;
							}

							$mod_item = $this->db->insert_batch('item_pemesanan',$items);
						}

						if(!empty($itemFree)){
							foreach ($itemFree as $key => $value) {
								$itemFree[$key]['id_pemesanan']=$insert_id_pemesanan;
								$itemFree[$key]['insert_by']=$session_id;
								$itemFree[$key]['update_by']=$session_id;
							}

							$mod_item_free = $this->db->insert_batch('item_pemesanan',$itemFree);
						}
					}

				}


				if($mode == 'edit'){
					try{
						$data = array(	
										//'judul'=>$judul,
										'jenis'=>$_GET['type'],
										'id_pemesan'=>$id_pemesan,
										'tanggal_acara'=>$tanggal_acara,
										'nama_event'=>$nama_event,
										'alamat_venue'=>$alamat_venue,
										'loading_in'=>$loading_in,
										'loading_out'=>$loading_out,
										'pic'=>$pic,
										'no_hp_pic'=>$no_hp_pic,
										// 'duration'=>$duration,
										'group'=>$group,
										'lantai'=>$lantai,
										'update_by'=>$session_id
									);

						$this->db->where('id', $id);
						$mod_db = $this->db->update('pemesanan', $data); 

						if(!empty($ls_tgl_acara)){
							foreach ($_POST['ls_tgl_acara'] as $key_acr => $value_acr) {
								$_POST['ls_tgl_acara'][$key_acr]['id_pemesanan']=$id;
								$_POST['ls_tgl_acara'][$key_acr]['insert_by']=$_SESSION['id_user'];
								$insert_tgl_acara = $this->db->insert('tanggal_acara',$_POST['ls_tgl_acara'][$key_acr]);
							}
						}

						if(!empty($ls_tgl_acara_del)){
							foreach ($ls_tgl_acara_del as $key_del => $value_del) {
								$this->db->where('id',$value_del)->update('tanggal_acara',array('is_delete'=>1,'delete_by'=>$_SESSION['id_user'],'delete_date'=>date('d-m-Y H:i:s')));
							}
						}

					}catch(Exception $e){

					}finally{
						if(!empty($items)){
							foreach ($items as $key => $value) {
								try{
									$items[$key]['id_pemesanan']=$id;
									$items[$key]['insert_by']=$session_id;
									$items[$key]['update_by']=$session_id;
								}catch(Exception $e){

								}finally{

									$id_i = '""';
									if(!empty($items[$key]['id'])){
										$id_i = $items[$key]['id'];
									}

									// if(!empty($items[$key]['edit_total'])){
									// 	if($items[$key]['edit_total']==1){
									// 		$nego = ', edit_total='.$items[$key]['edit_total'].',total_by='.$_SESSION['id_user'].',total_date="'.date("Y-m-d H:i:s").'"';
									// 	}else{
									// 		$nego="";
									// 	}
									// }else{
									// 	$nego="";
									// }

									$q = 'insert into item_pemesanan (id,id_pemesanan,id_item,qty,h_stock,disc,extra_charge,harga,total_harga,insert_by,update_by) 
										values('. $id_i .','
												. $items[$key]['id_pemesanan'] .','
												. $items[$key]['id_item'] .','
												. $items[$key]['qty'] .','
												. $items[$key]['h_stock'] .','
												. $items[$key]['disc'] .','
												. $items[$key]['extra_charge'] .','
												. $items[$key]['harga'] .','
												. $items[$key]['total_harga'] .','
												. $items[$key]['insert_by'] .','
												. $items[$key]['update_by'].') on duplicate key update 
												qty='. $items[$key]['qty'] . ',
												h_stock='. $items[$key]['h_stock'] . ',
												disc='. $items[$key]['disc'] . ',
												extra_charge='. $items[$key]['extra_charge'] . ',
												harga='. $items[$key]['harga'] . ',
												total_harga='. $items[$key]['total_harga'];
									$mod_item += $this->db->query($q);
									// echo $q;
									
								}
							}
						}

						if(!empty($list_del)){
							foreach ($list_del as $key => $value) {
								$this->db->where('id',$value);
								$this->db->update('item_pemesanan',array('is_delete'=>1));
							}
						}
						
						// $this->db->replace_batch('item_pengajuan',$items);



					}
				}
			}catch(Exception $e){

			}finally{
				if(!empty($id_pemesan)){
					if($mode=='add'){	
						if($mod_db==1 && ($mod_item>0 || $mod_item_free>0)){
							return '{"status":"1","message":"Sukses menambah pemesanan"}';
							$jenis_pemesanan = $this->db->where('id',$insert_id_pemesanan)->select('jenis')->get('pemesanan');

							$log = $this->log_status->add_log($insert_id_pemesanan,0,$jenis_pemesanan->row()->jenis);

							$this->db->insert('log_status_pemesanan',$log);
						}else{

							return '{"status":"-1","message":"Error Menambah Pemesanan (Item Kosong)"}';
						}
					}
					if($mode=='edit'){	
						if($mod_db==1 && $mod_item>0){
							return '{"status":"1","message":"Sukses Mengubah Pemesanan"}';
						}else{
							return '{"status":"-1","message":"Error Mengubah Pemesanan (Item Kosong) => DB '.$mod_db.' & IT '.$mod_item.'"}';
						}
					}
				}
			}
		}else{
			return '{"status":"-4","message":"ID User belum diisi"}';
			return false;
		}
	}

	public function list_item_pemesanan($id_pem=null){
		$id;

		if($id_pem==null){
			$id = $this->input->post('id');
		}else{
			$id=$id_pem;
		}
		
		$query = $this->db->query('	select 		
												p.id,p.no_pemesanan,
												p.tgl_pemesanan,
												p.`status`,
												p.tanggal_acara,
												p.tanggal_acara_awal,	
												p.tanggal_acara_akhir,
												p.nama_event,
												p.alamat_venue,	
												p.loading_in,	
												p.loading_out,	
												p.pic,	
												p.no_hp_pic,
												up.name as nama_pemesan,
												up.nama_perusahaan,
												up.email,
												up.fax,
												p.group,
												p.lantai,
												ip.qty,
												ip.qty_masuk,
												ifnull(ip.h_stock,"-") as h_stock,
												p.update_by,
												p.update_date,
												ip.id as id_it_pn,
												ifnull(i.item_name,ip.name) as item_name,
												ifnull(i.barcode,ip.barcode) as barcode,
												i.id as id_item,
												up.group,
												up.lantai,
												i.jenis_item,
												i.satuan,
												ip.total_harga,
												ip.harga,
												ip.disc,
												ifnull(ip.extra_charge,0) as extra_charge,
												ip.`total_harga` as harga_akhir,
												(select name from durasi where id=ip.durasi) as name_durasi,
												(select (
													(ip.harga*ip.qty)-
													((ip.harga*ip.qty)*(ip.disc/100))+
													((ip.harga*ip.qty)*(ip.`extra_charge`/100))
												)) as total_harga,
												if(ip.is_out=1,"checked","") as is_out,
												ip.out_remark,
												ip.in_remark,
												if(ip.is_in=1,"checked","") as is_in,
												ip.in_date,
												ip.out_date

									from pemesanan as p
											join item_pemesanan as ip
											left join pos_item as i on ip.id_item=i.id
											join user as up
											
									where p.id='.$id.' and 
											ip.id_pemesanan=p.id and 
											ip.is_delete=0 and 
											p.id_pemesan=up.id

									order by ip.id_item asc
											');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function list_item_pemesanan_edit($id=null){
		$query = $this->db->query('	select 	p.id as id,p.no_pemesanan,
												p.tgl_pemesanan,
												p.`status` as status,
												ip.qty,
												p.update_by,
												p.update_date,
												ip.id as ID_IT_PEMESANAN,
												i.id as ID_ITEM,
												i.item_name,
												i.barcode,
												(select u.name as kurir_name from user as u,pemesanan as p where p.id_kurir=u.id and p.id='.$id.') as kurir_name,
												i.qty as i_qty,
												i.jenis_item,
												(select name from durasi where id=ip.durasi) as name_durasi,
												ip.disc,
												ip.extra_charge,
												ip.harga,
												ip.total_harga,
												(select (qty*harga) from item_pemesanan where id=ip.id) as total,
												(select trim(((qty*harga)-(((qty*harga)*(disc/100))))+((qty*harga)*(extra_charge/100)))+0 from item_pemesanan where id=ip.id) as total_all


									from pemesanan as p
											join item_pemesanan as ip
											left join pos_item as i on ip.id_item=i.id
											
											
									where 	p.id='.$id.' and 
											ip.id_pemesanan=p.id and 
											ip.is_delete=0');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function ck_stat(){
		$query = $this->db->query('select id,status from pemesanan order by pemesanan.tgl_pemesanan desc');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function cancel_pemesanan($id){
		$query = $this->db->query("update pemesanan set status=6 where id=".$id." and status<5");

		
		if($query){
			$ck_stat = $this->db->where('id',$id)->select('status')->get('pemesanan');

			if($ck_stat->num_rows()>0){
				if($ck_stat->row()->status==6){
					$this->load->library('log_status');
					$jenis_pemesanan = $this->db->where('id',$id)->select('jenis')->get('pemesanan');

					$log = $this->log_status->add_log($id,6,$jenis_pemesanan->row()->jenis);
					$this->db->insert('log_status_pemesanan',$log);

					return '{"status":1,"message":"Berhasil membatalkan pemesanan"}';

				}else{
					if($ck_stat->row()->status==5){
						return '{"status":-3,"message":"Gagal membatalkan pemesanan, Status pemesanan sudah Selesai"}';
					}					
				}
				
			}else{
				return '{"status":-2,"message":"Gagal membatalkan pemesanan. Data tidak ditemukan"}';
			}
			
		}else{
			return '{"status":-1,"message":"Gagal membatalkan pemesanan"}';
		}
	}

	public function extra_charge(){
		$query = $this->db->query('	select 
											e.*,
											u.name as update_by_username
									from 
											extra_charge as e 
											join user as u 
									where 
											e.update_by=u.id
											and e.is_delete=0');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function durasi($id=null){
		$query = $this->db->query('	select * from durasi where is_delete=0');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function get_durasi($id=null){
		$query = $this->db->query('	select * from durasi where is_delete=0 and id_item='.$id);

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function getCustomerFromPemesanan($id=null){
		$query = $this->db->query('	select id_pemesan from pemesanan where is_delete=0 and id='.$id);

		if ($query->num_rows() > 0){
		    return $query;
		}else{
		    return NULL;
		}
	}
}
?>
