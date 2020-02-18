<?php 
class Model_produk extends CI_Model {
	function __construct(){
		parent::__construct();
	}
////#################################### KATEGORI ##############################################
	public function tb_kategori(){
	 	$query = $this->db->query("select mt.id, mt.code, mt.description, u.username as update_by_username, mt.update_date from pos_kategori as mt left join user as u on u.id = mt.update_by where mt.is_delete = '0'");

		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}
	public function add($code,$nama){

		$response=false;
		if($code == null || $nama == null){
			$response = false;
			return $response;
		}else{
			$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
			$data=array(
						'pos_type'=>'KANTOR',
						'code'=>$code,
						'description'=>$nama,
						'insert_by'=>$session_id,
						'update_by'=>$session_id
					);
			$add_stat = $this->db->insert('pos_kategori',$data);
			

			if($add_stat){
				$response = true;
			}else{
				$response = false;

			}
			return $response;
			
		}
		
	}
	public function edit($id,$code,$nama){
		$update_by = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';

        $data= array(
              'description'=>$nama,
              'code'=>$code,

              'update_by'=>$update_by,
        );

        //update data
        $this->db->where('id',$id);
        $save = $this->db->update('pos_kategori',$data);

        if($save){
              $response = array (
                    "status" => 'success',                    
                    "message" => 'Data updated'
              );
        }else{                                                
              $response = array(
                    "status" => 'error',                      
                    "message" => 'Error: Update failed'
              );
        }   
        return $response;        
	}
	public function result_add(){
		$query = $this->db->query("select mt.id, mt.code, mt.description, u.username as update_by_username, mt.update_date from pos_kategori as mt left join user as u on u.id = mt.update_by where mt.is_delete = '0' and mt.id = (select last_insert_id())");


	    if ($query->num_rows() > 0){
	          return $query->row();
	    }else{
	          return NULL;
	    }
	}
	public function del_kategori(){
		$id = $this->input->post('id');
		$delete_by = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$delete_date = date('Y-m-d H:i:s');

		$this->db->where('id',$id);
		$save = $this->db->update('pos_kategori',array('delete_by'=>$delete_by, 'delete_date'=>$delete_date, 'is_delete'=>'1')); 

		if($save){
		    $response = array(
		          "status" => 'success',                    
		          "message" => 'Success delete market type'
		    );
		}else{
		     $response = array(
		          "status" => 'error',                      
		          "message" => 'Error: Failed delete market type'
		    );
		}           

		return $response;
	}

//####################################   SUB KATEGORI ########################################
	public function tb_sub_kategori(){
		$query = $this->db->query("select 
									pk.code as kategori_code,
									pk.description as deskripsi_kategori,
									mt.id,
									mt.sub_kategori_code,
									mt.sub_description,
									pk.id as id_kat, 
									u.username as update_by_username, 
									mt.update_date 
								from 
									pos_kategori as pk,
									pos_sub_kategori as mt left join user as u on u.id = mt.update_by where mt.is_delete = '0' and pk.is_delete = '0' and pk.id=mt.id_kategori order by mt.update_date desc");


		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}
	public function add_sub($id_kat,$code,$nama){
		$response=false;
		if($id_kat == null || $code == null || $nama == null){
			$response = false;
			return $response;
		}else{
			$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
			$data=array(
						'pos_type'=>'KANTOR',
						'id_kategori'=>$id_kat,
						'sub_kategori_code'=>$code,
						'sub_description'=>$nama,
						'insert_by'=>$session_id,
						'update_by'=>$session_id
					);
			$add_stat = $this->db->insert('pos_sub_kategori',$data);
			

			if($add_stat){
				$response = true;
			}else{
				$response = false;

			}
			return $response;
			
		}	
	}
	public function result_add_sub(){
		$query = $this->db->query("select 
									pk.code as kategori_code,
									pk.description as deskripsi_kategori,
									mt.id,
									mt.sub_kategori_code,
									mt.sub_description,
									pk.id as id_kat, 
									u.username as update_by_username, 
									mt.update_date 
								from 
									pos_kategori as pk,
									pos_sub_kategori as mt left join user as u on u.id = mt.update_by where mt.is_delete = '0' and pk.is_delete = '0' and pk.id=mt.id_kategori and mt.id = (select last_insert_id())");


	    if ($query->num_rows() > 0){
	          return $query->row();
	    }else{
	          return NULL;
	    }
	}
	public function edit_sub($id,$id_kat,$code,$nama){
		$update_by = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';

        $data= array(
        		'id_kategori'=>$id_kat,
             	'sub_description'=>$nama,
             	'sub_kategori_code'=>$code,
             	'update_by'=>$update_by,
        );

        //update data
        $this->db->where('id',$id);
        $save = $this->db->update('pos_sub_kategori',$data);

        if($save){
              $response = array (
                    "status" => 'success',                    
                    "message" => 'Data updated'
              );
        }else{                                                
              $response = array(
                    "status" => 'error',                      
                    "message" => 'Error: Update failed'
              );
        }   
        return $response;        
	}
	public function del_sub_kategori(){
		$id = $this->input->post('id');
		$delete_by = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$delete_date = date('Y-m-d H:i:s');

		$this->db->where('id',$id);
		$save = $this->db->update('pos_sub_kategori',array('delete_by'=>$delete_by, 'delete_date'=>$delete_date, 'is_delete'=>'1')); 

		if($save){
		    $response = array(
		          "status" => 'success',                    
		          "message" => 'Success delete market type'
		    );
		}else{
		     $response = array(
		          "status" => 'error',                      
		          "message" => 'Error: Failed delete market type'
		    );
		}           

		return $response;
	}
//################################### ITEM ####################################################
	public function tb_item(){
		$query = $this->db->query("select      	i.id as ID_ITEM,
									            kt.code, 
									            sb.id as id_sub,
									            kt.id as id_kat,
									            sb.sub_kategori_code, 
									            kt.code,  
									            u.username as update_by_username, 
									            i.barcode,
									            i.qty,
									            i.satuan,
									            i.deskripsi_satuan,
									            i.harga_beli,
									            i.harga_jual,
									            i.lost_remark,
									            i.fragile,
									            i.status,
									            i.nama_gudang,
												i.kode_gudang,
												i.kode_lokasi,
												i.kode_rak,
												i.tahun_pembelian,

									             
									            i.item_name as nama_item,
									            sb.sub_description as jenis_item,
									            kt.description as kategori_item,
									            i.harga_beli,
									            i.harga_jual,
									            i.cost_percentage,
									            sb.update_date, 
									            sb.is_delete

									from        pos_kategori as kt, 
									            pos_item as i, 
									            pos_sub_kategori as sb left join user as u on u.id = sb.update_by

									where       sb.is_delete = '0' and 
									            kt.is_delete = '0' and 
									            i.is_delete = '0' and
									            i.id_sub_kategori=sb.id AND
									            i.id_kategori=kt.id AND 
									            i.id_sub_kategori=sb.id");


		if ($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return NULL;
		}
	}
	public function add_item(){
		$mode = $this->input->post('mode');
		$jenis_item = $this->input->post('jenis_item');
		$item_description = $this->input->post('item_description');
		$barcode = $this->input->post('barcode');
		$nama = $this->input->post('nama');
		$kat_id = $this->input->post('kat_id');
		$sub_kat_id = $this->input->post('sub_kat_id');
		$qty = $this->input->post('qty');
		$sat = $this->input->post('sat');
		$sat_des = $this->input->post('sat_des');
		$harga_beli = $this->input->post('harga_beli');
		$harga_jual = $this->input->post('harga_jual');
		$lost_remark = $this->input->post('lost_remark');
		$fragile = $this->input->post('fragile');
		$status = $this->input->post('status');


		$it_loc_nm_gudang = $this->input->post('it_loc_nm_gudang');
        $it_loc_kd_gudang = $this->input->post('it_loc_kd_gudang');
        $it_loc_kd_lokasi = $this->input->post('it_loc_kd_lokasi');
        $it_loc_kd_rak = $this->input->post('it_loc_kd_rak');
        $it_th_beli = $this->input->post('it_th_beli');


        // $cost_percentage = $this->input->post('cost_percentage');


		
		$response=false;
		if(	$mode == null || 
			$nama == null ||
			$kat_id == null || 
			$sub_kat_id == null ||
			// $harga_beli == null ||
			$harga_jual == null || 
			$lost_remark == null || 
			$fragile == null || 
			$status == null ||
			$it_loc_nm_gudang == null ||
			$it_loc_kd_gudang == null ||
			$it_loc_kd_lokasi == null ||
			$it_loc_kd_rak == null ||
			$it_th_beli == null
			// $cost_percentage == null
			){
				$response = false;
				return $response;
		}else{
			$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
			$data = array(
						'pos_type'=>'KANTOR',
						'jenis_item'=>'ITEM',
						'barcode'=>$barcode,
						'item_name'=>$nama,
						'id_kategori'=>$kat_id,
						'id_sub_kategori'=>$sub_kat_id,
						'qty'=>$qty,
						'satuan'=>$sat,
						'deskripsi_satuan'=>$sat_des,
						'harga_beli'=>$harga_beli,
						'harga_jual'=>$harga_jual,
						'lost_remark'=>$lost_remark,
						'fragile'=>$fragile,
						'status'=>$status,
						'nama_gudang' =>$it_loc_nm_gudang,
						'kode_gudang' =>$it_loc_kd_gudang,
						'kode_lokasi' =>$it_loc_kd_lokasi,
						'kode_rak' =>$it_loc_kd_rak,
						'tahun_pembelian' =>$it_th_beli,
						// 'cost_percentage'=>$cost_percentage,
						'insert_by'=>$session_id,
						'update_by'=>$session_id
					);
			$add_stat = $this->db->insert('pos_item',$data);
			$id_item = $this->db->insert_id();

			$durasi = !empty($_POST['durasi']) ? $_POST['durasi']:[];
			foreach ($durasi as $key => $value) {
				$durasi[$key]['id_item'] = $id_item;
				$durasi[$key]['insert_by']=$_SESSION['id_user'];
				$durasi[$key]['update_by']=$_SESSION['id_user'];
			}
        	$this->db->insert_batch('durasi',$durasi);
			

			if($add_stat){
				$response = true;
			}else{
				$response = false;

			}
			
			return $response;	
		}	
	}
	public function result_add_item(){
		$query = $this->db->query("select      	i.id as ID_ITEM,
									            kt.code, 
									            sb.id as id_sub,
									            kt.id as id_kat,
									            sb.sub_kategori_code, 
									            kt.code,  
									            u.username as update_by_username, 
									            i.barcode,
									            i.qty,
									            i.satuan,
									            i.deskripsi_satuan,
									            i.harga_beli,
									            i.harga_jual,
									            i.lost_remark,
									            i.fragile,
									            i.status,
									            i.nama_gudang,
												i.kode_gudang,
												i.kode_lokasi,
												i.kode_rak,

									             
									            i.item_name as nama_item,
									            sb.sub_description as jenis_item,
									            kt.description as kategori_item,
									            i.harga_beli,
									            i.harga_jual,
									            i.cost_percentage,
									            i.tahun_pembelian,
									            sb.update_date, 
									            sb.is_delete

									from        pos_kategori as kt, 
									            pos_item as i, 
									            pos_sub_kategori as sb left join user as u on u.id = sb.update_by

									where       sb.is_delete = '0' and 
									            kt.is_delete = '0' and 
									            i.is_delete = '0' and
									            i.id_sub_kategori=sb.id AND
									            i.id_kategori=kt.id AND 
									            i.id_sub_kategori=sb.id and
									            i.id = (select last_insert_id())");


	    if ($query->num_rows() > 0){
	          return $query->row();
	    }else{
	          return NULL;
	    }
	}
	public function edit_item(){
		$id = $this->input->post('id');
		$mode = $this->input->post('mode');
		$barcode = $this->input->post('barcode');
		$nama = $this->input->post('nama');
		$kat_id = $this->input->post('kat_id');
		$sub_kat_id = $this->input->post('sub_kat_id');
		$qty = $this->input->post('qty');
		$harga_beli = $this->input->post('harga_beli');
		$harga_jual = $this->input->post('harga_jual');
		$lost_remark = $this->input->post('lost_remark');
		$fragile = $this->input->post('fragile');
		$status = $this->input->post('status');

		$it_loc_nm_gudang = $this->input->post('it_loc_nm_gudang');
        $it_loc_kd_gudang = $this->input->post('it_loc_kd_gudang');
        $it_loc_kd_lokasi = $this->input->post('it_loc_kd_lokasi');
        $it_loc_kd_rak = $this->input->post('it_loc_kd_rak');

        $durasi = !empty($_POST['durasi'])?$_POST['durasi']:[];
        $deldurasi = !empty($_POST['deldurasi'])?$_POST['deldurasi']:[];


        $it_th_beli = $this->input->post('it_th_beli');
		// $cost_percentage = $this->input->post('cost_percentage');
		$update_by = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';


		$response=false;
		if(	$mode == null || 
			$nama == null ||
			$kat_id == null || 
			$sub_kat_id == null ||
			// $harga_beli == null ||
			$harga_jual == null || 
			$lost_remark == null || 
			$fragile == null || 
			$status == null ||
			$it_loc_nm_gudang == null ||
			$it_loc_kd_gudang == null ||
			$it_loc_kd_lokasi == null ||
			$it_loc_kd_rak == null ||
			$it_th_beli == null
			// $cost_percentage == null
			){
				$response = false;
				return $response;
		}else{
			$session_id = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
			$data = array(
						'pos_type'=>'KANTOR',
						'barcode'=>$barcode,
						'item_name'=>$nama,
						'id_kategori'=>$kat_id,
						'id_sub_kategori'=>$sub_kat_id,
						'qty'=>$qty,
						'harga_beli'=>$harga_beli,
						'harga_jual'=>$harga_jual,
						'lost_remark'=>$lost_remark,
						'fragile'=>$fragile,
						'status'=>$status,
						'nama_gudang' =>$it_loc_nm_gudang,
						'kode_gudang' =>$it_loc_kd_gudang,
						'kode_lokasi' =>$it_loc_kd_lokasi,
						'kode_rak' =>$it_loc_kd_rak,
						'tahun_pembelian' =>$it_th_beli,
						// 'cost_percentage'=>$cost_percentage,
						'insert_by'=>$session_id,
						'update_by'=>$session_id
					);

			$this->db->where('id',$id);
			$add_stat = $this->db->update('pos_item',$data);
			
			$durCount = count($durasi);
			$delCount = count($deldurasi);

			foreach ($durasi as $key => $value) {

				$insert_durasi = $this->db->query('insert into durasi (id,id_item,name,harga,insert_by,update_by) values ("'.$value['id'].'",'.$id.',"'.$value['name'].'",'.$value['harga'].','.$session_id.','.$session_id.') on duplicate key update id_item="'.$id.'"');

				if($insert_durasi){
					$durCount--;
				}
			}


			foreach ($deldurasi as $key => $value) {

				$del = $this->db->where('id',$value)->update('durasi',array('is_delete'=>1,'delete_date'=>date('Y-m-d H:i:s')));
				if($del){
					$delCount--;
				}
			}
			
			if($add_stat && $durCount==0 && $delCount==0){
				$response = true;
			}else{
				$response = false;

			}
			
			return $response;
			
		}	      
	}
	public function del_item(){
		$id = $this->input->post('id');
		$delete_by = $this->session->userdata('id_user') ? $this->session->userdata('id_user') : '1';
		$delete_date = date('Y-m-d H:i:s');

		$this->db->where('id',$id);
		$save = $this->db->update('pos_item',array('delete_by'=>$delete_by, 'delete_date'=>$delete_date, 'is_delete'=>'1')); 

		if($save){
		    $response = array(
		          "status" => 'success',                    
		          "message" => 'Success delete market type'
		    );
		}else{
		     $response = array(
		          "status" => 'error',                      
		          "message" => 'Error: Failed delete market type'
		    );
		}           

		return $response;
	}

	public function saveImgToDB($id,$name){
		$query = $this->db->query('INSERT INTO img_item (id_item,img_name) VALUES ('.$id.',"'.$name.'") ON DUPLICATE KEY UPDATE img_name="'.$name.'"');

		if($query){
			return true;
		}else{
			return false;
		}
	}


	public function ck_barcode($barcode=null){
		$query = $this->db->query("select      	i.id as ID_ITEM,
									            kt.code, 
									            sb.id as id_sub,
									            kt.id as id_kat,
									            sb.sub_kategori_code, 
									            kt.code,  
									            u.username as update_by_username, 
									            i.barcode,
									             
									            i.item_name as nama_item,
									            sb.sub_description as jenis_item,
									            kt.description as kategori_item,
									            i.harga_beli,
									            i.harga_jual,
									            i.cost_percentage,
									            sb.update_date, 
									            sb.is_delete

									from        pos_kategori as kt, 
									            pos_item as i, 
									            pos_sub_kategori as sb left join user as u on u.id = sb.update_by

									where       sb.is_delete = '0' and 
									            kt.is_delete = '0' and 
									            i.is_delete = '0' and
									            i.id_sub_kategori=sb.id AND
									            i.id_kategori=kt.id AND 
									            i.id_sub_kategori=sb.id AND
									            i.barcode=$barcode");


		if ($query->num_rows() > 0){
		    return "ADA";
		}else{
		    return "TIDAK";
		}
	}

//#################################### EXTEND ITEM ############################################
	public function tb_item_is_av(){
		$query = $this->db->query("select      	i.id as ID_ITEM,
									            kt.code, 
									            sb.id as id_sub,
									            kt.id as id_kat,
									            sb.sub_kategori_code, 
									            kt.code,  
									            u.username as update_by_username, 
									            i.barcode,
									            i.qty,
									             
									            i.item_name as nama_item,
									            sb.sub_description as jenis_item,
									            kt.description as kategori_item,
									            i.harga_beli,
									            i.harga_jual,
									            i.cost_percentage,
									            sb.update_date, 
									            sb.is_delete

									from        pos_kategori as kt, 
									            pos_item as i, 
									            pos_sub_kategori as sb left join user as u on u.id = sb.update_by

									where       sb.is_delete = '0' and 
									            kt.is_delete = '0' and 
									            i.is_delete = '0' and
									            i.id_sub_kategori=sb.id AND
									            i.id_kategori=kt.id AND 
									            i.id_sub_kategori=sb.id AND
									            i.qty>0");

		// echo $this->db->_error_message();
		// echo $this->db->_error_number();

		//show_error($message, $status_code, $heading = 'An Error Was Encountered');
		$err = $this->db->error();
		if($query){
		 	if ($query->num_rows() > 0){
			    return $query->result();
			}else{
			    return json_decode('{"status":"-1","message":"Data Kosong"}',true);
			}
		}else{
			//echo $err['code'];
			return json_decode('{"status":"'.$err['code'].'","message":"'.$err['message'].'"}',true);
		}

	}

	public function tb_item_for_pemesanan(){
		$query = $this->db->query("select      	i.id as ID_ITEM,
												i.is_external,
									            (select code from pos_kategori where id=i.id_kategori) as code, 
									            (select id from pos_sub_kategori where id=i.id_sub_kategori) as id_sub,
									            (select id from pos_kategori where id=i.id_kategori) as id_kat, 
									            (select sub_kategori_code from pos_sub_kategori where id=i.id_sub_kategori), 
									             
									            u.username as update_by_username, 
									            i.barcode,
									            i.qty,
									             
									            i.item_name as nama_item,
									            (select sub_description from pos_sub_kategori where id=i.id_sub_kategori) as sub_kategori,
									            (select description from pos_kategori where id=i.id_kategori) as kategori_item,
									            i.harga_beli,
									            i.harga_jual,
									            i.cost_percentage,
									            (select update_date from pos_sub_kategori where id=i.id_sub_kategori), 
									            (select is_delete from pos_sub_kategori where id=i.id_sub_kategori),
									            i.jenis_item

									from         
									            pos_item as i
												join user as u

									where       
												u.id=i.update_by and
												i.status='Active' and
									            ((i.jenis_item='ITEM') OR (i.jenis_item='PAKET'))");

		$err = $this->db->error();
		if($query){
		 	if ($query->num_rows() > 0){
			    return $query->result();
			}else{
			    return json_decode('{"status":"-1","message":"Data Kosong"}',true);
			}
		}else{
			//echo $err['code'];
			return json_decode('{"status":"'.$err['code'].'","message":"'.$err['message'].'"}',true);
		}
	}

	public function list_item_paket($id=null){
		$query = $this->db->query('	select
												pi.id as id_it_paket,
												pi.id_item_package as id_paket,
												pi.id_item as ID_ITEM,
												i.harga_jual as item_price,
												pi.item_qty,
												i.item_name,
												i.satuan,
												i.barcode,
												i.qty as item_h_stock,
												i.qty as stock,
												
												p.item_name as package_name,
												p.item_description as package_description,
												p.harga_jual as package_price,
												p.barcode as no_paket,
												u.name,
												(select pi.item_qty*i.harga_jual) as total
												
									from
												pos_item as p
												join package_items as pi
												join pos_item as i
												join user as u

									where
												pi.id_item_package=p.id
												and p.jenis_item="PAKET"
												and pi.id_item=i.id
												and pi.is_delete=0
												and p.update_by=u.id
												and p.id='.$id);
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return NULL;
		}
	}

	public function saveToPackage($data=null){

		if(!empty($data)){
			$insert = $this->db->insert('pos_item',$data);	
			if($insert){
				return $this->db->insert_id();
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}

	public function saveToPackageItems($data=null){
		if(!empty($data)){
			$this->db->insert_batch('package_items',$data);	
		}else{
			return NULL;
		}
	}

	public function updateToPackage($data=null,$id=null){

		if(!empty($data)){
			$this->db->where('id',$id);
			$insert = $this->db->update('pos_item',$data);	
		}else{
			return NULL;
		}
	}

	public function updateToPackageItems($data=null,$del=null){
		foreach ($del as $key => $value) {
			$del[$key]['delete_by']=$_SESSION['id_user'];

			$this->db->where('id',$del[$key]['id']);
			$this->db->update('package_items',$del[$key]);
		}
		foreach ($data as $key => $value) {
			if(empty($value['id'])){
				$this->db->insert('package_items',$data[$key]);
			}else{
				$this->db->where('id',$data[$key]['id']);
				$this->db->update('package_items',$data[$key]);
			}
		}
	}

	public function deletePackage($id=null){
		if(!empty($id)){
			$this->db->where('id',$id);
			$delete = $this->db->update('pos_item',array('is_delete'=>1,'delete_by'=>$_SESSION['id_user']));	
		}else{
			return NULL;
		}
	}


	public function tb_paket($id=null){
		$id_paket = '';
		if(!empty($id)){
			$id_paket = ' and p.id=' . $id;
		}
		$query = $this->db->query('	select
										p.*,p.id as id_paket,
										u.name,
										(select count(id) as jml_item from package_items where id_item_package=p.id) as jml_item
							from
										pos_item as p
										join user as u
							where 		
										p.is_delete=0
										and p.jenis_item="PAKET"
										and p.update_by=u.id ' . $id_paket);
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return NULL;
		}
	}

	public function getProduk(){
		$query = $this->db->query("select * from pos_item where is_delete=0 and jenis_item='ITEM'");
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}

	public function getHilang($id=null){
		$edit='';
		if(!empty($id)){
			$edit = "and b.id=".$id;
		}

		$query = $this->db->query("select b.id as id_b,i.id as id_item,b.*,i.* from barang_hilang as b join pos_item as i on b.id_barang=i.id where b.is_delete=0 ".$edit);
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}

	public function getDurasi($id=null){
		$query = $this->db->query("select id,name,harga from durasi where is_delete=0 and id_item=".$id);

		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}
}
?>
