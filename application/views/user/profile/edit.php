<?php
$this->load->view('templates/headers/main_header', $title);
$this->load->view('templates/sidebar/main_sidebar');
$this->load->view('templates/sidebar/main_modal');
?>
<style type="text/css">
	.badge-danger {
    	background-color: #cf283a;
    	color: #FFFFFF;
	}
	.badge-status-pos {
		text-transform: uppercase;
		position: absolute;
		left: -10px;
		top: -10px;
		font-size: 9px;
	}
</style>
<?php if($this->session->flashdata('message')) { ?>
<section class="messages">
	<div class="alert tag-alert-golden alert-dismissible fade in">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php echo $this->lang->line($this->session->flashdata('message')); ?>
	</div>
</section>
<?php } ?>
<?php if(validation_errors() != '') { ?>
<section class="messages"> 
	<div class="alert alert-danger alert-dismissible fade in">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php echo $this->lang->line('please_correct_your_information'); ?>
	</div>
</section>
<?php } ?>
<section class="messages">
    <div class="progress tag-alert-golden" style="border-radius: 22px;height: 15px;margin: 10px 12px 2px 0px;display: none;">
      <div style="background-color: #2DB12A;" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
</section>

<section class="profile_section_home profile_setting">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>
		<div class="row">		
			<div class="col-md-12 padding_zero" id="upldProPic">
				<h2 class="lyfStyl"><?php echo $this->lang->line('show_you_and_your_lifestyle_that_you_live_and_love'); ?></h2>
				<p class="help-block" style="color: white;font-weight: 400;font-size: 16.49px;"><?php echo $this->lang->line('pornographic_pictures_upload_warning_info_text'); ?></p>
				<h4 class="lyfStyl_sub"><?php echo $this->lang->line('this_is_how_other_member_see_you'); ?></h4>
				   <div class="avatar-upload">
				    <div class="avatar-preview prflPrvw">
            			<div id="imagePreview" style="background-image: url(<?php echo base_url().$this->session->userdata('user_avatar'); ?>);"></div>
        			</div>
			        <div class="avatar-edit">
				        <input name="file" type='file' id="userMProfilePicImage" accept=".png, .jpg, .jpeg" />
			         	<label for="userMProfilePicImage" class="imageUpload">
							<h4 class="upld_lbl"><?php echo $this->lang->line('upload_your_picture'); ?></h4>
						</label>
			        </div>       
    			</div>
			</div>
		</div>

		<div class="row" id="myProfile">
			<div class="col-md-12 padding_zero">
				<hr class="prfl_stting" />
			</div>
			
			<div class="col-md-12 padding_zero">
				<h2 class="lyfStyl"><?php echo $this->lang->line('my_profile_pictures'); ?></h2>
				<h4 class="lyfStyl_sub"><?php echo $this->lang->line('these_picture_of_you_may_see_each_members'); ?></h4>
				<div class="col-md-6 padding_zero" id="profile_picture_list">
					<?php 
						if(!empty($user_photos)) {
							foreach ($user_photos as $photo) {
								if($photo['photo_type'] == 'profile') {
					?>
				   	<div class="pro_pic" rel="<?php echo $photo['photo_id']; ?>">
				   		<?php if($photo['photo_status'] != 'active'): ?>
				   		<span class="badge badge-danger badge-status-pos" style=""><?php echo $this->lang->line($photo['photo_status']); ?></span>
				   		<?php endif; ?>
						<img src="<?php echo base_url($photo['photo_thumb_url']); ?>" class="proPicImg" />
						<div class="pic_galleryMnu">
							<div class="list-group">
								<img src="<?php echo base_url('images/prof-menu-arrow.png'); ?>" class="proPicArrow" />
							    <a href="javascript:void(0);" class="list-group-item move-to-vip-picture"><?php echo $this->lang->line('move_to_vip_gallary'); ?></a>
							    <a href="javascript:void(0);" class="list-group-item set-profile-picture"><?php echo $this->lang->line('set_as_profile_picture'); ?></a>
							    <a href="javascript:void(0);" class="list-group-item clear-my-picture"><?php echo $this->lang->line('clear'); ?></a>
  							</div>						
						</div>
					</div>
					<?php 
								}
							}
						}
					?>              
    			</div>
	 			<div class="col-md-4 col-xs-12 padding_zero" id="upldMyPrfls">
	 				<div class="avatar-upload">
				        <div class="avatar-edit">	
				            <input type='file' name="file" id="userProfilePicImage" accept=".png, .jpg, .jpeg" />
				            <label for="userProfilePicImage" class="imageUpload">
								<h4 class="upld_lbl"><?php echo $this->lang->line('upload_your_picture'); ?></h4>
							</label>
				        </div>       
    				</div>
	 			</div>
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting" />
				</div>
			</div>
		</div>
			
		<!--my vip picture-->
		<div class="row" id="myProfile">
			<div class="col-md-12 padding_zero">
				<h2 class="lyfStyl"><?php echo $this->lang->line('my_vip_pictures_gallery'); ?></h2>
				<h4 class="lyfStyl_sub"><?php echo $this->lang->line('these_picture_of_you_may_only_see_vip_members'); ?></h4>
				<div class="col-md-6 padding_zero" id="vip_picture_list">
					<?php 
						if(!empty($user_photos)) {
							foreach ($user_photos as $photo) {
								if($photo['photo_type'] == 'vip') {
					?>
				   	<div class="pro_pic" rel="<?php echo $photo['photo_id']; ?>">
				   		<?php if($photo['photo_status'] != 'active'): ?>
				   		<span class="badge badge-danger badge-status-pos" style=""><?php echo $this->lang->line($photo['photo_status']); ?></span>
				   		<?php endif; ?>				   		
						<img src="<?php echo base_url($photo['photo_thumb_url']); ?>" class="proPicImg" />
						<div class="pic_galleryMnu">
							<div class="list-group">
								<img src="<?php echo base_url('images/prof-menu-arrow.png'); ?>" class="proPicArrow" />							    
							    <a href="javascript:void(0);" class="list-group-item move-to-profile-picture"><?php echo $this->lang->line('move_to_profile_pictures'); ?></a>
								<a href="javascript:void(0);" class="list-group-item set-profile-picture"><?php echo $this->lang->line('set_as_profile_picture'); ?></a>							    
							    <a href="javascript:void(0);" class="list-group-item clear-my-picture"><?php echo $this->lang->line('clear'); ?></a>
  							</div>						
						</div>
					</div>
					<?php 
								}
							}
						}
					?>       
    			</div>
	 			<div class="col-md-4 padding_zero vipPicGal">
	 				<div class="avatar-upload">
				        <div class="avatar-edit"> 	
				            <input name="file" type='file' id="uploadVIPPrfileImage" accept=".png, .jpg, .jpeg" />
				            <label for="uploadVIPPrfileImage" class="imageUpload">
								<h4 class="upld_lbl"><?php echo $this->lang->line('upload_your_picture'); ?></h4>
							</label>
				        </div>       
    				</div>
	 			</div>
			</div>
		</div>
		<!--my vip picture-->
			
		<!--my private picture-->
		<div class="row private_pics" id="myProfile">
			<div class="col-md-12 padding_zero">
				<hr class="prfl_stting" />
			</div>
			<div class="col-md-12 padding_zero">
				<h2 class="lyfStyl"><?php echo $this->lang->line('my_private_pictures_gallery'); ?></h2>
				<h4 class="lyfStyl_sub"><?php echo $this->lang->line('these_picture_of_you_may_only_see_members_you_have_selected'); ?></h4>
				<div class="col-md-6 padding_zero">
					<?php 
						if(!empty($user_photos)) {
							$private_cnt = 1;
							foreach ($user_photos as $photo) {
								if($photo['photo_type'] == 'private') {
					?>
				   	<div class="pro_pic" rel="<?php echo $photo['photo_id']; ?>">
				   		<?php if($photo['photo_type'] == 'private') { ?><div class="unlockCount"><?php echo $private_cnt++; ?></div><?php } ?>
				   		<?php if($photo['photo_status'] != 'active'): ?>
				   		<span class="badge badge-danger badge-status-pos" style=""><?php echo $this->lang->line($photo['photo_status']); ?></span>
				   		<?php endif; ?>				   		
						<img src="<?php echo base_url($photo['photo_thumb_url']); ?>" class="proPicImg" />
						<div class="pic_galleryMnu">
							<div class="list-group">
								<img src="<?php echo base_url('images/prof-menu-arrow.png'); ?>" class="proPicArrow" />
							    <a href="javascript:void(0);" class="list-group-item clear-my-picture"><?php echo $this->lang->line('clear'); ?></a>
  							</div>						
						</div>
					</div>
					<?php 
								}
							}
						}
					?>
    			</div>
	 			<div class="col-md-4 padding_zero vipPicGal">
	 				<div class="avatar-upload">
        				<div class="avatar-edit">		
				            <input name="file" type='file' id="uploadPrivatePrfileImage" accept=".png, .jpg, .jpeg" />
				            <label for="uploadPrivatePrfileImage" class="imageUpload">
								<h4 class="upld_lbl"><?php echo $this->lang->line('upload_your_picture'); ?></h4>
							</label>
				        </div>      
    				</div>
	 			</div>
			</div>
		</div>
		<!--my private picture-->
			
		<!--User Details-->
		<form id="editForm" action="" method="POST" enctype="multipart/form-data">
			<div class="row" id="userDetails">
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting" />
				</div>
				<div class="col-md-12 padding_zero">
					<div class="text-left email_box">
						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('where_are_you_from'); ?></label>
								<input class="email_add" id="user_location" name="user_location" type="text" placeholder="<?php echo $this->lang->line('enter_location'); ?>" autocomplete="off" maxlength="100" value="<?php echo $user_row['user_city']; ?>" >
								<?php echo form_error('user_location'); ?>

								<input type="hidden" id="user_latitude" name="user_latitude" value="">
								<input type="hidden" id="user_longitude" name="user_longitude" value="">
							</div>
							<?php 
								$user_birthdate = explode('-', $user_row['user_birthday']);
							?>
							<div class="col-md-2">
								<label><?php echo $this->lang->line('day'); ?></label>
								<div class="select">
									<select name="dateofbirth_day">								
										<?php for($day=1; $day <= 31; $day++) { ?>
										<option class="option" value="<?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?>" <?php if($user_birthdate[2] == $day) { ?> selected="true" <?php } ?> ><?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?></option>
										<?php } ?>
									</select>
				  					<div class="select__arrow">
				  						<i class="fa fa-angle-down" aria-hidden="true"></i>
				  					</div>									
								</div>
							</div>
							<div class="col-md-2">
								<label><?php echo $this->lang->line('month'); ?></label>
								<div class="select">
									<select name="dateofbirth_month">
										<?php for($month=1; $month <= 12; $month++) { ?>
										<option class="option" value="<?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?>" <?php if($user_birthdate[1] == $month) { ?> selected="true" <?php } ?>><?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?></option>
										<?php } ?>
									</select>
	      							<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
	    						</div>
							</div>
							<div class="col-md-2">
								<label><?php echo $this->lang->line('year'); ?></label>
								<div class="select">
									<select name="dateofbirth_year">
										<?php 
										$curr_year = date('Y');
										$year_diff = $settings['site_age_limit'];
										$upto_year = $curr_year - $year_diff - 52;

										for($year=($curr_year-$year_diff); $year >= $upto_year; $year--) { ?>
										<option class="option" value="<?php echo $year; ?>" <?php if($user_birthdate[0] == $year) { ?> selected="true" <?php } ?>><?php echo $year; ?></option>
										<?php } ?>
									</select>
	      							<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
	    						</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('figure'); ?></label>
								<div class="select">
									<select name="user_figure">
										<?php foreach($figure_list as $figure) { ?>
										<option class="option" value="<?php echo $figure; ?>" <?php if($user_row['user_figure'] == $figure) { ?>selected="true" <?php } ?>><?php echo $this->lang->line($figure); ?></option>
										<?php } ?>
									</select>
									<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>									
								</div>								
							</div>
							<div class="col-md-6">
								<label><?php echo $this->lang->line('size'); ?></label>
								<div class="select">
									<input class="email_add" name="user_size" placeholder="200" maxlength="20" value="<?php echo $user_row['user_height']; ?>" >
									<div class="select__arrow"><?php echo $this->lang->line('cm'); ?></div>
								</div>
								<?php echo form_error('user_size'); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('job'); ?></label>
								<div class="select">
									<select name="user_job">
										<?php foreach($job_list as $job) { ?>
										<option class="option" value="<?php echo $job; ?>" <?php if($user_row['user_job'] == $job) { ?>selected="true" <?php } ?>><?php echo $this->lang->line($job); ?></option>
										<?php } ?>
									</select>
									<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<label><?php echo $this->lang->line('ethnicity'); ?></label>
								<div class="select">
									<select name="user_ethnicity">
										<?php foreach($ethnicity_list as $ethnicity) { ?>
										<option class="option" value="<?php echo $ethnicity; ?>" <?php if($user_row['user_ethnicity'] == $ethnicity) { ?>selected="true" <?php } ?>><?php echo $this->lang->line($ethnicity); ?></option>
										<?php } ?>
									</select>
									<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	

			<!--arrangement and contact wish-->
			<div class="row arrangements">
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting" />
				</div>
				<div class="col-md-12 padding_zero">
					<div class="text-left email_box">

