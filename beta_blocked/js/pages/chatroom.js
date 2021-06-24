var stopChatUserLoading = false;
var lockChatLoadUserAPI = false;
var activeUserChat = "";
var friend_user_url = '';
var currChatOnlineUsersPage = 0;
var chatLibraryActive = false;


$(document).ready(function() {

  	//$('.emoji_i').tooltip();
	/* Used For Unlock user chat */
	$(document).on("click", ".btn-show-chat-unlock-by-me-model" , function(e) {
		e.preventDefault();
		curr_obj = $(this);		

		// check for valid request
		$.ajax({
			type: 'post',
			data : {'user_hash': activeUserChat},
			url: base_url + "user/unlocks/isValidChatUnlockRequest",
			success: function(response) {
				if(response.status == true) {
					$("#user_unlock_member_id").val(activeUserChat);
					$("#unlockChatCreditModal").modal();
				} else {
					$("#alertMessageText").html(response.message)
					$("#alertMessageModal").modal('show');
				}
			}
		});
	});


  	$("#btn-smileys").click(function(e) {
  		if($("#smileybox").css('visibility') == 'visible') {
  			$("#smileybox").css('visibility', 'hidden');
  		} else {
  			$("#smileybox").css('visibility', 'visible');	
  		}		
	});

	$(".emojoIcon").click(function(e) {
		var curr_obj = $(this);
		var prv = $("#userTextMessage").html() + curr_obj.html();
		$("#userTextMessage").html(prv);
		$("#userTextMessage").find('br').remove();
		$("#smileybox").css('visibility', 'hidden');
  		//curr_obj.attr('data-text');
  	});

	setTimeout(loadOnlineChatUsers(currChatOnlineUsersPage), 2000);

	$(".btn-add-chat-favorite").click(function(e) {
		var curr_obj = $(this);
		e.preventDefault();

		if(curr_obj.hasClass('active-icon-yellow') == false) {
			if(activeUserChat != '') {
					
				$.ajax({
					url: base_url + "user/favorite/add_to_favorite",
					type: 'POST',
					data: {member_id: activeUserChat},
					dataType:'json',
					success: function(data) {
						if(data.status == true) {
							$(curr_obj).removeClass('fa-star-o').addClass("fa-star active-icon-yellow");
						} else {
							$(curr_obj).removeClass('fa-star-o').addClass("fa-star active-icon-yellow");
						}
					}
				});		
			}
		}
	});	

	$("#contacts.scrollBar").scroll(function () {
        var elementHeight = $("#contacts.scrollBar")[0].scrollHeight;
        var scrollPosition = $("#contacts.scrollBar").height() + $("#contacts.scrollBar").scrollTop();
       
        if(scrollPosition > ((elementHeight / 3)*2)) {
        	//alert(elementHeight + ' : ' + scrollPosition);        	
        	if(stopChatUserLoading == false && lockChatLoadUserAPI == false) {
        		currChatOnlineUsersPage++;
        		lockChatLoadUserAPI = true;
        		loadOnlineChatUsers(currChatOnlineUsersPage);
        	}
        }
	});

	$(document).on("keyup", "#onlineChatUserSerachText" , function() {
		currChatOnlineUsersPage = 0;
		activeUserChat = "";
		stopChatUserLoading = false;
		$("#onlineChatUsersList").html('');		
		loadOnlineChatUsers(currChatOnlineUsersPage);
	});

	// its used for loading user recent chat session data
	$(document).on("click", ".userchaticon" , function() {
		var that = $(this);
		var win_width = $( window ).width(); 

		if(win_width > 768) {
			$("#sidepanel").show();	
		} else {
			$("#sidepanel").hide();
		}

		var user_hash = that.attr('id');		
		var user_image_url =  $('.userpic').find('img').attr('src');;
		friend_user_url = that.find('.contc_bx img').attr('src');
		var friend_name =  that.find('.meta .name').html();
		activeUserChat = user_hash;

		if(user_hash != '') {
			$(".userchaticon").removeClass('active');
			that.addClass('active');
	
			$.ajax({
				type: 'post',
				url: base_url + "user/chat/loadUserChatMessages",
				data: {'user_hash': user_hash},
				success: function(response)  {
					var user_chat_text = '';
					chatLibraryActive = true;

					// Track Friend typing activity
					getFriendMessageTypingActivity();
					if(response.errorCode == 2) {						
						chatLibraryActive = false;
					}

					if(response.status == true) {
						that.find('.count').remove();
						$("#chatMessageTexFooter").show();

						if(response.errorCode == 0) {
							for(i=0; i < response.data.length; i++) {
								user_chat_text += '<li class="'+ response.data[i].message_ack +'">\n\
									';

								if(response.data[i].message_ack == 'replies') {
									user_chat_text += '<div class="chatImg"><div class="imgDivChat"><img src="'+ user_image_url + '" alt="" /></div><div class="chatTime os">'+ response.data[i].message_sent_date +'</div></div>';
								} else {
									user_chat_text += '<div class="chatImg"><div class="imgDivChat"><img src="'+ friend_user_url + '" alt="" /></div><div class="chatTime os">'+ response.data[i].message_sent_date +'</div></div>';
								}

								user_chat_text += '<div class="msgDiv"><p>'+ response.data[i].message_text +'</p>\n\
									</div>\n\
								</li>';
							}
						}

						if(response.errorCode == 2) {
							user_chat_text = response.data;
							$("#chatMessageTexFooter").hide();
						}
					}
					if(response.isFavorite == true) {
						$(".btn-add-chat-favorite").removeClass('fa-star-o').addClass("fa-star active-icon-yellow");
					} else {
						$(".btn-add-chat-favorite").removeClass('active-icon-yellow').removeClass('fa-star').addClass("fa-star-o");
					}
					$("#chatting_friend_name").html(friend_name);
					$("#user_messages_data").html(user_chat_text);
					$(".chatBoxScrollbar").animate({scrollTop: $(".chatBoxScrollbar")[0].scrollHeight}, 500);
					$("#userTextMessage").focus();

					if(response.errorCode == 2) {
						$("#user_messages_data").hide();
						$("#user_messages_data").fadeIn(500, function(){
						    $("#user_messages_data").addClass('animated fadeIn');
						});
					}
				}
			});
		}		
	});

	$(document).on("click", "#sendUserChatmessage" , function() {
		sendChatMessage();
	});

	$(document).on("keyup", "#userTextMessage" , function(event) {
		if($(this).html() != '' && $(this).html() != '<br>') {			
			var keycode = (event.keyCode ? event.keyCode : event.which);
	   		if(keycode == '13') {
	   			$('#sendUserChatmessage').click();
	    	} else {
	    		if(keycode != '8') {
	    			updateUserMessageTypingActivity();
	    		}
	    	}
		} else {
			$(this).html('');
		}
	});

	/* Used For sending Chat unlock request */
	$(document).on("click", ".btn-chat-unlock-request-in-chat", function(e) {
		e.preventDefault();
		$("#addUnlockForChatRequestModal").modal();
	});


	/* Used For sending Chat unlock request */
	$(document).on("click", "#btn-unlock-chat-request-send-in-chat", function(e) {
		e.preventDefault();

		if(activeUserChat != '') {
			$.ajax({
				type: 'post',
				data : {'user_hash': activeUserChat },
				url: base_url + "user/unlocks/sendChatUnlockRequestInChat",
				success: function(data) {
					$("#addUnlockForChatRequestModal").modal('hide');
					setTimeout(function() {
						$("#alertMessageText").html(data.message)
						$("#alertMessageModal").modal('show');
					}, 500);
				}
			});
		}
	});
	
	$(document).on("click", ".chat_button", function(e) {
		$("#sidepanel").show();
	});

	$(document).on("click", "#userTextMessage", function(e) {
		$("#userTextMessage").focus();
	});
});


