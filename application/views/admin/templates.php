<?php
	$tabbing = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : FALSE;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/commonfile.php');?>
	<title>KYC Details | POCHI Admin</title>
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
							<a href="<?=base_url()?>customers/pending-kyc">Others</a>
						</li>
						<li class="active">Templates</li>
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
							<div class="hr dotted hr-double"></div>
							<div class="row">
								<div class="col-sm-12">
									<div class="tabbable">
										<ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
											
											<li class="<?=$tabType == '2' ?  'active':''?>">
												<a data-toggle="tab" href="#mesgTmpl"><i class="blue ace-icon far fa-envelope-open bigger-120"></i> Email Template</a>
											</li>
											<li class="<?=$tabType == '1' ?  'active':''?>">
												<a data-toggle="tab" href="#smsTmpl"><i class="blue ace-icon far fa-comment-alt bigger-120"></i> SMS Template</a>
											</li>
										</ul>

										<div class="tab-content">
											<div id="mesgTmpl" class="tab-pane <?=$tabType == '2' ?  'in active':''?>">
												<div class="tabbable tabs-left">
													<ul class="nav nav-tabs">
														<?php $m = $tabID;
															foreach($msgTemplateAry as $msgTemplate){
															$isActivT = '';
															if($m == '' || ($tabType == '1' && $m > 0) || ($m == $msgTemplate->id && $tabType == '2')){
																if($tabbing == 'add-sms' || !$tabbing){
																	$isActivT = 'active';
																}
															}
															$msgTitle = $msgTemplate->title ? $msgTemplate->title : $msgTemplate->default_title;
															$m = 'false';
														?>
														<li class="<?=$isActivT?>">
															<a data-toggle="tab" href="#msgTab<?=$msgTemplate->id?>">
															<i class="green ace-icon far fa-envelope-open bigger-110"></i> <?=$msgTitle?></a>
														</li>
														<?php } ?>
														<li class="<?=$tabbing == 'add-email' ? 'active' : '' ?>">
															<a data-toggle="tab" href="#addMoreMsg">
															<i class="red ace-icon fas fa-plus bigger-110"></i> Add More</a>
														</li>
													</ul>
													<div class="tab-content">
														<?php $m = $tabID;
															foreach($msgTemplateAry as $msgTemplate){
															$eID = encode($msgTemplate->id);
															$isActivT = '';
															if($m == '' || ($tabType == '1' && $m > 0) || ($m == $msgTemplate->id && $tabType == '2')){	
																if($tabbing == 'add-sms' || !$tabbing){
																	$isActivT = 'in active';
																}
															}
																
															$m = 'false';
															$msgTitle = $msgTemplate->title ? $msgTemplate->title : $msgTemplate->default_title;
																
															$msgSubject = $msgTemplate->subject ? $msgTemplate->subject : $msgTemplate->default_subject; 
																
															$msgMessage = $msgTemplate->message ? $msgTemplate->message : $msgTemplate->default_msg;
														?>
														<div id="msgTab<?=$msgTemplate->id?>" class="tab-pane <?=$isActivT?>">
															<form class="msgSMSTemplFrm<?=$msgTemplate->id?>">
															<input type="hidden" value="<?=$eID?>" name="templateID" >
															<input type="hidden" name="type" value="2" />
															<div class="row">
																<div class="col-md-8 titleAraBtop">
																	<label class="required">Title</label>
																	<input maxlength="30" required name="title" type="text" class="form-control" value="<?=$msgTitle?>" />
																</div>
																<div class="col-md-4 btnAraBtop text-right"><br>
																	<?php if($msgTemplate->default_title || $msgTemplate->default_subject || $msgTemplate->default_msg){?>
																	<button onClick="restoreDefaltTemplt(this,'<?=$eID?>')" type="button" class="btn btn-warning"><i class="ace-icon fas fa-undo-alt bigger-110"></i> Restore Default</button>
																	<?php } ?>
																	<?php if($msgTemplate->isDeleted != '2'){?>
																	<button onClick="deleteTemplate('<?=$eID?>',2)" type="button" class="btn btn-danger"><i class="ace-icon fas fa-trash-alt bigger-110"></i> Delete</button>
																	<?php } ?>
																	<button type="submit" class="btn subDataTmp hide_now btn-success"><i class="ace-icon far fa-save bigger-110"></i> Update</button>
																</div>
															</div>
															
															<hr>
															<div>
																<label class="required">Subject</label>
																<input required type="text" name="subject" class="form-control" value="<?=$msgSubject?>" />
															</div><br>

															<label class="required">Message</label>
															<textarea required name="message" class="summernote"><?=$msgMessage?></textarea>
															</form>
														</div>
														<?php } ?>														
														<div id="addMoreMsg" class="tab-pane <?=$tabbing == 'add-email' ? 'in active' : '' ?>">
															<form class="msgSMSTemplFrmM">
															<input type="hidden" name="type" value="2" />
															<div class="row">
																<div class="col-md-9">
																	<label class="required">Title</label>
																	<input maxlength="30" name="title" type="text" class="form-control" value="" />
																</div>
																<div class="col-md-3 text-right"><br>
																	<button type="submit" class="btn btn-success"><i class="ace-icon fas fa-check bigger-110"></i> Save</button>
																</div>
															</div>
															<hr>
															<div>
																<label class="required">Subject</label>
																<input required name="subject" type="text" class="form-control" value="" />
															</div><br>
															<label class="required">Message</label>
															<textarea required name="message" class="summernote"></textarea>
															</form>
														</div>
													</div>
												</div>
											</div>
											<div id="smsTmpl" class="tab-pane <?=$tabType == '1' ?  'in active':''?>">
												<div class="tabbable tabs-left">
													<ul class="nav nav-tabs">
														<?php $m = $tabID;
															foreach($smsTemplateAry as $smsTemplate){
															$isActivT = '';
															if($m == '' || ($tabType == '2' && $m > 0) || ($m == $smsTemplate->id && $tabType == '1')){
																if($tabbing == 'add-email' || !$tabbing){
																	$isActivT = 'active';
																}
															}
															$msgTitle = $smsTemplate->title ? $smsTemplate->title : $smsTemplate->default_title;
															$m = 'false';
														?>
														<li class="<?=$isActivT?>">
															<a data-toggle="tab" href="#smsTab<?=$smsTemplate->id?>">
															<i class="green ace-icon far fa-comment-alt bigger-110"></i> <?=$msgTitle?></a>
														</li>
														<?php } ?>
														<li class="<?=$tabbing == 'add-sms' ? 'active' : '' ?>">
															<a data-toggle="tab" href="#addMoreSMS">
															<i class="red ace-icon fas fa-plus bigger-110"></i> Add More</a>
														</li>
													</ul>
													<div class="tab-content">
														<?php $m = $tabID;
															foreach($smsTemplateAry as $smsTemplate){
															$eID = encode($smsTemplate->id);
															$isActivT = '';
															if($m == '' || ($tabType == '2' && $m > 0) || ($m == $smsTemplate->id && $tabType == '1')){
																if($tabbing == 'add-email' || !$tabbing){
																	$isActivT = 'in active';
																}
															}
															$m = 'false';
															$msgTitle = $smsTemplate->title ? $smsTemplate->title : $smsTemplate->default_title;
																
															$msgSubject = $smsTemplate->subject ? $smsTemplate->subject : $smsTemplate->default_subject; 
																
															$msgMessage = $smsTemplate->message ? $smsTemplate->message : $smsTemplate->default_msg;
														?>
														
														<div id="smsTab<?=$smsTemplate->id?>" class="tab-pane <?=$isActivT?>">
															<form class="msgSMSTemplFrm<?=$smsTemplate->id?>">
															<input type="hidden" value="<?=$eID?>" name="templateID" >
															<input type="hidden" name="type" value="1" />
															<div class="row">
																<div class="col-md-8 titleAraBtop">
																	<label class="required">Title</label>
																	<input maxlength="30" name="title" type="text" class="form-control" value="<?=$msgTitle?>" required />
																</div>
																<div class="col-md-4 btnAraBtop text-right"><br>
																	<?php if($smsTemplate->default_title || $smsTemplate->default_subject || $smsTemplate->default_msg){?>
																	<button onClick="restoreDefaltTemplt(this,'<?=$eID?>')" type="button" class="btn btn-warning"><i class="ace-icon fas fa-undo-alt bigger-110"></i> Restore Default</button>
																	<?php } ?>
																	<?php if($msgTemplate->isDeleted != '2'){?>
																	<button onClick="deleteTemplate('<?=$eID?>',1)" type="button" class="btn btn-danger"><i class="ace-icon fas fa-trash-alt bigger-110"></i> Delete</button>
																	<?php } ?>
																	<button type="submit" class="btn subDataTmp hide_now btn-success"><i class="ace-icon far fa-save bigger-110"></i> Update</button>
																</div>
															</div>
															<hr>
															<div>
																<label class="required">Sender Name</label>
																<input name="subject" type="text" class="form-control" value="<?=$msgSubject?>" required />
															</div><br>

															<label class="required">SMS Text</label>
															<textarea required name="message" rows="8" class="form-control"><?=$msgMessage?></textarea>
															</form>
														</div>
														<?php } ?>
														
														<div id="addMoreSMS" class="<?=$tabbing == 'add-sms' ? 'in active' : '' ?> tab-pane">
															<form class="msgSMSTemplFrmS">
															<input type="hidden" name="type" value="1" />
															<div class="row">
																<div class="col-md-9">
																	<label class="required">Title</label>
																	<input maxlength="30" name="title" type="text" class="form-control" value="" required />
																</div>
																<div class="col-md-3 text-right"><br>
																	<button type="submit" class="btn btn-success"><i class="ace-icon fas fa-check bigger-110"></i> Save</button>
																</div>
															</div>
															<hr>
															<div>
																<label class="required">Sender Name</label>
																<input name="subject" type="text" class="form-control" value="" required />
															</div><br>
															<label class="required">SMS Text</label>
															<textarea required name="message" rows="8" class="form-control"></textarea>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
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
	<!-- /.main-container -->

	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	
	<script>
		$(document).ready(function() {
		  $('.summernote').summernote({
			  height: 250,
			  codemirror: {
				theme: 'monokai'
			  }
			});
		});
		$('.summernote').summernote({
		  height: 250,
		  codemirror: {
			theme: 'monokai'
		  }
		});
		$('input[name="subject"], textarea[name="message"], input[name="title"]').keyup(function(){
			$(this).closest('form').find('.subDataTmp').show();
			$(this).closest('form').find('.titleAraBtop').removeClass('col-md-8').addClass('col-md-6');
			$(this).closest('form').find('.btnAraBtop').removeClass('col-md-4').addClass('col-md-6');
		});
		
		$(".summernote").on("summernote.change", function (e) {
			$(this).closest('form').find('.subDataTmp').show();
			$(this).closest('form').find('.titleAraBtop').removeClass('col-md-8').addClass('col-md-6');
			$(this).closest('form').find('.btnAraBtop').removeClass('col-md-4').addClass('col-md-6');
		});
	</script>
</body>

</html>