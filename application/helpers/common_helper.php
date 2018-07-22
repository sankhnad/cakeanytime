<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Sankhnad Mishra.
 * User: info@sankhnad.com
 * Date: 03 July 2018
 * Time: 05:14 PM
 */

if(! function_exists('uploadFiles')){
	function uploadFiles( $fileName, $path = 'uploads/', $thumbs = '', $height = 240, $width = 360, $fileType = 'img' ) {
		$CI = & get_instance();
		$picture = $_FILES[ $fileName ][ 'name' ];
		$uploadFileName = '';
		if ( $picture ) {
			$config[ 'encrypt_name' ] = TRUE;
			$config[ 'upload_path' ] = $path;
			if ( $fileType == 'img' ) {
				$config[ 'allowed_types' ] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
			} else if ( $fileType == 'doc' ) {
				$config[ 'allowed_types' ] = 'pdf|doc|docx|ppt|xls|xlsx|txt|PDF|DOC|DOCX|PPT|TXT|XLS|XLSX';
			}else{
				$config[ 'allowed_types' ] = $fileType;
			}
			
			$CI->load->library( 'upload', $config );
			$CI->upload->initialize( $config );
			if ( $CI->upload->do_upload( $fileName ) ) {
				$fileData = $CI->upload->data();
				$uploadFileName = $fileData[ 'file_name' ];
			}
			if ( $thumbs != ''  && isset($fileData)) {
				$CI->gallery_path = realpath( APPPATH . '../' . $path );
				$config1 = array(
					'image_library' => 'gd2',
					'source_image' => $fileData[ 'full_path' ],
					'new_image' => $CI->gallery_path . '/' . $thumbs,
					'maintain_ratio' => TRUE,
					'create_thumb' => TRUE,
					'thumb_marker' => '',
					'width' => $width,
					'height' => $height
				);
				$CI->load->library( 'image_lib', $config1 );
				$CI->image_lib->resize();
			}
			return $uploadFileName;
		}
	}
}

if(! function_exists('generateRandom')){
	function crypto_rand_secure($min, $max){
		$range = $max - $min;
		if ($range < 1) return $min; // not so random...
		$log = ceil(log($range, 2));
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd > $range);
		return $min + $rnd;
	}
	function generateRandom($length,$type='all'){
		$token = "";
		if($type == 'all'){
		$codeAlphabet = "ABCEFGHJKLMNPQRSTUVWXYZ";
		$codeAlphabet.= "0123456789";
		}else if($type == 'string'){
			$codeAlphabet = "ABCEFGHJKLMNPQRSTUVWXYZ";
		}else if($type == 'number'){
			$codeAlphabet = "0123456789";
		}else{
			$codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+=-:"?><{}][/';
		}
		$max = strlen($codeAlphabet);
		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
		}
		return $token;
	}
}

if(! function_exists('trimData')){
	function trimData($str, $limit=100, $strip = false) {
		$str = ($strip == true)?strip_tags($str):$str;
		if (strlen ($str) > $limit) {
			$str = substr ($str, 0, $limit - 3);
			return (substr ($str, 0, strrpos ($str, ' ')).'...');
		}
		return trim($str);
	}
}

if(! function_exists('timeAgo')){
	function timeAgo($timestamp){
		$datetime1=new DateTime("now");
		$datetime2=date_create($timestamp);
		$diff=date_diff($datetime1, $datetime2);
		$timemsg='';
		if($diff->y > 0){
			$timemsg = $diff->y .' year'. ($diff->y > 1?"'s":'');
	
		}
		else if($diff->m > 0){
		 $timemsg = $diff->m . ' month'. ($diff->m > 1?"'s":'');
		}
		else if($diff->d > 0){
		 $timemsg = $diff->d .' day'. ($diff->d > 1?"'s":'');
		}
		else if($diff->h > 0){
		 $timemsg = $diff->h .' hour'.($diff->h > 1 ? "'s":'');
		}
		else if($diff->i > 0){
		 $timemsg = $diff->i .' minute'. ($diff->i > 1?"'s":'');
		}
		else if($diff->s > 0){
		 $timemsg = $diff->s .' second'. ($diff->s > 1?"'s":'');
		}	
		$timemsg = $timemsg.' ago';
		return $timemsg;
	}
}

