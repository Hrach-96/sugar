<?php
$this->load->view('templates/headers/main_header', $title);
$this->load->view('templates/sidebar/main_sidebar');
$this->load->view('templates/sidebar/main_modal');
?>
<section class="breacrum_section common_back">
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
	</div>
</section>

<section class="question_section kisses_section" id="visitorBx">	
	<div class="container">	
		<div class="row tabpagesRw chat_bx">
        <div class="col-md-12">
            <div class="tab question_bx" role="tabpanel">
			<div class="row chat_btns">	
			    <div class="col-md-12">
					<h4 class="full-pay gold-txt">
						<span class="byDiamonds"><?php echo $this->lang->line('visitors'); ?></span>
					</h4>
				</div> 
			</div>            	
			<div class="row">	
				  
                <ul class="nav nav-tabs" role="tablist">
				<li class="col-md-6"><a href="<?php echo base_url('visitors?type=to_me'); ?>" rel="div1" class="showSingle qbtn <?php if($visitor_type == 'to_me') { echo 'active-tab'; } ?>"><?php echo $this->lang->line('visited_to_me'); ?></a></li>
				<li class="col-md-6"><a href="<?php echo base_url('visitors?type=by_me'); ?>" rel="div1" class="showSingle qbtn <?php if($visitor_type == 'by_me') { echo 'active-tab'; } ?>"><?php echo $this->lang->line('visited_by_me'); ?></a></li>
                </ul>
				</div>
                <div class="question_bx">                	
                    <div>
						<div class="row qusn_rw">	
							               
                    <div class="targetDiv" id="div1">
						<div class="kisses_div">	
								<div class="row">
			<?php 
				if($visitor_type == 'to_me' || ($visitor_type == 'by_me' && $this->session->userdata('user_is_vip') == 'yes')) {
					if(!empty($users)) {
						foreach ($users as $user_row) {
							// User Age
							$today = date_create(date('Y-m-d'));
							$user_birthday = date_create($user_row['user_birthday']);
							$age = date_diff($today, $user_birthday);

							// Member Distance from User
							$dist = round(distance($user_latitude, $user_longitude, $user_row['user_latitude'], $user_row['user_longitude']));
				            if($user_row['user_active_photo_thumb'] == '') {
				              $user_row['user_active_photo_thumb'] = "images/avatar/".$user_row['user_gender'].".png";
				            }
			?>
			<div class="col-xs-6 col-sm-6 col-md-3">
				<div class="profile_thumbnail profile_data" rel="<?php echo $user_row['user_id_encrypted']; ?>">
					<a href="<?php echo base_url('user/profile/view?query=').urlencode($user_row['user_id_encrypted']); ?>">
						<img src="<?php echo base_url().$user_row['user_active_photo_thumb']; ?>" alt="" class="profile_a">
					</a>
					<div class="caption">
					  	<div class="row">
					  		<div class="col-md-12 col-sm-12 col-xs-12">
								<h4 class="pro_name"><?php echo $user_row['user_access_name']; ?> | <?php echo $age->y; ?> </h4>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h4 class="loc_km"><span class="km"><?php echo $dist; ?>km - <span class="city"><?php echo $user_row['user_city']; ?></span></h4>								
								
							</div>
<!-- 							<div class="col-md-12 col-sm-12 col-xs-12">
								<h4 class="text-right" style="font-size: 10px;"><?php echo date('d M Y', strtotime($user_row['profile_visited_date'])); ?></h4>		
							</div> -->					
						</div>		
						<hr class="pro_hr" />
						<div class="row">
							<div class="actions_div">
								<ul class="profile_actions">
									<li>
										<i class="flaticon-speech-bubbles-comment-option"></i>
										<i class="flaticon-kiss <?php echo ($user_row['is_kissed']) ? 'active-icon-red':''; ?>"></i>
										<i class="flaticon-like <?php echo ($user_row['is_favorite']) ? 'active-icon-yellow':''; ?>"></i>
										<i class="flaticon-question-speech-bubble"></i>
									</li>				
<!-- 									<li>
										<span class="ad_diamond"><?php echo $this->lang->line('make_a_gift'); ?></span>
										<i class="flaticon-giftbox"></i>
									</li> -->
								</ul>				
								<ul class="profile_actions">
									<li></li>
								</ul>
								<div class="clearfix"></div>
							</div>	
						</div>                           
					</div>
					<?php if($user_row['user_is_vip'] == 'yes') { ?>
						<img src="<?php echo base_url('images/vip_icon.png'); ?>" class="vip_icon" alt="">
					<?php } ?>
				</div>
        	</div>
        	<?php 
        				} 
        			} else {
        	?>
        		<div class="col-sm-12">
					<div class="text-center" style="color: white;padding: 32px;"><?php echo $this->lang->line('no_one_found'); ?></div>
				</div>        				
			<?php
        			}
        		} else {
        	?>
        	<div class="row">
				<div class="col-md-12 text-center payment_icons">
					<img src="<?php echo base_url('images/basis-usr-gold.png'); ?>" class="UserStImg">	
				    <h3><?php echo $this->lang->line('you_are_basic_user'); ?></h3>
				    <h4><?php echo $this->lang->line('this_feature_is_available_only_for_vip_members'); ?></h4>
				    <div>
				    	<a href="<?php echo base_url('user/vip'); ?>" class="buy_nw_credit btn_hover"><?php echo $this->lang->line('become_a_vip_now'); ?></a>
				    </div>
				</div>								
			</div>
			<?php 
        		}
        	?>

    </div>
   
   <?php if($visitor_type == 'to_me' || ($visitor_type == 'by_me' && $this->session->userdata('user_is_vip') == 'yes')) {
   			if($links != '') { ?>
	<div class="col-xs-18 col-sm-12 col-md-12 profile_divider"></div>	
	<div class="pagination">
		<span class="go_to">Go To &nbsp;&nbsp;&nbsp;&nbsp;|</span> 
		<?php echo $links; ?>	
	</div>
	<?php 	} 
		}
	?>
						</div>
                    </div>
						</div>	
                    </div>
				 </div>
            </div>
		</div>
		<div class="col-md-12">
    	</div>
    </div>
</section>

<?php
$this->load->view('templates/footers/main_footer');
?>