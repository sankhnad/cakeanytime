<?php
$adminData  = unserialize(adminDATA);
if(!AID || !isset($adminData[0]->aid)){
	redirect(admin_url().'login');
}
include('path.php');
$ispendingContact = ispendingContact();
$pendgKYCNum = ispendingKYC();
$pendgBankNum = ispendingBank();
?>

