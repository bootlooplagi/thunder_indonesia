<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{		
		$var['logo_url_path']='assets/img/logo/logo.png';
		$this->load->view('view-login',$var);
	}

	public function validate(){
		
		$this->form_validation->set_rules('username','','required');
		$this->form_validation->set_rules('password','','required');

		if($this->form_validation->run()==TRUE){
			$q = $this->db->query("select * from user where 
									(username='".$this->input->post('username')."' || email='".$this->input->post('username')."') 
								and is_delete='0' and is_active='1'");

			if ($q->num_rows() > 0){

				$id_user = $q->row()->id;
				$username = $q->row()->username;
				$email = $q->row()->email;
				$password = $q->row()->password;
				$user_type = $q->row()->user_type;		
				$name = $q->row()->name;
				$no_pegawai = $q->row()->no_pegawai;
				$department = $q->row()->department;
				$jabatan = $q->row()->jabatan;
				$color1 = $q->row()->color1;
				$color2 = $q->row()->color2;
				$color3 = $q->row()->color3;
				

				if(($this->input->post('username')==$username || $this->input->post('username')==$email) && sha1(md5($this->input->post('password')))==$password){
					$data = array(	
					'id_user' => $id_user,		      
					'username' => $username,				
					'logged_in' => TRUE,
					'user_type' => $user_type,
					'name' => $name,
					'no_pegawai'=>$no_pegawai,
					'department'=>$department,
					'jabatan'=>$jabatan,
					'color1'=>$color1,
					'color2'=>$color2,
					'color3'=>$color3
					 );

					$this->session->set_userdata($data);

					redirect('home');
				}else{
					redirect($this->agent->referrer());					
				}

			}else{
			    redirect('login');
			}			

		}else{
			redirect('login');
		}

	}

	public function logout(){
		$this->session->sess_destroy();		
		redirect('login');
	}

	public function savetheme(){
		$data = $this->input->post();

		$this->db->where('id',$_SESSION['id_user']);
		$setcolor = $this->db->update('user',$data);


		if($setcolor){
			echo 'Sukses mengganti warna';
			$_SESSION['color1'] = $data['color1'];
			$_SESSION['color2'] = $data['color2'];
			$_SESSION['color3'] = $data['color3'];

			// echo $_SESSION['color1'];
		}else{
			echo "Gagal mengganti tema (Err Code: 0001)";
		}
	}

	

}