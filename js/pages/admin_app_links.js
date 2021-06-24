$(document).ready(function () {
	$(".btn-save").click(function (e) {
		e.preventDefault();

		var button = $(this);
		button.html('<i class="fa fa-circle-o-notch fa-spin"></i>');

		var ios = $(".app_ios").val();
		var android = $(".app_android").val();

		$.ajax({
			url: base_url + "admin/save_app_links",
			type: 'POST',
			data: {ios: ios, android: android},
			success: function (data) {
				$(".alert-error-settings").empty();
				if (data.error > 0) {
					$(".alert-error-settings").html(data.error_msg).fadeIn();
					$("html, body").animate({scrollTop: 0}, 1000);
					button.html('<i class="fa fa-check"></i> Save Changes');
				} else {
					window.location = base_url + "admin/app_links?status=ok";
				}
			}
		});
	});
});