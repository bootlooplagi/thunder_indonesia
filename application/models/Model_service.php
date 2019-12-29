<?php 
class Model_service extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	public function tb_service($id=null){
		$query = $this->db->query('	select 
											s.*,u.name,
											v.nama_vendor,
											s.id_item as ID_ITEM,
											s.id as S_ID,
											s.update_date as service_update_date,
											u.name as service_update_by
									from 
											service as s  
											join vendor as v on s.id_vendor=v.id
											join user as u
									where 
											s.is_delete=0
											and s.update_by=u.id '.(!empty($id)?'and s.id='.$id:''));
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return NULL;
		}
	}

	public function ls_produk($id=null){
		$query = $this->db->query('	select * from item_service where is_delete=0 '.(!empty($id)?'and id_service='.$id:''));
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return NULL;
		}
	}

	public function vendor(){
		$query = $this->db->query('	select * from vendor where is_delete=0');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return NULL;
		}
	}
	
}
?>