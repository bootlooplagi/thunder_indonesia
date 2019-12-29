<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class customer extends CI_Controller {
	function __construct(){
		parent::__construct();

	}

	public function index(){

	}
	public function view(){
		$var['user'] = $_SESSION['user_type'];
		$var['s_active']='user';
		$var['js'] = 'js-customer';
		$var['mode']='view';
		$var['page_title']='USER MANAGEMENT';
		$var['plugin'] = 'plugin_1';
		$var['content']='view-customer';
		$this->load->model('model_user');
		$var['tb_customer'] = $this->model_user->tb_customer('User');
		$this->load->view('view-index',$var);
	}

	public function view_customer(){
		$var['user'] = $_SESSION['user_type'];
		$var['s_active']='customer';
		$var['js'] = 'js-customer';
		$var['mode']='view';
		$var['page_title']='CUSTOMER MANAGEMENT';
		$var['plugin'] = 'plugin_1';
		$var['content']='view-customer';
		$this->load->model('model_user');
		$var['tb_customer'] = $this->model_user->tb_customer('Customer');
		$this->load->view('view-index',$var);
	}

	public function add(){
		$this->load->model('model_user');

		$id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$data = $this->input->post();
		$u_available = $this->model_user->ck_user($data['username'],$data['email'],$data['user_type']);


		if($u_available){
			echo 'duplicate';
		}else{
			$data['insert_by'] = $id;
			$data['update_by'] = $id;
			$data['username'] = strtolower($data['username']);
			if($data['user_type']=='Karyawan'){
				$pass = $this->model_user->randomPassword();
				$data['password'] = sha1(md5($pass));

				$email_stat = $this->model_user->sendMail($data['email'],$data['name'],'',$data['group'],$data['lantai'],$data['username'],$pass);

				if($email_stat == '1'){
					$stat = $this->db->insert('user',$data);
					$l_id = $this->db->insert_id();
					if($stat){
						$this->db->where('id',$l_id);
						$this->db->update('user',array(
														'is_active'=>1,
														'active_by'=>$l_id,
														'insert_by'=>$l_id,
														'update_by'=>$l_id
													));
						echo 'success';
					}else{
						echo 'error1';
					}
				}else{
					echo 'error2';
					//print_r($email_stat);
				}
			}else{
				$data['password'] = sha1(md5('12345678'));

				$stat = $this->db->insert('user',$data);
				$l_id = $this->db->insert_id();
				if($stat){
					$this->db->where('id',$l_id);
					$this->db->update('user',array(
													'active_by'=>$l_id,
													'insert_by'=>$l_id,
													'update_by'=>$l_id
												));
					echo 'success';
				}else{
					echo 'error';
				}
			}

			
			// if($stat){
			// 	echo 'success';
			// }else{
			// 	echo 'error';
			// }
		}

	}

	public function add_customer(){
		$post = $this->input->post();

		$post['is_active']=1;
		$post['user_type']='Customer';
		$post['active_by']=$_SESSION['id_user'];
		$post['insert_by']=$_SESSION['id_user'];
		$post['update_by']=$_SESSION['id_user'];

		
		$save = $this->db->insert('user',$post);

		if($save){
		    echo '{"status":1,"message":"Sukses menambahkan user"}';
		}else{
		     echo '{"status":0,"message":"Error menambahkan user"}';
		}
	}

	public function edit_customer(){
		$post = $this->input->post();

		$post['is_active']=1;
		$post['user_type']='Customer';
		$post['active_by']=$_SESSION['id_user'];
		$post['insert_by']=$_SESSION['id_user'];
		$post['update_by']=$_SESSION['id_user'];

		
		$this->db->where('id',$post['id']);
		$save = $this->db->update('user',$post);

		if($save){
		    echo '{"status":1,"message":"Sukses mengubah data user"}';
		}else{
		     echo '{"status":0,"message":"Error mengubah data user"}';
		}
	}

	public function ubahStaff(){
		$this->db->where('user_type','Staff');
		$act = $this->db->update('user',array('user_type'=>'Karyawan'));

		if($act){
			echo "Success";
		}else{
			echo "Gagal";
		}
	}
	public function edit(){
		$id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$data = $this->input->post();
		$ck_user = $this->db->query('select update_by from user where id=' . $data['id']);

		if($ck_user->row()->update_by!=0){
			$data['update_by'] = $id;
		}

		$data['insert_by'] = $id;
		

		$data['name'] = $this->input->post('name');
		$data['no_pegawai'] = $this->input->post('no_pegawai');
		$data['jabatan'] = $this->input->post('jabatan');
		$data['department'] = $this->input->post('department');
		$data['user_type'] = $this->input->post('user_type');
		$data['group'] = $this->input->post('group');
		$data['username'] = strtolower($data['username']);

		if($this->input->post('user_type')=='Karyawan'){
			$data['email'] = $this->input->post('email');
			$data['lantai'] = $this->input->post('lantai');
		}

		unset($data['password']);

		$this->db->where('id',$data['id']);
		$this->db->update('user',$data);

	}

	public function delete(){
		$id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$data = $this->input->post();

		$data['delete_by'] = $id;
		$data['delete_date'] = date('Y-m-d H:i:s');
		$data['is_delete'] = 1;

		$this->db->where('id',$data['id']);
		$s = $this->db->update('user',$data);

		if($s){
			echo 'success';
		}else{
			echo 'error';
		}

	}

	public function activate(){
		$id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$data = $this->input->post();

		$data['active_by'] = $id;
		$data['active_date'] = date('Y-m-d H:i:s');
		$data['is_active'] = 1;

		$this->db->where('id',$data['id']);
		$s = $this->db->update('user',$data);

		if($s){
			echo 'success';
		}else{
			echo 'error';
		}

	}

	public function alert(){
		echo '';
	}

	public function add_freelance(){
		$name = $_POST['name'];
		$insert = $this->db->insert('user',array('name'=>$name,'user_type'=>'Freelance','is_freelance'=>1,'insert_by'=>$_SESSION['id_user'],'update_by'=>$_SESSION['id_user'],'is_active'=>1));
		if($insert){
			echo '{"id":'.$this->db->insert_id().',"status":1,"message":"Sukses input data freelance"}';
		}else{
			echo '{"id":"","status":0,"message":"Gagal input data freelance"}';
		}

	}

	

}
?>