function loadOnlineChatUsers(page_no) {
	var online_users = '';

	if($("#onlineChatUsersList").html() != undefined) {
		var search_key = $("#onlineChatUserSerachText").val();

		$.ajax({
			type: 'post',
			url: base_url + "user/chat/getChattingUsers",
			data: {'page_no': page_no, 'search_key': search_key},
			success: function(response) 
			{
				var online_users = '';
				if(response.errorCode == 0) {
					if(page_no == 0) {
						$("#onlineChatUsersList").html('');
					}

					for(i=0; i < response.data.length; i++) {
						var userAdded = document.getElementById(response.data[i].user_hash);
	
						if(userAdded == null) {
							if(response.data[i].active_chat == true) {
								activeUserChat = response.data[i].user_hash;
							}

							online_users = '<li class="contact userchaticon" id="'+ response.data[i].user_hash +'">\n\
								<div class="wrap">';

						    if(response.data[i].last_online_time < '00:30:00') {
								online_users += '<span class="contact-status online"></span>';
							} else {
								//online_users += '<span class="contact-status busy"></span>';
							}

							online_users += '<div class="contc_bx">\n\
									<img src="'+ base_url + response.data[i].user_active_photo_thumb + '" alt="" />';

							if(response.data[i].unseen_message_count > 0) {
								online_users += '<div class="count">'+ response.data[i].unseen_message_count +'</div>';
							}

							online_users += '</div>\n\
									<div class="meta">\n\
										<p class="name">'+response.data[i].user_access_name + '</p>\n\
										<p class="preview">'+ response.data[i].last_message.message_text  +'</p>\n\
									</div>\n\
								<div class="TimeStats"><div><b>...</b></div><div>'+ response.data[i].last_message.message_sent_time +'</div></div></div>\n\
							</li>';

							if(response.data[i].unseen_message_count > 0) {
								$("#onlineChatUsersList").prepend(online_users);
							} else {
								$("#onlineChatUsersList").append(online_users);
							}

						}
					}			        
				} else {
					stopChatUserLoading = true;
				}

				if(activeUserChat != '') {
					var actobj = document.getElementById(activeUserChat);
					$(actobj).trigger('click');
				}
				lockChatLoadUserAPI = false;
	    	}
    	});
    }    
}

