var stopUserLoading = false;
var lockLoadUserAPI = false;

$(document).ready(function() {
	var currOnlineUsersPage = 0;

	if(userLoggedIn == true) {
		setTimeout(syncWithServer, 300);
		setTimeout(loadOnlineUsers(currOnlineUsersPage), 300);
	}

	$("#onlineUsersList").scroll(function () {
        var elementHeight = $("#onlineUsersList")[0].scrollHeight;
        var scrollPosition = $("#onlineUsersList").height() + $("#onlineUsersList").scrollTop();
       
        if(scrollPosition > ((elementHeight / 3)*2)) {
        	//alert(elementHeight + ' : ' + scrollPosition);        	
        	if(stopUserLoading == false && lockLoadUserAPI == false) {
        		currOnlineUsersPage++;
        		lockLoadUserAPI = true;
        		loadOnlineUsers(currOnlineUsersPage);
        	}
        }
	});

	$(document).on("keyup", "#onlineUserSerachText" , function() {
		currOnlineUsersPage = 0;
		stopUserLoading = false;
		loadOnlineUsers(currOnlineUsersPage);
	});

	$(document).on("click", "#onlineUsersList .sideBar-body" , function() {
		var user_hash = $(this).attr('id');

		if(user_hash != '') {
			location.href = base_url + 'user/profile/view?query=' + user_hash;
		}
	});

});

