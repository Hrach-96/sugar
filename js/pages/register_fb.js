$(document).ready(function() {

	$(".btn-register-fb").click(function(e) {
		e.preventDefault();
		var that = $(this);
		that.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
		var username = $("#fbRegister input[name=user_username]").val();
		var date_of_birth = $("#fbRegister select[name=dateofbirth_year]").val() + '-' + $("#fbRegister select[name=dateofbirth_month]").val() + '-'+ $("#fbRegister select[name=dateofbirth_day]").val();
		var user_postcode = $("#fbRegister input[name=user_postcode]").val();
		var user_location = $("#fbRegister input[name=user_location]").val();
		var user_country = $("#fbRegister input[name=user_country]").val();
		var i_am_a = $("#fbRegister input[name=i_am_a]:checked").val();
		var i_am_inerested_in = $("#fbRegister input[name=i_am_inerested_in]:checked").val();
		var user_size = $("#fbRegister input[name=user_size]").val();
		var user_id = $("#fbRegister input[name=user_id]").val();
		var formData = new FormData();
        
        formData.append('user_id', user_id);
        formData.append('user_gender', i_am_a);
	    formData.append('user_inerested_in', i_am_inerested_in);
	    formData.append('username', username);
	    formData.append('date_of_birth', date_of_birth);
	    formData.append('user_postcode', user_postcode);
	    formData.append('user_location', user_location);
	    formData.append('user_country', user_country);
	    formData.append('user_size', user_size);
	    formData.append('user_latitude', user_latitude);
	    formData.append('user_longitude', user_longitude);

		$.ajax({
			url: base_url + "auth/registerViaFacebbok",
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,			
			success: function(data) {
				console.log(data);
				if(data.error == 1){
					if(data.error_array['username'])
					{
						$('#username').css('visibility','visible');
                    }
                    else
                    {
                    	$('#username').css('visibility','hidden');
                    }

                    if(data.error_array['user_postcode'])
                    {
                    	$('#postcode').css('visibility','visible');
                    }
                    else
                    {
                    	$('#postcode').css('visibility','hidden');
                    }

                    if(data.error_array['user_location'])
                    {
                    	$('#location').css('visibility','visible');
                    }
                    else
                    {
                    	$('#location').css('visibility','hidden');
                    }

                    if(data.error_array['user_size'])
                    {
                    	$('#size').css('visibility','visible');
                    }
                    else
                    {
                    	$('#size').css('visibility','hidden');
                    }

                    that.html(data.confirm_and_continue);
					
				}
				else{
						window.location.replace(base_url + "home");
					}
				
			}
		});
	});
});