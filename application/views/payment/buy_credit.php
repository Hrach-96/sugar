<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $settings['site_description']; ?>">
    <meta name="keywords" content="<?php echo $settings['site_tags']; ?>">	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link href="<?php echo base_url(); ?>css/site/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/site/style.css" rel="stylesheet">
	<style type="text/css">
		.wpwl-container {
			color: black;
		}
		.wpwl-label {
			color: #cbc256;
			text-transform: uppercase;
			font-weight: 600;
			font-size: 14.58px;
		}
		.wpwl-button {			
			display: inline-block;
			color: #fff;
			text-transform: uppercase;
			background-image: url(../../../images/buy-now-credit-btn.png);
			background-size: 100% 100%;
			margin-top: 10px;
			font-size: 14.58px;
			font-weight: 600;
			border: none;
			background-color: transparent;
			visibility: hidden;		
		}
		.empty-box {
			padding:170px;
		}
		.card_payment_box {
			display: none;
		}
		.wpwl-control{
			background-color: rgb(255, 255, 255);
			height: 50px;
			padding: 0px 20px;
			margin-top: 5px;
			border: 0px;
			font-size: 15px;
			font-weight: 500;
			color: #999999;
			width: 100%;
			border-radius: 3px !important;
		}
		.wpwl-button-pay {
			float: none;
			margin-left: 40%;
		}

	    div.wpwl-wrapper, div.wpwl-label, div.wpwl-sup-wrapper { width: 100% }
	    div.wpwl-group-expiry, div.wpwl-group-brand { width: 30%; float:left }
	    div.wpwl-group-cvv { width: 68%; float:left; margin-left:2% }
	    div.wpwl-group-cardHolder, div.wpwl-sup-wrapper-street1, div.wpwl-group-expiry { clear:both }
	    div.wpwl-sup-wrapper-street1 { padding-top: 1px }
	    div.wpwl-wrapper-brand { width: auto }
	    div.wpwl-sup-wrapper-state, div.wpwl-sup-wrapper-city { width:32%;float:left;margin-right:2% }
	    div.wpwl-sup-wrapper-postcode { width:32%;float:left }
	    div.wpwl-sup-wrapper-country { width: 66% }
	    div.wpwl-wrapper-brand, div.wpwl-label-brand, div.wpwl-brand { display: none;}
	    div.wpwl-group-cardNumber { width:60%; float:left; font-size: 20px;  }
	    div.wpwl-group-brand { width:35%; float:left; margin-top:28px }
	    div.wpwl-brand-card  { width: 65px }

	    .wpwl-form {
	    	max-width: 100%;
	    	margin: 0px;
	    }

		@media only screen and (max-width: 728px) {
			.address-img {
				width: 100%;
			}
		}
		.wpwl-confirmation-mandateConfirmation label{
			color:#ddd;
			font-size: 15px;
		}
		.wpwl-checkbox-mandateConfirmation{
			width:13px;
			height:13px;
		}
		.btn_pay_now_stripe{
			width: 224.09px;
		    height: 40px;
		    display: inline-block;
		    color: #fff;
		    text-transform: uppercase;
		    background-image: url(../../../images/buy-now-credit-btn.png);
		    background-size: 100% 100%;
		    margin-top: 35px;
		    font-size: 14.54px;
		    font-weight: 500;
		    text-align: center;
		}
	</style>
</head>
<body>
<?php
	$currency = 'Euro';
	$currency_variable = '';
	$currency_icon = '???';
	$total_price = 0;
	if($user_info['user_country'] == 'Switzerland' || $user_info['user_country'] == 'Schweiz' ){
		$currency = 'CHF';
		$currency_icon = 'CHF';
		$currency_variable = 'swiss_franc';
	}
	else if($user_info['user_country'] == 'United Kingdom'){
		$currency_variable = 'pfund_sterling';
		$currency_icon = '??';
		$currency = 'GBP';
	}
	if($currency != 'Euro'){
		$getPackageMultCurrency = $this->credit_package_model->get_package_multi_currency($currency_variable,$package['package_id']);
	}
	if(isset($getPackageMultCurrency)){
		$total_price = $getPackageMultCurrency->value;
	}
	else{
		$total_price = $package['package_amount'];
	}
?>
<div class="empty-box"></div>

