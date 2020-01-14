<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct() { 
		parent::__construct(); 
		//$this->load->library('mail');
		//$this->load->library('email'); //tambahkan dalam contruct pemanggil libarary mail
	}
	public function index(){}

	public function sendMail($email=null,$nama=null,$user_id=null,$group=null,$lantai=null,$username=null,$password=null){
		//$a = file_get_contents("file/registrasi.php");
		$this->load->library('mail');
		
		
		$html = '<div >
					<div >
						<center><h3>Bukti Registrasi Akun Karyawan PT. TUGU PRATAMA INDONESIA</h3></center>

						<p style="text-align:justify; text-indent: 40px;">Terimakasih anda telah melakukan registrasi Akun Karyawan <b>PT. TUGU PRATAMA INDONESIA</b>. Berikut ini adalah informasi mengenai Registrasi Akun Anda :</p>

					<pre>
					Nomor ID	: '. $user_id .'
					Nama		: '. $nama .'
					Group		: '. $group .'
					Lantai		: '. $lantai .'
					Email		: '. $email .'
					Jabatan		: STAFF

					Username	: <b>'. $username .'</b>
					Password	: <b>'. $password .'</b>
					</pre>

							<p style="text-align:justify; text-indent: 40px;">Mohon untuk tidak memberitahukan password kepada siapapun. Silahkan <a href="http://www.myogir.com/office_appliance" target="_blank">KLIK DISINI</a> untuk login.<br>
							</p>
						<p style="text-align:justify; text-indent: 40px;">Terimakasih.</p>
					</div>
				</div>';

		return $this->mail->register($email,$nama,'Registrasi Akun Karyawan',$html);
	}

	public function mailForgetPassword($email=null,$newpassword=null,$nama=null){
		$this->load->library('mail');
		$html = 'Akun dengan email <b>' . $email . '</b> telah melakukan forgot password dengan password baru : <br><br> <h2>'.$newpassword.'</h2><br><br> Silahkan login dengan menggunakan password tersebut.';
		return $this->mail->forgotPassword($email,$nama,'Forgot Akun Karyawan Akun Karyawan',$html);
	}

	public function ch_pass(){
		//$var['user'] = $_SESSION['user_type'];
		$id = $_SESSION['id_user'];

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

	public function register($dt=null){
		$var['js']='js-register';
		$this->load->view('view-register',$var);
	}

	public function forget($dt=null){
		$var['js']='js-forgot';
		$this->load->view('view-forgot',$var);
	}

	public function submit_register($ck=null){
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
					$email_stat = $this->sendMail($email,$name,$user_id,$group,$lantai,$username,$password);

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
							echo '{"status":"-3","message":"Registrasi Error, Silahkan coba kembali"}';
						}
					}else{
						echo '{"status":"-4","message":"Registrasi Error, Silahkan coba kembali"}';
					}
				}
			}
		}

	}

	public function randomPassword() {
		 // $alphabet = '1234567890';
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	public function submit_forget(){
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$q_akun = $this->db->query("select * from user where email='".$email."' and username='".$username."'");

		

		if($q_akun->num_rows()>0){
			$id = $q_akun->row()->id;
			//$user_id = $q_akun->row()->user_id;
			$name = $q_akun->row()->name;
			$group = $q_akun->row()->group;
			$lantai = $q_akun->row()->lantai;
			$username = $q_akun->row()->username;
			$password = $this->randomPassword();

		 	$email_stat = $this->mailForgetPassword($email,$password,$name);
		 	
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
			echo '{"status":"-3","message":"Tidak dapat menemukan User dengan Email tersebut"}';
		}
	}
}

?>