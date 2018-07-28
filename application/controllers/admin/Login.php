<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Login extends CI_Controller {
	
	function index() {
		$aid = $this->session->AID;
		$aidCookie = get_cookie('AID');
		$aid = $aidCookie ? $aidCookie : $aid;
		if($aid){
			redirect(admin_url().'dashboard');
		}
		
		$randCap = generateRandom(5);
		$captcha = $this->generateCaptcha( $randCap );
		$this->session->set_userdata( 'CAPTCHA_s', $randCap );
		$data[ 'captcha' ] = $captcha[ 'image' ];
		$this->load->view('admin/login', $data);
	}
	
	function validate() {
		if ( !$this->input->is_ajax_request() ) {
			exit( 'No direct script access allowed' );
		}
		$error = $aid = '';
		$email = $this->input->post('email');
		$password = md5( $this->input->post( 'password' ) );
		$rememberMe = $this->input->post( 'rememberMe' );
		$captcha = $this->input->post( 'captcha' );
		$sessionCaptcha = $this->session->CAPTCHA_s;
		if($captcha != $sessionCaptcha){
			//echo json_encode( array( 'id' => 0, 'error' => 'captcha' ) );
			//exit;
		}
		
		$result = $this->manual_model->checkLoginUserEmail($email);		
		
		$aid = $error = $trigger = $trigVal = '';
		if($result){			
			$where = array('userID'=> $result[0]->aid, 'action'=>'Login');
			$audiTrailAry = $this->common_model->getAll('*', 'admin_audittrail', $where, 'created_date DESC', '', '', $groupBy='', '1');
			
			$trigger = 1;
			if($audiTrailAry){
				$lastLog = $audiTrailAry[0]->status;
				$trigAry = unserialize($audiTrailAry[0]->data);
				$trigVal = $trigAry['trigger'];
				if($lastLog == 'Failed'){
					$trigger = $trigVal == 'suspended' ? $trigVal : (intval($trigVal) + 1);
				}
			}
			
			if($password == $result[0]->password){
				if ($result[0]->status == '2'){
					$error = 'suspended';
					$status = 'Suspended';
					$trigger = $trigVal == 'suspended' ? $trigVal : 1;
				}else if ($result[0]->status == '0'){
					$error = 'inactive';
					$status = 'Inactive';
					$trigger = 'inactive';
				}else{
					$aid = encode( $result[ 0 ]->aid );
					$this->session->set_userdata( 'AID', $aid );
					$this->session->set_userdata( 'CREATED', time() );
					if($rememberMe){
						$cookie= array(
						  'name'   => 'AID',
						  'value'  => $aid,
						  'expire' => time()+86500,
					  	);
					  	$this->input->set_cookie($cookie);
					}
					$status = 'Success';
					$trigger = 1;
				}
			}else{
				if($trigger >= 5){
					$data = array(
						'status' => '2',
					);
					$this->common_model->updateData('admin_user', array("aid"=> $result[ 0 ]->aid), $data);
					$trigger = 'suspended';
				}				
				$status = 'Failed';
				$error = 'error';
			}	
			
			$auditData = array(
				'userID' => $result[0]->aid,
				'ip' => getHostByName(getHostName()),
				'action' => 'Login',
				'status' => $status,
				'data' => serialize(array('trigger'=>$trigger)),
			);
			$indID = $this->common_model->saveData( 'admin_audittrail', $auditData );
		}else{
			$error = 'error';
		}
		echo json_encode( array( 'id' => $aid, 'error' => $error, 'trigger' => $trigger ) );
	}
	
	function generateCaptcha( $rand ) {
		$this->load->helper( 'captcha' );
		$this->load->helper( 'url' );
		$capPath = FCPATH.'uploads/captcha/';
		$myarray = array(
			'img_path' => $capPath,
			'img_url' => base_url( 'uploads/captcha/' ),
			'img_width' => '125',
			'img_height' => 36,
			'font_size' => 16,
			'word' => $rand,
			'colors' => array(
				'background' => array( 0, 0, 0 ),
				'border' => array( 523, 324, 654 ),
				'text' => array( 205, 195, 205 ),
				'grid' => array( 423, 867, 535 ),
			)
		);
		return create_captcha( $myarray );
	}
	
	function newCaptcha() {
		$randCap = generateRandom( 5 );
		$captcha = $this->generateCaptcha( $randCap );
		$this->session->set_userdata( 'CAPTCHA_s', $randCap );
		$result = array( 'result' => $captcha[ 'image' ] );
		echo json_encode( $result );
	}
	
	function forgetpassword() {
		if (!$this->input->is_ajax_request()){
			exit( 'No direct script access allowed' );
		}
		$email = $this->input->post('email');
		$result = $this->common_model->getAll('fname, aid, lname', 'admin_user', array('email'=>$email, 'isDeleted'=>'1'));
		if($result){
			$randToken = generateRandom(5, 'number');
			$store['token'] = md5($randToken);
			$store['modified_date'] = date("Y-m-d H:i:s", time());
			$this->common_model->updateData('admin_user', array("email"=> $email), $store);
			$data['token'] = $randToken;
			$data['name'] = $result[0]->fname.' '.$result[0]->lname;
			$data['email'] = $email;
			sendCommonEmail('forgetPassword', $data);
			$status = 'success';
		}else{
			$status = 'error';
		}
		echo json_encode(array( 'status' => $status));
	}
	
	function validateforgetPassword() {
		if (!$this->input->is_ajax_request()){
			//exit( 'No direct script access allowed' );
		}
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$data = array();
		$result = $this->common_model->getAll('aid, modified_date', 'admin_user', array('email'=>$email, 'isDeleted'=>'1', 'token'=>md5($token)));
		if($result){
			$datetime1 = new DateTime(date("Y-m-d H:i:s", time()));
			$datetime2 = new DateTime($result[0]->modified_date);
			$interval = $datetime1->diff($datetime2);
			$yrs = $interval->format('%y');
			$months = $interval->format('%m');
			$days = $interval->format('%a');
			$hrs = $interval->format('%h');
			if(($yrs > 0) || ($months > 0) || ($days > 0) || ($hrs >= 4)){
				$status = 'expired';
			}else{
				$data['id'] = encode($result[0]->aid);
				$data['token'] = encode($token);
				$data['val'] = encode($email);
				$status = 'success';
			}
		}else{
			$status = 'error';
		}
		echo json_encode(array( 'status' => $status, $data));
	}
	
	function updateFinalPass() {
		if (!$this->input->is_ajax_request()){
			exit( 'No direct script access allowed' );
		}
		$token = md5(decode($this->input->post('token')));
		$email = decode($this->input->post('val'));
		$aid = decode($this->input->post('id'));
		$password = md5($this->input->post('nPassword'));
		$data = array();
		
		if($token && $email && $aid && $password){
			$result = $this->common_model->getAll('fname, aid, lname, status', 'admin_user', array("email"=> $email, "aid"=> $aid, "token"=> $token, 'isDeleted'=>'1'));
			if($result){
				$store['token'] = '';
				$store['password'] = $password;
				$store['modified_date'] = date("Y-m-d H:i:s", time());
				if($result[0]->status == '2'){
					$store['status'] = '1';
				}
				$this->common_model->updateData('admin_user', array("email"=> $email, "aid"=> $aid, "token"=> $token), $store);
				
				$auditData = array(
					'userID' => $aid,
					'ip' => getHostByName(getHostName()),
					'action' => 'Forget Password Reset',
					'status' => 'Success',
					'data' => serialize(array('trigger'=>'1')),
				);
				$indID = $this->common_model->saveData( 'admin_audittrail', $auditData );
				
				$data['email'] = $email;
				sendCommonEmail('passwordUpdated', $data);
				$status = 'success';
			}else{
				$status = 'invalid';
			}
		}else{
			$status = 'error';
		}
		echo json_encode(array( 'status' => $status));
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
}