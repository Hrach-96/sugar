<?php
	$this->load->view('templates/headers/main_header', $title);
?>
<?php if($this->session->has_userdata('message')) { ?>
<section class="messages">
	<div class="alert tag-alert-golden alert-dismissible fade in">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php echo $this->lang->line($this->session->userdata('message')); $this->session->unset_userdata('message'); ?>
	</div>
</section>
<?php } ?>

<section class="buy_credit">
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="margin-top: -50px; ">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>		
		<div class="row">
			<div class="col-md-12 text-center padding_zero">
				<h4 class="full-pay gold-txt"><span class="vorteile"><?php echo $this->lang->line('faq_or_help'); ?></span></h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('frequently_asked_questions'); ?></h4>
				<h5 class="fqSbttl"><?php echo $this->lang->line('here_we_have_summarized_all_the_important_questions_and_answers_at_a_glance_for_you'); ?></h5>
			</div>
		</div>
	</div>
</section>

<section class="wishlist_section signup_section" id="faq_section">
	<div class="container">
	<!--FAQ div-->
		<div class="row">
			<div class="col-md-12 padding_zero">
				<div class="your-class">
					<div class="lilo-accordion-control"><?php echo $this->lang->line('registration_or_login'); ?></div>
					<div class="lilo-accordion-content">						
						<h4 class="fqTtl"><?php echo $this->lang->line('how_do_i_sign_up'); ?></h4>
						<p class="fourteen"><?php echo $this->lang->line('how_do_i_sign_up_first_text'); ?></p>
						
						<h4 class="fqTtl fqTtl1"><?php echo $this->lang->line('how_do_i_log_in'); ?></h4>
						<p class="fourteen"><?php echo $this->lang->line('how_do_i_sign_up_second_text'); ?></p>
						
						<h4 class="fqTtl fqTtl1"><?php echo $this->lang->line('i_get_the_message_invalid_email_password_when_logging_in'); ?></h4>
						<p class="fourteen"><?php echo $this->lang->line('i_get_the_message_invalid_email_password_when_logging_in_ans_text'); ?></p>
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('profile_or_pictures'); ?><i class="down"></i></div>
					<div class="lilo-accordion-content">
						<h4 class="fqTtl"><?php echo $this->lang->line('how_do_i_set_photos'); ?></h4>
						<p class="fourteen"><?php echo $this->lang->line('how_do_i_set_photos_first_text'); ?></p>
						<p class="fourteen"><?php echo $this->lang->line('how_do_i_set_photos_second_text'); ?></p>
						<p class="fourteen"><?php echo $this->lang->line('how_do_i_set_photos_third_text'); ?></p>
						<p class="fourteen"><?php echo $this->lang->line('how_do_i_set_photos_fourth_text'); ?></p>
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_many_photos_can_i_set'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('how_many_photos_can_i_set_first_text'); ?></p> 
						<p class="fourteen"><?php echo $this->lang->line('how_many_photos_can_i_set_second_text'); ?></p>
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('which_photos_are_not_allowed'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('which_photos_are_not_allowed_ans_text'); ?></p>
					</div>
					
					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_can_i_unlock_block_pictures_of_myself'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('how_can_i_unlock_block_pictures_of_myself_ans_text'); ?></p> 
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_can_i_become_a_vip_member'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('how_can_i_become_a_vip_member_ans_text'); ?></p> 
					</div>
									
					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_much_does_a_vip_membership_cost'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('the_following_prices_apply_to_the_use_of_vip_membership'); ?></p>						
						<h5 class="fqh5 sxteen os">Sugardaddy</h5>
						<ul class="fqUl padding_zero">
						<?php 
							if(!empty($vip_packages_male)) {
								foreach ($vip_packages_male as $package_row) {
									if($package_row['package_validity_total_months'] == 1) { 
						?>
								<li class="fourteen os"><?php echo $package_row['package_validity_total_months']; ?> <?php echo $this->lang->line('month'); ?> = <?php echo $package_row['package_amount_per_month']; ?> <?php echo $this->session->userdata('site_currency_symbol'); ?></li>
							<?php } else { ?>
							<li class="fourteen os"><?php echo $package_row['package_validity_total_months']; ?> <?php echo $this->lang->line('months'); ?> = <?php echo $package_row['package_amount_per_month']; ?> <?php echo $this->session->userdata('site_currency_symbol'); ?> <?php echo $this->lang->line('per_month'); ?> / <?php echo $this->lang->line('total'); ?> <?php echo $package_row['package_total_amount']; ?> <?php echo $this->session->userdata('site_currency_symbol'); ?></li>
							<?php 
									} 
								} 
							} 
						?>
						</ul>
						
						<h5 class="fqh5 sxteen os">Sugarbabe</h5>
						<ul class="fqUl padding_zero">
						<?php 
							if(!empty($vip_packages_female)) {
								foreach ($vip_packages_female as $package_row) {
									if($package_row['package_validity_total_months'] == 1) { 
						?>
								<li class="fourteen os"><?php echo $package_row['package_validity_total_months']; ?> <?php echo $this->lang->line('month'); ?> = <?php echo $package_row['package_amount_per_month']; ?> <?php echo $this->session->userdata('site_currency_symbol'); ?></li>
							<?php } else { ?>
							<li class="fourteen os"><?php echo $package_row['package_validity_total_months']; ?> <?php echo $this->lang->line('months'); ?> = <?php echo $package_row['package_amount_per_month']; ?> <?php echo $this->session->userdata('site_currency_symbol'); ?> <?php echo $this->lang->line('per_month'); ?> / <?php echo $this->lang->line('total'); ?> <?php echo $package_row['package_total_amount']; ?> <?php echo $this->session->userdata('site_currency_symbol'); ?></li>
							<?php 
									}
								} 
							} 
						?>
						</ul>
					</div>
									
					<div class="lilo-accordion-control"><?php echo $this->lang->line('what_are_credits'); ?></div>
					<div class="lilo-accordion-content">
						<ul class="fqUl padding_zero">
							<li class="fourteen os"><?php echo $this->lang->line('what_are_credits_first_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_credits_second_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_credits_third_one_text'); ?> <?php echo $settings['vip_user_credits_per_month']; ?> <?php echo $this->lang->line('what_are_credits_third_two_text'); ?> <?php echo ceil($settings['vip_user_credits_per_month'] / $settings['vip_user_unlocking_cost']); ?> <?php echo $this->lang->line('what_are_credits_third_three_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_credits_fourth_one_text'); ?> <?php echo $settings['vip_user_unlocking_cost']; ?> <?php echo $this->lang->line('what_are_credits_fourth_two_text'); ?> <?php echo $settings['basic_user_unlocking_cost']; ?> <?php echo $this->lang->line('what_are_credits_fourth_three_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_credits_fifth_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_credits_sixth_text'); ?></li>
						</ul>
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_much_are_credits'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('you_can_choose_from_the_following_packages'); ?></p>
						<table class="creditsTbl">
							<?php 
								if(!empty($credit_packages)) {
									foreach ($credit_packages as $package_row) {
							?>							
							<tr>
								<td><?php echo $package_row['package_credits']; ?> Credits</td>
								<td><?php echo $this->session->userdata('site_currency_symbol'); ?> <?php echo $package_row['package_amount']; ?></td>
							</tr>
							<?php 	}
								}
							?>
						</table>
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_can_i_pay'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('how_can_i_pay_ans_text'); ?></p>
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_can_i_perform_a_reality_check_or_property_check'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('how_can_i_perform_a_reality_check_or_property_check_ans_text'); ?></p>										
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('what_are_the_advantages_of_a_vip_membership'); ?></div>
					<div class="lilo-accordion-content">
						<ul class="fqUl padding_zero">
							<li class="fourteen os"><?php echo $this->lang->line('what_are_the_advantages_of_a_vip_membership_first_one_text'); ?> <?php echo $settings['vip_user_credits_per_month']; ?> <?php echo $this->lang->line('what_are_the_advantages_of_a_vip_membership_first_two_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_the_advantages_of_a_vip_membership_second_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_the_advantages_of_a_vip_membership_third_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_the_advantages_of_a_vip_membership_fourth_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_the_advantages_of_a_vip_membership_fifth_text'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('what_are_the_advantages_of_a_vip_membership_sixth_text'); ?></li>
						</ul>											
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('what_happens_when_my_vip_membership_ends'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('what_happens_when_my_vip_membership_ends_ans_text'); ?></p>
					</div>
									
					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_can_i_cancel'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('how_can_i_cancel_my_vip_membership_ans_text'); ?></p>
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_can_i_change_my_email_address'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('how_can_i_change_my_email_address_ans_text'); ?></p>				
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('how_can_i_change_my_username'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('how_can_i_change_my_username_ans_text'); ?></p>			
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('what_do_i_do_when_i_forgot_my_password'); ?></div>
					<div class="lilo-accordion-content">
						<p class="fourteen"><?php echo $this->lang->line('what_do_i_do_when_i_forgot_my_password_ans_text'); ?></p>
					</div>

					<div class="lilo-accordion-control"><?php echo $this->lang->line('the_following_things_can_only_be_changed_by_sugarbabe_deluxe'); ?></div>
					<div class="lilo-accordion-content">
						<ul class="fqUl padding_zero">
							<li class="fourteen os"><?php echo $this->lang->line('username'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('activation_of_the_profile_after_deactivation'); ?></li>
							<li class="fourteen os"><?php echo $this->lang->line('date_of_birth'); ?></li>
						</ul>											
					</div>

				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 padding_zero">
				<h4 class="fqTtl fqYllow"><?php echo $this->lang->line('if_you_dont_find_your_answer_feel_free_to_ask_us'); ?></h4>
				<form class="contact_form" action="<?php echo base_url('page/faq'); ?>" method="POST">	
					<div class="text-left email_box">
						<div class="row">
							<div class="col-md-12">
								<input class="email_add" type="text" name="full_name" placeholder="<?php echo $this->lang->line('username'); ?>" id="username" autocomplete="off" maxlength="38" value="<?php echo set_value('full_name'); ?>">
								<?php echo form_error('full_name'); ?>
							</div>
							<div class="col-md-6">
								<input class="email_add" type="text" name="email_address" placeholder="<?php echo $this->lang->line('email_address'); ?>" id="email" autocomplete="off" maxlength="38" value="<?php echo set_value('email_address'); ?>">
								<?php echo form_error('email_address'); ?>
							</div>
							<div class="col-md-6">
								<input class="email_add" type="tel" name="phone_number" placeholder="<?php echo $this->lang->line('phone_number'); ?>" id="phone" autocomplete="off" maxlength="38" value="<?php echo set_value('phone_number'); ?>">
								<?php echo form_error('phone_number'); ?>
							</div>
							<div class="col-md-12">
								<textarea class="email_add" type="text" name="message" placeholder="<?php echo $this->lang->line('question'); ?>" id="message"><?php echo set_value('message'); ?></textarea>
								<?php echo form_error('message'); ?>
							</div>
							<div class="col-md-6">
								<img id="captcha_image_url" src="<?php echo $captcha_image_url; ?>" style="margin-top: 10px;width:100%;height:45px;" /></label>
							</div>
							<div class="col-md-6">
								<input type="hidden" name="captcha_text_ans" value="<?php echo $this->session->userdata('captcha_text'); ?>">
								<input class="email_add" name="captcha_text" type="text" placeholder="<?php echo $this->lang->line('enter_image_text_here'); ?>" value="" autocomplete="off" maxlength="38">
								<?php echo form_error('captcha_text'); ?>
							</div>							
							<div class="col-md-12 text-right">
								<button class="buy_nw_credit btn_hover" type="submit"><?php echo $this->lang->line('send_message'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>	

	<!--FAQ div-->
	</div>		
</section>

<?php
	$this->load->view('templates/footers/main_footer');
?>