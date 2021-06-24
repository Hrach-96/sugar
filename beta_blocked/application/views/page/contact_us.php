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
			<div class="col-md-12">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>		
	</div>
	<div class="container contact_box rel">
		<div class="row abs">
			<div class="col-md-12 text-center">
				<h4 class="full-pay gold-txt contactTtl"><span><?php echo $this->lang->line('contact_us'); ?></span></h4>
				<p class="contact_p"><?php echo $this->lang->line('feel_free_to_ask_our_team_any_kind_of_question_or'); ?><br/> <?php echo $this->lang->line('help_we_are_completely_at_your_dispsoal_and_will_reply_shortly'); ?></p>
			</div>
		</div>
	</div>
</section>				

<section class="contact_container">
	<div class="container">
		<div class="row">
			<form class="contact_form" method="POST" action="" enctype="multipart/form-data">
				<div class="col-md-4 col-sm-4 padding_zero rel">
					<img src="<?php echo base_url('images/contact-back1.png'); ?>" class="contact_back abs" />
					<img src="<?php echo base_url('images/contact-back-small.png'); ?>" class="contact_back1 abs" />
				</div>
				<div class="col-md-8 col-sm-8 padding_zero">
					<div class="text-left email_box">
						<div class="row">
							<div class="col-md-6">								
								<input class="email_add" name="first_name" type="text" placeholder="<?php echo $this->lang->line('first_name'); ?>" id="firstname" value="<?php echo set_value('first_name'); ?>" autocomplete="off" maxlength="38">
								<?php echo form_error('first_name'); ?>
							</div>
							<div class="col-md-6">
								<input class="email_add" name="last_name" type="text" placeholder="<?php echo $this->lang->line('last_name'); ?>" id="lastname" value="<?php echo set_value('last_name'); ?>"  autocomplete="off" maxlength="38">
								<?php echo form_error('last_name'); ?>
							</div>
							<div class="col-md-6">
								<input class="email_add" name="email_address" type="email" placeholder="<?php echo $this->lang->line('email_address'); ?>" value="<?php echo set_value('email_address'); ?>"  id="email" autocomplete="off" maxlength="38">
								<?php echo form_error('email_address'); ?>
							</div>
							<div class="col-md-6">
								<input class="email_add" name="phone_number" type="tel" placeholder="<?php echo $this->lang->line('phone_number'); ?>" value="<?php echo set_value('phone_number'); ?>"  id="phone" autocomplete="off" maxlength="38">
								<?php echo form_error('phone_number'); ?>		
							</div>
							<div class="col-md-12">
								<textarea class="email_add" name="message" type="text" placeholder="<?php echo $this->lang->line('message'); ?>" id="message"><?php echo set_value('message'); ?></textarea>
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

							<div class="col-md-6 col-sm-6 text-left">
								<a class="buy_nw_credit btn_hover" id="attach_file" href="javascript:void(0);"><?php echo $this->lang->line('attach_file'); ?></a>
								<input style="visibility: hidden;" type="file" id="message_attachment" name="attachment" >
								<span id="attached_filename"></span>
							</div>
							<div class="col-md-6 col-sm-6 text-right">
								<button type="submit" class="sendBtnC buy_nw_credit btn_hover"><?php echo $this->lang->line('send_message'); ?></button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>		
	</div>		
</section>
<?php
	$this->load->view('templates/footers/main_footer');
?>