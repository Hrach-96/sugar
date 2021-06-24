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

<section class="question_section qstBox PrivacyDiv" id="faq_section"> 		
	<div class="container">
		<div class="row chat_bx">	
        	<div class="col-md-12 QstnCol">
            	<div class="tab question_bx" role="tabpanel">			
					<div class="row">	
			     		<div class="col-md-12">
							<h4 class="full-pay gold-txt">
          						<span class="byDiamonds">
          							<?php echo $this->lang->line('listing_basic_data_protection_regulation_with_subchapters'); ?>
          						</span>
        					</h4>
						</div> 						
					</div>
					<div class="row">
						<!--privacy policy tab-->
						<div class="col-md-12">
							<div class="your-class">
								<div class="lilo-accordion-control"><?php echo $this->lang->line('preamble'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('preamble_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('preamble_info_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('general'); ?></div>
								<div class="lilo-accordion-content">
									<p class="fourteen"><?php echo $this->lang->line('general_info_first'); ?> </p>
									<p class="fourteen"><?php echo $this->lang->line('general_info_second'); ?></p>
									<ul class="termsUl">
			        					<li><?php echo $this->lang->line('general_info_second_rule_one'); ?></li>
			            				<li><?php echo $this->lang->line('general_info_second_rule_two'); ?></li>        						
			            				<li><?php echo $this->lang->line('general_info_second_rule_three'); ?></li>
										<li><?php echo $this->lang->line('general_info_second_rule_four'); ?></li> 
										<li><?php echo $this->lang->line('general_info_second_rule_five'); ?></li>
										<li><?php echo $this->lang->line('general_info_second_rule_six'); ?></li> 
										<li><?php echo $this->lang->line('general_info_second_rule_seven'); ?></li>
										<li><?php echo $this->lang->line('general_info_second_rule_eight'); ?></li> 
										<li><?php echo $this->lang->line('general_info_second_rule_nine'); ?></li>   					
									</ul>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('responsible'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('responsible_text_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('responsible_text_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('your_rights'); ?></div>
								<div class="lilo-accordion-content">
									<p class="fourteen"><?php echo $this->lang->line('your_rights_text_first'); ?></p>
									<ul class="termsUl">
        								<li><?php echo $this->lang->line('your_rights_text_first_rule_one'); ?></li>
            							<li><?php echo $this->lang->line('your_rights_text_first_rule_two'); ?></li>
            							<li><?php echo $this->lang->line('your_rights_text_first_rule_three'); ?></li>
            							<li><?php echo $this->lang->line('your_rights_text_first_rule_four'); ?></li>
										<li><?php echo $this->lang->line('your_rights_text_first_rule_five'); ?></li>  
										<li><?php echo $this->lang->line('your_rights_text_first_rule_six'); ?></li>
									</ul>
									<p class="fourteen"><?php echo $this->lang->line('your_rights_text_second'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('your_rights_text_third'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('right_to_information'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('right_to_information_info_first'); ?></p>
									<ul class="termsUl">
        								<li><?php echo $this->lang->line('right_to_information_info_first_rule_one'); ?></li>
            							<li><?php echo $this->lang->line('right_to_information_info_first_rule_two'); ?></li>
            							<li><?php echo $this->lang->line('right_to_information_info_first_rule_three'); ?></li>
            							<li><?php echo $this->lang->line('right_to_information_info_first_rule_four'); ?></li>
            							<li><?php echo $this->lang->line('right_to_information_info_first_rule_five'); ?></li>
            							<li><?php echo $this->lang->line('right_to_information_info_first_rule_six'); ?></li>
									</ul>
									<p class="fourteen"><?php echo $this->lang->line('right_to_information_info_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('right_to_rectification'); ?></div>
								<div class="lilo-accordion-content">
									<p class="fourteen"><?php echo $this->lang->line('right_to_rectification_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('right_to_rectification_info_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('right_to_delete'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('right_to_delete_info_text'); ?></p>
									<ul class="termsUl">
        								<li><?php echo $this->lang->line('right_to_delete_info_text_rule_one'); ?></li>
            							<li><?php echo $this->lang->line('right_to_delete_info_text_rule_two'); ?></li>			
            							<li><?php echo $this->lang->line('right_to_delete_info_text_rule_three'); ?></li>
            							<li><?php echo $this->lang->line('right_to_delete_info_text_rule_four'); ?><?php echo $this->lang->line(''); ?></li>
										<li><?php echo $this->lang->line('right_to_delete_info_text_rule_five'); ?></li>  
										<li><?php echo $this->lang->line('right_to_delete_info_text_rule_six'); ?></li>			
									</ul>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('right_to_be_forgotten'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('right_to_be_forgotten_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('right_to_restriction_of_processing'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('right_to_restriction_of_processing_info_text'); ?></p>
									<ul class="termsUl">
        								<li><?php echo $this->lang->line('right_to_restriction_of_processing_info_text_rule_one'); ?></li>
            							<li><?php echo $this->lang->line('right_to_restriction_of_processing_info_text_rule_two'); ?></li>
            							<li><?php echo $this->lang->line('right_to_restriction_of_processing_info_text_rule_three'); ?></li>
            							<!-- <li><?php echo $this->lang->line('right_to_restriction_of_processing_info_text_rule_four'); ?></li> -->
									</ul>
								</div>


								<div class="lilo-accordion-control"><?php echo $this->lang->line('right_to_data_portability'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('right_to_data_portability_info_first'); ?>
									</p>
									<p class="fourteen"><?php echo $this->lang->line('right_to_data_portability_info_second'); ?>
									</p>
									<p class="fourteen"><?php echo $this->lang->line('right_to_data_portability_info_third'); ?>
									</p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('right_to_objection'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('right_to_objection_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('right_to_objection_info_second'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('right_to_objection_info_third'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('right_to_objection_info_fourth'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('right_to_objection_info_fifth'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('right_to_objection_info_sixth'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('automated_decisions_in_individual_cases_including_profiling'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('automated_decisions_in_individual_cases_including_profiling_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('right_to_revoke_a_data_protection_consent'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('right_to_revoke_a_data_protection_consent_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('minor'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('minor_info'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('data_security'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('data_security_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('data_security_info_second'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('data_security_info_third'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('data_security_info_fourth'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('webhost'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('webhost_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('webhost_info_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('server_log_files'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('server_log_files_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('server_log_files_info_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('can_be_detected'); ?></div>
								<div class="lilo-accordion-content">	
									<ul class="termsUl">
										<li><?php echo $this->lang->line('can_be_detected_rule_one'); ?></li>
										<li><?php echo $this->lang->line('can_be_detected_rule_two'); ?></li>
										<li><?php echo $this->lang->line('can_be_detected_rule_three'); ?></li>
										<li><?php echo $this->lang->line('can_be_detected_rule_four'); ?></li>
										<li><?php echo $this->lang->line('can_be_detected_rule_five'); ?></li>  
										<li><?php echo $this->lang->line('can_be_detected_rule_six'); ?></li> 
										<li><?php echo $this->lang->line('can_be_detected_rule_seven'); ?></li> 
										<li><?php echo $this->lang->line('can_be_detected_rule_eight'); ?></li>
									</ul>		
									<p class="fourteen"><?php echo $this->lang->line('can_be_detected_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('this_information_is_needed_to'); ?>	Diese Informationen werden benötigt, um </div>
								<div class="lilo-accordion-content">	
									<ul class="termsUl">
										<li><?php echo $this->lang->line('this_information_is_needed_to_rule_one'); ?></li>
										<li><?php echo $this->lang->line('this_information_is_needed_to_rule_two'); ?></li>
										<li><?php echo $this->lang->line('this_information_is_needed_to_rule_three'); ?></li>
										<li><?php echo $this->lang->line('this_information_is_needed_to_rule_four'); ?></li>
									</ul>
									<p class="fourteen"><?php echo $this->lang->line('this_information_is_needed_to_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('this_information_is_needed_to_info_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('cookies'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('cookies_info'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('how_do_we_collect_your_information_online'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('how_do_we_collect_your_information_online_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('online_forms'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('online_forms_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('online_forms_info_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('e_mail'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('e_mail_info'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('registration_and_voluntary_user_profile_information'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('registration_and_voluntary_user_profile_information_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('notifications'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('notifications_text_info'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('private_messages'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('private_messages_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('newsletter'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('news_info_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('news_info_second'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('news_info_third'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('news_info_fourth'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('news_info_fifth'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('news_info_sixth'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('why_do_we_process_your_data'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('why_do_we_process_your_data_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('to_process_your_order_including_customer_service'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('to_process_your_order_including_customer_service_info_text'); ?>
									</p>
								</div>		

								<div class="lilo-accordion-control"><?php echo $this->lang->line('registration_data'); ?>								 
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('registration_data_info'); ?>
									</p>
								</div>

								<div class="lilo-accordion-control">
									<?php echo $this->lang->line('voluntary_profile_information_of_the_user'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('voluntary_profile_information_of_the_user_info_text'); ?>
									</p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('acquisition_of_credits_and_vip_membership'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('acquisition_of_credits_and_vip_membership_info_text'); ?>
									</p>
								</div>			

								<div class="lilo-accordion-control">
									<?php echo $this->lang->line('newsletter'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('newsletter_info_first'); ?>
									</p>
									<p class="fourteen"><?php echo $this->lang->line('newsletter_info_second'); ?>
									</p>
									<p class="fourteen"><?php echo $this->lang->line('newsletter_info_third'); ?>
									</p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('why_are_we_allowed_to_process_your_data'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('why_are_we_allowed_to_process_your_data_info_text'); ?>
									</p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('to_process_your_order'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('to_process_your_order_info_text'); ?>
									</p>
								</div>		

								<div class="lilo-accordion-control">
									<?php echo $this->lang->line('registration_voluntary_user_profile_information_credits_and_vip_membership_notifications_private_messages'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('registration_voluntary_user_profile_information_legal_information'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('marketing_general'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('marketing_general_info'); ?>
									</p>
								</div>	

								<div class="lilo-accordion-control">
									<?php echo $this->lang->line('newsletter_legal'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('newsletter_legal_info'); ?></p>
								</div>	

								<div class="lilo-accordion-control">
									<?php echo $this->lang->line('which_data_do_we_process'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('which_data_do_we_process_info_text'); ?>
									</p>
								</div>		

								<div class="lilo-accordion-control"><?php echo $this->lang->line('information_desk'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('information_desk_info_text'); ?>
									</p>
								</div>	

								<div class="lilo-accordion-control"><?php echo $this->lang->line('assignment'); ?>
								</div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('assignment_info_text_first'); ?></p>	
									<ul class="termsUl">
										<li><?php echo $this->lang->line('assignment_info_text_first_rule_one'); ?></li>
										<li><?php echo $this->lang->line('assignment_info_text_first_rule_two'); ?></li>
										<li><?php echo $this->lang->line('assignment_info_text_first_rule_three'); ?></li>
									</ul>
									<p class="fourteen"><?php echo $this->lang->line('assignment_info_text_second'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('registration_rule'); ?></div>
								<div class="lilo-accordion-content">			
								<p class="fourteen"><?php echo $this->lang->line('registration_rule_details'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('voluntary_profile_information_of_the_user_reg'); ?></div>
								<div class="lilo-accordion-content">			
								<p class="fourteen"><?php echo $this->lang->line('voluntary_profile_information_of_the_user_reg_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('acquisition_of_credits_and_vip_membership_rule'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('acquisition_of_credits_and_vip_membership_rule_details'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('private_messages_rule'); ?></div>
								<div class="lilo-accordion-content">			
								<p class="fourteen"><?php echo $this->lang->line('private_messages_rule_text'); ?></p>
								</div>			

								<div class="lilo-accordion-control"><?php echo $this->lang->line('newsletter_rule'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('newsletter_rule_text_first'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('newsletter_rule_text_second'); ?></p>
								</div>			

								<div class="lilo-accordion-control"><?php echo $this->lang->line('to_whom_are_your_data_shared'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('to_whom_are_your_data_shared_info_first'); ?></p>
									<ul class="termsUl">
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_first_rule_one'); ?></li>
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_first_rule_two'); ?></li>
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_first_rule_three'); ?></li>        						
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_first_rule_four'); ?></li>
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_first_rule_five'); ?></li>  
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_first_rule_six'); ?></li>
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_first_rule_seven'); ?></li>
									</ul>
									<p class="fourteen"><?php echo $this->lang->line('to_whom_are_your_data_shared_info_second'); ?></p>
									<ul class="termsUl">
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_second_rule_one'); ?></li>
										<li><?php echo $this->lang->line('to_whom_are_your_data_shared_info_second_rule_two'); ?></li>
									</ul>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('registration_voluntary_profile_information_of_the_user'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('registration_voluntary_profile_information_of_the_user_info_text'); ?></p>
								</div>		

								<div class="lilo-accordion-control"><?php echo $this->lang->line('acquisition_of_credits_and_vip_membership_det'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('acquisition_of_credits_and_vip_membership_det_info'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('notifications_private_messages'); ?></div>
								<div class="lilo-accordion-content">			
									<p class="fourteen"><?php echo $this->lang->line('notifications_private_messages_info_text'); ?></p>
								</div>

								<div class="lilo-accordion-control"><?php echo $this->lang->line('how_long_do_we_process_your_data'); ?></div>
								<div class="lilo-accordion-content">	
									<h4 class="mainPt"><?php echo $this->lang->line('information_desk'); ?></h4>		
									<p class="fourteen"><?php echo $this->lang->line('information_desk_data'); ?></p>

									<h4 class="mainPt"><?php echo $this->lang->line('assignment'); ?></h4>		
									<p class="fourteen"><?php echo $this->lang->line('assignment_data_one'); ?></p>
									<p class="fourteen"><?php echo $this->lang->line('assignment_data_two'); ?></p>

									<h4 class="mainPt"><?php echo $this->lang->line('registration_and_volunteer_data_title'); ?></h4>
									<p class="fourteen"><?php echo $this->lang->line('registration_and_volunteer_data'); ?></p>

									<h4 class="mainPt"><?php echo $this->lang->line('notifications_private_messages_title'); ?></h4>
									<p class="fourteen"><?php echo $this->lang->line('notifications_private_messages_data'); ?>
									</p>

									<h4 class="mainPt"><?php echo $this->lang->line('marketing_general'); ?></h4>
									<p class="fourteen"><?php echo $this->lang->line('marketing_general_data'); ?>
									</p>

								<h4 class="mainPt"><?php echo $this->lang->line('newsletter'); ?></h4>
								<p class="fourteen"><?php echo $this->lang->line('newsletter_data'); ?>
								</p>

								<h4 class="mainPt"><?php echo $this->lang->line('google_analytics'); ?></h4>
								<p class="fourteen"><?php echo $this->lang->line('google_analytics_info_one'); ?>
								</p>		
								<!-- <p class="fourteen"><?php echo $this->lang->line('google_analytics_info_two'); ?> -->
								</p>		
								<p class="fourteen"><?php echo $this->lang->line('google_analytics_info_three'); ?>
								</p>		
								<p class="fourteen"><?php echo $this->lang->line('google_analytics_info_four'); ?>
								</p>	
								<p class="fourteen"><?php echo $this->lang->line('google_analytics_info_five'); ?>
								</p>	
								<p class="fourteen"><?php echo $this->lang->line('google_analytics_info_six'); ?>
								</p>
								<p class="fourteen"><?php echo $this->lang->line('google_analytics_info_seven'); ?>
								</p>
								<p class="fourteen"><?php echo $this->lang->line('google_analytics_info_eight'); ?>
								</p>

								<h4 class="mainPt"><?php echo $this->lang->line('use_of_social_media_plugins'); ?></h4>	
								<p class="fourteen"><?php echo $this->lang->line('use_of_social_media_plugins_info_one'); ?>
								</p>
								<p class="fourteen"><?php echo $this->lang->line('use_of_social_media_plugins_info_two'); ?>
								</p>
								<p class="fourteen">
								<a href="https://www.facebook.com/policy.php" target="_blank">https://www.facebook.com/policy.php</a>
								</p>
								<p class="fourteen">
								<a href="https://www.facebook.com/policies/cookies" target="_blank">https://www.facebook.com/policies/cookies</a>
								</p>
								<p class="fourteen">
								<a href="https://www.facebook.com/legal/terms/page_controller_addendum#" target="_blank">https://www.facebook.com/legal/terms/page_controller_addendum#</a>
								</p>
								<p class="fourteen">
								<a href="https://twitter.com/de/privacy" target="_blank">https://twitter.com/de/privacy</a>
								</p>
								<p class="fourteen">
								<a href="https://help.instagram.com/519522125107875" target="_blank">https://help.instagram.com/519522125107875</a>
								</p>	

								<h4 class="mainPt"><?php echo $this->lang->line('facebook_site'); ?></h4>	
								<p class="fourteen"><?php echo $this->lang->line('facebook_site_info_one'); ?>
								</p>	
								<p class="fourteen">
								<a href="https://www.facebook.com/Sugarbabe-Deluxe-325776621387740" target="_blank">https://www.facebook.com/Sugarbabe-Deluxe-325776621387740</a>
								</p>
								<p class="fourteen"><?php echo $this->lang->line('facebook_site_info_two'); ?>
								</p>

								<p class="fourteen">
								<a href="https://www.facebook.com/policy.php" target="_blank">https://www.facebook.com/policy.php</a>
								</p>
								<p class="fourteen">
								<a href="https://www.facebook.com/policies/cookies" target="_blank">https://www.facebook.com/policies/cookies</a>
								</p>
								<p class="fourteen">
								<a href="https://www.facebook.com/business/news/updates-for-page-admins-in-the-eu-and-the-eea" target="_blank">https://www.facebook.com/business/news/updates-for-page-admins-in-the-eu-and-the-eea</a>
								</p>
								<p class="fourteen">
								<a href="https://www.facebook.com/legal/terms/page_controller_addendum#" target="_blank">https://www.facebook.com/legal/terms/page_controller_addendum#</a>
								</p>

								<h4 class="mainPt"><?php echo $this->lang->line('instagram_profile'); ?></h4>	
								<p class="fourteen"><?php echo $this->lang->line('instagram_profile_info_one'); ?>
								</p>	
								<p class="fourteen">
								<a href="https://www.instagram.com/sugarbabe_deluxe.eu" target="_blank">https://www.instagram.com/sugarbabe_deluxe.eu</a>
								</p>
								<p class="fourteen"><?php echo $this->lang->line('instagram_profile_info_two'); ?>
								</p>	
								<p class="fourteen">
								<a href="https://help.instagram.com/519522125107875" target="_blank">https://help.instagram.com/519522125107875</a>
								</p>

								<h4 class="mainPt"><?php echo $this->lang->line('twitter_profile'); ?></h4>	
								<p class="fourteen"><?php echo $this->lang->line('twitter_profile_info_one'); ?>
								</p>	
								<p class="fourteen">
								<a href="https://twitter.com/DeluxeSugarbabe" target="_blank">https://twitter.com/DeluxeSugarbabe</a>
								</p>
								<p class="fourteen"><?php echo $this->lang->line('twitter_profile_info_two'); ?>
								</p>	
								<p class="fourteen">
								<a href="https://twitter.com/de/privacy" target="_blank">https://twitter.com/de/privacy</a>
								</p>
							</div>
						<!--end accrdn-->
						</div>
					</div>   
					<!--privacy policy tab-->   
					</div>
            	</div>
			</div>
    	</div>		
	</div>
</section>
<?php
$this->load->view('templates/footers/main_footer');
?>
