
		<!-- <section class="wishlist_section signup_section"> -->
		<section class="wishlist_section signup_section">
			<div class="container">
				<div class="row">
					<form method="POST" action="<?php echo base_url('site/newsSubscription'); ?>">		
					<div class="col-md-5 col-sm-5 col-xs-12">	
						<h4 class="full-pay gold-txt"><span class="sgn_fr"><?php echo $this->lang->line('signup_for'); ?></span><br><span class="sb_dlx"><?php echo $settings['site_name'].' '.$this->lang->line('news'); ?></span></h4>
						<p class="email_text"><?php echo $this->lang->line('enter_your_email_address_to_get_news_and_offer_from_space_wallet'); ?></p>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-12">
						<div class="row email_input_row">
							<div class="col-md-7 col-sm-12 col-xs-6 nwsletterBox">
								<div class="form-group city_form">				
									<input type="email" id="email_add" placeholder="<?php echo $this->lang->line('enter_your_email_address'); ?>" name="user_email" class="form-control" autocomplete="off">					
								</div>
								<?php if($this->session->has_userdata('message')) { ?>
								<div class="form_error" style="color: #d11a1a;font-size: 16.33px;margin: -12px auto;">
									<?php echo $this->lang->line($this->session->userdata('message')); $this->session->unset_userdata('message'); ?>
								</div>
								<?php } ?>
							</div>
							<div class="col-md-5 col-sm-12 col-xs-6 go_btn_col nwsletterBox">
								<button id="btn-subscribe-news" type="submit"><a href="javascript:void(0);" class="go_online_shop Rettangolo_2 sign_now btn_hover" onclick="subscribeNews()"><?php echo $this->lang->line('sign_now'); ?></a></button>
							</div>	
						</div>	
					</div>	
					</form>
				</div>		
			</div>		
		</section>

		<!--footer-->
		<div class="container footer_container">
			<footer>
				<div class="row">
					<div class="col-md-2 col-sm-2 sm1 col-xs-6">
				<ul class="footer_menu">
					<li><a href="<?php echo base_url('page/privacy_statement'); ?>"><?php echo $this->lang->line('privacy_statement'); ?></a></li>
					<li><a href="<?php echo base_url('page/terms_of_use'); ?>"><?php echo $this->lang->line('terms_of_use'); ?></a></li>
					<li><a href="<?php echo base_url('page/imprint'); ?>"><?php echo $this->lang->line('imprint'); ?></a></li>
					<li><a href="<?php echo base_url('page/cancellation_terms'); ?>"><?php echo $this->lang->line('cancellation_terms'); ?></a></li>					
				</ul>
			</div>
			<div class="col-md-2 col-sm-2 sm1 col-xs-6 divider_col">
				<ul class="footer_menu">
					


					<li><a href="<?php echo base_url('page/faq'); ?>"><?php echo $this->lang->line('faq'); ?></a></li>
					<!-- <li><a href="<?php //echo base_url('page/blog'); ?>"><?php echo $this->lang->line('blog'); ?></a></li> -->
						<li><a href="<?php echo base_url('page/contactUs'); ?>"><?php echo $this->lang->line('contact_us'); ?></a></li>
					<!-- <li class="abt_mn"><a href="<?php echo base_url('page/about_us'); ?>"><?php echo $this->lang->line('about_us'); ?></a></li> -->
					<!-- <li><a href="<?php echo base_url('page/how_it_works'); ?>"><?php echo $this->lang->line('how_it_works'); ?></a></li> -->
					<!-- <li><a href="<?php echo base_url('page/feedback'); ?>"><?php echo $this->lang->line('feedback'); ?></a></li> -->
					
				</ul>
				<span class="dotted_line_bottom"></span>
			</div>
					<div class="col-md-5 col-sm-5 sm3 social_links hiddenSL">
					<hr class="dwnld_hr hidden-sm hidden-lg hidden-md">
						<h4 class="apptxt">Download <?php echo $settings['site_name']; ?> app</h4>
						<img src="<?php echo base_url('images/ios.png'); ?>" alt="<?php echo $this->lang->line('apple_app_store_logo')?>" class="ios">
						<img src="<?php echo base_url('images/android.png'); ?>" alt="<?php echo $this->lang->line('google_play_store_logo')?>" class="android">
						<hr class="dwnld_hr hidden-sm hidden-lg hidden-md btm_hr">
					</div>
	
					<div class="col-md-5 col-sm-5 sm4 social_links col-xs-12">
						<ul class="right_UL social_ul" id="bs-collapse-1">
							<li><span class="langlbl"><?php echo strtoupper($this->lang->line('select_your_country')); ?></span></li>
							
							<li class="dropdown">
								<span class="select_lang dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('site_country_abbr'); ?></span>
								<ul class="dropdown-menu" aria-labelledby="about-us">
								<?php 
									$countries = $this->country_model->get_active_countries_list();						
									if(!empty($countries)):
										foreach ($countries as $country):
											if($country['country_abbr'] != $this->session->userdata('site_country_abbr')):
								?>
									<li><a onclick="switchCountry('<?php echo $country['country_abbr']; ?>')" href="javascript:void(0);"><?php echo $country['country_abbr']; ?></a></li>
								<?php 		endif;
										endforeach;
									endif; 
								?>
								</ul>								
							</li>

							<li class="social_li">
								<a href="<?php echo $settings['twitter_url']; ?>"><i class="flaticon-twitter-logo-silhouette"></i></a>
								<a href="<?php echo $settings['fb_url']; ?>"><i class="flaticon-facebook-app-logo"></i></a>
								<a href="<?php echo $settings['instagram_url']; ?>"><i class="flaticon-instagram-logo"></i></a>
								<a href="<?php echo $settings['youtube_url']; ?>"><i class="flaticon-youtube"></i></a>
							</li>
						</ul>
					</div>

				</div>

				<div class="clearfix"></div>
				<div class="copyright"> 
				<div class="col-md-7 col-sm-8">
					<span><?php echo $settings["site_copyright_text"]; ?></span>
					<a href="#" class="cp_a"><?php echo $this->lang->line('press'); ?></a>
					<a href="#"><?php echo $this->lang->line('sitemap'); ?></a>
					<!-- <a href="#"><?php echo $this->lang->line('affiliate'); ?></a> -->
				</div>
				<div class="col-md-5 col-sm-4 text-right">
					<div class="amazon-div">
					<img src="<?php echo base_url('images/256-amazon.png'); ?>" alt="<?php echo $this->lang->line('sugarbabe_deluxe_web_security_seal') ?>" class="256-amazon">
				</div>
				</div>
				</div>
			</footer>
		</div>
	<!--footer-->

	<!-- Cookie Modal -->
	<div class="modal fade fade-in notificationModal" id="cookieModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal body -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="alertBox">
								<button type="button" class="ckCls" data-dismiss="modal" aria-label="close">×</button>
								<P class="cookieP"><?php echo $this->lang->line('cookies_text_first'); ?></P>
								<p class="cookieSbP"><?php echo $this->lang->line('cookies_text_second'); ?><a href="<?php echo base_url('page/privacy_statement'); ?>"><?php echo $this->lang->line('learn_more'); ?></a></p>
								<button type="button" name="btn-search" class="save_search next btn_hover ckAgree"><span class="search_span"><?php echo $this->lang->line('i_agree'); ?></span></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Add Favorite Modal -->

	<div class="modal fade registerModal" id="forgotPasswordModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="fourth">
			  			<div class="text-center">
			  				<h4 class="full-pay gold-txt"><span class="sign_span" style="font-size: 38px;"><?php echo $this->lang->line('forgot_your_password'); ?></span></h4>
						</div>

						<form role="form">
							<div class="text-left email_box">
								<label><?php echo $this->lang->line('enter_your_username_or_email'); ?></label>
								<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('your_username'); ?>" id="forgotpass_email" autocomplete="off" maxlength="38" >	
							</div>							

							<div class="selection_div">
								<div class="col-md-12">	
									<div class="form-error"></div>
								</div>

								<div class="row">
									<div class="text-center">
										<button type="submit" class="btn-recover-password-ok continue_btn next member-login-a btn_hover"><span class="cont_span"><?php echo $this->lang->line('send'); ?></span></button>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Welcome Ads for New Visitors Model -->
	<div class="modal fade transparent_mdl landing-page-bg" id="welcomeAdsModal" role="dialog" style="z-index: 10000;">
	    <div class="modal-dialog">
	      	<!-- Modal content-->
	      	<div class="modal-content welcome-modal-content">
	        	
	        	<div class="modal-body wel-ads-mod-body" style="">
	        		<div class="wel-adss-inner-box">
						<h4 class="full-pay gold-txt text-center"><span class="sign_span countdown-text respMainModalTitle"><?php echo $this->lang->line('countdown'); ?></span></h4>
						
						<h3 class="welcome-add-second-line"><?php echo $this->lang->line('if_you_look_forward_to_the_official_start_of'); ?></h3>
						<div class="modal-logo-main-div">
							<img src="<?php echo base_url('images/sugarbabe-logo.png'); ?>" alt="<?php echo $this->lang->line('sugarbabe_deluxe_logo') ?>" class="modal-logo-image">
						</div>
						<h3 class="welcome-add-second-line"><?php echo $this->lang->line('you_sign_up_for_free_once'); ?></h3>
						<h3 class="welcome-add-third-line"><?php echo $this->session->userdata('site_setting')['free_credits'].' '.$this->lang->line('credits_as_a_welcome_gift'); ?></h3>

						<h3 class="welcome-add-fourth-line"><?php echo $this->lang->line('welcome_ads_note_first_text'); ?></h3>
						<h3 class="welcome-add-fourth-line"><?php echo $this->lang->line('welcome_ads_note_second_text'); ?></h3>
					</div>
	        	</div>
	      	</div>      
	    </div>
	</div>

	<!-- End: Welcome Note Model -->

	<script type="text/javascript">
		var base_url = "<?php echo base_url() ?>";
		var almost_there_str = "<?php echo $this->lang->line('almost_there'); ?>";
		var demo_reg_closed_str = "<?php echo $this->lang->line('demo_reg_closed'); ?>";
		var yeah_str = "<?php echo $this->lang->line('yeah'); ?>";
		var success_str = "<?php echo $this->lang->line('success'); ?>";
		var sign_in_str = "<?php echo $this->lang->line('sign_in'); ?>";
		var register_str = "<?php echo $this->lang->line('register_btn'); ?>";
		var email_invalid_str = "<?php echo $this->lang->line('email_invalid'); ?>";
		var email_not_linked_str = "<?php echo $this->lang->line('email_not_linked'); ?>";
		var recover_password_success_str = "<?php echo $this->lang->line('recover_password_success'); ?>";

		var please_select_correct_option = "<?php echo $this->lang->line('please_select_correct_option'); ?>";
		var please_enter_valid_email = "<?php echo $this->lang->line('please_enter_valid_email'); ?>";
		var please_accept_terms_and_conditions = "<?php echo $this->lang->line('please_accept_terms_and_conditions'); ?>";		
		var please_enter_username_and_password = "<?php echo $this->lang->line('please_enter_username_and_password'); ?>";
		var please_enter_strong_password = "<?php echo $this->lang->line('please_enter_strong_password'); ?>";
		var please_enter_your_postcode = "<?php echo $this->lang->line('please_enter_your_postcode'); ?>";
		var please_enter_valid_postcode = "<?php echo $this->lang->line('please_enter_valid_postcode'); ?>";
		var please_enter_your_location = "<?php echo $this->lang->line('please_enter_your_location'); ?>";
		var please_enter_your_size = "<?php echo $this->lang->line('please_enter_your_size'); ?>";
		var please_enter_your_description = "<?php echo $this->lang->line('please_enter_your_description'); ?>";
		var please_enter_your_impression = "<?php echo $this->lang->line('please_enter_your_impression'); ?>";
		var please_enter_valid_size = "<?php echo $this->lang->line('please_enter_valid_size'); ?>";
		var please_enter_image_text = "<?php echo $this->lang->line('please_enter_image_text'); ?>";
		var no_legal_age = "<?php echo $this->lang->line('no_legal_age'); ?>";
		var please_enter_username_or_email = "<?php echo $this->lang->line('please_enter_username_or_email'); ?>";
		var send_str = "<?php echo $this->lang->line('send'); ?>";

		var user_latitude = "0.000000";
		var user_longitude = "0.000000";

	</script>	

    <script src="<?php echo base_url(); ?>js/welcome/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/welcome/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.cookie.min.js"></script>
    <script src="<?php echo base_url(); ?>js/custom.js?v=1.0"></script>
    <script src="<?php echo base_url(); ?>js/pages/welcome_ok.js?v=1.0"></script>
	
	<!-- Geolocation API -->
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY; ?>&callback=initAutocomplete&libraries=places&v=weekly" async></script>
	<!-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo GOOGLE_MAP_API_KEY; ?>"></script>
	<script src="<?php // echo base_url(); ?>js/geocomplete/jquery.geocomplete.js"></script> -->
