<?php
$this->load->view('templates/headers/main_header', $title);
$this->load->view('templates/sidebar/main_sidebar');
?>

<?php if($this->session->flashdata('message')) { ?>
<section class="messages">
	<div class="alert tag-alert-golden alert-dismissible fade in">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php echo $this->lang->line($this->session->flashdata('message')); ?>
	</div>
</section>
<?php } ?>

<section class="payment_method mPSection">
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="margin-top: -60px; ">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>		
		<div class="row">
			<div class="col-md-12 text-center">
				<h4 class="full-pay gold-txt">          
	          		<span class="vipPackage"><?php echo $this->lang->line('manage_profile'); ?></span>
	        	</h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('setup_your_email_address_password_and_much_more'); ?></h4>
			</div>					
		</div>
		<div class="row vip_box mPbox">					
			<div>
				<?php if($this->session->userdata('user_is_vip') == 'yes') { ?>
					<img src="<?php echo base_url('images/vip-user.png'); ?>" class="UserStImg">
					<h5 class="basisUsr"><?php echo $this->lang->line('vip_user'); ?></h5>
				<?php } else { ?>
					<img src="<?php echo base_url('images/basis-usr-gold.png'); ?>" class="UserStImg">
					<h5 class="basisUsr"><?php echo $this->lang->line('basis_user'); ?></h5>
				<?php } ?>
			</div>
		</div>
		
		<div class="row mpForms">
			<div class="col-md-12 col-xs-12 padding_zero">	
				<h4 class="mPtitle"><?php echo $this->lang->line('manage_your_email'); ?></h4>
				<h5 class="mSbtitle"><?php echo $this->lang->line('change_your_email_address'); ?></h5>
			</div>	
			<div class="col-md-12 padding_zero">
				<div class="text-left email_box">
					<div class="row">
						<div class="col-md-6 col-sm-6">								
							<input value="" class="email_add" type="email" placeholder="<?php echo $this->lang->line('old_email_address'); ?>" id="oldEmail" autocomplete="off" maxlength="38">
						</div>
						<div class="col-md-6 col-sm-6">
							<input class="email_add" type="email" placeholder="<?php echo $this->lang->line('new_email_address'); ?>" id="newEmail" autocomplete="off" maxlength="38">					
						</div>
						<div class="col-md-12 text-left">
							<a class="buy_nw_credit btn_hover" id="btn-change-email" href="javascript:void(0);"><?php echo $this->lang->line('update'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>		

		<div class="row mpForms">
			<div class="col-md-12 col-xs-12 padding_zero">	
				<h4 class="mPtitle"><?php echo $this->lang->line('manage_your_password'); ?></h4>
				<h5 class="mSbtitle"><?php echo $this->lang->line('change_your_password'); ?></h5>
			</div>	
			<div class="col-md-12 padding_zero">
				<div class="text-left email_box">
					<div class="row">
						<div class="col-md-4 col-sm-4">								
							<input class="email_add" type="password" placeholder="<?php echo $this->lang->line('old_password'); ?>" id="oldPwd" autocomplete="off" maxlength="38">
						</div>
						<div class="col-md-4 col-sm-4">
							<input class="email_add" type="password" placeholder="<?php echo $this->lang->line('new_password'); ?>" id="newPwd" autocomplete="off" maxlength="38">					
						</div>
						<div class="col-md-4 col-sm-4">
							<input class="email_add" type="password" placeholder="<?php echo $this->lang->line('repeat_new_password'); ?>" id="rptnewPwd" autocomplete="off" maxlength="38">					
						</div>
						<div class="col-md-12 text-left">
							<a class="buy_nw_credit btn_hover" id="btn-change-password" href="javascript:void(0);"><?php echo $this->lang->line('update'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>	
		
		<div class="row mpForms blckRow">	
			<div class="col-md-10 col-xs-12 col-sm-12 padding_zero">	
				<h4 class="mPtitle"><?php echo $this->lang->line('chat_online_switcher'); ?></h4>
				<h5 class="mSbtitle"><?php echo $this->lang->line('chat_online_switcher_info'); ?></h5>
			</div>	
			<div class="col-md-2 col-xs-12 col-sm-12 padding_zero onOff">	
				<div class="tglBtn">
					<span class="offlinespn <?php if($this->session->userdata('user_is_online') == 'no') { ?>offColor<?php } ?>"><?php echo $this->lang->line('offline'); ?></span>
					<input <?php if($this->session->userdata('user_is_vip') == 'no') { ?>disabled="true"<?php } ?> type="checkbox" id="switch1" <?php if($this->session->userdata('user_is_online') == 'yes') { ?>checked="true"<?php } ?> switch="none" />
					<label for="switch1" data-on-label="" data-off-label=""></label>
					<span class="onlinespn <?php if($this->session->userdata('user_is_online') == 'no') { ?>offColor<?php } ?>"><?php echo $this->lang->line('online'); ?></span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12 padding_zero pad_rgt">	
				<a class="buy_nw_credit btn_hover mpBtn" href="javascript:void(0);" data-toggle="modal" data-target="#deleteProfile" data-backdrop="static" data-keyboard="false"><?php echo $this->lang->line('delete_profile'); ?></a>
			</div>		
			<div class="col-md-4 col-sm-4 col-xs-12 padding_zero pad_rgt">
				<a class="buy_nw_credit btn_hover mpBtn" href="javascript:void(0);" data-toggle="modal" data-target="#deactivateProfile" data-backdrop="static" data-keyboard="false"><?php echo $this->lang->line('deactivate_profile'); ?></a>
			</div>		
			<div class="col-md-4 col-sm-4 col-xs-12 padding_zero pad_lft">
				<?php if($this->session->userdata('user_is_vip') == 'yes') { ?>
				<a class="buy_nw_credit btn_hover mpBtn" href="javascript:void(0);" data-toggle="modal" data-target="#updatetoVip" data-backdrop="static" data-keyboard="false"><?php echo $this->lang->line('cancel_vip_membership'); ?></a>
				<?php } ?>
			</div>
		</div>	
	</div>
</section>


<?php
$this->load->view('templates/footers/main_footer');
?>

		<!-- Delete Profile -->
<div class="modal fade transparent_mdl" id="deleteProfile" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content profileModals">
		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">×</button>
      		</div>
			<div class="modal-body">
				<section class="buy_credit">
					<form method="POST" action="<?php echo base_url('user/profile/deleteProfile'); ?>">
					<input type="hidden" name="delete_token" value="1DF45EF">
					<div class="byCreditChkout">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 class="full-pay gold-txt">
          							<span class="byCredits news_span"><?php echo $this->lang->line('are_you_sure_you_want_to_delete_your_profile_permanently'); ?></span>
        						</h4>
								<h4 class="get_in_touch" style="text-transform: initial;"><?php echo $this->lang->line('delete_profile_information_text'); ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 text-center prchsed_pln">
								<button type="submit" class="buy_nw_credit btn_hover" ><?php echo $this->lang->line('yes'); ?></button>
								<a data-dismiss="modal" class="buy_nw_credit btn_hover" href="javascript:void(0);"><?php echo $this->lang->line('no'); ?></a>
							</div>
						</div>
					</div>
					</form>
				</section>
			</div>
		</div>
	</div>
</div>
<!--Buy Credits Modal-->

<!-- Deactivate Profile -->
<div class="modal fade transparent_mdl" id="deactivateProfile" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content profileModals">
		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">×</button>
      		</div>
			<div class="modal-body">
					<section class="buy_credit">
					<form method="POST" action="<?php echo base_url('user/profile/deactivateProfile'); ?>">
					<input type="hidden" name="deactivate_token" value="1DF45EF">
					<div class="byCreditChkout">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 class="full-pay gold-txt">
          							<span class="byCredits news_span"><?php echo $this->lang->line('are_you_sure_you_want_to_deactivate_your_profile'); ?></span>
        						</h4>
								<h4 class="get_in_touch" style="text-transform: initial;"><?php echo $this->lang->line('deactivate_profile_information_text'); ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 text-center prchsed_pln">
								<button type="submit" class="buy_nw_credit btn_hover" ><?php echo $this->lang->line('yes'); ?></button>
								<a data-dismiss="modal" class="buy_nw_credit btn_hover" href="javascript:void(0);"><?php echo $this->lang->line('no'); ?></a>
							</div>
						</div>
					</div>
					</form>
				</section>
			</div>
		</div>
	</div>
</div>
<!--Deactivate Modal-->

<!-- updatetoVip modal -->
<div class="modal fade transparent_mdl" id="updatetoVip" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content profileModals">
		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">×</button>
      		</div>
			<div class="modal-body">
				<section class="buy_credit">
					<form method="POST" action="<?php echo base_url('user/profile/cancelVIPMembership'); ?>">
					<input type="hidden" name="cancel_vip_token" value="1DF45EF">
					<div class="byCreditChkout">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 class="full-pay gold-txt">
          							<span class="byCredits news_span"><?php echo $this->lang->line('are_you_sure_that_you_no_longer_want_to_be_a_vip_member'); ?></span>
        						</h4>
								<h4 class="get_in_touch" style="text-transform: initial;"><?php echo $this->lang->line('cancel_vip_memebership_information_text'); ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 text-center prchsed_pln">
								<button type="submit" class="buy_nw_credit btn_hover" ><?php echo $this->lang->line('yes'); ?></button>
								<a data-dismiss="modal" class="buy_nw_credit btn_hover" href="javascript:void(0);"><?php echo $this->lang->line('no'); ?></a>
							</div>
						</div>
					</div>
					</form>
				</section>
			</div>
		</div>
	</div>
</div>
<!--updatetoVip Modal-->