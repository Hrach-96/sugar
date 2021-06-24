$(document).ready(function() {
	$(".btn-continue").click(function(e) {
		e.preventDefault();
		
		$(".form-reg-part-1").hide();
		$(".form-reg-part-2").fadeIn();
		
		$(".lead").html(almost_there_str);
		$(".leadmob").html(almost_there_str);
		
		$(".titlemob").hide();
		
		// Create the cookies for the gender & interested_in
		$.cookie('bepoke_gender', $(".form_gender").val());
		$.cookie('bepoke_interested_in', $(".form_looking_for").val());
		$("#user-carousel").hide();
		$(".second-part-titles").css("marginTop", "50px");
	});
	
	$(".footer_links a").click(function(e) {
		e.preventDefault();
		
		var page_id = $(this).attr("data-id");
		
		$("#welcome_page_modal").modal("show");
		$("#welcome_page_modal .modal-body").html('<div style="text-align:center;"><i class="fa fa-circle-o-notch fa-spin modal-icon"></i></div>');
		
		$.ajax({
			url: base_url + "site/get_welcome_page",
			type: 'POST',
			data: {page_id: page_id},
			success: function(data) {
				$("#welcome_page_modal .modal-title").html(data.page.title);
				$("#welcome_page_modal .modal-body").html(data.page.content);
			}
		});
	});
	
	$("#user-carousel").owlCarousel({
 
     	 autoPlay: 3000, //Set AutoPlay to 3 seconds
	 	 lazyLoad:true, 
	      items : 4,
	      autoHeight:true,
	      itemsDesktop : [800,3],
	      itemsDesktopSmall : [979,3]
	 
	  });
	
	$(document).on("click", ".btn-register-mob", function(e) {
		e.preventDefault();
		
		var current_width = $(window).width();
		
		if( current_width <= 510 ) {
			$(this).html("Sign In");
			$(this).removeClass("btn-register-mob").addClass("btn-login");
			
			$(".form-reg-part-1").fadeIn();
			$(".form_reg").hide();
		} else {
			$("#login_modal").modal("show");
		}
	});
	
	$(document).on("click", ".btn-login", function(e) {
		e.preventDefault();
		
		var current_width = $(window).width();
		
		if( current_width <= 510 ) {
			$(this).html("Register");
			$(this).removeClass("btn-login").addClass("btn-register-mob");
			
			$(".form-reg-part-1").hide();
			$(".form-reg-part-2").hide();
			$(".form_reg").fadeIn();
		} else {
			$("#login_modal").modal("show");
		}
	});

	$(document).on("click", "#registerModal input[name=serious_relationship_interested]:checked", function(e) {
		$("#registerModal input[name=user_contact_request]").attr("checked", false);
	});

	$(document).on("click", "#registerModal input[name=user_contact_request]:checked", function(e) {
		$("#registerModal input[name=serious_relationship_interested]").attr("checked", false);
	});

	// Validations for register page
   	$('#registerModal .next').on('click', function() {
   		var curClass = $(this).closest('.none').attr('class');
   		curClass = curClass.split(' ');
   		var currStep = curClass[1];   		

		if(currStep == 'first') {
			var i_am_a = $("#registerModal input[name=i_am_a]:checked").val();
			if(i_am_a == undefined) {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_select_correct_option+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			} else {
				$(this).closest('.none').find('.form-error').html('').fadeOut();
			}
		}

		if(currStep == 'second') {
			var i_am_inerested_in = $("#registerModal input[name=i_am_inerested_in]:checked").val();
			if(i_am_inerested_in == undefined) {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_select_correct_option+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			} else {
				$(this).closest('.none').find('.form-error').html('').fadeOut();
			}
		}

		if(currStep == 'third') {
			var valid_email = $("#registerModal input[name=user_email]").val();
			var captcha_text = $("#registerModal input[name=captcha_text]").val();
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

			if(captcha_text == '') {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_image_text+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			}

			if(valid_email == '' || !valid_email.match(mailformat)) {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_valid_email+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			} else {
				$(this).closest('.none').find('.form-error').html('').fadeOut();
			}
		}

		if(currStep == 'fourth') {
			//var strongPassword  = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
			var strongPassword  = /^(?=.*[0-9])[a-zA-Z0-9!@#$%^&*]{8,16}$/;
			var username = $("#registerModal input[name=user_username]").val();
			var password = $("#registerModal input[name=user_password]").val();			

			if(username == '' || password == '') {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_username_and_password+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			}

			if(!password.match(strongPassword)) {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_strong_password+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;				
			} else {
				$(this).closest('.none').find('.form-error').html('').fadeOut();
			}
		}

		if(currStep == 'fifth') {
			var date_of_birth = $("#registerModal select[name=dateofbirth_year]").val() + '-' + $("#registerModal select[name=dateofbirth_month]").val() + '-'+ $("#registerModal select[name=dateofbirth_day]").val();
			var max_date_for_reg = $("#registerModal input[name=min_date_for_reg]").val();
			var d1 = new Date(date_of_birth);
			var d2 = new Date(max_date_for_reg);

			if(d1.getTime() > d2.getTime()) {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+no_legal_age+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			} else {
			 	$(this).closest('.none').find('.form-error').html('').fadeOut();
			}
		}

		if(currStep == 'six') {
			var i_am_a = $("#registerModal input[name=i_am_a]:checked").val();
			var user_arangement = $("#registerModal input[name=user_arangement]:checked").val();

			if(i_am_a == 'female') {			
				if(user_arangement == undefined) {
					var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_select_correct_option+'</div>';
					$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
					return;
				} else {
					$(this).closest('.none').find('.form-error').html('').fadeOut();
				}
			}
		}

		if(currStep == 'seven') {
			var serious_relationship = $("#registerModal input[name=serious_relationship_interested]:checked").val();
			if(serious_relationship == undefined) {
				var user_contact_request = $("#registerModal input[name=user_contact_request]:checked").val();

				if(user_contact_request == undefined) {
					var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_select_correct_option+'</div>';
					$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
					return;
				} else {
					$(this).closest('.none').find('.form-error').html('').fadeOut();
				}
			}
		}

		if(currStep == 'eight') {
			var user_postcode = $("#registerModal input[name=user_postcode]").val();
			var user_location = $("#registerModal input[name=user_location]").val();			
			var isNumberPat = /^[0-9]*$/;
			//var isNumberPat = /[1-4]/g;

			if(user_postcode == '') {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_your_postcode+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			}

			if(!user_postcode.match(isNumberPat)) {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_valid_postcode+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			}

			if(user_location == '') {
				var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_your_location+'</div>';
				$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
				return;
			} else {
				$(this).closest('.none').find('.form-error').html('').fadeOut();
			}			
		}

		if(currStep == 'nine') {
			var user_size = $("#registerModal input[name=user_size]").val();
			var isNumberPat = /^[0-9]*$/;

			if(user_size != '') {
				if(!user_size.match(isNumberPat)) {
					var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_valid_size+'</div>';
					$(this).closest('.none').find('.form-error').html(error_msg).fadeIn();
					return;
				} else {
					$(this).closest('.none').find('.form-error').html('').fadeOut();
				}
			}
		}

		$('.active').fadeOut('slow', function() {
	      	// this gets called when the fade out finishes
	      	var i_am_a = $("#registerModal input[name=i_am_a]:checked").val();
			
	      	//if(($(this).hasClass('nineteen') == true || $(this).hasClass('fifth') == true) && i_am_a == 'male') {
	      	if(( $(this).hasClass('nineteen') == true && i_am_a == 'male' )  || $(this).hasClass('fifth') == true ) {
		      	$(this).removeClass('active').next().next().fadeIn('slow', function() {
		        	//this gets called when the fade in finishes
		        	$(this).addClass('active');	
		      	});
	      	} else {
		      	$(this).removeClass('active').next().fadeIn('slow', function() {
		        	//this gets called when the fade in finishes
		        	$(this).addClass('active');	
					//$('.none').next().hasClass('.active');
		      	});
	      	}
	    });
  	});

	$("#registerModal button.close").click(function() {
    	$("#registerModal div").removeClass('active');
     	$("#registerModal .none").hide();
   		$("#registrationForm .first").addClass('active');
   		//$("#registrationForm .fifth").addClass('active');
   	});

	// Username already taken or not checking
	$(document).on("change", "#user_username", function(e) {
		e.preventDefault();
		var username = $("#user_username").val();
		var that = $(this);
		
		$.ajax({
			url: base_url + "auth/checkUsernameExists",
			type: 'POST',
			data: {'username' : username},
			success: function(data) {
				$(that).closest('.none').find('.form-error').html('').fadeOut();
				if(data.error == 1) {
					var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';
					$(that).closest('.none').find('.form-error').html(error_msg).fadeIn();
					$('#btn_next_valid_username_step').hide();
				} else {					
					$('#btn_next_valid_username_step').show();
				}
			}
		});
	});	

	// Email already taken or not checking
	$(document).on("change", "#user_email", function(e) {
		e.preventDefault();
		var email = $("#user_email").val();
		var that = $(this);
		
		$.ajax({
			url: base_url + "auth/checkEmailExists",
			type: 'POST',
			data: {'email' : email},
			success: function(data) {
				$(that).closest('.none').find('.form-error').html('').fadeOut();
				if(data.error == 1) {
					var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';
					$(that).closest('.none').find('.form-error').html(error_msg).fadeIn();
					$('#btn_next_valid_email_step').hide();
				} else {
					$('#btn_next_valid_email_step').show();
				}
			}
		});
	});	

	// Email already taken or not checking
	$(document).on("change", "#captcha_text", function(e) {
		e.preventDefault();
		var captcha_text = $("#captcha_text").val();
		var that = $(this);
		
		$.ajax({
			url: base_url + "auth/verifyCaptcha",
			type: 'POST',
			data: {'captcha_text' : captcha_text},
			success: function(data) {
				$(that).closest('.none').find('.form-error').html('').fadeOut();
				if(data.status == false) {
					var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';
					$(that).closest('.none').find('.form-error').html(error_msg).fadeIn();
					$('#btn_next_valid_email_step').hide();
				} else if(data.status == true) {
					$('#btn_next_valid_email_step').show();
				}
			}
		});
	});		

	$("#add-user-sport").click(function() {
        var prev_selected_sports = $("#registerModal input[name='user_sports_selected[]']").val();
        var add_item = true;
        var itm_val = $("#registerModal select[name=user_sports] option:selected").val();
        var itm_text = $("#registerModal select[name=user_sports] option:selected").text();

        if(prev_selected_sports != undefined) {
            $("#registerModal input[name='user_sports_selected[]']").each(function(){
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

	$("#add-user-interest").click(function() {
        var prev_selected_interests = $("#registerModal input[name='user_interests_selected[]']").val();
        var add_item = true;
        var itm_val = $("#registerModal select[name=user_interests] option:selected").val();
        var itm_text = $("#registerModal select[name=user_interests] option:selected").text();

        if(prev_selected_interests != undefined) {
            $("#registerModal input[name='user_interests_selected[]']").each(function(){
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

    $("#add-user-language").click(function() {
        var prev_selected_languages = $("#registerModal input[name='user_languages_selected[]']").val();
        var add_item = true;
        var itm_val = $("#registerModal select[name=user_languages] option:selected").val();
        var itm_text = $("#registerModal select[name=user_languages] option:selected").text();

        if(prev_selected_languages != undefined) {
            $("#registerModal input[name='user_languages_selected[]']").each(function(){
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

	$(".btn-register").click(function(e) {
		e.preventDefault();
		var that = $(this);

		var legal_age = $("#registerModal input[name=legal_age_terms_conds]:checked").val();
		if(legal_age == undefined) {
			var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_accept_terms_and_conditions+'</div>';
			that.closest('.none').find('.form-error').html(error_msg).fadeIn();
			return;
		} else {
			that.closest('.none').find('.form-error').html('').fadeOut();
		}

		var i_am_a = $("#registerModal input[name=i_am_a]:checked").val();
		var i_am_inerested_in = $("#registerModal input[name=i_am_inerested_in]:checked").val();
		var user_email = $("#registerModal input[name=user_email]").val();
		var captcha_text = $("#registerModal input[name=captcha_text]").val();
		var username = $("#registerModal input[name=user_username]").val();
		var password = $("#registerModal input[name=user_password]").val();
		var date_of_birth = $("#registerModal select[name=dateofbirth_year]").val() + '-' + $("#registerModal select[name=dateofbirth_month]").val() + '-'+ $("#registerModal select[name=dateofbirth_day]").val();
		var serious_relationship = $("#registerModal input[name=serious_relationship_interested]:checked").val();		
		var user_postcode = $("#registerModal input[name=user_postcode]").val();
		var user_location = $("#registerModal input[name=user_location]").val();
		var user_country = $("#registerModal input[name=user_country]").val();
		var user_figure = $("#registerModal select[name=user_figure]").val();
		var user_size = $("#registerModal input[name=user_size]").val();

		var user_hair_color = $("#registerModal select[name=user_hair_color]").val();
		var user_eye_color = $("#registerModal select[name=user_eye_color]").val();
		var user_ethnicity = $("#registerModal select[name=user_ethnicity]").val();
		var user_job = $("#registerModal select[name=user_job]").val();
		var user_is_smoker = $("#registerModal input[name=user_is_smoker]:checked").val();
		var user_has_child = $("#registerModal input[name=user_has_child]:checked").val();

        var user_arangement_arr = [];
        $.each($("#registerModal input[name=user_arangement]:checked"), function() {
        	user_arangement_arr.push($(this).val());
        });
        var user_arangement = user_arangement_arr.join(',');

		var user_sports = [];
        $("#registerModal input[name='user_sports_selected[]']").each(function(){
            user_sports.push($(this).val());
        });
		var user_interests = [];
        $("#registerModal input[name='user_interests_selected[]']").each(function(){
            user_interests.push($(this).val());
        });        
		var user_languages = [];
        $("#registerModal input[name='user_languages_selected[]']").each(function(){
            user_languages.push($(this).val());
        });

		var my_description = $("#registerModal textarea[name=my_description]").val();
		var how_can_man_impress_you = $("#registerModal textarea[name=how_can_man_impress_you]").val();

        var user_contact_request_arr = [];
        $.each($("#registerModal input[name=user_contact_request]:checked"), function() {
        	user_contact_request_arr.push($(this).val());
        });
        var user_contact_request = user_contact_request_arr.join(',');

		that.addClass("disabled");
		that.html('<i class="fa fa-circle-o-notch fa-spin"></i>');

	    var upFileInput = document.getElementById('imageUpload');
	    var img_file = upFileInput.files[0];
	    var formData = new FormData();
	    if(img_file != undefined)
	    	formData.append('profile_pic', img_file);

	    formData.append('user_gender', i_am_a);
	    formData.append('user_inerested_in', i_am_inerested_in);
	    formData.append('user_email', user_email);
	    formData.append('captcha_text', captcha_text);	    
	    formData.append('username', username);
	    formData.append('password', password);
	    formData.append('date_of_birth', date_of_birth);
	    formData.append('user_arangement', user_arangement);
	    formData.append('serious_relationship', serious_relationship);
	    formData.append('user_contact_request', user_contact_request);
	    formData.append('user_postcode', user_postcode);
	    formData.append('user_location', user_location);
	    formData.append('user_country', user_country);
	    formData.append('user_figure', user_figure);
	    formData.append('user_size', user_size);
	    formData.append('user_hair_color', user_hair_color);
	    formData.append('user_eye_color', user_eye_color);
	    formData.append('user_ethnicity', user_ethnicity);
	    formData.append('user_job', user_job);
	    formData.append('user_is_smoker', user_is_smoker);
	    formData.append('user_has_child', user_has_child);
	    formData.append('user_sports', user_sports);
	    formData.append('user_interests', user_interests);
	    formData.append('how_can_man_impress_you', how_can_man_impress_you);
	    formData.append('user_languages', user_languages);
	    formData.append('my_description', my_description);
	    formData.append('user_latitude', user_latitude);
	    formData.append('user_longitude', user_longitude);

		$.ajax({
			url: base_url + "auth/register",
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,			
			success: function(data) {
				that.removeClass("disabled");
			
				if(data.error == 1) {
					that.html(register_str);

					// write validations error code here if any more
					if(data.error_array.user_email != undefined) {
						// Email already exists validations
    					$("#registerModal div").removeClass('active');
     					$("#registerModal .none").hide();
   						$("#registrationForm .third").addClass('active');

						var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + data.error_array.user_email + '</div>';
						$("#registrationForm .third").find('.form-error').html(error_msg).fadeIn();
					}
					if(data.error_array.username != undefined) {
						// Username already exists validations
    					$("#registerModal div").removeClass('active');
     					$("#registerModal .none").hide();
   						$("#registrationForm .fourth").addClass('active');

						var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + data.error_array.username + '</div>';
						$("#registrationForm .fourth").find('.form-error').html(error_msg).fadeIn();
					}
					if(data.error_array.captcha_text != undefined) {
						// Incorrect captcha validations
    					$("#registerModal div").removeClass('active');
     					$("#registerModal .none").hide();
   						$("#registrationForm .third").addClass('active');
   						$("#captcha_image_url").attr('src', data.captcha_image_url);

						var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + data.error_array.captcha_text + '</div>';
						$("#registrationForm .third").find('.form-error').html(error_msg).fadeIn();
					}					
				} else if(data.error == 2) {					
					that.html(register_str);
				} else if(data.error == 0) {
					that.html('ERROR');
					setTimeout(function() {
				    	$("#registerModal").modal('hide');
						$("#freeCreditsModal").modal("show");
						//window.location = base_url + "home";
					}, 1200);
					
					that.prop("disabled", true);
					that.html('<i class="fa fa-check"></i> ' + yeah_str);
				}
			}
		});
	});
	
	$(".btn-login-ok-mob").click(function(e) {
		e.preventDefault();
		
		var username = $("form#loginmob #logusernamemob").val();
		var password = $("form#loginmob #logpasswordmob").val();
		
		var that = $(this);
		that.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
		
		$.ajax({
			url: base_url + "auth/login",
			type: 'POST',
			data: {username : username, password : password},
			success: function(data) {
				$("#logusernamemob").closest(".form-group").removeClass("has-error");
				$("#logpasswordmob").closest(".form-group").removeClass("has-error");
				$(".error-login").hide();
			
				if(data.error == 999) {
					$("#logusernamemob").closest(".form-group").addClass("has-error");
					$("#logpasswordmob").closest(".form-group").addClass("has-error");
					$(".error-login").html("<div class='refreshLogin'><i class='fa fa-times-circle'></i></div>" + data.status).fadeIn();
					
					that.html(sign_in_str);
				} else if(data.error == 998) {
					$("#passwordregmob").closest(".form-group").addClass("has-error");
					$(".error-login").html("<div class='refreshLogin'><i class='fa fa-times-circle'></i></div>" + data.status).fadeIn();
					
					that.html(sign_in_str);
				} else {	
					$(".error-login").removeClass("alert-danger").addClass("alert-success").html("<div class='refreshLogin'><i class='fa fa-check-square'></i></div><strong>" + data.message + "</strong>").fadeIn();					
					window.location = data.url_redirect;
				}
			}
		});
	});
	
	$("#btn_forgot_password").click(function(e) {
		e.preventDefault();
		
		$("#login_modal").modal("hide");
		$("#forgotPasswordModal").modal("show");
	});
	
	$(".btn-recover-password-ok").click(function(e) {
		e.preventDefault();
		
		var email = $("#forgotpass_email").val();
		if(email == '') {
			var error_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+please_enter_username_or_email+'</div>';
			$('#forgotPasswordModal').find('.form-error').html(error_msg).fadeIn();
			return;
		} else {
			$('#forgotPasswordModal').find('.form-error').html('').fadeOut();
		}
				
		var that = $(this);
		that.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
		that.prop("disabled", true);
		
		$.ajax({
			url: base_url + "auth/recover_password",
			type: 'POST',
			data: {email: email},
			success: function(data) {		
				if(data.error == 999) {
					var success_msg = '<div class="alert-dlx alert-danger-dlx fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';					
					$('#forgotPasswordModal').find('.form-error').html(success_msg).fadeIn();

					that.html(send_str);
					that.prop("disabled", false);
				} else if(data.error == 998) {
					var success_msg = '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';					
					$('#forgotPasswordModal').find('.form-error').html(success_msg).fadeIn();

					that.html(send_str);
					that.prop("disabled", false);
				} else {
					var success_msg = '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';					
					$('#forgotPasswordModal').find('.form-error').html(success_msg).fadeIn();
					
					setTimeout(function() {
						window.location = data.url_redirect;
					}, 3000);
				}
			}
		});
	});
	
	$(".btn-login-ok").click(function(e) {
		e.preventDefault();
		
		var username = $("form#login #logusername").val();
		var password = $("form#login #logpassword").val();
		
		var that = $(this);
		that.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
		
		$.ajax({
			url: base_url + "auth/login",
			type: 'POST',
			data: {username : username, password : password},
			success: function(data) {
				$("#logusername").closest(".form-group").removeClass("has-error");
				$("#logpassword").closest(".form-group").removeClass("has-error");
				$(".error-login").hide();
			
				if(data.error == 999) {
					$("#logusername").closest(".form-group").addClass("has-error");
					$("#logpassword").closest(".form-group").addClass("has-error");
					$(".error-login").html("<div class='refreshLogin'><i class='fa fa-times-circle'></i></div>" + data.message).fadeIn();
					
					that.html("<span class='cont_span'>"+sign_in_str+"</span>");
				} else if(data.error == 998) {
					$("#passwordreg").closest(".form-group").addClass("has-error");
					$(".error-login").html("<div class='refreshLogin'><i class='fa fa-times-circle'></i></div>" + data.message).fadeIn();
					
					that.html("<span class='cont_span'>"+sign_in_str+"</span>");
				} else {	
					$(".error-login").removeClass("alert-danger").addClass("alert-success").html("<div class='refreshLogin'><i class='fa fa-check-square'></i></div><strong>" + data.message + "</strong>").fadeIn();
					
					setTimeout(function() {
						window.location = data.url_redirect;
					}, 3000);
				}
			}
		});
	});
	
});