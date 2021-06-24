<style type="text/css">
    .rept-title {
        color:white;
        text-transform: uppercase;
        font-size: 18.62px;
        font-family: "Montserrat";        
    }
    .rept-reason {
        color:white;
        font-family: "Montserrat";
        font-size: 14px;
    }
    .report-col .control__indicator {
        position: absolute;
        height: 20px;
        width: 20px;
        background: #e6e6e6;
            background-color: rgb(230, 230, 230);
        top: 2px;
        left: -11px;
        position: absolute;
        margin: 0 auto;
    }
    .report-col .control {
        font-size: 14.62px;
    }
</style>

<!-- Add Favorite Modal -->
<div class="modal fade fade-in notificationModal" id="addFavoriteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
						<div class="alertBox">
						<table>
							<tr>
								<td><img src="<?php echo base_url('images/thumbs-up-hand-symbol.png'); ?>" class="noti_i" /></td>
								<td><?php echo $this->lang->line('are_you_sure_to_add_to_favorite'); ?>?</td>
								<td class="text-right">
								<button type="button" class="btn-add-favorite save_search btn_hover "  data-dismiss="modal"><span class="search_span"><?php echo $this->lang->line('yes'); ?></span></button>
								<button type="button" class="save_search btn_hover" data-dismiss="modal"><span class="search_span"><?php echo $this->lang->line('no'); ?></span></button>
							</td>
							</tr>
						</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Add Favorite Modal -->

<!-- Delete Favorite Modal -->
<div class="modal fade fade-in notificationModal" id="deleteFavoriteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
					<div class="alertBox">
						<table>
							<tr>
								<td><img src="<?php echo base_url('images/thumbs-up-hand-symbol.png'); ?>" class="noti_i" /></td>
								<td><?php echo $this->lang->line('are_you_sure_to_remove_from_favorite'); ?>?</td>
								<td class="text-right">
								 <button type="button" class="btn-delete-favorite text-uppercase save_search btn_hover" data-dismiss="modal"><?php echo $this->lang->line('yes'); ?></button>
                            <button type="button" class="text-uppercase save_search btn_hover" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>
							</td>
							</tr>
						</table>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Add Favorite Modal -->

<!-- Add Kiss Modal -->
<div class="modal fade fade-in notificationModal" id="addKissModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
					<div class="alertBox">
						<table>
							<tr>
								<td><img src="<?php echo base_url('images/woman-lips.png'); ?>" class="noti_i" /></td>
								<td><?php echo $this->lang->line('are_you_sure_to_send_kiss'); ?>?</td>
								<td class="text-right">
								<button type="button" class="btn-send-kiss save_search btn_hover text-uppercase" data-dismiss="modal"><?php echo $this->lang->line('yes'); ?></button>
                            <button type="button" class="save_search btn_hover text-uppercase" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>								
							</td>
							</tr>
						</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Add Kiss Modal -->

<!-- Delete Kiss Modal -->
<div class="modal fade fade-in notificationModal" id="deleteKissModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
					<div class="alertBox">
						<table>
							<tr>
								<td><img src="<?php echo base_url('images/woman-lips.png'); ?>" class="noti_i" /></td>
								<td><?php echo $this->lang->line('are_you_sure_to_remove_kiss'); ?>?</td>
								<td class="text-right">
								<button type="button" class="save_search btn_hover btn-remove-kiss text-uppercase" data-dismiss="modal"><?php echo $this->lang->line('yes'); ?></button>
                            <button type="button" class="save_search btn_hover text-uppercase" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>
							</td>
							</tr>
						</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Kiss Modal -->

