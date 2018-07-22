<?php
	$customerList = '';
	foreach($customerAry as $data){
		if(in_array($data->id,$custIds)){
			$customerList .= '<option selected="selected" value="'.$data->id.'">'.$data->fname.' '.$data->lname.'</option>';
		}else{
			$customerList .= '<option value="'.$data->id.'">'.$data->fname.' '.$data->lname.'</option>';
		}
	}

	

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Group Detail | POCHI Admin</title>
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
							<a href="<?=admin_url()?>">Home</a>
						</li>
						<li>
							<a href="<?=admin_url()?>groups">Groups List</a>
						</li>
						<li class="active">Group Detail</li>
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
								<div class="infobox infobox-green mt0">
									<div class="infobox-icon">
										<i class="ace-icon fas fa-users"></i>
									</div>
									<div class="infobox-data">
										<span class="infobox-data-number"><?=$groupDetailAry[0]->name?></span>
										<div class="infobox-content">Group Name</div>
									</div>
								</div>
								
								<div class="infobox infobox-blue mt0">
									<div class="infobox-icon">
										<i class="ace-icon fas fa-project-diagram"></i>
									</div>
									<div class="infobox-data">
										<span class="infobox-data-number"><?=$groupDetailAry[0]->id?></span>
										<div class="infobox-content">Group Account</div>
									</div>
								</div>
							
								<div class="buttonAre mt10">
									<a onClick="getgroupMemberOnlyList();" class="btn btn-primary"><i class="ace-icon fas fa-user-shield bigger-110"></i> Add Members</a>
								</div>
							</div>

							<div class="filterPageare">
								<input type="hidden" value="<?=$eID?>" class="filter_id"/>
							</div>

							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Member Since</th>
										<th>Status</th>
									</tr>
								</thead>
							</table>
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

	<!-- Modal: Manage Group Admin  -  Modal -->
	<div id="groupAdminMod" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Group Name: <strong><?=$gName?></strong></h4>
				</div>
				<form id="assignGroupMember">
					<input type="hidden" value="<?=$eID?>" name="groupAccount"/>
					<div class="modal-body">
						<select name="customers[]" class="selectpicker custData" title="Select Group Mambers from the list" data-live-search="true" multiple data-width="100%" data-size="5">									
								<?=$customerList?>                          
						</select>					
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
						<button type="submit" class="btn btn-sm btn-success"><span class="bigger-110"> <i class="ace-icon fas fa-check bigger-110"></i> Add Members</span></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Modal:  reason for suspending  -  Modal -->
	<div id="suspendReasonMod" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md">
			<!-- Modal content-->
			<div class="modal-content">
				<form id="suspendGroupMemberReason">
					<input type="hidden" value="<?=$eID?>" name="gid" />
					<input type="hidden" class="activeMemEml" />
					<input type="hidden" class="activeMemSms" />
					<input type="hidden" class="smsTypID" />
					<input type="hidden" class="emailTypID" />
					<input type="hidden" name="mid" />
					<input type="hidden" class="idBxTemp" />
					<input type="hidden" class="isActivateBoxTemp" />
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Suspend Member</h4>
					</div>
					<div class="modal-body">
						<label class="required">Mention the reason for suspending this customer from this group</label>
						<textarea name="comment" class="form-control" required></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
						<button type="submit" data-model='0' data-type='0' class="btn btn-sm btn-danger"> <i class="ace-icon fas fa-check bigger-110"></i> <span class="bigger-110 no-text-shadow"> Submit</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php include('includes/email_sms_template.php')?>
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		function filterRecord() {
			filterData = {
				"id": $( 'input.filter_id' ).val(),
			};
			ajaxPageTarget( 'data_table', 'groups', 'groups_data_lst' );
		}
		filterRecord();
	</script>
</body>

</html>