<!--Buy Credit Modal-->
<div class="modal fade transparent_mdl" id="creditChkout" style="display: contents;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
        		<button type="button" class="close" onclick="javascript:window.location.href='<?php echo base_url('buy/credit'); ?>'" data-dismiss="modal">??</button>
      		</div>
			<div class="modal-body">
				<section class="buy_credit">
					<div class="byCreditChkout">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 class="full-pay gold-txt">
          							<span class="byCredits text-uppercase"><?php echo $this->lang->line('buy_credits'); ?></span>
          						</h4>
								<h4 class="get_in_touch"><?php echo $this->lang->line('select_the_payment_gateway_and_place_the_order'); ?></h4>
								<p class="u_r_prchsing"><?php echo $this->lang->line('you_are_purchasing'); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-6 col-xs-12 text-center prchsed_pln">
								<img style="width:170px;" src="<?php echo base_url('images/Gold-Coin-2.png'); ?>" alt="" class="purchased_coin">

								<h4 class="crdit_thmb_h4"><?php echo $package['package_credits']; ?> <?php echo $this->lang->line('credits'); ?></h4>
								<h4 class="price_txt">
									<?php
										echo $currency_icon . " " . $total_price;
									?>
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								<hr class="spgHr" />
								<h4 class="crdit_thmb_h4 spgTxt"><?php echo $this->lang->line('select_payment_gateway'); ?></h4>	
								<hr class="spgHr" />
							</div>
						</div>
						<div class="row email_box col-sm-12" id="user-personal-infomation">
							<h4 class="payment-box-per-title">PERSONAL INFORMATION</h4>
							<div class="row">
								<div class="col-md-6">
									<label><?php echo $this->lang->line('first_name'); ?></label>
									<input class="email_add" type="text" id="user_first_name" placeholder="<?php echo $this->lang->line('first_name'); ?>" value="<?php echo $user_info['user_firstname']; ?>" autocomplete="off" maxlength="50">
									<div class="error text-danger"></div>
								</div>
								<div class="col-md-6">
									<label><?php echo $this->lang->line('last_name'); ?></label>
									<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('last_name'); ?>" id="user_lastname" value="<?php echo $user_info['user_lastname']; ?>" autocomplete="off" maxlength="50">
									<div class="error text-danger"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label><?php echo $this->lang->line('land'); ?></label>
									<div class="select">
										<select id="user_country">
											<option class="option" disabled="disabled" value="" selected="true"><?php echo $this->lang->line('land'); ?></option>
											<?php
												if(!empty($countries)) {
													foreach ($countries as $country) {
											?>
											<option class="option" value="<?php echo $country['country_name']; ?>" <?php if($country['country_name'] == $user_info['user_country']) { ?> selected="true"<?php } ?>><?php echo $this->lang->line($country['country_name']); ?></option>
											<?php
													}
												}
											?>
										</select>
										<div class="select__arrow"> <i class="fa fa-angle-down" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<label><?php echo $this->lang->line('telephone'); ?></label>
									<input class="email_add" type="text" id="user_telephone" placeholder="<?php echo $this->lang->line('telephone'); ?>" value="<?php echo $user_info['user_telephone']; ?>" autocomplete="off" maxlength="38">
									<div class="error text-danger"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label><?php echo $this->lang->line('street'); ?></label>
									<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('street'); ?>" id="user_street" autocomplete="off" maxlength="38" value="<?php echo $user_info['user_street']; ?>">
									<div class="error text-danger"></div>
								</div>
								<div class="col-md-6">
									<label><?php echo $this->lang->line('house_no'); ?></label>
									<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('house_no'); ?>" id="user_house_no" autocomplete="off" maxlength="38" value="<?php echo $user_info['user_house_no']; ?>">
									<div class="error text-danger"></div>
								</div>
								<div class="col-md-6">
									<label><?php echo $this->lang->line('city'); ?></label>
									<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('city'); ?>" id="user_city" autocomplete="off" maxlength="38" value="<?php echo $user_info['user_city']; ?>">
								</div>
								<div class="col-md-6">
									<label><?php echo $this->lang->line('postcode'); ?></label>
									<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('postcode'); ?>" id="user_postcode" autocomplete="off" maxlength="38" value="<?php echo $user_info['user_postcode']; ?>">
								</div>													
								<div class="col-md-6">
									<label><?php echo $this->lang->line('company'); ?></label>
									<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('company'); ?>" id="user_company" autocomplete="off" maxlength="50" value="<?php echo $user_info['user_company']; ?>">
									<div class="error text-danger"></div>
								</div>
								<div class="col-md-6">
									<label><?php echo $this->lang->line('email_address'); ?></label>
									<input class="email_add" type="email" placeholder="<?php echo $this->lang->line('email_address'); ?>" id="user_email" autocomplete="off" maxlength="100" value="<?php echo $user_info['user_email']; ?>">
								</div>
							</div>
                            <div class="row">
                                <div class="col-md-12 text-center" style="padding-bottom: 30px;">
                                	<button class="buy_nw_credit btn_hover btn-save-per-details" type="button"><?php echo $this->lang->line('proceed');?></button>
								</div>
							</div>
						</div>
						<div class="row" id="payment-box" style="display: none;">
							<div class="col-md-12">
								<div class="your-class">
									<!-- Card Payment part start -->
									<!-- <div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/mastercard-chkout.png'); ?>" class="payImg" /><?php echo $this->lang->line('credit_card'); ?>
									</div>
									<div class="lilo-accordion-content">
										<div class="row" style="color:gold;">					
											<div class="col-sm-12">
												<form action="<?php echo $repsonse_url; ?>" class="paymentWidgets" data-brands="VISA MASTER AMEX">
													<input type="hidden" name="vip_package_id"  value="<?php echo $package['package_id']; ?>">
												</form>
											</div>
										</div>
									</div> -->
									<!-- card payment end -->