<script>
  let autocomplete;
  let address1Field;
  let postalField;

  function initAutocomplete() {
    address1Field = document.querySelector("#user_location");
    autocomplete = new google.maps.places.Autocomplete(address1Field, {});
    address1Field.focus();
    autocomplete.addListener("place_changed", fillInAddress);
  }
  function fillInAddress() {
    const place = autocomplete.getPlace();
    let address1 = "";
    document.querySelector("#user_latitude").value = autocomplete.getPlace().geometry.location.lat();
	document.querySelector("#user_longitude").value = autocomplete.getPlace().geometry.location.lng();
    for (const component of place.address_components) {
      const componentType = component.types[0];

      switch (componentType) {
        case "locality":
          document.querySelector("#locality").value = component.long_name;
          break;
        case "country":
          document.querySelector("#country").value = component.long_name;
          break;
      }
    }
    $('#btn-location-continue').show();
    // address1Field.value = address1;
  }
</script>
<!-- webgain new scripts -->
<!-- Variablenuebergabe --> 
<script> 
	 window.ntmData=window.ntmData||[]; 
	 window.ntmData.push({ 
	 gdpr: "-1", /* 0 if GDPR does not apply, 1 if GDPR applies */ 
	 gdprConsent: "", /* IAB TCF 2.0 consent string */
	 pageType:"homepage" 
	 }); 
