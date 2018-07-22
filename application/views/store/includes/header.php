<!--Start: Login Modal Box -->
<div class="modal fade" id="registerLoginMod" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content login-form">
			<div class="modal-body">
				<section class="login-sec padding-top-30 padding-bottom-30">
					<div class="row">
						<div class="col-md-5 borderRignReg">
							<h5>Login Your Account</h5>
							<form class="login_customer">
								<ul class="row">
									<li class="col-sm-12">
										<label>Email / Username
											<input type="text" class="form-control" name="email" placeholder="">
										</label>
									</li>
									<li class="col-sm-12">
										<label>Password
											<input type="password" class="form-control" name="password" placeholder="">
										</label>
									</li>
									<li class="col-sm-6">
										<div class="checkbox checkbox-primary">
											<input id="cate1" name="remember" class="styled" type="checkbox">
											<label for="cate1"> Keep me logged in </label>
										</div>
									</li>
									
									<li class="col-sm-6"> <a href="#" class="forget">Forgot your password?</a> </li>
									
									<li class="col-sm-12 btnSubmLon">
										<button type="submit" class="btn-round"><i class="fas fa-key"></i> &nbsp; Login</button>
									</li>
									
									<li class="col-sm-12 socialLognBt">
										<a class="facebookBtnLogin" target="_blank" href="#">
											Facebook Login
										</a>
										<a class="googleBtnLogin" target="_blank" href="#">
											Google Login
										</a>
									</li>
								</ul>
							</form>
						</div>
						<div class="col-md-7">
							<h5>Don’t have an Account? Register now</h5>
							<form class="register_customer">
								<ul class="row">
									<li class="col-sm-6">
										<label>First Name
											<input type="text" class="form-control" name="fname" placeholder="">
										</label>
									</li>
									<li class="col-sm-6">
										<label>Last Name
											<input type="text" class="form-control" name="lname" placeholder="">
										</label>
									</li>
									<li class="col-sm-12">
										<label>Email
											<input type="email" class="form-control" name="email" placeholder="">
										</label>
									</li>
									<li class="col-sm-6">
										<label>Mobile
											<input type="text" class="form-control" name="mobile" placeholder="">
										</label>
									</li>
									
									<li class="col-sm-6">
										<label>Username
											<input type="text" class="form-control" name="username" placeholder="">
										</label>
									</li>
									<li class="col-sm-6">
										<label>Password
											<input type="password" class="form-control" name="password" placeholder="">
										</label>
									</li>
									<li class="col-sm-6">
										<label>Confirm Password
											<input type="password" class="form-control" placeholder="">
										</label>
									</li>
									<li class="col-sm-12 text-left">
										<button type="submit" class="btn-round"><i class="fas fa-lock"></i> &nbsp; Register</button>
									</li>
								</ul>
							</form>
							
							<form class="confirmOTP_customer padding-top-100">
								<ul class="row">
									<li class="col-sm-6">
										<label>Mobile Number
											<input type="mobile" value="" disabled class="form-control">
										</label>
									</li>
									<li class="col-sm-6">
										<label>OTP
											<input type="text" class="form-control" name="otp" placeholder="Enter Your TOP">
										</label>
									</li>
									<li class="col-sm-12 text-center">
										<button type="submit" class="btn-round btn-light"><i class="far fa-edit"></i> &nbsp; Change Number</button>
										<button type="button" class="btn-round"><i class="fas fa-mobile-alt"></i> &nbsp; Confirm OTP</button>
									</li>
								</ul>
							</form>
							
							
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
<!--End: Login Modal Box -->

