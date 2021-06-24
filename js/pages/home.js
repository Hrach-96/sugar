var stopHomeUserLoading = false;
var lockLoadHomeUserAPI = false;

$(document).ready(function() {
    var currHomeUsersPage = 0;

    if($('#is_home_page').val() == 'yes') {
        setTimeout(loadHomePageUsers(currHomeUsersPage), 10);
    }

    $('.body').scroll(function () {
        if($('#is_home_page').val() == 'yes') {
            var elementHeight = $('.body')[0].scrollHeight;
            var scrollPosition = $('.body').height() + $('.body').scrollTop();    

            if(scrollPosition > ((elementHeight / 3) * 2)) {

                if(stopHomeUserLoading == false && lockLoadHomeUserAPI == false) {
                    console.log(elementHeight + ' : ' + scrollPosition);
                    currHomeUsersPage++;
                    lockLoadHomeUserAPI = true;
                    loadHomePageUsers(currHomeUsersPage);
                }
            }
        }
    });

    $(document).on("click", ".go-back", function(e) {
        window.history.back();
    });

    $(document).on("click", "#searchForm input[name=serious_relationship]:checked", function(e) {
      	$("#searchForm input[name='contact_request[]']").attr("checked", false);
    });

    $(document).on("click", "#searchForm input[name='contact_request[]']:checked", function(e) {
      $("#searchForm input[name=serious_relationship]").attr("checked", false);
    });	


    $(document).on("click", "#editForm input[name=serious_relationship_interested]:checked", function(e) {
      	$("#editForm input[name='user_contact_request[]']").attr("checked", false);
    });

    $(document).on("click", "#editForm input[name='user_contact_request[]']:checked", function(e) {
      $("#editForm input[name=serious_relationship_interested]").attr("checked", false);
    });	


    $(document).on("click", "#add-user-sport", function(e) {
        var prev_selected_sports = $("#editForm input[name='user_sports_selected[]']").val();
        var add_item = true;
        var itm_val = $("#editForm select[name=user_sports] option:selected").val();
        var itm_text = $("#editForm select[name=user_sports] option:selected").text();

        if(prev_selected_sports != undefined) {
            $("#editForm input[name='user_sports_selected[]']").each(function(){
                var itm_id = $(this).val();
                if(itm_id == itm_val) {
                   add_item = false;
                }
            });
        }

        if(add_item == true) {
            var litem = '<div class="alert tag-alert tag-alert-golden alert-dismissible fade in">\n\
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n\
                  '+ itm_text +'<input type="hidden" name="user_sports_selected[]" value="'+itm_val+'" >\n\
              </div>';          

            $("#sports_selected_items").append(litem);
        }
    });

    $(document).on("click", "#add-user-interest", function(e) {
        var prev_selected_interests = $("#editForm input[name='user_interests_selected[]']").val();
        var add_item = true;
        var itm_val = $("#editForm select[name=user_interests] option:selected").val();
        var itm_text = $("#editForm select[name=user_interests] option:selected").text();

        if(prev_selected_interests != undefined) {
            $("#editForm input[name='user_interests_selected[]']").each(function(){
                var itm_id = $(this).val();
                if(itm_id == itm_val) {
                   add_item = false;
                }
            });
        }

        if(add_item == true) {
            var litem = '<div class="alert tag-alert tag-alert-golden alert-dismissible fade in">\n\
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n\
                  '+ itm_text +'<input type="hidden" name="user_interests_selected[]" value="'+itm_val+'" >\n\
              </div>';          

            $("#interests_selected_items").append(litem);
        }
    });

    $(document).on("click", "#add-user-language", function(e) {
        var prev_selected_languages = $("#editForm input[name='user_languages_selected[]']").val();
        var add_item = true;
        var itm_val = $("#editForm select[name=user_languages] option:selected").val();
        var itm_text = $("#editForm select[name=user_languages] option:selected").text();

        if(prev_selected_languages != undefined) {
            $("#editForm input[name='user_languages_selected[]']").each(function(){
                var itm_id = $(this).val();
                if(itm_id == itm_val) {
                   add_item = false;
                }
            });
        }

        if(add_item == true) {
            var litem = '<div class="alert tag-alert tag-alert-golden alert-dismissible fade in">\n\
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n\
                  '+ itm_text +'<input type="hidden" name="user_languages_selected[]" value="'+itm_val+'" >\n\
              </div>';          

            $("#languages_selected_items").append(litem);
        }
    });

    $(document).on("click", ".set-profile-picture", function(e) {
        var pic_data = $(this).closest('.pro_pic').attr('rel');
        var pic_url =  $(this).closest('.pro_pic').find('.proPicImg').attr('src');

        $.ajax({
            url: base_url + "user/profile/setAsProfilePicture",
            type: 'POST',
            data: {'pic_data': pic_data},
            dataType:'json',
            success: function(data) {
                if(data.status == true) {
                    $(".userpic img").attr('src', pic_url);
                    $('#imagePreview').css('background-image', 'url('+ pic_url +')');
                } else {
                    if(data.errorCode == 2) {
                        $(".userpic img").attr('src', data.data);
                        $('#imagePreview').css('background-image', 'url('+ data.data +')');                        
                    }
                    $("#alertMessageText").html(data.message)
                    $("#alertMessageModal").modal();
                }
            }
        });        
    });

    $(document).on("click", ".move-to-vip-picture", function(e) {
        var pic_data = $(this).closest('.pro_pic').attr('rel');
        parent = $(this);

        $.ajax({
            url: base_url + "user/profile/moveToVIPPicture",
            type: 'POST',
            data: {'pic_data': pic_data},
            dataType:'json',
            success: function(data) {
                if(data.status == true) {
                    parent.closest('.pro_pic').fadeOut(300, function() { 
                        var obj = parent.closest('.pro_pic').clone().appendTo( "#vip_picture_list");
                        $(this).remove();
                        obj.css('display', 'inline-block');
                        obj.find('.move-to-vip-picture').remove();
                        obj.find('.list-group').prepend('<a href="javascript:void(0);" class="list-group-item move-to-profile-picture">move-to profile picture</a>');
                    });
                } else {
                    $("#alertMessageText").html(data.message)
                    $("#alertMessageModal").modal();
                }
            }
        });
    });

    $(document).on("click", ".move-to-profile-picture", function(e) {
        var pic_data = $(this).closest('.pro_pic').attr('rel');
        parent = $(this);

        $.ajax({
            url: base_url + "user/profile/moveToProfilePicture",
            type: 'POST',
            data: {'pic_data': pic_data},
            dataType:'json',
            success: function(data) {
                if(data.status == true) {
                  parent.closest('.pro_pic').fadeOut(300, function() { 
                      var obj = parent.closest('.pro_pic').clone().appendTo( "#profile_picture_list");
                      $(this).remove();
                      obj.css('display', 'inline-block');
                      obj.find('.move-to-profile-picture').remove();
                      obj.find('.list-group').prepend('<a href="javascript:void(0);" class="list-group-item move-to-vip-picture">move to vip gallary</a>');
                  });
                } else {
                    $("#alertMessageText").html(data.message)
                    $("#alertMessageModal").modal();
                }
            }
        });
    });

    $(document).on("click", ".clear-my-picture", function(e) {
        var parent = $(this);
        var pic_data = $(parent).closest('.pro_pic').attr('rel');

        $.ajax({
            url: base_url + "user/profile/clearMyPicture",
            type: 'POST',
            data: {'pic_data': pic_data},
            dataType:'json',
            success: function(data) {
                if(data.status == true) {
                    if(data.setAvatar == true) {
                        $(".userpic img").attr('src', data.avatar);
                        $('#imagePreview').css('background-image', 'url('+ data.avatar +')');
                    }
                    parent.closest('.pro_pic').fadeOut(300, function() { 
                      $(this).remove();
                    });
                } else {
                    $("#alertMessageText").html(data.message)
                    $("#alertMessageModal").modal();
                }
            }
        });
    });    

    /* Manage Profile */
    $(document).on("click", "#btn-change-email", function(e) {
        var oldemail = $("#oldEmail").val();
        var newemail = $("#newEmail").val();
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var contn = true;

        if(oldemail != '' && newemail != '') {
            if(!oldemail.match(mailformat)) {
                $("#alertMessageText").html(please_enter_valid_email);
                $("#alertMessageModal").modal();                
                contn = false;
                return;
            }

            if(!newemail.match(mailformat)) {
                $("#alertMessageText").html(please_enter_valid_email);
                $("#alertMessageModal").modal();
                contn = false;
                return;
            }

            if(contn == true) {
                $.ajax({
                    url: base_url + "user/profile/changeEmail",
                    type: 'POST',
                    data: {'oldemail': oldemail, 'newemail':newemail},
                    dataType:'json',
                    success: function(data) {
                        if(data.status == true) {
                            $("#oldEmail").val('');
                            $("#newEmail").val('');                            
                            $("#alertMessageText").html(data.message)
                            $("#alertMessageModal").modal();
                        } else {
                            $("#alertMessageText").html(data.message)
                            $("#alertMessageModal").modal();
                        }
                    }
                });
            }
        } else {
            $("#alertMessageText").html(please_correct_your_information);
            $("#alertMessageModal").modal();
        }
    });    

    /* Change Password */
    $(document).on("click", "#btn-change-password", function(e) {
        var oldPwd = $("#oldPwd").val();
        var newPwd = $("#newPwd").val();
        var rptnewPwd = $("#rptnewPwd").val();
        var contn = true;

        if(oldPwd != '' && newPwd != '' && rptnewPwd != '') {
            if(newPwd != rptnewPwd) {
                $("#alertMessageText").html(password_mismatch);
                $("#alertMessageModal").modal();
                contn = false;
                return;
            }

            if(contn == true) {
                $.ajax({
                    url: base_url + "user/profile/changePassword",
                    type: 'POST',
                    data: {'oldPwd': oldPwd, 'newPwd':newPwd, 'rptnewPwd':rptnewPwd},
                    dataType:'json',
                    success: function(data) {
                        if(data.status == true) {
                            $("#oldPwd").val('');
                            $("#newPwd").val('');
                            $("#rptnewPwd").val('');
                            $("#alertMessageText").html(data.message)
                            $("#alertMessageModal").modal();
                        } else {
                            $("#alertMessageText").html(data.message)
                            $("#alertMessageModal").modal();
                        }
                    }
                });
            }
        } else {
            $("#alertMessageText").html(please_correct_your_information);
            $("#alertMessageModal").modal();
        }
    });    


    /* Chat Online Switcher for VIP Memebrs */
    $(document).on("click", "#switch1", function(e) {
        var switcher_value = 'offline';
        if($('#switch1:checked').val() != undefined) {
            switcher_value = 'online';
        }

        $.ajax({
            url: base_url + "user/profile/onlineSwitcher",
            type: 'POST',
            data: {'switcher_value': switcher_value},
            dataType:'json',
            success: function(data) {
                if(data.status == false) {
                    $("#switch1").prop('checked', 'true');
                    $("#alertMessageText").html(data.message)
                    $("#alertMessageModal").modal();
                }
            }
        });
    });

    /* Update user information using Payment Model */
    $(document).on("click", ".btn-save-per-details", function(e) {
        var that = $(this);

        var u_firstname = $("#user_first_name").val();
        var u_lastname = $("#user_lastname").val();
        var u_telephone = $("#user_telephone").val();
        var u_street = $("#user_street").val();
        var u_house_no = $("#user_house_no").val();
        var u_company = $("#user_company").val();
        var valid = true;

        if(u_firstname == '') {
            $('#user_first_name').next('.error').html(please_correct_your_information);
            valid = false;
        } else {
            $('#user_first_name').next('.error').html('');
        }

        if(u_lastname == '') {
            $('#user_lastname').next('.error').html(please_correct_your_information);
            valid = false;
        } else {
            $('#user_lastname').next('.error').html('');
        }

        if(u_telephone == '') {
            $('#user_telephone').next('.error').html(please_correct_your_information);
            valid = false;
        } else {
            $('#user_telephone').next('.error').html('');
        }

        if(valid == true) {
            // Update user information
            $.ajax({
                url: base_url + "user/profile/updateProfileInfo",
                type: 'POST',
                data: {'first_name':u_firstname, 'last_name':u_lastname, 'telephone':u_telephone, 'street':u_street, 'house_no':u_house_no, 'company':u_company },
                success: function(data) {               
                    if(data.status == true) {
                        that.css('display', 'none');                        
                        $("#user-personal-infomation").css('display', 'none');
                        $("#payment-box").css('display', 'block');
                    } else if(data.errorCode == 1) {
                        $("#alertMessageText").html(data.message)
                        $("#alertMessageModal").modal();                        
                    } else {
                        that.css('display', 'none');
                        $("#user-personal-infomation").css('display', 'none');
                        $("#payment-box").css('display', 'block');                        
                    }
                }
            });
        }

    });

    /* Buy Diamonds Model */
    $(document).on("click", ".btn-buy-diamond-model", function(e) {
        var params = $(this).attr('data-id');
        var params = params.split(',');

        $("#diamond_package_id").val(params[0]);
        $("#total_buy_diamonds").html(params[1]);
        $("#total_buy_amount").html(params[2]);

        $("#diamondChkout").modal();
    });

    /* Buy VIP using Diamonds Model */
    $(document).on("click", ".btn-buy-vip-diamond-model", function(e) {
        var params = $(this).attr('data-id');
        var params = params.split(',');

        $("#vip_diamond_package_id").val(params[0]);
        $("#vip_diamond_package_months").html(params[1]);
        $("#vip_package_diamonds").html(params[2]);

        $("#vipDiamondChkout").modal();
    });

});

