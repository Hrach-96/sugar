<section class="wishlist_section signup_section">
	<div class="container">
		<form method="POST" action="<?php echo base_url('site/newsSubscription'); ?>">
			<div class="row">
				<div class="col-md-5 col-sm-5 col-xs-12">	
					<h4 class="full-pay gold-txt"><span class="sgn_fr"><?php echo $this->lang->line('signup_for'); ?></span><br><span class="sb_dlx"><?php echo $settings['site_name'].' '.$this->lang->line('news'); ?></span></h4>
					<p class="email_text"><?php echo $this->lang->line('enter_your_email_address_to_get_news_and_offer_from_space_wallet'); ?></p>
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					<div class="row newsletter-top-height">
						<div class="col-md-7 col-sm-5 col-xs-12">
							<div class="form-group city_form">
								<input type="email" id="email_add" placeholder="<?php echo $this->lang->line('enter_your_email_address'); ?>" name="user_email" class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-md-5 col-sm-7 col-xs-12 go_btn_col">
							<button type="submit" class="go_online_shop Rettangolo_2 sign_now btn_hover"><?php echo $this->lang->line('sign_now'); ?></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>

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
					<!-- <li><a href="<?php echo base_url('page/blog'); ?>"><?php echo $this->lang->line('blog'); ?></a></li> -->
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
						<ul class="dropdown-menu footerLanguageMenu" aria-labelledby="about-us">
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
				<?php //echo date('Y'); ?> <?php //echo $settings["site_name"]; ?>
			</div>
			<div class="col-md-5 col-sm-4 text-right">
				<div class="amazon-div">
					<img src="<?php echo base_url('images/256-amazon.png'); ?>" alt="<?php echo $this->lang->line('sugarbabe_deluxe_web_security_seal') ?>" class="256-amazon">
				</div>
			</div>
		</div>
	</footer>
</div>
<!-- Alert Message Modal -->
<div class="modal fade fade-in notificationModal" id="alertMessageModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal body -->
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="alertBox">
							<table>
								<tr>
									<td><img src="<?php echo base_url('images/thumbs-up-hand-symbol.png'); ?>" alt="<?php echo $this->lang->line('black_gold_thumbs_up_icon') ?>" class="noti_i" /></td>
									<td><span id="alertMessageText"></span></td>
									<td class="text-right" style="width: 25%;">
										<button type="button" id="alertbtn" class="save_search btn_hover text-uppercase" data-dismiss="modal"><?php echo $this->lang->line('ok'); ?></button>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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

<!-- upload profile pic dialog Modal -->
<div class="modal fade fade-in notificationModal userNotification" id="profilePicNotifctn">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal body -->
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="text-center">
							<h4 class="full-pay gold-txt common33" style="text-transform: uppercase;"><span class="sign_span cinzel"><?php echo $this->lang->line('hello').' '.$this->session->userdata('user_username'); ?>,<br/><?php echo $this->lang->line('you_do_not_have_a_profile_picture_yet'); ?></span></h4>
						</div>
						<h3 class="register_title common16"><?php echo $this->lang->line('profiles_with_pictures_get_more_attention_and_increase_the'); ?>
						<br class="mobileBr" /><?php echo $this->lang->line('flirt_chances_up_to'); ?></h3>
						<a href="<?php echo base_url('user/profile/edit'); ?>" class="go_online_shop Rettangolo_2 btn_hover btnMobileFirst" id="buy_nw_credits"><?php echo $this->lang->line('upload_your_profile_picture_now'); ?>
							<div class="avatar-upload">
								<div class="avatar-edit">
									<input type='file' name="user_photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
									<label for="imageUpload" class="imageUpload"></label>
								</div>
							</div>
						</a>
						<a href="#" data-dismiss="modal" class="go_online_shop Rettangolo_2 btn_hover btnspater btnMobileSecond" id="buy_nw_credits"><?php echo $this->lang->line('later'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- upload profile pic dialog Modal -->

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>js/jquery-2.1.1.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.nailthumb.min.js"></script>
<script src="<?php echo base_url(); ?>js/nouislider.min.js"></script>
<script src="<?php echo base_url(); ?>js/flatui-fileinput.js"></script>
<script src="<?php echo base_url(); ?>js/masonry.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.timeago.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.cssemoticons.min.js"></script>
<script src="<?php echo base_url(); ?>js/vendor/jquery.sidr.min.js"></script>
<script src="<?php echo base_url(); ?>js/vendor/fastclick.js"></script>
<script src="<?php echo base_url(); ?>js/profile_slider.js"></script>
<script src="<?php echo base_url(); ?>js/chat_sidebar.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-slider.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.easing.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.smoothScroll.js"></script>
<script src="<?php echo base_url(); ?>js/css-menu.js"></script>
<script src="<?php echo base_url(); ?>js/pages/user_activity.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo base_url(); ?>js/tab.js"></script>
<!-- <script src="<?php echo base_url(); ?>js/tooltipster.bundle.min.js"></script> -->
<script src="<?php echo base_url(); ?>js/pages/home.js?v=1.1.0"></script>
<script src="<?php echo base_url(); ?>js/pages/pages.js?v=1.0"></script>
<script src="<?php echo base_url(); ?>js/pages/online.js?v=1.1.2"></script>
<script src="<?php echo base_url(); ?>js/main-custom.js?v=1.0"></script>
<?php if(uri_string() == 'user/profile/edit'): ?>
<script src="<?php echo base_url(); ?>js/cropper/cropper.js"></script>
<?php endif; ?>
<?php if(uri_string() == 'chat'): ?>
<script src="<?php echo base_url(); ?>js/pages/chatroom.js?v=1.0"></script>
<?php endif; ?>

<!-- Geolocation API -->    
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo GOOGLE_MAP_API_KEY; ?>"></script>
<script src="<?php echo base_url(); ?>js/geocomplete/jquery.geocomplete.js"></script>

<script>
	var userLoggedIn = false;
	<?php if($this->session->has_userdata('user_id')): ?>
	userLoggedIn = true;
	<?php endif; ?>

	$('a[href^="#"]').SmoothScroll({
		duration: 1000,
		easing  : 'easeOutQuint'
	});

	$("#location_input").geocomplete().bind("geocode:result", function(event, result){
		$("#location_input").val(result.name);
		$("#location_latitude").val(result.geometry.location.lat);
		$("#location_longitude").val(result.geometry.location.lng);
  	});

	$("#location_input").keydown(function() {
		if($('#location_input').val() != '') {
			$.ajax({
				url: "https://maps.googleapis.com/maps/api/geocode/json?address="+ $('#location_input').val() +"&language=en&key=<?php echo GOOGLE_MAP_API_KEY; ?>",
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					if(data.results.length > 0) {
						$("#location_latitude").val(data.results[0].geometry.location.lat);
						$("#location_longitude").val(data.results[0].geometry.location.lng);
					}
				}
			});
		} else {
			$("#location_latitude").val('<?php echo $this->session->userdata('user_latitude'); ?>');
			$("#location_longitude").val('<?php echo $this->session->userdata('user_longitude'); ?>');
		}
	});

