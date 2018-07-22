<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('sendSMS')) {
    function sendSMS($data) {
        $CI = & get_instance();	
		
		$AUTH_ID = 'sankhnad';
		$AUTH_TOKEN = 'sd354f3sd54f';		
		
		$sms_text = generateMsgText($data);
		$sms_from = $data['sms_from'] ? $data['sms_from'] : SMS_FROM;
		$sms_to = $data['sms_to'];
		
		if(!$sms_text || !$sms_from || !$sms_to){
			return 'error_data';
		}
		
		$url = 'https://smsgateway.com/'.$AUTH_ID.'/message/';
		$data = array("from" => "$sms_from", "to" => "$sms_from", "text" => "$sms_text");
		$data_string = json_encode($data);
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$response = curl_exec( $ch );
		curl_close($ch);
		return 'success';
    }
	
	function generateMsgText($data) {
		switch ($data['case']) {
			case 'customerEmailCustom':			
				$msgText = str_replace(
					array(
						'[[OTP]]',
						'[[FULL_NAME]]',
						'[[YEAR]]',
						'[[WEB_URL]]',
						'[[ADMIN_URL]]',
						'[[EMAIL]]',
						'[[USERNAME]]',
						'[[COMMENT]]',
						'[[PHONE]]',
						'[[POCHI_ID]]',
						'[[ACCOUNT_NUM]]',
					),
					array(
						'OTP',
						$data['name'],
						date('Y'),
						web_url(),
						base_url(),
						$data['email'],
						$data['username'],
						$data['comment'],
						$data['msisdn'],
						$data['profile_id'],
						$data['account'],
					),
					$data['DB_message']
				);
				break;
				
			case 'customerSMSBank':
				$msgText = str_replace(
					array(
						'[[FULL_NAME]]',
						'[[YEAR]]',
						'[[WEB_URL]]',
						'[[ADMIN_URL]]',
						'[[EMAIL]]',
						'[[USERNAME]]',
						'[[COMMENT]]',
						'[[PHONE]]',
						'[[POCHI_ID]]',
						'[[ACCOUNT_NUM]]',
						'[[BANK_ACCOUNT_NUM]]',
					),
					array(
						$data['name'],
						date('Y'),
						web_url(),
						base_url(),
						$data['email'],
						$data['username'],
						$data['comment'],
						$data['msisdn'],
						$data['profile_id'],
						$data['account'],
						$data['bank_account'],
					),
					$data['DB_message']
				);
			break;
				
			case 'memberSMSCustom':			
				$msgText = str_replace(
					array(
						'[[FULL_NAME]]',
						'[[GROUP_NAME]]',
						'[[GROUP_ACCOUNT]]',
						'[[COMMENT]]',						
						'[[EMAIL]]',
						'[[USERNAME]]',
						'[[PHONE]]',
						'[[POCHI_ID]]',
						'[[ACCOUNT_NUM]]',
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
					),
					array(
						$data['name'],
						$data['group_name'],
						$data['group_account'],
						$data['comment'],						
						$data['email'],
						$data['username'],
						$data['msisdn'],
						$data['profile_id'],
						$data['account'],
						date('Y'),
						base_url(),
						web_url(),
					),
					$data['DB_message']
				);
				break;
				
			case 'groupSMSCustom':			
				$msgText = str_replace(
					array(
						'[[GROUP_NAME]]',
						'[[GROUP_ACCOUNT]]',
						'[[COMMENT]]',
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
					),
					array(
						$data['group_name'],
						$data['group_account'],
						$data['comment'],
						date('Y'),
						base_url(),
						web_url(),
					),
					$data['DB_message']
				);
				break;
			
			case 'forgetPassword':		
				$msgText = str_replace(
							array(
								'[[OTP]]',
								'[[FULL_NAME]]',
								'[[YEAR]]',
								'[[WEB_URL]]',
								'[[ADMIN_URL]]',
								'[[EMAIL]]'
							),
							array(
								$data['token'],
								$data['name'],
								date('Y'),
								web_url(),
								base_url(),
								$data['email'],
							),
							$data['DB_message']
						);
				break;
			default:
				break;
		}
		return trim($msgText);
	}
}

if(! function_exists('sendCommonSMS')){
	function sendCommonSMS($case, $dataAray) {
		$CI = & get_instance();
		$status = 'error';
		switch ($case) {				
			case 'customerSMSCustom':
				$status = sendSMS($dataAray);
				break;
			case 'customerSMSBank':
				$status = sendSMS($dataAray);
				break;
			case 'memberSMSCustom':
				$status = sendSMS($dataAray);
				break;
			case 'forgetPassword':
				$template = $CI->common_model->getAll('subject, message, default_subject, default_msg', 'admin_message_template', array('id'=>'2'), '', '', array('isDeleted'=>array('0')));
				$data['case']  = $case;
				$data['to_number'] = $dataAray['phone'];
				$data['DB_message']  = $template[0]->message ? $template[0]->message : $template[0]->default_msg;
				sendSMS($data, $emailConfig);
				break;
			default:
				break;
		}
		return $status;
	}
}

?>
