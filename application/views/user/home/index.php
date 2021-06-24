<?php
$this->load->view('templates/headers/main_header', $title);
$this->load->view('templates/sidebar/main_sidebar');
$qdata['questions'] = $questions;
$this->load->view('templates/sidebar/main_modal', $qdata);
?>
<?php if($this->session->flashdata('message')) { ?>
<section class="messages">
	<div class="alert tag-alert-golden alert-dismissible fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php echo $this->lang->line($this->session->flashdata('message')); ?>
	</div>
</section>
<?php } ?>

<section class="wishlist_section profile_section_home" id="profile_sectionDiv">
	<form action="" method="POST" id="searchForm">
		<div class="container filter_container">
			<div class="row filter_row" id="filter_row">
				<div class="col-md-4 col-sm-12 pad_right_zero srchByLoc">
					<div class="locationBx">
						<input id="location_input" type="text" value="<?php echo(!isset($this->session->userdata("home_search_parameters")['location']))? '': $this->session->userdata("home_search_parameters")['location']; ?>" class="form-control" name="location" placeholder="<?php echo $this->session->userdata('user_city'); ?>">
						<img src="<?php echo base_url('images/location_i.png'); ?>" class="location_i">

						<input type="hidden" id="location_latitude" name="location_latitude" value="<?php echo(!isset($this->session->userdata("home_search_parameters")['location_latitude']))? $this->session->userdata('user_latitude'): $this->session->userdata("home_search_parameters")['location_latitude']; ?>">
						<input type="hidden" id="location_longitude" name="location_longitude" value="<?php echo(!isset($this->session->userdata("home_search_parameters")['location_longitude']))? $this->session->userdata('user_longitude'): $this->session->userdata("home_search_parameters")['location_longitude']; ?>">
					</div>
				</div>
				<div class="col-md-2 col-sm-6 age_range">
					<?php $age_range = explode(',', SEARCH_AGE_RANGE); ?>
					<label class="ttl_lbl"><?php echo $this->lang->line('age_range'); ?></label>
					<input id="ex2" type="text" name="age_range" class="span2" value="<?php echo(!isset($this->session->userdata("home_search_parameters")['age_range']))? SEARCH_AGE_RANGE: $this->session->userdata("home_search_parameters")['age_range']; ?>" data-slider-min="<?php echo $age_range[0]; ?>" data-slider-max="<?php echo $age_range[1]; ?>" data-slider-step="1" data-slider-value="[<?php echo(!isset($this->session->userdata("home_search_parameters")['age_range']))? SEARCH_AGE_RANGE: $this->session->userdata("home_search_parameters")['age_range']; ?>]"
					data-slider-ticks-labels='["<?php echo $age_range[0].' '.$this->lang->line('age'); ?>", "<?php echo $age_range[1].' '.$this->lang->line('age'); ?>"]'/>
				</div>
				<div class="col-md-2 col-sm-6 km_range searchBtns">
					<?php $distance_range = explode(',', SEARCH_DISTANCE_RANGE); ?>
					<label class="ttl_lbl"><?php echo $this->lang->line('distance'); ?></label>
					<input id="ex3" type="text" class="span2" value="<?php echo(!isset($this->session->userdata("home_search_parameters")['distance']))? SEARCH_DISTANCE_RANGE : $this->session->userdata("home_search_parameters")['distance']; ?>" name="distance" data-slider-min="<?php echo $distance_range[0]; ?>" data-slider-max="<?php echo $distance_range[1]; ?>" data-slider-step="1" data-slider-value="[<?php echo(!isset($this->session->userdata("home_search_parameters")['distance']))? SEARCH_DISTANCE_RANGE: $this->session->userdata("home_search_parameters")['distance']; ?>]" data-slider-ticks-labels='["<?php echo $distance_range[0]; ?> Km", "<?php echo $distance_range[1]; ?> Km"]' />
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-3 col-sm-6 searchBtns">
					<div class="text-right search_div">
						<button type="submit" name="btn-search" class="btn-login-ok save_search next member-login-a btn_hover"><span class="search_span"><?php echo $this->lang->line('search'); ?></span></button>
						<button type="submit" name="btn-saved-search" class="btn-login-ok save_search next member-login-a btn_hover"><span class="search_span"><?php echo $this->lang->line('saved_search'); ?></span></button>
						<label class="advnc_srch"><?php echo $this->lang->line('advance_search'); ?></label>
						<div class="cls_advnc_srch"><span class="close_adsrch"><?php echo $this->lang->line('close_advance_search'); ?></span>X</div>
					</div>
				</div>
			</div>
		</div>

		<?php 
		if($this->session->has_userdata("home_search_type")) {

			$search_params = $this->session->userdata("home_search_parameters");
			$search_text_arr = array();

			if(!empty($search_params['location'])) {
				$search_text_arr[] = '<span class="srcfirst">'.$search_params['location'].'</span>';
			}

			$age_range = explode(',', $search_params['age_range']);
			$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('age').':</span> <span class="srclast">'.$age_range[0].' '.$this->lang->line('to').' '.$age_range[1].' '.$this->lang->line('year').'</span>';

			$distance = explode(',', $search_params['distance']);
			$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('distance').':</span> <span class="srclast">'.$distance[0].' '.$this->lang->line('to').' '.$distance[1].' KM</span>';

			if($this->session->userdata("home_search_type") == 'advanced') {
				$size_range = explode(',', $search_params['size_range']);
				$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('size').':</span> <span class="srclast">'.$size_range[0].' to '.$size_range[1].'</span>';          
				if(!empty($search_params['figure'])) {
					$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('figure').':</span> <span class="srclast">'.$this->lang->line($search_params['figure']).'</span>';
				}
				if(!empty($search_params['ethnicity'])) {
					$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('ethnicity').': '.$this->lang->line($search_params['ethnicity']).'</span>';
				}
				if(!empty($search_params['hair_color'])) {
					$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('hair_color').':</span> <span class="srclast">'.$this->lang->line($search_params['hair_color']).'</span>';
				}
				if(!empty($search_params['eye_color'])) {
					$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('eye_color').':</span> <span class="srclast">'.$this->lang->line($search_params['eye_color']).'</span>';
				}
				if(!empty($search_params['smoker'])) {
					$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('smoker').':</span> <span class="srclast">'.$this->lang->line($search_params['smoker']).'</span>';
				}
				if(!empty($search_params['activity_and_quality'])) {
					$activity_and_quality_arr = explode(',', $search_params['activity_and_quality']);
					$activity_and_quality_txt = array();

					foreach ($activity_and_quality_arr as $act) {
						$activity_and_quality_txt[] = $this->lang->line($act);
					}
					$search_text_arr[] = '<span class="srcfirst">'.$this->lang->line('activity_and_quality').':</span> <span class="srclast">'.implode(', ', $activity_and_quality_txt).'</span>';
				}
			}
		?>
		<div class="container">
			<div class="clearfix"></div>
			<div class="col-sm-12">
				<div class="searchResultText text-center">
				<?php 
					if($this->session->userdata("using_saved_search") == true) {
						echo $this->lang->line('saved_search_results').': '.implode(', ', $search_text_arr);   
					} else {
						echo $this->lang->line('search_results').': '.implode(', ', $search_text_arr);
					}            
				?>
				</div>
			</div>
		</div>
		<?php } ?>

		<div class="container homeContainer">
			<div class="row filter_row advnc_srch_div" id="advance_filter">
				<div class="col-md-12">
					<h4 class="full-pay gold-txt suche">
						<span class="sgn_fr"><?php echo $this->lang->line('advanced_search'); ?></span>
					</h4>
				</div>
				<div class="col-md-7 col-sm-12 pad_right_zero">
					<div class="row adSrow">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<h4 class="kontaktwunsch"><?php echo $this->lang->line('contact_desired'); ?></h4>
							<?php 
							if(!empty($contact_requests)) {
								$selected_contact_req = array();
								if(isset($this->session->userdata("home_search_parameters")['contact_request'])) {
									$selected_contact_req = explode(',', $this->session->userdata("home_search_parameters")['contact_request']);
								}
								foreach($contact_requests as $req) {
							?>
								<label class="control control--radio col-md-12"><?php echo $this->lang->line($req['contact_request_name']); ?>
									<input type="checkbox" name="contact_request[]" value="<?php echo $req['contact_request_id']; ?>" <?php if(isset($this->session->userdata("home_search_parameters")['contact_request'])) { echo(in_array($req['contact_request_id'], $selected_contact_req))?'checked':''; } ?> />
									<div class="control__indicator"></div>
								</label>
							<?php } 
								} 
							?>        
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<h4 class="kontaktwunsch"><?php echo $this->lang->line('activity_and_quality'); ?></h4>
							<?php 
								$selected_act_quality = array();
								if(isset($this->session->userdata("home_search_parameters")['activity_and_quality'])) {
									$selected_act_quality = explode(',', $this->session->userdata("home_search_parameters")['activity_and_quality']);
								}
							?>
							<!--checkboxes-->
							<label class="control control--radio col-md-12">
								<?php echo $this->lang->line('only_members_with_photo'); ?>
								<input type="checkbox" name="activity_and_quality[]" value="only_members_with_photo" <?php if(isset($this->session->userdata("home_search_parameters")['activity_and_quality'])) { echo(in_array('only_members_with_photo', $selected_act_quality))?'checked':''; } ?>>
								<div class="control__indicator"></div>
							</label>
							<label class="control control--radio col-md-12">
								<?php echo $this->lang->line('only_new_members'); ?>
								<input type="checkbox" name="activity_and_quality[]" value="only_new_members" <?php if(isset($this->session->userdata("home_search_parameters")['activity_and_quality'])) { echo(in_array('only_new_members', $selected_act_quality))?'checked':''; } ?>>
								<div class="control__indicator"></div>
							</label>      
							<label class="control control--radio col-md-12">
								<?php echo $this->lang->line('available_online'); ?>
								<input type="checkbox" name="activity_and_quality[]" value="available_online" <?php if(isset($this->session->userdata("home_search_parameters")['activity_and_quality'])) { echo(in_array('available_online', $selected_act_quality))?'checked':''; } ?>>
								<div class="control__indicator"></div>
							</label>      
							<label class="control control--radio col-md-12">
								<?php echo $this->lang->line('only_vip_members'); ?>
								<input type="checkbox" name="activity_and_quality[]" value="only_vip_members" <?php if(isset($this->session->userdata("home_search_parameters")['activity_and_quality'])) { echo(in_array('only_vip_members', $selected_act_quality))?'checked':''; } ?>>
								<div class="control__indicator"></div>
							</label>       
							<label class="control control--radio col-md-12">
								<?php echo $this->lang->line('only_verified_members'); ?>
								<input type="checkbox" name="activity_and_quality[]" value="only_verified_members" <?php if(isset($this->session->userdata("home_search_parameters")['activity_and_quality'])) { echo(in_array('only_verified_members', $selected_act_quality))?'checked':''; } ?>>
								<div class="control__indicator"></div>
							</label>		
						</div>
					</div>

					<div class="advnce_divdr clearfix MobDivider"></div>
				</div>

				<div class="col-md-5 col-sm-12 age_range col-xs-12" id="advnc_fltr">
					<div class="row">
						<div class="col-md-12">
							<?php $size_range = explode(',', SEARCH_HEIGHT_RANGE); ?>
							<label class="grobe heightLbl"><?php echo $this->lang->line('size'); ?></label>
							<input id="ex4" type="text" class="span2" name="size_range" value="<?php echo(!isset($this->session->userdata("home_search_parameters")['size_range']))? SEARCH_HEIGHT_RANGE : $this->session->userdata("home_search_parameters")['size_range']; ?>" data-slider-min="<?php echo $size_range[0]; ?>" data-slider-max="<?php echo $size_range[1]; ?>" data-slider-step="1" data-slider-value="[<?php echo(!isset($this->session->userdata("home_search_parameters")['size_range']))? SEARCH_HEIGHT_RANGE : $this->session->userdata("home_search_parameters")['size_range']; ?>]"
							data-slider-ticks-labels='["<?php echo $size_range[0]; ?> Cm", "<?php echo $size_range[1]; ?> Cm"]'/>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label><?php echo $this->lang->line('figure'); ?></label>
							<div class="select">
								<select name="figure">
									<option class="option" value="" selected="true"><?php echo $this->lang->line('all'); ?></option>
									<?php foreach($figure_list as $figure) { ?>
									<option class="option" value="<?php echo $figure; ?>" <?php if(isset($this->session->userdata("home_search_parameters")['figure'])) { echo($this->session->userdata("home_search_parameters")['figure'] == $figure)?'selected':''; } ?>><?php echo $this->lang->line($figure); ?></option>
									<?php } ?>
								</select>
								<div class="select__arrow">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label><?php echo $this->lang->line('ethnicity'); ?></label>
							<div class="select">
								<select name="ethnicity">
									<option class="option" value="" selected="true"><?php echo $this->lang->line('all'); ?></option>
									<?php foreach($ethnicity_list as $ethnicity) { ?>
									<option class="option" value="<?php echo $ethnicity; ?>" <?php if(isset($this->session->userdata("home_search_parameters")['ethnicity'])) { echo($this->session->userdata("home_search_parameters")['ethnicity'] == $ethnicity)?'selected':''; } ?>><?php echo $this->lang->line($ethnicity); ?></option>
									<?php } ?>
								</select>
								<div class="select__arrow">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label><?php echo $this->lang->line('hair_color'); ?></label>
							<div class="select">
								<select name="hair_color">
									<option class="option" value="" selected="true"><?php echo $this->lang->line('all'); ?></option>
									<?php foreach($hair_color_list as $hlist) { ?>
									<option class="option" value="<?php echo $hlist; ?>" <?php if(isset($this->session->userdata("home_search_parameters")['hair_color'])) { echo($this->session->userdata("home_search_parameters")['hair_color'] == $hlist)?'selected':''; } ?>><?php echo $this->lang->line($hlist); ?></option>
									<?php } ?>
								</select>              
								<div class="select__arrow">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label><?php echo $this->lang->line('languages'); ?></label>
							<div class="select">
								<select name="user_languages">
									<option class="option" value="" selected="true"><?php echo $this->lang->line('all'); ?></option>
									<?php 
									if(!empty($languages)) {
										foreach($languages as $language) {
											?>
											<option class="option" value="<?php echo $language['language_id']; ?>" <?php if(isset($this->session->userdata("home_search_parameters")['user_languages'])) { echo($this->session->userdata("home_search_parameters")['user_languages'] == $language['language_id'])?'selected':''; } ?>><?php echo $this->lang->line($language['language_name']); ?></option>
											<?php   } 
										} 
										?>
								</select>
								<div class="select__arrow">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label><?php echo $this->lang->line('eye_color'); ?></label>
							<div class="select">
								<select name="eye_color">
									<option class="option" value="" selected="true"><?php echo $this->lang->line('all'); ?></option>
									<?php foreach($eye_color_list as $elist) { ?>
									<option class="option" value="<?php echo $elist; ?>" <?php if(isset($this->session->userdata("home_search_parameters")['eye_color'])) { echo($this->session->userdata("home_search_parameters")['eye_color'] == $elist)?'selected':''; } ?>><?php echo $this->lang->line($elist); ?></option>
									<?php } ?>
								</select>
								<div class="select__arrow">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label><?php echo $this->lang->line('smoker'); ?></label>
							<div class="select">
								<select name="smoker">
									<option class="option" value="" selected="true"><?php echo $this->lang->line('all'); ?></option>
									<option class="option" value="yes" <?php if(isset($this->session->userdata("home_search_parameters")['smoker'])) { echo($this->session->userdata("home_search_parameters")['smoker'] == 'yes')?'selected':''; } ?>><?php echo $this->lang->line('yes'); ?></option>
									<option class="option" value="no" <?php if(isset($this->session->userdata("home_search_parameters")['smoker'])) { echo($this->session->userdata("home_search_parameters")['smoker'] == 'no')?'selected':''; } ?>><?php echo $this->lang->line('no'); ?></option>
									<option class="option" value="occasionally" <?php if(isset($this->session->userdata("home_search_parameters")['smoker'])) { echo($this->session->userdata("home_search_parameters")['smoker'] == 'occasionally')?'selected':''; } ?>><?php echo $this->lang->line('occasionally'); ?></option>
								</select>
								<div class="select__arrow">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">		
					<div class="row ">
						<div class="col-md-12">
							<h4 class="kontaktwunsch"><?php echo $this->lang->line('i_am_only_at_one'); ?></h4>
						</div>
						<div class="col-md-12">
							<label class="control control--radio col-md-12 interest">
								<?php echo $this->lang->line('serious_relationship_interested'); ?>
								<input type="radio" name="serious_relationship" value="yes" <?php if(isset($this->session->userdata("home_search_parameters")['serious_relationship'])) { echo($this->session->userdata("home_search_parameters")['serious_relationship'] == 'yes')?'checked':''; } ?>>
								<div class="control__indicator"></div>
							</label>
						</div>
					</div>
				</div>

				<div class="row">
				<?php 
					// if saved search present then can only delete your search
					$hide_delete_class = 'hidden';
					if($this->session->has_userdata("using_saved_search")) {
						if($this->session->userdata("using_saved_search") == true) {
							$hide_delete_class = '';
						}
					}
				?>
					<div class="col-md-4 col-sm-4 <?php echo $hide_delete_class; ?>">
						<div class="text-right search_div">
							<button type="submit" name="btn-delete-search" class="continue_btn next" id="suche"><span class="cont_span"><?php echo $this->lang->line('delete_search'); ?></span></button>
						</div>
					</div> 
					<div class="col-md-4 col-sm-4">
						<div class="text-right search_div">
							<button type="submit" name="btn-save-search" class="continue_btn next" id="suche"><span class="cont_span"><?php echo $this->lang->line('save_search'); ?></span></button>
						</div>
					</div> 
					<div class="col-md-4 col-sm-4">
						<div class="text-right search_div">
							<button type="submit" name="btn-start-search" class="continue_btn next" id="suche"><span class="cont_span"><?php echo $this->lang->line('start_search'); ?></span></button>
						</div>
					</div>

				</div>
				<div class="col-xs-18 col-sm-12 col-md-12 profile_divider"></div>
			</div>

			<input type="hidden" name="is_home_page" id="is_home_page" value="yes">

			<div class="row" id="profile_view">
			<?php 
				if(!empty($users)) {
					foreach ($users as $user_row) {
						// User Age
			?>
<!-- 				<div class="col-xs-18 col-sm-6 col-md-3 col-xs-6 <?php if($user_row["is_online"] == true): ?>isOnineNow<?php endif; ?>">
					<div class="profile_thumbnail profile_data" rel="<?php echo $user_row['user_id_encrypted']; ?>">
						<a id="img_<?php echo $user_row['user_id']; ?>" href="<?php echo base_url('user/profile/view?query=').urlencode($user_row['user_id_encrypted']); ?>" class="profile_a">

							<?php if($user_row["is_online"] == true): ?>
							<span class="onoffStatusSpn os"><?php echo $this->lang->line('online'); ?></span>
							<?php endif; ?>

							<?php if($user_row["is_new"] == true): ?>
							<span class="newuser-icon"><?php echo $this->lang->line('new'); ?></span>
							<?php endif; ?>

							<img src="<?php echo base_url().$user_row['user_active_photo_thumb']; ?>" alt="">
							<div class="inner_div imghvr-shutter-out-horiz">
								<h4><?php echo $this->lang->line('view_profile'); ?></h4>
							</div>
						</a>
						<div class="caption">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h4 class="pro_name">
										<?php echo $user_row['user_access_name']; ?> | 
										<?php echo $user_row['user_age']; ?>
									</h4>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h4 class="loc_km">
										<span class="km">
											<?php echo $user_row['distance']; ?>km - 
											<span class="city">
												<?php echo $user_row['user_city']; ?>
											</span>
										</span>
									</h4>
								</div>
							</div>
							<hr class="pro_hr" />
							<div class="row">
								<div class="actions_div">
									<ul class="profile_actions">
										<li>
											<a href="#" data-tooltip="Questions" data-position="bottom" class="bottom">
												<i class="flaticon-speech-bubbles-comment-option"></i>
											</a>
											<i class="flaticon-kiss 
												<?php echo ($user_row['is_kissed']) ? 'active-icon-red':''; ?>">
											</i>
											<i class="flaticon-like 
											<?php echo ($user_row['is_favorite']) ? 'active-icon-yellow':''; ?>">
											</i>
											<i class="flaticon-question-speech-bubble"></i>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<?php if($user_row['user_is_vip'] == 'yes') { ?>
						<img src="<?php echo base_url('images/vip_icon.png'); ?>" class="vip_icon" alt="">
						<?php } ?>
					</div>
				</div> -->
				<?php 
					}	
				} else {
					?>
<!-- 				<div class="text-center" style="color: white;">
					<?php echo $this->lang->line('no_one_found'); ?>
				</div> -->
				<?php
				}
				?>
			</div>
			<div class="col-xs-18 col-sm-12 col-md-12 profile_divider"></div>
		</div>
		<div class="bottom-effect-black"></div>
	</form>
</section>

<!--Special Gift Section-->
<!--
<section class="wishlist_section gift_section">
<div class="container">
<div class="row">
<div class="col-md-5 col-sm-5 col-xs-12 fulWidth">
<h4 class="full-pay gold-txt">
<span class="bygift">Buy a Special Gift
for Your Sugababe</span>
<br/>
</h4>
<h5 class="code_h5">#enjoytheshopping</h5>
<p class="gift_p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea com</p>
<h4 class="gift_h4">Original designer Bags, Jewelry	, Perfume, Clothing, High Heels and much more.</h4>
<div class="row">
<div class="col-md-12 go_btn_col">
<a href="#" class="go_online_shop Rettangolo_2 btn_hover" id="buy_nw_credits">Buy Now Credits</a>
</div>
</div>
</div>
<div class="col-md-7 col-sm-7 col-xs-12 fulWidth">
<img src="
<?php echo base_url('images/gift.png'); ?>" class="img-responsive giftImg">

</div>
</div>
</div>
</section>
-->
<?php
$this->load->view('templates/footers/main_footer');
?>