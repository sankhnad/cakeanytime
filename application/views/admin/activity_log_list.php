<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/commonfile.php');?>
	<title>Activity Log | POCHI Admin </title>
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
							<a href="<?=base_url()?>others/manage_users">Others</a>
						</li>
						<li>
							<a href="<?=base_url()?>others/manage_users/activity-log/<?=$eId?>">Manage Users</a>
						</li>
						<li class="active">Activity Log</li>
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
								<div class="titleAre"><i class="fas fa-undo-alt"></i> Activity Log: <strong><?=$userInfoAry[0]->fname?> <?=$userInfoAry[0]->lname?></strong></div>
							</div>
							<div class="hr dotted hr-double"></div>

							<div class="filterPageare">
								<input type="hidden" class="filter_aid" value="<?=encode($userInfoAry[0]->aid)?>" />
								<div class="filterPanL" style="max-width: 20%;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="far fa-calendar-alt bigger-110"></i>
										</span>
										<input class="form-control filter_data" placeholder="Date Between" type="text" />
									</div>
								</div>
								<div class="filterPanL">
									<button type="button" title="Filter Record" onClick="filterRecord();" class="btn btn-warning btn-sm"><i class="fa fa-filter"></i> &nbsp;Filter</button>
								</div>
							</div>

							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Action</th>
										<th>Status</th>
										<th>IP Address</th>
										<th>Date Performed</th>
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

	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		filterData = {
			"filter_aid": $( 'input.filter_aid' ).val(),
		};
		ajaxPageTarget('data_table', 'others', 'activity_log_lst' );
		
		function filterRecord() {
			filterData = {
				"filter_aid": $( 'input.filter_aid' ).val(),
				"filter_data": $( 'input.filter_data' ).val(),
			};
			ajaxPageTarget('data_table', 'others', 'activity_log_lst' );
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