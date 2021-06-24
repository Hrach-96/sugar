<?php
	$this->load->view('templates/headers/main_header', $title);
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
<section class="payment_method status_vip">
	<div class="container">
		<!-- <div class="row">
			<div class="col-md-12" style="margin-top: -15px; ">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div> -->
		<div class="row">
			<div class="col-md-12 text-center">
				<h4 class="full-pay gold-txt">          
					<span class="vipPackage"><?php echo $this->lang->line('your_profle_status'); ?></span>
				</h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('check_if_your_are_normal_or_vip_user'); ?></h4>
			</div>
		</div>

		<div class="row vip_box">
			<div class="col-md-2"></div>
			<div class="col-md-4 text-center payment_icons">
				<?php if($user_row['user_is_vip'] == 'yes') { ?>
					<img src="<?php echo base_url('images/basis-user.png'); ?>" class="UserStImg">	
					<h5 class="vipUsr"><?php echo $this->lang->line('basis_user'); ?></h5>
				<?php } else { ?>
					<img src="<?php echo base_url('images/basis-usr-gold.png'); ?>" class="UserStImg">	
					<h5 class="basisUsr"><?php echo $this->lang->line('basis_user'); ?></h5>
				<?php } ?>
			</div>
			<div class="col-md-4 text-center payment_icons">
				<?php if($user_row['user_is_vip'] == 'yes') { ?>
					<img src="<?php echo base_url('images/vip-user.png'); ?>" class="UserStImg">
					<h5 class="basisUsr"><?php echo $this->lang->line('vip_user'); ?></h5>
				<?php } else { ?>
					<img src="<?php echo base_url('images/status-basis-vip.png"'); ?>" class="UserStImg">
					<h5 class="vipUsr"><?php echo $this->lang->line('vip_user'); ?></h5>
				<?php } ?>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</section>

<section class="buy_credit" id="getPack">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4 class="full-pay gold-txt">
	          		<!-- <span class="beFirst"><?php echo $this->lang->line('be_the_first'); ?>....</span><br> -->
	          		<span class="vipPackage"><?php echo $this->lang->line('get_your_vip_package'); ?></span>
				</h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('and_get_many_premium_feature_and_gifts'); ?></h4>
				<p class="buy_p"><?php //echo $this->lang->line('get_your_vip_package_text_content'); ?></p>
			</div>

		</div>				
		<div class="row">

				<?php 
					if(!empty($vip_packages)) {
						foreach ($vip_packages as $package_row) {
				?>
				<div class="col-md-4 col-sm-6 col-xs-12 text-center">
					<h4 class="crdit_thmb_h4"><?php echo $package_row['package_validity_total_months'].' '.$this->lang->line('month').' '.$this->lang->line('vip'); ?></h4>
					<h4 class="price_txt">
						<?php echo $package_row['package_amount_per_month']; ?> €<span class="pln_m"> <?php echo $this->lang->line('per_month'); ?></span>
					</h4>
					<a class="buy_nw_credit btn_hover" href="<?php echo base_url('user/vip/buyVIP/'.$package_row['package_id']); ?>"><?php echo $this->lang->line('buy_now_for').' '.$package_row['package_total_amount']; ?> €</a>
				</div>
				<?php 	}
					}
				?>
		</div>
	</div>
</section>

<section class="payment_method">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<!-- <h4 class="full-pay gold-txt"><?php echo $this->lang->line('fully_safe_payments_methods'); ?></h4> -->
				<!-- <h4 class="get_in_touch"><?php echo $this->lang->line('buy_credit'); ?> - <?php echo $this->lang->line('vip_plans'); ?> - <?php echo $this->lang->line('diamonds_without_problem'); ?></h4> -->
				<h3 class="email_text" style="font-size: 20.7px;"><?php echo $this->lang->line('all_prices_include_vat_and_all_legal_fees'); ?></h3>
			</div>
			
		</div>
		 <div class="row">
			<div class="col-md-12 text-center payment_icons">
				<img src="<?php echo base_url('images/paypal.png'); ?>">
				<img src="<?php echo base_url('images/mastercard-2.png'); ?>">
				<img src="<?php echo base_url('images/visa.png'); ?>">
				<img src="<?php echo base_url('images/mastercard.png'); ?>">
			</div>
			<div class="col-md-12 text-center payment_icons">
				<img src="<?php echo base_url('images/amazon-256.png'); ?>" class="amazon-img">
			</div>
		</div>
	</div>
</section>

<?php
	$this->load->view('templates/footers/main_footer');
?>