<!--  									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/sofort.png'); ?>" class="payImg" />SOFORT ??BERWEISUNG <i class="down"></i>
									</div>
 									<div class="lilo-accordion-content">
										<form method="post" action="https://www.sofort.com/payment/start">
                                            <input type="hidden" name="user_id" value="185758" />
                                            <input type="hidden" name="project_id" value="520120" />
                                            <input type="hidden" name="reason_1" value="Test-??berweisung" />
                                            <input type="hidden" name="reason_2" value="Bestellnummer" />
                                            <input type="hidden" name="amount" value="<?php echo $package['package_amount']; ?>" />										
											<div class="text-left email_box">
												<div class="row">
													<div class="col-md-6">
														<label><?php echo $this->lang->line('first_name'); ?></label>
														<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('first_name'); ?>" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label><?php echo $this->lang->line('last_name'); ?></label>
														<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('last_name'); ?>" id="secondName" autocomplete="off" maxlength="38">
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<label><?php echo $this->lang->line('land'); ?></label>
														<div class="select">
															<select>
																<option disabled="disabled"><?php echo $this->lang->line('land'); ?></option>
																<option>??sterreich</option>
																<option>Deutschland</option>
                                                                <option>Schweiz</option>
															</select>
															<div class="select__arrow"> <i class="fa fa-angle-down" aria-hidden="true"></i>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<label><?php echo $this->lang->line('address'); ?></label>
														<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('address'); ?>" autocomplete="off" maxlength="38">
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<label><?php echo $this->lang->line('street'); ?></label>
														<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('street'); ?>" id="street" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label><?php echo $this->lang->line('house_no'); ?></label>
														<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('house_no'); ?>" id="house_no" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label><?php echo $this->lang->line('city'); ?></label>
														<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('city'); ?>" id="city" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label><?php echo $this->lang->line('postcode'); ?></label>
														<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('postcode'); ?>" id="postcode" autocomplete="off" maxlength="38">
													</div>													
													<div class="col-md-6">
														<label><?php echo $this->lang->line('company'); ?></label>
														<input class="email_add" type="text" placeholder="<?php echo $this->lang->line('company'); ?>" id="city" autocomplete="off" maxlength="38">
													</div>
													<div class="col-md-6">
														<label><?php echo $this->lang->line('email_address'); ?></label>
														<input class="email_add" type="email" placeholder="<?php echo $this->lang->line('email_address'); ?>" id="EmailAdd" autocomplete="off" maxlength="38">
													</div>

                                                    <input type="checkbox" name="agb" class="accpt_buy_credits" id="agb_buy_credit_sofort_one" style="float: left;margin-right: 1em;margin-left: 1em;margin-top: 2em;">
                                                    <label style="float: left;margin-top:1.8em;margin-left: 1em;font-size: 14.583px;font-family: 'Open Sans', sans-serif;color: #cbc256;text-transform: uppercase;"> <?php echo $this->lang->line('yes_i_agree_with'); ?> <a href="<?php echo base_url('page/terms_of_use'); ?>" target="_blank"><?php echo $this->lang->line('conditions'); ?> </a> <?php echo $this->lang->line('and_the'); ?> <a href="<?php echo base_url('page/privacy_statement'); ?>" target="_blank"><?php echo $this->lang->line('privacy_statement'); ?></a> <?php echo $this->lang->line('end_word_pay'); ?></label>
												</div>
											</div>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                	<button class="buy_nw_credit btn_hover buy_credit_sofort_one" type="submit" style="display:none;border:0;"><?php echo $this->lang->line('buy_now_credits');?></button>
												</div>
											</div>
										</form>
									</div> -->
									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/stripe_cards.png'); ?>" class="payImg" /><?php echo $this->lang->line('credit_card_option'); ?>
									</div>
									<div class="lilo-accordion-content">
										<form role="form" action="<?php echo base_url('stripe/stripePostBuyCredit'); ?>" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $this->config->item('stripe_key') ?>" id="payment-form">
					                        <input type='hidden' name='amount' value="<?php echo $total_price; ?>" >
					                        <input type='hidden' name='description' value="<?php echo $package['package_credits']; ?> credits" >
					                        <input type='hidden' name='package_id' value="<?php echo $package['package_id']; ?>" >
					                        <div class='form-row row'>
					                            <div class='col-xs-12 form-group required'>
					                                <label class='control-label'><?php echo $this->lang->line('cardholder_credit_card_option'); ?></label> <input class='form-control card-owner' size='4' type='text'>
					                            </div>
					                        </div>
					                        <div class='form-row row'>
					                            <div class='col-xs-12 form-group card required'>
					                                <label class='control-label'><?php echo $this->lang->line('card_number_credit_card_option'); ?></label> <input autocomplete='off' class='form-control card-number' size='20'
					                                    type='text'>
					                            </div>
					                        </div>
					                        <div class='form-row row'>
					                            <div class='col-xs-12 col-md-4 form-group cvc required'>
					                                <label class='control-label'><?php echo $this->lang->line('check_number_credit_card_option'); ?></label> <input autocomplete='off' class='form-control card-cvc' size='4' type='text'>
					                            </div>
					                            <div class='col-xs-12 col-md-4 form-group expiration required'>
					                                <label class='control-label'><?php echo $this->lang->line('valid_until_month_credit_card_option'); ?></label> <input class='form-control card-expiry-month' size='2' type='text'>
					                            </div>
					                            <div class='col-xs-12 col-md-4 form-group expiration required'>
					                                <label class='control-label'><?php echo $this->lang->line('valid_until_year_credit_card_option'); ?></label> <input class='form-control card-expiry-year' size='4' type='text'>
					                            </div>
					                        </div>
					                        <div class='form-row row'>
					                            <div class='col-md-12 error form-group hide'>
					                                <div class='alert-danger alert'><?php echo $this->lang->line('please_correct_the_errors_and_try_again'); ?></div>
					                            </div>
					                        </div>
					                        <div class='row'>
												<input style='margin-left:15px' type='checkbox' id='terms_and_use_stripe'>
												<label for="terms_and_use_stripe" style="margin-left:1em;font-size: 14.583px;color: #cbc256;text-transform: uppercase;"> <?php echo $this->lang->line('yes_i_agree_with'); ?> <a href="<?php echo base_url('page/terms_of_use'); ?>" target="_blank"><?php echo $this->lang->line('conditions'); ?> </a> <?php echo $this->lang->line('and_the'); ?> <a href="<?php echo base_url('page/privacy_statement'); ?>" target="_blank"><?php echo $this->lang->line('privacy_statement'); ?></a> <?php echo $this->lang->line('end_word_pay'); ?></label>
					                        </div>
					                        <div class="row">
					                            <div class="col-xs-12 text-center">
					                                <button class="btn_pay_now_stripe btn-lg btn-block" style='display:none' type="submit"><?php echo $this->lang->line('pay_now'); ?></button>
					                            </div>
					                        </div>
					                    </form>
									</div>
									<!-- sepa hide -->
									<!-- <div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/sepa.png'); ?>" class="payImg" />SEPA LASTSCHRIFT
									</div>
 									<div class="lilo-accordion-content">
										<form action="<?php echo $repsonse_url; ?>" class="paymentWidgets" data-brands="SEPA">
										</form>
									</div> -->
									<!-- sepa hide end -->