<!--Start: Change City Modal Box -->
<div class="modal fade" <?=CITY ? '': 'data-backdrop="static" data-keyboard="false"' ?> id="changeCity" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content login-form">
			<div class="modal-body">
				<div id="delCities" class="city-box text-center">
					<div class="row">
						<div class="delCities-title">
							<h4>In which city you would like delivery?</h4>
							<p> Delivering in
								<?=count($cityListsObj)?>cities of India</p>
						</div>
						<header class="search-box ">
							<div class="search-cate">
								<input type="search" onKeyUp="filterCity(this)" placeholder="Search for your city...">
								<button class="submit" type="submit"><i class="icon-magnifier"></i></button>
							</div>
						</header>

						<div class="col-sm-12" id="popularDelCities">
							<div class="row">
								<div class="col-sm-12 mb15">
									<h6> Popular Cities</h6>
								</div>
								<ul class="popularCityList">
									<li><img src="<?=$iURL_storeAssts?>images/icons/mumbai.png"/> Mumbai</li>
									<li><img src="<?=$iURL_storeAssts?>images/icons/mumbai.png"/> <span>NCR</span>
									</li>
									<li><img src="<?=$iURL_storeAssts?>images/icons/mumbai.png"/> <span>Bengaluru</span>
									</li>
									<li><img src="<?=$iURL_storeAssts?>images/icons/mumbai.png"/> <span>Hyderabad</span>
									</li>
									<li><img src="<?=$iURL_storeAssts?>images/icons/mumbai.png"/> <span>Chennai</span>
									</li>
									<li><img src="<?=$iURL_storeAssts?>images/icons/mumbai.png"/> <span>Pune</span>
									</li>
								</ul>
							</div>
						</div>
						<a href="javascript:;" class="viewAllCities">View All Cities</a>
						<span class="otdcityLbl">Other Cities</span>
						<ul class="allCityList mp15">
							<?php foreach($cityListsObj as $cityLists){
								echo '<li onClick="updateCitySelect(this, \''.encode($cityLists->fld_cid).'\')">'.$cityLists->fld_cityName.'</li>';
							}?>
						</ul>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End: Change City Modal Box -->

<!-- Start: Top bar -->
<div class="top-bar">
	<div class="container">
		<p>Welcome to SmartTech center!</p>
		<div class="right-sec">
			<ul>
				<li><a href="javascript:;" data-toggle="modal" data-target="#registerLoginMod">Login/Register </a>
				</li>
				<li>
					<select class="selectpicker">
						<option> &nbsp;Hi, Ankit &nbsp; </option>
						<option>My Profile</option>
						<option>My Address book</option>
						<option>My Reminders</option>

						<option>My Orders </option>
						<option>My Tickets</option>
						<option>Change Password </option>
						<option>Sign Out </option>
					</select>
				</li>
			</ul>
			<div class="social-top">
				<a href="#."><i class="fas fa-facebook"></i></a>
				<a href="#."><i class="fas fa-twitter"></i></a>
				<a href="#."><i class="fas fa-linkedin"></i></a>
				<a href="#."><i class="fas fa-dribbble"></i></a>
				<a href="#."><i class="fas fa-pinterest"></i></a>
			</div>
		</div>
	</div>
</div>
<!-- End: Top bar -->

