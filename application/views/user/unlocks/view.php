<?php
	$this->load->view('templates/headers/main_header', $title);
	$this->load->view('templates/sidebar/main_modal');
	$filter = $this->input->get('filter');
	$type = $this->input->get('type');
?>

<?php if($this->session->has_userdata('message')) { ?>
<section class="messages">
	<div class="alert tag-alert-golden alert-dismissible fade in">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <?php echo $this->lang->line($this->session->userdata('message')); $this->session->unset_userdata('message'); ?>
	</div>
</section>
<?php } ?>

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

<section class="question_section unlocks qstBox blckBack" id="unlockSection">		
	<div class="container">
        	<div class="col-md-12 QstnCol chat_bx">
            	<div class="tab question_bx" role="tabpanel">			
					<div class="row chat_btns">	
			     		<div class="col-md-6">
							<h4 class="full-pay gold-txt">
          						<span class="byDiamonds"><?php echo $this->lang->line('unlocks'); ?></span>
        					</h4>
						</div> 
						<div class="col-md-6 text-right">
							<a href="<?php if(empty($type)){ echo base_url('unlocks?filter=chat_request'); } else { echo base_url('unlocks?filter=chat_request&type='.$type ); } ?>" rel="div2" class="<?php if($filter == 'chat_request') { echo 'qactive'; } else { echo 'qbtn'; } ?> ja btn_hover"><?php echo $this->lang->line('chat'); ?></a>
							<a href="<?php if(empty($type)){ echo base_url('unlocks?filter=images_request'); } else { echo base_url('unlocks?filter=images_request&type='.$type ); } ?>" rel="div2" class="<?php if($filter == 'images_request') { echo 'qactive'; } else { echo 'qbtn'; } ?> ja btn_hover"><?php echo $this->lang->line('picture_gallery'); ?></a>
						</div>
					</div>
					<div class="row">	
						<ul class="nav nav-tabs" role="tablist">
		                    <li class="col-md-4 col-sm-12"><a href="<?php if(empty($filter)){ echo base_url('unlocks?type=open'); } else { echo base_url('unlocks?filter='.$filter.'&type=open'); } ?>" rel="div1" class="showSingle <?php if($unlock_type == 'open') { echo 'qactive'; } else { echo 'qbtn'; } ?>"><?php echo $this->lang->line('open_unlocks'); ?></a></li>
		                    <li class="col-md-4 col-sm-12"><a href="<?php if(empty($filter)){ echo base_url('unlocks?type=active'); } else { echo base_url('unlocks?filter='.$filter.'&type=active'); }  ?>" rel="div2" class="showSingle <?php if($unlock_type == 'active') { echo 'qactive'; } else { echo 'qbtn'; } ?>"><?php echo $this->lang->line('active_unlocks'); ?></a></li>
		                    <li class="col-md-4 col-sm-12"><a href="<?php if(empty($filter)){ echo base_url('unlocks?type=rejected'); } else { echo base_url('unlocks?filter='.$filter.'&type=rejected'); } ?>" rel="div2" class="showSingle <?php if($unlock_type == 'rejected') { echo 'qactive'; } else { echo 'qbtn'; } ?>"><?php echo $this->lang->line('rejected_requests'); ?></a></li>
		                </ul>
					</div>
                	<div class="question_bx">
						<div class="row qusn_rw">	
							<div>								
								<?php
								if(!empty($requests)) {
								?>
								<table class="qstn_tbl">
									<?php
										foreach ($requests as $request) {
											// User Age
											$today = date_create(date('Y-m-d'));
											$user_birthday = date_create($request['user_birthday']);
											$age = date_diff($today, $user_birthday);
								            if($request['user_active_photo_thumb'] == '') {
								              $request['user_active_photo_thumb'] = "images/avatar/".$request['user_gender'].".png";
								            }								        
								           ?>
                                     <tr>
										<td class="col-md-1">
										<div class="profilePic">
											<a href="<?php echo base_url('user/profile/view?query=').urlencode($request['user_id_encrypted']); ?>">
												<img src="<?php echo base_url().$request['user_active_photo_thumb']; ?>" class="question_Pic">
											</a>
										</div>
										</td>
										<td class="col-md-4">
											<h4 class="qname"><?php echo $request['user_access_name']; ?> | <?php echo $age->y.' '.$this->lang->line('years'); ?>  -  <span class="chat_req"><?php echo $this->lang->line($request['unlock_request_type']); ?></span></h4>
											<h4 class="qcity"><?php echo $request['user_city']; ?></h4>
										</td>
										<td class="col-md-4 qvline">
											<?php if($request['unlock_request_type'] == 'images_request') { ?>
											<h5 class="qtxt"><img src="<?php echo base_url().$request['photo_thumb_url']; ?>" class="unlckProfImg" /></h5>
											<?php } ?>
										</td>
										<td class="col-md-3 qvline" data-id="<?php echo $request['unlock_request_id']; ?>">
											<?php if($unlock_type == 'open' || $unlock_type == 'rejected') { ?>
											<a href="javascript:void(0);" rel="div2" class="qbtn ja btn_hover <?php echo ($request['unlock_request_type'] == 'chat_request')?'btn-show-chat-unlock-model':'btn-show-image-unlock-model'; ?>"><?php echo $this->lang->line('unlock'); ?></a>
											<?php } ?>
	<!-- 										<a href="#" rel="div2" class="qbtn ja btn_hover"><?php echo $this->lang->line('maybe_later'); ?></a> -->
											<?php if($unlock_type == 'open') { ?>
											<a href="javascript:void(0);" rel="div2" class="qbtn ja btn_hover btn-unlock-reject"><?php echo $this->lang->line('reject'); ?></a>
											<?php } ?>

											<?php if($unlock_type == 'active' &&  $request['unlock_request_type'] == 'images_request') { ?>
												<a href="javascript:void(0);" rel="div2" class="qbtn ja btn_hover btn-disable-user-unlock-request"><?php echo $this->lang->line('disable'); ?></a>
											<?php } ?>											
										</td>												
									</tr>
									<tr>
										<td colspan="5">
										<hr class="qhr"/>
										</td>
									</tr>
								 <?php  }    	
									
									  ?>
								</table>
								<?php } else { ?>
					        		<div class="col-sm-12">
										<div class="text-center" style="color: white;padding: 32px;"><?php echo $this->lang->line('no_one_found'); ?></div>
									</div>
								<?php } ?>
							</div>	
						</div>

					   	<?php if($links != '') { ?>
						<div class="col-xs-18 col-sm-12 col-md-12 profile_divider"></div>	
						<div class="pagination">
							<span class="go_to">Go To &nbsp;&nbsp;&nbsp;&nbsp;|</span> 
							<?php echo $links; ?>	
						</div>
						<?php } ?>

				 	</div>
            	</div>
			</div>
	</div>
