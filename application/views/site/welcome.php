<?php
	$this->load->view('templates/headers/welcome_header', $title);
	$link_facebook = $this->config->item('fb_url').'?client_id=' . $this->config->item('fb_client_id')  . '&redirect_uri=' . $this->config->item('fb_redirect_uri').'&auth_type=rerequest&scope=email';
?>

<style type="text/css">
	.alert-danger-dlx {
		color: #f2e9e8;
		background-color: #d5191966;
		border-color: #e9e9e9;
		font-size: 16px;
	}
	.alert-dlx {
		padding: 10px;
		margin: 10px 10%;
		border: 1px solid transparent;
		border-radius: 4px;	
	}
	.tag-alert {
		border: 0;
		border-radius: 0;
		padding: 5px 15px;
		font-size: 14px;
		display: inline-block;
		border-radius: 22px !important;
		margin-bottom: 6px;
		margin-right: 3px;
	}
	.tag-alert-golden {
	    color: #4d4e4d;
	    background-color: #e9c320;
	    border-color: #e9c320;
	    font-weight: bolder;
	    font-weight: bold;
	}
	.tag-alert .close {
	    position: relative;
	    top: 0px;
	    right: -8px;
	    color: inherit;
	}	
	.gold-star {
		color: gold;
	}
	.pac-container{
		z-index: 2000;
	}
</style>
	<header class="top_header">
				<div class="wlcmOverlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6 col-lg-4">
					<div class="logo_div">
						
					</div>
				</div>
				
				<div class="col-md-6 col-sm-6 col-xs-12 col-lg-8 text-right" id="bs-collapse-1">
					<ul class="right_UL">
						<li>
							<span class="langlbl"><?php echo $this->lang->line('select_your_country'); ?></span>
						</li>
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
						<li><i class="fa fa-search"></i></li>
					</ul>
				</div>
			</div>
			<?php if($this->session->flashdata('message') != '') { ?>
			<div class="row col-sm-12">
				<div class="alert tag-alert-golden alert-dismissible fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata('message'); ?>
				</div>
			</div>
			<?php } ?>

			<div class="row wlcm_rw">
				<div class="col-md-1"></div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="sugarbabe_logo">
						<img src="<?php echo base_url('images/Sfondo-copia.png'); ?>" alt="<?php echo $this->lang->line('attractive_sugar_babe_with_her_sugar_daddy') ?>" class="sugarbabe_back">
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12 text-right">
					<div class="wlcm_bx">
						<img src="<?php echo base_url('images/sugarbabe-logo.png'); ?>" alt="<?php echo $this->lang->line('sugarbabe_deluxe_logo') ?>" class="sugarbabe_logo_home"><br/><br/>
						<h4 class="full-pay gold-txt text-center"><span class="wlcm_txt"><?php echo $this->lang->line('welcome_to'); ?></span><br><span class="wlcmsb_txt">sugarbabe-deluxe.eu</span></h4>
						<br/><br/>
						<a href="javascript:void(0);" class="continue_btn RegBtn register_btn btn_hover" data-toggle="modal" data-target="#registerModal" data-backdrop="static" data-keyboard="false" id="next"><span class="cont_span"><?php echo $this->lang->line('try_for_free_and_anonymously'); ?></span></a>
						<p class="or_p"><?php echo $this->lang->line('or'); ?></p>
						
						<!-- <a href="<?php echo $fb_login_url; //$this->facebook->login_url();?>" class="continue_btn next member_login register_btn fb_i" ><span class="cont_span"><img src="images/fb_icon.png"><?php echo $this->lang->line('login_with_facebook'); ?></span></a> -->
						<button style='border:none;outline:none' class="fb_i member_login"  onclick="location.href='<?= $link_facebook ?>'" >
							<span class="cont_span"><img src="images/fb_icon.png" alt="<?php echo $this->lang->line('white_facebook_logo'); ?>"><?php echo $this->lang->line('login_with_facebook'); ?></span>
						</button>
						<a href="javascript:void(0);" class="continue_btn next member_login register_btn btn_hover" data-toggle="modal" data-target="#login_modal" data-keyboard="false"><span class="cont_span"><?php echo $this->lang->line('member_login'); ?></span></a>

						<a href="#"><img src="<?php echo base_url('images/home-amazon-256.png'); ?>" class="home-amazon-256" alt="<?php echo $this->lang->line('sugarbabe_deluxe_web_security_seal') ?>"></a>
						<br/><br/>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="row scrll_rw">
				<div class="col-md-12 text-center">
					<a href="#2"><img src="<?php echo base_url('images/scroll_icon.png'); ?>" alt="<?php echo $this->lang->line('white_computer_mouse_icon'); ?>"></a>
				</div>
			</div>
		</div>
	</header>

	<div class="clearfix"></div>
	<section class="whatis_sugarbabe">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-8 col-xs-12 col-lg-6">
				<h4 class="full-pay gold-txt"><span class="wht_sbdlx"><?php echo $this->lang->line('what_is_sugababe_deluxe'); ?></span></h4>
				<!-- <h5 class="code_h5">#enjoytheluxury</h5> -->
				<video width="100%" controls id='sugarbabe_vid' poster="<?php echo base_url('videos/SBD_Promo_AD_poster.png'); ?>">
					  <source src="<?php echo base_url('videos/SBD_Promo_AD.mp4'); ?>" type="video/mp4">
					  <source src="mov_bbb.ogg" type="video/ogg">
					  Your browser does not support HTML5 video.
				</video>
				<p class="whatis_sugarbabe_p"><?php echo $this->lang->line('what_is_sugababe_deluxe_text_content_first'); ?></p>
				<p class="whatis_sugarbabe_p"><?php echo $this->lang->line('what_is_sugababe_deluxe_text_content_second'); ?></p>

				<a href="#" class="continue_btn next try_nw_free register_btn btn_hover" data-toggle="modal" data-target="#registerModal" data-backdrop="static" data-keyboard="false"><span class="cont_span"><?php echo $this->lang->line('try_for_free'); ?></span></a>
				</div>
				<div class="col-md-6 col-sm-4 col-xs-12 col-lg-6">
				</div>
			</div>
		</div>
	</section>

	<div class="clearfix"></div>
 	<section class="rich_more">
	<div Class="backOverlay"></div>
		<div class="container">
			<div class="row">				
				<div class="col-md-6 col-sm-4 col-xs-6 col-lg-6">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
				
				<h4 class="full-pay gold-txt sugar-dad-new-heading"><span class="wht_sbdlx"><?php echo $this->lang->line('sugardaddys_or_sugababe'); ?>?</span></h4>
				<!-- <h5 class="code_h5 text_right">#enjoytherichest</h5> -->

				<p class="whatis_sugarbabe_p text-left">
					<?php echo $this->lang->line('sugardaddys_or_sugababe_text_content_first'); ?>
				</p>
				<p class="whatis_sugarbabe_p text-left">
					<?php echo $this->lang->line('sugardaddys_or_sugababe_text_content_second'); ?>
				</p>

				<h1 class="daddy_babe text-left"><?php echo $this->lang->line('what_does_sugarbabe_deluxe_offer_you'); ?></h1>
				<p class="whatis_sugarbabe_p text-left">
					<ul class="" style="color: rgb(255, 255, 255);margin-left: 40px;">
						<li class="whatis_sugarbabe_p"><?php echo $this->lang->line('free_registration'); ?></li>
						<li class="whatis_sugarbabe_p"><?php echo $this->lang->line('safe_dating'); ?></li>
						<li class="whatis_sugarbabe_p"><?php echo $this->lang->line('tested_profiles'); ?></li>
						<li class="whatis_sugarbabe_p"><?php echo $this->lang->line('authenticity_checks'); ?></li>
						<!-- <li class="whatis_sugarbabe_p"><?php echo $this->lang->line('rich_in_more_than_one_way'); ?>:</li> -->
						<!-- <li class="whatis_sugarbabe_p">#enjoytherichest</li> -->
					</ul>
				</p>	
				<div class="text_right rich_btn_div">
				<a href="#" class="continue_btn next try_nw_free register_btn btn_hover" data-toggle="modal" data-target="#registerModal" data-backdrop="static" data-keyboard="false"><span class="cont_span"><?php echo $this->lang->line('try_for_free'); ?></span></a>
				</div>
				</div>
			</div>
		</div>
	</section>


