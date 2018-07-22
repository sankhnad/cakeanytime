<?php
class Common_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function getAll($select='*', $table, $where=array(), $order='', $inData=array(), $notinData=array(), $groupBy='', $limit='') {
		$this->db->select( $select );
		if($where){
			$this->db->where( $where );
		}
		if($inData){
			foreach($inData as $key=>$val){
				$this->db->where_in($key, $val);
			}			
		}
		if($notinData){
			foreach($notinData as $key=>$val){
				$this->db->where_not_in($key, $val);
			}			
		}
		if($groupBy){
			$this->db->group_by($groupBy);
		}
		if($order){
			$this->db->order_by($order);
		}
		if($limit != ''){
			if(is_array($limit)){
				$this->db->limit($limit[0],$limit[1]);
			}else{
				$this->db->limit($limit);
			}
		}		
		$query = $this->db->get( $table );
		//echo $this->db->last_query().'<br><br>';
		return $query->result();
	}
	
	function updateData($table, $where, $data) {
		$this->db->where($where);
		$this->db->update($table, $data );
		//echo $this->db->last_query();
		return true;
	}
	
	function bulkUpdateData($table, $data, $index, $where=array()) {
		if($where){
			$this->db->where($where);
		}
		$this->db->update_batch($table,$data, $index);
		//echo $this->db->last_query();
		return true;
	}
	
	function saveData($table, $data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();
		//return $this->db->last_query();
	}
	
	function bulkSaveData($table, $data) {
		$this->db->insert_batch($table, $data);
		//echo $this->db->last_query();
		return true;
	}
	
	function deleteData($table, $data) {
		$this->db->delete($table, $data);
		//echo $this->db->last_query();
		return true;
	}

	function countResults($tbl, $where = array() ) {
		if(isset( $where )) {
			$this->db->where( $where );
		}
		$this->db->from( $tbl );
		//echo  $this->db->last_query();
		return $this->db->count_all_results();
	}

	function fetch_pagination( $table, $limit, $start, $order = array() ) {
		$this->db->limit( $limit, $start );
		if ( !empty( $order ) ) {
			$this->db->order_by( $order[ 0 ], $order[ 1 ] );
		}
		$query = $this->db->get( $table );
		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $row ) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	function customQuery($sql){
		$query = $this->db->query( $sql );
		//echo $this->db->last_query();
		return $query->result_array();		
	}
}