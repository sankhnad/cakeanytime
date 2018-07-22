<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/path.php');?>
	<title>Reset Password | FIMCO | POCHI</title>
	<?php include('includes/styles.php'); ?>
</head>
<body class="login-layout light-login">
	<div id="preloader"> <img src="<?=$iURL_assets?>admin/images/preloader.gif" alt="" /> </div>
	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container">
						<div class="center logoLoginAra">
							<img src="<?=$iURL_assets?>logo.png" height="80px" />
							<div>&copy; <strong>FIMCO</strong> <i>Inform, Advise, Execute</i></div>
						</div>
						<div class="space-6"></div>
						<div class="position-relative">
							<div id="login-box" class="login-box visible widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h3 class="header blue center">
												<i class="ace-icon fa fa-key"></i>
												Validate Account
												<div class="space-6"></div>
											</h3>											
										<div class="space-6"></div>
										<form id="validateforgetPassword">
											<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input name="email" type="email" class="form-control" placeholder="Email" required />
														<i class="ace-icon fa fa-user"></i>
													</span>
												</label>
												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input name="token" type="text" class="form-control" placeholder="OTP" required autocomplete="off" />
														<i class="ace-icon fa fa-lock"></i>
													</span>
												</label>
												
												<div class="space"></div>
												<div class="clearfix">
													<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
													    <span class="bigger-110">Next &nbsp;</span>
														<i class="ace-icon fa fa-arrow-right"></i>
													</button>												
												</div>
												<div class="space-4"></div>
											</fieldset>
										</form>
									</div>
									<!-- /.widget-main -->
									<div class="toolbar clearfix">
										<div>
											<a href="<?=base_url()?>login" class="forgot-password-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												Back to login page
											</a>
										</div>
									</div>
								</div>
								<!-- /.widget-body -->
							</div>
							<!-- /.login-box -->
							<div id="resetPasswordFinal" class="forgot-box widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Reset Password
											</h4>
									
										<div class="space-6"></div>
										<p>Enter your email and to receive instructions</p>
										<form id="updateFinalPass">
											<input type="hidden" name="token" />
											<input type="hidden" name="val" />
											<input type="hidden" name="id" />
											<fieldset>
												<label class="block clearfix posR">
													<span class="block input-icon input-icon-right">
														<input onBlur="$('.passValida').hide();" onKeyUp="validatePassword(this.value, this)" type="password" class="form-control" name="nPassword" placeholder="Enter New Password" />
														<i class="ace-icon fa fa-lock"></i>
													</span>
													<span class="passValida"></span>
												</label>
												<label class="block clearfix posR">
													<span class="block input-icon input-icon-right">
														<input onBlur="$('.passValida').hide();" onKeyUp="validatePassword(this.value, this)" type="password" class="form-control" name="cPassword" placeholder="Confirm Password" />
														<i class="ace-icon fa fa-lock"></i>
													</span>
													<span class="passValida"></span>
												</label>											
												<div class="clearfix">
													<button type="submit" class="pull-right btn btn-sm btn-danger">
														<i class="ace-icon fa fa-lightbulb-o"></i>
														<span class="bigger-110">Update Password</span>
													</button>
												</div>
											</fieldset>
										</form>
									</div>
									<!-- /.widget-main -->
									<div class="toolbar center">
										<a href="#" data-target="#login-box" class="back-to-login-link">
											<i class="ace-icon fa fa-arrow-left"></i> &nbsp;
											Back to validation panel
										</a>									
									</div>
								</div>
								<!-- /.widget-body -->
							</div>
							<!-- /.forgot-box -->
							
						</div>
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
	<!-- inline scripts related to this page -->
	<script type="text/javascript">
		jQuery( function ( $ ) {
			$( document ).on( 'click', '.toolbar a[data-target]', function ( e ) {
				e.preventDefault();
				var target = $( this ).data( 'target' );
				$( '.widget-box.visible' ).removeClass( 'visible' ); //hide others
				$( target ).addClass( 'visible' ); //show target
			} );
		} );
	</script>
</body>
</html>