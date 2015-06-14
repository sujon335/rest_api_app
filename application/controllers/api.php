<?php


require(APPPATH.'libraries/REST_Controller.php');

class Api extends REST_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('panorama_model');
	}
	function latest_get(){
		$ln = $this->get('lang');
		$count = $this->get('count');
		if(!$count) $count = 5;
		$q='';
		if($ln=='bn'){
			$s = 'select * from panorama_code join panorama_info_bn on panorama_code.id=panorama_info_bn.id order by ddate desc limit '.$count;
		}else{
			$s = 'select * from panorama_code join panorama_info on panorama_code.id=panorama_info.id order by ddate desc limit '.$count;
		}
		$q= $this->db->query($s);
		$data = array();
		if($q->num_rows()){
			$data['status']='success';
			$data['data']=$q->result();
		}else{
			$data['status']='failed';
		}
		$this->response($data);
		//~ $s = 'select * from panorama_code,
	}
	
	function random_get(){
		$ln = $this->get('lang');
		$count = $this->get('count');
		if(!$count) $count = 5;
		$q='';
		$s = '';
		if($lang=='bn'){
			$s = 'select * from panorama_code join panorama_info_bn on panorama_code.id=panorama_info_bn.id order by rand_index limit '.$count;
		}else{
			$s = 'select * from panorama_code join panorama_info on panorama_code.id=panorama_info.id order by rand_index limit '.$count;
		}
		$q= $this->db->query($s);
		$data = array();
		if($q->num_rows()){
			$data['status']='success';
			$data['data']=$q->result();
			foreach($r as $data['data']){
				$this->panorama_model->update_rand_index($r->id);
			}
		}else{
			$data['status']='failed';
		}
		$this->response($data);
	}
	
	function popular_get(){
		$ln = $this->get('lang');
		$count = $this->get('count');
		if(!$count) $count = 5;
		$q='';
		$s = '';
		if($lang=='bn'){
			$s = 'select * from panorama_code join panorama_info_bn on panorama_code.id=panorama_info_bn.id order by view_count limit '.$count;
		}else{
			$s = 'select * from panorama_code join panorama_info on panorama_code.id=panorama_info.id order by view_count limit '.$count;
		}
		$q= $this->db->query($s);
		$data = array();
		if($q->num_rows()){
			$data['status']='success';
			$data['data']=$q->result();
			$data['status']='failed';
		}
		$this->response($data);
	}
	
	
	function pano_get(){
		$ln = $this->get('lang');
		$id = $this->get('id');
		//echo $id;
		$q = '';
		$s='';
		if($ln=='bn'){
			$s = 'select * from panorama_code join panorama_info_bn on panorama_code.id=panorama_info_bn.id where panorama_code.id='.$id;
		}else{
			$s = 'select * from panorama_code join panorama_info on panorama_code.id=panorama_info.id where panorama_code.id='.$id;
		}
		//echo $s;
		$q = $this->db->query($s);
		$data = array();
		if($q->num_rows()){
			$data['status']='success';
			$data['data']=$q->result();
		}else $data['status']='failed';
		$this->response($data);
	}
	
	
	function district_get(){
		$ln = $this->get('lang');
		
		$avail = $this->get('avail');
		
		if($avail){
			
			$s = 'select distinct district from panorama_info';
			$s_bn = 'select distinct district from panorama_info_bn';
			$data = array();
			if($ln=='bn'){
				$q = $this->db->query($s_bn);
				if($q->num_rows()){
					$data['status']='success';
					$data['data']=$q->result();
				}else{
					$data['status']='failed';
				}
			}else{
				$q = $this->db->query($s);
				if($q->num_rows()){
					$data['status']='success';
					$data['data']=$q->result();
				}else{
					$data['status']='failed';
				}
			}
			$this->response($data);
			
		}else{
		
			$dis = $this->get('name');
			if($dis) $dis='Dhaka';
			//~ echo $dis;
			$q = '';
			$s = '';
			if($ln=='bn'){
				$s = 'select * from panorama_code join panorama_info_bn on panorama_code.id=panorama_info_bn.id where district="'.$dis.'"';
			}else{
				$s = 'select * from panorama_code join panorama_info on panorama_code.id=panorama_info.id where district="'.$dis.'"';
			}
			
			$q = $this->db->query($s);
			$data = array();
			if($q->num_rows()){
				$data['status']='success';
				$data['data']=$q->result();
			}else $data['status']='failed';
			$this->response($data);
			
		}
	}
	
	function list_get(){
		$ln = $this->get('lang');
		$cnt = $this->get('count');
		$page = $this->get('page');
		$sort = $this->get('sort');
		$by = $this->get('by');
		if(!$cnt) $cnt = 10;
		if(!$page) $page = 1;
		if(!$by || $by=='date') $by = 'ddate';
		//~ if($by=='date') $by='ddate';
		if(!$sort || ($sort!='desc' && $sort!='asc')) $sort=='desc';
		
		$start = ($page-1)*$cnt;
		
		$q = '';
		$s = '';
		
		if($ln=='bn'){
			$s = 'select * from panorama_info_bn join panorama_code on panorama_info_bn.id = panorama_code.id order by `'.$by.'` '.$sort.' limit '.$start.','.$cnt;
		}else{
			$s = 'select * from panorama_info join panorama_code on panorama_info.id = panorama_code.id order by `'.$by.'` '.$sort.' limit '.$start.','.$cnt;
		}
		//~ echo $s;
		$q = $this->db->query($s);
		
		if($q->num_rows()){
			$data['status']='success';
			$data['data']=$q->result();
		}else{
			$data['status']='failed';
		}
		
		$data['total']=0;
		$tot = 0;
		$q = $this->db->query('select count(id) as tot from panorama_code');
		if($q->num_rows()){
			$tot = $q->result();
			foreach($r as $tot){
				$tot = $r->tot;
				break;
			}
			$data['total']=$tot;
		}
		$data['page']=$page;
		$data['start']=$start;
		$data['end']=$start+$cnt-1;
		$this->response($data);
	}
}
