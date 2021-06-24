$(document).ready(function() {
	$('.thumbnail').nailthumb();	
	
	$(".btn-search").click(function(e) {
		e.preventDefault();
		
		var username = $(".form-username").val();
		
		if(username == "") {
			alert("Please type a username");
		} else {
			$.ajax({
				url: base_url + "admin/search_user",
				type: 'POST',
				data: {username: username},
				success: function(data) {
					if(data.error == 999) {
						alert(data.error_msg);
					} else if(data.error == 998) {
						alert(data.error_msg);
					} else {
						window.location = base_url + "admin/edit_user/" + data.user_id;
					}
				}
			});
		}
	});
	
			$(".btn-delete-user").click(function(e) {
		e.preventDefault();
		
		var user_id = $(this).attr("data-user-id");
		var that = $(this);

		$.ajax({
			url: base_url + "admin/delete_user",
			type: 'POST',
			data: {user_id: user_id},
			success: function(data) {
				if(data.error == 999) {
					alert(data.error_msg);
				} else if(data.error == 500) {
					alert(data.error_msg);
				} else if(data.error == 998) {
					alert(data.error_msg);
				} else {
					window.location = base_url + "admin/manage_users?action=deleted_user"
				}
			}
		});
	});

	
		$(".btn-delete-photo").click(function(e) {
		e.preventDefault();
		
		var button = $(this);

		if(button.hasClass("btn-success") == false && confirm("Are you sure you want to remove this report?")) {
			$.ajax({
				url: base_url + "admin/cancel_report",
				type: 'POST',
				data: {report_id: button.attr("data-id")},
				success: function(data) {
					if(data.error == 999) {
						alert(data.error_msg);
					} else if(data.error == 500) {
						alert(data.error_msg);
					} else if(data.error == 998) {
						alert(data.error_msg);
					} else {
						button.html("<i class='fa fa-check'></i> Report Removed");
						button.addClass("btn-success");
					}
				}
			});
		}
	});
});
	
	
	$(".btn-cancel").click(function(e) {
		e.preventDefault();
		
		var button = $(this);

		if(button.hasClass("btn-success") == false && confirm("Are you sure you want to remove this report?")) {
			$.ajax({
				url: base_url + "admin/cancel_report",
				type: 'POST',
				data: {report_id: button.attr("data-id")},
				success: function(data) {
					if(data.error == 999) {
						alert(data.error_msg);
					} else if(data.error == 500) {
						alert(data.error_msg);
					} else if(data.error == 998) {
						alert(data.error_msg);
					} else {
						button.html("<i class='fa fa-check'></i> Report Removed");
						button.addClass("btn-success");
					}
				}
			});
		}
	});