</section>

<!--profile slider-->
<!--Special Gift Section-->
<!--
<section class="wishlist_section wishlistBlck" id="question_wishlist">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile1.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><i class="flaticon-diamond"></i><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile2.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><i class="flaticon-diamond"></i><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
				<div class="col-md-6">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile3.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><i class="flaticon-diamond"></i><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile4.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><i class="flaticon-diamond"></i><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-6">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile5.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><i class="flaticon-diamond"></i><span>400,00 DMD</span></h4>
						<a class="continue_btn btn_hover"><span class="cont_span">Buy Now</span></a>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="<?php echo base_url('images/wishlist/profile6.png'); ?>" class="img-responsive">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<h3 class="wshlst_h3">Luxury Ring Product</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...</p>
					<div class="wshlst_bottom">
						<h4><i class="flaticon-diamond"></i><span>400,00 DMD</span></h4>
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
</section>
-->
<!--Special Gift Section-->
<section class="wishlist_section" style="padding: 30px;">
</section>
<!--	
<section class="wishlist_section gift_section">
	<div class="container">
		<div class="row">			
			<div class="col-md-5 col-sm-5 col-xs-12">
				<h4 class="full-pay gold-txt"><span class="bygift">Buy a Special Gift
for Your Sugababe</span><br/></h4>
				<h5 class="code_h5">#enjoytheshopping</h5>
				<p class="gift_p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea com</p>
				<h4 class="gift_h4">Original designer Bags, Jewelry	, Perfume, Clothing, High Heels and much more.</h4>

				<div class="row">	
					<div class="col-md-12 go_btn_col">			
						<a href="#" class="go_online_shop Rettangolo_2 btn_hover">Buy Now Credits</a>
					</div>		
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12">
				<img src="<?php echo base_url('images/gift.png'); ?>" class="img-responsive">
			</div>	
		</div>			
	</div>		
</section> 
-->
<?php
$this->load->view('templates/footers/main_footer');
?>
