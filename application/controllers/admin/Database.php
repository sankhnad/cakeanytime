<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Database  extends CI_Controller {
	public
	function __construct() {
		parent::__construct();
	}

	public
	function index() {
		$data['activeMenu'] = 'database';
		$this->load->view('admin/table_list', $data);
	}
	
	function table_list(){
		$this->load->model( 'DataTblModel', 'datatablemodel' );
		
		$hostname = $this->db->hostname; 
		$username = $this->db->username; 
		$password = $this->db->password; 
		$database = $this->db->database; 
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		
		$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".$database."'";
		$tableName = $this->common_model->customQuery($query);
		
		
		$recordsTotal = count($tableName);
		
		$aColumns=array(
			'TABLE_NAME',
			'TABLE_NAME',
			'TABLE_NAME',
		);

		$iSQL = "FROM INFORMATION_SCHEMA.TABLES";
		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 0, 'asc');
		$sWhere = $quryTmp['where'] ? $quryTmp['where'] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp['order'];
		$sLimit = $quryTmp['limit'];
		$sAnd .= ' AND TABLE_TYPE = "BASE TABLE" AND TABLE_SCHEMA = "'.$database.'"';
		
		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";	
		
		$qtrAry = $this->common_model->customQuery($sQuery);
		
		$sQuery = "SELECT COUNT(".$aColumns[0].") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		";
		$iFilteredAry = $this->common_model->customQuery($sQuery);
		$recordsFiltered = $iFilteredAry[0]['iFiltered'];
		
		$sEcho = $this->input->get_post('draw',true );
		$results = array(
			"draw" => intval($sEcho),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);
		
		
		foreach ($results['tempData'] as $aKey => $aRow) {
			//$id = encode($aRow['TABLE_NAME']);
			$id = $aRow['TABLE_NAME'];
			$btnAra = ' <a class="blue" target="_blank" href="'.admin_url().'database/table/'.$id.'"> <i class="ace-icon fas fa-search-plus bigger-130"></i></a>';
			
			$btnAra .= ' <a class="red" data-tooltip="tooltip" title="Delete" onClick="deleteCommon(this,\''.$id.'\',\'contact\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a>';
			
			$tableInfo = $this->common_model->countResults($aRow['TABLE_NAME']);
			
			$row = array();
			$row[] = '<a target="_blank" href="'.admin_url().'database/table/'.$id.'">'.$aRow['TABLE_NAME'].'</a>';
			$row[] = $tableInfo.' Records';
			$row[] = '<div class="action-buttons">'.$btnAra.'</div>';
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function table($table='') {
		$hostname = $this->db->hostname; 
		$username = $this->db->username; 
		$password = $this->db->password; 
		$database = $this->db->database; 
		
		
		if($table){
			$qtrAry = 'SELECT * FROM '.$table.' LIMIT 1';
			$columnName = $this->common_model->customQuery($qtrAry);
			
			if(!$columnName){
				$query = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='".$database."' AND `TABLE_NAME`='".$table."'";
				$qtrAry = $this->common_model->customQuery($query);
				foreach($qtrAry as $value){
					$columnName[0][$value['COLUMN_NAME']] = '1';
				}
			}
			$data['column'] = $columnName;
			$data['table'] = $table;
			$data['activeMenu'] = 'database';
			$this->load->view('admin/table_data', $data);
		}else{
			$this->load->view('admin/505');
		}
	}
	
	function table_data_list(){		
		$this->load->model( 'DataTblModel', 'datatablemodel' );
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		
		$hostname = $this->db->hostname; 
		$username = $this->db->username; 
		$password = $this->db->password; 
		$database = $this->db->database; 
		
		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if($inDataKey == 'filter_table'){
					if($inDataVal){
						$table = $inDataVal;
					}
				}
			}
		}
		
		$recordsTotal = $this->common_model->countResults($table);
		
		$columnName = $this->common_model->getAll('*', $table, '', '', '', '', '', '1');
		
		
		
		
		
		if($columnName){
			foreach($columnName[0] as $key=>$value){
				$aColumns[] = $key;
			}
		}else{
			$query = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='".$database."' AND `TABLE_NAME`='".$table."'";
			$qtrAry = $this->common_model->customQuery($query);
			//print_r($qtrAry);
			foreach($qtrAry as $value){
				$aColumns[] = $value['COLUMN_NAME'];
			}
		}
		
			
		$iSQL = "FROM $table";
		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 0);
		$sWhere = $quryTmp['where'] ? $quryTmp['where'] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp['order'];
		$sLimit = $quryTmp['limit'];

		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";
		$qtrAry = $this->common_model->customQuery($sQuery);
		
		$sQuery = "SELECT COUNT(".$aColumns[0].") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		";
		$iFilteredAry = $this->common_model->customQuery($sQuery);
		$recordsFiltered = $iFilteredAry[0]['iFiltered'];
		
		$sEcho = $this->input->get_post('draw',true );
		$results = array(
			"draw" => intval($sEcho),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);
		
		
		foreach ($results['tempData'] as $aKey => $aRow) {		
			$id = '';
			$btnAra = ' <a class="blue" data-tooltip="tooltip" title="Quick View" onClick="contactQuickView(\''.$id.'\');" href="javascript:;"> <i class="ace-icon fas fa-search-plus bigger-130"></i></a>';
			
			$btnAra .= ' <a class="red" data-tooltip="tooltip" title="Delete" onClick="deleteCommon(this,\''.$id.'\',\'contact\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a>';
			
			
			$row = array();
			foreach($aRow as $aRowData){
				$row[] = $aRowData;
			}
			$row[] = '<div class="action-buttons">'.$btnAra.'</div>';
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function getTableRecord() {
		$hostname = $this->db->hostname; 
		$username = $this->db->username; 
		$password = $this->db->password; 
		$database = $this->db->database; 
		
		$table = $this->input->post('table');
		$key = $this->input->post('key');
		$value = $this->input->post('value');
		
		if($key){
			$record = $this->common_model->getAll('*', $table, array($key, $value));
			$record = json_decode(json_encode($record),true);
		}else{
			$query = "SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='".$database."' AND `TABLE_NAME`='".$table."'";
			$columnRecord = $this->common_model->customQuery($query);
		}
		echo json_encode($columnRecord);
	}
}