if(! function_exists('encode')){
	function encode($str){		
		for($i=0; $i<3;$i++){
			//$str=strrev(base64_encode($str));
			$str = strtr(strrev(base64_encode($str)), '+/=', '._-');
		}
		return $str;
	}
}

if(! function_exists('decode')){	
	function decode($str){
	  for($i=0; $i<3;$i++){
		  //$str=base64_decode(strrev($str));
		  $str = base64_decode(strtr(strrev($str), '._-', '+/='));
	  }
	  return $str;
	}
}

if(! function_exists('getIndicatrIParent')){
    function getIndicatrIParent($iid='',$status='') {
		$CI = & get_instance();
		if($status != ''){
			$where = array('id'=>$iid, 'status'=>$status);
		}else{
			$where = array('id'=>$iid);
		}
		return $CI->common_model->getAll( '*', 'tbl_indicator_master', $where, array( 'sort', 'asc' ) );
	}
}

if (!function_exists('array_tree')){
  function array_tree($arr, $main_index, $parent_index, $child_index) {
    $new = array();
    foreach ($arr as $a){
      $new[$a[$parent_index]][] = $a;
    }
    // we create a closure in order to be recursive
    function create_tree(&$list, $parent, $i, $c) {
      $tree = array();
      foreach ($parent as $k => $l){
        if(isset($list[$l[$i]])){
          $l[$c] = create_tree($list, $list[$l[$i]], $i, $c);
        }
        $tree[] = $l;
      }
      return $tree;
    }
    return create_tree($new, $new[0], $main_index, $child_index);
  }
}

if(!function_exists('createNotification()')){
  function createNotification($data=array()) {
    if($data){
		$CI = & get_instance();
		return $CI->common_model->saveData("tbl_notification", $data);
	}
  }
}

if(! function_exists('notficationCount')){
    function notficationCount($uType, $status='') {
		$CI = & get_instance();
		if($status != ''){
			$where = array('visibleTo_id'=>$uType, 'is_read'=>$status);
		}else{
			$where = array('visibleTo_id'=>$uType);
		}
		return $CI->common_model->countResults('tbl_notification', $where);
	}
}

if(! function_exists('search_in_array')){
	function search_in_array($array, $key, $value){ 
		$results = array(); 

		if (is_array($array)) 
		{ 
			if (isset($array[$key]) && $array[$key] == $value) 
				$results[] = $array; 

			foreach ($array as $subarray) 
				$results = array_merge($results, search_in_array($subarray, $key, $value)); 
		} 

		return $results; 
	} 
}

if(! function_exists('lastLogin')){
	function lastLogin($uid){
		$CI = & get_instance();
		$lstLoginAry = $CI->common_model->getAll('created_date', 'admin_audittrail', array('userID'=>$uid, 'user_type'=>'0', 'action' => 'Login', 'status' => 'Success'), 'created_date desc', '', '', '', '2');
		if($lstLoginAry){
			if(isset($lstLoginAry[1]->created_date)){
				return date('jS M Y | h:i A', strtotime($lstLoginAry[1]->created_date));
			}else{
				return date('jS M Y | h:i A', strtotime($lstLoginAry[0]->created_date));
			}
		}else{
			return 'Today';
		}
	}
}

if(! function_exists('adminLastLogin')){
	function adminLastLogin($aid){
		$CI = & get_instance();
		$lstLoginAry = $CI->common_model->getAll('created_date', 'admin_audittrail', array('userID'=>$aid, 'user_type'=>'0', 'action' => 'Login', 'status' => 'Success'), 'created_date desc', '', '', '', '1');
		if($lstLoginAry){
			return $lstLoginAry[0]->created_date;
		}
	}
}