function sendChatMessage() {
	var message_text = $("#userTextMessage").html();
	var user_image_url =  $('.userpic').find('img').attr('src');

	var todaydate = new Date();
 	var hours = todaydate.getHours();
  	var minutes = todaydate.getMinutes();
  	var ampm = hours >= 12 ? 'PM' : 'AM';
  	hours = hours % 12;
  	hours = hours ? hours : 12; // the hour '0' should be '12'
  	minutes = minutes < 10 ? '0'+minutes : minutes;
  	var now = hours + ':' + minutes + ' ' + ampm;

	if(activeUserChat != '' && chatLibraryActive == true) {
		$("#userTextMessage").html('');

		$.ajax({
			type: 'post',
			url: base_url + "user/chat/sendChatMessage",
			data: {'user_hash': activeUserChat, 'message_text': message_text},
			success: function(response)  {
				var user_chat_text = '';

				if(response.status == true) {
					user_chat_text += '<li class="replies">\n\
						';
					user_chat_text += '<div class="chatImg"><div class="imgDivChat"><img src="'+ user_image_url + '" alt="" /></div><div class="chatTime os">'+ response.messageTime +'</div></div>';
					user_chat_text += '<div class="msgDiv"><p>'+ response.messageText +'</p>\n\
						</div>\n\
					</li>';
					$("#user_messages_data").append(user_chat_text);
					$(".chatBoxScrollbar").animate({scrollTop: $(".chatBoxScrollbar")[0].scrollHeight}, 1000);					
				} else {
					if(response.errorCode == 2) {
						$("#user_messages_data").html(response.data);
					}
					$("#alertMessageText").html(response.message)
					$("#alertMessageModal").modal('show');
				}
				$("#userTextMessage").focus();
			}
		});			
	} else {
		$("#alertMessageText").html(please_select_user_for_chatting);
		$("#alertMessageModal").modal('show');		
	}	
}

function getRecentChatMessages() {

	if(activeUserChat != '' && chatLibraryActive == true) {
		$.ajax({
			type: 'post',
			url: base_url + "user/chat/getRecentChatMessage",
			data: {'user_hash': activeUserChat},
			success: function(response)  {
				var user_chat_text = '';

				if(response.status == true) {
					for(i=0; i < response.data.length; i++) {
						user_chat_text += '<li class="sent">\n\
							<div class="chatImg"><div class="imgDivChat"><img src="'+ friend_user_url + '" alt="" /></div><div class="chatTime os">'+  response.data[i].message_sent_date +'</div></div>\n\
							<div class="msgDiv"><p>'+ response.data[i].message_text +'</p>\n\
							</div>\n\
						</li>';
					}						

					$("#user_messages_data").append(user_chat_text);
					$(".chatBoxScrollbar").animate({scrollTop: $(".chatBoxScrollbar")[0].scrollHeight}, 500);
				}					
			}
		});			
	}	
}

var updateMessagActivity = true;

function updateUserMessageTypingActivity() {

	if(activeUserChat != '' && updateMessagActivity == true && chatLibraryActive == true) {
		updateMessagActivity = false;

		$.ajax({
			type: 'post',
			url: base_url + "user/chat/updateUserMessageTypingActivity",
			data: {'user_hash': activeUserChat},
			success: function(response)  {
				setTimeout(function() {
					updateMessagActivity = true;
				}, 1500);
			}
		});			
	}	
}

var typingMessagActivity = true;

function getFriendMessageTypingActivity() {

	$("#user_is_typing").hide();
	if(activeUserChat != '' && typingMessagActivity == true && chatLibraryActive == true) {
		typingMessagActivity = false;

		$.ajax({
			type: 'post',
			//async: false,
			url: base_url + "user/chat/getFriendMessageTypingActivity",
			data: {'user_hash': activeUserChat},
			success: function(response)  {
				if(response.status == true) {
					// Success
					$("#user_is_typing").show();
				}

				setTimeout(function() {
					typingMessagActivity = true;
					getFriendMessageTypingActivity();
				}, 5000);
			},
    		error: function (xhr, ajaxOptions, thrownError) {
    			typingMessagActivity = true;
    			setTimeout(getFriendMessageTypingActivity, 10000);
    		}
		});

	}	
}