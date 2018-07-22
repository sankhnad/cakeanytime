<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Coupons List | POCHI Admin</title>
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
							<a href="<?=admin_url()?>coupon">Coupon</a>
						</li>
						<li class="active">Coupon List</li>
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
								<div class="titleAre"><i class="far fa-id-card"></i> Coupon List</div>
								<div class="buttonAre">
									<a class="btn btn-primary" href="<?=admin_url()?>coupons/add"><i class="ace-icon fas fa-user-plus bigger-110"></i> Add New Coupon</i></a>
								</div>
							</div>
							<div class="hr dotted hr-double"></div>

							<div class="filterPageare">
								
								<div class="filterPanL">
									<select class="selectpicker filter_status" title="Select Status" data-live-search="true" data-width="fit" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
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
									  <th>Coupon Name</th>
									  <th>Code</th>
									  <th>Discount</th>
									  <th>Date Start</th>
									  <th>Date End</th>
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
								<tr class="qEmail">
									<th>Email</th>
									<td><span></span></td>
								</tr>
								<tr class="qPhone">
									<th>Phone</th>
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
		function filterRecord() {
			filterData = {
				"filter_date": $( 'input.filter_date' ).val(),
				"filter_status": $( 'select.filter_status' ).val(),
			};
			ajaxPageTarget('data_table', 'coupons', 'coupon_lst' );
		}
		filterRecord();
	
	
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