if(! function_exists('customerLastLogin')){
	function customerLastLogin($cid){
		$CI = & get_instance();
		$lstLoginAry = $CI->common_model->getAll('created_date', 'admin_audittrail', array('userID'=>$cid, 'user_type'=>'1', 'action' => 'Login', 'status' => 'Success'), 'created_date desc', '', '', '', '1');
		if($lstLoginAry){
			return $lstLoginAry[0]->created_date;
		}
	}
}

if(! function_exists('ispendingKYC')){
	function ispendingKYC(){
		$CI = & get_instance();
		return 5;
	}
}

if(! function_exists('ispendingContact')){
	function ispendingContact(){
		$CI = & get_instance();
		return $CI->common_model->countResults('admin_contact_us', array('isRead'=>'1'));
	}
}

if(! function_exists('ispendingBank')){
	function ispendingBank(){
		$CI = & get_instance();
		return 10;
	}
}

if(! function_exists('validatePassword')){
	function validatePassword($decrypted, $encrypted) { 
		// $decrypted, $encrypted = 'abc', 'pbkdf2_sha256$36000$7Ceq5OMccwI9$pK+DdwQKNPICUdCWF9aCvS3jqNCNJu5ySNv1WGa3uck='
		$pieces = explode("$", $encrypted);

		$iterations = $pieces[1];
		$salt = $pieces[2];
		$old_hash = $pieces[3];

		$hash = hash_pbkdf2("SHA256", $decrypted, $salt, $iterations, 0, true);
		$hash = base64_encode($hash);

		if ($hash == $old_hash) {
		   return true;
		}
		else {
		   return false; 
		}
	}
}

if(! function_exists('encryptPassword')){
	function encryptPassword($password, $iterations=36000, $algorithm='sha256'){
		// Django password in PHP
		$salt = base64_encode(openssl_random_pseudo_bytes(9));
		$hash = hash_pbkdf2($algorithm, $password, $salt, $iterations, 32, true);
		return 'pbkdf2_' . $algorithm . '$' . $iterations . '$' . $salt . '$' . base64_encode($hash);
	}
}

if(! function_exists('store_url')){
	function store_url($uri = ''){
		$domain = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
		$domain = preg_replace('/index.php.*/', '', $domain);
		if (!empty($_SERVER['HTTPS'])) {
			return 'https://' . $domain.'admin/';
		} else {
			return 'http://' . $domain.'admin/';
		}		
	}
}

if(! function_exists('admin_url')){
	function admin_url($uri = ''){
		$domain = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
		$domain = preg_replace('/index.php.*/', '', $domain);
		if (!empty($_SERVER['HTTPS'])) {
			return 'https://' . $domain.'admin/';
		} else {
			return 'http://' . $domain.'admin/';
		}		
	}
}

if(! function_exists('getTemplateEnSList')){
	function getTemplateEnSList($type = ''){
		$CI = & get_instance();
		if($type){
			$where = array('type'=>$type);
		}
		return $CI->common_model->getAll('id, title, default_title', 'admin_message_template', $where, 'created_on desc', '', array('isDeleted'=>array('0')));
	}
}

if(! function_exists('convertToSQLDate')){
	function convertToSQLDate($date, $symbol = '/'){
		$bothDate = explode("-", $date);
		$startDate = explode( $symbol, trim($bothDate[0]));
		$startDate = $startDate[2].'-'.$startDate[1].'-'.$startDate[0];
		if(isset($bothDate[1])){
			$endDate = explode( $symbol, trim($bothDate[1]));			
			$endDate = $endDate[2].'-'.$endDate[1].'-'.$endDate[0];
			return array($startDate, $endDate);
		}else{
			return $startDate;
		}
	}
}