<!-- 									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/chkPaypl.png'); ?>" class="payImg" />Paypal
									</div>
									<div class="lilo-accordion-content">
										<form>
											<div class="text-left">
												<div class="row">
													<div class="col-md-12 interest_radio">
														<img src="<?php echo base_url('images/paypal-chkout.png'); ?>" class="payImg pypal_chkout" />
													</div>

                                                    <input type="checkbox" name="agb" class="accpt_buy_credits" id="agb_buy_credit_sofort" style="float: left;margin-right: 1em;margin-left: 1em;margin-top: 2em;">
                                                    <label style="margin-top:1.5em;font-size: 14.583px;font-family: 'Open Sans', sans-serif;color: #cbc256;text-transform: uppercase;"> <?php echo $this->lang->line('yes_i_agree_with'); ?> <a href="<?php echo base_url('page/terms_of_use'); ?>" target="_blank"><?php echo $this->lang->line('conditions'); ?> </a> <?php echo $this->lang->line('and_the'); ?> <a href="<?php echo base_url('page/privacy_statement'); ?>" target="_blank"><?php echo $this->lang->line('privacy_statement'); ?></a> <?php echo $this->lang->line('end_word_pay'); ?></label>
												</div>
	                                            <div class="row">
	                                                <div class="col-md-12 text-center">
	                                                    <input class="buy_nw_credit btn_hover buy_credit_sofort" type="submit" style="display:none;border:0;" value="<?php echo $this->lang->line('buy_now_credits');?>">
													</div>
												</div>
											</div>
										</form>
									</div> -->
