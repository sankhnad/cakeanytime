$(document).on("submit", ".register_customer", function (e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'login/register',
		dataType: 'json',
		type: 'POST',
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function (obj) {
			if (obj.status == 'user-error') {
				swal("Sorry!", "This username is not available, choose a different username.", "error");
			} else if (obj.status == 'email-error') {
				swal("Sorry!", "This email address is not available, choose a different email address.", "error");
			} else if (obj.status == 'success') {
				swal("Successfull !!", "Your account has been successfully created. An verification mail has been sent to your email and also please enter OTP here to verify your mobile", "success");
				$('.register_customer').remove();
				$('.confirmOTP_customer').show();
			}else{
				csrfError();
			}
			
		},
		error: function () {
			csrfError();
		}
	});
});

$(document).on("submit", ".login_customer", function (e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'login/check',
		dataType: 'json',
		type: 'POST',
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function (obj) {
			if (obj.status == 'error') {
				swal({
					title: 'Invalid Login',
					html: 'The email/username or password you entered is not valid',
					confirmButtonColor: '#FF9494',
					type: 'warning'
				});
			} else if (obj.status == 'pending') {
				swal({
					title: 'Pending Verification!!',
					text: 'Your account is not verified yet. Please verify your account first',
					confirmButtonColor: '#FF9494',
					type: 'warning'
				});
			}else if (obj.status == 'success') {
				var redictURL = window.location.hash.substring(1);
				redictURL = redictURL ? redictURL : base_url + 'admin';
				timerAlert('Login Successfully!', 'Successfully Logged in', redictURL);
			}else{
				csrfError();
			}
		},
		error: function () {
			csrfError();
		}
	});
});

function updateCitySelect(selfObj, id){
	var dataString = {
		id: id,
	};
	$.ajax({
		url: base_url + 'home/updateCitySelect',
		dataType: 'json',
		type: 'POST',
		data: dataString,
		beforeSend: function () {
			showLoader();
		},
		success: function (data) {
			timerAlert('Successful!!', 'You have selected '+$(selfObj).text(), 'reload');
		},
		error: function () {
			csrfError();
		}
	});
}
$('.viewAllCities').on('click',function(){
	$('.allCityList, .otdcityLbl').slideDown();
	$(this).remove();
	$('#changeCity .modal-body').animate({
		scrollTop: $('#popularDelCities').offset().top
	}, 2000);
});
function filterCity(element) {
	$('.allCityList, .otdcityLbl').slideDown();
	$('.viewAllCities').remove();
	var value = $(element).val();
	$(".allCityList li, .popularCityList li").each(function() {
		if ($(this).text().search(new RegExp(value, "i")) > -1) {
			$(this).show();
		} else {
			$(this).hide();
		}
	});
}

$(".numberOnly").keydown(function (e) {
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		(e.keyCode >= 35 && e.keyCode <= 40)) {
		return;
	}
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});

function goBack() {
	window.history.back();
}

function gotoPage(url) {
	if (url == 'reload') {
		location.reload();
	} else {
		window.location.href = url;
	}
}

function showLoader() {
	$('#preloader').show();
}

function hideLoader() {
	$('#preloader').hide();
}

$(document).ajaxStop(function () {
	processTooltip();
	$('.selectpicker').selectpicker('refresh');
	hideLoader()
});

var filterData = {};

function ajaxTbl(targeT, fn) {
	$('.' + targeT).DataTable({
		responsive: true,
		"bDestroy": true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + 'ajaxDataTable/' + fn,
			"type": 'POST',
			"data": {
				filterData,
			},
		},
	});
}

function ajaxPageTarget(targeT, page, fn) {
	$('.' + targeT).DataTable({
		responsive: true,
		"bDestroy": true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": base_url + page + '/' + fn,
			"type": 'POST',
			"data": {
				filterData
			},
		},
	});
}
function timerAlert(sub, msg, target) {
	swal({
		title: sub,
		text: msg,
		timer: 1000,
		onOpen: function () {
			swal.showLoading();
		}
	}).then(
		function () {},
		function (dismiss) {
			if (dismiss === 'timer') {
				if (target) {
					if (target == 'reload') {
						gotoPage('');
					} else {
						gotoPage(target);
					}
				}
			}
		}
	);
}

function csrfError() {
	swal("Oops!!", "Something went wrong please refresh your page.", "error");
	hideLoader();
}

function processTooltip() {
	$('.tooltip.fade').removeClass('in');
	$('[data-tooltip="tooltip"], [data-toggle="tooltip"]').tooltip({
		container: 'body',
		html: true
	});
}
$(document).ready(function(){

	//$(".sticky").sticky({topSpacing:0});
	
	
	if($('.productSlider').length > 0){
		var productSlider = $('.productSlider');
		productSlider.owlCarousel({
			items : 6,
			autoplay:true,
			loop:true,
			margin: 30,
			autoplayTimeout:5000,
			autoplayHoverPause:true,
			navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
			lazyLoad:true,
			dots: false,
			nav: true,
			responsive:{
				0:{
					items:2,
				},
				600:{
					items:3,
				},
				1000:{
					items:4,
				},
				1200:{
					items:6,
				}
			},
			animateOut: 'fadeOut'
		});
		$('.playProductSlide').on('click', function() {
			productSlider.trigger('play.owl.autoplay', [2000])
		});
		$('.stopProductSlide').on('click', function() {
			productSlider.trigger('stop.owl.autoplay')
		});
	}
	
	
	
	
	$("#testimonial-slider").owlCarousel({ 
		items : 3,
		autoplay:true,
		loop:true,
		margin: 10,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ["",""],
		lazyLoad:true,
		nav: true,
		dots: false,
		responsive:{
			0:{
				items:1,
			},
			600:{
				items:2,
			},
			1000:{
				items:3,
			},
			1200:{
				items:3,
			}
		},
		animateOut: 'fadeOut'       
	});

	var wow = new WOW({
		boxClass:     'animate',      // animated element css class (default is wow)
		animateClass: 'animated', 	// animation css class (default is animated)
		offset:       100,          // distance to the element when triggering the animation (default is 0)
		mobile:       false        // trigger animations on mobile devices (true is default)
	});

	wow.init();
});