function syncWithServer() {
	$.ajax({
		type: 'post',
		async: false,
		url: base_url + "user/online/sync",
		success: function(response) {
			if(response.status == true) {
				if($("#online_user_count").html() != undefined) {
					$("#online_user_count").html(response.total_online_users);

					// For Sidebar Chatting : change online status of user and show to top
					if($('#onlineUsersList').html() != undefined) {
						$('#onlineUsersList').find('.user_status').remove();
						$('#profile_view').find('.onoffStatusSpn').remove();
						// $('#profile_view').find('.newuser-icon').remove();

						if(response.total_online_users > 0) {
							for(ind=0; ind < response.total_online_users; ind++) {
								var cobj = document.getElementById(response.online_users_hash[ind]['user_hash']);

								if(cobj != null) {
									// make user is online
									$(cobj).find('.avatar-icon').prepend('<span class="user_status"></span>');
									// shift online users to top
									$(cobj).clone().prependTo("#onlineUsersList");
									$(cobj).remove();
									
								} else {
									var online_users = '';
							     	online_users += '<div class="row animate fadeInLeftBig sideBar-body" id="'+ response.online_users_hash[ind].user_hash +'">\n\
								        <div class="col-sm-3 col-xs-3 sideBar-avatar">\n\
								          <div class="avatar-icon">\n\
								    			<span class="user_status"></span>\n\
								    			<img src="'+ base_url + response.online_users_hash[ind].user_active_photo_thumb + '">\n\
								            </div>\n\
								          </div>\n\
								          <div class="col-sm-9 col-xs-9 sideBar-main">\n\
								            <div class="row">\n\
								              <div class="col-sm-12 col-md-12 col-xs-12 sideBar-name">\n\
								                <span class="name-meta">'+response.online_users_hash[ind].user_access_name + ' | '+ Math.floor(response.online_users_hash[ind].user_age) + '</span>\n\
								              </div>\n\
								              <div class="col-sm-12 col-md-12 col-xs-12 pull-right sideBar-city">\n\
								                <span class="city-meta">'+response.online_users_hash[ind].user_city + '</span>\n\
								              </div>\n\
								            </div>\n\
								        </div>\n\
								    </div>';
								    $("#onlineUsersList").prepend(online_users);
								}
							}
						}

						if(response.total_online_home_users > 0) {
							for(ind=0; ind < response.total_online_home_users; ind++) {
								var cobj = document.getElementById(response.online_home_users_hash[ind]['user_hash']);

								// Check user is added or not on home page and change online status
								var imgObj = $('#img_' + response.online_home_users_hash[ind].user_id).html();
								if($('#is_home_page').html() != undefined) {
									if(imgObj == undefined) {
										var new_icon_teg = "";
										if(response.online_home_users_hash[ind].is_new == true) {
		                                    new_icon_teg = '<span class="newuser-icon">' + ln_new_str + '</span>';
		                                }
				                        var home_users = '<div class="col-xs-18 col-sm-6 col-md-3 col-xs-6 isOnineNow">\n\
				                            <div class="profile_thumbnail profile_data" rel="'+ response.online_home_users_hash[ind].user_id_encrypted +'">\n\
				                                <a target="_blank" id="img_'+ response.online_home_users_hash[ind].user_id +'" href="' + base_url + 'user/profile/view?query=' + response.online_home_users_hash[ind].user_hash + '" class="profile_a">\n\
				                                <span class="onoffStatusSpn os">' + ln_online_str + '</span>\n\
				                                ' + new_icon_teg + '<img src="' + base_url + response.online_home_users_hash[ind].user_active_photo_thumb + '" alt="">\n\
				                                    <div class="inner_div imghvr-shutter-out-horiz">\n\
				                                        <h4>' + ln_view_profile_str + '</h4>\n\
				                                    </div>\n\
				                                </a>\n\
				                                <div class="caption">\n\
				                                    <div class="row">\n\
				                                        <div class="col-md-12 col-sm-12 col-xs-12">\n\
				                                            <h4 class="pro_name">\n\
				                                                ' + response.online_home_users_hash[ind].user_access_name + ' | \n\
				                                                ' + response.online_home_users_hash[ind].user_age + '\n\
				                                            </h4>\n\
				                                        </div>\n\
				                                        <div class="col-md-12 col-sm-12 col-xs-12">\n\
				                                            <h4 class="loc_km">\n\
				                                                <span class="km">\n\
				                                                    ' + response.online_home_users_hash[ind].distance + 'km - \n\
				                                                    <span class="city">\n\
				                                                        ' + response.online_home_users_hash[ind].user_city + '\n\
				                                                    </span>\n\
				                                                </span>\n\
				                                            </h4>\n\
				                                        </div>\n\
				                                    </div>\n\
				                                    <hr class="pro_hr" />\n\
				                                    <div class="row">\n\
				                                        <div class="actions_div">\n\
				                                            <ul class="profile_actions">\n\
				                                                <li>\n\
				                                                    <a href="#" data-tooltip="Questions" data-position="bottom" class="bottom">\n\
				                                                        <i class="flaticon-speech-bubbles-comment-option"></i>\n\
				                                                    </a>\n\
				                                                    <i class="flaticon-kiss ';
				                                                    if(response.online_home_users_hash[ind].is_kissed == true) {
				                                                        home_users += 'active-icon-red';
				                                                    }
				                                                    home_users += '"></i>\n\
				                                                    <i class="flaticon-like ';
				                                                    if(response.online_home_users_hash[ind].is_favorite == true) {
				                                                        home_users += 'active-icon-yellow';
				                                                    }
				                                                    home_users += '"></i>\n\
				                                                    <i class="flaticon-question-speech-bubble"></i>\n\
				                                                </li>\n\
				                                            </ul>\n\
				                                            <div class="clearfix"></div>\n\
				                                        </div>\n\
				                                    </div>\n\
				                                </div>';

			                            if(response.online_home_users_hash[ind].user_is_vip == 'yes') {
			                                home_users += '<img src="'+ base_url + 'images/vip_icon.png" class="vip_icon" alt="">';
			                            }

				                        home_users += '</div>\n\
				                        </div>';

			                            $("#profile_view").prepend(home_users);
			                            
			                            $("body").animate({scrollTop: 0}, 500);
		                        	} else {
		                        		if($('#img_' + response.online_home_users_hash[ind].user_id).find('span').hasClass('onoffStatusSpn') == false) {
											$('#img_' + response.online_home_users_hash[ind].user_id).prepend('<span class="onoffStatusSpn os">' + ln_online_str + '</span>');
											if(response.online_home_users_hash[ind].is_new){
												// $('#img_' + response.online_home_users_hash[ind].user_id).prepend('<span class="newuser-icon">' + ln_new_str + '</span>');
											}
		                        			cobj = $('#img_' + response.online_home_users_hash[ind].user_id).closest('.col-xs-18');
											$(cobj).clone().prependTo("#profile_view");
											$(cobj).remove();
		                        		}
		                        	}
								}
								// END Logic for Home Page Online Users
							}
						}								

					}

					// For Online Chatting Window : user after clicking on chat menu, change status of online users
					if($('#onlineChatUsersList').html() != undefined) {

						$('#onlineChatUsersList').find('.contact-status').remove();
						if(response.total_online_users > 0) {
							for(ind=0; ind < response.total_online_users; ind++) {						
								var cobj = document.getElementById(response.online_users_hash[ind]['user_hash']);

								if(cobj != null) {
									// Show new message arrived with message count
									if(response.online_users_hash[ind]['message_count'] > 0) {
										if( $(cobj).hasClass('active') == true )  {
											getRecentChatMessages();
										} else {
											$(cobj).find('.contc_bx count').remove();
											$(cobj).find('.contc_bx').append('<div class="count">'+ response.online_users_hash[ind]['message_count'] +'</div>');
										}
									}
									// make user as online								
									$(cobj).find('.wrap').prepend('<span class="contact-status online"></span>');
									$(cobj).clone().prependTo("#onlineChatUsersList");
									$(cobj).remove();
								} else {
									if(response.online_users_hash[ind]['message_count'] > 0) {
										var online_users = '';
										online_users += '<li class="contact userchaticon" id="'+ response.online_users_hash[ind]['user_hash'] +'">\n\
											<div class="wrap">\n\
												<span class="contact-status online"></span>\n\
													<div class="contc_bx">\n\
													<img src="'+ base_url + response.online_users_hash[ind].user_active_photo_thumb + '" alt="" />';

										if(response.online_users_hash[ind]['message_count'] > 0) {
											online_users += '<div class="count">'+ response.online_users_hash[ind]['message_count'] +'</div>';
										}

										online_users += '</div>\n\
												<div class="meta">\n\
													<p class="name">'+response.online_users_hash[ind].user_access_name + '</p>\n\
													<p class="preview">&nbsp;</p>\n\
												</div>\n\
												<div class="TimeStats"><div><b>...</b></div><div></div></div></div>\n\
											</div>\n\
										</li>';

										$("#onlineChatUsersList").prepend(online_users);
									}
								}
							}
						}
					}

				}
				if($("#new_user_count").html() != undefined) {
					$("#new_user_count").html(response.total_online_new_users);
				}
				setTimeout(syncWithServer, 10000);
			} else {
				location.href = response.redirect_url;
			}
    	},
    	error: function (xhr, ajaxOptions, thrownError) {
    		setTimeout(syncWithServer, 20000);
    	}
	});

}


