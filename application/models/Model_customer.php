<?php 
class Model_customer extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	public function index(){

	}

	public function getCustomer($id=null){
		$query = $this->db->query("select * from user where is_delete=0 and id=".$id);

		if($query->num_rows()>0){
			return $query;
		}else{
			return null;
		}
	}
}
?>