<!-- Report User Modal -->
<div class="modal fade transparent_mdl" id="reportUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="question_section">
                    <div class="question_bx">
                        <div class="form-group">
                            <h4 class="full-pay gold-txt"><span class="Que_title"><?php echo $this->lang->line('report_this_user'); ?></span></h4>
                        </div>
                        <div class="form-group">
                            <div class="control-label rept-title"><?php echo $this->lang->line('reason'); ?></div>
                            <ul style="list-style: none;" class="rept-reason">
                                <li>
                                    <div class="col-sm-12 report-col">
                                        <label class="control control--radio"><?php echo $this->lang->line('user_has_contact_details_in_the_profile'); ?>
                                            <input type="radio" name="report_reason" value="user_has_contact_details_in_the_profile" checked="true">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="col-sm-12 report-col">
                                        <label class="control control--radio"><?php echo $this->lang->line('user_is_a_minor'); ?>
                                            <input type="radio" name="report_reason" value="user_is_a_minor">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="col-sm-12 report-col">
                                        <label class="control control--radio"><?php echo $this->lang->line('user_pursues_commercial_interests'); ?>
                                            <input type="radio" name="report_reason" value="user_pursues_commercial_interests">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="col-sm-12 report-col">
                                        <label class="control control--radio"><?php echo $this->lang->line('profile_photos_can_be_found_on_the_internet_specify_source'); ?>
                                            <input type="radio" name="report_reason" value="profile_photos_can_be_found_on_the_internet_specify_source">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="col-sm-12 report-col">
                                        <label class="control control--radio"><?php echo $this->lang->line('profile_photos_do_not_belong_to_the_user'); ?>
                                            <input type="radio" name="report_reason" value="profile_photos_do_not_belong_to_the_user">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </li>                                
                                <li>
                                    <div class="col-sm-12 report-col">
                                        <label class="control control--radio"><?php echo $this->lang->line('user_is_on_wrong_platform_no_sb_sd'); ?>
                                            <input type="radio" name="report_reason" value="user_is_on_wrong_platform_no_sb_sd">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="col-sm-12 report-col">
                                        <label class="control control--radio"><?php echo $this->lang->line('other'); ?>
                                            <input type="radio" name="report_reason" value="other">
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <div class="control-label rept-title"><?php echo $this->lang->line('other_reason'); ?></div>
                            <textarea class="form-control" id="other_report_reason" name="other_reason" placeholder="<?php echo $this->lang->line('enter_your_specific_reason'); ?>"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-success btn-sm-dialog btn-send-report text-uppercase save_search"><?php echo $this->lang->line('confirm'); ?></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-danger btn-sm-dialog text-uppercase save_search" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Report User Modal -->

<!-- Ask Question Modal -->
<div class="modal fade transparent_mdl" id="userQuestionModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
		         <div class="question_section">		
                	<div class="qDiv">
                		<div class="row">
                        	<div class="col-md-12 col-sm-12 col-xs-12">
                            	<div class="question_bx">
                					<div class="row">
                						<div class="col-md-12 col-sm-12 col-xs-12 text-left">
                							<h4 class="full-pay gold-txt"><span class="Que_title"><?php echo $this->lang->line('here_you_can_ask_your_first_questions'); ?></span></h4>
                						</div>
                						<div class="col-md-12 col-sm-12 col-xs-12">
                						 	<div class="ques_tbl">          
                						  	<table class="table">
                								<tbody> 
                									<?php 
                										if(!empty($questions)) { 
                											$sr_no = 1;
                											foreach ($questions as $question_row) {
                									?>
                							  		<tr>
                										<td class="col-xs-12"><span class="que_no"><?php echo $sr_no++; ?>.</span><?php echo $this->lang->line($question_row['question_text']); ?></td>
                										<td class="col-xs-12">
                											<a href="javascript:void();" data-id="<?php echo $question_row['question_id']; ?>" class="question_btn send-question"><span class="btn_span"><?php echo $this->lang->line('send_question'); ?></span><img src="<?php echo base_url('images/fragesenden-btn.png'); ?>" class="fragesenden-btn"></a>
                										</td>										
                							  		</tr> 
                							  		<?php } } ?>
                								</tbody>
                						  	</table>
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
	</div>
</div>
<!-- END Ask Question Modal -->

<!-- Block user Modal -->
<div class="modal fade fade-in notificationModal" id="blockUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alertBox">
                        <table>
                            <tr>
                                <td><img src="<?php echo base_url('images/block-user-thumb.png'); ?>" class="noti_i" /></td>
                                <td><?php echo $this->lang->line('are_you_sure_to_block_this_user'); ?>?</td>
                                <td class="text-right">
                                <button type="button" class="btn-block-user save_search" data-dismiss="modal"><span class="search_span"><?php echo $this->lang->line('yes'); ?></span></button>
                                <button type="button" class="save_search" data-dismiss="modal"><span class="search_span"><?php echo $this->lang->line('no'); ?></span></button>
                            </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Add Favorite Modal -->

