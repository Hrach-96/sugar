<?php
$this->load->view('templates/headers/main_header', $title);
?>

<section class="buy_credit fstBxMob">
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="margin-top: -63px; ">
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
          			<span class="byDiamonds"><?php echo $this->lang->line('buy_diamonds'); ?></span>
        		</h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('and_buy_gifts_to_your_sugarbaby_on_our_online_shop'); ?></h4>
				<p class="buy_p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12 text-center">
				<img src="<?php echo base_url('images/buy-diamonds.png'); ?>" class="partenrs_img">
			</div>
		</div>
		<div class="row">
			<?php 
				if(!empty($diamond_packages)) {
					foreach ($diamond_packages as $package_row) {
			?>
				<div class="col-md-3 col-sm-6 col-xs-12 text-center">
					<h4 class="crdit_thmb_h4" style="font-size: 30.33px;"><?php echo $package_row['package_diamonds'].' '.$this->lang->line('diamonds'); ?></h4>
					<h4 class="price_txt"><?php echo $package_row['package_amount']; ?> €</h4>
					<a class="buy_nw_credit btn_hover btn-buy-diamond-model" data-id="<?php echo $package_row['package_id']; ?>, <?php echo $package_row['package_diamonds']; ?>, <?php echo $package_row['package_amount']; ?>" href="javascript:void(0);"><?php echo $this->lang->line('buy_now_diamonds'); ?></a>
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
				<h4 class="full-pay gold-txt">
					<span class="byDiamonds"><?php echo $this->lang->line('fully_safe_payments_methods'); ?></span>
				</h4>	
				<h4 class="get_in_touch"><?php echo $this->lang->line('buy_credit'); ?> - <?php echo $this->lang->line('vip_plans'); ?> - <?php echo $this->lang->line('diamonds_without_problem'); ?></h4>
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


<!--Buy Diamonds Modal-->
<div class="modal fade transparent_mdl" id="diamondChkout" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form action="<?php echo base_url('user/diamonds/buy'); ?>" name="buy_diamonds" method="POST">
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
          							<span class="byCredits"><?php echo $this->lang->line('buy_diamonds'); ?></span>
          						</h4>
								<h4 class="get_in_touch"><?php echo $this->lang->line('select_the_payment_gateway_and_place_the_order'); ?></h4>
								<p class="u_r_prchsing"><?php echo $this->lang->line('you_are_purchasing'); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-6 col-xs-12 text-center prchsed_pln">
								<img style="width: 470px;" src="<?php echo base_url('images/buy-diamonds.png'); ?>" alt="" class="purchased_coin">
								<input type="hidden" name="diamond_package_id" id="diamond_package_id" value="">
								<h4 class="crdit_thmb_h4"><span id="total_buy_diamonds">0</span> <?php echo $this->lang->line('diamonds'); ?></h4>	
								<h4 class="price_txt"><span id="total_buy_amount">0</span> €</h4>
								<button class="buy_nw_credit btn_hover" type="submit"><?php echo $this->lang->line('buy_now_diamonds'); ?></button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								<hr class="spgHr" />
								<h4 class="crdit_thmb_h4 spgTxt"><?php echo $this->lang->line('select_payment_gateway'); ?></h4>	
								<hr class="spgHr" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="your-class">
									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/mastercard-chkout.png'); ?>" class="payImg" /><?php echo $this->lang->line('credit_card'); ?>
									</div>
									<div class="lilo-accordion-content">
										<form id="login">
											<div class="text-left email_box">
												<div class="row">
													<div class="col-md-6">
														<label>Card Number</label>
														<input class="email_add" type="text" placeholder="1234-5678...." id="logusername" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-3">
														<label>Expiry Date</label>
														<input class="email_add" type="text" placeholder="DD/YY" id="expiryDate" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-3">
														<label>CCV</label>
														<input class="email_add" type="password" placeholder="CCV" id="cvv" autocomplete="off" maxlength="38">
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<label>Card Owner Name</label>
														<input class="email_add" type="email" placeholder="First and Second Name" id="CardOwnerName" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label>Email</label>
														<input class="email_add" type="email" placeholder="Email Address" id="OEmailId" autocomplete="off" maxlength="38">
													</div>
												</div>
											</div>
										</form>
									</div>
									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/sofort.png'); ?>" class="payImg" />SOFORT ÜBERWEISUNG <i class="down"></i>
									</div>
									<div class="lilo-accordion-content">
										<form>
											<div class="text-left email_box">
												<div class="row">
													<div class="col-md-6">
														<label>First Name</label>
														<input class="email_add" type="text" placeholder="First Name" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label>Second Name</label>
														<input class="email_add" type="text" placeholder="Second Name" id="secondName" autocomplete="off" maxlength="38">
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<label>Land</label>
														<div class="select">
															<select>
																<option>Land</option>
																<option>Option</option>
																<option>Option</option>
															</select>
															<div class="select__arrow"> <i class="fa fa-angle-down" aria-hidden="true"></i>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<label>Address</label>
														<input class="email_add" type="text" placeholder="Address" autocomplete="off" maxlength="38">
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<label>N</label>
														<input class="email_add" type="text" placeholder="N" id="N" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label>Plz</label>
														<input class="email_add" type="text" placeholder="Plz" id="plz" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label>City</label>
														<input class="email_add" type="text" placeholder="City" id="city" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label>Email Address</label>
														<input class="email_add" type="email" placeholder="Email Address" id="EmailAdd" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-12 interest_radio">
														<label class="control control--radio col-md-12 interest">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
															<input type="radio" name="radio">
															<div class="control__indicator"></div>
														</label>
													</div>
												</div>
											</div>
										</form>
									</div>
									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/sepa.png'); ?>" class="payImg" />SEPA LASTSCHRIFT
									</div>
									<div class="lilo-accordion-content">
										<form>
											<div class="text-left email_box">
												<div class="row">
													<div class="col-md-12">	<span class="bTitle">Bank Name : <span class="bDesc">Bank Name will go here</span></span>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">	<span class="bTitle">Account holder : <span class="bDesc">Bank account holder will go here</span></span>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">	<span class="bTitle">Iban : <span class="bDesc">Iban will go here</span></span>
													</div>
													<div class="col-md-6">	<span class="bTitle">bic/swift: : <span class="bDesc">bic/swift will go here</span></span>
													</div>
												</div>
											</div>
										</form>
									</div>
									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/chkPaypl.png'); ?>" class="payImg" />Paypal
									</div>
									<div class="lilo-accordion-content">
										<form>
											<div class="text-left">
												<div class="row">
													<div class="col-md-12 interest_radio">
														<label class="control control--radio col-md-12 interest chkout_radio padding_right_b">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
															<input type="radio" name="radio">
															<div class="control__indicator"></div>
														</label>
														<img src="<?php echo base_url('images/paypal-chkout.png'); ?>" class="payImg pypal_chkout" />
													</div>
												</div>
											</div>
										</form>
									</div>
									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/voraksee.png'); ?>" class="payImg" />VORKASSE
									</div>
									<div class="lilo-accordion-content">
										<form>
											<div class="text-left">
												<div class="row">
													<div class="col-md-12">
														<label class="control control--radio col-md-12 interest chkout_radio">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
															<input type="radio" name="radio">
															<div class="control__indicator"></div>
														</label>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<button class="buy_nw_credit btn_hover" type="submit"><?php echo $this->lang->line('buy_now_diamonds'); ?></button>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		</form>
	</div>
</div>
<!--Buy Diamonds Modal-->

<?php
$this->load->view('templates/footers/main_footer');
?>