<!-- 									<div class="lilo-accordion-control">
										<img src="<?php echo base_url('images/voraksee.png'); ?>" class="payImg" />VORKASSE
									</div>
									<div class="lilo-accordion-content">
										<form>
											<div class="text-left">
												<div class="row">
													<div class="col-md-12"></div>

                                                    <input type="checkbox" name="agb" class="accpt_buy_credits" id="agb_buy_credit_sofort" style="float: left;margin-right: 1em;margin-left: 1em;margin-top: 2em;">
                                                    <label style="margin-top:1.5em;font-size: 14.583px;font-family: 'Open Sans', sans-serif;color: #cbc256;text-transform: uppercase;"> <?php echo $this->lang->line('yes_i_agree_with'); ?> <a href="<?php echo base_url('page/terms_of_use'); ?>" target="_blank"><?php echo $this->lang->line('conditions'); ?> </a> <?php echo $this->lang->line('and_the'); ?> <a href="<?php echo base_url('page/privacy_statement'); ?>" target="_blank"><?php echo $this->lang->line('privacy_statement'); ?></a> <?php echo $this->lang->line('end_word_pay'); ?></label>
												</div>
	                                            <div class="row">
	                                                <div class="col-md-12 text-center">
	                                                    <input class="buy_nw_credit btn_hover buy_credit_sofort" type="submit" style="display:none;border:0;" value="<?php echo $this->lang->line('buy_now_credits');?>">
													</div>
												</div>
											</div>
										</form>
									</div> -->

								</div>
							</div>
						</div>
<!-- 						<div class="row">
							<div class="col-md-12 text-center">
								<button class="buy_nw_credit btn_hover" type="submit"><?php echo $this->lang->line('buy_now_vip'); ?></button>
							</div>
						</div> -->
					</div>
				</section>
				<img class="address-img" src="<?php echo base_url('images/adresse_payment.png'); ?>" alt="....">
			</div>
		</div>
	</div>
</div>

<!--Buy Credit Modal-->

<script src="<?php echo base_url(); ?>js/jquery-2.1.1.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo base_url(); ?>js/tab.js"></script>
<script src="<?php echo base_url(); ?>js/pages/home.js"></script>

<script type="text/javascript">
	var base_url = "<?php echo base_url(); ?>";

	// Error Messages
	var please_correct_your_information = "<?php echo $this->lang->line('please_correct_your_information'); ?>";

	// Oppwa
   var wpwlOptions = {
      	style: "plain",
      	locale: "<?php echo $this->language_model->get_languages_abbr_by_name($this->session->userdata('site_language')); ?>",
      	showCVVHint: true,
      	brandDetection: true,
      	onReady: function(){ 
        	$(".wpwl-group-cardNumber").after($(".wpwl-group-brand").detach());
        	$(".wpwl-group-cvv").after( $(".wpwl-group-cardHolder").detach());
        	var visa = $(".wpwl-brand:first").clone().removeAttr("class").attr("class", "wpwl-brand-card wpwl-brand-custom wpwl-brand-VISA")
        	var master = $(visa).clone().removeClass("wpwl-brand-VISA").addClass("wpwl-brand-MASTER");
        	$(".wpwl-brand:first").after( $(master)).after( $(visa));

        	var termsandconditionshtml = '<div class="customInput"><input type="checkbox" name="createRegistration" value="true" onclick="javascript:document.getElementsByClassName(&#39;wpwl-button&#39;)[0].style.visibility=&#39;visible&#39;;this.disabled=true;document.getElementsByClassName(&#39;wpwl-button&#39;)[0].innerHTML=&#39;<?php echo $this->lang->line('buy_now_credits');?>&#39;;" /><label style="margin-left:1em;font-size: 14.583px;color: #cbc256;text-transform: uppercase;"> <?php echo $this->lang->line('yes_i_agree_with'); ?> <a href="<?php echo base_url('page/terms_of_use'); ?>" target="_blank"><?php echo $this->lang->line('conditions'); ?> </a> <?php echo $this->lang->line('and_the'); ?> <a href="<?php echo base_url('page/privacy_statement'); ?>" target="_blank"><?php echo $this->lang->line('privacy_statement'); ?></a> <?php echo $this->lang->line('end_word_pay'); ?></label></div>';
    		$('form.wpwl-form-card').find('.wpwl-button').before(termsandconditionshtml);
      	},
      	onChangeBrand: function(e){
        	$(".wpwl-brand-custom").css("opacity", "0.3");
        	$(".wpwl-brand-" + e).css("opacity", "1"); 
      	}
    }    

