<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Transaction Fees List | POCHI Admin
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
							<a class="active" href="<?=base_url()?>transaction_fees">Transaction Fees</a>
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
							</br>
							<div class="row">
								<div class="col-sm-12 pricing-box">
									<div class="widget-box widget-color-blue">
										<div class="widget-header">
											<h5 class="widget-title bigger lighter">Current Transaction Fees</h5>
										</div>
										<div class="widget-body">
											<div class="widget-main">
												<div class="row">
												<div class="dateStPr col-md-4">
													<i class="far fa-calendar-alt"></i> 
													<?=date('jS M Y | h:i A',strtotime($tranFee[0]->created_date));?>
												</div>
												<div class="price transFesTbl col-md-4">
													<span><i class="fas fa-dollar-sign"></i><?=$tranFee[0]->rate?></span>
													<small>/ transaction</small>
												</div>
												<div class="activStPr col-md-4">
													<i class="fas fa-circle"></i> Active Status
												</div>
												</div>
											</div>
											<div>
												<a href="javascript:;" data-toggle="modal" data-target="#addTransactionModal" class="btn btn-block btn-primary">
													<i class="ace-icon fas fa-edit bigger-110"></i>
													<span>Change Fees</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<hr>
							<div class="headPageA mt0">
								<div class="titleAre pt0"><i class="far fa-money-bill-alt"></i> Transaction fee history </div>
							</div>
							<div class="hr dotted hr-double"></div>
							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Transaction Fee</th>
										<th>Created On</th>
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


	<!-- Modal -  -  Modal -->
	<div id="addTransactionModal" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><span class="acnlblNm"></span> Set Transaction Fee</h4>
				</div>
				<form class="form-horizontal" id="addTransactionFee" role="form">
					<input type="hidden" name="rid" value="">
					<div class="modal-body">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th class="pass">Transaction Fee</th>
									<td>
										<input type="text" class="form-control numberOnly" autocomplete="off" name="rate" required placeholder="Add Transaction Fee">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
						<button type="submit" class="btn btn-sm btn-success"> <i class="ace-icon fas fa-save bigger-110"></i> <span class="bigger-110 no-text-shadow"><span class="acnlblNm"></span> Change Fee</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		ajaxPageTarget('data_table', 'manage_rates', 'transaction_fees_lst' );
	</script>
	<style>
		.data_table td:first-child {
		  white-space: nowrap;
		}
	</style>
</body>

</html>