<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Accounts extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model( 'DataTblModel', 'datatablemodel' );
	}

	function index() {
		$data[ 'activeMenu' ] = 'accounts';
		$data[ 'activeSubMenu' ] = 'accounts_statement';
		$this->load->view( 'admin/account_statement_list', $data );
	}

	function accounts_statement() {
		$this->index();
	}

	function statement_lst() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';

		$recordsTotal = $this->common_model->countResults( 'fimcosite_account' );

		$aColumns = array(
			'a.account',
			'a.current_balance_currency',
			'a.current_balance',
			'a.ts_current_bal',
			'a.available_balance_currency',
			'a.available_balance',
			'a.ts_available_bal',
			'a.bonus_currency',
			'a.bonus',
			'a.ts_bonus',
			'a.status',
			'a.allow_overdraft',
			'a.id',
			'a.nickname',
			'b.msisdn',
			'b.profile_type',
			'b.profile_id',
			'b.user_id',
			'c.username',
			'c.first_name',
			'c.last_name',
			'c.email',
			'c.last_login',
		);

		$iSQL = "FROM fimcosite_account as a 
				 LEFT JOIN fimcosite_profile as b ON a.profile_id = b.profile_id 
				 LEFT JOIN auth_user as c ON b.user_id = c.id";

		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 3 );
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];



		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";
		$qtrAry = $this->common_model->customQuery( $sQuery );

		$sQuery = "SELECT COUNT(" . $aColumns[ 0 ] . ") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		";
		$iFilteredAry = $this->common_model->customQuery( $sQuery );
		$recordsFiltered = $iFilteredAry[ 0 ][ 'iFiltered' ];

		$sEcho = $this->input->get_post( 'draw', true );
		$results = array(
			"draw" => intval( $sEcho ),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);

		foreach ( $results[ 'tempData' ] as $aKey => $aRow ) {
			$cid = encode( $aRow[ 'user_id' ] );
			$account = encode( $aRow[ 'account' ] );

			$btnAra = ' <a data-tooltip="tooltip" title="Account <br>Ledger" href="' . base_url() . 'accounts/ledger/' . $account . '" class="btn btn-xs btn-inverse"><i class="ace-icon fas fa-dollar-sign bigger-120"></i></a>';

			$btnAra .= ' <a data-tooltip="tooltip" title="Transaction <br>Report" href="' . base_url() . 'accounts/transaction/' . $account . '" class="btn btn-xs btn-primary"><i class="ace-icon far fa-copy bigger-120"></i></a>';

			if ( $aRow[ 'last_login' ] ) {
				$lastLogin = date( 'jS M Y | h:i A', strtotime( $aRow[ 'last_login' ] ) );
			} else {
				$lastLogin = 'Never Login';
			}

			if ( $aRow[ 'status' ] == '1' ) {
				$status = '<span class="badge badge-success">Active</span>';
			} else {
				$status = '<span class="badge badge-danger">Inactive</span>';
			}

			if ( $aRow[ 'status' ] == '1' ) {
				$overDarft = '<span class="label label-sm label-success arrowed-right">Allowed</span>';
			} else {
				$overDarft = '<span class="label label-sm label-purple arrowed-in">Not Allowed</span>';
			}

			$cDetail = '<ul class=\'popovLst\'>
							<li><strong>Username:</strong> ' . $aRow[ 'username' ] . '</li>
							<li><strong>Email:</strong> ' . $aRow[ 'email' ] . '</li>
							<li><strong>Phone:</strong> ' . $aRow[ 'msisdn' ] . '</li>
							<li><strong>Last Login:</strong> ' . $lastLogin . '</li>
					    </ul>';

			$nickName = '<a href="javascript:;" onClick="customerQuickView(\'' . $cid . '\')" title="' . $aRow[ 'first_name' ] . ' ' . $aRow[ 'last_name' ] . '" data-trigger="hover"  data-toggle="popover"  data-content="' . $cDetail . '">' . $aRow[ 'nickname' ] . '</a>';


			$row = array();
			$row[] = $aRow[ 'profile_id' ];
			$row[] = $nickName;
			$row[] = '<a target="_blank" href="' . base_url() . 'accounts/ledger/' . $account . '">' . $aRow[ 'account' ] . '</span>';
			$row[] = number_format( $aRow[ 'current_balance' ], 2 ) . ' ' . $aRow[ 'current_balance_currency' ];
			$row[] = number_format( $aRow[ 'available_balance' ], 2 ) . ' ' . $aRow[ 'available_balance_currency' ];
			$row[] = number_format( $aRow[ 'bonus' ], 2 ) . ' ' . $aRow[ 'bonus_currency' ];
			$row[] = $overDarft;
			$row[] = $status;
			$row[] = $btnAra;
			$results[ 'data' ][] = $row;
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}

	function ledger( $eAc = '' ) {
		$account = decode( $eAc );

		if ( !$account ) {
			redirect( base_url() . 'error-500' );
		}

		$accountInfoAry = $this->common_model->getAll( '*', 'fimcosite_account', array( 'account' => $account ) );
		if ( !$accountInfoAry ) {
			redirect( base_url() . 'error-500' );
		}

		$custInfoAry = '';
		if ( $accountInfoAry[ 0 ]->profile_id ) {
			$custInfoAry = $this->manual_model->getFullCustomerData( '*, a.id as cid, d.id as kyc_id, d.status as kyc_status', array( 'b.profile_id' => $accountInfoAry[ 0 ]->profile_id ) );
		}
		$data[ 'eAccount' ] = $eAc;
		$data[ 'activeMenu' ] = 'accounts';
		$data[ 'activeSubMenu' ] = 'accounts_statement';
		$data[ 'accountInfoAry' ] = $accountInfoAry;
		$data[ 'custInfoAry' ] = $custInfoAry;
		$this->load->view( 'admin/ledger_list', $data );
	}

	function ledger_lst() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';

		if ( isset( $_REQUEST[ 'filterData' ] ) ) {
			foreach ( $_REQUEST[ 'filterData' ] as $inDataKey => $inDataVal ) {
				if ( $inDataKey == 'filter_account' ) {
					if ( $inDataVal ) {
						$account = decode( $inDataVal );
						$inData .= ' AND account IN("' . $account . '")';
					}
				}

				if ( $inDataKey == 'filter_date' ) {
					if ( $inDataVal ) {
						$inDataVal = explode( "-", $inDataVal );
						$startDate = explode( "/", trim( $inDataVal[ 0 ] ) );
						$endDate = explode( "/", trim( $inDataVal[ 1 ] ) );
						$startDate = $startDate[ 2 ] . '-' . $startDate[ 0 ] . '-' . $startDate[ 1 ];
						$endDate = $endDate[ 2 ] . '-' . $endDate[ 0 ] . '-' . $endDate[ 1 ];
						$inData .= ' AND full_timestamp BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
					}
				}
			}
		}

		$recordsTotal = $this->common_model->countResults( 'pochi_ledger', array( 'account' => $account ) );

		$aColumns = array(
			'full_timestamp',
			'trans_type',
			'amount',
			'reference',
			'available_o_bal',
			'available_c_bal',
			'current_o_bal',
			'current_c_bal',
			'mode',
			'trans_id',
			'amount_currency',
			'available_o_bal_currency',
			'available_c_bal_currency',
			'current_o_bal_currency',
			'current_c_bal_currency',
		);

		$iSQL = " FROM pochi_ledger ";

		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 0 );
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];

		$sAnd = " AND account = '" . $account . "'";

		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";
		$qtrAry = $this->common_model->customQuery( $sQuery );

		$sQuery = "SELECT COUNT(" . $aColumns[ 0 ] . ") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		";
		$iFilteredAry = $this->common_model->customQuery( $sQuery );
		$recordsFiltered = $iFilteredAry[ 0 ][ 'iFiltered' ];

		$sEcho = $this->input->get_post( 'draw', true );
		$results = array(
			"draw" => intval( $sEcho ),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);

		foreach ( $results[ 'tempData' ] as $aKey => $aRow ) {
			if ( $aRow[ 'trans_type' ] == 'CREDIT' ) {
				$trans_type = '<span class="label label-sm label-success arrowed-right">Credit</span>';
			} else {
				$trans_type = '<span class="label label-sm label-purple arrowed-in">Debit</span>';
			}
			$row = array();
			$row[] = date( 'jS M Y | h:i A', strtotime( $aRow[ 'full_timestamp' ] ) );;
			$row[] = $trans_type;
			$row[] = number_format( $aRow[ 'amount' ], 2 ) . ' ' . $aRow[ 'available_o_bal_currency' ];
			$row[] = $aRow[ 'reference' ];
			$row[] = number_format( $aRow[ 'available_o_bal' ], 2 ) . ' ' . $aRow[ 'available_o_bal_currency' ];
			$row[] = number_format( $aRow[ 'available_c_bal' ], 2 ) . ' ' . $aRow[ 'available_c_bal_currency' ];
			$row[] = number_format( $aRow[ 'current_o_bal' ], 2 ) . ' ' . $aRow[ 'current_o_bal_currency' ];
			$row[] = number_format( $aRow[ 'current_c_bal' ], 2 ) . ' ' . $aRow[ 'current_c_bal_currency' ];
			$row[] = $aRow[ 'mode' ];
			$row[] = $aRow[ 'trans_id' ];
			$results[ 'data' ][] = $row;
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}

	function transaction( $eAc = '' ) {
		$account = decode( $eAc );

		if ( !$account ) {
			redirect( base_url() . 'error-500' );
		}

		$accountInfoAry = $this->common_model->getAll( '*', 'fimcosite_account', array( 'account' => $account ) );
		if ( !$accountInfoAry ) {
			redirect( base_url() . 'error-500' );
		}

		$custInfoAry = '';
		if ( $accountInfoAry[ 0 ]->profile_id ) {
			$custInfoAry = $this->manual_model->getFullCustomerData( '*, a.id as cid, d.id as kyc_id, d.status as kyc_status', array( 'b.profile_id' => $accountInfoAry[ 0 ]->profile_id ) );
		}
		$data[ 'eAccount' ] = $eAc;
		$data[ 'activeMenu' ] = 'accounts';
		$data[ 'activeSubMenu' ] = 'accounts_statement';
		$data[ 'accountInfoAry' ] = $accountInfoAry;
		$data[ 'custInfoAry' ] = $custInfoAry;
		$this->load->view( 'admin/transaction_list', $data );
	}

	function transaction_lst() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';

		if ( isset( $_REQUEST[ 'filterData' ] ) ) {
			foreach ( $_REQUEST[ 'filterData' ] as $inDataKey => $inDataVal ) {
				if ( $inDataKey == 'filter_account' ) {
					if ( $inDataVal ) {
						$account = decode( $inDataVal );
						$inData .= ' AND dst_account IN("' . $account . '")';
					}
				}

				if ( $inDataKey == 'filter_date' ) {
					if ( $inDataVal ) {
						$inDataVal = explode( "-", $inDataVal );
						$startDate = explode( "/", trim( $inDataVal[ 0 ] ) );
						$endDate = explode( "/", trim( $inDataVal[ 1 ] ) );
						$startDate = $startDate[ 2 ] . '-' . $startDate[ 0 ] . '-' . $startDate[ 1 ];
						$endDate = $endDate[ 2 ] . '-' . $endDate[ 0 ] . '-' . $endDate[ 1 ];
						$inData .= ' AND full_timestamp BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
					}
				}
			}
		}

		$recordsTotal = $this->common_model->countResults( 'pochi_transaction', array( 'dst_account' => $account ) );

		$aColumns = array(
			'full_timestamp',
			'msisdn',
			'trans_id',
			'service',
			'channel',
			'mode',
			'dst_account',
			'amount_currency',
			'amount',
			'charge_currency',
			'charge',
			'reference',
			'status',
			'result_code',
			'message',
			'processed_timestamp',
		);

		$iSQL = " FROM pochi_transaction ";

		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 0 );
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];

		$sAnd = " AND dst_account = '" . $account . "'";

		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";
		$qtrAry = $this->common_model->customQuery( $sQuery );

		$sQuery = "SELECT COUNT(" . $aColumns[ 0 ] . ") AS iFiltered
		$iSQL
		$sWhere
		$sAnd

		$inData
		$notInData
		";
		$iFilteredAry = $this->common_model->customQuery( $sQuery );
		$recordsFiltered = $iFilteredAry[ 0 ][ 'iFiltered' ];

		$sEcho = $this->input->get_post( 'draw', true );
		$results = array(
			"draw" => intval( $sEcho ),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);

		foreach ( $results[ 'tempData' ] as $aKey => $aRow ) {
			if ( $aRow[ 'status' ] == 'PENDING' ) {
				$status = '<span class="label label-sm label-warning arrowed-in">Pending</span>';
			} else if ( $aRow[ 'status' ] == 'SUCCESS' ) {
				$status = '<span class="label label-sm label-success arrowed-right">Success</span>';
			} else if ( $aRow[ 'status' ] == 'FAILED' ) {
				$status = '<span class="label label-sm label-danger arrowed-left">Failed</span>';
			}


			if ( $aRow[ 'service' ] == 'P2P' ) {
				$service = '<span class="label label-purple">Pochi to Pochi</span>';
			} else if ( $aRow[ 'service' ] == 'DEPOSIT' ) {
				$service = '<span class="label label-success">Deposit</span>';
			} else if ( $aRow[ 'service' ] == 'WITHDRAW' ) {
				$service = '<span class="label label-danger">Withdraw</span>';
			} else if ( $aRow[ 'service' ] == 'BONUS' ) {
				$service = '<span class="label label-inverse">Bonus</span>';
			} else if ( $aRow[ 'service' ] == 'FEES' ) {
				$service = '<span class="label label-warning">Fees</span>';
			}


			$row = array();
			$row[] = date( 'jS M Y | h:i A', strtotime( $aRow[ 'full_timestamp' ] ) );
			$row[] = $aRow[ 'trans_id' ];
			$row[] = $service;
			$row[] = $aRow[ 'channel' ];
			$row[] = $aRow[ 'mode' ];
			$row[] = $aRow[ 'dst_account' ];
			$row[] = number_format( $aRow[ 'amount' ], 2 ) . ' ' . $aRow[ 'amount_currency' ];
			$row[] = number_format( $aRow[ 'charge' ], 2 ) . ' ' . $aRow[ 'charge_currency' ];
			$row[] = $aRow[ 'reference' ];
			$row[] = $status;
			$results[ 'data' ][] = $row;
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}
	
	function manual_credit() {
		$data[ 'activeMenu' ] = 'accounts';
		$data[ 'activeSubMenu' ] = 'manual_credit';
		$this->load->view( 'admin/manual_credit_list', $data );
	}

	function import ($isDrafted = '', $eID = '', $isError = '' ) {
		$id = $eID ? decode($eID) : '';
		$data[ 'activeMenu' ] = 'accounts';
		$data[ 'activeSubMenu' ] = 'import';
		$data['isError'] = $isError;
		if ($eID){
			$data[ 'eID' ] = $eID;
			if($id){
				$draftStatement = $this->common_model->getAll('status, id, created_on','admin_import_statement',array('aid'=>AID, 'id'=>$id, 'isDeleted'=> '1'));
				$data[ 'draftStatement' ] = $draftStatement;
				if($draftStatement){
					$this->load->view('admin/import_statement_data', $data);
				}else{
					$this->load->view( 'admin/500');
				}
			}else{
				$this->load->view( 'admin/500');
			}
		}else if ( $isDrafted == 'drafted' ) {
			$this->load->view( 'admin/import_drafted', $data );
		} else {
			$this->load->view( 'admin/import_statement', $data );
		}
	}

	function upload_statement() {
		if (!AID){
			exit( 'Unauthorized access' );
		}
		set_time_limit(1000000000);
		
		$statementFile = $_FILES[ 'statement' ][ 'name' ];
		$allowed_ext = array( "csv" );
		
		if(!$statementFile){
			echo json_encode( array( 'success' => false, 'output' => 'file_error') );
			exit;
		}
		$extnAry = explode(".", $statementFile);
		$extension = end($extnAry);
		
		if(!in_array($extension, $allowed_ext)){
			echo json_encode( array( 'success' => false, 'output' => 'ext_error') );
			exit;
		}
		
		$docFile = uploadFiles('statement', 'downloads/statement', '', '', '', 'csv');
		
		$stmtDate = array(
			'aid' => AID,
			'document' => $docFile,
			'created_on' => date("Y-m-d H:i:s", time()),
		);
		
		$ais = $this->common_model->saveData('admin_import_statement', $stmtDate);
		
		
		$tempFile = $_FILES[ "statement" ][ "tmp_name" ];		
		$file_data = fopen($tempFile, 'r');
		fgetcsv( $file_data );
		while ($row = fgetcsv($file_data)){
			$checkCustomer = $this->manual_model->checkImportCustomer('id', 'fimcosite_profile', '(profile_id="'.$row[0].'" or msisdn = "'.$row[0].'")');
			
			if($checkCustomer){
				$status = '3';
			}else{
				$status = '4';
			}
			$data[] = array(
				'ais' => $ais,
				'profile_id' => $row[0],
				'from_bank_account_no' => $row[1],
				'from_bank_name' => $row[2],
				'received_bank_account_no' => $row[3],
				'received_bank_name' => $row[4],
				'amount' => $row[5],
				'transaction_no' => $row[6],
				'transaction_mode' => $row[7],
				'transaction_type' => $row[8],
				'transaction_date' => implode('-',explode('_',$row[9])),
				'status' => $status,
				'created_on' => date("Y-m-d H:i:s", time()),
			);
		}
		
		$this->common_model->bulkSaveData('admin_import_statement_data', $data);
		
		fclose($file_data);
		echo json_encode(array('success' => true, 'id' => encode($ais)));
	}
	
	function draft_lst() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';

		if ( isset( $_REQUEST[ 'filterData' ] ) ) {
			foreach ( $_REQUEST[ 'filterData' ] as $inDataKey => $inDataVal ) {
				if ( $inDataKey == 'filter_status' ) {
					if($inDataVal){
						$inData .= ' AND status IN("'.implode('","', $inDataVal).'")';
					}
				}

				if ( $inDataKey == 'filter_date' ) {
					if ( $inDataVal ) {
						$inDataVal = explode( "-", $inDataVal );
						$startDate = explode( "/", trim( $inDataVal[ 0 ] ) );
						$endDate = explode( "/", trim( $inDataVal[ 1 ] ) );
						$startDate = $startDate[ 2 ] . '-' . $startDate[ 0 ] . '-' . $startDate[ 1 ];
						$endDate = $endDate[ 2 ] . '-' . $endDate[ 0 ] . '-' . $endDate[ 1 ];
						$inData .= ' AND created_on BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
					}
				}
			}
		}

		$recordsTotal = $this->common_model->countResults( 'admin_import_statement', array('aid'=> AID, 'isDeleted'=> 1));

		$aColumns = array(
			'created_on',
			'(SELECT COUNT(id) FROM admin_import_statement_data WHERE ais = sid) as totalStatemnt',
			'document',
			'status',
			'modified_on',
		);
		
		$iSQL = " FROM admin_import_statement ";

		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 0 );
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];
		array_unshift($aColumns, 'id as sid');
		$sAnd =  ' AND aid = '.AID.' AND isDeleted = 1';
		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";
		
		$qtrAry = $this->common_model->customQuery( $sQuery );

		$sQuery = "SELECT COUNT(" . $aColumns[ 1 ] . ") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		";
		
		$iFilteredAry = $this->common_model->customQuery( $sQuery );
		$recordsFiltered = $iFilteredAry[ 0 ][ 'iFiltered' ];

		$sEcho = $this->input->get_post( 'draw', true );
		$results = array(
			"draw" => intval( $sEcho ),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);
		foreach ( $results['tempData'] as $aKey => $aRow ) {
			$id = encode($aRow['sid']);
			$btnAra = '<a class="blue" data-tooltip="tooltip" title="Detailed view" target="_blank" href="'.base_url().'accounts/import/drafted/'.$id.'"> <i class="ace-icon fas fa-search-plus bigger-130"></i></a> ';
			
			$isError = $this->common_model->countResults( 'admin_import_statement_data', array('ais'=> $aRow['sid'], 'status'=> '4', 'isDeleted'=> '1'));
			
			if($isError > 0){
				$btnAra .= '<a class="red" data-tooltip="tooltip" title="List of Errors" target="_blank" href="'.base_url().'accounts/import/drafted/'.$id.'/error_list"> <i class="ace-icon fas fa-exclamation-circle bigger-130"></i></a> ';
			}
			
			
			if ($aRow[ 'status' ] == '1') {
				$status = '<span class="badge badge-success">Approved</span>';
			}else if ($aRow[ 'status' ] == '0') {
				$status = '<span class="badge badge-danger stateWarn">Rejected</span>';
				$btnAra .= '<a class="green snA" data-tooltip="tooltip" title="Send for approval" onClick="sendForApproval(\''.$id.'\', \'bulk\');" href="javascript:;"> <i class="ace-icon far fa-share-square bigger-130"></i> </a> ';
			}else if ($aRow[ 'status' ] == '2') {
				$status = '<span class="badge badge-primary">Waiting for approval</span>';
			}else{
				$status = '<span class="badge badge-warning stateWarn">Drafted</span>';
				
				$btnAra .= '<a class="green snA" data-tooltip="tooltip" title="Send for approval" onClick="sendForApproval(\''.$id.'\', \'bulk\');" href="javascript:;"> <i class="ace-icon far fa-share-square bigger-130"></i> </a> ';
				
				$btnAra .= '<a class="red delA" data-tooltip="tooltip" title="Delete"  onClick="deleteCommon(this,\''.$id.'\',\'draftedStatement\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a> ';
			}
			
			$row = array();
			$row[] = '<a target="_blank" data-tooltip="tooltip" title="Click here to check detailed statement" href="'.base_url().'accounts/import/drafted/'.$id.'">'.date('jS M Y | h:i A', strtotime( $aRow[ 'created_on'])).'</a>';
			$row[] = $aRow['totalStatemnt'];
			$row[] = '<a target="_blank" data-tooltip="tooltip" title="Click here to download the original file" href="'.base_url().'accounts/download/drafted/'.$id.'">Download</a>';
			$row[] = $status;
			$row[] = '<span data-id="'.$id.'" class="btnAreaAction">'.$btnAra.'</span>';
			
			$results[ 'data' ][] = $row;
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}
	
	function download($type='', $eID=''){
		if (!AID ) {
			exit( 'Unauthorized Access' );
		}
		if($eID){
			$id = decode($eID);
		}
		if($type == 'drafted'){
			if($id){
				$stateData = $this->common_model->getAll('document, created_on', 'admin_import_statement', array('id'=> $id,  'isDeleted'=> 1));
				if(!$stateData){
					exit( 'Unauthorized Access' );
				}
				$document = $stateData[0]->document;
				$fullPath = base_url().'downloads/statement/';
				$fullFilePath = $fullPath.$document;
				
				$url = $fullFilePath;
				
				$fileName = 'statement - '.date('jS M Y - h i A', strtotime($stateData[0]->created_on));
				header('Content-type: text/csv');
				header('Content-Disposition: attachment; filename="'.$fileName.'.csv"');
				header('Pragma: no-cache');
				header('Expires: 0');
				
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, false);
				echo $data = curl_exec($curl);
				curl_close($curl);
				exit;
			}else{
				exit( 'Unauthorized Access' );
			}
		}		
	}
	
	function draft_data_lst() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = $isManual = '';

		if ( isset( $_REQUEST[ 'filterData' ] ) ) {
			foreach ( $_REQUEST[ 'filterData' ] as $inDataKey => $inDataVal ) {
				if ( $inDataKey == 'filter_status' ) {
					if($inDataVal){
						$inData .= ' AND status IN("'.implode('","', $inDataVal).'")';
					}
				}
				
				if ( $inDataKey == 'filter_id' ) {
					if($inDataVal){
						$ais = decode($inDataVal);
						$inData .= ' AND ais = '.$ais;						
					}
				}
				if($inDataKey == 'filter_manual'){
					if($inDataVal){
						$ais = decode($inDataVal);
						$inData .= ' AND ais IS NULL';
						$isManual = true;
					}
				}

				if ($inDataKey == 'filter_date') {
					if ( $inDataVal ) {
						$inDataVal = explode( "-", $inDataVal );
						$startDate = explode( "/", trim( $inDataVal[ 0 ] ) );
						$endDate = explode( "/", trim( $inDataVal[ 1 ] ) );
						$startDate = $startDate[ 2 ] . '-' . $startDate[ 0 ] . '-' . $startDate[ 1 ];
						$endDate = $endDate[ 2 ] . '-' . $endDate[ 0 ] . '-' . $endDate[ 1 ];
						$inData .= ' AND transaction_date BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
					}
				}
			}
		}
		$tempWhere = array('ais'=> $ais, 'isDeleted'=> '1');
		if($isManual){
			$tempWhere['ais'] = NULL;
		}
		$recordsTotal = $this->common_model->countResults( 'admin_import_statement_data', $tempWhere);
		
		$aColumns = array(
			'profile_id',
			'from_bank_name',
			'from_bank_account_no',
			'received_bank_name',
			'received_bank_account_no',
			'amount',
			'transaction_no',
			'transaction_mode',
			'transaction_type',
			'transaction_date',
			'id',
			'ais',
			'status',
			'created_on',
			'modified_on',
			'isDeleted',
		);
		
		$iSQL = " FROM admin_import_statement_data ";

		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 9);
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];
		$sAnd =  ' AND isDeleted = 1';
		
		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";
		
		$qtrAry = $this->common_model->customQuery( $sQuery );

		$sQuery = "SELECT COUNT(" . $aColumns[ 0 ] . ") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		";
		
		$iFilteredAry = $this->common_model->customQuery( $sQuery );
		$recordsFiltered = $iFilteredAry[ 0 ][ 'iFiltered' ];

		$sEcho = $this->input->get_post( 'draw', true );
		$results = array(
			"draw" => intval( $sEcho ),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);
		foreach ( $results['tempData'] as $aKey => $aRow ) {
			$id = encode($aRow['id']);
			
			$btnAra = '<a class="blue" data-tooltip="tooltip" onClick="getDetailsStatementData(\''.$id.'\',0)" title="Detailed view" href="javascript:;"> <i class="ace-icon fas fa-search-plus bigger-130"></i></a>';
			
			if($isManual && ($aRow[ 'status' ] == '3' || $aRow[ 'status' ] == '0')){
				$btnAra .= '<a class="green snA" data-tooltip="tooltip" title="Send for approval" onClick="sendForApproval(\''.$id.'\', \'single\');" href="javascript:;"> <i class="ace-icon far fa-share-square bigger-130"></i> </a> ';
			}
			
			$checkCustomer = $this->manual_model->checkImportCustomer('user_id, ', 'fimcosite_profile', '(profile_id="'.$aRow['profile_id'].'" or msisdn = "'.$aRow['profile_id'].'")');
			if($checkCustomer){
				$isCustomer = '<a onclick="customerQuickView(\''.encode($checkCustomer[0]->user_id).'\')" data-tooltip="tooltip" title="Customer Quick View" href="javascript:;" >'.$aRow['profile_id'].'</a>';
			}else{
				$isCustomer = '<span class="red" onclick="getDetailsStatementData(\''.$id.'\',1)" data-tooltip="tooltip" title="Customer Not Found" href="javascript:;" >'.$aRow['profile_id'].'</span>';
			}
			
			if ($aRow[ 'status' ] == '1') {
				$status = '<span class="badge badge-success">Approved</span>';
			}else if ($aRow[ 'status' ] == '0') {
				$status = '<span class="badge badge-danger stateWarn">Rejected</span>';
			}else if ($aRow[ 'status' ] == '2') {
				$status = '<span class="badge badge-primary">Waiting for approval</span>';
			}else if ($aRow[ 'status' ] == '3') {
				$status = '<span class="badge badge-warning stateWarn">Drafted</span>';
			}else if ($aRow[ 'status' ] == '4') {
				$status = '<span onClick="getDetailsStatementData(\''.$id.'\',1)"  data-tooltip="tooltip" title="Found invalid Record. Please edit and put valid data" class="badge cursorP background-red">Invalid</span>';
			}
			
			
			if ($aRow[ 'status' ] == '3' || $aRow[ 'status' ] == '4'){
				$btnAra .= '<a class="green qedA" data-tooltip="tooltip" onClick="getDetailsStatementData(\''.$id.'\',1)" title="Quick Edit" href="javascript:;"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i></a>';
				
				$btnAra .= '<a class="red delA" data-tooltip="tooltip" title="Delete"  onClick="deleteCommon(this,\''.$id.'\',\'draftedStatementData\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a> ';
			}
			
			$row = array();
			$row[] = $isCustomer;
			$row[] = $aRow['from_bank_name'];
			$row[] = $aRow['from_bank_account_no'];
			$row[] = $aRow['received_bank_account_no'];
			$row[] = $aRow['received_bank_name'];
			$row[] = $aRow['amount'];
			
			$row[] = $aRow['transaction_no'];
			$row[] = $aRow['transaction_mode'];
			$row[] = $aRow['transaction_type'];
			$row[] = date('jS M Y', strtotime( $aRow[ 'transaction_date']));
			$row[] = $status;
			$row[] = '<span  data-id="'.$id.'" class="btnAreaAction">'.$btnAra.'</span>';
			
			$results[ 'data' ][] = $row;
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}
	
	function getDetailsStatementData(){
		if(!$this->input->is_ajax_request() || !AID){
			exit( 'Unauthorized Access' );
		}
		$id = decode($this->input->post('id'));
		$stateData = $this->common_model->getAll('*', 'admin_import_statement_data', array('id' => $id, 'isDeleted' => '1'));
		if(!$stateData){
			echo json_encode(array('status'=>'error'));
			exit;
		}
		$data = array(
			'sPID' => $stateData[0]->profile_id,
			'sFrBank' => $stateData[0]->from_bank_account_no,
			'sFrBankAcc' => $stateData[0]->from_bank_name,			
			'sReceivedBank' => $stateData[0]->received_bank_account_no,
			'sReceivedBankAcc' => $stateData[0]->received_bank_name,
			'sAmount' => $stateData[0]->amount,
			'sTranNum' => $stateData[0]->transaction_no,
			'sTranMode' => $stateData[0]->transaction_mode,
			'sTranType' => $stateData[0]->transaction_type,
			'sTranDate' =>  date('m/d/Y', strtotime($stateData[0]->transaction_date)),
			'sTranDateSpan' =>  date('jS M Y', strtotime($stateData[0]->transaction_date)),
		);
		echo json_encode($data);
	}
	
	function draftedStateDataUpdate(){
		$id = decode($this->input->post('sDataID'));
		$sPID = $this->input->post('sPID');
		$checkCustomer = $this->manual_model->checkImportCustomer('id', 'fimcosite_profile', '(profile_id="'.$sPID.'" or msisdn = "'.$sPID.'")');
			
		if(!$checkCustomer){
			echo json_encode(array('status'=>'error'));
			exit;
		}
		
		$data = array(
			'profile_id' => $sPID,
			'from_bank_account_no' => $this->input->post('sFrBank'),
			'from_bank_name' => $this->input->post('sFrBankAcc'),
			'received_bank_account_no' => $this->input->post('sReceivedBank'),
			'received_bank_name' => $this->input->post('sReceivedBankAcc'),
			'amount' => $this->input->post('sAmount'),
			'transaction_no' => $this->input->post('sTranNum'),
			'transaction_mode' => $this->input->post('sTranMode'),
			'transaction_type' => $this->input->post('sTranType'),
			'transaction_date' => convertToSQLDate($this->input->post('sTranDate')),
			'status' => '3',
		);
		if($id){
			$this->common_model->updateData('admin_import_statement_data', array("id"=> $id), $data);
			echo json_encode(array('status'=>'updated'));
		}else{
			$data['created_on'] = date("Y-m-d H:i:s", time());
			$this->common_model->saveData('admin_import_statement_data', $data);
			echo json_encode(array('status'=>'success'));
		}
	}
	
	function export (){
		$data[ 'activeMenu' ] = 'accounts';
		$data[ 'activeSubMenu' ] = 'export';
		$this->load->view( 'admin/export_statements', $data );
	}
	
	function export_lst() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';

		if ( isset( $_REQUEST[ 'filterData' ] ) ) {
			foreach ( $_REQUEST[ 'filterData' ] as $inDataKey => $inDataVal ) {
				if ( $inDataKey == 'filter_status' ) {
					if($inDataVal){
						$inData .= ' AND status IN("'.implode('","', $inDataVal).'")';
					}
				}

				if ( $inDataKey == 'filter_date' ) {
					if ( $inDataVal ) {
						$inDataVal = explode( "-", $inDataVal );
						$startDate = explode( "/", trim( $inDataVal[ 0 ] ) );
						$endDate = explode( "/", trim( $inDataVal[ 1 ] ) );
						$startDate = $startDate[ 2 ] . '-' . $startDate[ 0 ] . '-' . $startDate[ 1 ];
						$endDate = $endDate[ 2 ] . '-' . $endDate[ 0 ] . '-' . $endDate[ 1 ];
						$inData .= ' AND created_on BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
					}
				}
			}
		}

		$recordsTotal = $this->common_model->countResults( 'admin_import_statement', array('aid'=> AID, 'isDeleted'=> 1));

		$aColumns = array(
			'created_on',
			'(SELECT COUNT(id) FROM admin_import_statement_data WHERE ais = sid) as totalStatemnt',
			'document',
			'status',
			'modified_on',
		);
		
		$iSQL = " FROM admin_import_statement ";

		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 0 );
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];
		array_unshift($aColumns, 'id as sid');
		$sAnd =  ' AND aid = '.AID.' AND isDeleted = 1';
		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";
		
		$qtrAry = $this->common_model->customQuery( $sQuery );

		$sQuery = "SELECT COUNT(" . $aColumns[ 1 ] . ") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		";
		
		$iFilteredAry = $this->common_model->customQuery( $sQuery );
		$recordsFiltered = $iFilteredAry[ 0 ][ 'iFiltered' ];

		$sEcho = $this->input->get_post( 'draw', true );
		$results = array(
			"draw" => intval( $sEcho ),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);
		foreach ( $results['tempData'] as $aKey => $aRow ) {
			$id = encode($aRow['sid']);
			$btnAra = '<a class="blue" data-tooltip="tooltip" title="Detailed view" target="_blank" href="'.base_url().'accounts/import/drafted/'.$id.'"> <i class="ace-icon fas fa-search-plus bigger-130"></i></a> ';
			
			
			if ($aRow[ 'status' ] == '1') {
				$status = '<span class="badge badge-success">Approved</span>';
			}else if ($aRow[ 'status' ] == '0') {
				$status = '<span class="badge badge-danger">Rejected</span>';
			}else if ($aRow[ 'status' ] == '2') {
				$status = '<span class="badge badge-primary">Waiting for approval</span>';
			}else{
				$status = '<span class="badge badge-warning">Drafted</span>';
				
				$btnAra .= '<a class="green snA" data-tooltip="tooltip" title="Send for approval" onClick="viewProfleUser(\''.$id.'\')" href="#"> <i class="ace-icon far fa-share-square bigger-130"></i> </a> ';
				
				$btnAra .= '<a class="red delA" data-tooltip="tooltip" title="Delete"  onClick="deleteCommon(this,\''.$id.'\',\'draftedStatement\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a> ';
			}
			
			$row = array();
			$row[] = '<a target="_blank" data-tooltip="tooltip" title="Click here to check detailed statement" href="'.base_url().'accounts/import/drafted/'.$id.'">'.date('jS M Y | h:i A', strtotime( $aRow[ 'created_on'])).'</a>';
			$row[] = $aRow['totalStatemnt'];
			$row[] = '<a target="_blank" data-tooltip="tooltip" title="Click here to download the original file" href="'.base_url().'accounts/download/drafted/'.$id.'">Download</a>';
			$row[] = $status;
			$row[] = '<span class="btnAreaAction">'.$btnAra.'</span>';
			
			$results[ 'data' ][] = $row;

		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}
	
	function sendForApproval(){
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		$type = $this->input->post('type');
		
		if($type == 'manual'){
			$idObj = $this->input->post('id');
		}else{
			$id = decode($this->input->post('id'));
		}		
		
		$data = array(
			'status' => '2',
		);
		if($type == 'single'){
			$this->common_model->updateData('admin_import_statement_data', array("id"=> $id), $data);
		}
		else if($type == 'bulk'){
			$this->common_model->updateData('admin_import_statement', array("id"=> $id), array('status' => '2'));
			$idObj = $this->common_model->getAll('id', 'admin_import_statement_data', array('ais' => $id, 'isDeleted' => '1'), '', array('status'=> array('0','3')));
			
			foreach($idObj as $idData){
				$bulkData[] = array(
						'id'=>$idData->id,
						'status' => '2',
					);
			}
			if($idObj){
				$this->common_model->bulkUpdateData('admin_import_statement_data', $bulkData, 'id');			
			}
		}
		else if($type == 'manual'){
			foreach($idObj as $idData){
				$bulkData[] = array(
						'id'=>decode($idData),
						'status' => '2',
					);
			}
			$this->common_model->bulkUpdateData('admin_import_statement_data', $bulkData, 'id');
		}
		
		echo json_encode(array('status'=>'success'));
	}
	
	function bulk_credit($eID = '', $isError = '' ) {
		$id = $eID ? decode($eID) : '';
		$data[ 'activeMenu' ] = 'accounts';
		$data[ 'activeSubMenu' ] = 'import';
		$data['isError'] = $isError;
		if ($eID){
			$data[ 'eID' ] = $eID;
			if($id){
				$draftStatement = $this->common_model->getAll('status, id, created_on','admin_import_statement',array('aid'=>AID, 'id'=>$id, 'isDeleted'=> '1'));
				$data[ 'draftStatement' ] = $draftStatement;
				if($draftStatement){
					$this->load->view('admin/import_statement_data', $data);
				}else{
					$this->load->view( 'admin/500');
				}
			}else{
				$this->load->view( 'admin/500');
			}
		}else {
			$this->load->view( 'admin/import_drafted', $data );
		}
	}
}