<?php
$this->load->view('templates/headers/main_header', $title);
?>
<section class="breacrum_section common_back blckBack">
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

<section class="question_section unlocks qstBox blckBack">		
	<div class="container">
		<div class="row chat_bx">   
			<div class="col-md-12 QstnCol">
				<div class="tab question_bx" role="tabpanel">			
					<div class="row chat_btns">	
						<div class="col-md-12">
							<h4 class="full-pay gold-txt">
								<span class="byDiamonds"><?php echo $this->lang->line('cancellation_terms'); ?></span>
							</h4>
						</div> 						
					</div>

					<div class="question_bx" id="Widerrufsrecht">
						<div class="row">	
							<div>								
								<div id="termsBx">
									<div class="row">
										<div class="col-md-12">
											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds"><?php echo $this->lang->line('withdrawal'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><?php echo $this->lang->line('withdrawal_rule_one'); ?></li>
												<li><?php echo $this->lang->line('withdrawal_rule_two'); ?></li>
												<img src="<?php echo base_url('images/pages/widerruf.png'); ?>" style="margin-left:-2em" alt="...">
												<li><?php echo $this->lang->line('withdrawal_rule_four'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds"><?php echo $this->lang->line('consequences_of_the_cancellation'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><?php echo $this->lang->line('consequences_of_the_cancellation_policy'); ?></li>
											</ul>
										</div>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
</section>
<?php
$this->load->view('templates/footers/main_footer');
?>
