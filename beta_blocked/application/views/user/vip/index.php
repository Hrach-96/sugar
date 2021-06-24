<?php
	$this->load->view('templates/headers/main_header', $title);
?>

<style type="text/css">
	.wpwl-container {
		color: black;
	}
	.wpwl-label {
		color: white;	
	}
</style>

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

<section class="buy_credit vorteile-vip">
	<div class="container">
		<!-- <div class="row">
			<div class="col-md-12">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>	 -->	
		<div class="row">
			<div class="col-md-12 text-center vipHeading">
				<h4 class="full-pay gold-txt"><span class="vorteile"><?php echo $this->lang->line('advantages_vip'); ?></span></h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('and_get_in_contact_with_more_and_more_people'); ?></h4>
				<h5 class="vipSbttl"><?php echo $this->lang->line('become_vip_and_its_advantage_text'); ?></h5>
			</div>
		</div>
	</div>
</section>
		
<section class="buy_coin vip_tbl" id="vipTbl">
	<div class="container">
		<div class="row">
	  		<div class="col-xs-18 col-sm-12 col-md-12">
	  			<div class="table-responsive vip_tbl_div">
					<table>
  						<thead>
						    <tr>
						      <th><h4 class="full-pay gold-txt"><span class="funknen"><?php echo $this->lang->line('features'); ?></span></h4></th>
						      <th><h4 class="full-pay gold-txt"><span class="als_vip"><?php echo $this->lang->line('as_a_vip_member'); ?></span></h4></th>
						      <th><h4 class="full-pay gold-txt"><span class="als_vip"><?php echo $this->lang->line('as_a_basic_member'); ?></span></h4></th>
						    </tr>
  						</thead>
					  	<tbody>
						<?php 
							if(!empty($member_features)) {
								foreach ($member_features as $feature_row) {
						?>
					    <tr>
					      <td><?php echo $this->lang->line($feature_row['feature_name']); ?></td>
					      <td><?php if($feature_row['feature_value_type'] == 'value') { echo $feature_row['feature_vip_value']; } else  { if($feature_row['feature_vip_value'] == 'active') { echo '<img src="'.base_url('images/vip-tick.png').'">'; } else { echo '<img src="'.base_url('images/vip-cross.png').'">'; } } ?></td>
					      <td><?php if($feature_row['feature_value_type'] == 'value') { echo $feature_row['feature_basic_value']; } else  { if($feature_row['feature_basic_value'] == 'active') { echo '<img src="'.base_url('images/vip-tick.png').'">'; } else { echo '<img src="'.base_url('images/vip-cross.png').'">'; } } ?></td>
					    </tr>
						<?php } 
							} 
						?>
  						</tbody>
					</table>
        		</div>
        	</div>
    	</div>
	</div>
</section>
		
<section class="buy_coin">
	<div class="container">
		<div class="row">
			<div class="col-xs-18 col-sm-12 col-md-12 col-lg-12 become_vip_col text-center">
			<h4 class="full-pay gold-txt">
          <!-- <span class="beFirst"><?php echo $this->lang->line('be_the_first'); ?>....</span><br> -->
          <span class="vipPackage"><?php echo $this->lang->line('get_your_vip_package'); ?></span>
        </h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('and_get_many_premium_feature_and_gifts'); ?></h4>
				<p class="vip_p be-the-first"></p>
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
<!-- 					<h4 class="or_dmnds">
						<span class="pln_m"><?php echo $this->lang->line('or'); ?></span><?php echo $package_row['package_diamonds_per_month'].' '.$this->lang->line('diamonds'); ?><span class="pln_m"> <?php echo $this->lang->line('per_month'); ?></span>
					</h4>	 -->
					<a class="buy_nw_credit btn_hover" href="<?php echo base_url('user/vip/buyVIP/'.$package_row['package_id']); ?>"><?php echo $this->lang->line('buy_now_for').' '.$package_row['package_total_amount']; ?> €</a>
<!-- 					<a class="buy_nw_credit btn_hover btn-buy-vip-diamond-model" data-id="<?php echo $package_row['package_id']; ?>, <?php echo $package_row['package_validity_total_months']; ?>, <?php echo $package_row['package_total_diamonds']; ?>" href="javascript:void(0);"><?php echo $this->lang->line('reedem').' '.$package_row['package_total_diamonds'].' '.$this->lang->line('diamonds_now'); ?></a> -->
				</div>
				<?php 	}
					}
				?>
			</div>
		</div>
	</div>
</section>

<section class="vip_pay_mthd" id="vipMethod">
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
				<img src="<?php echo base_url('images/amazon-256.png'); ?>" class="amazon-img" style="display: inline;" >
			</div>
		</div>
	</div>
</section>

<!--Buy VIP Using Diamonds Modal-->
<div class="modal fade transparent_mdl" id="vipDiamondChkout" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="<?php echo base_url('user/vip/buyUsingDiamonds'); ?>" name="buy_vip" method="POST">
		<div class="modal-content">
			<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">×</button>
      		</div>
			<div class="modal-body">
				<section class="buy_credit">
					<div class="byCreditChkout">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 class="full-pay gold-txt">
          							<span class="byCredits"><?php echo $this->lang->line('buy_vip'); ?></span>
          						</h4>
								<p class="u_r_prchsing"><?php echo $this->lang->line('you_are_purchasing'); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-6 col-xs-12 text-center prchsed_pln">
								<img style="width:170px;" src="<?php echo base_url('images/vip-user.png'); ?>" alt="" class="purchased_coin">
								<input type="hidden" name="vip_package_id" id="vip_diamond_package_id" value="">
								<h4 class="crdit_thmb_h4"><span id="vip_diamond_package_months">0</span> <?php echo $this->lang->line('month').' '.$this->lang->line('vip'); ?></h4>	
								<h4 class="price_txt"><span id="vip_package_diamonds">0</span> <?php echo $this->lang->line('diamonds'); ?></h4>
								<button class="buy_nw_credit btn_hover" type="submit"><?php echo $this->lang->line('buy_now_vip'); ?></button>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		</form>
	</div>
</div>
<!--Buy VIP Using Diamonds Modal-->

<?php
	$this->load->view('templates/footers/main_footer');
?>
