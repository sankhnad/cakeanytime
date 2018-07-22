<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Process extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}

	function index() {
		$this->load->view( 'index' );
	}

	function userRegistraion() {
		if ( !$this->input->is_ajax_request() || (uType != 2 && uType != 3) ) {
			exit( 'No direct script access allowed' );
		}
		$uid = decode($this->input->post( 'uid' ));
		$email = $this->input->post( 'email' );
		$username = $this->input->post( 'username' );
		$userState = $this->input->post( 'userState' );
		$userDist = $this->input->post( 'userDist' );
		$userBlock = $this->input->post( 'userBlock' );
		$token = generateRandom(10);
		$data = array(
			'fld_name' => $this->input->post( 'name' ),
			'fld_phone' => $this->input->post( 'number' ),
			'fld_email' => $email,
			'fld_isNewPassword' => '0',
			'fld_token' => $token,
			'fld_employee_id' => $this->input->post( 'empID' ),
			'fld_read_only' => $this->input->post( 'readOnly' ) == '1' ? '1' : '2'
		);
		if ($uid) {
			$emailStatus = $this->isUserEmailAvailble($email, 'email', $uid);
			if($emailStatus == 'valid'){
				$this->common_model->updateData( "fld_id", $uid, $data, 'tbl_user');
				$this->sendCommonEmail('userAddUpdate', array('uid'=>$uid,'status'=>'updated'));
				$status = 'sucess';
			}else{
				$status = 'email-error';
			}
		} else {
			$chekEmail = $this->isUserEmailAvailble( $email, 'email' );
			if ($chekEmail == 'error' ) {
				$status = 'email-error';
			} else {
				$chekUser = $this->isUserEmailAvailble( $username, 'username' );
				if ($chekUser == 'error') {
					$status = 'user-error';
				}
			}
			if ($chekEmail == 'valid' && $chekUser == 'valid' ) {
				$data[ 'fld_username' ] = $username;
				$data[ 'fld_userType' ] = $this->input->post( 'userType' );
				$data[ 'fld_password' ] = md5( $username . '@123' );
				$data[ 'fld_stateCode' ] = $userState;
				$data[ 'fld_districtCode' ] = !$userState ? NULL : $userDist;
				$data[ 'fld_blockCode' ] = !$userDist && !$userBlock ? NULL : $userBlock;
				$data[ 'fld_created_date' ] = date("Y-m-d H:i:s", time());
				$uid = $this->common_model->saveData( "tbl_user", $data );
				$this->sendCommonEmail('userAddUpdate', array('uid'=>$uid,'status'=>'created'));
				$status = 'sucess';
			}
		}
		echo json_encode( array( 'status' => $status ) );
	}
	
	function requestResetPass() {		
		if ( !$this->input->is_ajax_request() || (uType != 2 && uType != 3)) {
			exit( 'No direct script access allowed' );
		}
		$uid = decode($this->input->post('uid'));
		if ($uid) {
			$this->sendCommonEmail('userAddUpdate', array('uid'=>$uid,'status'=>'reset'));
		}
	}
	
	function updateProfile() {
		if(!$this->input->is_ajax_request() || (uType != 1)){
			exit('Unauthorized Access');
		}
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$data = array(
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'username' => $username,
		);
		
		if(AID) {
			$emailStatus = $this->isUserEmailAvailble($email, 'email', AID);
			if($emailStatus == 'valid'){
				$usernameStatus = $this->isUserEmailAvailble($username, 'username', AID);
				if($usernameStatus == 'valid'){
					$this->common_model->updateData('admin_user', array("aid"=> AID), $data);
					$status = 'sucess';
				}else{
					$status = 'username-error';
				}				
			}else{
				$status = 'email-error';
			}
		}
		echo json_encode( array( 'status' => $status ) );
	}
	
	function userProfileAddEdit() {
		if(!$this->input->is_ajax_request() || (uType != 1)){
			exit('Unauthorized Access');
		}
		$aid = decode($this->input->post('aid'));
		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$username = $this->input->post('username');		
		$password = $this->input->post('password');
		$role = $this->input->post('role');
		$avtar = $_FILES['avtar']['name'];
		
		$data = array(
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'username' => $username,
			'phone' => $phone,
			'role' => $role,
		);
		
		if($aid){
			if($password){
				$data['password'] = md5($password);
			}
			
			$emailStatus = $this->isUserEmailAvailble($email, 'email', $aid);
			if($emailStatus == 'valid'){
				$usernameStatus = $this->isUserEmailAvailble($username, 'username', $aid);
				if($usernameStatus == 'valid'){
					if($avtar){
						$data['avtar'] = uploadFiles('avtar', 'uploads/profile/', 'thumb', 360, 360);
					}
					
					$this->common_model->updateData('admin_user', array("aid"=> $aid), $data);
					$status = 'sucess';
				}else{
					$status = 'username-error';
				}				
			}else{
				$status = 'email-error';
			}
			
		}else{
			$data['created_date'] = date("Y-m-d H:i:s", time());
			$data['password'] = $password ? md5($password) : md5(generateRandom(5));
			
			$chekEmail = $this->isUserEmailAvailble($email, 'email');
			if ($chekEmail == 'error' ) {
				$status = 'email-error';
			} else {
				$chekUser = $this->isUserEmailAvailble( $username, 'username' );
				if ($chekUser == 'error') {
					$status = 'username-error';
				}
			}
			if ($chekEmail == 'valid' && $chekUser == 'valid' ) {
				if($avtar){
					$data['avtar'] = uploadFiles('avtar', 'uploads/profile/', 'thumb', 360, 360);
				}
				$aid = $this->common_model->saveData("admin_user", $data );
				//$this->sendCommonEmail('userAddUpdate', array('uid'=>$uid,'status'=>'created'));
				$status = 'sucess';
			}			
		}
		echo json_encode( array( 'status' => $status ) );
	}

	function isUserEmailAvailble( $data = '', $type = '', $aid='' ) {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$data = $data == '' ? $_REQUEST[ 'data' ] : $data;
		$type = $type == '' ? $_REQUEST[ 'type' ] : $type;
		$aid = $aid == '' ? decode($_REQUEST['aid']) : $aid;
		$where = array( $type => $data );
		if($aid !=''){
			$notinData = array('aid'=> array($aid));
		}else{
			$notinTarget = '';
			$notinData = array();
		}	
			
		$data = $this->common_model->getAll('aid', 'admin_user', $where, '', '', $notinData);
		if(count($data)>0){
			$status = 'error';
		}else{
			$status = 'valid';
		}
		if(isset($_REQUEST['data'])){
			echo json_encode( array( 'status' => $status ) );
		}else{
			return($status);
		}
	}
	
	function uploadProfileImg() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$fileData = $_FILES['fileData']['name'];
		$data = array();
		if ($fileData) {
			$data['avtar'] = uploadFiles('fileData', 'uploads/profile/', 'thumb', 360, 360);
			$this->common_model->updateData('admin_user', array("aid"=>AID), $data);
			$status = $data['avtar'];
		} else {
			$status = 'error';
		}
		echo json_encode( array( 'status' => $status ) );
	}

	function deleteCommon() {
		if ( !$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$data = array();
		$id = decode($this->input->post('id'));
		$type = $this->input->post('type');
		$value = $this->input->post('value');
		switch ($type) {
			case 'admin':
				$data['isDeleted'] = '0';
				$tbleName = 'admin_user';
				$where = array('aid'=>$id);
				break;
			case 'contact':
				$data['isDeleted'] = '0';
				$tbleName = 'admin_contact_us';
				$where = array('id'=>$id);
				break;
			case 'draftedStatement':
				$data['isDeleted'] = '0';
				$tbleName = 'admin_import_statement';
				$where = array('id'=>$id);
				$this->common_model->updateData('admin_import_statement_data', array('ais'=>$id), $data);
				break;
			case 'draftedStatementData':
				$data['isDeleted'] = '0';
				$tbleName = 'admin_import_statement_data';
				$where = array('id'=>$id);
				break;
			default:
				exit;
		}
		$process = $this->common_model->updateData($tbleName, $where, $data);
		echo json_encode( array( 'status' => $process ) );
	}

		
	function login() {
		if ( !$this->input->is_ajax_request() ) {
			exit( 'No direct script access allowed' );
		}
		$error = $id = '';
		$email = $this->input->post( 'email' );
		$password = md5( $this->input->post( 'password' ) );
		$rememberMe = $this->input->post( 'rememberMe' );
		$captcha = $this->input->post( 'captcha' );
		$sessionCaptcha = $this->session->CAPTCHA_s;
		if($captcha != $sessionCaptcha){
			//echo json_encode( array( 'id' => 0, 'error' => 'captcha' ) );
			//exit;
		}
		
		$result = $this->manual_model->checkLoginUserEmail($email);
		
		$id = $error = '';
		if($result){
			
			$where = array('fld_userID'=> $result[0]->fld_id, 'fld_action'=>'Login');
			$order = array('fld_created_date','DESC');
			$limit = 1;
			$audiTrailAry = $this->common_model->getAll('*', 'tbl_audittrail_user', $where, $order, $limit);
			
			$trigger = 1;
			if($audiTrailAry){
				$lastLog = $audiTrailAry[0]->fld_status;
				$trigAry = unserialize($audiTrailAry[0]->fld_data);
				$trigVal = $trigAry['trigger'];
				if($lastLog == 'Failed'){
					$trigger = $trigVal == 'suspended' ? $trigVal : (intval($trigVal) + 1);
				}
			}
			
			if($password == $result[0]->fld_password){
				if ( $result[0]->fld_status == '0' ) {
					$error = 'inactive';
					$status = 'Inactive';
					$trigger = $trigVal == 'suspended' ? $trigVal : 1;
				}else{
					$id = encode( $result[ 0 ]->fld_id );
					$this->session->set_userdata( 'UID', $id );
					$this->session->set_userdata( 'uType', $result[ 0 ]->fld_userType );
					$this->session->set_userdata( 'CREATED', time() );
					$data = array(
						'fld_activity' => 1
					);
					$this->common_model->updateData( "fld_email", $result[ 0 ]->fld_id, $data, 'tbl_user' );
					$status = 'Success';
					$trigger = $trigVal == 'suspended' ? $trigVal : 1;
				}
			}else{
				if($trigger >= 5){
					$data = array(
						'fld_status' => '0',
					);
					$this->common_model->updateData( "fld_id", $result[ 0 ]->fld_id, $data, 'tbl_user' );
					$trigger = 'suspended';
				}				
				$status = 'Failed';
				$error = 'error';
			}	
			
			$auditData = array(
				'fld_userID' => $result[0]->fld_id,
				'fld_action' => 'Login',
				'fld_status' => $status,
				'fld_data' => serialize(array('IP'=>getHostByName(getHostName()), 'trigger'=>$trigger)),
			);
			$indID = $this->common_model->saveData( 'tbl_audittrail_user', $auditData );
		}else{
			$error = 'error';
		}
		
		echo json_encode( array( 'id' => $id, 'error' => $error, 'trigger' => $trigger ) );
	}	
	
	function upgradePassword() {		 		
		$token = decode($this->input->post('token'));
		$uid = decode($this->input->post('uid'));
		$result = $this->common_model->getAll('fld_id', 'tbl_user', array('fld_id' => $uid, 'fld_token' => $token));
		if(count($result)>0){
			$data = array(
				'fld_isNewPassword' => 1,
				'fld_token' => NULL
			);
		}		
		$newPassword = $this->input->post( 'password' );
		
		if ($newPassword != '') {
			$data[ 'fld_password' ] = md5( $newPassword );
		}
		$process = $this->common_model->updateData( "fld_id", $uid, $data, 'tbl_user' );
		echo json_encode( array( 'status' => 'success' ) );
	}
	
	function resetPassword() {
		if (!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		$newPassword = $this->input->post( 'nPass' );
		$oldPassword = md5( $this->input->post( 'oPass' ) );
		if ( $newPassword != '' ) {
			$result = $this->common_model->getAll( 'aid', 'admin_user', array( "aid" => AID, "password" => $oldPassword ) );
			if ( count( $result ) > 0 ) {
				$data = array(
					'password' => md5( $newPassword )
				);
				$process = $this->common_model->updateData('admin_user', array("aid"=>AID), $data);
				$status = 'sucess';
			} else {
				$status = 'oldError';
			}
		} else {
			$status = 'passRequre';
		}
		echo json_encode( array( 'status' => $status ) );
	}
	
	function logout() {
        $this->session->sess_destroy();
		delete_cookie('AID');
		delete_cookie('UID');
        $url = $this->input->get('ulr');
        $url = $url ? '#'.$url : '';
        unset( $_SESSION['AID']);
		unset( $_SESSION['UID']);
        unset( $_SESSION['CREATED']);
        redirect( admin_url() . 'login'.$url );
    }
	
	
	function changeStatus() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$id = decode($this->input->post('id'));
		$status = $this->input->post('status');
		$type = $this->input->post('type');
		$target = $this->input->post('target');
		
		if($type == 'delete'){
			$data = array(
				'isDeleted'=> $status,
			);
		}else if($type == 'status'){
			$data = array(
				'status'=> $status,
			);
		}
		if($target == 'groups'){
			$tbl = 'customer_group';
			$where = array('id'=>$id);
		
			$this->common_model->deleteData('customer_group_member', array('group_id'=>$id));
			
		}
		else if($target == 'vendor'){
			$tbl = 'vendor';
			$where = array('vid'=>$id);
		
			$this->common_model->deleteData('vendor', array('vid'=>$id));
		}
		else if($target == 'customer'){
			$tbl = 'customer';
			$where = array('id'=>$id);
		}else if($target == 'category'){
			$tbl = 'category';
			$where = array('category_id'=>$id);
		}else if($target == 'coupon'){
			$tbl = 'coupon';
			$where = array('cid'=>$id);
		}
		
		$this->common_model->updateData($tbl,$where, $data);
		echo json_encode( array( 'status' => true ) );
	}

}