<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class service extends CI_Controller {

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
		//HARUSNYA DIISI HALAMAN DASHBOARD
		$data['title'] = 'Service';
		$data['page_title'] = 'SERVICE';
		$data['content'] = 'view-service';
		$data['s_active']='service';
		$data['js'] = 'js-service';
		$data['plugin'] = 'plugin_1';
		$data['user'] = $_SESSION['user_type'];
		$data['mode']='view';

		$this->load->model('model_produk');
		$this->load->model('model_service');

		$data['items'] = $this->model_produk->tb_item();
		$data['tb_service'] = $this->model_service->tb_service();
		$this->load->view('view-index',$data);
	}

	public function view_add(){
		$data['title'] = 'Service';
		$data['page_title'] = 'SERVICE';
		$data['content'] = 'view-service';
		$data['s_active']='service';
		$data['js'] = 'js-service';
		$data['plugin'] = 'plugin_1';
		$data['user'] = $_SESSION['user_type'];
		$data['mode']='add';

		$this->load->model('model_produk');
		$this->load->model('model_service');

		$data['items'] = $this->model_produk->tb_item();
		$data['tb_service'] = $this->model_service->tb_service();
		$data['vendor'] = $this->model_service->vendor();

		$this->load->view('view-index',$data);
	}

	public function view_edit(){
		$id_service = $_GET['id'];
		$data['title'] = 'Service';
		$data['page_title'] = 'SERVICE';
		$data['content'] = 'view-service';
		$data['s_active']='service';
		$data['js'] = 'js-service';
		$data['plugin'] = 'plugin_1';
		$data['user'] = $_SESSION['user_type'];
		$data['mode']='edit';

		$this->load->model('model_produk');
		$this->load->model('model_service');

		$data['produk']= $this->model_service->ls_produk($id_service);
		$data['items'] = $this->model_produk->tb_item();
		$data['tb_service'] = $this->model_service->tb_service($id_service);
		$data['vendor'] = $this->model_service->vendor();

		$this->load->view('view-index',$data);
	}


	public function add(){
		$data = json_decode(json_encode($this->input->post('data')),true);
		$data[0]['insert_by'] = $_SESSION['id_user'];
		$data[0]['update_by'] = $_SESSION['id_user'];

		// $update_item = $this->db->query("update pos_item set qty=(qty-".$data[0]['jml_barang'].") where id=". $data[0]['id_item']);

		$insert = $this->db->insert('service',$data[0]);
		$insert_last_id = $this->db->insert_id();

		if($insert){
			echo '{"status":1,"message":"Sukses Menambahkan Data Service"}';
			// if($update_item){
				
			// }else{
			// 	echo '{"status":0,"message":"Error saat menambah data Service"}';
			// 	$rollback = $this->db->delete('service',array('id'=>$insert_last_id));
			// }
		}else{
			echo '{"status":0,"message":"Error saat menambahkan data Service"}';
		}
	}

	public function edit(){
		$data = json_decode(json_encode($this->input->post('data')),true);
		$id = $this->input->post('id');
		$data[0]['insert_by'] = $_SESSION['id_user'];
		$data[0]['update_by'] = $_SESSION['id_user'];

		$this->db->where('id',$id);
		$insert = $this->db->update('service',$data[0]);

		if($insert){
			echo '{"status":1,"message":"Sukses Mengubah Data Service"}';
		}else{
			echo '{"status":0,"message":"Error saat mengubah data Service"}';
		}
	}

	public function delete(){
		// $data = json_decode(json_encode($this->input->post('data')),true);
		$id = $this->input->post('id');

		$data[0]['update_by'] = $_SESSION['id_user'];
		$data[0]['delete_by'] = $_SESSION['id_user'];
		$data[0]['delete_date'] = date('Y-m-d hh:mm:ss');
		$data[0]['is_delete'] = 1;

		$this->db->where('id',$id);
		$insert = $this->db->update('service',$data[0]);

		if($insert){
			echo '{"status":1,"message":"Sukses Menghapus Data Service"}';
		}else{
			echo '{"status":0,"message":"Error saat menghapus data Service"}';
		}
	}

	public function done(){
		// $data = json_decode(json_encode($this->input->post('data')),true);
		$id = $this->input->post('id');

		$data[0]['jml_barang'] = $this->input->post('jml_barang');
		$data[0]['id_item'] = $this->input->post('id_item');
		$data[0]['status_service'] = 1;
		$data[0]['update_by'] = $_SESSION['id_user'];

		$update_item = $this->db->query("update pos_item set qty=(qty+".$data[0]['jml_barang'].") where id=". $data[0]['id_item']);

		$this->db->where('id',$id);
		$status = $this->db->update('service',$data[0]);

		if($status){
			if($update_item){
				echo '{"status":1,"message":"Sukses Mengubah Status Data Service"}';
			}else{
				echo '{"status":0,"message":"Error saat mengubah status data Service"}';
				
				$this->db->where('id',$id);
				$status = $this->db->update('service',array('status_service'=>0));
			}
		}else{
			echo '{"status":0,"message":"Error saat mengubah status data Service"}';
		}
	}

	public function submit_service(){
		$detail = $_POST['detail'];
		$items = $_POST['items'];

		$detail['insert_by'] = $_SESSION['id_user'];
		$detail['update_by'] = $_SESSION['id_user'];

		$insert = $this->db->insert('service',$detail);
		$insert_id = $this->db->insert_id();

		$updateIT = count($items);

		foreach ($items as $key => $value) {
			$items[$key]['id_service']=$insert_id;
			$items[$key]['insert_by'] = $_SESSION['id_user'];
			$items[$key]['update_by'] = $_SESSION['id_user'];

			$updateItem = $this->db->query("update pos_item set qty=(qty-1) where id=". $value['id_item']);
			if($updateItem){
				$updateIT--;
			}
		}

		$insertItem = $this->db->insert_batch('item_service',$items);		

		if($insert && $insertItem && ($updateIT==0)){
			echo '{"status":1,"message":"Sukses menginput data Service"}';
		}else{
			echo '{"status":0,"message":"Gagal menginput data Service"}';
		}

	}

	public function submit_edit_service(){
		$id_service = $_POST['id_service'];
		$detail = $_POST['detail'];
		$items = !empty($_POST['items']) ? $_POST['items']:[]; //fromClient
		$itemsServer = !empty($_POST['itemsserver']) ? $_POST['itemsserver']:[];
		$itemsDeleted = !empty($_POST['itemsdeleted']) ? $_POST['itemsdeleted']:[]; //fromClient
		$itemsDone = !empty($_POST['itemsdone']) ? $_POST['itemsdone']:[]; //fromClient
		$itemsFail = !empty($_POST['itemsfail']) ? $_POST['itemsfail']:[]; //fromClient

		$detail['insert_by'] = $_SESSION['id_user'];
		$detail['update_by'] = $_SESSION['id_user'];

		$update_detail = $this->db->where('id',$id_service)->update('service',$detail);
		// $insert_id = $this->db->insert_id();

		$updateIT = !empty($items)?count($items):0;
		$updateProdService = count($itemsServer);
		$updateDeleted = !empty($itemsDeleted)?count($itemsDeleted):0;
		$updateDone = !empty($itemsDone)?count($itemsDone):0;
		$updateFail = !empty($itemsFail)?count($itemsFail):0;

		if(!empty($items)){
			foreach ($items as $key => $value) {
				$items[$key]['id_service']=$id_service;
				$items[$key]['insert_by'] = $_SESSION['id_user'];
				$items[$key]['update_by'] = $_SESSION['id_user'];

				$updateItem = $this->db->query("update pos_item set qty=(qty-1) where id=". $value['id_item']);
				if($updateItem){
					$updateIT--;
				}
			}
		}

		foreach ($itemsServer as $s_key => $s_value) {
			// $itemsServer[$s_key]['insert_by'] = $_SESSION['id_user'];
			$itemsServer[$s_key]['update_by'] = $_SESSION['id_user'];

			$updateITService = $this->db->where('id',$s_value['id'])
										->update('item_service',$itemsServer[$s_key]);

			if($updateITService){
				$updateProdService--;
			}
		}

		foreach ($itemsDeleted as $d_key => $d_value) {
			$itemsDeleted[$d_key]['delete_by'] = $_SESSION['id_user'];
			$itemsDeleted[$d_key]['delete_date'] = date('Y-m-d H:i:s');
			$itemsDeleted[$d_key]['is_delete'] = 1;

			$updateITDeleted = $this->db->where('id',$d_value['id'])
										->update('item_service',$itemsDeleted[$d_key]);

			$updateItemDeleted = $this->db->query("update pos_item set qty=(qty+1) where id=". $d_value['id_item']);

			if($updateITDeleted && $updateItemDeleted){
				$updateDeleted--;
			}
		}

		foreach ($itemsDone as $dn_key => $dn_value) {
			$itemsDone[$dn_key]['status'] = 1;
			$itemsDone[$dn_key]['done_date'] = date('Y-m-d H:i:s');
			$itemsDone[$dn_key]['fail_date'] = null;
			// $itemsDone[$dn_key]['is_delete'] = 1;

			$updateITDone = $this->db->where('id',$dn_value['id'])
										->update('item_service',$itemsDone[$dn_key]);

			$updateItemDone = $this->db->query("update pos_item set qty=(qty+1) where id=". $dn_value['id_item']);

			if($updateITDone && $updateItemDone){
				$updateDone--;
			}
		}

		foreach ($itemsFail as $fl_key => $fl_value) {
			$itemsFail[$fl_key]['status'] = 2;
			$itemsFail[$fl_key]['fail_date'] = date('Y-m-d H:i:s');
			$itemsFail[$fl_key]['done_date'] = null;
			// $itemsFail[$fl_key]['is_delete'] = 1;

			$updateITFail = $this->db->where('id',$fl_value['id'])
										->update('item_service',$itemsFail[$fl_key]);

			// $updateItemFail = $this->db->query("update pos_item set qty=(qty+1) where id=". $fl_value['id_item']);

			if($updateITFail){
				$updateFail--;
			}
		}

		$insertItem = !empty($items) ? $this->db->insert_batch('item_service',$items):1;		

		if($update_detail && $insertItem && ($updateIT==0) && ($updateProdService==0) && ($updateDeleted==0) && ($updateDone==0) && ($updateFail==0)){
			echo '{"status":1,"message":"Sukses menginput data Service"}';
		}else{
			echo '{"status":0,"message":"Gagal menginput data Service"}';
		}

	}

	public function add_vendor(){
		$data = $_POST['data'];

		// $data = array(
		// 				'nama_vendor' => 'asdasd',
		// 			    'pic' => 'dadasd',
		// 			    // 'no_telp' => 24324,
		// 			    // 'no_hp' => 234234,
		// 			    'alamat_vendor' => 'asdas'
		// 			);
		$data['insert_by'] = $_SESSION['id_user'];
		$data['update_by'] = $_SESSION['id_user'];
		$insert = $this->db->insert('vendor',$data);

		if($insert){
			echo '{"status":1,"message":"Sukses menambahkan data Vendor"}';
		}else{
			echo '{"status":0,"message":"Gagal menambahkan data Vendor"}';
		}
	}

}