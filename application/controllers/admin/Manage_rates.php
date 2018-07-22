<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Manage_rates  extends CI_Controller {
	public
	function __construct() {
		parent::__construct();
	}

	function management_fees() {
		$data['activeMenu'] = 'fees_rate';
		$data['activeSubMenu'] = 'management_fees';
		$this->load->view('admin/management_fees_list', $data);
	}
	
	function management_fees_lst(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$this->load->model( 'DataTblModel', 'datatablemodel' );
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';		
		
		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if($inDataKey == 'filter_date'){
					if($inDataVal){
						$inDataVal = explode("-",$inDataVal);
						$startDate = explode("/",trim($inDataVal[0]));
						$endDate = explode("/",trim($inDataVal[1]));
						$startDate = $startDate[2].'-'.$startDate[0].'-'.$startDate[1];
						$endDate = $endDate[2].'-'.$endDate[0].'-'.$endDate[1];
						$inData .= ' AND created_date BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}
				
				if($inDataKey == 'filter_type'){
					if($inDataVal){
						$inData .= ' AND type IN("'.implode('","', $inDataVal).'")';
					}
				}
			}
		}	
		
		
		$recordsTotal = $this->common_model->countResults('pochi_management_fees');

		$aColumns=array(
			'label_name',
			'rate',
			'type',
			'created_date',
			'id',
		);
			
			
		$iSQL = "FROM pochi_management_fees";
		
		
		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 3);
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
			$id = encode($aRow['id']);

			if($aRow['type'] == 'P'){
				$type = 'Percentage';
			}else{
				$type = 'Flat Rate';
			}
			$btnAra = '<a class="blue" data-toggle="tooltip" title="Edit Management Fee" onClick="getManagementFee(\''.$id.'\')" href="javascript:;"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i></a>';			
			
			$row = array();
			$row[] = $aRow['label_name'];
			$row[] = $aRow['rate'];
			$row[] = $type;
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_date']));
			$row[] = '<div class="action-buttons">'.$btnAra.'</div>';
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function getManagementFee(){
		$id = decode($this->input->post('id'));
		if(!$id || !$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$obj = $this->common_model->getAll('label_name, rate, type', 'pochi_management_fees', array('id'=>$id));
		echo json_encode($obj);
	}
	
	function editAddManagementFee(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$id = decode($this->input->post('id'));
		$rate = $this->input->post('rate');		
		$name = $this->input->post('name');
		$type = $this->input->post('type');		
		if($rate <= 0 && !is_numeric($rate)){
			echo json_encode(array('status' => 'error'));
			return(false);
		}
		
		$data = array(
			'label_name'	=>$name,
			'rate'			=>$rate,
			'type'			=>$type,
		);
		if($id){
			$this->common_model->updateData('pochi_management_fees', array('id'=>$id), $data);
		}else{
			$data['created_date'] = date("Y-m-d H:i:s", time());
			$this->common_model->saveData('pochi_management_fees', $data);
		}
		echo json_encode(array('status' => 'success'));
	}
	
	function transaction_fees() {
		$tranFee = $this->common_model->getAll('*', 'pochi_transaction_fees', array('status'=>'1'));
		
		$data['activeMenu'] = 'fees_rate';
		$data['activeSubMenu'] = 'transaction_fees';
		$data['tranFee'] = $tranFee;
		$this->load->view('admin/transaction_fees_list', $data);
	}
	
	function transaction_fees_lst(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$this->load->model( 'DataTblModel', 'datatablemodel' );
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';		
		
		$recordsTotal = $this->common_model->countResults('pochi_transaction_fees');

		$aColumns=array(
			'created_date',
			'rate',
			'status',
		);
			
			
		$iSQL = "FROM pochi_transaction_fees";
		
		
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
			if($aRow['status'] == '1'){
				$status = '<div class="activStPr text-left"><i class="fas fa-circle"></i> Active</div>';
			}else{
				$status = '<div class="inActivStPr  text-left"><i class="fas fa-circle"></i> Inactive</div>';
			}			
			
			$row = array();
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_date']));
			$row[] = $aRow['rate'];
			$row[] = $status;
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function addTransactionFee(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$rate = $this->input->post('rate');
		if($rate <= 0 && !is_numeric($rate)){
			echo json_encode(array('status' => 'error'));
			return(false);
		}
		
		$this->common_model->updateData('pochi_transaction_fees', array('status'=>'1'), array('status'=>'0'));
		$this->common_model->saveData('pochi_transaction_fees', array('rate'=>$rate));
		echo json_encode(array('status' => 'success'));
	}
}