<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

	public function index()	{

		$this->load->view('view-login');
	}

	public function randomPassword() {
	    // $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $alphabet = '1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	//########## REGISTER
	public function register($ck=null){
		$this->load->model('model_user');

		$user_id = time();
		$username = $this->input->post('username');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$group = $this->input->post('group');
		$lantai = $this->input->post('lantai');
		$password = $this->randomPassword();


		$data = array(
			'user_id' => $user_id,
			'username' => $username,
			'name' => $name,
			'group' => $group,
			'lantai' => $lantai,
			'email' => $email,
			'user_type' => 'Karyawan',
			'is_active' => 1,
			'active_date' => date('Y-m-d H:i:s'),
			'password' => sha1(md5($password))
		);

		$q_username = $this->db->query("select id from user where username='".$username."'");
		$q_email = $this->db->query("select id from user where email='".$email."'");


		if(!empty($ck)){
			if($q_username->num_rows()>0){
				echo '{"status":"1","message":"Registrasi Sukses"}';
			}else{
				if($q_email->num_rows()>0){
					echo '{"status":"1","message":"Registrasi Sukses"}';
				}else{
					echo '{"status":"1","message":"Registrasi Sukses"}';
				}
			}
		}else{
			if($q_username->num_rows()>0){
				echo '{"status":"-1","message":"Username sudah terdaftar"}';
			}else{
				if($q_email->num_rows()>0){
					echo '{"status":"-2","message":"Email sudah terdaftar"}';
				}else{
					//echo $this->randomPassword();
					$email_stat = $this->model_user->sendMail($email,$name,$user_id,$group,$lantai,$username,$password);

					if($email_stat == '1'){
						$insert = $this->db->insert('user',$data);
						$l_id = $this->db->insert_id();
						if($insert){
							$this->db->where('id',$l_id);
							$this->db->update('user',array(
															'active_by'=>$l_id,
															'insert_by'=>$l_id,
															'update_by'=>$l_id
														));
							echo '{"status":"1","message":"Registrasi Sukses"}';
						}else{
							echo '{"status":"-3","message":"(DB) Registrasi Error, Silahkan coba kembali"}';
						}
					}else{
						echo '{"status":"-4","message":"'.$email_stat.'"}';
						//print_r($email_stat);
					}
				}
			}
		}

	}

	//########### FORGET / FORGOT PASSWORD
	public function forget(){

		$this->load->model('model_user');


		$username = $this->input->post('username');
		$email = $this->input->post('email');

		echo $this->input->post('username') . '>' . $email;

		$q_akun = $this->db->query("select * from user where user_type='Karyawan' and email='".$email."' and username='".$username."'");

		

		if($q_akun->num_rows()>0){
			$id = $q_akun->row()->id;
			$username = $q_akun->row()->username;
			$name = $q_akun->row()->name;
			$group = $q_akun->row()->group;
			$lantai = $q_akun->row()->lantai;
			$password = $this->randomPassword();

		 	$email_stat = $this->model_user->mailForgetPassword($email,$password,$name);
		 	
		 	if($email_stat=='1'){
			 	$this->db->where('id',$id);
				$update = $this->db->update('user',array(
												'password' => sha1(md5($password)),
												'update_by'=>$id
											));
				if($update){
					echo '{"status":"1","message":"Forgot Password Sukses"}';
				}else{
					echo '{"status":"-1","message":"Database Error"}';
				}
			}else{
				echo '{"status":"-2","message":"Error Forgot Password, Silahkan coba kembali."}';
			}
			
		}else{
			echo '{"status":"-3","message":"Tidak dapat menemukan Karyawan dengan Username dan Email tersebut"}';
		}
	}

	public function txt_stat($i=null){
		$status = ['Waiting Approval','Order Received','Courir Assigned','Prepare Item','Courier On The Way','Done','Cancel'];
		return $status[$i];
	}
	public function ls_pemesanan(){

		$this->load->model('Model_mobile');
		
		$data = $this->Model_mobile->ls_pemesanan();

		$dt = json_decode(json_encode($data),true);
		
		if(!empty($dt)){
			foreach ($dt as $key =>$value) {
				//$dt[$key]['item_list']='';
				$dt[$key]['txt_stat']=$this->txt_stat($dt[$key]['status']);
				$str = '';
				$item = $this->Model_mobile->ls_it_pemesanan($dt[$key]['id_pemesanan']);
				if($item){
					foreach ($item as $in => $value) {
						
						$str .= ','.$value->item_name;
						$f_str = substr($str,1);
						$dt[$key]['item_list']=$f_str;

					}
				}
				
			}
			echo json_encode($dt);
		}else{

		}
	}

	public function ls_by_kurir($id_kurir=null){
		$this->load->model('Model_mobile');

		$status = ['Waiting Approval','Order Received','Courir Assigned','Prepare Item','Courier On The Way','Done','Cancel'];
		
		$data = $this->Model_mobile->ls_pemesanan_by_kurir($id_kurir);

		$dt = json_decode(json_encode($data),true);
		
		if(!empty($dt)){
			foreach ($dt as $key =>$value) {
				//$dt[$key]['item_list']='';
				$dt[$key]['txt_stat']=$status[$dt[$key]['status']];
				$str = '';
				$item = $this->Model_mobile->ls_it_pemesanan($dt[$key]['id_pemesanan']);
				//print_r($item);
				if($item){
					foreach ($item as $in => $value) {
						
						$str .= ','.$value->item_name;
						$f_str = substr($str,1);
						$dt[$key]['item_list']=$f_str;

					}
				}else{
					
				}
				
			}
			echo json_encode($dt);
		}else{
			//echo "A";
		}
	}
	public function ls_by_pemesan(){
		$id_staff = $this->input->post('id');
		$this->load->model('Model_mobile');

		$status = ['Waiting Approval','Order Received','Courir Assigned','Prepare Item','Courier On The Way','Done','Cancel'];
		
		$data = $this->Model_mobile->ls_pemesanan_by_pemesan($id_staff);


		$dt = json_decode(json_encode($data),true);
		
		if(!empty($dt)){
			foreach ($dt as $key =>$value) {
				//$dt[$key]['item_list']='';
				$dt[$key]['txt_stat']=$status[$dt[$key]['status']];
				$str = '';
				$item = $this->Model_mobile->ls_it_pemesanan($dt[$key]['id_pemesanan']);
				$rate = $this->Model_mobile->ck_rate($dt[$key]['id_pemesanan']);
				//print_r($item);
				if($item){
					foreach ($item as $in => $value) {
						
						$str .= ','.$value->item_name;
						$f_str = substr($str,1);
						$dt[$key]['item_list']=$f_str;

					}
				}else{
					
				}

				

				$dt[$key]['rate']=$rate[0];

				
			}
			echo json_encode($dt);
		}else{
			//echo "A";
		}
	}

	public function ls_item_pemesanan($id=null){
		$this->load->model('Model_mobile');
		$item = $this->Model_mobile->ls_it_pemesanan($id);


		$dt = json_decode(json_encode($item),true);
		//echo $dt[0]['id_item'];
		foreach ($dt as $in => $value) {
			//echo $value[$in]['id_item'];
			$img = json_decode($this->Model_mobile->getPhoto($dt[$in]['id_item']),true);
			$dt[$in]['img_name']=$img[0]['img_name'];
		}

		echo json_encode($dt);
	}

	public function insertkurir(){

		$id_pem = $this->input->post('id_pemesanan');
		$id_kurir = $this->input->post('id_kurir');

		$this->db->where('id',$id_pem);
		$this->db->where('is_delete',0);
		$dt = $this->db->select('*')->from('pemesanan')->get();


		$this->db->where('id',$id_kurir);
		$this->db->where('is_delete',0);
		$this->db->where('is_active',1);
		$this->db->where('user_type','Kurir');
		$kurir = $this->db
							->select('id')
							->select('username')
							->select('name')
							->from('user')
							->get();
		//print_r($kurir->result());

		if($kurir->num_rows()>0){
			if($dt->num_rows()>0){
				$stat = $dt->row()->status;

				switch ($stat) {
					case 0:
						echo '{"status":0,"message":"Waiting Approval"}';
						break;
					case 1:
						try{
							if(!empty($id_pem) && !empty($id_kurir)){

								$u_dt = array(
												'id_kurir'=>$id_kurir,
												'add_kurir_date'=>date('Y-m-d H:i:s'),
												'add_kurir_by'=>$id_kurir,
												'status'=>2
												);

								$this->db->where('id',$dt->row()->id);
								$update = $this->db->update('pemesanan',$u_dt);

								if($update){
									echo '{"status":1,"message":"Success Update Kurir"}';
								}else{
									echo '{"status":-2,"message":"Kesalahan saat mengupdate Data Pemesanan, coba lagi"}';
								}
							}else{
								echo '{"status":-1,"message":"Kurir / Data Pemesanan tidak ada"}';
							}


						}catch(Exception $e){
							echo '{"status":-3,"message":"Terjadi kesalahan saat update data"}';
						}
						break;
					case 2:
						echo '{"status":2,"message":"Courir Assigned"}';
						break;
					case 3:
						echo '{"status":3,"message":"Prepare Item"}';
						break;
					case 4:
						echo '{"status":4,"message":"Courier On The Way"}';
						break;
					case 5:
						echo '{"status":5,"message":"Done"}';
						break;
					default:
						# code...
						break;
				}
			}else{
				echo '{"status":-5,"message":"Data Pemesanan tidak ada / Pemesanan sudah di cancel/delete"}';
			}
		}else{
			echo '{"status":-4,"message":"Status kurir tidak aktif / Data kurir tidak ada"}';
		}
		//print_r($kurir->result());
	}

	public function updatestatpemesanan(){
		$id_pem = $this->input->post('id_pemesanan');
		$id_kurir = $this->input->post('id_kurir');
		$stat = $this->input->post('status');

		if(!empty($id_pem)&&!empty($id_kurir)&&!empty($stat)){
			$dt = $this->db->query("
								select
									 p.id,u_k.id as id_kurir,p.status,u_k.name
								FROM
									pemesanan as p
								    join user as u_k on p.id_kurir=u_k.id
								WHERE
									u_k.user_type='Kurir' and
									p.status!=5 and
									p.is_delete=0 and
								    p.id=".$id_pem." AND u_k.id=".$id_kurir);

			
			if($dt->num_rows()>0){
				if($stat>2 && $stat<=5){
					$data = array(
								'status'=>$stat,
								'update_by'=>$id_kurir
								);
					$this->db->where('id',$id_pem);
					$s_updt = $this->db->update('pemesanan',$data);
					if($s_updt){
						echo '[{"status":1,"message":"Sukses update status pemesanan"}]';
					}else{
						echo '[{"status":0,"message":"Error update status pemesanan"}]';
					}
				}else{
					echo '[{"status":-3,"message":"Status pemesanan salah, silahkan coba lagi"}]';
				}
				
			}else{
				echo '[{"status":-1,"message":"Data tidak ditemukan / pemesanan sudah selesai"}]';
			}	
		}else{
			echo '[{"status":-2,"message":"Data inputan tidak lengkap, silahkan coba lagi"}]';
		}

	}

	//########### LOGIN
	public function login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$query = $this->db->query("select * from user where username='".$username."' or email='".$username."'");
		$jml_order = $this->db->query("select count(id) as jml from pemesanan where status=1 and is_delete=0");

		if(empty($username) || empty($password)){
			echo '[{"status":"5","message":"Username / Password belum diisi"}]';
		}else{
			if ($query->num_rows() > 0){
			
				$s_username = $query->row()->username;
				$s_email = $query->row()->email;
				$s_password = $query->row()->password;

				if(($username == $s_username || $username == $s_email) && sha1(md5($password))==$s_password){
					try{
						$data = json_decode(json_encode($query->result()),true);
					}catch(Exception $e){
						
					}finally{
						if($data[0]['is_delete']==0){
							if($data[0]['is_active']==0){
								echo '[{"status":"2","message":"Status User masih belum aktif"}]';			
							}else{
								$data[0]['status'] = '1';
								$data[0]['message'] = 'Login Success';	
								if($jml_order->num_rows()>0){
									$data[0]['new_order']=$jml_order->row()->jml;
								}
								echo json_encode($data);
							}			
						}else{
							echo '[{"status":"4","message":"User sudah di hapus"}]';
						}
					}
					
				}else{
					echo '[{"status":"0","message":"Username / Password Salah"}]';
				}
			}else{
				echo '[{"status":"3","message":"User tidak ditemukan"}]';
			}
		}
		
	}

	public function ch_pass(){
		//$var['user'] = $_SESSION['user_type'];
		$id = $this->input->post('id_user');

		$o = $this->input->post('old');
		$n = $this->input->post('new');

		if(!empty($o)&&!empty($n)){
			$this->db->where('id',$id);
			$this->db->select('password');
			$v_old = $this->db->get('user');


			try{
				$old = $v_old->row()->password;
				
					if(sha1(md5($o))==$old){
						
						$this->db->where('id', $id);
						$u = $this->db->update('user',array('password'=>sha1(md5($n))));
						if($u){
							echo '{ "status":"1","message":"Sukses mengubah password" }';
						}else{
							echo '{ "status":"-2","message":"Error mengubah password" }';
						}
						
					}else{
						echo '{ "status":"-1","message":"Password lama salah" }';
					}
			}catch(Exception $e){

			}
		}else{
			echo '{ "status":"-3","message":"Password lama & password baru harus diisi" }';
		}
		
	}	

	public function jml_order(){
		$query = $this->db->query("select count(id) as jml from pemesanan where status=1 and is_delete=0");
		if($query->num_rows()>0){
			echo '{"jml":'.$query->row()->jml.'}';
		}
	}

	public function orderkurir(){
		$id_kurir = $this->input->post('id_kurir');

		if(!empty($id_kurir)){
			$query = $this->db->query("	
										select
												p.*,u_k.id as id_kurir,u_k.username,u_k.name,p.status
										FROM
												pemesanan as p
										        join user as u_k on p.id_kurir=u_k.id
										where	p.id_kurir=".$id_kurir." AND
												p.is_delete=0 AND 
												u_k.is_delete=0 AND
												u_k.is_active=1

										");

			if($query->num_rows()>0){
				echo json_encode($query->result());
			}
		}

	}

	public function pemesanan(){
		$id = $this->input->post('id');
		$id_staff = $this->input->post('id_staff'); //ID Staff
		$mode = $this->input->post('mode'); //Mode add or edit
		$nomor = 'PSN-'.time().'-'.date('Y'); //Nomor Pemesanan
		$items = $this->input->post('item'); //Bentuk Array


		$this->load->model('model_mobile');
		$ck_staff = $this->model_mobile->ck_staff($id_staff);
			if($mode == 'add'){
				if(!empty($ck_staff)){
					try{
						$dt_insert = array(	
										'id_pemesan'=>$id_staff,
										'no_pemesanan'=>$nomor,
										'insert_by'=>$id_staff,
										'update_by'=>$id_staff
									);
						$tb_pemesanan = $this->db->insert('pemesanan',$dt_insert);
						if($tb_pemesanan){
							$id_pemesanan=$this->db->insert_id();
							foreach ($items as $key => $value) {
								$items[$key]['id_pemesanan']=$id_pemesanan;
								$items[$key]['insert_by']=$id_staff;
								$items[$key]['update_by']=$id_staff;
							}
							
							$tb_item_pem = $this->db->insert_batch('item_pemesanan',$items);


							if($tb_item_pem){
								$this->load->model('model_transaksi');
								$dt_pem = $this->model_transaksi->tb_pemesanan($id_pemesanan);
								if($dt_pem){
									$data = json_decode(json_encode($dt_pem),true);
									$data[0]['status_php'] = 1;
									$data[0]['message'] = 'Berhasil Menginput Pemesanan';
									echo json_encode($data);
								}else{
									$data[0]['status_php'] = -3;
									$data[0]['message'] = "Kesalahan saat mengambil data Pemesanan";
									echo json_encode($data);
								}
							}else{
								$data[0]['status_php'] = -2;
								$data[0]['message'] = "Kesalahan saat memasukkan Item Pemesanan";
								echo json_encode($data);
							}
						}else{
							$data[0]['status_php'] = -1;
							$data[0]['message'] = "Kesalahan saat memasukkan Pemesanan";
							echo json_encode($data);
						}

					}catch(Exception $e){
						//echo $e;
					}finally{
						
					}
				}else{
					$data[0]['status_php'] = -4;
					$data[0]['message'] = "Karyawan tidak ada/bukan karyawan";
					echo json_encode($data);
				}
			}else{
				if($mode == 'edit'){

				}else{
					$data[0]['status_php'] = -5;
					$data[0]['message'] = "Mode tidak sesuai";
					echo json_encode($data);
				}
			}
	}

	//##################################  PEMESANAN ###############################
	//#### LIST ITEM

	public function ck_pemesanan(){
		$pm = $this->db->select('*')->from('item_pemesanan')->get();
		if($pm->num_rows()>0){
			echo json_encode($pm->result());
		}
	}

	public function item(){
		$this->load->model('model_produk');
		$this->load->model('model_mobile');
		$dt = [];

		$dt = json_decode(json_encode($this->model_produk->tb_item_is_av()),true);

		foreach ($dt as $in => $value) {
			$img = json_decode($this->model_mobile->getPhoto($dt[$in]['ID_ITEM']),true);
			$dt[$in]['img_name']=$img[0]['img_name'];
		}
		

		echo json_encode($dt);


	}


	public function trx_pemesanan($mobile=null,$id_p=null){
		$this->load->model('model_transaksi');
		$this->model_transaksi->trx_pemesanan($mobile,$id_p);
		//inputan
		//Example
			// mode:add
			// id_pemesan:84
			// id:
			// nomor:PSN-1515011659-2018
			// item[0][id]:
			// item[0][id_item]:96
			// item[0][qty]:1

			// item[1][id]:
			// item[1][id_item]:97
			// item[1][qty]:1
			// id_user:84
			// id=25 (id pemesanan jika mode = edit)
	}

	public function staff_ls_pemesanan(){
		$id = $this->input->post('id');
		$this->load->model('model_transaksi');
		echo json_encode($this->model_transaksi->tb_pemesanan(null,$id));
	}

	public function del_it_pemesanan(){
		$id = $this->input->post('id');
		
		$this->db->where('id',$id);
		$del_stat = $this->db->update('item_pemesanan',array('is_delete'=>1));

		if($del_stat){
			echo '{"status":"1","message":"Sukses menghapus item pemesanan"}';
		}else{
			echo '{"status":"-1","message":"Error menghapus item pemesanan"}';
		}
	}

	//################ RATE #############
	public function v_rate(){
		$id = $this->input->post('id_kurir');
		
		$query = $this->db->query('	select 
												r.id_kurir,
												u_k.name,
												count(r.id_kurir) as jml_pemesanan,
												avg(r.rate) as rate 
									from 
												rating as r
												join user as u_k

									where 
												r.id_kurir='. $id .'
												and r.id_kurir=u_k.id');

		$err = $this->db->error();
		
		if($query){
		 	if ($query->num_rows() > 0){
			    echo json_encode($query->result());
			}else{
			    echo json_encode(json_decode('[{"status":"-1","message":"Data Kosong"}]',true));
			}
		}else{
			//echo $err['code'];
			echo json_encode(json_decode('[{"status":"'.$err['code'].'","message":"'.$err['message'].'"}]',true));	
		}


	}

	public function add_rate(){
		$id_kurir = $this->input->post('id_kurir'); 
		$id_pemesan = $this->input->post('id_pemesan');
		$id_pemesanan = $this->input->post('id_pemesanan');
		$rate = $this->input->post('rate');

		if(
			empty($id_kurir) ||
			empty($id_pemesan) ||
			empty($id_pemesanan) ||
			empty($rate)
			){
				echo json_encode(json_decode('[{"status":"-1","message":"Data tidak lengkap, harap isi semua form"}]',true));
				return false;


		}else{

			if(!is_numeric($id_kurir) || !is_numeric($id_pemesan) || !is_numeric($id_pemesanan) || !is_numeric($rate)){
					echo json_encode(json_decode('[{"status":"-2","message":"Inputan hanya boleh berisi Angka"}]',true));
					return false;
			}else{


				$insert = $this->db->query('insert into rating (id_kurir,id_pemesan,id_pemesanan,rate) 
										values('. $id_kurir .','
												. $id_pemesan .','
												. $id_pemesanan .','
												. $rate .') on duplicate key update rate='. $rate);
				// $data = array(
				// 				'id_kurir' => $id_kurir,
				// 				'id_pemesan' => $id_pemesan,
				// 				'id_pemesanan' => $id_pemesanan,
				// 				'rate' => $rate
				// 				);

				// $insert = $this->db->insert('rating',$data);

				$err = $this->db->error();

				if($insert){
					echo json_encode(json_decode('[{"status":"1","message":"Berhasil Menginputkan Data"}]',true));
				}else{
					echo json_encode(json_decode('[{"status":"'.$err['code'].'","message":"'.$err['message'].'"}]',true));
				}
				
			}
		}


	}

	public function cancel_pem(){
		$id = $this->input->post('id');
		$this->load->model('model_transaksi');
		$c = $this->model_transaksi->cancel_pemesanan($id);

		echo $c;

	}

	public function ch_password(){
		//$var['user'] = $_SESSION['user_type'];
		$id = $this->input->post('id_user');

		$o = $this->input->post('old');
		$n = $this->input->post('new');

		if(!empty($o)&&!empty($n)){
			$this->db->where('id',$id);
			$this->db->select('password');
			$v_old = $this->db->get('user');


			try{
				$old = $v_old->row()->password;
				
					if(sha1(md5($o))==$old){
						
						$this->db->where('id', $id);
						$u = $this->db->update('user',array('password'=>sha1(md5($n))));
						if($u){
							echo '{ "status":"1","message":"Sukses mengubah password" }';
						}else{
							echo '{ "status":"-2","message":"Error mengubah password" }';
						}
						
					}else{
						echo '{ "status":"-1","message":"Password lama salah" }';
					}
			}catch(Exception $e){

			}
		}else{
			echo '{ "status":"-3","message":"Password lama & password baru harus diisi" }';
		}
	}

	public function edit_profile(){
		
		//$data = $this->input->post();
		$data['id'] = $this->input->post('id');
		$data['insert_by'] = $this->input->post('id');
		$data['update_by'] = $this->input->post('id');

		$data['name'] = $this->input->post('name');
		//$data['no_pegawai'] = $this->input->post('no_pegawai');
		$data['jabatan'] = $this->input->post('jabatan');
		$data['department'] = $this->input->post('department');
		//$data['user_type'] = $this->input->post('user_type');
		$data['email'] = $this->input->post('email');
		$data['group'] = $this->input->post('group');
		$data['lantai'] = $this->input->post('lantai');
		//$data['username'] = strtolower($data['username']);

		unset($data['password']);

		//print_r($data);

		$this->db->where('id',$data['id']);
		$update = $this->db->update('user',$data);

		$empty = true;
		if($update){
			//echo '{"status":"1","message":"Sukses mengubah data"}';
			//print_r($data);
			
			foreach ($data as $key => $value) {
				if(!empty($value)){
					$empty = false;
					//echo '{"status":"1","message":"Sukses mengubah data"}';
				}else{
					echo '{"status":-2,"message":"'.strtoupper($key).' belum diisi"}';
					$empty = true;
					return false;
				}
			}
			if(!$empty){
				echo '{"status":1,"message":"Sukses mengubah data"}';
			}
		}else{
			echo '{"status":-1,"message":"Error mengubah data (DB)"}';
		}

	}

	public function search(){
		$id = $this->input->post('id');
		$text = $this->input->post('text');

		if(!empty($id)){
			if(!empty($text)){
				$status = ['Waiting Approval','Order Received','Courir Assigned','Prepare Item','Courier On The Way','Done','Cancel'];

				$this->load->model('Model_mobile');
				$data = $this->Model_mobile->search_pemesanan($id,$text);

				$dt = json_decode(json_encode($data),true);

				if(!empty($dt)){
					foreach ($dt as $key =>$value) {
						//$dt[$key]['item_list']='';
						$dt[$key]['txt_stat']=$status[$dt[$key]['status']];
						$str = '';
						$item = $this->Model_mobile->ls_it_pemesanan($dt[$key]['id_pemesanan']);
						$rate = $this->Model_mobile->ck_rate($dt[$key]['id_pemesanan']);
						//print_r($item);
						if($item){
							foreach ($item as $in => $value) {
								
								$str .= ','.$value->item_name;
								$f_str = substr($str,1);
								$dt[$key]['item_list']=$f_str;

							}
						}else{
							
						}

						

						$dt[$key]['rate']=$rate[0];

						
					}
					echo json_encode($dt);
				}
			}
		}else{
			echo '{ "status":"-1","message":"ID Kosong" }';
		}

	}

	public function search_item(){
		$text = $this->input->post('text');
		// $query = $this->db->query("select * from pos_item where item_name like '%" . $text . "%' and is_delete=0");
		$this->load->model('model_produk');
		$this->load->model('model_mobile');

		$dt = [];
		$dt = json_decode(json_encode($this->model_produk->tb_item_is_av($text)),true);

		
		foreach ($dt as $in => $value) {
			$img = json_decode($this->model_mobile->getPhoto($dt[$in]['ID_ITEM']),true);
			$dt[$in]['img_name']=$img[0]['img_name'];
		}

		if(!empty($dt)){
			echo json_encode($dt);
		}
	}
}
?>