<!-- 	<section class="rich_more">
	<div Class="backOverlay"></div>
		<div class="container">
			<div class="row">				
				<div class="col-md-6 col-sm-4 col-xs-6 col-lg-6">
				</div>
				<div class="col-md-6 col-sm-8 col-xs-12 col-lg-6">
				
				<h4 class="full-pay gold-txt"><span class="wht_sbdlx rich_span"><?php echo $this->lang->line('rich_in_more_than_one_way'); ?>:</span></h4>
				<h5 class="code_h5 text_right">#enjoytherichest</h5>
							
				<h1 class="daddy_babe text_right"><?php echo $this->lang->line('rich_in_culture'); ?></h1>
				<p class="whatis_sugarbabe_p text_right">
					<?php echo $this->lang->line('rich_in_culture_info_text'); ?>
				</p>
				<h1 class="daddy_babe text_right"><?php echo $this->lang->line('rich_in_knowledge'); ?></h1>
				<p class="whatis_sugarbabe_p text_right">
					<?php echo $this->lang->line('rich_in_knowledge_info_text'); ?>
				</p>	
				<h1 class="daddy_babe text_right"><?php echo $this->lang->line('rich_in_experience'); ?></h1>
				<p class="whatis_sugarbabe_p text_right">
					<?php echo $this->lang->line('rich_in_experience_info_text'); ?>
				</p>
				<div class="text_right rich_btn_div">
				<a href="#" class="continue_btn next try_nw_free register_btn btn_hover" data-toggle="modal" data-target="#registerModal" data-backdrop="static" data-keyboard="false"><span class="cont_span"><?php echo $this->lang->line('try_for_free'); ?></span></a>
				</div>
				</div>
			</div>
		</div>
	</section> -->

