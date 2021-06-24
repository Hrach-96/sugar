<?php
	$this->load->view('templates/headers/main_header', $title);
?>

<!--profile slider-->
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

<section class="qstBox question_section" id="QuestionSection">		
	<div class="container">
        <div class="col-md-12 QstnCol chat_bx">
            <div class="tab question_bx" role="tabpanel">
			<div class="row chat_btns">	
			     <div class="col-md-12">
					<h4 class="full-pay gold-txt">
			          <span class="byDiamonds"><?php echo $this->lang->line('questions'); ?>
					  </span>
			        </h4>
				</div> 
			</div>
			<div class="row">	
				<ul class="nav nav-tabs" role="tablist">
                    <li class="col-md-6"><a href="<?php echo base_url('questions?type=received'); ?>" rel="div1" class="showSingle <?php if($question_type == 'received') { echo 'qactive'; } else { echo 'qbtn'; } ?>"><?php echo $this->lang->line('question_to_me'); ?></a></li>
                    <li class="col-md-6"><a href="<?php echo base_url('questions?type=sent'); ?>" rel="div2" class="showSingle <?php if($question_type == 'sent') { echo 'qactive'; } else { echo 'qbtn'; } ?>"><?php echo $this->lang->line('question_by_me'); ?></a></li>
                </ul>
				</div>
                <div class="question_bx">
                	<?php if($question_type == 'received') { ?>
                    <div>
						<div class="row qusn_rw">								
						<?php
							if(!empty($users)) {
						?>
								<table class="qstn_tbl">
							<?php
								foreach ($users as $user_row) {
									// User Age
									$today = date_create(date('Y-m-d'));
									$user_birthday = date_create($user_row['user_birthday']);
									$age = date_diff($today, $user_birthday);

							        if($user_row['user_active_photo_thumb'] == '') {
							          $user_row['user_active_photo_thumb'] = "images/avatar/".$user_row['user_gender'].".png";
							        }
							?>		
								<tr>
									<td class="col-md-1">
									<div class="profilePic">
										<a href="<?php echo base_url('user/profile/view?query=').urlencode($user_row['user_id_encrypted']); ?>">
											<img src="<?php echo base_url().$user_row['user_active_photo_thumb']; ?>" class="question_Pic">
										</a>
									</div>
									</td>
									<td class="col-md-3">
										<h4 class="qname"><?php echo $user_row['user_access_name']; ?></h4>
										<h4 class="bdate"><span><?php echo $age->y; ?></span> <span><?php echo $this->lang->line('years'); ?></span></h4>
										<h4 class="qcity"><?php echo $user_row['user_city']; ?></h4>
									</td>
									<td class="col-md-4 qvline">
										<h5 class="qtxt"><?php echo $this->lang->line($user_row['question_text']); ?></h5>
									</td>
									<td class="col-md-3 qvline" data-id="<?php echo $user_row['user_question_id']; ?>">
										<?php 
											if($user_row['question_options'] != '') {
												$quest_options = explode(',', $user_row['question_options']); 
											} else {
												$quest_options = array();
											}
											if($user_row['user_question_answered'] == 'no') {
												if(!empty($quest_options)) {
													foreach ($quest_options as $opt) {
										?>
											<a href="#" rel="div2" class="qbtn ja answer-user-question btn_hover" data-answer="<?php echo $opt; ?>"><?php echo $this->lang->line($opt); ?></a>
										<?php 		} 
												} 
											} else { 
										?>
											<h5 class="qtxt qans yes_no"><?php echo $this->lang->line($user_row['user_question_answer_text']); ?></h5>
										<?php } ?>
									</td>
									<td class="col-md-1 qvline text-center">
										<div class="delete_i delete-user-question" data-id="<?php echo $user_row['user_question_id']; ?>"><img src="<?php echo base_url('images/delete.png'); ?>"></div>
									</td>						
								</tr>
								<tr>
									<td colspan="5">
									<hr class="qhr"/>
									</td>
								</tr>
							<?php } ?>
							</table>
						<?php } else { ?>
			        		<div class="col-sm-12">
								<div class="text-center" style="color: white;padding: 32px;"><?php echo $this->lang->line('no_one_found'); ?></div>
							</div>
						<?php } ?>
						</div>	
                    </div>
                	<?php } else { ?>
					<div>
						<div class="row qusn_rw">							
						<?php
							if(!empty($users)) {
						?>
							<table class="qstn_tbl">
							<?php
								foreach ($users as $user_row) {
									// User Age
									$today = date_create(date('Y-m-d'));
									$user_birthday = date_create($user_row['user_birthday']);
									$age = date_diff($today, $user_birthday);
						            if($user_row['user_active_photo_thumb'] == '') {
						              $user_row['user_active_photo_thumb'] = "images/avatar/".$user_row['user_gender'].".png";
						            }									
							?>										
								<tr>
									<td class="col-md-1">
										<div class="profilePic">
											<a href="<?php echo base_url('user/profile/view?query=').urlencode($user_row['user_id_encrypted']); ?>">
												<img src="<?php echo base_url().$user_row['user_active_photo_thumb']; ?>" class="question_Pic">
											</a>
										</div>
									</td>
									<td class="col-md-3">
										<h4 class="qname"><?php echo $user_row['user_access_name']; ?></h4>
										<h4 class="bdate"><span><?php echo $age->y; ?></span> <span><?php echo $this->lang->line('years'); ?></span></h4>
										<h4 class="qcity"><?php echo $user_row['user_city']; ?></h4>
									</td>
									<td class="col-md-4 qvline">
										<h5 class="qtxt"><?php echo $this->lang->line($user_row['question_text']); ?></h5>
									</td>
									<td class="col-md-3 qvline">
										<h5 class="qtxt qans"><?php echo $this->lang->line($user_row['user_question_answer_text']); ?></h5>
									</td>
									<td class="col-md-1 qvline text-center">
										<div class="delete_i delete-user-question" data-id="<?php echo $user_row['user_question_id']; ?>"><img src="<?php echo base_url('images/delete.png'); ?>"></div>
									</td>
								</tr>
								<tr>
									<td colspan="5">
									<hr class="qhr"/>
									</td>
								</tr>
								<?php } ?>
							</table>
							<?php } else { ?>
			        		<div class="col-sm-12">
								<div class="text-center" style="color: white;padding: 32px;"><?php echo $this->lang->line('no_one_found'); ?></div>
							</div>
							<?php } ?>
						</div>					
					</div>
					<?php } ?>
				 </div>
            </div>
		</div>
		<div class="col-md-12">
    	</div>
	<!--<div class="bottom-effect"></div>-->
