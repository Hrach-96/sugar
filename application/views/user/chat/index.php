<?php
	$this->load->view('templates/headers/main_header', $title);
	$qdata['questions'] = array();
	$this->load->view('templates/sidebar/main_modal', $qdata);
?>
<!--profile slider-->
<div id="main-chat" class="main-chat-fix-all">
<section class="breacrum_section common_back ChatBackDiv">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="question_section qstBox" id="chatBx">		
	<div class="container chat-pl-15">
		<div class="row">
        	<div class="col-md-12 chat-pl-0">
            	<div class="chat_bx">
				<h4 class="full-pay gold-txt chat_btns DlxChat">
			          <span class="byDiamonds">sugarbabes deluxe chat</span>
			        </h4>
					<div id="frame" class="chat-box-fix">
						<div id="sidepanel">
							<div id="profile">
								<div class="wrap">
									<span class="user_st">
										<?php echo $this->lang->line('there_are'); ?> <span class="on_user"><span id="online_user_count">0</span> <?php echo $this->lang->line('user_online'); ?></span> | <span class="new_user"><span id="new_user_count">0</span> <?php echo $this->lang->line('new_user'); ?></span>
									</span>
								</div>
								<hr class="chat_hr"/>
							</div>
		
							<div id="contacts" class="scrollBar">
								<ul id="onlineChatUsersList"></ul>
							</div>

							<div id="search">
								<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
								<input id="onlineChatUserSerachText" name="serachText" type="text" placeholder="<?php echo $this->lang->line('search'); ?>" />
							</div>
						</div>

						<div class="content">
							<div class="contact-profile">
								<span class="chatList chat_button"><i class="fa fa-angle-left" aria-hidden="true"></i>Back To Chat List</span>
								<div class="chat_username text-left">
									<span class="usr_chat" id="user_is_typing" style="display: none;"><i id="chatting_friend_name"></i> <span ><?php echo $this->lang->line('is_typing'); ?>...</span></span>
								</div>
								<div class="social-media">
									<i class="fa fa-star-o btn-add-chat-favorite" aria-hidden="true"></i>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="messages chatBoxScrollbar">
								<ul id="user_messages_data">

<!-- 									<div class="btn_container col-sm-12" style="margin-top: 50px;">
										<div class="text-center">
											<i class="fa fa-comments fa-5x"></i>
											<h4>Unlock Conversation</h4>
										</div>
										<h5 style="margin-top: 50px;">If you want to send messages, you need to unlock this conversation.</h5>
										<a class="action_btns continue_btn btn_hover">Unlock</a>
										<a class="action_btns continue_btn btn_hover btn-chat-unlock-request">Unlock Request</a>
									</div>
 -->									
								</ul>
							</div>

							<div class="message-input" id="chatMessageTexFooter" style="display: none;">
								<div class="smileywrap">
									<!-- Generated markup by the plugin -->
									<div id="smileybox">
									  	<div class="arrow"></div>
									  	<div class="smileybox-inner">
									  	<?php
									  		$smiley_icons = get_smiley_icons();
									  		$smiley_chars = get_smiley_chars();

									  		if(count($smiley_chars) > 0) {
									  			for($ind = 0; $ind < count($smiley_chars); $ind++) {
									  				echo '<span class="emojoIcon" data-text="'.$smiley_chars[$ind].'">'.$smiley_icons[$ind].'</span>';
									  			}
											}
									    ?>
									  	</div>
									</div>									
								</div>
								
								<div class="wrap">
									<div class="typing-div wordWrapBreakWordClass" id="userTextMessage" name="userTextMessage" placeholder="<?php echo $this->lang->line('write_your_message'); ?>..." contentEditable="true"></div>

									<img src="<?php echo base_url('images/emojis.png'); ?>" class="attch_img emoji_i" id="btn-smileys">

									<button id="sendUserChatmessage" class="submit attch_img sbmt_cht"><img src="<?php echo base_url('images/send.png'); ?>"></button>
								</div>
							</div>
						</div>
					</div>
            	</div>
			</div>
			<div class="col-md-12">		
    		</div>
    	</div>
	<div class="bottom-effect"></div>
</section>

<!--Special Gift Section-->
<section class="wishlist_section" id="chatWishList" style="padding: 30px;"></section>

<!-- Unlock Using Credits into Unlock Menu Modal -->
<div class="modal fade fade-in notificationModal" id="unlockChatCreditModal">
    <div class="modal-dialog unlock-modal">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alertBox">
                        <form action="<?php echo base_url('user/unlocks/unlockChatRequest'); ?>" method="POST">
                            <input type="hidden" id="user_unlock_member_id" name="unlock_member_id" value=""> 
                            <h4><img src="<?php echo base_url('images/unlock-request-key.png'); ?>" class="noti_i" /></h4>
                            <div class="text-center">    
                                <h4 class="gold-txt"><?php echo $this->lang->line('are_you_sure_to_unlock_this_request'); ?></h4>
                                <p style="color:white;"><?php echo $this->lang->line('validity_for_this_activation_is_one_month_only'); ?></p>
                                <?php if($this->session->userdata('user_is_vip') == 'no') { ?>
                                <h5 class="get_in_touch"><?php echo $this->lang->line('unlocking_cost').': '.$this->session->userdata('site_setting')['basic_user_unlocking_cost'].' '.$this->lang->line('credits'); ?></h5>
                                    <input type="hidden" name="unlocking_cost" value="<?php echo $this->session->userdata('site_setting')['basic_user_unlocking_cost']; ?>">
                                <img src="<?php echo base_url('images/vip-user.png'); ?>" class="UserStImg"> 
                                <h5 class="get_in_touch"><?php echo $this->lang->line('unlocking_cost_for_vip_user_is'); ?> <?php echo $this->session->userdata('site_setting')['vip_user_unlocking_cost'].' '.$this->lang->line('credits'); ?></h5>
                                <?php } else { ?>
                                    <h5 class="get_in_touch"><?php echo $this->lang->line('unlocking_cost').': '.$this->session->userdata('site_setting')['vip_user_unlocking_cost'].' '.$this->lang->line('credits'); ?></h5>
                                        <input type="hidden" name="unlocking_cost" value="<?php echo $this->session->userdata('site_setting')['vip_user_unlocking_cost']; ?>">
                                <?php } ?>
                                <div class="row">
                                    <div class="text-center">
                                        <?php if($this->session->userdata('user_is_vip') == 'no') { ?>
                                        <a href="<?php echo base_url('user/vip'); ?>" class="buy_nw_credit btn_hover"><?php echo $this->lang->line('become_a_vip_now'); ?></a>
                                        <?php } ?>
                                        <button type="submit" class="btn-unlock-request save_search btn_hover"><span class="search_span"><?php echo $this->lang->line('unlock'); ?></span></button>
                                        <button type="button" class="save_search btn_hover" data-dismiss="modal"><span class="search_span"><?php echo $this->lang->line('no'); ?></span></button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Unlock Using Credits  Modal -->

<?php
$this->load->view('templates/footers/main_footer');
?>