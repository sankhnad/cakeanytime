		<?php
		if(!isset($activeMenu)){
			$activeMenu = '';
		}
		if(!isset($activeSubMenu)){
			$activeSubMenu = '';
		}
		?>
		<script type="text/javascript">
			try {
				ace.settings.loadState( 'main-container' )
			} catch ( e ) {}
		</script>
		<div id="sidebar" class="sidebar responsive ace-save-state">
			<script type="text/javascript">
				try {
					ace.settings.loadState( 'sidebar' )
				} catch ( e ) {}
			</script>
			<div class="sidebar-shortcuts" id="sidebar-shortcuts">
				<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
					<button onClick="gotoPage('<?=admin_url()?>contact/message')" class="btn btn-success" data-tooltip="tooltip" title="Support Message"> <i class="ace-icon fas fa-bell"></i> </button>
					<button data-toggle="modal" data-target="#changePassMod" class="btn btn-info" data-tooltip="tooltip" title="Change Password"> <i class="ace-icon ace-icon fas fa-key"></i> </button>
					<button onClick="gotoPage('<?=admin_url()?>profile')" class="btn btn-warning" data-tooltip="tooltip" title="Settings"> <i class="ace-icon fa fa-cogs"></i> </button>
					<button onClick="gotoPage('<?=admin_url()?>logout')" class="btn btn-danger" data-tooltip="tooltip" title="Logout"> <i class="ace-icon fa fa-power-off"></i> </button>
				</div>
				<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
					<span class="btn btn-success"></span>
					<span class="btn btn-info"></span>
					<span class="btn btn-warning"></span>
					<span class="btn btn-danger"></span>
				</div>
			</div>
			<!-- /.sidebar-shortcuts -->
			<ul class="nav nav-list">
				<li class="<?=$activeMenu == 'dashboard' ? 'active':''?>">
					<a href="<?=admin_url();?>">
							<i class="menu-icon fas fa-tachometer-alt"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
					<b class="arrow"></b>
				</li>
				
				<li class="<?=$activeMenu == 'customers' ? 'active':''?>">
					<a href="<?=admin_url();?>customers">
							<i class="menu-icon fas fa-users"></i>
							<span class="menu-text"> Customers </span>
						</a>
					<b class="arrow"></b>
				</li>
				
				<li class="<?=$activeMenu == 'vendors' ? 'active':''?>">
					<a href="<?=admin_url()?>vendors">
						<i class="menu-icon fas fa-store"></i>
						<span class="menu-text"> Vendors </span>
					</a>
					<b class="arrow"></b>
				</li>
				
				<li class="<?=$activeMenu == 'store' ? 'active open':''?>">
					<a href="javascript;:" class="dropdown-toggle"> <i class="menu-icon fas fa-shopping-cart"></i>
						<span class="menu-text"> Manage Store</span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<li class="<?=$activeSubMenu == 'category' ? 'active':''?>">
							<a href="<?=admin_url()?>category"><i class="menu-icon fa fa-caret-right"></i>Product Category</a>
							<b class="arrow"></b>
						</li>
						<li class="<?=$activeSubMenu == 'product' ? 'active':''?>">
							<a href="<?=admin_url()?>customers"><i class="menu-icon fa fa-caret-right"></i>Product List</a>
							<b class="arrow"></b>
						</li>
					</ul>
				</li>
				
				<li class="<?=$activeMenu == 'location' ? 'active open':''?>">
					<a href="javascript;:" class="dropdown-toggle"> <i class="menu-icon fas fa-map-marker-alt"></i>
						<span class="menu-text"> Location</span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<li class="<?=$activeSubMenu == 'state' ? 'active':''?>">
							<a href="<?=admin_url()?>location/state"><i class="menu-icon fa fa-caret-right"></i> State</a>
							<b class="arrow"></b>
						</li>
						<li class="<?=$activeSubMenu == 'city' ? 'active':''?>">
							<a href="<?=admin_url()?>location/city"><i class="menu-icon fa fa-caret-right"></i> City</a>
							<b class="arrow"></b>
						</li>
						<li class="<?=$activeSubMenu == 'pin' ? 'active':''?>">
							<a href="<?=admin_url()?>location/pin"><i class="menu-icon fa fa-caret-right"></i> PIN Code</a>
							<b class="arrow"></b>
						</li>
						<li class="<?=$activeSubMenu == 'area' ? 'active':''?>">
							<a href="<?=admin_url()?>location/area"><i class="menu-icon fa fa-caret-right"></i> Area</a>
							<b class="arrow"></b>
						</li>
					</ul>
				</li>
				
				<li class="<?=$activeMenu == 'groups' ? 'active':''?>">
					<a href="<?=admin_url()?>groups">
						<i class="menu-icon fas fa-list"></i>
						<span class="menu-text"> Groups </span>
					</a>
					<b class="arrow"></b>
				</li>				
				
				<li class="<?=$activeMenu == 'fees_rate' ? 'active open':''?>">
					<a href="javascript;:" class="dropdown-toggle"> <i class="menu-icon fas fa-percent"></i>
						<span class="menu-text"> Fees and Rate</span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<li class="<?=$activeSubMenu == 'management_fees' ? 'active':''?>">
							<a href="<?=admin_url()?>management_fees"><i class="menu-icon fa fa-caret-right"></i> Management Fees</a>
							<b class="arrow"></b>
						</li>
						
						<li class="<?=$activeSubMenu == 'transaction_fees' ? 'active':''?>">
							<a href="<?=admin_url()?>transaction_fees"><i class="menu-icon fa fa-caret-right"></i> Transaction Fees</a>
							<b class="arrow"></b>
						</li>
						
						<li class="<?=$activeSubMenu == 'manage_rates' ? 'active':''?>">
							<a href="<?=admin_url()?>manage_rates"><i class="menu-icon fa fa-caret-right"></i> Manage Rates</a>
							<b class="arrow"></b>
						</li>
						
					</ul>
				</li>				
				
				<li class="<?=$activeMenu == 'reports' ? 'active':''?>">
					<a href="<?=admin_url()?>reports">
						<i class="menu-icon fas fa-chart-line"></i>
						<span class="menu-text"> Reports </span>
					</a>
					<b class="arrow"></b>
				</li>
				
				<li class="<?=$activeMenu == 'others' ? 'active open':''?>">
					<a href="javascript;:" class="dropdown-toggle"> <i class="menu-icon fab fa-nintendo-switch"></i>
						<span class="menu-text"> Others</span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<li class="<?=$activeSubMenu == 'manage_coupons' ? 'active':''?>">
								<a href="<?=admin_url()?>coupons"><i class="menu-icon fa fa-caret-right"></i> Manage Coupons</a>
								<b class="arrow"></b>
						</li>
						<li class="<?=$activeSubMenu == 'manage_users' ? 'active':''?>">
							<a href="<?=admin_url()?>others/manage_users"><i class="menu-icon fa fa-caret-right"></i> Manage Users</a>
							<b class="arrow"></b>
						</li>
						<li class="<?=$activeSubMenu == 'templates' ? 'active':''?>">
							<a href="<?=admin_url()?>others/templates"><i class="menu-icon fa fa-caret-right"></i> SMS/Email Template</a>
							<b class="arrow"></b>
						</li>
					</ul>
				</li>
				
				<li class="<?=$activeMenu == 'settings' ? 'active open':''?>">
					<a href="javascript;:" class="dropdown-toggle"> <i class="menu-icon fas fa-cogs"></i>
						<span class="menu-text"> Settings</span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<li class="<?=$activeSubMenu == 'profile' ? 'active':''?>">
							<a href="<?=admin_url()?>profile"><i class="menu-icon fa fa-caret-right"></i> Manage Profile</a>
							<b class="arrow"></b>
						</li>
						<li class="<?=$activeSubMenu == 'logout' ? 'active':''?>">
							<a href="<?=base_url()?>logout"><i class="menu-icon fa fa-caret-right"></i> Logout</a>
							<b class="arrow"></b>
						</li>
					</ul>
				</li>
				
				<li class="<?=$activeMenu == 'contact_msg' ? 'active':''?>">
					<a href="<?=admin_url()?>contact/message">
						<i class="menu-icon far fa-life-ring"></i>
						<span class="menu-text"> Support 
							<span data-newmsgcnt="<?=$ispendingContact?>" class="badge <?=$ispendingContact ? '':'hide_now'?> badge-transparent newmsgcnt tooltip-error" title="<?=$ispendingContact?> New Message">
								<i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i>
							</span>
						</span>
						
					</a>
					<b class="arrow"></b>
				</li>
			</ul>
			<!-- /.nav-list -->
			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
				<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
			</div>
		</div>