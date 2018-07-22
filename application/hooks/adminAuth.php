<?php
class adminAuth{
	protected $CI;

	public function __construct() {
		$this->CI = & get_instance();
	}

	public function loginAuth(){
		$uType = '';
		$aid = $this->CI->session->AID;
		$aidCookie = get_cookie('AID');
		$aid = $aidCookie ? $aidCookie : $aid;	
		define('eAID',$aid);
		$aid = decode($aid);
		$adminData = '';
		if($aid){
			$adminData = $this->CI->common_model->getAll('*', 'admin_user', array('aid'=>$aid, 'status'=>'1'));
			if($adminData){
				$uType = $adminData[0]->role;
			}
		}
		define('adminDATA',serialize($adminData));
		define('AID',$aid);
		define('uType',$uType);
	}
}
?>