<!-- 	<section class="wishlist_section gift_section">
		<div class="container">
			<div class="row">			
				<div class="col-md-5 col-sm-5 col-xs-12">					
					<h4 class="gold-txt">
					  <span class="bygift"><?php echo $this->lang->line('buy_a_special_gift_for_your_sugababe'); ?></span>
					</h4>
					<h5 class="code_h5">#enjoytheshopping</h5>
					<p class="gift_p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea com</p>
					<h4 class="gift_h4"><?php echo $this->lang->line('buy_a_special_gift_for_your_sugababe_sub_text'); ?></h4>
					<div class="row">		
						<div class="col-md-12">	
							<a href="#" class="continue_btn next try_nw_free register_btn byNow btn_hover"><span class="cont_span"><?php echo $this->lang->line('buy_now_credits'); ?></span></a>
							</a>
						</div>		
					</div>
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					<img src="<?php echo base_url('images/gift-img-hm.png'); ?>" class="img-responsive">
				</div>
			</div>
		</div>
	</section> -->

	<!--testimonial section-->
	<section class="testimonial_section">
		<div class="container">
    		<div class="row">
        		<div class="col-md-12 text-center">
					<h4 class="gold-txt liberty-text">
						<span class="review_txt"><?php echo $this->lang->line('sugarbabe_deluxe_review'); ?></span>
					</h4>
				</div>
        		<div class="col-md-12 text-center">
            		<div id="testimonial-slider" class="owl-carousel">

		                <div class="testimonial">
		                    <div class="pic">
		                        <img src="<?php echo base_url('images/testimonials/sabine_r.png'); ?>" alt="<?php echo $this->lang->line('sugarbabe_deluxe_testimonial_sabine') ?>">
		                    </div>
							<ul class="rating">
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                    </ul>
		                    <h3 class="title">Sabine R.</h3>
		                    <div class="testimonial-content">
		                        <div class="testimonial-profile">
		                            <h3 class="name"><?php echo $this->lang->line('munich'); ?></h3>
		                        </div>
		                    </div>
		                    <p class="description"><?php echo $this->lang->line('sabine_r_text_description'); ?></p>
		                </div>

						<div class="testimonial">
		                    <div class="pic">
		                        <img src="<?php echo base_url('images/testimonials/mario_l.png'); ?>" alt="<?php echo $this->lang->line('sugarbabe_deluxe_testimonial_mario') ?>">
		                    </div>
							<ul class="rating">
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                    </ul>
		                    <h3 class="title">Mario L.</h3>
		                    <div class="testimonial-content">
		                        <div class="testimonial-profile">
		                            <h3 class="name"><?php echo $this->lang->line('frankfurt_am_main'); ?></h3>
		                        </div>
		                    </div>                    
		                    <p class="description"><?php echo $this->lang->line('mario_l_text_description'); ?></p>
		                </div>

						<div class="testimonial">
		                    <div class="pic">
		                        <img src="<?php echo base_url('images/testimonials/nicole_g.png'); ?>" alt="<?php echo $this->lang->line('sugarbabe_deluxe_testimonial_nicole') ?>">
		                    </div>
							<ul class="rating">
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                        <li class="fa fa-star gold-star"></li>
		                    </ul>
		                    <h3 class="title">Nicole G.</h3>
		                    <div class="testimonial-content">
		                        <div class="testimonial-profile">
		                            <h3 class="name"><?php echo $this->lang->line('vienna'); ?></h3>
		                        </div>
		                    </div>
		                    <p class="description"><?php echo $this->lang->line('nicole_g_text_description'); ?></p>
		                </div>
            		</div>
        		</div>
		 		<div class="col-md-12 text-center">
					<a href="#" class="continue_btn next try_nw_free register_btn btn_hover" data-toggle="modal" data-target="#registerModal" data-backdrop="static" data-keyboard="false"><span class="cont_span"><?php echo $this->lang->line('try_for_free'); ?></span></a>
				</div>
    		</div>
		</div>
	</section>
	<!--testimonial section-->	
	
<!--signup section-->

<?php $this->load->view('templates/footers/welcome_footer'); ?>