function loadOnlineUsers(page_no) {
	var online_users = '';

	if($("#onlineUsersList").html() != undefined) {
		var search_key = $("#onlineUserSerachText").val();

		$.ajax({
			type: 'post',
			url: base_url + "user/online/getOnlineUsers",
			data: {'page_no': page_no, 'search_key': search_key},
			success: function(response) 
			{
				var online_users = '';
				if(response.errorCode == 0) {
					for(i=0; i < response.data.length; i++) {
						var userAdded = document.getElementById(response.data[i].user_hash);

						if(userAdded == null) {
					     	online_users += '<div class="row animate fadeInLeftBig sideBar-body" id="'+ response.data[i].user_hash +'">\n\
						        <div class="col-sm-3 col-xs-3 sideBar-avatar">\n\
						          <div class="avatar-icon">';

						    if(response.data[i].last_online_time < '00:59:00') {
						    	online_users += '<span class="user_status"></span>';
						    }
						            
						    online_users += '<img src="'+ base_url + response.data[i].user_active_photo_thumb + '">\n\
						            </div>\n\
						          </div>\n\
						          <div class="col-sm-9 col-xs-9 sideBar-main">\n\
						            <div class="row">\n\
						              <div class="col-sm-12 col-md-12 col-xs-12 sideBar-name">\n\
						                <span class="name-meta">'+response.data[i].user_access_name + ' | '+ Math.floor(response.data[i].user_age) + '</span>\n\
						              </div>\n\
						              <div class="col-sm-12 col-md-12 col-xs-12 pull-right sideBar-city">\n\
						                <span class="city-meta">'+response.data[i].user_city + '</span>\n\
						              </div>\n\
						            </div>\n\
						        </div>\n\
						    </div>';
						}
					}			        
				} else {
					stopUserLoading = true;
				}
				if(page_no == 0) {
					$("#onlineUsersList").html(online_users);
				} else {
					$("#onlineUsersList").append(online_users);
				}
				lockLoadUserAPI = false;
	    	}
    	});
    }    
}
