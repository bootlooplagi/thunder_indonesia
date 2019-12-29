<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class maintenance extends CI_Controller {

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
	public function index(){

	}

	public function query($submit=null){
		if(empty($submit)){
			echo "<form style='width:1000px;' method='POST' action='".base_url('maintenance/query/submit')."'>
						<input type='text' name='query' style='width:100%;'>
						<button type='submit'>KIRIM</button>
				  </form>
				";
		}

		if($submit=='submit'){
			$q = $this->db->query($_POST['query']);

			if($q){
				echo "SUKSES";
			}else{
				echo "GAGAL";
			}
		}
	}		
	
}