<!--Login Modal -->
<div id="login_modal" class="modal fade registerModal" role="dialog">
	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
     		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
      		</div>
      		<div class="modal-body" id="group">
	  			<div class="fourth">
		  			<div class="text-center">
		  				<h4 class="full-pay gold-txt"><span class="sign_span"><?php echo $this->lang->line('sign_in'); ?></span></h4>	                 
					</div>
					<h3 class="register_title"><?php echo $this->lang->line('enter_username_and_password_and_login_inside'); ?></h3>
					<form id="login">
					<div class="text-left email_box">
						<label><?php echo $this->lang->line('username'); ?> / <?php echo $this->lang->line('email'); ?></label>
						<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('your_username'); ?>" id="logusername" autocomplete="off" maxlength="38">
						<label><?php echo $this->lang->line('password'); ?></label>
						<input class="email_add" type="password" placeholder="<?php echo $this->lang->line('your_password'); ?>" id="logpassword" autocomplete="off" maxlength="38">					
					</div>
					<div class="selection_div">
						<div class="row">	
							<div class="col-md-12">
								<div  style="text-align:center;">
									<div class="error-login alert alert-danger"></div>			
		        				</div>
							</div>
							<div class="col-md-6 text-left">
								<a href="#" id="btn_forgot_password"><label class="help-block" style="cursor: pointer;"><?php echo $this->lang->line('forgot_your_password'); ?></label></a>
							</div>
							<div class="col-md-6">
								<div class="signin_btn">
									<button type="submit" class="btn-login-ok continue_btn next member-login-a btn_hover"><span class="cont_span"><?php echo $this->lang->line('sign_in'); ?></span></button>
								</div>
							</div>
						</div>
						</form>
						<div class="row">
							<div class="col-md-12">
								<div class="or_div" style="margin-top: -4px;">
									<h2><span><?php echo $this->lang->line('facebook_or'); ?></span></h2>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<h4 class="fcbk_lbl"><?php echo $this->lang->line('if_facebook'); ?></h4>
								<a href="<?php echo $fb_login_url; ?>" class="fb_btn"><img src="images/fb_icon.png" alt="<?php echo $this->lang->line('white_facebook_logo'); ?>"><?php echo $this->lang->line('facebook_connect'); ?></a>
							</div>
						</div>
					</div>
      			</div>
	  		</div>
      		<div class="modal-footer"></div>
    	</div>
	</div>
</div>
<!--login modal-->