</script>

<?php
	if($this->session->has_userdata('show_upload_profile_pic_dialog')):
		$this->session->unset_userdata('show_upload_profile_pic_dialog');
?>
<script>
	$(document).ready(function($) {
		$("#profilePicNotifctn").modal();
	});
</script>
<?php endif; ?>

<script type="text/javascript">
	if ($(window).width() < 767) {
		$("#ex2").slider({
			tooltip: 'always',
			step: 1
		});
		$("#ex3").slider({
			tooltip: 'always',
			step: 1
		});
		$("#ex4").slider({
			tooltip: 'always',
			step: 1
		});
	} else {
		$("#ex2").slider({
			step: 1
		});
		$("#ex3").slider({
			step: 1
		});
		$("#ex4").slider({
			step: 1
		});
	}		
</script>

<script type="text/javascript">
	$( document ).ready(function( $ ) {
		$( '#example5' ).sliderPro({
			width: '100%',
			height: 400,
			autoplay:false,
			orientation: 'horizontal',
			loop: false,
			arrows: true,
			buttons: false,
			thumbnailsPosition: 'bottom',
			thumbnailPointer: true,
			thumbnailWidth: 100,
			thumbnailArrows: true,
			breakpoints: {
				800: {
					thumbnailsPosition: 'bottom',
					thumbnailWidth: 270,
					thumbnailHeight: 100
				},
				500: {
					thumbnailsPosition: 'bottom',
					thumbnailWidth: 120,
					thumbnailHeight: 50
				}
			}
		});
		
	});
</script>
<script type="text/javascript">
	
	FastClick.attach(document.body);
	
	$(".sidr_btn").sidr();
	$(".message").emoticonize();
	
	var base_url = "<?php echo base_url(); ?>";
	var please_correct_your_information = "<?php echo $this->lang->line("please_correct_your_information"); ?>";
	var please_enter_valid_email = "<?php echo $this->lang->line("please_enter_valid_email"); ?>";
	var password_mismatch = "<?php echo $this->lang->line("password_mismatch"); ?>";
	var send_question_str = "<?php echo $this->lang->line("send_question"); ?>";
	var please_select_user_for_chatting = "<?php echo $this->lang->line("please_select_user_for_chatting"); ?>";
	var ln_online_str = "<?php echo $this->lang->line("online"); ?>";
	var ln_new_str = "<?php echo $this->lang->line("new"); ?>";
	var ln_view_profile_str = "<?php echo $this->lang->line("view_profile"); ?>";

	function switchLanguage(lang_id) {
		$.ajax({
			url: base_url + "auth/switch_language",
			type: 'POST',
			data: {'lang_id' : lang_id},
			dataType:'json',
			success: function(data) {
				if(data.status == true) {
					location.reload(true);
					location.href = "";
				}
			}
		});
	}

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