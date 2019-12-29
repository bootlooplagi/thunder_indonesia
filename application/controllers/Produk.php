<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	function __construct(){
		parent::__construct();
		

	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// $this->load->view('view-index');

	}

//####################  KATEGORI & SUB #############################
	public function kategori($mode=null){
			$var['user'] = $_SESSION['user_type'];

			if($mode=='add'){
				$code = $this->input->post('code');
				$nama = $this->input->post('nama');

				$u_code = $this->db->query("select upper(code) as code from pos_kategori where upper(code)='".strtoupper($code)."' and is_delete=0");

				if($u_code->num_rows()>0){
					echo json_encode((object)array('status_add'=>0,'message'=>'Error Menambahkan data. Kode sudah terdaftar. Err Code : 878787456'));
					die();
				}else{
					$this->load->model('model_produk');
					$add = $this->model_produk->add($code,$nama);
					$result_add = $this->model_produk->result_add();
					if($add){
						$result_add->status_add = 1;
						$result_add->message = 'Sukses menambahkan Data.';
						echo json_encode($result_add);
					}else{
						echo json_encode((object)array('status_add'=>0,'message'=>'Error Menambahkan data. Err Code : 74857'));
					}
				}

			}
			if($mode=='edit'){
				$id = $this->input->post('id');
				$code = $this->input->post('code');
				$nama = $this->input->post('nama');

				$u_code = $this->db->query("select upper(code) as code from pos_kategori where upper(code)='".strtoupper($code)."' and (not id=".$id . ") and is_delete=0");

				if($u_code->num_rows()>0){
					echo json_encode((object)array('status_edit'=>0,'message'=>'Error Menambahkan data. Kode sudah terdaftar. Err Code : 899358'));
					die();
				}else{
					$this->load->model('model_produk');
					$edit = $this->model_produk->edit($id,$code,$nama);
					if($edit){

						$edit['status_edit'] = 1;
						$edit['message'] = 'Sukses mengubah Data.';
						echo json_encode($edit);
					}else{
						echo json_encode((object)array('status_edit'=>0,'message'=>'Error Menambahkan data. Err Code : 56546'));
					}
				}
			}
			if($mode=='del'){
				$id = $this->input->post('id');
				$this->load->model('model_produk');
				$del = $this->model_produk->del_kategori($id);
				if($del){
					echo json_encode($del);
				}
			}
			if($mode=='view'){
				$var['s_active']='kategori';
				$var['js'] = 'js-kategori';
				$var['mode']='view';
				$var['page_title']='KATEGORI';
				$var['plugin'] = 'plugin_1';
				$var['content']='view-pos_kategori';
				$this->load->model('model_produk');
				$var['tb_kategori'] = $this->model_produk->tb_kategori();
				$this->load->view('view-index',$var);

			}	
	}

	public function ck_code_sub($code,$id=null){
		
		if(!empty($id)){
			$u_code = $this->db->query("select upper(sub_kategori_code) as code from pos_sub_kategori where upper(sub_kategori_code)='".strtoupper($code)."' and (not id=".$id.") and is_delete=0");
		}else{
			$u_code = $this->db->query("select upper(sub_kategori_code) as code from pos_sub_kategori where upper(sub_kategori_code)='".strtoupper($code)."' and is_delete=0");
		}

		if($u_code->num_rows()>0){
			return 1;
		}else{
			return 0;
		}
	}

	public function sub_kategori($mode=null){
		$var['user'] = $_SESSION['user_type'];

		if($mode=='view'){
			$var['s_active']='sub_kategori';
			$var['js'] = 'js-sub_kategori';
			$var['mode']='view';
			$var['page_title']='SUB KATEGORI';
			$var['plugin'] = 'plugin_1';
			$var['content']='view-pos_sub_kategori';
			$this->load->model('model_produk');
			$var['tb_kategori'] = $this->model_produk->tb_kategori();
			$var['tb_sub_kategori'] = $this->model_produk->tb_sub_kategori();
			$this->load->view('view-index',$var);
		}

		if($mode=='add'){
			$id_kat = $this->input->post('id_kat');
			$code = $this->input->post('code');
			$nama = $this->input->post('nama');
			$this->load->model('model_produk');

			if($this->ck_code_sub($code)){
				echo json_encode((object)array('status_add'=>0,'message'=>'Error Menambahkan data. Kode sub kategori sudah terdaftar. Err Code : 56546666'));
			}else{
				$add_sub = $this->model_produk->add_sub($id_kat,$code,$nama);
				$result_add_sub = $this->model_produk->result_add_sub();
				if($add_sub){
					$result_add_sub->status_add = 1;
					$result_add_sub->message = 'Sukses menambahkan Data.';
					echo json_encode($result_add_sub);
				}else{
					echo json_encode((object)array('status_add'=>0,'message'=>'Error Menambahkan data. Err Code : 156546666'));
				}
			}
		}

		if($mode=='edit'){
			$id = $this->input->post('id_sub_kat');
			$id_kat = $this->input->post('id_kat');
			$code = $this->input->post('code');
			$nama = $this->input->post('nama');

			if($this->ck_code_sub($code,$id)){
				echo json_encode((object)array('status_edit'=>0,'message'=>'Error Mengubah data. Kode sub kategori sudah terdaftar. Err Code : 5654667766'));
			}else{
				$this->load->model('model_produk');
				$edit_sub = $this->model_produk->edit_sub($id,$id_kat,$code,$nama);
				if($edit_sub){
					$edit_sub['status_edit'] = 1;
					$edit_sub['message'] = 'Sukses mengubah Data.';
					echo json_encode($edit_sub);
				}else{
					echo json_encode((object)array('status_edit'=>0,'message'=>'Error Menambahkan data. Err Code : 99476'));
				}
			}

		}

		if($mode=='del'){
			$id = $this->input->post('id');
			$this->load->model('model_produk');
			$del_sub = $this->model_produk->del_sub_kategori($id);
			if($del_sub){
				echo json_encode($del_sub);
			}
		}
	}
	public function kat_and_sub(){
		$var['user'] = $_SESSION['user_type'];

		$this->load->model('model_produk');
		$var['tb_kategori'] = $this->model_produk->tb_kategori();
		$var['tb_sub_kategori'] = $this->model_produk->tb_sub_kategori();

		$var['kats']=array();
		foreach ($var['tb_kategori'] as $kat=>$val) {
			array_push($var['kats'],$val);
		}
		$var['subs']=array();
		foreach ($var['tb_kategori'] as $kat=>$val) {
			array_push($var['subs'],[]);
			foreach ($var['tb_sub_kategori'] as $skat=>$sval) {
				if($sval->id_kat==$val->id){
					array_push($var['subs'][$kat],$sval);
				}
			}
		}
	}
	
