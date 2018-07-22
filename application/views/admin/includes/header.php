	<div id="preloader"> <span onClick="hideLoader()" class="hideLoaderTxt">Hide Loader</span> <img src="<?=$iURL_assets?>admin/images/preloader.gif" alt="" /> </div>
	  <div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left fixed" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		
			<div class="navbar-header pull-left">
				<a href="<?=admin_url()?>" class="navbarLogo">
					<img src="<?=$iURL_assets?>logo.png" />
				</a>
			</div>
			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">
					<li class="light-blue dropdown-modal">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="<?=$iURL_profile?>thumb/<?=$adminData[0]->avtar ? :'user.png'?>" alt="Photo" />
							<span class="user-info">
								<small>Welcome,</small>
								<?=$adminData[0]->fname?>
							</span>
							<i class="ace-icon fa fa-caret-down"></i>
						</a>
						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li><a href="<?=admin_url()?>profile"> <i class="ace-icon fa fa-user"></i> My Profile</a></li>
							<li><a href="javascript:;" data-toggle="modal" data-target="#changePassMod"><i class="ace-icon fas fa-key"></i> Update Password</a></li>
							<li class="divider"></li>
							<li>
								<a href="<?=admin_url()?>logout"><i class="ace-icon fa fa-power-off"></i> Logout</a>
							
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /.navbar-container -->
	</div>