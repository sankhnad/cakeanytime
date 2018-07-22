<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Users List | POCHI Admin</title>
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
							Others
						</li>
						<li class="active"><a href="<?=base_url()?>others/manage_users">Manage Users</a></li>
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
								<div class="titleAre"><i class="far fa-id-card"></i> Manage Users</div>
								<div class="buttonAre">
									<a class="btn btn-primary" href="<?=base_url()?>others/manage_users/add"><i class="ace-icon fas fa-user-plus bigger-110"></i> Add New User</i></a>
								</div>
							</div>
							<div class="hr dotted hr-double"></div>

							<div class="filterPageare">
								<div class="filterPanL">
									<select class="selectpicker filter_role" title="Select Role" data-live-search="true" data-width="fit" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
										<option value="1">Super User</option>
										<option value="2">Administrator</option>
										<option value="3">Accountant</option>
									</select>
								</div>
								<div class="filterPanL">
									<select class="selectpicker filter_status" title="Select Status" data-live-search="true" data-width="fit" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
										<option value="2">Suspended</option>
									</select>
								</div>
								<div class="filterPanL" style="max-width: 20%;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="far fa-calendar-alt bigger-110"></i>
										</span>
										<input class="form-control filter_data" placeholder="Reg. Date Range" type="text" />
									</div>
								</div>
								<div class="filterPanL">
									<button type="button" title="Filter Record" onClick="filterRecord();" class="btn btn-warning btn-sm"><i class="fa fa-filter"></i> &nbsp;Filter</button>
								</div>
							</div>

							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Created On</th>
										<th>Role</th>										
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
		<?php include('includes/footer.php')?>
	</div>
	<!-- /.main-container -->

	<!-- Modal -->
	<div id="profileQuickView" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Quick View</h4>
				</div>
				<form class="form-horizontal" id="adminUpdatePas" role="form">
					<div class="modal-body">
						<div class="text-center"><img width="20%" class="qUAAvtar" src="" /></div>
						<table class="table table-bordered">
							<tbody>
								<tr class="qName">
									<th width="40%">Name</th>
									<td><span></span></td>
								</tr>
								<tr class="qUsername">
									<th>Username</th>
									<td><span></span></td>
								</tr>
								<tr class="qEmail">
									<th>Email</th>
									<td><span></span></td>
								</tr>
								<tr class="qPhone">
									<th>Phone</th>
									<td><span></span></td>
								</tr>								
								<tr class="qRole">
									<th>Role</th>
									<td><span></span></td>
								</tr>
								<tr class="qStatus">
									<th>Status</th>
									<td><span></span></td>
								</tr>
								<tr class="qCreated">
									<th>Created On</th>
									<td><span></span></td>
								</tr>
								<tr class="qLastLogin">
									<th>Last Login</th>
									<td><span></span></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
						<a target="_blank" href="" class="btn btn-sm btn-primary editModb"> <i class="ace-icon fas fa-pencil-alt bigger-110"></i> <span class="bigger-110"> Edit</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		ajaxPageTarget('data_table', 'others', 'users_lst' );
		function filterRecord() {
			filterData = {
				"filter_role": $( 'select.filter_role' ).val(),
				"filter_status": $( 'select.filter_status' ).val(),
				"filter_data": $( 'input.filter_data' ).val(),
			};
			ajaxPageTarget('data_table', 'others', 'users_lst' );
		}
		
		$('.filter_data').daterangepicker({
			'applyClass' : 'btn-sm btn-success',
			'cancelClass' : 'btn-sm btn-info',
			'autoUpdateInput':false,
			locale: {
				applyLabel: 'Apply',
				cancelLabel: 'Clear'
			}
		})
		.prev().on(ace.click_event, function(){
			$(this).next().focus();
		});
		$('.filter_data').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
		$('.filter_data').on('cancel.daterangepicker', function(ev, picker) {
		  $(this).val('');
		});
	</script>
	<style>
		.data_table td:first-child {
		  white-space: nowrap;
		}
	</style>
</body>

</html>