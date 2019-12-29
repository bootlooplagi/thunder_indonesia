<?php 
class Model_report extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	public function getDriver(){
		$query = $this->db->query("select id,name,user_type,is_freelance from user where (user_type='Kurir' or user_type='Freelance') and is_delete=0 and is_active=1");
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}

	public function getDataReportDriver($id=null,$month=null,$year=null){
		$query = $this->db->query("	select 
											p.id,c.id_kurir,u.name,p.no_pemesanan,p.tgl_pemesanan,p.`status`
									from 
											pemesanan as p
											join crew_pemesanan as c on c.id_pemesanan=p.id
											join user as u on u.id=c.id_kurir
									where
											p.is_delete=0
											and p.jenis='pemesanan'
											and c.id_kurir=".$id."
											and month(tgl_pemesanan)=".$month."
											and year(tgl_pemesanan)=".$year);
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}

	public function tb_item_disewa(){
		$query = $this->db->query("	select
											i.item_name,
											ip.qty,
											ip.durasi,
											d.name as durasi_name,
											d.harga,
											sum(ip.qty) as total_disewa, 
											sum(d.harga) as total_anggaran_from_durasi,
											sum(ip.total_harga) as anggaran_akhir
									from 
											pemesanan as p 
											join item_pemesanan as ip on ip.id_pemesanan=p.id
											join pos_item as i on ip.id_item=i.id
											join durasi as d on ip.durasi=d.id

									where 
											p.`status`=3
											and p.is_delete=0
									group by i.id
									");
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}

	public function tb_item_terlaris(){
		$query = $this->db->query("	select
											i.item_name,
											ip.qty,
											ip.durasi,
											d.name as durasi_name,
											d.harga,
											sum(ip.qty) as total_disewa, 
											sum(d.harga) as total_anggaran_from_durasi,
											sum(ip.total_harga) as anggaran_akhir
									from 
											pemesanan as p 
											join item_pemesanan as ip on ip.id_pemesanan=p.id
											join pos_item as i on ip.id_item=i.id
											join durasi as d on ip.durasi=d.id

									where 
											p.`status`=3
											and p.is_delete=0
									group by i.id
									order by total_disewa desc
									");
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}

	public function tb_jumlah_driver(){
		$query = $this->db->query("	select u.name,
									(select count(*) from crew_pemesanan as cp join pemesanan as pp on cp.id_pemesanan=pp.id where  cp.id_kurir=u.id and pp.is_delete=0 and pp.jenis='pemesanan') as total_jobs,
									(select count(*) from crew_pemesanan as cp join pemesanan as pp on cp.id_pemesanan=pp.id where (pp.`status`>=2 and pp.`status`<5) and cp.id_kurir=u.id and pp.is_delete=0 and pp.jenis='pemesanan') as progress,
									(select count(*) from crew_pemesanan as cp join pemesanan as pp on cp.id_pemesanan=pp.id where pp.`status`=5 and cp.id_kurir=u.id and pp.is_delete=0 and pp.jenis='pemesanan') as done
									from user as u where (u.user_type='Kurir' or u.user_type='Freelance')
									group by u.id
									order by total_jobs desc
									");
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}

	
}
?>