<?php
if ( $customerData ) {	
	$actionBtn = 'Update';
	$lblNew = 'Edit';
	$fname = $customerData[ 0 ]->fname;
	$lname = $customerData[ 0 ]->lname;
	$email = $customerData[ 0 ]->email;
	$mobile = $customerData[ 0 ]->mobile;
	$gender = $customerData[0]->gender;
	$avtar = $customerData[ 0 ]->avtar;
	$dob = $customerData[0]->dob ? date( 'd/m/Y', strtotime($customerData[0]->dob )) : '';
	$doa = $customerData[0]->doa ? date( 'd/m/Y', strtotime($customerData[0]->doa)) : '';
	$isEmail_verified = $customerData[ 0 ]->isEmail_verified;
	$isSMS_verified = $customerData[ 0 ]->isSMS_verified;
	$status = $customerData[ 0 ]->status;
} else {
	$actionBtn = 'Save';
	$lblNew = 'New';
	$status = $isSMS_verified = $isEmail_verified = $gender = 1;
	$fname = $lname = $email = $username = $mobile = $avtar = $dob = $doa = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title><?=$lblNew?> Customer | Admin</title>
	<link href="<?=$iURL_assets?>admin/js/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
	<?php include('includes/styles.php'); ?>
</head>

<body class="no-skin">
	<?php include('includes/header.php')?>
	<div class="main-container ace-save-state" id="main-container">
		<?php include('includes/sidebar.php')?>
		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="<?=base_url()?>">Home</a>
						</li>
						<li>
							<a href="<?=admin_url()?>customers">Customers</a>
						</li>
						<li class="active">
							<a href="<?=admin_url()?>customers/<?=$lblNew?>"><?=$lblNew?> Customer</a>
						</li>
					</ul>
					<!-- /.breadcrumb -->
					<div class="nav-search">
						<i>Last Login : <?=lastLogin(AID);?></i>
					</div>
					<!-- /.nav-search -->
				</div>
				<div class="page-content">
					<div class="row">
						<div class="col-xs-12">
							<div class="headPageA">
								<div class="titleAre"><i class="fas fa-users"></i> <?=$lblNew?> Customer</div>
							</div>
							<div class="hr dotted hr-double"></div>						
							<form class="form-horizontal customerAddEdit">
								<input type="hidden" value="<?=$cid?>" name="id"/>
								<div class="row">
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">First Name *</label>
													<div class="col-md-12">
														<input type="text" value="<?=$fname?>" name="fname" class="form-control" placeholder="Enter First Name" required/>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Last Name</label>
													<div class="col-md-12">
														<input type="text" value="<?=$lname?>" name="lname" class="form-control" placeholder="Enter Last Name"/>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Group</label>
													<div class="col-md-12">
														<select class="selectpicker" name="group[]" title="Select Group" data-live-search="true" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
														<?php 
														foreach($groupAry as $groupData){
															if ($customerData){
																$isGroupSlct = search_in_array($groupSelectedAry, 'group_id', $groupData->id);
																$isGroup = $isGroupSlct  ? 'selected':'';
															}else{
																$isGroup = $groupData->isDefault == '1' ? 'selected':'';
															}
														?>
														<option <?=$isGroup?> value="<?=$groupData->id?>"><?=$groupData->name?></option>
														<?php } ?>
														</select>
													</div>
												</div>
											</div>											
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Email e.g. "abc@host.com" *</label>
													<div class="col-md-12">
														<input type="email" value="<?=$email?>" onBlur="checkCustEmailAvlb(this.value,'email')" onKeyPress="$('.emailErr').hide();" name="email" class="form-control" placeholder="Enter Email" required>
														<span class="help-block emailErr"> This email address is not available </span>
														<span class="help-block emailValidaErr"> Please enter a valid email </span>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Mobile e.g. "9999999999" *</label>
													<div class="col-md-12">
														<input onBlur="checkCustEmailAvlb(this.value,'mobile')" onKeyPress="$('.usernameErr').hide();" type="text" name="mobile" value="<?=$mobile?>" placeholder="Enter Phone Number" data-mask="0000000000" class="form-control" required>
														
														<span class="help-block usernameErr"> This phone is not available </span>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Gender</label>
													<div class="col-md-12">
														<div class="radio">
															<label>
																<input name="gender" type="radio" value="1" <?=$gender=='M' ? 'checked' : ''?> class="ace" />
																<span class="lbl"> Male</span>
															</label>
															<label>
																<input name="gender" type="radio" class="ace" value="2" <?=$gender=='F' ? 'checked' : ''?> />
																<span class="lbl"> Female</span>
															</label>
														</div>
													</div>
												</div>
											</div>
											
											<div class="clearfix"></div>
											
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Date of Birth</label>
													<div class="col-md-12">
														<div class="input-group">
															<input name="dob" class="form-control date-picker" value="<?=$dob?>"  type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" />
															<span class="input-group-addon">
																<i class="far fa-calendar-alt bigger-110"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Date of Birth</label>
													<div class="col-md-12">
														<div class="input-group">
															<input name="doa" value="<?=$doa?>" class="form-control date-picker" type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" />
															<span class="input-group-addon">
																<i class="far fa-calendar-alt bigger-110"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Password</label>
													<div class="col-md-12">
														<input type="password" name="password" class="form-control" placeholder="Enter Password">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<label for="input-file-now-custom-1">Profile Image</label>
										<input name="avtar" type="file" id="input-file-now-custom-1" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="<?=$iURL_profile?><?=$avtar ? $avtar : 'user.png'?>"/>
									</div>									
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx">
															<label>Email Verified</label>
															<label class="switchS">
															  <input name="verifiedEmail" value="1" class="switchS-input" type="checkbox" <?=$isEmail_verified == '1' ? 'checked' : ''?> />
															  <span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span> </label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx">
															<label>SMS Verified</label>
															<label class="switchS">
															  <input name="verifiedSMS" value="1" class="switchS-input" type="checkbox" <?=$isSMS_verified == '1' ? 'checked' : ''?> />
															  <span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span> </label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx">
															<label>Status</label>
															<label class="switchS switchSCuStatus">
															  <input name="status" value="1" class="switchS-input" type="checkbox" <?=$status == '1' ? 'checked' : ''?> />
															  <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label>
														</div>
													</div>
												</div>
											</div>
											<!--<div class="col-sm-4">
											  <div class="form-group">
												<div class="col-md-12">
												  <div class="borderChexBx">
													<label>Send Login Credentials</label>
													<label class="switchS">
													  <input name="credentials" value="1" class="switchS-input" type="checkbox" />
													  <span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span> </label>
												  </div>
												</div>
											  </div>
											</div>-->
											<div class="col-sm-12">
												<div class="form-group">
													<div class="col-md-12 text-right">
														<button type="button" class="btn btn-primary pull-left waves-effect waves-light mangAdresBtn <?=$customerData ? '' : 'hide_now'?>" onClick="manageAddressPan()"><i class="fa fa-map-marker"></i> Manage Address</button>
														<a href="<?=base_url('admin/customers')?>" class="btn btn-inverse waves-effect waves-light">Cancel</a>
														<button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i> <?=$actionBtn?> Customer</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					<div class="row addressAreaContnr">
						<div class="col-xs-12">
							<div class="hr"></div>
							<div class="headPageA">
								<div class="titleAre"><i class="fas fa-users"></i> Address List</div>
							</div>
							<div class="hr dotted hr-double"></div>						
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-4">
										<div class="newAddressBox waves-effect waves-light" data-toggle="modal" data-target="#addressAddEdit"> <i class="ti-plus"></i> <span>Add Address</span> </div>
									</div>
									<?php foreach($addressList as $addressData){?>
									<div class="col-sm-4">
										<div class="boxAddressDis <?=$addressData->isDefault == '1' ? 'defaultAdsULI':'' ?>">
											<div class="defultBxRa">Default Address</div>
											<ul class="addressULLI">
												<?php
												$aidEncripted = encode($addressData->aid);
												if($addressData->type == '0'){
													$aTyp = 'Home Address';
													$aTyp = '<span class="adsTypL">('.$aTyp.')<span>';
												}else if($addressData->type == '1'){
													$aTyp = 'Office Address';
													$aTyp = '<span class="adsTypL">('.$aTyp.')<span>';
													echo '<li>' . $addressData->remarks . ''.$aTyp.'</li>';
													$aTyp = '';
												}else if($addressData->type == '2'){
													$aTyp = 'Others';
													$aTyp = '<span class="adsTypL">('.$aTyp.')<span>';
												}
												if ( $addressData->name ) {
													echo '<li>' . $addressData->name . ''.$aTyp.'</li>';
												}
												if ( $addressData->address_line_1 ) {
													echo '<li>' . $addressData->address_line_1 . ',</li>';
												}
												if ( $addressData->address_line_2 ) {
													echo '<li>' . $addressData->address_line_2 . ',</li>';
												}
												if ( $addressData->landmark ) {
													echo '<li>' . $addressData->landmark . ',</li>';
												}
												if ( $addressData->city ) {
													echo '<li>' . $addressData->city . ', ' . $addressData->cityName . ',</li>';
												}
												if ( $addressData->pin ) {
													echo '<li>India - ' . $addressData->pin . '</li>';
												} else {
													echo '<li>India</li>';
												}
												if ( $addressData->mobile ) {
													echo '<li>Phone number: ' . $addressData->mobile . '</li>';
												}
																				
												if ($addressData->type == '2'){
													echo '<li>Remarks: ' . $addressData->remarks . '</li>';
												}
												?>
											</ul>
											<ul class="actionAdresULLI">
												<li onClick="editAddressModel('<?=$aidEncripted?>','<?=$cid?>')">Edit</li>
												<li onClick="deleteAddress(this, '<?=$aidEncripted?>')">Delete</li>
												<li onClick="setDefaultAddress(this, '<?=$aidEncripted?>','<?=$cid?>')">Set as Default</li>
											</ul>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<!-- /.row -->
				</div>
				<!-- /.page-content -->
			</div>
		</div>
		<!-- /.main-content -->
		<?php include('includes/footer.php')?>
	</div>
	
	<!-- Modal -- Add or Edit Address -- Modal -->
	<div id="addressAddEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="editNewAddress">
					<input type="hidden" name="aid" value=""/>
					<input type="hidden" value="<?=$cid?>" name="cid"/>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Add New Address</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group col-md-6">
								<label class="required">Full Name</label>
								<input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
							</div>
							<div class="form-group col-md-6">
								<label class="required">Mobile</label>
								<input data-tooltip="tooltip" title="10-digit mobile number without prefixes" type="text" name="mobile" data-mask="0000000000" class="form-control" required>
							</div>
							<div class="form-group col-md-6">
								<label>Country</label>
								<select class="selectpicker" data-width="100%" title="Select Country" disabled required>
									<option selected>India</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="required">PIN Code</label>
								<input data-tooltip="tooltip" title="6 digits [0-9] pincode" onBlur="getZipData(this.value)" type="text" name="pin" data-mask="000000" class="form-control" required/>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label class="required">Street Address</label>
								</div>
								<div class="col-md-6">
									<input type="text" name="addresline1" class="form-control" maxlength="60" placeholder="Flat / House No. / Floor / Building" required>
								</div>
								<div class="col-md-6">
									<input type="text" name="addresline2" class="form-control" maxlength="60" placeholder="Colony / Street / Locality">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Land Mark</label>
							<input type="text" name="landmark" class="form-control" maxlength="60" placeholder="E.g. Near AIIMS Flyover, Behind Regal Cinema, etc.">
						</div>
						<div class="row">
							<div class="form-group col-md-6">
								<label class="required">City</label>
								<input type="text" name="city" class="form-control" maxlength="60" required/>
							</div>
							<div class="form-group col-md-6">
								<label class="required">State</label>
								<select class="selectpicker" data-width="100%" name="state" title="Select State" data-live-search="true" required>
								<?php 
								foreach($stateAry as $stateData){
								?>
								<option value="<?=$stateData->sid?>"><?=$stateData->stateName?></option>
								<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label>Address Type</label>
								<div class="borderChexBx radioBtnAr">									
									<label>
										<input name="type" id="homeTyp" type="radio" checked class="ace" value="0" />
										<span class="lbl"> Home</span>
									</label>
									<label>
										<input name="type" id="officeTyp" type="radio" class="ace" value="1" />
										<span class="lbl"> Office</span>
									</label>
									<label>
										<input name="type" id="otherTyp"  type="radio" class="ace" value="2" />
										<span class="lbl"> Others</span>
									</label>
								</div>
							</div>
							<div class="form-group col-md-6 otherTypAdrs">
								<label>Remarks</label>
								<input type="text" name="remarks" class="form-control" maxlength="100" placeholder="E.g. My Sweet Home; Sister's Office etc.">
							</div>
						</div>
					</div>
					<div class="modal-footer posR">
						<div class="groupSwitch">
						<label>Mark as a default address</label>
						<label class="switchS">
							<input name="isDefault" value="1" class="switchS-input" type="checkbox">
							<span class="switchS-label" data-on="Yes" data-off="No"></span>
							<span class="switchS-handle"></span>
						</label>
						</div>
						<button type="button" class="btn btn-inverse waves-effect waves-light m-r-10" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i> Submit</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	
	<!-- basic scripts -->
	<script src="<?=$iURL_assets?>admin/js/dropify/dist/js/dropify.min.js"></script>
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		$(document).ready(function(){
			$('.dropify').dropify();
		});
		$('.date-picker').datepicker({
			autoclose: true,
		});
		
		$('.datapicker').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
		});

		$('.datapicker').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
		});
		<?php if(isset($_GET['address'])){?>
		manageAddressPan();
		<?php } ?>
		$('input[type=radio][name=type]').change(function() {
			if(this.value == '0'){
				$('.otherTypAdrs label').html('Remarks');
			}else if(this.value == '1'){
				$('.otherTypAdrs label').html('Office Name');
			}else if(this.value == '2'){
				$('.otherTypAdrs label').html('Other');
			}
		});
	</script>
</body>

</html>