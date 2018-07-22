<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Rate List | POCHI Admin
	</title>
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
						<li>Fees and Rate</li>
						<li class="active">
							<a class="active" href="<?=base_url()?>manage_rates">Manage Rates</a>
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
								<div class="titleAre"><i class="far fa-money-bill-alt"></i> Manage Rates</div>
								<?php
									if($rateMonth){
								?>
								<div class="buttonAre">
									<button type="button" onClick="editAddManageRate('','<?=$rateMonth?>')" class="btn btn-primary"><i class="ace-icon fas fa-plus bigger-110"></i> Add Rate</i></button>
								</div>
								<?php } ?>
							</div>
							<div class="hr dotted hr-double"></div>

							<div class="filterPageare">
								<div class="filterPanL" style="max-width: 30%;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="far fa-calendar-alt bigger-110"></i>
										</span>
										<input class="form-control filter_date" placeholder="Rate Created Date Range" type="text" />
									</div>
								</div>
								<div class="filterPanL">
									<button type="button" title="Filter Record" onClick="filterRecord();" class="btn btn-warning btn-sm"><i class="fa fa-filter"></i> &nbsp;Filter</button>
								</div>
							</div>

							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Rate</th>
										<th>Month / Year</th>
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
	
	
	<!-- Modal -  -  Modal -->
	<div id="addRateModal" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><span class="acnlblNm"></span> Rate</h4>
				</div>
				<form class="form-horizontal" id="editAddManageRate" role="form">
					<input type="hidden" name="rid" value="">
					<div class="modal-body">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th colspan="2" class="pass">For the month of <span class="red mntlblNm"></span></th>
								</tr>
								<tr>
									<th class="pass">Rate</th>
									<td>
										<input type="text" class="form-control numberOnly" autocomplete="off" name="rate" required placeholder="Add Rate">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
						<button type="submit" class="btn btn-sm btn-success"> <i class="ace-icon fas fa-save bigger-110"></i> <span class="bigger-110 no-text-shadow"><span class="acnlblNm"></span> Rate</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		ajaxPageTarget('data_table', 'manage_rates', 'rate_lst' );
		function filterRecord() {
			filterData = {
				"filter_isRead": $( 'select.filter_isRead' ).val(),
				"filter_date": $( 'input.filter_date' ).val(),
			};
			ajaxPageTarget('data_table', 'manage_rates', 'rate_lst' );
		}
		
		$('.filter_date').daterangepicker({
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
		$('.filter_date').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
		$('.filter_date').on('cancel.daterangepicker', function(ev, picker) {
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