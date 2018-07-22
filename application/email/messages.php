<?php
switch ($data['case']) {
	case 'customerEmailCustom':		
		$subText = str_replace(
					array(
						'[[OTP]]',
						'[[FULL_NAME]]',
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
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
						base_url(),
						web_url(),
						$data['email'],
						$data['username'],
						$data['comment'],
						$data['msisdn'],
						$data['profile_id'],
						$data['account'],
					),
					$data['DB_subject']
				);
		
		$msgText = str_replace(
					array(
						'[[OTP]]',
						'[[FULL_NAME]]',
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
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
						base_url(),
						web_url(),
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
	
	case 'customerEmailBank':		
		$subText = str_replace(
					array(
						'[[FULL_NAME]]',
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
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
						base_url(),
						web_url(),
						$data['email'],
						$data['username'],
						$data['comment'],
						$data['msisdn'],
						$data['profile_id'],
						$data['account'],
						$data['bank_account'],
					),
					$data['DB_subject']
				);
		
		$msgText = str_replace(
					array(
						'[[FULL_NAME]]',
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
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
						base_url(),
						web_url(),
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
		
		
	case 'forgetPassword':		
		$subText = $data['DB_subject'];
		$msgText = str_replace(
					array(
						'[[OTP]]',
						'[[FULL_NAME]]',
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
						'[[EMAIL]]'
					),
					array(
						$data['token'],
						$data['name'],
						date('Y'),
						base_url(),
						web_url(),
						$data['email'],
					),
					$data['DB_message']
				);
		break;
	case 'passwordUpdated':		
		$subText = $data['DB_subject'];
		$msgText = str_replace(
					array(
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
						'[[EMAIL]]'
					),
					array(
						date('Y'),
						base_url(),
						web_url(),
						$data['email'],
					),
					$data['DB_message']
				);
		break;
	case 'activateCustomerAccount':
		$subText = $data['DB_subject'];
		$msgText = str_replace(
					array(
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
						'[[EMAIL]]',
			 			'[[USERNAME]]',
					),
					array(
						date('Y'),
						base_url(),
						web_url(),
						$data['email'],
						$data['username'],
					),
					$data['DB_message']
				);
		break;
	case 'suspendCustomerAccount':		
		$subText = $data['DB_subject'];
		$msgText = str_replace(
					array(
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
						'[[EMAIL]]',
			 			'[[USERNAME]]',
					),
					array(
						date('Y'),
						base_url(),
						web_url(),
						$data['email'],
						$data['username'],
					),
					$data['DB_message']
				);
		break;
	case 'approveKYC':
	case 'rejectKYC':
		$subText = $data['DB_subject'];
		$msgText = str_replace(
					array(
						'[[YEAR]]',
						'[[ADMIN_URL]]',
						'[[WEB_URL]]',
						'[[EMAIL]]',
			 			'[[USERNAME]]',
						'[[COMMENT]]',
					),
					array(
						date('Y'),
						base_url(),
						web_url(),
						$data['email'],
						$data['username'],
						$data['comment'],
					),
					$data['DB_message']
				);
		break;
		
	case 'memberEmailCustom':		
		$subText = str_replace(
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
					$data['DB_subject']
				);
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
		
	case 'groupEmailCustom':		
		$subText = str_replace(
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
					$data['DB_subject']
				);
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
		
	default:
		break;
}
?>
