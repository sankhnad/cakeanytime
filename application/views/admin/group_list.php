<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Group List | POCHI Admin </title>
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
							<a href="<?=admin_url()?>group">Group</a>
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
								<div class="titleAre"><i class="fas fa-users"></i> Group List</div>
								<div class="buttonAre">
									<button data-toggle="modal" data-target="#groupAddEdit" class="btn btn-primary"><i class="ace-icon fas fa-plus"></i> Add Group</i></button>
								</div>
							</div>
							<div class="hr dotted hr-double"></div>
							<div class="filterPageare">
								<div class="filterPanL">
									<select class="selectpicker filter_status" title="Select Status" data-width="fit" multiple data-actions-box="true">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
								<div class="filterPanL">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="far fa-calendar-alt bigger-110"></i>
										</span>									
										<input class="form-control filter_date" placeholder="Created On" type="text"/>
									</div>
								</div>
								<div class="filterPanL">
									<button type="button" title="Filter Record" onClick="filterRecord();" class="btn btn-warning fxFilBtn btn-sm"><i class="fa fa-filter"></i> &nbsp;Filter</button>
									<button type="button" title="Filter Record" onClick="resetFilterRecord(1);" class="btn btn-grey fxFilBtn btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; Reset</button>
								</div>
							</div>
							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										  <th>Group Name</th>
										  <th>Number of Member</th>
										  <th>Created On</th>
										  <th>Status</th>
										  <th>Action</th>
										
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

		<!-- Modal:  Add Edit Group Modal  -  Modal -->
		<div id="groupAddEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <form id="editNewGroup">
      			<input type="hidden" name="cgid" />
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				  <h4 class="modal-title">Add New Group</h4>
				</div>
				<div class="modal-body">
				  <div class="form-group">
					<label>Group Name</label>
					<input type="text" name="name" class="form-control" placeholder="Enter Group Name">
				  </div>
				</div>
				
				<div class="modal-footer posR">
					<div class="groupSwitch">
					<label>Mark as a default group</label>
					<label class="switchS">
						<input name="default" value="1" class="switchS-input" type="checkbox">
						<span class="switchS-label" data-on="Yes" data-off="No"></span>
						<span class="switchS-handle"></span>
					</label>
					</div>
					 <button type="button" class="btn btn-inverse" data-dismiss="modal">Cancel</button>
					 <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
				</div>				
			  </form>
			</div>
		  </div>
		</div>
		<!-- /.Add Edit Group Modal  -->
	
		<!-- Modal:  reason for suspending  -  Modal -->
		<div id="suspendReasonMod" class="modal fade" role="dialog">
					<div class="modal-dialog modal-md">
						<!-- Modal content-->
						<div class="modal-content">
							<form id="suspendGroupMemberReason">
								<input type="hidden" name="groupID" />
								<input type="hidden" class="idBxTemp" />
								<input type="hidden" class="isActivateBoxTemp" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Suspend Group</h4>
								</div>
								<div class="modal-body">
									<label class="required">Mention the reason for inactive this group</label>
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
		<?php include('includes/footer.php')?>
	</div>
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		function filterRecord() {
			filterData = {
				"filter_date": $( 'input.filter_date' ).val(),
				"filter_status": $( 'select.filter_status' ).val(),
			};
			ajaxPageTarget('data_table', 'groups', 'groups_lst' );
		}
		filterRecord();
	</script>
</body>

</html>