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
	    .voucherCodeAddField{
	    	background-color: rgb(255, 255, 255);
		    height: 50px;
		    padding: 0px 20px;
		    margin-top: 5px;
		    border: 0px;
		    font-size: 15px;
		    font-weight: 500;
		    color: #999999;
		    width: 100%;
	    }
	    .existVoucherAnswers{
	    	text-align:center!important;
	    	font-size: 18.62px!important;
	    	color: rgb(255, 255, 255)!important;
	    	text-transform: uppercase!important;
	    	font-weight: 500;
	    }
	    .display-none{
	    	display:none;
	    }
		@media only screen and (max-width: 728px) {
			.address-img {
				width: 100%;
			}
		}
	</style>
</head>
<body>

<div class="empty-box"></div>

<!--Buy Credit Modal-->
<div class="modal fade transparent_mdl" id="creditChkout" style="display: contents;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
        		<button type="button" class="close" onclick="javascript:window.location.href='<?php echo base_url('buy/credit'); ?>'" data-dismiss="modal">×</button>
      		</div>
			<div class="modal-body">
				<section class="buy_credit">
					<div class="byCreditChkout">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 class="full-pay gold-txt">
          							<span class="byCredits text-uppercase"><?php echo $this->lang->line('buy_credit'); ?></span>
          						</h4>
								<p class="u_r_prchsing"><?php echo $this->lang->line('you_are_purchasing'); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-6 col-xs-12 text-center prchsed_pln">
								<img style="width:170px;" src="<?php echo base_url('images/Gold-Coin-2.png'); ?>" alt="" class="purchased_coin">
							</div>
						</div>
						<div class="row email_box col-sm-12" id="user-personal-infomation">
					  		<div>
								<h2 class="text-center gold-txt reg-sub-title text-uppercase"><?php echo $this->lang->line('you_have_voucher_code'); ?></h2>
								<div class="selection_div">
									<div class="row">
										<label class="control control--radio col-md-4 col-md-offset-2 existVoucherAnswers"><?php echo $this->lang->line('ok'); ?>
				      						<input type="radio" name="voucher_code" value="yes" />
				      						<div class="control__indicator"></div>
				    					</label>
					 					<label class="control control--radio col-md-4 existVoucherAnswers"><?php echo $this->lang->line('skip'); ?>
				      						<input type="radio" name="voucher_code" value="no" />
				      						<div class="control__indicator"></div>
				    					</label>
				    					<div class="voucherCodeAddSection col-md-12 display-none">
				    						<div class='col-md-6 col-md-offset-3'>
				    							<input type='text' class='form-control voucherCodeAddField' placeholder="<?php echo $this->lang->line('code_voucher'); ?>">
				    							<div class="error text-danger promocode_error_message display-none"><?php echo $this->lang->line('promocode_are_not_exist'); ?></div>
				    						</div>
				    					</div>
									</div>
				      			</div>
				      		</div>
                            <div class="row">
                                <div class="col-md-12 text-center" style="padding-bottom: 30px;">
                                	<button class="buy_nw_credit btn_hover display-none btn_complete_voucher"><?php echo $this->lang->line('proceed');?></button>
								</div>
							</div>
						</div>						
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
	$(document).ready(function(){
		var choosed_version;
		$("input[name='voucher_code']").change(function() {
			$(".btn_complete_voucher").slideDown(200)
			choosed_version = $("input[type='radio'][name='voucher_code']:checked").val();
			if(choosed_version == 'yes'){
				$(".voucherCodeAddSection").slideDown(200)
			}
			else{
				$(".voucherCodeAddSection").slideUp(200)
			}
		});
		$(document).on("click",".btn_complete_voucher",function(){
			var voucher_code = $(".voucherCodeAddField").val();
			if(choosed_version == 'yes'){
				$.ajax({
					type:"post",
					url:"/user/vouchers/getVoucherInfo",
					data:{voucher_code:voucher_code},
					success:function(res){
						res = JSON.parse(res);
						if(res != null){
							window.location.replace("<?php echo base_url('user/credits/buyCredit/'.$package_id); ?>?voucher_code=" + voucher_code);
						}
						else{
							$(".promocode_error_message").slideDown();
						}
					}
				})
			}
			else{
				window.location.replace("<?php echo base_url('user/credits/buyCredit/'.$package_id); ?>");
			}
		})
	})
</script>
</body>
</html>