function loadHomePageUsers(page_no) {

    if($("#profile_view").html() != undefined) {

        $.ajax({
            type: 'post',
            url: base_url + "user/home/getHomeUsers",
            data: {'page_no': page_no},
            success: function(response) 
            {
                var home_users = '';
                if(response.errorCode == 0) {
                    for(i=0; i < response.data.length; i++) {
                        if($('#img_' + response.data[i].user_id).html() == undefined) {
                            home_users = '<div class="col-xs-18 col-sm-6 col-md-3 col-xs-6 ';

                            if(response.data[i].is_online == true) {
                                home_users += 'isOnineNow';
                            }
                            //target="_blank"
                            home_users += '">\n\
                                <div class="profile_thumbnail profile_data" rel="'+ response.data[i].user_id_encrypted +'">\n\
                                <a  id="img_'+ response.data[i].user_id +'" href="' + base_url + 'user/profile/view?query=' + encodeURIComponent(response.data[i].user_id_encrypted) + '" class="profile_a">';
                                if(response.data[i].is_online == true) {
                                    home_users += '<span class="onoffStatusSpn os">' + ln_online_str + '</span>';
                                }
                                if(response.data[i].is_new == true) {
                                    home_users += '<span class="newuser-icon">' + ln_new_str + '</span>';
                                }
                                home_users += '<img src="' + base_url + response.data[i].user_active_photo_thumb + '" alt="">\n\
                                    <div class="inner_div imghvr-shutter-out-horiz">\n\
                                        <h4>' + ln_view_profile_str + '</h4>\n\
                                    </div>\n\
                                </a>\n\
                                <div class="caption">\n\
                                    <div class="row">\n\
                                        <div class="col-md-12 col-sm-12 col-xs-12">\n\
                                            <h4 class="pro_name">\n\
                                                ' + response.data[i].user_access_name + ' | \n\
                                                ' + response.data[i].user_age + '\n\
                                            </h4>\n\
                                        </div>\n\
                                        <div class="col-md-12 col-sm-12 col-xs-12">\n\
                                            <h4 class="loc_km">\n\
                                                <span class="km">\n\
                                                    ' + response.data[i].distance + 'km - \n\
                                                    <span class="city">\n\
                                                        ' + response.data[i].user_city + '\n\
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
                                                    if(response.data[i].is_kissed == true) {
                                                        home_users += 'active-icon-red';
                                                    }
                                                    home_users += '"></i>\n\
                                                    <i class="flaticon-like ';
                                                    if(response.data[i].is_favorite == true) {
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

                            if(response.data[i].user_is_vip == 'yes') {
                                home_users += '<img src="'+ base_url + 'images/vip_icon.png" class="vip_icon" alt="">';
                            }

                            home_users += '</div>\n\
                        </div>';
                        
                            if(response.data[i].is_online == true) {

                                if($('#profile_view').find('.isOnineNow').last().html() != undefined) {
                                    $(home_users).insertAfter($('#profile_view').find('.isOnineNow').last());
                                } else {
                                    $("#profile_view").prepend(home_users);
                                }
                                
                                $("body").animate({scrollTop: 0}, 500);
                            } else {
                                $("#profile_view").append(home_users);
                            }
                        }
                    }
                } else {
                    stopHomeUserLoading = true;
                }

                lockLoadHomeUserAPI = false;
            }
        });
    }
}
