<?php
	$this->load->view('templates/headers/main_header', $title);
	//$this->load->view('templates/sidebar/main_sidebar');
	$qdata['questions'] = $questions;
	$this->load->view('templates/sidebar/main_modal', $qdata);
?>

<?php if($this->session->has_userdata('message')) { ?>
<section class="messages">
	<div class="alert tag-alert-golden alert-dismissible fade in">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php echo $this->lang->line($this->session->userdata('message')); $this->session->unset_userdata('message'); ?>
	</div>
</section>
<?php } ?>

<!--profile slider-->
<section class="breacrum_section common_back">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo $this->session->userdata('back_url'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_search_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="profile_section" id="profile_view">	
	<?php if($user_row['user_status'] == 'deleted') { ?> 
		<div class="deletion-stamp-view"><?php echo $this->lang->line($user_row['user_status']); ?></div>
	<?php } else { ?>
	<div class="container profile_data" rel="<?php echo $user_row['user_id_encrypted']; ?>">
		<div class="row">
			<div class="col-md-7">
				<div id="example5" class="slider-pro">
					<div class="sp-slides">
					<?php 						
						if(!empty($user_photos)) { 
							foreach ($user_photos as $photo_row) {
								$show_become_vip_window = false;
								$show_image_unlock_window = false;
								if($photo_row['photo_type'] == 'vip' && $this->session->userdata('user_is_vip') == 'no') {
									$show_become_vip_window = true;
									$blur_style = "filter: blur(5px);-webkit-filter: blur(5px);";
									//$image_url = base_url('user/profile/blurPicture/'.$photo_row['photo_id']);
									$image_url = base_url($photo_row['photo_thumb_url']);
								} else if($photo_row['photo_type'] == 'private' && !in_array($photo_row['photo_id'], $user_unlocked_photo_arr)) {
									// show unlocked images
									$show_image_unlock_window = true;
									$blur_style = "filter: blur(5px);-webkit-filter: blur(5px);";
									//$image_url = base_url('user/profile/blurPicture/'.$photo_row['photo_id']);
									$image_url = base_url($photo_row['photo_thumb_url']);
								} else {
									$blur_style = "";
									$back_image_url = '';
									$image_url = base_url($photo_row['photo_url']);
								}
						?>
						<div class="sp-slide">
							<img style="background-repeat: no-repeat;background-size: 100% 100%;<?php echo $blur_style; ?>" data-id="<?php echo $photo_row['photo_id']; ?>" class="sp-image" 
							src="<?php echo $image_url; ?>" 
							data-src="<?php echo $image_url; ?>" 
							data-retina="<?php echo $image_url; ?>" />

							<?php if($show_become_vip_window == true): ?>
							<div style="position: absolute;left: 0px;top: 0px;height: 100%;width: 100%;background-color: #0009;">
								<center>
									<img src="<?php echo base_url('images/basis-usr-gold.png'); ?>" class="UserStImg">
									<br>
									<h3 class="text-center resp_font_23"><?php echo $this->lang->line('only_visible_to_vip_members'); ?></h3>
									<br>
									<a href="<?php echo base_url('user/vip'); ?>" class="buy_nw_credit btn_hover"><?php echo $this->lang->line('become_a_vip_now'); ?></a>
								</center>
							</div>
							<?php endif; ?>

							<?php if($show_image_unlock_window == true): ?>
							<div style="position: absolute;left: 0px;top: 0px;height: 100%;width: 100%;background-color: #0009;">
								<center>
									<br><br><br><br>
									<img src="<?php echo base_url('images/unlock_user_photo_screen_thumb.png'); ?>" class='secret_icon_resp' style="width: 56px;">
									<br>
									<h3 class="text-center resp_font_23"><?php echo $this->lang->line('send_image_unlock_request_to_this_user'); ?></h3>
									<br>
									<a class="buy_nw_credit btn_hover btn-images-unlock-request"><?php echo $this->lang->line('unlock_request'); ?></a>
								</center>
							</div>
							<?php endif; ?>

						</div>
					<?php 		//}
							}							
						} else {
					?>
						<div class="sp-slide">
							<?php 
								$avatar = "images/avatar/".$user_row['user_gender'].".png";
							?>
							<img data-id="" class="sp-image" src="<?php echo base_url('images/no_img.png'); ?>"
								data-src="<?php echo base_url($avatar); ?>"
								data-retina="<?php echo base_url($avatar); ?>" />
						</div>
					<?php 							
						}
					?>
					</div>

					<div class="sp-thumbnails">
					<?php 
						if(!empty($user_photos)) { 
							$private_cnt = 1;
							foreach ($user_photos as $photo_row) {								
								if($photo_row['photo_type'] == 'vip' && $this->session->userdata('user_is_vip') == 'no') {
									$back_image_url = base_url($photo_row['photo_thumb_url']);
									//$back_image_url = base_url('user/profile/blurPicture/'.$photo_row['photo_id']);
									$blur_style = "filter: blur(2px);-webkit-filter: blur(2px);";
									$image_url = base_url('images/for_vip_user_photo_screen_thumb.png');
									$block_img_css = 'padding:6px;';
								} else if($photo_row['photo_type'] == 'private' && !in_array($photo_row['photo_id'], $user_unlocked_photo_arr)) {
									$back_image_url = base_url($photo_row['photo_thumb_url']);
									$blur_style = "filter: blur(2px);-webkit-filter: blur(2px);";
									//$back_image_url = base_url('user/profile/blurPicture/'.$photo_row['photo_id']);
									$image_url = base_url('images/unlock_user_photo_screen_thumb.png');
									$block_img_css = 'padding:6px;';
								} else {
									$back_image_url = base_url($photo_row['photo_thumb_url']);
									$image_url = '';
									$block_img_css = '';
									$blur_style = "";
									//$image_url = base_url($photo_row['photo_thumb_url']);
									//$block_img_css = '';
								}
						?>						
						<div class="sp-thumbnail">
							<div class="sp-thumbnail-image-container">
								<?php if($photo_row['photo_type'] == 'private') { ?><div class="unlockCount"><?php echo $private_cnt++; ?></div><?php } ?>
								<img style="<?php echo $blur_style; ?>" class="sp-thumbnail-image" src="<?php echo $back_image_url; ?>"/>
								<img src="<?php echo $image_url; ?>" class="unlockImg"/>
							</div>
							<div class="sp-thumbnail-text">
								<div class="sp-thumbnail-title">Photo Title</div>
								<div class="sp-thumbnail-description">Photo Desc</div>
							</div>
						</div>

				<!-- 				<div class="sp-thumbnail">
							<div class="sp-thumbnail-image-container">
								<img class="sp-thumbnail-image" style="background-image: url('<?php echo $back_image_url; ?>'); background-repeat: no-repeat;background-size: 100% 100%;width: 100%;height: 60px;<?php echo $block_img_css; ?>" src="<?php echo $image_url; ?>"/>
							</div>
							<div class="sp-thumbnail-text">
								<div class="sp-thumbnail-title">Photo Title</div>
								<div class="sp-thumbnail-description">Photo Desc</div>
							</div>
						</div> -->
					<?php 
							}
						}
					?>
					</div>

    			</div>
				<div class="actions_div">
					<ul class="profile_actions">
						<li>
							<i class="flaticon-speech-bubbles-comment-option"></i>
							<i class="flaticon-kiss <?php echo ($is_kissed) ? 'active-icon-red':''; ?>"></i>
							<i class="flaticon-like <?php echo ($is_favorite) ? 'active-icon-yellow':''; ?>"></i>
							<i class="flaticon-question-speech-bubble"></i>
						</li>
						
<!-- 						<li class="ad_dmdns">
							<span class="ad_diamond"><?php echo $this->lang->line('add_diamonds'); ?> </span>
							<i class="flaticon-diamond"></i>
						</li>
						<li class="ad_dmdns">
							<span class="ad_diamond"><?php echo $this->lang->line('make_a_gift'); ?></span>
							<i class="flaticon-giftbox"></i>
						</li> -->
						
					</ul>
					
					
					<div class="btn_container">
						<div class="social_links"></div>
						<hr class="profile_hr hidden-sm hidden-md hidden-lg"/>
						<a class="action_btns continue_btn btn_hover btn-show-unlock-by-me-model"><?php echo $this->lang->line('unlock'); ?></a>
						<a class="action_btns continue_btn btn_hover btn-chat-unlock-request"><?php echo $this->lang->line('unlock_request'); ?></a>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="about_user">
					<?php if($user_row['user_about'] != '') { ?>
					<h4 class="abt_title"><?php echo ucfirst($this->lang->line('p_about')).' '.ucfirst($user_row['user_access_name']); ?></h4>
					<p><?php echo $user_row['user_about']; ?></p>
					<?php } ?>

					<?php if($user_row['user_gender'] == 'female' && $user_row['user_how_impress'] != '') { ?>
					<h4 class="abt_title">
						<?php echo $this->lang->line('how_can_man_impress_to'); ?>
					</h4>
					<p><?php echo $user_row['user_how_impress']; ?></p>
					<?php } ?>	
    			</div>
    		</div>
    		<div class="col-md-5">
				<div class="row">
				<div class="col-md-9 col-sm-9 col-xs-12 respUserNameProfile">
				<h3 class="usr_nm">
					<?php 
						// User Age
						$today = date_create(gmdate('Y-m-d H:i:s'));
						$user_birthday = date_create($user_row['user_birthday']);
						$user_age = date_diff($today, $user_birthday);

						echo $user_row['user_access_name'].' | '.$user_age->y; 

						$user_distance = round(distance($user_latitude, $user_longitude, $user_row['user_latitude'], $user_row['user_longitude']));

						if($user_row['user_last_activity_date'] == '') {
							$last_activity_date = date_create($user_row['user_register_date']);
						} else {
							$last_activity_date = date_create($user_row['user_last_activity_date']);
						}
						$user_online_ago = date_diff($today, $last_activity_date);
						//print_r($user_online_ago);

						$user_online_ago_str = '';						
						if($user_online_ago->y > 0) {
							if($user_online_ago->y == 1) {
								$user_online_ago_str = $user_online_ago->y.' '.$this->lang->line('year');
							} else {
								$user_online_ago_str = $user_online_ago->y.' '.$this->lang->line('years');
							}
						} elseif ($user_online_ago->m > 0) {
							if($user_online_ago->m == 1) {
								$user_online_ago_str = $user_online_ago->m.' '.$this->lang->line('month');
							} else {
								$user_online_ago_str = $user_online_ago->m.' '.$this->lang->line('months');
							}
						} elseif ($user_online_ago->d > 0) {
							if($user_online_ago->d == 1) {
								$user_online_ago_str = $user_online_ago->d.' '.$this->lang->line('day');
							} else {
								$user_online_ago_str = $user_online_ago->d.' '.$this->lang->line('days');
							}
						} elseif ($user_online_ago->h > 0) {
							if($user_online_ago->h == 1) {
								$user_online_ago_str = $user_online_ago->h.' '.$this->lang->line('hour');
							} else {
								$user_online_ago_str = $user_online_ago->h.' '.$this->lang->line('hours');	
							}
						} elseif ($user_online_ago->i > 0) {
							if($user_online_ago->i == 1) {
								$user_online_ago_str = $user_online_ago->i.' '.$this->lang->line('minute');
							} else {
								$user_online_ago_str = $user_online_ago->i.' '.$this->lang->line('minutes');
							}
						}

					?>
				</h3>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 respIconProfile">
				<div class="report_user pull-right">
					<span style="margin-right: 20px;" class='respDisLikeProfile'><i class="fa fa-thumbs-down fa-2x  <?php echo ($is_disliked) ? 'active-icon-red':'btn-user-dislike'; ?>"></i></span>
					<span><i class="fa fa-ban fa-2x <?php echo ($is_reported) ? 'active-icon-red':'btn-report-user'; ?>"></i></span>
				</div>
				</div>
				</div>
				<h4 class="plc"><?php echo $user_row['user_city'].', '.$user_row['user_country']; ?> - <?php echo $user_distance; ?> Km <?php //echo $this->lang->line('away'); ?></h3>
				<ul class="online_sts">
					<li><h6><?php if($user_online_ago_str != '') { echo $this->lang->line('online_before').' '.$user_online_ago_str; } else { echo $this->lang->line('online'); } ?> </h6></li>
					<li>						
						<h6 class="verifd">
							<?php if($user_row['user_verified'] == 'yes') { ?>
							<i class="flaticon-check"></i>
							<span><?php echo $this->lang->line('user_reality_verified'); ?></span>
							<?php } ?>
						</h6>
					</li>
				</ul>
				<div class="usr_info">
					<div class="clearfix"></div>
					<div class="row bottom_info">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('figure'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p"><?php echo $this->lang->line($user_row['user_figure']); ?></p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('size'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p"><?php if($user_row['user_height'] > 0) { echo $user_row['user_height'].' '.$this->lang->line('cm'); } ?></p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('job'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p"><?php echo $this->lang->line($user_row['user_job']); ?></p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('ethnicity'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p"><?php echo $this->lang->line($user_row['user_ethnicity']); ?></p>
						</div>

<!-- 						<?php if($user_row['user_gender'] == 'female') { ?>
							<div class="clearfix"></div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<h5 class="info_ttl"><?php echo $this->lang->line('arangement'); ?> :</h5>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6"></div>
							<?php 
								$selected_arrangement_arr = explode(',', $user_row['user_arangement']);
								if(count($selected_arrangement_arr) > 0) {
									foreach ($selected_arrangement_arr as $arrangement) {
							?>
							<div class="clearfix"></div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<p class="info_p"><?php echo $this->lang->line($arrangement); ?></p>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<p class="info_p"><?php //echo $user_row['user_monthly_budget']; ?></p>
							</div>
						<?php 		} 
								}
							}
						?> -->

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('hair_color'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p"><?php echo $this->lang->line($user_row['user_hair_color']); ?></p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('eye_color'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p"><?php echo $this->lang->line($user_row['user_eye_color']); ?></p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('smoker'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p"><?php echo $this->lang->line($user_row['user_smoker']); ?></p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('children'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p">
								<?php
									if($user_row['user_has_child'] == 'yes' && $user_row['how_many_childrens'] > 0) {
										echo $user_row['how_many_childrens'];
									} else {										
										echo $this->lang->line($user_row['user_has_child']); 	
									}
								?>									
								</p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('languages'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p">
								<?php
									$user_lang = array();
									if(!empty($user_spoken_languages)) {
										foreach ($user_spoken_languages as $i_row) {
											$user_lang[] = $this->lang->line($i_row['language_name']);
										}
									} 
									$user_lang_str = implode(' - ', $user_lang);
									echo $user_lang_str;
								?>								
							</p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('contact_request'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p">
								<?php
									if($user_row['interested_in_serious_relationship'] == 'yes') {
										echo $this->lang->line('serious_relationship_interested');
									} else {
										$user_con_reqs = array();
										if(!empty($user_contact_requests)) {
											foreach ($user_contact_requests as $i_row) {
												$user_con_reqs[] = $this->lang->line($i_row['contact_request_name']);
											}
										} 
										$user_con_reqs_str = implode(' - ', $user_con_reqs);
										echo $user_con_reqs_str;
									}
								?>
								</p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<h5 class="info_ttl"><?php echo $this->lang->line('interests'); ?> :</h5>
						</div>	
						<div class="col-md-6 col-sm-6 col-xs-6">			
							<p class="info_p">
								<?php
									$user_intes = array();
										if(!empty($user_interests)) {
											foreach ($user_interests as $i_row) {
												$user_intes[] = $this->lang->line($i_row['interest_name']);
											}
										} 
										$user_intes_str = implode(' - ', $user_intes);
										echo $user_intes_str; 
								?>
							</p>
						</div>

						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-6 clearfix">
							<h5 class="info_ttl"><?php echo $this->lang->line('sports'); ?> :</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<p class="info_p">
								<?php
									$user_spts = array();
									if(!empty($user_sports)) {
										foreach ($user_sports as $i_row) {
											$user_spts[] = $this->lang->line($i_row['sport_name']);
										}
									} 
									$user_sports_str = implode(' - ', $user_spts);
									echo $user_sports_str;
								?>
							</p>
						</div>
					</div>
				</div>
    		</div>
    	</div>
	<div class="bottom-effect"></div>
	<?php } ?>
</section>

<section class="wishlist_section proWishlist" id="wish_list">
	<div class="container">
	</div>
</section>
<!--profile slider-->
<!--Special Gift Section-->
<!--
<section class="wishlist_section" id="wish_list">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-right wlist_box">
				<h4 class="full-pay gold-txt"><span class="usr_wlist"><?php echo $user_row['user_access_name']; ?>’s Wishlist</span></h4>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile1.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="../../images/diamond-icon.png" class="diamondIcon"><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile2.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="../../images/diamond-icon.png" class="diamondIcon"><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
				<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile3.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="../../images/diamond-icon.png" class="diamondIcon"><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile4.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="../../images/diamond-icon.png" class="diamondIcon"><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile5.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="../../images/diamond-icon.png" class="diamondIcon"><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile6.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="../../images/diamond-icon.png" class="diamondIcon"><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>					
		</div>
		<div class="row">
			<div class="col-md-4 dotted_line_div"> 
				<span class="dotted_line"></span>
			</div>
			<div class="col-md-4 go_btn_col">			
				<a href="#" class="go_online_shop btn_hover" id="go_shop_btn">
				Go to the online Shop
				</a>
			</div>
			<div class="col-md-4 dotted_line_div"> 
				<span class="dotted_line"></span>
			</div>
		</div>
	</div>
	<div class="bottom-effect-black"></div>
</section>
-->
<!--Special Gift Section-->
<section class="wishlist_section" style="padding: 30px;">
</section>
<!--	
<section class="wishlist_section gift_section">
	<div class="container">
		<div class="row">			
			<div class="col-md-5 col-sm-5 col-xs-12 fulWidth">
				<h4 class="full-pay gold-txt"><span class="bygift">Buy a Special Gift
				for Your Sugababe</span><br/></h4>
				<h5 class="code_h5">#enjoytheshopping</h5>
				<p class="gift_p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea com</p>
				<h4 class="gift_h4">Original designer Bags, Jewelry	, Perfume, Clothing, High Heels and much more.</h4>

				<div class="row">	
					<div class="col-md-12 go_btn_col">			
						<a href="#" class="go_online_shop Rettangolo_2 btn_hover" id="bynw_crdt">Buy Now Credits</a>
					</div>		
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12 fulWidth">
				<img src="<?php echo base_url('images/gift.png'); ?>" class="img-responsive giftImg">
			</div>	
		</div>			
	</div>		
</section> 
-->
<?php
$this->load->view('templates/footers/main_footer');
?>