</script> 
<!-- Allgemeiner Tag --> 
<noscript>
	<iframe src="//tm.container.webgains.link/tm/a/container/noscript/249d3b047b.html" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<script>
	(function(n,e,o,r,y){
		n[r]=n[r]||[];
		n[r].push(
			{
				'event':'ntmInit','t':new Date().getTime()
			}); 
		var f = e.getElementsByTagName(o)[0],s=e.createElement(o),d=r!='ntmData'?'&ntmData='+r:'';
		s.async=true;
		s.src='http'+(document.location.protocol=='https:'?'s':'')+'://tm.container.webgains.link/tm/a/container/init/'+y+'.js?'+d+'&rnd='+Math.floor(Math.random()*100000000);
		f.parentNode.insertBefore(s,f);
	})(window,document,'script','ntmData','249d3b047b');
</script>
<!-- webgain new script end -->
<script>
$(document).ready(function(){
    $("#testimonial-slider").owlCarousel({
        items:3,
        itemsDesktop:[1000,2],
        itemsDesktopSmall:[979,2],
        itemsTablet:[768,2],
        itemsMobile:[650,1],
        pagination:false,
        navigation:true,
        navigationText:["",""],
        autoPlay:false
    });

   	getUserLocation(); 

	// $("#user_location").geocomplete().bind("geocode:result", function(event, result){
	// 	$("#user_location").val(result.name);
 //   		user_latitude = result.geometry.location.lat;
 //   		user_longitude = result.geometry.location.lng;
	// 	console.log(user_latitude,user_longitude);
 //   		$('#btn-location-continue').show();
 //   		$(this).css('margin-bottom', 'auto');
 //  	});

});

