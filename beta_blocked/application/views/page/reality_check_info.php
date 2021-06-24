<?php
	$this->load->view('templates/headers/main_header', $title);
?>
<section class="buy_credit">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4 class="full-pay gold-txt"><span><?php echo $this->lang->line('how_does_the_reality_check_work'); ?></span></h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('how_it_works'); ?></h4>
			</div>
		</div>
	</div>
</section>

<section class="wishlist_section signup_section" id="chkBoxs">
	<div class="container">
	<!--FAQ div-->
		<div class="row">
			<div class="col-md-12 padding_zero">
				<div class="checkContnr">
					<div class="IndxNo gold-txt">01</div>
					<div class="chkTxt">
						<h4 class="fqTtl"><?php echo $this->lang->line('sugarbabe_deluxe_lettering'); ?></h4>
						<p class="fourteen"><?php echo $this->lang->line('sugarbabe_deluxe_lettering_info_text'); ?></p>
					</div>
					<div class="chkTxt">
						<h4 class="fqTtl"><?php echo $this->lang->line('create_a_photo'); ?></h4>
						<p class="fourteen"><?php echo $this->lang->line('create_a_photo_info_text'); ?></p>
					</div>
				</div>
				<div class="checkContnr">
					<div class="IndxNo gold-txt">02</div>
					<div class="chkTxt">
						<h4 class="fqTtl"><?php echo $this->lang->line('submit_photo'); ?></h4>
						<p class="fourteen"><?php echo $this->lang->line('submit_photo_info_text'); ?></p>
					</div>
				</div>
				<div class="ChckUL">
					<h5 class="fqh5 sxteen os"><?php echo $this->lang->line('please_note_the_following_rules'); ?></h5>
					<ul class="fqUl padding_zero">
						<li class="fourteen os"><?php echo $this->lang->line('reality_check_rule_one'); ?></li>
						<li class="fourteen os"><?php echo $this->lang->line('reality_check_rule_two'); ?></li>
						<li class="fourteen os"><?php echo $this->lang->line('reality_check_rule_three'); ?></li>
						<li class="fourteen os"><?php echo $this->lang->line('reality_check_rule_four'); ?></li>
						<li class="fourteen os"><?php echo $this->lang->line('reality_check_rule_five'); ?></li>
					</ul>
				</div>
				<div class="ChckUL">
					<h5 class="fqh5 sxteen os"><?php echo $this->lang->line('your_advantages_of_the_reality_check'); ?></h5>
					<ul class="fqUl padding_zero">
						<li class="fourteen os"><?php echo $this->lang->line('advantages_text_one'); ?></li>
						<li class="fourteen os"><?php echo $this->lang->line('advantages_text_two'); ?></li>
						<li class="fourteen os"><?php echo $this->lang->line('advantages_text_three'); ?></li>
					</ul>
				</div>
			</div>
		<!--FAQ div-->
		</div>
	</div>
</section>

<?php
	$this->load->view('templates/footers/main_footer');
?>