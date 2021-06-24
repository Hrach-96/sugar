<?php $this->load->view('templates/headers/main_header', $title); ?>


<?php if($this->session->has_userdata('message')) { ?>
<section class="messages">
	<div class="alert tag-alert-golden alert-dismissible fade in">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php echo $this->lang->line($this->session->userdata('message')); $this->session->unset_userdata('message'); ?>
	</div>
</section>
<?php } ?>

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

<section class="buy_credit fstBxMob">
	<div class="container">
		<!-- <div class="row">
			<div class="col-md-12 buyCreditBrd">
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
         			<span class="byDiamonds"><?php echo $this->lang->line('buy_credit_to_unlock_more_levels'); ?></span>
        		</h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('and_get_in_contact_with_more_and_more_people'); ?></h4>
				<p class="buy_p"></p>
			</div>
		</div>
		<div class="row byCreditRw">
			<?php 
				if(!empty($credit_packages)) {
					$coin_img_index = 0;
					foreach ($credit_packages as $package_row) {
			?>			
			<div class="col-md-3 col-sm-6 col-xs-12 text-center">
				<img src="<?php echo base_url($coin_image[$coin_img_index++]); ?>" alt="">
				<h4 class="crdit_thmb_h4"><?php echo $package_row['package_credits'].' '.$this->lang->line('credits'); ?></h4>	
				<h4 class="price_txt"><?php echo $package_row['package_amount']; ?> €</h4>
				<a class="buy_nw_credit btn_hover" href="<?php echo base_url('user/credits/buyCredit/'.$package_row['package_id']); ?>"><?php echo $this->lang->line('buy_now_credits'); ?></a>
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
				<!-- <h4 class="full-pay gold-txt"><span class="byDiamonds"><?php echo $this->lang->line('fully_safe_payments_methods'); ?></span></h4>	 -->
				<!-- <h4 class="get_in_touch"><?php echo $this->lang->line('buy_credit'); ?> - <?php echo $this->lang->line('vip_plans'); ?> - <?php echo $this->lang->line('diamonds_without_problem'); ?></h4> -->
				<h4 class="full-pay gold-txt"><span class="byDiamonds"><?php echo $this->lang->line('buy_now_credits'); ?></span></h4>
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

<?php $this->load->view('templates/footers/main_footer'); ?>