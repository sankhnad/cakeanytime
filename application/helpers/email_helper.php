<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('sendEmail')) {
    function sendEmail($data, $emailConfig) {
		
        $CI = & get_instance();
		$CI->load->helper('path');
		include(APPPATH . 'email/messages.php');
		
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
			'smtp_port' => 465,
			'smtp_crypto'=> 'ssl',
			'smtp_user' => 'AKIAJMWPK7QUNBCT2I7Q',
			'smtp_pass' => 'AmNHx/wEfj3m1ZYuPdcy1QzvGt5ThuMpAfEao94T+DsA',
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		$CI->email->initialize($config);
		$CI->email->set_mailtype("html");
		$CI->email->set_newline("\r\n");
		
        
		$subject = isset($subText) ? $subText : FROM_NAME;
        $message = FROM_NAME;
        $to_email = $emailConfig['to_email'];
		$cc_email = isset($emailConfig['cc_email']) ? $emailConfig['cc_email'] : '';
        $from_name = isset($emailConfig['from_name']) ? $emailConfig['from_name'] : FROM_NAME;
        $from_email = isset($emailConfig['from_email']) ? $emailConfig['from_email'] : FROM_EMAIL;
        $upload_file = isset($emailConfig['upload_file']) ? $emailConfig['upload_file'] : '';
        $upload_path = isset($emailConfig['upload_path']) ? $emailConfig['upload_path'] : 'uploads/';
		$assetsPath = $CI->config->item('default_path')['email'];
		$logoPath = $CI->config->item('default_path')['assets'].'logo.png';
		if(!isset($to_email) || $to_email ==''){
			return 'error_data';
		};
		
		switch ($data['case']) {
            case 'customerEmailCustom':
                include(APPPATH . 'email/customerEmailCustom.php');
                break;
			case 'customerEmailBank':
                include(APPPATH . 'email/customerEmailBank.php');
                break;
			case 'groupEmailCustom':
                include(APPPATH . 'email/groupEmailCustom.php');
                break;
			case 'memberEmailCustom':
                include(APPPATH . 'email/memberEmailCustom.php');
                break;
			case 'forgetPassword':
                include(APPPATH . 'email/forgetPassword.php');
                break;
			case 'passwordUpdated':
                include(APPPATH . 'email/passwordUpdated.php');
                break;
			case 'activateCustomerAccount':
                include(APPPATH . 'email/activateCustomerAccount.php');
                break;
			case 'suspendCustomerAccount':
                include(APPPATH . 'email/suspendCustomerAccount.php');
                break;
			case 'approveKYC':
                include(APPPATH . 'email/approveKYC.php');
                break;
			case 'rejectKYC':
                include(APPPATH . 'email/rejectKYC.php');
                break;
            default:
				exit;
        }
		
        if ($upload_file) {
            $path = set_realpath($upload_path);
            $CI->email->attach($path . $upload_file);
        }

		
		$CI->email->to($to_email);
		$CI->email->from($from_email, $from_name);
		if($cc_email){
			$CI->email->cc($cc_email); 
		}
        $CI->email->subject($subject);
        $CI->email->message($message);
		
		$result = $CI->email->send();
		
        //Send mail 
        if ($result) {
			return 'success';			
        }else{
			//echo $CI->email->print_debugger();
            return 'error';
        }
	}
}