//######################################################################

//####################################### ITEM #####################
	public function item($mode=null){
		$var['user'] = $_SESSION['user_type'];


		if($mode=='view'){
			$var['s_active']='item';
			$var['js'] = 'js-item';
			$var['mode']='view';
			$var['page_title']='STOK GUDANG';
			$var['plugin'] = 'plugin_1';
			$var['content']='view-pos_item';
			$this->load->model('model_produk');
			$var['tb_kategori'] = $this->model_produk->tb_kategori();
			$var['tb_sub_kategori'] = $this->model_produk->tb_sub_kategori();
			$var['tb_item'] = $this->model_produk->tb_item();

			$this->load->model('model_produk');
			$var['tb_kategori'] = $this->model_produk->tb_kategori();
			$var['tb_sub_kategori'] = $this->model_produk->tb_sub_kategori();

			//print_r($var['tb_sub_kategori']);
			$var['kats']=array();
			$var['subs']=array();
			if(!empty($var['tb_kategori'])){
				foreach ($var['tb_kategori'] as $kat=>$val) {
					array_push($var['kats'],$val);
				}

				foreach ($var['tb_kategori'] as $kat=>$val) {
					array_push($var['subs'],[]);
					if(!empty($var['tb_kategori'])){
						foreach ($var['tb_sub_kategori'] as $skat=>$sval) {
							if($sval->id_kat==$val->id){
								array_push($var['subs'][$kat],$sval);
							}
						}
					}
				}
			}
			

			$this->load->view('view-index',$var);

		}

		if($mode=='add'){
			$this->load->model('model_produk');
			$add_item = $this->model_produk->add_item();
			$result_add_item = $this->model_produk->result_add_item();
			if($add_item){
				echo json_encode($result_add_item);
			}
		}

		if($mode=='edit'){
			$this->load->model('model_produk');
			$edit_item = $this->model_produk->edit_item();
			if($edit_item){
				echo json_encode($edit_item);
			}
		}

		if($mode=='del'){
			$id = $this->input->post('id');
			$this->load->model('model_produk');
			$del_item = $this->model_produk->del_item($id);
			if($del_item){
				echo json_encode($del_item);
			}
		}
	}
	public function generate_barcode(){
		$rnd = $this->db->query('select floor(10000+(RAND()*69999)) as rnd');
		$r_rnd = $rnd->row()->rnd;

		$this->db->insert('barcode',array('id'=>$r_rnd));
		$err = $this->db->error();
		if($err['code']==1062){
			$this->db->insert('barcode',array('id'=>''));
		}


		$fnl = $this->db->insert_id();
		$bc_it = $this->db->query('select barcode from pos_item where barcode='.$r_rnd);

		if($bc_it->num_rows()>0){
			$this->generate_barcode();
		}else{
			echo $fnl;
		}
	}

	public function paket_item($mode=null,$id=null){
		$this->load->model('model_produk');

		$var['user'] = $_SESSION['user_type'];
		if($mode=='view'){
			$var['s_active']='paket_item';
			$var['js'] = 'js-paket_item';
			$var['mode']='view';
			$var['page_title']='PAKET ITEM';
			$var['plugin'] = 'plugin_1';
			$var['content']='view-paket_item';

			$var['tb_paket'] = $this->model_produk->tb_paket();
			//echo "SIAP";
			$this->load->view('view-index',$var);
		}

		if($mode=='edit'){
			$var['s_active']='paket_item';
			$var['js'] = 'js-paket_item';
			$var['mode']='edit';
			$var['page_title']='EDIT PAKET';
			$var['plugin'] = 'plugin_1';
			$var['content']='view-paket_item';
			$var['id'] = $id;
			$var['tb_paket'] = $this->model_produk->list_item_paket($id);
			$var['items'] = $this->model_produk->tb_item_is_av();
			$var['list'] = $this->model_produk->list_item_paket($id);
			// print_r($var['tb_paket']);

			$this->load->view('view-index',$var);
		}

		if($mode=='add'){
			$var['s_active']='paket_item';
			$var['js'] = 'js-paket_item';
			$var['mode']='add';
			$var['page_title']='ADD PAKET';
			$var['plugin'] = 'plugin_1';
			$var['content']='view-paket_item';
			$var['id'] = $id;

			$var['items'] = $this->model_produk->tb_item_is_av();


			$this->load->view('view-index',$var);
		}

		if($mode=='submit'){
			$post = $this->input->post();
			
			if($post['mode']=='add'){
				$dataPackage = array(	
										'barcode'=>$post['no_paket'],
										'jenis_item'=>'PAKET',
										'item_name'=>$post['nama'],
										'harga_jual'=>$post['harga'],
										'item_description'=>$post['deskripsi'],
										'insert_by'=>$_SESSION['id_user'],
										'update_by'=>$_SESSION['id_user']
									);

				
				$dataPackageItems = $post['item'];
				$saveToPackage = $this->model_produk->saveToPackage($dataPackage);
				foreach ($dataPackageItems as $key => $value) {
					$dataPackageItems[$key]['id_item_package']=$saveToPackage;
					$dataPackageItems[$key]['insert_by']=$_SESSION['id_user'];
					$dataPackageItems[$key]['update_by']=$_SESSION['id_user'];
				}
				

				$saveToPackageItems = $this->model_produk->saveToPackageItems($dataPackageItems);
			}

			if($post['mode']=='edit'){
				$dataPackage = array(
										'item_name'=>$post['nama'],
										'harga_jual'=>$post['harga'],
										'item_description'=>$post['deskripsi'],
										'update_by'=>$_SESSION['id_user']
									);

				
				$dataPackageItems = $post['item'];
				$updateToPackage = $this->model_produk->updateToPackage($dataPackage,$post['id']);
				foreach ($dataPackageItems as $key => $value) {
					$dataPackageItems[$key]['id_item_package']=$post['id'];
					$dataPackageItems[$key]['update_by']=$_SESSION['id_user'];
				}
				

				$updateToPackageItems = $this->model_produk->updateToPackageItems($dataPackageItems,$post['del']);
			}
			
			
		}

		if($mode=='delete'){
			$id_package = $this->input->post('id');
			$deletePackage = $this->model_produk->deletePackage($id_package);
		}
	}
