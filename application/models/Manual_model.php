<?php
class Manual_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
		
	function checkLoginUserEmail($data='') {
		if($data !=''){
			$this->db->select('aid, password, status');
			$this->db->from('admin_user');
			$this->db->where('email',$data);
			$this->db->or_where('username', $data); 
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
	}
	
	function getFullCustomerData($select, $where){
		$this->db->select($select);
		$this->db->from('auth_user AS a');
		$this->db->join('fimcosite_profile AS b', 'a.id = b.user_id', 'LEFT');
		$this->db->join('fimcosite_account AS c', 'b.profile_id = c.profile_id', 'LEFT');
		$this->db->join('fimcosite_kyc AS d', 'c.account = d.account', 'LEFT');
		$this->db->where($where);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();		
	}
	
	function getLocationData($select, $where, $type){
		$this->db->select($select);
		if($type == 'city' || $type == 'state' || $type == 'pin'){
			$this->db->from('location_state AS a');
			$this->db->join('location_city AS b', 'a.sid = b.sid', 'LEFT');
		}
		if($type == 'pin' || $type == 'area'){
			$this->db->join('location_pin AS c', 'b.cid = c.cid', 'LEFT');
		}
		if($type == 'area'){
			$this->db->join('location_area AS d', 'd.pin = d.pin', 'LEFT');
		}
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();		
	}
	
	function checkImportCustomer($select, $table, $where){
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();		
	}
	
	function getFullGroupInfo($select, $where){
		$this->db->select($select);
		$this->db->from('customer_group AS a');
		$this->db->join('customer_group_member AS b', 'a.id = b.group_id', 'LEFT');
		$this->db->join('customer AS c', 'b.customer_id = c.id', 'LEFT');
		$this->db->where($where);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();		
	}
	
	function checkLoginCustomerEmail($data='') {
		if($data !=''){
			$this->db->select('fld_cid, fld_password, fld_status, fld_isEmail_verified, fld_isSMS_verified');
			$this->db->from('tbl_customer');
			$this->db->where('fld_email',$data);
			$this->db->where('fld_isDeleted','2');
			$this->db->or_where('fld_username', $data); 
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
	}

	function getFullCustomerAddress($where, $order=array()){
		$this->db->select('a.*,b.cityName');
		$this->db->from('address AS a');
		$this->db->join('location_city AS b', 'a.stateCode = b.cid', 'LEFT');
		$this->db->where($where);
		if (!empty($order)){
			$this->db->order_by($order[0], $order[1]);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();		
	}	
	
	
	function findDubliSlug($table, $slug) {
		$SQL = 'SELECT count(url_slug) as iTotal FROM '.$table.' WHERE url_slug LIKE "'.$slug.'%"';
		$query = $this->db->query($SQL);
		return $query->result();
	}
}