function subscribeNews() {
	$("#btn-subscribe-news").click();
}

function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showUserPosition);
    }
}

function showUserPosition(position) {
   	// user_latitude = position.coords.latitude;
   	// user_longitude = position.coords.longitude;   	
}
$(document).ready(function(){
	$("#user_postcode").change(function() {
		// var pincode_addr = $(this).val();

		// <?php 
		// 	if($this->session->has_userdata('user_currlocation')) {
		// 		$cur_country = $this->session->userdata('user_currlocation')['country'];
		// 	} else {
		// 		$cur_country = DEFAULT_COUNTRY;
		// 	}
		//  ?>
		// $.ajax({
		// 	url: "https://maps.googleapis.com/maps/api/geocode/json?address="+ pincode_addr +"+<?php //echo $cur_country; ?>&language=en&key=<?php //echo GOOGLE_MAP_API_KEY; ?>",
		// 	type: 'GET',
		// 	dataType: 'json',
		// 	success: function(data) {
		// 		var addr_str = "";

		// 		if(data.results.length > 0) {
		// 			var addr_length = data.results[0].address_components.length;

		// 			if(addr_length > 1) {
		// 				var g_city = data.results[0].address_components[1].long_name;
		// 				var g_country = data.results[0].address_components[addr_length-1].long_name;
		// 				var g_country_code = data.results[0].address_components[addr_length-1].short_name;
		// 			} else {
		// 				var g_city = '';
		// 				var g_country = data.results[0].address_components[0].long_name;
		// 				var g_country_code = data.results[0].address_components[0].short_name;
		// 			}
		// 			user_latitude = data.results[0].geometry.location.lat;
		// 			user_longitude = data.results[0].geometry.location.lng;
		// 			$("#registerModal input[name=user_location]").val(g_city);
		// 			$("#registerModal input[name=user_country]").val(g_country);
		// 			$("#registerModal input[name=user_country_code]").val(g_country_code);
		// 			// $('#btn-location-continue').show();
		// 			$(this).css('margin-bottom', 'auto');
		// 		}
		// 	}
		// });
	});

	$("#user_location").change(function() {
		// var location_addr = $(this).val();

		// $.ajax({
		// 	url: "https://maps.googleapis.com/maps/api/geocode/json?address="+ location_addr +"&language=en&key=<?php echo GOOGLE_MAP_API_KEY; ?>",
		// 	type: 'GET',
		// 	dataType: 'json',
		// 	success: function(data) {
		// 		var addr_str = "";

		// 		if(data.results.length > 0) {
		// 			var addr_length = data.results[0].address_components.length;

		// 			if(addr_length > 1) {
		// 				var g_city = data.results[0].address_components[1].long_name;
		// 				var g_country = data.results[0].address_components[addr_length-1].long_name;
		// 				var g_country_code = data.results[0].address_components[addr_length-1].short_name;
		// 			} else {
		// 				var g_city = '';
		// 				var g_country = data.results[0].address_components[0].long_name;
		// 				var g_country_code = data.results[0].address_components[0].short_name;
		// 			}
		// 			user_latitude = data.results[0].geometry.location.lat;
		// 			user_longitude = data.results[0].geometry.location.lng;					
		// 			$("#registerModal input[name=user_country]").val(g_country);
		// 			$("#registerModal input[name=user_country_code]").val(g_country_code);
		// 			// $('#btn-location-continue').show();
		// 			$(this).css('margin-bottom', 'auto');
		// 		} else {
		// 			$("#user_location").val('');
		// 			// $('#btn-location-continue').hide();
		// 			$(this).css('margin-bottom', '150px');
		// 		}
		// 	}
		// });
	});
// $("#user_location").geocomplete({
	// 	details: ".location_full_details",
	// 	detailsAttribute: "data-geo"
	// });
	$(document).on('keyup', '#user_location', function() {
		$(this).css('margin-bottom', '150px');
	})

});

    function switchCountry(country_abbr) {
		$.ajax({
			url: base_url + "auth/switch_country",
			type: 'POST',
			data: {'country_abbr' : country_abbr},
			dataType:'json',
			success: function(data) {
				if(data.status == true) {
					location.reload(true);
					location.href = "";
				}
			}
		});
    }
</script>

<?php echo $settings["site_analytics"]; ?>

</body>

</html>
