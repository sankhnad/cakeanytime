<?php
include('paths.php');
$adminDATA  = unserialize(adminDATA);
$cityListsObj = getCitiesList();

//if(!AID || !isset($adminDATA[0]->fld_aid)){
	//redirect(base_url().'login');
//}

/*$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);*/

?>
