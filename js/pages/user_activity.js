$(document).ready(function() {
	var kiss_receiver_id = '';
	var favorate_member_id = '';
	var question_member_id = '';
	var report_member_id = '';
	var dislike_member_id  = '';
	var unlock_user_id  = '';
	var unlock_picture_id  = '';
	var unlock_chat_user_id  = '';

	var curr_obj = null;

	/* Used For sending image unlock request from profile */
	$(".btn-images-unlock-request").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		unlock_user_id = curr_obj.closest(".profile_data").attr('rel');
		unlock_picture_id = $(".sp-slides .sp-selected").find('img').attr('data-id');

		$("#addUnlockImageRequestModal").modal();
	});

	/* Used For sending Chat unlock request */
	$(document).on("click", ".btn-chat-unlock-request", function(e) {
		e.preventDefault();
		curr_obj = $(this);
		unlock_chat_user_id = curr_obj.closest(".profile_data").attr('rel');
		$("#addUnlockChatRequestModal").modal();
	});

	/* Used For sending Chat unlock request */
	$(document).on("click", "#btn-unlock-chat-request-send", function(e) {
		e.preventDefault();

		if(unlock_chat_user_id != '') {
			$.ajax({
				type: 'post',
				data : {'user_hash': unlock_chat_user_id },
				url: base_url + "user/unlocks/sendChatUnlockRequest",
				success: function(data) {
					$("#addUnlockChatRequestModal").modal('hide');
					setTimeout(function() {
						$("#alertMessageText").html(data.message)
						$("#alertMessageModal").modal('show');
					}, 500);
				}
			});
		}
	});

	/* Used For sending image unlock request */
	$("#btn-unlock-image-request-send").click(function(e) {
		e.preventDefault();

		if(unlock_user_id != '' && unlock_picture_id != '') {
			$.ajax({
				type: 'post',
				data : {'user_hash': unlock_user_id, 'picture_id':unlock_picture_id},
				url: base_url + "user/unlocks/sendImageRequest",
				success: function(data) {
					$("#addUnlockImageRequestModal").modal('hide');
					setTimeout(function() {
						if(data.status == false && data.errorCode == 2) {
							$("#userNotification").modal('show');
						} else {
							$("#alertMessageText").html(data.message)
							$("#alertMessageModal").modal('show');
						}
					}, 500);
				}
			});
		}
	});

	/* Used For Unlock user photo from view Profile */
	$(".btn-show-unlock-by-me-model").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		unlock_user_id = curr_obj.closest(".profile_data").attr('rel');

		$("#user_unlock_memeber_id").val(unlock_user_id);
		$("#unlockUserCreditModal").modal();
	});

	/* Used For Show User Chatting window */
	$(document).on("click", ".flaticon-speech-bubbles-comment-option", function(e) {
		e.preventDefault();
		user_hash = $(this).closest(".profile_data").attr('rel');

		if(user_hash != '') {
			$.ajax({
				type: 'post',
				data : {'user_hash': user_hash},
				url: base_url + "user/chat/setActiveChat",
				success: function(response) {
					if(response.status == true) {
						location.href = base_url + 'chat';
					}
				}
			});
		}
	});

	$(document).on("click", ".flaticon-kiss", function(e) {
		e.preventDefault();
		curr_obj = $(this);
		kiss_receiver_id = curr_obj.closest(".profile_data").attr('rel');

		if(curr_obj.hasClass("active-icon-red") == true) {
			$("#deleteKissModal").modal();
		} else {
			$("#addKissModal").modal();
		}
	});


	$(document).on("click", ".flaticon-like", function(e) {
		e.preventDefault();
		curr_obj = $(this);
		favorate_member_id = $(this).closest(".profile_data").attr('rel');

		if(curr_obj.hasClass("active-icon-yellow") == true) {
			$("#deleteFavoriteModal").modal();
		} else {
			$("#addFavoriteModal").modal();
		}
	});

	$(document).on("click", ".btn-user-dislike", function(e) {
		e.preventDefault();
		curr_obj = $(this);
		dislike_member_id = $(this).closest(".profile_data").attr('rel');

		if(curr_obj.hasClass("active-icon-red") == false) {
			$("#blockUserModal").modal();
		}
	});

	$(".btn-block-user").click(function(e) {
		e.preventDefault();

		if(dislike_member_id != '') {
			$.ajax({
				url: base_url + "user/dislike/add_to_dislike",
				type: 'POST',
				data: {member_id: dislike_member_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).removeClass("btn-user-dislike").addClass("active-icon-red").off('click');
					} else {
						setTimeout(function() {
							$("#alertMessageText").html(data.message)
							$("#alertMessageModal").modal('show');
						}, 500);
					}
				}
			});		
		}
	});

	$(document).on("click", ".flaticon-question-speech-bubble", function(e) {
		e.preventDefault();
		curr_obj = $(this);
		question_member_id = curr_obj.closest(".profile_data").attr('rel');

		$("#userQuestionModal").find('.question_btn').removeClass('question-sent');
		$("#userQuestionModal").find('.question_btn > .btn_span').html(send_question_str);
		$("#userQuestionModal").modal('show');
	});

	$(".send-question").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		var question_id = curr_obj.attr('data-id');

		if(question_member_id != '' && question_id != '') {				
			$.ajax({
				url: base_url + "user/questions/sendQuestion",
				type: 'POST',
				data: {'question_id': question_id, 'member_data': question_member_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).removeClass("send-question");
						$(curr_obj).find('.btn_span').html(data.message);
						$(curr_obj).addClass("question-sent");
					} else {
						if(data.errorCode == 0) {
							$(curr_obj).removeClass("send-question");
							$(curr_obj).find('.btn_span').html(data.message);
							$(curr_obj).addClass("question-sent");
						} else {
							$("#alertMessageText").html(data.message)
							$("#alertMessageModal").modal();
						}
					}
				}
			});		
		}
	});


	$(".delete-user-question").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		var question_id = curr_obj.attr('data-id');

		if(question_id != '') {
			$.ajax({
				url: base_url + "user/questions/deleteQuestion",
				type: 'POST',
				data: {'question_id': question_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).closest('tr')
						.children('td')
						.animate({ padding: 0 }, 1000)
						.wrapInner('<div />')
						.children()
						.slideUp(function() {
							$(curr_obj).closest("tr").next('tr').remove();
							$(curr_obj).closest("tr").remove();
						});
					} else {
						$("#alertMessageText").html(data.message)
						$("#alertMessageModal").modal();
					}
				}
			});		
		}
	});


	$(".btn-disable-user-unlock-request").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		var unlock_req_id = curr_obj.closest('td').attr('data-id');

		if(unlock_req_id != '') {
			$.ajax({
				url: base_url + "user/unlocks/disableImageUnlockRequest",
				type: 'POST',
				data: {'unlock_id': unlock_req_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).closest('tr')
						.children('td')
						.animate({ padding: 0 }, 1000)
						.wrapInner('<div />')
						.children()
						.slideUp(function() {
							$(curr_obj).closest("tr").next('tr').remove();
							$(curr_obj).closest("tr").remove();
						});
					} else {
						$("#alertMessageText").html(data.message)
						$("#alertMessageModal").modal();
					}
				}
			});		
		}
	});

	$(".answer-user-question").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		var question_id = $(this).closest('td').attr('data-id');
		var question_answer = $(this).attr('data-answer');

		if(question_id != '') {
			$.ajax({
				url: base_url + "user/questions/answerQuestion",
				type: 'POST',
				data: {'question_id': question_id, 'question_answer': question_answer},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						question_answer = '<h5 class="qtxt qans">'+question_answer+'</h5>';
						$(curr_obj).closest("td").html(question_answer);
					} else {
						$("#alertMessageText").html(data.message)
						$("#alertMessageModal").modal();
					}
				}
			});		
		}
	});

	$(".btn-unblock-user").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		var member_hash = curr_obj.attr('data-id');

		if(member_hash != '') {
			$.ajax({
				url: base_url + "user/blocked/unblockUser",
				type: 'POST',
				data: {'member_hash': member_hash},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).closest('.blckRow')
						.animate({ height: 0 }, 1000)
						.wrapInner('<div />')
						.children()
						.slideUp(function() {
							$(curr_obj).closest('.blckRow').remove();
						});
					} else {
						$("#alertMessageText").html(data.message)
						$("#alertMessageModal").modal();
					}
				}
			});
		}
	});

	$(".btn-report-user").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		report_member_id = curr_obj.closest(".profile_data").attr('rel');
		$("#reportUserModal").modal();
	});

	$(".btn-send-report").click(function(e) {
		e.preventDefault();
		var report_reason = $('input[name=report_reason]:checked').val();
		var other_reason = $('#other_report_reason').val();

		if(report_member_id != '') {
			$.ajax({
				url: base_url + "user/report/send",
				type: 'POST',
				data: {'report_reason': report_reason, 'other_reason': other_reason, 'report_member_data': report_member_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$("#alertMessageText").html(data.message)
						$(curr_obj).removeClass("btn-report-user").addClass("active-icon-red").off('click');
					} else {
						$("#alertMessageText").html(data.message)
					}
					$("#reportUserModal").remove();
					$("#alertMessageModal").modal();
				}
			});		
		}
	});

	$("#alertbtn").click(function(e) {
		$(".modal-backdrop.fade.in").addClass('hideBack');
	});


	$(".btn-add-favorite").click(function(e) {
		e.preventDefault();

		if(favorate_member_id != '') {
				
			$.ajax({
				url: base_url + "user/favorite/add_to_favorite",
				type: 'POST',
				data: {member_id: favorate_member_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).addClass( "active-icon-yellow");
					} else {
						setTimeout(function() {
							$("#alertMessageText").html(data.message)
							$("#alertMessageModal").modal('show');
						}, 500);
					}
				}
			});		
		}
	});

	$(".btn-delete-favorite").click(function(e) {
		e.preventDefault();

		if(favorate_member_id != '') {
			$.ajax({
				url: base_url + "user/favorite/delete_from_favorite",
				type: 'POST',
				data: {member_id: favorate_member_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).removeClass("active-icon-yellow");
					} else {
						setTimeout(function() {
							$("#alertMessageText").html(data.message)
							$("#alertMessageModal").modal('show');
						}, 500);
					}
				}
			});
		}
	});

	$(".btn-send-kiss").click(function(e) {
		e.preventDefault();
		
		if(kiss_receiver_id != '') {
			$.ajax({
				url: base_url + "user/kisses/send_kiss",
				type: 'POST',
				data: {member_id: kiss_receiver_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).addClass( "active-icon-red");
					} else {
						setTimeout(function() {
							$("#alertMessageText").html(data.message)
							$("#alertMessageModal").modal('show');
						}, 500);
					}
				}
			});		
		}
	});

	$(".btn-remove-kiss").click(function(e) {
		e.preventDefault();
		
		if(kiss_receiver_id != '') {
			$.ajax({
				url: base_url + "user/kisses/remove_kiss",
				type: 'POST',
				data: {member_id: kiss_receiver_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).removeClass("active-icon-red");
					} else {
						setTimeout(function() {
							$("#alertMessageText").html(data.message)
							$("#alertMessageModal").modal('show');
						}, 500);
					}
				}
			});
		}		
	});
	
	/* Used For Reject user unlock request */
	$(".btn-unlock-reject").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		var unlock_id = curr_obj.closest('td').attr('data-id');

		if(unlock_id != '') {
			$.ajax({
				url: base_url + "user/unlocks/rejectUnlockRequest",
				type: 'POST',
				data: {'unlock_id': unlock_id},
				dataType:'json',
				success: function(data) {
					if(data.status == true) {
						$(curr_obj).closest('tr')
						.children('td')
						.animate({ padding: 0 }, 1000)
						.wrapInner('<div />')
						.children()
						.slideUp(function() {
							$(curr_obj).closest("tr").next('tr').remove();
							$(curr_obj).closest("tr").remove();
						});
					} else {
						$("#alertMessageText").html(data.message)
						$("#alertMessageModal").modal();
					}
				}
			});		
		}
	});	

	$(".btn-show-chat-unlock-model").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		var unlock_id = curr_obj.closest('td').attr('data-id');

		$("#user_unlock_chat_request_id").val(unlock_id);
		$("#unlockUserChatCreditModal").modal();
	});

	$(".btn-show-image-unlock-model").click(function(e) {
		e.preventDefault();
		curr_obj = $(this);
		var unlock_id = curr_obj.closest('td').attr('data-id');

		$("#user_unlock_image_request_id").val(unlock_id);
		$("#unlockImageCreditModal").modal();
	});



});