if(! function_exists('sendCommonEmail')){
	function sendCommonEmail($mailing, $dataAray) {
		$CI = & get_instance();
		$status = 'error';
		switch ($mailing) {
			case 'customerEmailCustom':
				$emailConfig['to_email'] = $dataAray['email'];
				$emailConfig['cc_email'] = $dataAray['cc_email'];
				$status = sendEmail($dataAray, $emailConfig);
				break;
			case 'customerEmailBank':
				$emailConfig['to_email'] = $dataAray['email'];
				$emailConfig['cc_email'] = $dataAray['cc_email'];
				$status = sendEmail($dataAray, $emailConfig);
				break;
			case 'groupEmailCustom':
				$emailConfig['to_email'] = $dataAray['email'];
				$emailConfig['cc_email'] = $dataAray['cc_email'];
				$status = sendEmail($dataAray, $emailConfig);
				break;
			case 'memberEmailCustom':
				$emailConfig['to_email'] = $dataAray['email'];
				$emailConfig['cc_email'] = $dataAray['cc_email'];
				$status = sendEmail($dataAray, $emailConfig);
				break;
			case 'forgetPassword':
				$template = $CI->common_model->getAll('subject, message, default_subject, default_msg', 'admin_message_template', array('id'=>'1'), '', '', array('isDeleted'=>array('0')));
				$data['case']  = $mailing;
				$data['token'] = $dataAray['token'];
				$data['name']  = $dataAray['name'];
				$emailConfig['to_email'] = $dataAray['email'];
				$data['email']  = $dataAray['email'];
				$data['DB_subject']  = $template[0]->subject ? $template[0]->subject : $template[0]->default_subject;
				$data['DB_message']  = $template[0]->message ? $template[0]->message : $template[0]->default_msg;
				$status = sendEmail($data, $emailConfig);
				break;
			case 'passwordUpdated':
				$template = $CI->common_model->getAll('subject, message, default_subject, default_msg', 'admin_message_template', array('id'=>'3'), '', '', array('isDeleted'=>array('0')));
				$custInfoAry = $CI->common_model->getAll('email, username', 'auth_user', array('email'=>$dataAray['email']));
				$data['case']  = $mailing;
				$data['case']  = $mailing;
				$emailConfig['to_email'] = $dataAray['email'];
				$data['email']  = $custInfoAry[0]->email;
				$data['username']  = $custInfoAry[0]->username;
				$data['DB_subject']  = $template[0]->subject ? $template[0]->subject : $template[0]->default_subject;
				$data['DB_message']  = $template[0]->message ? $template[0]->message : $template[0]->default_msg;
				$status = sendEmail($data, $emailConfig);
				break;
			case 'activateCustomerAccount':
				$template = $CI->common_model->getAll('subject, message, default_subject, default_msg', 'admin_message_template', array('id'=>'5'), '', '', array('isDeleted'=>array('0')));
				$custInfoAry = $CI->common_model->getAll('email, username', 'auth_user', array('id'=>$dataAray['id']));
				$data['case']  = $mailing;
				$emailConfig['to_email'] = $custInfoAry[0]->email;
				$data['email']  = $custInfoAry[0]->email;
				$data['username']  = $custInfoAry[0]->username;
				$data['DB_subject']  = $template[0]->subject ? $template[0]->subject : $template[0]->default_subject;
				$data['DB_message']  = $template[0]->message ? $template[0]->message : $template[0]->default_msg;
				$status = sendEmail($data, $emailConfig);
				break;
			case 'suspendCustomerAccount':
				$template = $CI->common_model->getAll('subject, message, default_subject, default_msg', 'admin_message_template', array('id'=>'7'), '', '', array('isDeleted'=>array('0')));
				$custInfoAry = $CI->common_model->getAll('email, username', 'auth_user', array('id'=>$dataAray['id']));
				$data['case']  = $mailing;
				$emailConfig['to_email'] = $custInfoAry[0]->email;
				$data['email']  = $custInfoAry[0]->email;
				$data['username']  = $custInfoAry[0]->username;
				$data['DB_subject']  = $template[0]->subject ? $template[0]->subject : $template[0]->default_subject;
				$data['DB_message']  = $template[0]->message ? $template[0]->message : $template[0]->default_msg;
				$status = sendEmail($data, $emailConfig);
				break;
			case 'approveKYC':
			case 'rejectKYC':
				$kycAccount = $CI->common_model->getAll('account', 'fimcosite_kyc', array('id'=>$dataAray['id']));
				
				$custInfoAry = $CI->manual_model->getFullCustomerData('a.email, a.username, a.first_name, a.last_name, a.id', array('d.account'=>$kycAccount[0]->account));
				
				if($mailing == 'approveKYC'){
					$templateID = '9';
				}else if($mailing == 'rejectKYC'){
					$templateID = '11';
				}else{
					break;
				}
				$template = $CI->common_model->getAll('subject, message, default_subject, default_msg', 'admin_message_template', array('id'=>$templateID), '', '', array('isDeleted'=>array('0')));
				
				$data['case']  = $mailing;
				$emailConfig['to_email'] = $custInfoAry[0]->email;
				$data['email']  = $custInfoAry[0]->email;
				$data['name']  = $custInfoAry[0]->first_name.' '.$custInfoAry[0]->last_name;
				$data['cid']  = $custInfoAry[0]->id;
				$data['comment']  = $dataAray['comment'];
				$data['username']  = $custInfoAry[0]->username;
				$data['DB_subject']  = $template[0]->subject ? $template[0]->subject : $template[0]->default_subject;
				$data['DB_message']  = $template[0]->message ? $template[0]->message : $template[0]->default_msg;
				$status = sendEmail($data, $emailConfig);
				break;
				
			default:
				break;
		}
		return $status;
	}
}
?>