<!-- 
						<?php if($user_row['user_gender'] == 'female') { ?>
						<div class="row">
							<div class="col-md-12" id="arrngments_sb">
								<label><?php echo $this->lang->line('arangement'); ?></label>
							</div>
							<?php 
								$selected_arrangement_arr = array(); 
								$selected_arrangement_arr = explode(',', $user_row['user_arangement']);
							?>
							<div class="col-md-2">
								<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('luxury'); ?>
		      						<input type="checkbox" name="user_arangement[]" value="luxury" <?php if(in_array('luxury', $selected_arrangement_arr)){ ?> checked="true" <?php } ?> />
		      						<div class="control__indicator"></div>
		    					</label>
							</div>
							<div class="col-md-2">
			 					<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('lifestyle'); ?>
		      						<input type="checkbox" name="user_arangement[]" value="lifestyle" <?php if(in_array('lifestyle', $selected_arrangement_arr)){ ?> checked="true" <?php } ?> />
		      						<div class="control__indicator"></div>
		    					</label>
							</div>
							<div class="col-md-4">
								<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('monthly_budget'); ?>
		      						<input type="checkbox" name="user_arangement[]" value="monthly_budget" <?php if(in_array('monthly_budget', $selected_arrangement_arr)){ ?> checked="true" <?php } ?> />
		      						<div class="control__indicator"></div>
		    					</label>
							</div>
							<?php echo form_error('user_arangement[]'); ?>
						</div>
						<?php } ?> -->

						<div class="row">							
							<div class="col-md-12" id="contact_wish">
								<label><?php echo $this->lang->line('contact_request'); ?></label>
							</div>
							<div class="col-md-12" id="contctReqst">
							<?php 
								if(!empty($contact_requests)) { 
									$selected_contact_requests = array();
									if(!empty($user_contact_requests)) {
										foreach($user_contact_requests as $ureq) {
											array_push($selected_contact_requests, $ureq['contact_request_contact_id']);
										}
									}

									foreach($contact_requests as $req) {
							?>
							<div class="col-md-3">
								<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line($req['contact_request_name']); ?>
      								<input type="checkbox" name="user_contact_request[]" value="<?php echo $req['contact_request_id']; ?>" <?php if(in_array($req['contact_request_id'], $selected_contact_requests)){ ?> checked="true" <?php } ?> />
      								<div class="control__indicator"></div>
    							</label>
							</div>
							<?php 	} 
								} 
							?>
							</div>
						</div>
					</div>
				</div>
			</div>					
			<!--arrangement and contact wish-->
					
			<!--ICH BIN NUR AN EINER-->
			<div class="row arrangements">
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting" />
				</div>
				<div class="col-md-12 padding_zero">
					<div class="text-left email_box">
						<div class="row">
							<div class="col-md-12 cinzel_font" id="arrngments_sb">
								<label><?php echo $this->lang->line('i_am_only_at_one'); ?></label>
							</div>
							<div class="col-md-6">
								<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('serious_relationship_interested'); ?>
									<input type="radio" name="serious_relationship_interested" value="yes" <?php if($user_row['interested_in_serious_relationship'] == 'yes') { ?> checked="true" <?php } ?>  />
									<div class="control__indicator"></div>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--ICH BIN NUR AN EINER-->

			<!--ICH BIN NUR AN EINER-->
			<div class="row arrangements">
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting" />
				</div>
				<div class="col-md-12 padding_zero">
					<div class="text-left email_box">
						<div class="row cinzel_font" id="arrngments_sb">
							<div class="col-md-6">
								<label>
									<?php echo $this->lang->line('my_description'); ?>
									<?php 
										if($user_about) { 
											$user_about_text = $user_about['content_text'];
										 	if($user_about['content_status'] != 'approved') {
												echo "<span class='badge text-right' style='background-color:#c73e28 !important;color: #fff !important;'>".$this->lang->line($user_about['content_status'])."</span>";
											}
										} else {
											$user_about_text = $user_row['user_about'];
										}
									?>
									</label>
								<input name="old_my_description" type="hidden" value="<?php echo $user_about_text; ?>">
								<textarea class="form-control" name="my_description" placeholder="<?php echo $this->lang->line('write_your_information_here'); ?>" rows="5"><?php echo $user_about_text; ?></textarea>
								<?php echo form_error('my_description'); ?>
							</div>							
							<div class="col-md-6">
								<?php if($this->session->userdata('user_gender') == 'female') { ?>
									<label>
										<?php echo $this->lang->line('how_can_man_impress_you'); ?>
										<?php 
											if($user_how_impress) {
												$user_how_impress_text = $user_how_impress['content_text'];
												if($user_how_impress['content_status'] != 'approved') {												
													echo "<span class='badge text-right' style='background-color:#c73e28 !important;color: #fff !important;'>".$this->lang->line($user_how_impress['content_status'])."</span>";
												}
											} else {
												$user_how_impress_text = $user_row['user_how_impress'];
											}
										?>					
									</label>
									<input name="old_how_can_man_impress_you" type="hidden" value="<?php echo $user_how_impress_text; ?>">
									<textarea class="form-control" name="how_can_man_impress_you" placeholder="<?php echo $this->lang->line('write_your_information_here'); ?>" rows="5"><?php echo $user_how_impress_text; ?></textarea>
									<?php echo form_error('how_can_man_impress_you'); ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--ICH BIN NUR AN EINER-->
						
			<!--Other Info-->
			<div class="row email_box cinzel_font" id="other_details">
				<div class="row">						
					<div class="col-md-6 col-lg-6 col-xs-12 sprt_cl sp_div" id="sprt_cl_div">
						<label class="emptytLbl"><?php echo $this->lang->line('sport'); ?></label>
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
			              <div class="select__arrow">
			                <i class="fa fa-angle-down" aria-hidden="true"></i>
			              </div>
            			</div>				
						<img id="add-user-sport" src="<?php echo base_url('images/add.png'); ?>" class="add-sport">
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 sprt_cl sp_div" id="sprt_cl_div">
						<label class="emptytLbl">&nbsp;&nbsp;</label>
						<div class="selected-items" id="sports_selected_items">
							<?php 
								if(!empty($user_sports)) {
									foreach($user_sports as $sport_name) {
							?>
							<div class="alert tag-alert tag-alert-golden alert-dismissible fade in">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <?php echo $this->lang->line($sport_name['sport_name']); ?>
							  <input type="hidden" name="user_sports_selected[]" value="<?php echo $sport_name['user_sport_ref_id']; ?>" >
							</div>
							<?php 	}
								}
							?>
						</div>
					</div>
				</div>

				<div class="row">						
					<div class="col-md-6 col-lg-6 col-xs-12 sprt_cl sp_div" id="sprt_cl_div">
						<label class="emptytLbl"><?php echo $this->lang->line('interests'); ?></label>
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
							<div class="select__arrow">
								<i class="fa fa-angle-down" aria-hidden="true"></i>
          					</div>
        				</div>
						<img id="add-user-interest" src="<?php echo base_url('images/add.png'); ?>" class="add-sport">
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 sprt_cl sp_div" id="sprt_cl_div">
						<label class="emptytLbl">&nbsp;&nbsp;</label>
						<div class="selected-items" id="interests_selected_items">
							<?php 
								if(!empty($user_interests)) {
									foreach($user_interests as $interest_name) {
							?>
							<div class="alert tag-alert tag-alert-golden alert-dismissible fade in">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <?php echo $this->lang->line($interest_name['interest_name']); ?>
							  <input type="hidden" name="user_interests_selected[]" value="<?php echo $interest_name['interest_id_ref']; ?>" >
							</div>
							<?php 	}
								}
							?>
						</div>
					</div>
				</div>

				<div class="row">						
					<div class="col-md-6 col-lg-6 col-xs-12 sprt_cl sp_div" id="sprt_cl_div">
						<label class="emptytLbl"><?php echo $this->lang->line('languages'); ?></label>
						<div class="select">
							<select name="user_languages">
								<?php 
									if(!empty($languages)) {
										foreach($languages as $language) {
								?>
									<option class="option" value="<?php echo $language['language_id']; ?>"><?php echo $this->lang->line($language['language_name']); ?></option>
								<?php 	} 
									} 
								?>
							</select>
							<div class="select__arrow">
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</div>
            			</div>				
						<img id="add-user-language" src="<?php echo base_url('images/add.png'); ?>" class="add-sport">
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 sprt_cl sp_div" id="sprt_cl_div">
						<label class="emptytLbl">&nbsp;&nbsp;</label>
						<div class="selected-items" id="languages_selected_items">
							<?php 
								if(!empty($user_spoken_languages)) {
									foreach($user_spoken_languages as $language_name) {
							?>
							<div class="alert tag-alert tag-alert-golden alert-dismissible fade in">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <?php echo $this->lang->line($language_name['language_name']); ?>
							  <input type="hidden" name="user_languages_selected[]" value="<?php echo $language_name['spoken_language_ref_lang_id']; ?>" >
							</div>
							<?php 	}
								}
							?>
						</div>
					</div>
				</div>

				<div class="row eyeHair">						
					<div class="col-md-6 col-lg-6 col-xs-12 sprt_cl sp_div">
						<label class="emptytLbl"><?php echo $this->lang->line('eye_color'); ?></label>
						<div class="select">
							<select name="user_eye_color">
								<?php foreach($eye_color_list as $elist) { ?>
								<option class="option" value="<?php echo $elist; ?>" <?php if($user_row['user_eye_color'] == $elist) { ?>selected="true" <?php } ?>><?php echo $this->lang->line($elist); ?></option>
								<?php } ?>
							</select>
							<div class="select__arrow">
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</div>
            			</div>				
							
					</div>	
					<div class="col-md-6 col-lg-6 col-xs-12 sprt_cl sp_div">
						<label><?php echo $this->lang->line('hair_color'); ?></label>
						<div class="select">
							<select name="user_hair_color">
								<?php foreach($hair_color_list as $hlist) { ?>
								<option class="option" value="<?php echo $hlist; ?>" <?php if($user_row['user_hair_color'] == $hlist) { ?>selected="true" <?php } ?>><?php echo $this->lang->line($hlist); ?></option>
								<?php } ?>
							</select>
							<div class="select__arrow">
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</div>
            			</div>							
					</div>	
				</div>				
			</div>
					
					
			<!--smoker & children-->
			<div class="row arrangements">
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting" />
				</div>
				<div class="col-md-12 padding_zero">
					<div class="text-left email_box">				
						<div class="row">												
							<div class="row">
								<div class="col-md-4">
									<div class="col-md-12" id="contact_wish">
										<label><?php echo $this->lang->line('smoker'); ?></label>
									</div>
									<div class="col-md-3">
							   			<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('yes'); ?>
										  	<input type="radio" name="user_is_smoker" value="yes" <?php if($user_row['user_smoker'] == 'yes') { ?>checked="true" <?php } ?> />
										  	<div class="control__indicator"></div>
										</label>
									</div>
									<div class="col-md-3">
										<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('no'); ?>
										  	<input type="radio" name="user_is_smoker" value="no" <?php if($user_row['user_smoker'] == 'no') { ?>checked="true" <?php } ?> />
										  	<div class="control__indicator"></div>
										</label>
									</div>
									<div class="col-md-4">
										<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('occasionally'); ?>
											<input type="radio" name="user_is_smoker" value="occasionally" <?php if($user_row['user_smoker'] == 'occasionally') { ?>checked="true" <?php } ?> />
											<div class="control__indicator"></div>
										</label>
									</div>
									<div class="col-md-12"><?php echo form_error('user_is_smoker'); ?></div>
								</div>

								<div class="col-md-7">
									<div class="col-md-12" id="contact_wish">
										<label><?php echo $this->lang->line('children'); ?></label>
									</div>
									<div class="col-md-2">
							   			<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('yes'); ?>
							  				<input type="radio" name="user_has_child" value="yes" <?php if($user_row['user_has_child'] == 'yes') { ?>checked="true" <?php } ?>  />
							  				<div class="control__indicator"></div>
										</label>
									</div>
									<div class="col-md-2">
							   			<label class="control control--radio col-md-12 interest chkout_radio"><?php echo $this->lang->line('no'); ?>
							  				<input type="radio" name="user_has_child" value="no" <?php if($user_row['user_has_child'] == 'no') { ?>checked="true" <?php } ?> />
							  				<div class="control__indicator"></div>
										</label>
									</div>
									<div class="col-md-4">
										<div class="select">
											<select name="how_many_childrens">
												<option value=""><?php echo $this->lang->line('how_many'); ?></option>
												<option value="1" <?php if($user_row['how_many_childrens'] == '1') { ?> selected="true"<?php } ?> >1</option>
												<option value="2" <?php if($user_row['how_many_childrens'] == '2') { ?> selected="true"<?php } ?>>2</option>
											</select>
											<div class="select__arrow">
												<i class="fa fa-angle-down" aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div class="col-md-12"><?php echo form_error('user_has_child'); ?></div>
								</div>						
							</div>							
						</div>
					</div>
				</div>
			</div>			
			<!--smoker & children-->											
		
			<div class="row fileUploadDiv" id="userDetails">
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting">
				</div>
				<div class="col-md-12 padding_zero">
					<h4 class="full-pay gold-txt">
          				<span class="byDiamonds"><?php echo $this->lang->line('are_you_real'); ?>?</span>
        			</h4>
					<div class="text-left email_box">
						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('reality_check'); ?></label>
								<div class="box">
									<input type="file" name="reality_check_file" id="reality_check_file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
									<label for="reality_check_file"><img src="<?php echo base_url('images/profile-upload.png'); ?>" class="upload-icon" /><span><?php echo $this->lang->line('choose_a_file'); ?>&hellip;</span></label>
								</div>	
								<a href="<?php echo base_url('page/realityCheck'); ?>"><label class="real_chk"><?php echo $this->lang->line('how_does_the_reality_check_works'); ?>?</label></a>
							</div>
							<div class="col-md-6">
								<label>&nbsp;</label>
								<div class="box">
								<?php 
									if(!empty($reality_check_documents)) { 
										foreach ($reality_check_documents as $document) {
											if($document['document_status'] == 'verified') {
												$badge_sts_color = "background-color:#119611 !important;color: #fff !important;";
											} else {
												$badge_sts_color = "background-color:#c73e28 !important;color: #fff !important;";
											}
								?>
									<span class="badge" style="<?php echo $badge_sts_color; ?>font-family: 'Montserrat', 'Helvetica',Arial,sans-serif;text-transform: uppercase;font-size: 12px;font-weight: 700;"><?php echo $this->lang->line($document['document_status']); ?></span>&nbsp;
									<a href="<?php echo base_url($document['document_url']); ?>"><?php echo $document['document_name']; ?></a>
									<br/><br/>
								<?php 
										}
									}
								?>
								</div>
							</div>
						</div>	
<!-- 						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('reality_check_gift_delivery'); ?></label>
								<div class="box">
									<input type="file" name="gift_delivery_check_file" id="gift_delivery_check_file" class="inputfile inputfile-1" />
									<label for="gift_delivery_check_file"><img src="<?php echo base_url('images/profile-upload.png'); ?>" class="upload-icon" /><span><?php echo $this->lang->line('choose_a_file'); ?>&hellip;</span></label>
								</div>
								<a href="<?php echo base_url('page/realityGiftCheck'); ?>"><label class="real_chk"><?php echo $this->lang->line('how_does_the_reality_check_gift_delivery_works'); ?>?</label></a>
							</div>
						</div> -->
						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('assets_check'); ?></label>
								<div class="box">
									<input type="file" name="asset_check_file" id="asset_check_file" class="inputfile inputfile-1" />
									<label for="asset_check_file"><img src="<?php echo base_url('images/profile-upload.png'); ?>" class="upload-icon" /><span><?php echo $this->lang->line('choose_a_file'); ?>&hellip;</span></label>
								</div>
								<a href="<?php echo base_url('page/assetCheck'); ?>"><label class="real_chk"><?php echo $this->lang->line('how_does_the_assets_check_works'); ?>?</label></a>
							</div>
							<div class="col-md-6">
								<label>&nbsp;</label>
								<div class="box">
								<?php 
									if(!empty($asset_check_documents)) { 
										foreach ($asset_check_documents as $document) {
											if($document['document_status'] == 'verified') {
												$badge_sts_color = "background-color:#119611 !important;color: #fff !important;";
											} else {
												$badge_sts_color = "background-color:#c73e28 !important;color: #fff !important;";
											}
								?>
									<span class="badge" style="<?php echo $badge_sts_color; ?>font-family: 'Montserrat', 'Helvetica',Arial,sans-serif;text-transform: uppercase;font-size: 12px;font-weight: 700;"><?php echo $this->lang->line($document['document_status']); ?></span>&nbsp;
									<a href="<?php echo base_url($document['document_url']); ?>"><?php echo $document['document_name']; ?></a>
									<br/><br/>
								<?php 
										}
									}
								?>
								</div>
							</div>							
						</div>						
					</div>
				</div>
			</div>
			
			<div class="row" id="submit_btns">
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting">
				</div>
				<div class="col-md-12 padding_zero">
					<div class="btn_box haarf">
						<button type="submit" class="continue_btn next btn_hover"><span class="cont_span"><?php echo $this->lang->line('save_profile'); ?></span></button>
						<button type="button" class="continue_btn next btn_hover go-back"><span class="cont_span"><?php echo $this->lang->line('cancel'); ?></span></button>
					</div>
				</div>
				<div class="col-md-12 padding_zero" id="mobHr">
					<hr class="prfl_stting">
				</div>
			</div>
		</form>
	</div>
</section>

<!-- Image Croopper Model -->
<div class="modal fade transparent_mdl" id="imageCropperModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog crop-image-modal-dialog" role="document">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="help-block" style="color: white;font-weight: 400;font-size: 13px;"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $this->lang->line('pornographic_pictures_upload_warning_info_text'); ?></p>
				<div class="cropper-img-container">
					<img id="imageForCropping" src="<?php echo base_url('images/avatar.png'); ?>">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="save_search" id="cropImage"><span class="search_span"><?php echo $this->lang->line('upload'); ?></span></button>
			</div>
        </div>
    </div>
</div>
<!-- END Image Croopper Model -->
<script>
window.addEventListener('DOMContentLoaded', function () {
	var cropperimage = document.getElementById('imageForCropping');
	var userMProfilePicImage = document.getElementById('userMProfilePicImage');
	var userProfilePicImage = document.getElementById('userProfilePicImage');
	var uploadVIPPrfileImage = document.getElementById('uploadVIPPrfileImage');
	var uploadPrivatePrfileImage = document.getElementById('uploadPrivatePrfileImage');

	var $cropperprogress = $('.progress');
	var $cropperprogressBar = $('.progress-bar');
	var $croppermodal = $('#imageCropperModal');
	var cropper;
    var is_profile = 'yes';
    var photo_type = 'profile';

    // Upload Main Profile picture and set as default
    userMProfilePicImage.addEventListener('change', function (e) {
        var files = e.target.files;
    	is_profile = 'yes';
    	photo_type = 'profile';

        var done = function (url) {
          	userMProfilePicImage.value = '';
          	cropperimage.src = url;
          	$croppermodal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
			file = files[0];

			if (URL) {
				done(URL.createObjectURL(file));
			} else if (FileReader) {
				reader = new FileReader();
				reader.onload = function (e) {
					done(reader.result);
				};
				reader.readAsDataURL(file);
			}
        }
    });

	// Upload Profile pictures
    userProfilePicImage.addEventListener('change', function (e) {
        var files = e.target.files;
    	is_profile = 'no';
    	photo_type = 'profile';

        var done = function (url) {
          	userProfilePicImage.value = '';
          	cropperimage.src = url;
          	$croppermodal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
			file = files[0];

			if (URL) {
				done(URL.createObjectURL(file));
			} else if (FileReader) {
				reader = new FileReader();
				reader.onload = function (e) {
					done(reader.result);
				};
				reader.readAsDataURL(file);
			}
        }
    });

	// Upload VIP pictures
    uploadVIPPrfileImage.addEventListener('change', function (e) {
        var files = e.target.files;
    	is_profile = 'no';
    	photo_type = 'vip';

        var done = function (url) {
          	uploadVIPPrfileImage.value = '';
          	cropperimage.src = url;
          	$croppermodal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
			file = files[0];

			if (URL) {
				done(URL.createObjectURL(file));
			} else if (FileReader) {
				reader = new FileReader();
				reader.onload = function (e) {
					done(reader.result);
				};
				reader.readAsDataURL(file);
			}
        }
    });

    // Upload Private pictures
    uploadPrivatePrfileImage.addEventListener('change', function (e) {
        var files = e.target.files;
    	is_profile = 'no';
    	photo_type = 'private';

        var done = function (url) {
          	uploadPrivatePrfileImage.value = '';
          	cropperimage.src = url;
          	$croppermodal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
			file = files[0];

			if (URL) {
				done(URL.createObjectURL(file));
			} else if (FileReader) {
				reader = new FileReader();
				reader.onload = function (e) {
					done(reader.result);
				};
				reader.readAsDataURL(file);
			}
        }
    });

    // Intialise cropper module
    $croppermodal.on('shown.bs.modal', function () {
    	cropper = new Cropper(cropperimage);
    }).on('hidden.bs.modal', function () {
    	cropper.destroy();
        cropper = null;
    });

    // Crop Image and upload to server
    document.getElementById('cropImage').addEventListener('click', function () {
        var canvas;
        $croppermodal.modal('hide');

        if(cropper) {
			canvas = cropper.getCroppedCanvas({
				// width: 1600,
				// height: 1200,
			});
          	$cropperprogress.show();

          	canvas.toBlob(function (blob) {
	            var formData = new FormData();
	            var url = base_url + 'user/profile/uploadProfilePic';
	            formData.append('profile', is_profile);
	            formData.append('type', photo_type);
	            formData.append('file', blob, 'profilepic.jpg');
	            $("html, body").animate({ scrollTop: 0 }, "slow");

	            $.ajax(url, {
	              	method: 'POST',
	              	data: formData,
	              	processData: false,
	              	contentType: false,
	              	xhr: function () {
	                	var xhr = new XMLHttpRequest();

	                	xhr.upload.onprogress = function (e) {
		                  	var percent = '0';
		                  	var percentage = '0%';

		                  	if(e.lengthComputable) {
		                    	percent = Math.round((e.loaded / e.total) * 100);
		                    	percentage = percent + '%';
		                    	$cropperprogressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
		                  	}
	                	};
	                	return xhr;
	              	},
	              	success: function (data) {
	                	//$cropperalert.show().html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message);
	              	},
	              	error: function () {
	              		location.reload();
	                	//$cropperalert.show().html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message);
	              	},
	              	complete: function () {
	                	$cropperprogress.hide();
	                	location.reload();
	              	},
	            });
          	});
        }
    });

	$("#user_location").geocomplete().bind("geocode:result", function(event, result){
		$("#user_location").val(result.name);
		$("#user_latitude").val(result.geometry.location.lat);
		$("#user_longitude").val(result.geometry.location.lng);
  	});

	$("#user_location").change(function() {
		if($(this).val() != '') {
			$.ajax({
				url: "https://maps.googleapis.com/maps/api/geocode/json?address="+ $(this).val() +"&language=en&key=<?php echo GOOGLE_MAP_API_KEY; ?>",
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					if(data.results.length > 0) {
						$("#user_latitude").val(data.results[0].geometry.location.lat);
						$("#user_longitude").val(data.results[0].geometry.location.lng);
					}
				}
			});
		} else {
			$("#user_latitude").val('<?php echo $this->session->userdata('user_latitude'); ?>');
			$("#user_longitude").val('<?php echo $this->session->userdata('user_longitude'); ?>');
		}
	});
	
});
</script>
<?php
$this->load->view('templates/footers/main_footer');
?>