<!-- Unlock Image Request Modal -->
<div class="modal fade fade-in notificationModal" id="addUnlockImageRequestModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                    <div class="alertBox">
                        <table>
                            <tr>
                                <td><img src="<?php echo base_url('images/unlock-request-key.png'); ?>" class="noti_i" /></td>
                                <td><?php echo $this->lang->line('are_you_sure_to_send_image_unlock_request'); ?>?</td>
                                <td class="text-right">
                                <button type="button" id="btn-unlock-image-request-send" class="btn-send-kiss save_search btn_hover text-uppercase"><?php echo $this->lang->line('yes'); ?></button>
                                <button type="button" class="save_search btn_hover text-uppercase" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Unlock Image Request Modal -->

<!-- Unlock Chat Request Modal -->
<div class="modal fade fade-in notificationModal" id="addUnlockChatRequestModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alertBox">
                        <table>
                            <tr>
                                <td><img src="<?php echo base_url('images/unlock-request-key.png'); ?>" class="noti_i" /></td>
                                <td><?php echo $this->lang->line('are_you_sure_to_send_chat_unlock_request'); ?>?</td>
                                <td class="text-right">
                                <button type="button" id="btn-unlock-chat-request-send" class="btn-send-kiss save_search btn_hover text-uppercase"><?php echo $this->lang->line('yes'); ?></button>
                                <button type="button" class="save_search btn_hover text-uppercase" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Unlock Chat Request Modal -->

<!-- Unlock Chat Request Modal -->
<div class="modal fade fade-in notificationModal" id="addUnlockForChatRequestModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alertBox">
                        <table>
                            <tr>
                                <td><img src="<?php echo base_url('images/unlock-request-key.png'); ?>" class="noti_i" /></td>
                                <td><?php echo $this->lang->line('are_you_sure_to_send_chat_unlock_request'); ?>?</td>
                                <td class="text-right">
                                <button type="button" id="btn-unlock-chat-request-send-in-chat" class="btn-send-kiss save_search btn_hover text-uppercase"><?php echo $this->lang->line('yes'); ?></button>
                                <button type="button" class="save_search btn_hover text-uppercase" data-dismiss="modal"><?php echo $this->lang->line('no'); ?></button>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Unlock Chat Request Modal -->

<!-- Unlock Chat Using Credits into Unlock Menu Modal -->
<div class="modal fade fade-in notificationModal" id="unlockUserChatCreditModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alertBox">
                        <form action="<?php echo base_url('user/unlocks/unlockRequestForChat'); ?>" method="POST">
                            <input type="hidden" id="user_unlock_chat_request_id" name="unlock_request_id" value="">
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

<!-- Unlock Image into Unlock Menu Modal -->
<div class="modal fade fade-in notificationModal" id="unlockImageCreditModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alertBox">
                        <form action="<?php echo base_url('user/unlocks/unlockRequestForImage'); ?>" method="POST">
                            <input type="hidden" id="user_unlock_image_request_id" name="unlock_request_id" value="">
                            <h4><img src="<?php echo base_url('images/unlock-request-key.png'); ?>" class="noti_i" /></h4>
                            <div class="text-center">    
                                <h4 class="gold-txt"><?php echo $this->lang->line('are_you_sure_to_unlock_this_request'); ?></h4>
                                <div class="row">
                                    <div class="text-center">
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


<!-- Unlock User Using Credits into Profile View  -->
<div class="modal fade fade-in notificationModal" id="unlockUserCreditModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alertBox">
                        <form action="<?php echo base_url('user/unlocks/unlockUserRequest'); ?>" method="POST">
                            <input type="hidden" id="user_unlock_memeber_id" name="unlock_member_id" value=""> 
                            <h4><img src="<?php echo base_url('images/unlock-request-key.png'); ?>" class="noti_i unlockI" /></h4>
                            <div class="text-center">    
                                <h4 class="gold-txt"><?php echo $this->lang->line('are_you_sure_to_unlock_this_user'); ?></h4>
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
<!-- Unlock User Using Credits into Profile View  -->

<!-- userNotification Modal -->
<div class="modal fade fade-in notificationModal userNotification" id="userNotification">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <h4 class="full-pay gold-txt common33"><span class="sign_span cinzel"><?php echo $this->lang->line('you_have_already_sent_this_user_two_requests_for_the_activation_of_images'); ?></span></h4>
                        </div>
                        <h3 class="register_title common16"><?php echo $this->lang->line('the_user_must_first_respond_to_your_requests_for_more'); ?><br class="mobileBr" /> <?php echo $this->lang->line('to_be_able_to_ship'); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- userNotification Modal -->