if(! function_exists('getCitiesList')){
    function getCitiesList($where = array()) {
		$CI = & get_instance();
		$where['isDeleted'] = '1';
		$where['status'] = '1';		
		$cityObj = $CI->common_model->getAll('*', 'location_city', $where, 'cityName asc');
		return $cityObj;
	}
}
if(! function_exists('getCategoryList')){
    function getCategoryList($where) {
		$CI = & get_instance();
		$ref = [];
		$items = [];
		$categoryObj = $CI->common_model->getAll('*', 'category', $where, 'sort_order asc');
		
		foreach ( $categoryObj as $categoryData ) {
			$thisRef = & $ref[ $categoryData->category_id ];
			$thisRef[ 'category_id' ] = $categoryData->category_id;
			$thisRef[ 'parent_id' ] = $categoryData->parent_id;
			$thisRef[ 'name' ] = $categoryData->name;
			$thisRef[ 'url_slug' ] = $categoryData->url_slug;
			$thisRef[ 'status' ] = $categoryData->status;
			$thisRef[ 'isTopBar' ] = $categoryData->isTopBar;
			$thisRef[ 'isLeftBar' ] = $categoryData->isLeftBar;
			$thisRef[ 'icon' ] = $categoryData->icon;
			$thisRef[ 'sort_order' ] = $categoryData->sort_order;
			if ( $categoryData->parent_id == 0 ) {
				$items[ $categoryData->category_id ] = & $thisRef;
			} else {
				$ref[ $categoryData->parent_id ][ 'child' ][ $categoryData->category_id ] = & $thisRef;
			}
		}
		return array($ref,$items);
	}
}

if(! function_exists('convertData')){
	function convertData($date, $type='database') {
		$newDate = false;
		if($type == 'database' && $date){
			$date =  explode("/",$date);
			if(isset($date[2])){
				$newDate = $date[2].'-'.$date[1].'-'.$date[0];
			}
		}
		if($type == 'front' && $date){
			$newDate = date('d/m/Y', strtotime($date));
		}
		return $newDate;
	}
}

if(!function_exists('slugify')){
	function slugify($string, $replace = array(), $delimiter = '-', $locale = 'en_US.UTF-8', $encoding = 'UTF-8') {
		if (!extension_loaded('iconv')) {
			throw new Exception('iconv module not loaded');
		}
		// Save the old locale and set the new locale
		$oldLocale = setlocale(LC_ALL, '0');
		setlocale(LC_ALL, $locale);
		$clean = iconv($encoding, 'ASCII//TRANSLIT', $string);
		if (!empty($replace)) {
			$clean = str_replace((array) $replace, ' ', $clean);
		}
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower($clean);
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		$clean = trim($clean, $delimiter);
		// Revert back to the old locale
		setlocale(LC_ALL, $oldLocale);
		return $clean;
	}
}

if(! function_exists('getProductist')){
    function getProductist($where) {
		$CI = & get_instance();
		$ref = [];
		$items = [];
		$productObj = $CI->common_model->getAll('*', 'product', $where, 'sort_order asc');
		foreach ( $productObj as $productData ) {
			$thisRef = & $ref[ $productData->product_id ];
			$thisRef[ 'product_id' ] = $productData->product_id;
			$thisRef[ 'model' ] = $productData->model;
			$thisRef[ 'name' ] = $productData->name;
			$thisRef[ 'url_slug' ] = $productData->url_slug;
			$thisRef[ 'image' ] = $productData->image;
			
			$thisRef[ 'quantity' ] = $productData->quantity;
			$thisRef[ 'stock_status_id' ] = $productData->stock_status_id;
			
			$thisRef[ 'price' ] = $productData->price;
			$thisRef[ 'date_available' ] = $productData->date_available;
			$thisRef[ 'weight' ] = $productData->weight;
			$thisRef[ 'weight_class_id' ] = $productData->weight_class_id;
			$thisRef[ 'lenght_class_id' ] = $productData->lenght_class_id;
			$thisRef[ 'length' ] = $productData->length;
			$thisRef[ 'width' ] = $productData->width;
			$thisRef[ 'height' ] = $productData->height;
			$thisRef[ 'description' ] = $productData->description;
			$thisRef[ 'status' ] = $productData->status;
			$thisRef[ 'sort_order' ] = $productData->sort_order;
			
			$items[ $productData->product_id ] = & $thisRef;
		}
		return array($items);
	}
}


?>
