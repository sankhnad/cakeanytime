<?php
class userAuth{
	protected $CI;

	public function __construct() {
		$this->CI = & get_instance();
	}

	public function selectedCity(){
		$city = $this->CI->session->CITY;
		$cityCookie = get_cookie('CITY');
		$city = $cityCookie ? $cityCookie : $city;
		$cityName = '';
		if($city){
			$cityListsObj = getCitiesList(array('cid'=>$city));
			if($cityListsObj){
				$cityName = $cityListsObj[0]->cityName;
			}else{
				$city = '';
			}
		}
		define('CITY',$city);
		define('CITY_NAME',$cityName);
	}
}
?>