<!-- Register Modal -->
<div id="registerModal" class="modal fade" role="dialog">
 	<div class="modal-dialog">
    	<!-- Modal content-->
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
      		</div>
      		<div class="modal-body" id="registrationForm">
	  		
	  		<!-- First step for Registration -->
	  		<div class="none first active">
	  			<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('i_am_a'); ?>:</div>
				<div class="selection_div">
					<div class="row">		
						<label class="control control--radio col-md-6"><?php echo $this->lang->line('man'); ?>
      						<input type="radio" name="i_am_a" value="male" />
      						<div class="control__indicator"></div>
    					</label>
	 					<label class="control control--radio col-md-6"><?php echo $this->lang->line('female'); ?>
      						<input type="radio" name="i_am_a" value="female" />
      						<div class="control__indicator"></div>
    					</label>
    					<div class="col-md-12 form-error error-box-message"></div>
						<div class="btn_box">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End First step -->

	  		<!-- Second step for Registration -->
	  		<div class="none second">
	        	<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('i_am_inerested_in'); ?>:</div>
				<div class="selection_div">
					<div class="row">		
						<label class="control control--radio col-md-6"><?php echo $this->lang->line('men'); ?>
      						<input type="radio" name="i_am_inerested_in" value="male" />
      						<div class="control__indicator"></div>
    					</label>
	 					<label class="control control--radio col-md-6"><?php echo $this->lang->line('women'); ?>
      						<input type="radio" name="i_am_inerested_in" value="female" />
      						<div class="control__indicator"></div>
    					</label>
    					<div class="col-md-12 form-error error-box-message"></div>
						<div class="btn_box">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
	  		</div>
	  		<!-- End First step -->

	  	  	<!-- Third step for Registration -->
	  		<div class="none third">
	        	<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-left email_box">
					<label><img id="captcha_image_url" alt='Captcha' src="<?php echo $captcha_image_url; ?>" style="width:100%;height:45px;" /></label>
					<input class="email_add" id="captcha_text" name="captcha_text" placeholder="<?php echo $this->lang->line('enter_above_text_here'); ?>">
					<label><?php echo $this->lang->line('email_address'); ?></label>
					<input class="email_add" id="user_email" name="user_email" placeholder="<?php echo $this->lang->line('email_placeholder'); ?>">		
					<label class="col-md-12">
						<span style="color: rgb(255, 255, 255);text-transform: uppercase;"><?php echo $this->lang->line('information_for'); ?> <a style="color: rgb(255, 255, 255);text-decoration: underline;" target="_blank" href="<?php echo base_url('page/privacy_statement'); ?>"><?php echo $this->lang->line('general_privacy'); ?></a> <?php echo $this->lang->line('and'); ?> <a style="color: rgb(255, 255, 255);text-decoration: underline;" target="_blank" href="<?php echo base_url('page/terms_of_use'); ?>"><?php echo $this->lang->line('terms_of_use'); ?></a>
						</span>
    				</label>
				</div>
				<div class="col-md-12 form-error error-box-message"></div>
				<div class="selection_div">
					<div class="row">
						<div class="btn_box">
							<a href="#" class="continue_btn next btn_hover" id="btn_next_valid_email_step"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
	  		</div>
	  		<!-- End Third step -->

	  	  	<!-- Fourth step for Registration -->
	  		<div class="none fourth">
	        	<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-left email_box">
					<label><?php echo $this->lang->line('username'); ?></label>
					<input class="email_add" type="text" id="user_username" name="user_username" maxlength="100" placeholder="<?php echo $this->lang->line('enter_username'); ?>">
					<label><?php echo $this->lang->line('password'); ?></label>
					<input class="email_add" type="password" name="user_password" maxlength="50" placeholder="<?php echo $this->lang->line('enter_password'); ?>">
					<p class="help-block" style="color: white;font-weight: 400;"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $this->lang->line('enter_password_info_text'); ?></p>
				</div>
				<div class="selection_div">
					<div class="col-md-12 form-error error-box-message"></div>					
					<div class="row">
						<div class="btn_box">
							<a href="#" class="continue_btn next btn_hover" id="btn_next_valid_username_step" style="display: none;"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
	  		</div>
	  		<!-- End Fourth step -->

		   	<!-- Fifth step for Registration -->
		  	<div class="none fifth">
	        	<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
	        	<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
	        	<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('enter_your_birthday'); ?>:</div>
				<div class="text-left date_box email_box">
					<div class="row">
						<input type="hidden" name="min_date_for_reg" id="min_date_for_reg" value="<?php echo date('Y-m-d', strtotime('-'.$settings['site_age_limit'].' year', strtotime(gmdate('Y-m-d')))); ?>" >
						<div class="col-md-4 col-sm-4 col-xs-12">
							<label><?php echo $this->lang->line('day'); ?></label>
							<div class="select">
								<select name="dateofbirth_day">
									<?php for($day=1; $day <= 31; $day++) { ?>
									<option class="option" value="<?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?>"><?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?></option>
									<?php } ?>
								</select>
			  					<div class="select__arrow">
			  						<i class="fa fa-angle-down" aria-hidden="true"></i>
			  					</div>
							</div>
						</div>			
						<div class="col-md-4 col-sm-4 col-xs-12">
							<label><?php echo $this->lang->line('month'); ?></label>
							<div class="select">
								<select name="dateofbirth_month">
									<?php for($month=1; $month <= 12; $month++) { ?>
									<option class="option" value="<?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?>"><?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?></option>
									<?php } ?>
								</select>
      							<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
    						</div>
    					</div>	
						<div class="col-md-4 col-sm-4 col-xs-12">
							<label><?php echo $this->lang->line('year'); ?></label>
							<div class="select">
								<select name="dateofbirth_year">
									<?php 
									$curr_year = date('Y');
									$year_diff = $settings['site_age_limit'];
									$upto_year = $curr_year - $year_diff - 52;

									for($year=($curr_year-$year_diff); $year >= $upto_year; $year--) { ?>
									<option class="option" value="<?php echo $year; ?>"><?php echo $year; ?></option>
									<?php } ?>
								</select>
      							<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
    						</div>
    					</div>
    				</div>
    				<div class="col-md-12 form-error error-box-message"></div>
				</div>
				<div class="selection_div cont_btn">					
					<div class="row">
						<div class="btn_box">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
	  		</div>
	  		<!-- End fifth step -->

	  		<!-- Sixth step for Registration -->
	  		<div class="none six">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('arangement'); ?>:</div>
				<div class="selection_div">
					<div class="row" id="arrangment">
						<label class="control control--radio col-md-3 col-xs-12"><?php echo $this->lang->line('luxury'); ?>
      						<input type="checkbox" name="user_arangement" value="luxury" />
      						<div class="control__indicator"></div>
    					</label>
	 					<label class="control control--radio col-md-3 col-xs-12"><?php echo $this->lang->line('lifestyle'); ?>
      						<input type="checkbox" name="user_arangement" value="lifestyle" />
      						<div class="control__indicator"></div>
    					</label>
						<label class="control control--radio col-md-6 col-xs-12"><?php echo $this->lang->line('monthly_budget'); ?>
      						<input type="checkbox" name="user_arangement" value="monthly_budget" />
      						<div class="control__indicator"></div>
    					</label>
    					<div class="col-md-12 form-error error-box-message"></div>
						<div class="btn_box arrngmnt">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Sixth step -->

	  		<!-- Seventh step for Registration -->
	  		<div class="none seven" id="whr_frm">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('contact_request'); ?>:</div>
				<div class="selection_div">
					<div class="row" id="kontak">	
						<div class="kontak_div">
							<?php 
								if(!empty($contact_requests)) { 
									foreach($contact_requests as $req) {
							?>
							<div class="col-md-6">
								<label class="control control--radio"><?php echo $this->lang->line($req['contact_request_name']); ?>
      								<input type="checkbox" name="user_contact_request" value="<?php echo $req['contact_request_id']; ?>" />
      								<div class="control__indicator"></div>
    							</label>
							</div>
							<?php 	} 
								} 
							?>
						</div>
						<div class="clearfix"></div>
						<hr class="kontak_hr"/>
						<div class="text-left gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('i_am_only_at_one'); ?>:</div>
						<div class="row">
							<div class="col-md-12 text-left Beziehung">
								<label class="control control--radio"><?php echo $this->lang->line('serious_relationship_interested'); ?>
									<input type="radio" name="serious_relationship_interested" value="yes" />
									<div class="control__indicator"></div>
								</label>
							</div>
						</div>
						<div class="col-md-12 form-error error-box-message"></div>
						<div class="btn_box">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
				</div>
      		</div>
	  		<!-- End Seventh step -->

	  		<!-- Eighth step for Registration -->
	  		<div class="none eight" id="whr_frm">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('where_are_you_from'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm">		
						<div class="col-md-4 col-lg-4 col-xs-12 pd-rgt">
							<label><?php echo $this->lang->line('postcode'); ?></label>
							<input class="email_add" id="user_postcode" name="user_postcode" placeholder="<?php echo $this->lang->line('enter_postcode'); ?>" maxlength="8">
						</div>
						<div class="col-md-8 col-lg-8 col-xs-12">
							<label><?php echo $this->lang->line('location'); ?></label>
							<!-- <input class="email_add" name="user_location" id="user_location" placeholder="<?php // echo $this->lang->line('enter_location'); ?>"> -->
					        <input class='email_add' id="user_location" name="user_location" required autocomplete="off"/>
					        <input type='hidden' id="locality" name="locality" value='' />
					        <input type='hidden' id="country" name="country" value='' />
					        <input type='hidden' id="user_latitude" name="user_latitude" value='' />
					        <input type='hidden' id="user_longitude" name="user_longitude" value='' />
						</div>
						<div class="col-md-12 form-error error-box-message"></div>
						<div class="clearfix"></div>
						<div class="btn_box whr_btn" id="btn-location-continue" style="display: none;">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
  				</div>
      		</div>
	  		<!-- End Eighth step -->

	   		<!-- Ninth step for Registration -->
	  		<div class="none nine" id="whr_frm">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('figure'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm">		
						<div class="col-md-4 col-lg-4 col-xs-12 pd-rgt">
							<label><?php echo $this->lang->line('figure'); ?></label>
							<div class="select">
								<select name="user_figure">
									<?php foreach($figure_list as $figure) { ?>
									<option class="option" value="<?php echo $figure; ?>"><?php echo $this->lang->line($figure); ?></option>
									<?php } ?>
								</select>
								<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
							</div>					
						</div>
						<div class="col-md-8 col-lg-8 col-xs-12">
							<label><?php echo $this->lang->line('size'); ?></label>
							<div class="select">
								<input class="email_add" name="user_size" placeholder="200" maxlength="20" >
								<div class="select__arrow"><?php echo $this->lang->line('cm'); ?></div>
							</div>
						</div>
						<div class="col-md-12 form-error error-box-message"></div>
						<div class="clearfix"></div>
						<div class="btn_box whr_btn">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Ninth step-->

	   		<!-- Tenth step for Registration -->
	  		<div class="none ten" id="whr_frm">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('hair_color'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm">					
						<div class="col-md-12 col-lg-12 col-xs-12">
							<label><?php echo $this->lang->line('hair_color'); ?></label>
							<div class="select">
								<select name="user_hair_color">
									<?php foreach($hair_color_list as $hlist) { ?>
									<option class="option" value="<?php echo $hlist; ?>"><?php echo $this->lang->line($hlist); ?></option>
									<?php } ?>
								</select>
								<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
							</div>	
						</div>
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Tenth step -->

	  		<!-- Eleventh step for Registration -->
	  		<div class="none eleven" id="whr_frm">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('eye_color'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm">					
						<div class="col-md-12 col-lg-12 col-xs-12">
							<label><?php echo $this->lang->line('eye_color'); ?></label>
							<div class="select">
								<select name="user_eye_color">
									<?php foreach($eye_color_list as $elist) { ?>
									<option class="option" value="<?php echo $elist; ?>"><?php echo $this->lang->line($elist); ?></option>
									<?php } ?>
								</select>
								<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Eleventh step -->

	  		<!-- Twelth step for Registration -->
	  		<div class="none twelve" id="whr_frm">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('ethnic_affiliation'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm">					
						<div class="col-md-12 col-lg-12 col-xs-12">
							<label><?php echo $this->lang->line('ethnic_affiliation'); ?></label>
							<div class="select">
								<select name="user_ethnicity">
									<?php foreach($ethnicity_list as $ethnicity) { ?>
									<option class="option" value="<?php echo $ethnicity; ?>"><?php echo $this->lang->line($ethnicity); ?></option>
									<?php } ?>
								</select>
								<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Twelth step -->

	  		<!-- Thirteenth step for Registration -->
	  		<div class="none thirteen" id="whr_frm">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('job'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm">					
						<div class="col-md-12 col-lg-12 col-xs-12">
							<label><?php echo $this->lang->line('job'); ?></label>
							<div class="select">
								<select name="user_job">
									<?php foreach($job_list as $job) { ?>
									<option class="option" value="<?php echo $job; ?>"><?php echo $this->lang->line($job); ?></option>
									<?php } ?>
								</select>
								<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Thirteenth step -->

	  	  	<!-- Fourteenth step for Registration -->
	  		<div class="none fourteen">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('smoker'); ?>:</div>
				<div class="selection_div whr_btn">
					<div class="row">		
						<label class="control control--radio col-md-3 col-xs-12"><?php echo $this->lang->line('yes'); ?>
							<input type="radio" name="user_is_smoker" value="yes" />
							<div class="control__indicator"></div>
						</label>
						<label class="control control--radio col-md-3 col-xs-12"><?php echo $this->lang->line('no'); ?>
							<input type="radio" name="user_is_smoker" value="no" />
							<div class="control__indicator"></div>
						</label>
						<label class="control control--radio col-md-6 col-xs-12"><?php echo $this->lang->line('occasionally'); ?>
							<input type="radio" name="user_is_smoker" value="occasionally" />
							<div class="control__indicator"></div>
						</label>
						<div class="col-md-12 form-error error-box-message"></div>
						<div class="btn_box arrngmnt">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Fourteenth step -->

	  		<!-- Fifteenth step for Registration -->
	  		<div class="none fifteen">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('children'); ?>:</div>
				<div class="selection_div whr_btn">
					<div class="row">		
						<label class="control control--radio col-md-6"><?php echo $this->lang->line('yes'); ?>
							<input type="radio" name="user_has_child" value="yes" />
							<div class="control__indicator"></div>
						</label>
						<label class="control control--radio col-md-3"><?php echo $this->lang->line('no'); ?>
							<input type="radio" name="user_has_child" value="no" />
							<div class="control__indicator"></div>
						</label>
						<div class="col-md-12 form-error error-box-message"></div>
						<div class="btn_box arrngmnt">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End fifteenth step -->

	  		<!-- Sixteenth step for Registration -->
	  		<div class="none sixteen" id="sport_div">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('sport'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm sports_div">					
						<div class="col-md-12 col-lg-12 col-xs-12 sprt_cl sp_div" id="sprt_cl_div">
							<label><?php echo $this->lang->line('sport'); ?></label>
							<div class="select">
								<select name="user_sports" class="add_sport_drop">
								<?php 
									if(!empty($sports)) { 
										foreach($sports as $sport) {
								?>
									<option class="option" value="<?php echo $sport['sport_id']; ?>"><?php echo $this->lang->line($sport['sport_name']); ?></option>
								<?php 	} 
									} else {
								?>
									<option class="option" value="none"><?php echo $this->lang->line('none'); ?></option>
								<?php
									} 
								?>
								</select>
							</div>			
							<img id="add-user-sport" src="<?php echo base_url('images/add.png'); ?>" alt="<?php echo $this->lang->line('white_plus_icon'); ?>" class="add-sport">	
						</div>
						<div class="col-md-12 col-lg-12 col-xs-12 sprt_cl sp_div" id="sports_selected_items">							
						</div>
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Sixteenth step -->

	  		<!-- Seventeenth step for Registration -->
	  		<div class="none seventeen">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('interests'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm sports_div">					
						<div class="col-md-12 col-lg-12 col-xs-12 sprt_cl">
							<label><?php echo $this->lang->line('interests'); ?></label>
							<div class="select">
								<select name="user_interests">
									<?php 
										if(!empty($interests)) { 
											foreach($interests as $interest) {
									?>
										<option class="option" value="<?php echo $interest['interest_id']; ?>"><?php echo $this->lang->line($interest['interest_name']); ?></option>
									<?php 	} 
										} else {
									?>
										<option class="option" value="none"><?php echo $this->lang->line('none'); ?></option>
									<?php
										} 
									?>
								</select>
							</div>			
							<img id="add-user-interest" src="<?php echo base_url('images/add.png'); ?>" alt="<?php echo $this->lang->line('white_plus_icon'); ?>" class="add-sport">	
						</div>
						<div class="col-md-12 col-lg-12 col-xs-12 sprt_cl sp_div" id="interests_selected_items">
						</div>						
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
				</div>
      		</div>
	  		<!-- End Seventeenth step -->

	  		<!-- Eighteenth step for Registration -->
	  		<div class="none eighteen">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('languages'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm sports_div">					
						<div class="col-md-12 col-lg-12 col-xs-12 sprt_cl">
							<label><?php echo $this->lang->line('languages'); ?></label>
							<div class="select">
								<select name="user_languages">
									<?php 
										if(!empty($language_list)) {
											foreach($language_list as $lang) {
									?>
										<option class="option" value="<?php echo $lang['language_id']; ?>"><?php echo $this->lang->line($lang['language_name']); ?></option>
									<?php 	} 
										} 
									?>
								</select>
								<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
							</div>			
							<img id="add-user-language" src="<?php echo base_url('images/add.png'); ?>" alt="<?php echo $this->lang->line('white_plus_icon'); ?>" class="add-sport">	
						</div>
						<div class="col-md-12 col-lg-12 col-xs-12 sprt_cl sp_div" id="languages_selected_items">
						</div>						
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
				</div>
      		</div>
	  		<!-- End Eighteenth step -->

	   		<!-- Nineteenth step for Registration -->
	  		<div class="none nineteen" id="descrption">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('my_description'); ?>:</div>
				<div class="selection_div">
					<div class="row email_box whr_frm">					
						<div class="col-md-12 col-lg-12 col-xs-12">
							<label><?php echo $this->lang->line('my_description'); ?></label>
							<textarea class="form-control" name="my_description" placeholder="<?php echo $this->lang->line('write_your_information_here'); ?>" rows="5" id="description"></textarea>
						<!--<input class="email_add" placeholder="Hellblond">		-->
						</div>
						<div class="col-md-12 form-error error-box-message"></div>
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- End Nineteenth step -->

	   		<!-- Twentyth step for Registration -->
	  		<div class="none twenty" id="descrption">
        		<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase">
					<?php echo $this->lang->line('how_can_man_impress_you'); ?>:
				</div>
				<div class="selection_div">
					<div class="row email_box whr_frm">					
						<div class="col-md-12 col-lg-12 col-xs-12">
							<label><?php echo $this->lang->line('how_can_man_impress_you'); ?>:</label>
							<textarea class="form-control" name="how_can_man_impress_you" placeholder="<?php echo $this->lang->line('write_your_information_here'); ?>" rows="5" id="description"></textarea>
						</div>
						<div class="col-md-12 form-error error-box-message"></div>
						<div class="clearfix"></div>
						<div class="btn_box haarf">
							<a href="#" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('continue'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
	  		<!-- END Twentyth step -->

	  		<!-- TwentyOneth step for Registration -->
	  		<div class="none twentyone" id="upld_prfile">
	        	<div class="text-center gold-txt reg-title text-uppercase"><?php echo $this->lang->line('create_your_account'); ?></div>			 
				<h3 class="register_title"><?php echo $this->lang->line('join_us_txt'); ?></h3>
				<div class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('upload_profile_picture'); ?>:</div>
				<div class="selection_div">
					<div class="row">		
						<div class="col-md-12 text-center">
							<p class="help-block" style="color: white;font-weight: 400;font-size: 16.49px;"><?php echo $this->lang->line('pornographic_pictures_upload_warning_info_text'); ?></p>
							<div class="avatar-upload">
								<div class="avatar-edit">
									<input type='file' name="user_photo" id="imageUpload" accept=".png, .jpg, .jpeg" onchange="showUserImage(this);" />
									<label for="imageUpload" class="imageUpload respImageUploadSignupPart">
									<h4 class="upld_lbl"><?php echo $this->lang->line('upload_photo'); ?></h4>
									</label>
								</div>
								<div class="avatar-preview" id="imageAvatarPreview" style="display: none;">
									<div id="imagePreview" style="background-image: url(<?php echo base_url('images/avatar/male.png'); ?>);">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<label class="control control--radio  agb_lbl"><?php echo $this->lang->line('legal_age_terms'); ?>
									<input type="radio" name="legal_age_terms_conds" value="yes"  />
									<div class="control__indicator"></div>
								</label>
							</div>
						</div>
						<div class="col-md-12 form-error error-box-message"></div>
						<div class="btn_box">
							<a href="#" class="continue_btn btn-register btn_hover"><span class="cont_span"><?php echo $this->lang->line('register'); ?></span></a>
						</div>
					</div>
      			</div>
      		</div>
			<!-- End TwnetyOneth step -->
	  		     		
    		</div>
			<div class="modal-footer"></div>
		</div>		
	</div>
</div>

<!-- Free Credits for First Registration Modal -->
<div class="modal fade transparent_mdl" id="freeCreditsModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>         
        </div>
        <div class="modal-body">
          <h4 class="full-pay gold-txt text-center"><span class="sign_span"><?php echo $this->lang->line('thank_you_for_registering_on'); ?></span></h4>
			<h3 class="register_title"><?php echo $this->lang->line('with_your_registration_you_will_receive_once'); ?></h3>
			<h3 class="freeCrdts"><?php echo $settings['free_credits'].' '.$this->lang->line('credits_for_free'); ?>.</h3>
			<p class="thnkP"><?php echo $this->lang->line('credits_first_text'); ?></p>
			<div class="thnkDvder" style="width: auto !important;"></div>
			<p class="thnkP"><?php echo $this->lang->line('credits_second_text'); ?></p>
		 	<div class="notesDiv">
				<a href="<?php echo base_url('user/home'); ?>" class="continue_btn RegBtn register_btn btn_hover"><span class="cont_span"><?php echo $this->lang->line('back_to_homepage'); ?></span></a>
		 	</div>
        </div>
      </div>      
    </div>
  </div>
<!-- END: Free Credits for First Registration Modal -->

<script type="text/javascript">	
	function showUserImage(input) {
		//var input = $(this);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result+')');
                $('#imageAvatarPreview').show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

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
</script>