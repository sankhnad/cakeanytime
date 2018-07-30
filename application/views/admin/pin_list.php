<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>PIN List | POCHI Admin </title>
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
							<a href="<?=admin_url()?>location">Location</a>
						</li>
						<li class="active">
							<a href="<?=admin_url()?>location/pin">PIN Code</a>
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
								<div class="titleAre"><i class="fas fa-users"></i> PIN Code List</div>
								<div class="buttonAre">
									<button data-toggle="modal" data-target="#locationAddEdit" class="btn btn-primary"><i class="ace-icon fas fa-plus"></i> Add PIN Code</i></button>
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
										<th>PIN Code</th>
										<th>City</th>
										<th>State</th>
										<th>Areas Inside</th>
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

		<!-- Modal:  Add Edit City Modal  -  Modal -->
		<div id="locationAddEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <form id="editNewPin">
				<input type="hidden" name="pin" />
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				  <h4 class="modal-title">Add New PIN Code</h4>
				</div>
				<div class="modal-body">
				  <div class="form-group">
					<label>State List</label>
					<select class="selectpicker" data-width="100%" name="sid" title="Select State" data-live-search="true" required>
                       <?php $statList = ''; foreach($stateAry as $stateData){
							$statList .= '<option value="'.encode($stateData->sid).'">'.$stateData->stateName.'</option>';
						}
						echo $statList;
						?>
					</select>
				  </div>
				  <div class="multiAddLocalCon"></div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-inverse" data-dismiss="modal">Cancel</button>
				  <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
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
			ajaxPageTarget('data_table', 'location', 'pin_list' );
		}
		filterRecord();
		addRemoveLocaInput(this, 'add', 'pin');
	</script>
</body>

</html>