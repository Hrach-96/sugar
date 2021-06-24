<?php
	$this->load->view('templates/headers/main_header', $title);
	$currency = 'Euro';
	$currency_icon = '€';
	$currency_variable = '';
	if($user_info['user_country'] == 'Switzerland' || $user_info['user_country'] == 'Schweiz'){
		$currency_icon = 'CHF';
		$currency = 'CHF';
		$currency_variable = 'swiss_franc';
	}
	else if($user_info['user_country'] == 'United Kingdom'){
		$currency_icon = '£';
		$currency_variable = 'pfund_sterling';
		$currency = 'GBP';
	}
	$uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
?>
<?php if($this->session->has_userdata('message')) { ?>
	<script>
        (function(w,e,b,g,a,i,n,s){w['ITCVROBJ']=a;w[a]=w[a]||function(){
            (w[a].q=w[a].q||[]).push(arguments)},w[a].l=1*new Date();i=e.createElement(b),
            n=e.getElementsByTagName(b)[0];i.async=1;i.src=g;n.parentNode.insertBefore(i,n)
        })(window,document,'script','https://analytics.webgains.io/cvr.min.js','ITCVRQ');
        ITCVRQ('set', 'trk.programId', 279725);
        ITCVRQ('set', 'cvr', {
            value: '3',
            currency: "<?php echo $currency ?>",
            language: 'de_DE',
            eventId: 1058855,
            orderReference : 'Hier Ihre eindeutige Referenz fuer die Bestellung',
            comment: '',
            multiple: '',
            checksum: '',
            items: '',
            customerId: '',
            voucherId: ''
        });
        ITCVRQ('conversion');
    </script>
    
<section class="messages">
	<div class="alert tag-alert-golden alert-dismissible fade in">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php echo $this->lang->line($this->session->userdata('message')); $this->session->unset_userdata('message'); ?>
	</div>
</section>
<?php } ?>
<?php if($this->session->has_userdata('webgain_script')) {
	$package_amount = $this->session->userdata('package_amount');
	$this->session->unset_userdata('package_amount');
	$this->session->unset_userdata('webgain_script');
	$voucher_used_code = '';
	if($this->session->has_userdata('voucher_used_code')){
		$voucher_used_code = $this->session->userdata('voucher_used_code');
		$this->session->unset_userdata('voucher_used_code');
	}
	$webgain_net_price = ($package_amount*5) /6;
	?>
	<script>
        (function(w,e,b,g,a,i,n,s){w['ITCVROBJ']=a;w[a]=w[a]||function(){
            (w[a].q=w[a].q||[]).push(arguments)},w[a].l=1*new Date();i=e.createElement(b),
            n=e.getElementsByTagName(b)[0];i.async=1;i.src=g;n.parentNode.insertBefore(i,n)
        })(window,document,'script','https://analytics.webgains.io/cvr.min.js','ITCVRQ');
        ITCVRQ('set', 'trk.programId', 279725);
        ITCVRQ('set', 'cvr', {
            value: "<?php echo $webgain_net_price ?>",
            currency: "<?php echo $currency ?>",
            language: 'de_DE',
            eventId: 1058855,
            orderReference : "<?php echo $uuid ?>",
            comment: '',
            multiple: '',
            checksum: '',
            items: '',
            customerId: '',
            voucherId: "<?php echo $voucher_used_code?>"
        });
        ITCVRQ('conversion');
    </script>
<?php } ?>
<?php if($this->session->has_userdata('data_buy_credit_info')) {
	$data_buy_credit_info = $this->session->userdata('data_buy_credit_info');
	$this->session->unset_userdata('data_buy_credit_info');
	?>
	<script>
		 window.ntmData=window.ntmData||[];
		 window.ntmData.push({ 
		 gdpr: "-1",
		 gdprConsent: "",
		 pageType:"order",
		 transactionId: "<?php echo $data_buy_credit_info['transaction_id']?>",
		 orderValue: "<?php echo $data_buy_credit_info['price'] ?> <?php echo $data_buy_credit_info['currency'] ?>",
		 products: [
		 {id: "<?php echo $data_buy_credit_info['package_id']?>", qty: "1", price: "<?php echo $data_buy_credit_info['price'] ?> <?php echo $data_buy_credit_info['currency'] ?>", name: "<?php echo $data_buy_credit_info['package_name'] ?>" },
		 ]
		 });
	</script>
	<script>
		(function(n,e,o,r,y){
			n[r]=n[r]||[];
			n[r].push(
				{
					'event':'ntmInit','t':new Date().getTime()
				}); 
			var f = e.getElementsByTagName(o)[0],s=e.createElement(o),d=r!='ntmData'?'&ntmData='+r:'';
			s.async=true;
			s.src='http'+(document.location.protocol=='https:'?'s':'')+'://tm.container.webgains.link/tm/a/container/init/'+y+'.js?'+d+'&rnd='+Math.floor(Math.random()*100000000);
			f.parentNode.insertBefore(s,f);
		})(window,document,'script','ntmData','249d3b047b');
	</script>
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
						if($currency != 'Euro'){
							$getPackageMultCurrency = $this->credit_package_model->get_package_multi_currency($currency_variable,$package_row['package_id']);
						}
			?>			
			<div class="col-md-3 col-sm-6 col-xs-12 text-center">
				<img src="<?php echo base_url($coin_image[$coin_img_index++]); ?>" alt="">
				<h4 class="crdit_thmb_h4"><?php echo $package_row['package_credits'].' '.$this->lang->line('credits'); ?></h4>	
				<h4 class="price_txt">
					<?php
						if(isset($getPackageMultCurrency)){
							echo $currency_icon . " " . $getPackageMultCurrency->value;
						}
						else{
							echo $package_row['package_amount'] . " €";
						}
					?>
				</h4>
				<a class="buy_nw_credit btn_hover" href="<?php echo base_url('user/credits/buyCreditVoucher/'.$package_row['package_id']); ?>"><?php echo $this->lang->line('buy_now_credits'); ?></a>
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
				<!-- <img src="<?php echo base_url('images/paypal.png'); ?>"> -->
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