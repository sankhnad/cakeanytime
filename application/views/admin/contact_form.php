<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/path.php');?>
	<title>Contact Us | Admin Portal</title>
	<?php include('includes/styles.php'); ?>
</head>
<body class="login-layout light-login">
	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="center contactFmrCnr">
						<img src="<?=$iURL_assets?>logo.png" height="80px" />
						<div>&copy; <strong>FIMCO</strong> <i>Inform, Advise, Execute</i></div>
					</div>
					<div class="space-6"></div>
					<div class="position-relative">
						<div id="login-box" class="login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h3 class="header blue center">
											Contact Us
											<div class="space-6"></div>
										</h3>											
									<div class="space-6"></div>
									<form id="contactUsMsgForm">
										<fieldset>
											<div class="row">
												<label class="col-md-6">
													
													<span class="block input-icon input-icon-right">
														<input maxlength="60" name="email" type="email" class="form-control validateEmail" placeholder="Email *" required  />
														<i class="ace-icon fas fa-at"></i>
													</span>
													<span class="emailErrorMsg">Email is not formatted properly</span>
												</label>
												<label class="col-md-6">
													<span class="block input-icon input-icon-right">
														<input maxlength="12" name="phone" type="text" class="form-control phoneOnly" placeholder="Phone *" required />
														<i class="ace-icon fas fa-phone"></i>
													</span>
												</label>
											</div>
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<input maxlength="200" name="subject" type="text" class="form-control" placeholder="Subject *" required />
													<i class="ace-icon fas fa-pencil-alt"></i>
												</span>
											</label>
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<textarea maxlength="500" style="height: 100px;" class="form-control" name="message" placeholder="Your Message *" required></textarea>
													<i class="ace-icon far fa-comment-alt"></i>
												</span>
											</label>
											<div class="space"></div>
											<div class="clearfix text-center">
												<button type="submit" class="width-35 btn btn-sm btn-primary">
													<i class="ace-icon fas fa-check"></i>
													<span class="bigger-110">Send Message</span>
												</button>												
											</div>
											<div class="space-4"></div>
										</fieldset>
									</form>
								</div>
							</div>
							<!-- /.widget-body -->
						</div>
						<?php if(!AID){?>
						<div class="boxNdHlpbox">
							<span>Want to access admin portal? <a href="<?=base_url()?>login">Login Now</a></span>
						</div>
						<?php }else{ ?>
						<div class="boxNdHlpbox">
							<span>Go to <a href="<?=base_url()?>">Dashboard</a></span>
						</div>
						<?php } ?>
					</div>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.main-content -->
	</div>
	<!-- /.main-container -->
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script>
		isEnableTimerCnt = true;;
	</script>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	
</body>
</html>