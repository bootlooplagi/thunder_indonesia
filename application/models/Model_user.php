<?php 
class Model_user extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	public function index(){
		$id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$query = $this->db->query('select * from user where id='.$id);

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}
	public function tb_customer($role=null){
		$customer = '';
		if($role=='Customer'){
			$customer='=';
		}
		if($role=='User'){
			$customer='!=';
		}

		$query = $this->db->query('select us.id as id_user,us.*,u.username as update_by_username from user as us join user as u where us.update_by=u.id and us.is_delete=0 and us.user_type '.$customer.'"Customer"');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function ck_user($u=null,$e=null,$t=null){

		if($t=='Karyawan'){
			$query = $this->db->query('select username from user where username="'. $u .'" or email="' . $e . '"');
		}else{
			$query = $this->db->query('select username from user where username="'. $u .'"');
		}
		

		if ($query->num_rows() > 0){
		    return true;
		}else{
		    return NULL;
		}
	}

	public function list_customer(){
		$query = $this->db->query('select * from user where user_type="Customer" and is_delete=0 and is_active=1');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function list_kurir(){
		$query = $this->db->query('select id,username,name from user where user_type="Kurir" and is_delete=0 and is_active=1');

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}

	public function sendMail($email=null,$nama=null,$user_id=null,$group=null,$lantai=null,$username=null,$password=null){
		//$a = file_get_contents("file/registrasi.php");
		$this->load->library('mail');
		
		
		$html = '<div >
					<div >
						<center><h3>Bukti Registrasi Akun Karyawan PT. TUGU PRATAMA INDONESIA</h3></center>

						<p style="text-align:justify; text-indent: 40px;">Terimakasih anda telah melakukan registrasi Akun Karyawan <b>PT. TUGU PRATAMA INDONESIA</b>. Berikut ini adalah informasi mengenai Registrasi Akun Anda :</p>

					<pre>
					Nama		: '. $nama .'
					Group		: '. $group .'
					Lantai		: '. $lantai .'
					Email		: '. $email .'
					Jabatan		: KARYAWAN

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
}
?>