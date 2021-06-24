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
		<div class="row">   
			<div class="col-md-12 QstnCol chat_bx">
				<div class="tab question_bx" role="tabpanel">			
					<div class="row chat_btns">	
						<div class="col-md-12">
							<h4 class="full-pay gold-txt">
								<span class="byDiamonds">
									<?php echo $this->lang->line('general_terms_of_use_sugarbabe_deluxe'); ?>
								</span>
							</h4>
						</div> 						
					</div>

					<div class="question_bx">
						<div class="row">	
							<div>								
								<div id="termsBx">
									<div class="row">
										<div class="col-md-12">								
											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">1.<?php echo $this->lang->line('general'); ?></span>
											</h4>
											<ul class="termsUl">
												<li>
													<img class='point_1_1' src="<?php echo base_url('images/pages/adresse2.png'); ?>" alt="...." style="margin-left:-2.8em">
													<img class='point_1_1_330' src="<?php echo base_url('images/terms_of_use/1_1_330.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_390' src="<?php echo base_url('images/terms_of_use/1_1_390.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_450' src="<?php echo base_url('images/terms_of_use/1_1_450.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_510' src="<?php echo base_url('images/terms_of_use/1_1_510.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_570' src="<?php echo base_url('images/terms_of_use/1_1_570.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_630' src="<?php echo base_url('images/terms_of_use/1_1_630.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_690' src="<?php echo base_url('images/terms_of_use/1_1_690.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_750' src="<?php echo base_url('images/terms_of_use/1_1_750.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_810' src="<?php echo base_url('images/terms_of_use/1_1_810.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_870' src="<?php echo base_url('images/terms_of_use/1_1_870.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_930' src="<?php echo base_url('images/terms_of_use/1_1_930.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
													<img class='point_1_1_990' src="<?php echo base_url('images/terms_of_use/1_1_990.jpg'); ?>" alt="...." style="display:none;margin-left:-2.6em">
												</li>
												<li><span class="Numbering">1.2</span><?php echo $this->lang->line('general_rule_two'); ?></li>
												<li><span class="Numbering">1.3</span><?php echo $this->lang->line('general_rule_three'); ?></li>
												<li><span class="Numbering">1.4</span><?php echo $this->lang->line('general_rule_four'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">2. <?php echo $this->lang->line('services'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering">2.1</span><?php echo $this->lang->line('services_rule_one'); ?></li>
												<li><span class="Numbering">2.2</span><?php echo $this->lang->line('services_rule_two'); ?></li>
											</ul>
											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">3. <?php echo $this->lang->line('license_agreement'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering">3.1</span><?php echo $this->lang->line('license_agreement_rule_one'); ?></li>
												<li><span class="Numbering">3.2</span><?php echo $this->lang->line('license_agreement_rule_two'); ?></li>
											</ul>	
											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">4. <?php echo $this->lang->line('rights_and_obligations'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering">4.1</span><?php echo $this->lang->line('rights_and_obligations_rule_one'); ?></li>
												<li><span class="Numbering">4.2</span><?php echo $this->lang->line('rights_and_obligations_rule_two'); ?></li>
												<li><span class="Numbering">4.3</span><?php echo $this->lang->line('rights_and_obligations_rule_three'); ?>
													<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('rights_and_obligations_rule_three_one'); ?></h5>
													<ul class="innerUl">
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_one_one'); ?></li>
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_one_two'); ?></li>
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_one_three'); ?></li>
													</ul>

													<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('rights_and_obligations_rule_three_two'); ?></h5>
													<ul class="innerUl">
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_two_one'); ?></li>
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_two_two'); ?></li>
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_two_three'); ?></li>
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_two_four'); ?></li>
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_two_five'); ?></li>
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_two_six'); ?></li>
														<li><?php echo $this->lang->line('rights_and_obligations_rule_three_two_seven'); ?></li>
													</ul>
												</li>
												<li>
													<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('rights_and_obligations_rule_three_three'); ?></h5>
												</li>
												<li>
													<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('rights_and_obligations_rule_three_four'); ?></h5>
												</li>
												<li>
													<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('rights_and_obligations_rule_three_five'); ?></h5>
												</li>
											</ul>	

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">5. <?php echo $this->lang->line('availability'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><?php echo $this->lang->line('availability_info_text'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">6. <?php echo $this->lang->line('content'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering">6.1</span><?php echo $this->lang->line('content_rule_one'); ?></li>
												<li><span class="Numbering">6.2</span><?php echo $this->lang->line('content_rule_two'); ?></li>
												<li><span class="Numbering">6.3</span><?php echo $this->lang->line('content_rule_three'); ?>
												<ul class="innerUl">
													<li id="innermain">
														<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('content_rule_three_one'); ?></h5>
													</li>
													<li id="innermain">
														<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('content_rule_three_two'); ?></h5>
													</li>
													<li id="innermain">
														<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('content_rule_three_three'); ?></h5>
													</li>
												</ul>
												</li>
												<li><?php echo $this->lang->line('content_rule_three_four'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">7. <?php echo $this->lang->line('duration_and_termination'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering">7.1</span><?php echo $this->lang->line('duration_and_termination_rule_one'); ?></li>
												<li><span class="Numbering">7.2</span><?php echo $this->lang->line('duration_and_termination_rule_two'); ?></li>
												<li><span class="Numbering">7.3</span><?php echo $this->lang->line('duration_and_termination_rule_three'); ?></li>
												<li><span class="Numbering">7.4</span><?php echo $this->lang->line('duration_and_termination_rule_four'); ?></li>
												<li><span class="Numbering">7.5</span><?php echo $this->lang->line('duration_and_termination_rule_five'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">8. <?php echo $this->lang->line('blocking'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering">8.1</span><?php echo $this->lang->line('blocking_rule_one'); ?></li>
												<li><span class="Numbering">8.2</span><?php echo $this->lang->line('blocking_rule_two'); ?></li>
												<li><span class="Numbering">8.3</span><?php echo $this->lang->line('blocking_rule_three'); ?></li>	        						
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">9. <?php echo $this->lang->line('payment'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering">9.1</span><?php echo $this->lang->line('payment_rule_one'); ?></li>
												<li id="innermain">
													<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('payment_rule_one_one'); ?></h5>
												</li>	
												<img class='point_9_3' src="<?php echo base_url('images/pages/lastschrift.png'); ?>" style="margin-left:1.84em;" alt="....">
												<img class='point_9_3_330' src="<?php echo base_url('images/terms_of_use/9_3_330.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_390' src="<?php echo base_url('images/terms_of_use/9_3_390.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_450' src="<?php echo base_url('images/terms_of_use/9_3_450.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_510' src="<?php echo base_url('images/terms_of_use/9_3_510.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_570' src="<?php echo base_url('images/terms_of_use/9_3_570.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_630' src="<?php echo base_url('images/terms_of_use/9_3_630.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_690' src="<?php echo base_url('images/terms_of_use/9_3_690.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_750' src="<?php echo base_url('images/terms_of_use/9_3_750.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_810' src="<?php echo base_url('images/terms_of_use/9_3_810.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_870' src="<?php echo base_url('images/terms_of_use/9_3_870.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_930' src="<?php echo base_url('images/terms_of_use/9_3_930.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<img class='point_9_3_990' src="<?php echo base_url('images/terms_of_use/9_3_990.jpg'); ?>" alt="...." style="display:none;margin-left:1.5em">
												<li id="innermain">
													<h5 class="innerh5"><span class="inDot"></span><?php echo $this->lang->line('payment_rule_one_three'); ?></h5>
												</li>
												<li id="innermain">Paypal: XXX</li>
												<li><span class="Numbering">9.2</span><?php echo $this->lang->line('payment_rule_two'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">10. <?php echo $this->lang->line('liability'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering">10.1 </span> <?php echo $this->lang->line('liability_rule_one'); ?></li>
												<li><span class="Numbering respNumberingLeftSpace">10.2 </span> <?php echo $this->lang->line('liability_rule_two'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">11. <?php echo $this->lang->line('services'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><?php echo $this->lang->line('services_info_text'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">12. <?php echo $this->lang->line('amendments'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><?php echo $this->lang->line('amendments_info_text'); ?></li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">13. <?php echo $this->lang->line('cancellation'); ?></span>
											</h4>
											<ul class="termsUl">
												<img class='point_13_1' src="<?php echo base_url('images/pages/widerrufsbelehrung.png'); ?>" style="margin-left:0.3em" alt="...">
												<img class='point_13_1_330' src="<?php echo base_url('images/terms_of_use/13_1_330.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_390' src="<?php echo base_url('images/terms_of_use/13_1_390.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_450' src="<?php echo base_url('images/terms_of_use/13_1_450.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_510' src="<?php echo base_url('images/terms_of_use/13_1_510.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_570' src="<?php echo base_url('images/terms_of_use/13_1_570.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_630' src="<?php echo base_url('images/terms_of_use/13_1_630.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_690' src="<?php echo base_url('images/terms_of_use/13_1_690.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_750' src="<?php echo base_url('images/terms_of_use/13_1_750.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_810' src="<?php echo base_url('images/terms_of_use/13_1_810.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_870' src="<?php echo base_url('images/terms_of_use/13_1_870.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_930' src="<?php echo base_url('images/terms_of_use/13_1_930.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<img class='point_13_1_990' src="<?php echo base_url('images/terms_of_use/13_1_990.jpg'); ?>" alt="...." style="display:none;margin-left:0.5em">
												<li><span class="Numbering respNumberingLeftSpace">13.2 </span> <?php echo $this->lang->line('cancellation_rule_two'); ?></li>
												<li><?php echo $this->lang->line('cancellation_rule_two_info'); ?></li>
												<li><span class="Numbering respNumberingLeftSpace">13.3</span><?php echo $this->lang->line('cancellation_rule_three'); ?>
												</li>
											</ul>

											<h4 class="full-pay gold-txt termsHead">
												<span class="byDiamonds">14. <?php echo $this->lang->line('final_provisions'); ?></span>
											</h4>
											<ul class="termsUl">
												<li><span class="Numbering respNumberingLeftSpace">14.1</span><?php echo $this->lang->line('final_provisions_rule_one'); ?></li>
												<li><span class="Numbering respNumberingLeftSpace">14.2</span><?php echo $this->lang->line('final_provisions_rule_two'); ?></li>
												<li style='word-wrap: break-word;'><span class="Numbering respNumberingLeftSpace">14.3</span><?php echo $this->lang->line('final_provisions_rule_three'); ?>&nbsp;<a href="http://ec.europa.eu/consumers/odr">http://ec.europa.eu/consumers/odr</a>.
												</li>
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
<script type="text/javascript">
	$(document).ready(function(){
		showAppropiateImages();
		$(window).resize(function() {
			showAppropiateImages();
		});
		function showAppropiateImages(width){
			var width = $( window ).width();
			if(width >= 300 && width < 360){
				$(".point_9_3_810").css({'display':'none'})
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_390").css({'display':'none'})
				$(".point_1_1_330").css({'display':'block'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_390").css({'display':'none'})
				$(".point_9_3_330").css({'display':'block'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_390").css({'display':'none'})
				$(".point_13_1_330").css({'display':'block'})
			}
			if(width >= 360 && width < 420){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_330").css({'display':'none'})
				$(".point_1_1_390").css({'display':'block'})
				$(".point_1_1_450").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_330").css({'display':'none'})
				$(".point_9_3_390").css({'display':'block'})
				$(".point_9_3_450").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_330").css({'display':'none'})
				$(".point_13_1_390").css({'display':'block'})
				$(".point_13_1_450").css({'display':'none'})
			}
			if(width >= 420 && width < 480){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_390").css({'display':'none'})
				$(".point_1_1_450").css({'display':'block'})
				$(".point_1_1_510").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_390").css({'display':'none'})
				$(".point_9_3_450").css({'display':'block'})
				$(".point_9_3_510").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_390").css({'display':'none'})
				$(".point_13_1_450").css({'display':'block'})
				$(".point_13_1_510").css({'display':'none'})
			}
			if(width >= 480 && width < 540){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_450").css({'display':'none'})
				$(".point_1_1_510").css({'display':'block'})
				$(".point_1_1_570").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_450").css({'display':'none'})
				$(".point_9_3_510").css({'display':'block'})
				$(".point_9_3_570").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_450").css({'display':'none'})
				$(".point_13_1_510").css({'display':'block'})
				$(".point_13_1_570").css({'display':'none'})
			}
			if(width >= 540 && width < 600){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_510").css({'display':'none'})
				$(".point_1_1_570").css({'display':'block'})
				$(".point_1_1_630").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_510").css({'display':'none'})
				$(".point_9_3_570").css({'display':'block'})
				$(".point_9_3_630").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_510").css({'display':'none'})
				$(".point_13_1_570").css({'display':'block'})
				$(".point_13_1_630").css({'display':'none'})
			}
			if(width >= 600 && width < 660){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_570").css({'display':'none'})
				$(".point_1_1_630").css({'display':'block'})
				$(".point_1_1_690").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_570").css({'display':'none'})
				$(".point_9_3_630").css({'display':'block'})
				$(".point_9_3_690").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_570").css({'display':'none'})
				$(".point_13_1_630").css({'display':'block'})
				$(".point_13_1_690").css({'display':'none'})
			}
			if(width >= 660 && width < 720){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_630").css({'display':'none'})
				$(".point_1_1_690").css({'display':'block'})
				$(".point_1_1_750").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_630").css({'display':'none'})
				$(".point_9_3_690").css({'display':'block'})
				$(".point_9_3_750").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_630").css({'display':'none'})
				$(".point_13_1_690").css({'display':'block'})
				$(".point_13_1_750").css({'display':'none'})
			}
			if(width >= 720 && width < 780){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_690").css({'display':'none'})
				$(".point_1_1_750").css({'display':'block'})
				$(".point_1_1_810").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_690").css({'display':'none'})
				$(".point_9_3_750").css({'display':'block'})
				$(".point_9_3_810").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_690").css({'display':'none'})
				$(".point_13_1_750").css({'display':'block'})
				$(".point_13_1_810").css({'display':'none'})
			}
			if(width >= 780 && width < 840){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_750").css({'display':'none'})
				$(".point_1_1_810").css({'display':'block'})
				$(".point_1_1_870").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_750").css({'display':'none'})
				$(".point_9_3_810").css({'display':'block'})
				$(".point_9_3_870").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_750").css({'display':'none'})
				$(".point_13_1_810").css({'display':'block'})
				$(".point_13_1_870").css({'display':'none'})
			}
			if(width >= 840 && width < 900){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_810").css({'display':'none'})
				$(".point_1_1_870").css({'display':'block'})
				$(".point_1_1_930").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_810").css({'display':'none'})
				$(".point_9_3_870").css({'display':'block'})
				$(".point_9_3_930").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_810").css({'display':'none'})
				$(".point_13_1_870").css({'display':'block'})
				$(".point_13_1_930").css({'display':'none'})
			}
			if(width >= 900 && width < 960){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_870").css({'display':'none'})
				$(".point_1_1_930").css({'display':'block'})
				$(".point_1_1_990").css({'display':'none'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_870").css({'display':'none'})
				$(".point_9_3_930").css({'display':'block'})
				$(".point_9_3_990").css({'display':'none'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_870").css({'display':'none'})
				$(".point_13_1_930").css({'display':'block'})
				$(".point_13_1_990").css({'display':'none'})
			}
			if(width >= 960 && width < 1210){
				$(".point_1_1").css({'display':'none'})
				$(".point_1_1_930").css({'display':'none'})
				$(".point_1_1_990").css({'display':'block'})
				$(".point_9_3").css({'display':'none'})
				$(".point_9_3_930").css({'display':'none'})
				$(".point_9_3_990").css({'display':'block'})
				$(".point_13_1").css({'display':'none'})
				$(".point_13_1_930").css({'display':'none'})
				$(".point_13_1_990").css({'display':'block'})
			}
		}
	})
</script>