//######################################################################




	public function upload($id){

		if(isset($_FILES['image'])){
			foreach ($_FILES['image']['name'] as $key => $value) {
				$errors= array();

				$file_name = $_FILES['image']['name'][$key];
				$file_size = $_FILES['image']['size'][$key];
				$file_tmp = $_FILES['image']['tmp_name'][$key];
				$file_type = $_FILES['image']['type'][$key];
				$ext=explode('.',$file_name);
				$file_ext = strtolower(end($ext));
				
				$expensions= array("jpeg","jpg","png");

				if(in_array($file_ext,$expensions)=== false){
				 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
				}

				if($file_size > 2097152) {
				 $errors[]='File size must be excately 2 MB';
				}

				if(empty($errors)==true) {
					$name = 'ID'.$id.'_G'.$key.'.jpg';
				 	move_uploaded_file($file_tmp,"./assets/img/".$name);
				 	$this->load->model('model_produk');
				 	$var['saveToDB'] = $this->model_produk->saveImgToDB($id,$name);
				 	echo "Success";
				}else{
				 	print_r($errors);
				}
			}
	   	}
	}

	public function getPhoto(){
		$id=$this->input->post('id');
		$res=$this->db->get_where('img_item',array('id_item'=>$id));
		if ($res->num_rows() > 0){
		    echo json_encode($res->result());
		}else{
		    echo NULL;
		}
	}

	public function cekBarcodeItem($barcode=null){
		$this->load->model('model_produk');
		$var['barcode']=$this->model_produk->ck_barcode($barcode);
		echo $var['barcode'];
	}

	public function printbarcode(){
		$this->load->library('barcode');
		$bc = $this->db->query("select * from pos_item where id=".$this->input->get('id'));
		//echo $this->input->get('id');
		//print_r($bc->result());
		if($bc->num_rows()>0){
			$barcode = $bc->row()->barcode;
			$nama = $bc->row()->item_name;

			$this->barcode->print_barcode($barcode,$nama);
		}else{
			echo "Item tidak ada atau barcode kosong.";
		}
	}

	public function barang_hilang(){
		$this->load->model('model_produk');
		$var['user'] = $_SESSION['user_type'];
		$var['page_title']='BARANG HILANG';
		$var['js']='js-barang_hilang';
		$var['plugin']='plugin_1';
		$var['s_active'] = 'barang_hilang';
		$var['content']='view-barang_hilang';
		$var['produk']=$this->model_produk->getHilang();
		$this->load->view('view-index',$var);
	}

	public function add_barang_hilang(){
		$var['mode']='add';
		$this->load->model('model_produk');
		$var['barang'] = $this->model_produk->getProduk();
		$this->load->view('view-add_barang_hilang',$var);
	}

	public function insert_barang_hilang(){
		$data = $_POST['data'];
		$data['insert_by']=$_SESSION['id_user'];
		$data['update_by']=$_SESSION['id_user'];

		$insert = $this->db->insert('barang_hilang',$data);
		$update_item = $this->db->query("update pos_item set qty=qty-1 where id=".$data['id_barang']);

		if ($insert && $update_item) {
			echo "Sukses menginput Data Barang Hilang";
		}else{
			echo "Gagal menginput Data Barang Hilang";
		}

	}

	public function edit_barang_hilang(){
		$var['mode']='edit';
		$this->load->model('model_produk');
		$var['barang'] = $this->model_produk->getProduk();
		$var['id_barang']=$_POST['id'];
		$var['data']=$this->model_produk->getHilang($_POST['id']);

		$this->load->view('view-add_barang_hilang',$var);
	}

	public function rev_barang_hilang(){
		$id = $_POST['id_barang'];
		$data = $_POST['data'];
		$data['insert_by']=$_SESSION['id_user'];
		$data['update_by']=$_SESSION['id_user'];

		$insert = $this->db->where('id',$id)->update('barang_hilang',$data);

		if ($insert) {
			echo "Sukses menginput Data Barang Hilang";
		}else{
			echo "Gagal menginput Data Barang Hilang";
		}

	}

	public function found_barang_hilang(){
		$id = $_POST['id_barang'];
		$id_item = $_POST['id_item'];

		$insert = $this->db->where('id',$id)->update('barang_hilang',array('found'=>1,'update_by'=>$_SESSION['id_user'],'found_date'=>date('Y-m-d H:i:s')));

		$update_item = $this->db->query("update pos_item set qty=qty+1 where id=".$id_item);
		
		if ($insert && $update_item) {
			echo "Sukses mengubah data.";
		}else{
			echo "Gagal mengubah data.";
		}

	}

	public function getdurasi(){
		$id = $_POST['id'];
		$this->load->model('model_produk');
		$dur = $this->model_produk->getDurasi($id);

		if(!empty($dur)){
			echo json_encode($dur);
		}else{
			echo null;
		}
		
	}

	public function addExternal(){
		if(!empty($_POST['data'])){
			$data = $_POST['data'];

			$data['barcode'] = time();
			$data['insert_by'] = $_SESSION['id_user'];
			$data['update_by'] = $_SESSION['id_user'];

			$insert = $this->db->insert('pos_item',$data);
			$id_item = $this->db->insert_id();

			$insert_durasi = $this->db->insert('durasi',array(
				'id_item'=>$id_item,
				'name'=>'1 Hari',
				'harga'=>$_POST['data']['harga_jual'],
				'insert_by'=>$_SESSION['id_user'],
				'update_by'=>$_SESSION['id_user']
			));

			if($insert && $insert_durasi){
				$res = $this->db->get_where('pos_item',array('id'=>$id_item));
				if($res->num_rows()>0){
					echo json_encode(array(
						'status'=>1,
						'message'=>'Sukses menambahkan item external.',
						'result'=>$res->row()
					));
				}else{
					echo json_encode(array(
						'status'=>0,
						'message'=>'Gagal menambahkan item External. Err Code : 6234878',
						'result'=>null
					));
				}
			}else{
				echo json_encode(array(
					'status'=>0,
					'message'=>'Gagal menambahkan item External. Err Code : 987345',
					'result'=>null
				));
			}
		}else{
			echo json_encode(array(
				'status'=>0,
				'message'=>'Gagal menambahkan item External. Data tidak lengkap. Err Code : 8787',
				'result'=>null
			));
		}
	}
}