</section>

<!--profile slider-->
<!--Special Gift Section-->
<!--<section class="wishlist_section" id="question_wishlist">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile1.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="images/diamond-icon.png" class="diamondIcon" /><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile2.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="images/diamond-icon.png" class="diamondIcon" /><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
				<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile3.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="images/diamond-icon.png" class="diamondIcon" /><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile4.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="images/diamond-icon.png" class="diamondIcon" /><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile5.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="images/diamond-icon.png" class="diamondIcon" /><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile6.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><img src="images/diamond-icon.png" class="diamondIcon" /><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>					
		</div>
		<div class="row">
			<div class="col-md-4 dotted_line_div"> 
				<span class="dotted_line"></span>
			</div>
			<div class="col-md-4 go_btn_col">			
				<a href="#" class="go_online_shop btn_hover" id="go_shop_btn">
				Go to the online Shop
				</a>
			</div>
			<div class="col-md-4 dotted_line_div"> 
				<span class="dotted_line"></span>
			</div>
		</div>
	</div>
	<div class="bottom-effect-black"></div>
</section>-->
<!--Special Gift Section-->
	
<!--<section class="wishlist_section gift_section">
	<div class="container">
		<div class="row">			
			<div class="col-md-5 col-sm-5 col-xs-12 fulWidth">
				<h4 class="full-pay gold-txt"><span class="bygift">Buy a Special Gift
for Your Sugababe</span><br/></h4>
				<h5 class="code_h5">#enjoytheshopping</h5>
				<p class="gift_p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea com</p>
				<h4 class="gift_h4">Original designer Bags, Jewelry	, Perfume, Clothing, High Heels and much more.</h4>

				<div class="row">	
					<div class="col-md-12 go_btn_col">			
						<a href="#" class="go_online_shop Rettangolo_2 btn_hover" id="buy_nw_credits">Buy Now Credits</a>
					</div>		
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12 fulWidth">
				<img src="<?php echo base_url('images/gift.png'); ?>" class="img-responsive giftImg">
			</div>	
		</div>			
	</div>		
</section> -->
<?php
$this->load->view('templates/footers/main_footer');
?>