<!-- Start: Header -->
<header>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-4 col-sm-12 col-md-2 col-lg-3">
				<div class="logo"> <a href="<?=base_url()?>"><img src="<?=$iURL_storeAssts?>images/logo.png" alt="" ></a> </div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 hidden-xs">
				<div class="search-cate">
					<input type="search" placeholder="Search entire store here...">
					<button class="submit" type="submit"><i class="icon-magnifier"></i></button>
				</div>
			</div>

			<div class="col-xs-8 col-sm-6 col-md-6 col-lg-5">
				<!-- Cart Part -->
				<ul class="nav navbar-right cart-pop">
					<li>
						<i class="fa fa-street-view"></i>
						<strong>Delivery City</strong> <br>
						<span>
							<?=CITY_NAME?><small><a href="javascript:;" data-toggle="modal" data-target="#changeCity">change</a></small>
						</span>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="itm-cont">3</span> 
                            <i class="flaticon-shopping-bag"></i> 
                            <strong>My Cart</strong> <br>
                            <span>3 item(s) - $500</span>
                        </a>
						<ul class="dropdown-menu">
							<li>
								<div class="media-left"><a href="#" class="thumb"><img src="<?=$iURL_storeAssts?>images/item-img-1-1.jpg" class="img-responsive"></a>
								</div>
								<div class="media-body"><a href="#" class="tittle">Funda Para Ebook 7" 128GB full HD</a> <span>250 x 1</span>
								</div>
							</li>
							<li>
								<div class="media-left"><a href="#" class="thumb"><img src="<?=$iURL_storeAssts?>images/item-img-1-2.jpg" class="img-responsive"></a>
								</div>
								<div class="media-body"><a href="#" class="tittle">Funda Para Ebook 7" full HD</a> <span>250 x 1</span> </div>
							</li>
							<li class="btn-cart"><a href="checkout.php" class="btn-round">View Cart</a> </li>
						</ul>
					</li>
				</ul>
			</div>

		</div>
	</div>

	<!-- Nav -->
	<nav class="navbar ownmenu">
		<div class="container-fluid">

			<!-- Categories -->
			<div class="cate-lst"> <a data-toggle="collapse" class="cate-style" href="#cater"><i class="fa fa-list-ul"></i> Our Categories </a>
				<div class="cate-bar-in">
					<div id="cater" class="collapse">
						<ul>
							<li class="sub-menu"><a href="#."> Cakes By Type</a>
								<ul>
									<li><a href="#."> Delicious Cakes</a>
									</li>
									<li><a href="#."> Anniversary Cakes</a>
									</li>
									<li><a href="#."> Photo Cakes</a>
									</li>
									<li><a href="#."> Heart-Shape Cakes</a>
									</li>
									<li><a href="#."> 2-3 Tier Cakes</a>
									</li>
									<li><a href="#."> Premium cakes</a>
									</li>
									<li><a href="#."> Designer Cakes</a>
									</li>
									<li><a href="#."> Kids Cakes</a>
									</li>
								</ul>
							</li>
							<li class="sub-menu"><a href="#.">Cakes By Flavour </a>
								<ul>
									<li><a href="#."> Black Forest Cakes</a>
									</li>
									<li><a href="#."> Butterscotch Cakes</a>
									</li>
									<li><a href="#."> Chocolate Cakes</a>
									</li>
									<li><a href="#."> Fruit Cakes</a>
									</li>
									<li><a href="#."> Pineapple Cakes</a>
									</li>
									<li><a href="#."> Red Velvet Cakes</a>
									</li>
									<li><a href="#."> Coffee Cakes</a>
									</li>
									<li><a href="#."> Strawberry Cakes</a>
									</li>
									<li><a href="#."> Vanilla Cakes</a>
									</li>
								</ul>
							</li>
							<li class="sub-menu"><a href="#."> Occasion Special</a>
								<ul>
									<li><a href="#."> Valentine Day</a>
									</li>
									<li><a href="#."> Rose Day</a>
									</li>
									<li><a href="#."> New Year</a>
									</li>
									<li><a href="#."> Techers Day</a>
									</li>
									<li><a href="#."> Chritsmas Cakes</a>
									</li>
									<li><a href="#."> Anniversary Cakes</a>
									</li>
									<li><a href="#."> Birthday Cakes</a>
									</li>
								</ul>
							</li>
							<li class="sub-menu"><a href="#.">Festival special</a>
								<ul>
									<li><a href="#."> Holi</a>
									</li>
									<li><a href="#."> Diwali</a>
									</li>
									<li><a href="#."> 26 January</a>
									</li>
									<li><a href="#."> 15 August</a>
									</li>
								</ul>
							</li>
							<li><a href="#."> FLowers</a>
							</li>
							<li><a href="#."> Combos</a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="navbar-header"><button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-open-btn" aria-expanded="false"> <span><i class="fa fa-navicon"></i></span> </button>
			</div>

			<!-- NAV -->
			<div class="collapse navbar-collapse" id="nav-open-btn">
				<ul class="nav">
					<li class=" active">
						<a href="./">
							<p><img src="<?=$iURL_storeAssts?>images/icons/birthday-cake.png">
							</p>Cakes</a>
					</li>
					<!-- <li class="dropdown"> <a href="index.html" class="dropdown-toggle" data-toggle="dropdown">Pages </a>
                        <ul class="dropdown-menu multi-level animated-2s fadeInUpHalf">
                            <li><a href="#"> About </a></li>
                            <li><a href="#"> Login Form </a></li>
                            <li><a href="#"> Products 3 Columns </a></li>
                        </ul>
                    </li> -->
					<li>
						<a href="shop.php">
							<p><img src="<?=$iURL_storeAssts?>images/icons/bunch-of-flowers.png">
							</p>Flowers </a>
					</li>
					<li>
						<a href="#">
							<p><img src="<?=$iURL_storeAssts?>images/icons/combo.png">
							</p>Combo </a>
					</li>
					<li>
						<a href="#">
							<p><img src="<?=$iURL_storeAssts?>images/icons/birthday.png">
							</p>Birthday</a>
					</li>
					<li>
						<a href="#">
							<p><img src="<?=$iURL_storeAssts?>images/icons/wedding-rings.png">
							</p>Anniversary </a>
					</li>
					<li>
						<a href="#">
							<p><img src="<?=$iURL_storeAssts?>images/icons/love.png">
							</p>Gifts </a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
<!-- End: Header -->