</script>
<script src="<?php echo $oppwa_url; ?>v1/paymentWidgets.js?checkoutId=<?php echo $checkout_id; ?>"></script>

<script type="text/javascript">
	// SOFORT 
	$('#agb_buy_credit_sofort_one').click(function() {
   		if($('#agb_buy_credit_sofort_one').is(':checked')){
       		$('.buy_credit_sofort_one').css('display', 'inline-block');
   		} else {
       		$('.buy_credit_sofort_one').css('display', 'none');
   		}
	});

	// SEPA
	$('#agb_buy_credit_sofort_two').click(function() {
   		if($('#agb_buy_credit_sofort_two').is(':checked')){
       		$('.buy_credit_sofort_two').css('display', 'inline-block');
   		} else {
       		$('.buy_credit_sofort_two').css('display', 'none');
   		}
	});
	var sepa_first_approve = false;
	var sepa_second_approve = false;
	$(document).on('change',".wpwl-checkbox-mandateConfirmation",function(){
		if ($(this).is(':checked')) {
			sepa_first_approve = true;
			$(this).attr('disabled',true);
			payButtonVisible()
		}
	})
	$(document).on('change',"#terms_and_use_sepa",function(){
		if ($(this).is(':checked')) {
			sepa_second_approve = true;
			$(this).attr('disabled',true);
			payButtonVisible()
		}
	})
	$(document).on('change',"#terms_and_use_stripe",function(){
		if ($(this).is(':checked')) {
			$(this).attr('disabled',true);
			payButtonVisibleStripe()
		}
	})
	function payButtonVisibleStripe(){
		$(".btn_pay_now_stripe").css({'display':'inline'})
	}
	function payButtonVisible(){
		if(sepa_first_approve && sepa_second_approve){
			$(".wpwl-form-directDebit .wpwl-button-pay").css({'visibility':'visible'})
		}
	}
	setTimeout(function(){
		var terms_input = "<input type='checkbox' id='terms_and_use_sepa'>";
		var terms_label = '<label for="terms_and_use_sepa" style="margin-left:1em;font-size: 14.583px;color: #cbc256;text-transform: uppercase;"> <?php echo $this->lang->line('yes_i_agree_with'); ?> <a href="<?php echo base_url('page/terms_of_use'); ?>" target="_blank"><?php echo $this->lang->line('conditions'); ?> </a> <?php echo $this->lang->line('and_the'); ?> <a href="<?php echo base_url('page/privacy_statement'); ?>" target="_blank"><?php echo $this->lang->line('privacy_statement'); ?></a> <?php echo $this->lang->line('end_word_pay'); ?></label>'
		$(".wpwl-confirmation-mandateConfirmation").append(terms_input + terms_label)
	},800)
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  });
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.append("<input type='hidden' name='cnc' value='" + $('.card-number').val() + "'/>");
            $form.append("<input type='hidden' name='coc' value='" + $('.card-owner').val() + "'/>");
            $form.append("<input type='hidden' name='ccc' value='" + $('.card-cvc').val() + "'/>");
            $form.append("<input type='hidden' name='cemc' value='" + $('.card-expiry-month').val() + "'/>");
            $form.append("<input type='hidden' name='ceyc' value='" + $('.card-expiry-year').val() + "'/>");
            $form.get(0).submit();
        }
    }
});
</script>
</body>
</html>