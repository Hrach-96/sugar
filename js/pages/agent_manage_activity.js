$(document).ready(function() {

	$(".btn-approve_content").click(function(e) {
		e.preventDefault();
		var that = $(this);
			
		var content_status = $(that).attr('data-id');
		var content_id = $(that).closest('tr').attr('data-id');
		
		if(content_status != '' && content_id != '') {
			$.ajax({
				url: base_url + "agent/approvals/approve_user_content",
				type: 'POST',
				data: {'content_status': content_status, 'content_id': content_id},
				success: function(response) {
					contents_checked++;
					if(response.status == true) {						
						if(content_status == 'approved') {
							var strSt = '<span class="badge badge-success">'+ response.data +'</span>';
						} else {
							var strSt = '<span class="badge badge-danger">'+ response.data +'</span>';
						}
						$(that).closest('tr').find('td.contentStatus').html(strSt);
						$(that).closest('tr').find('td.userAction').html('');
					} else {
						var errMsg = '<span class="text-danger">'+response.message+'</span>';
						if(response.errorCode == 1) {
							if(response.requestStatus == 'approved') {
								var strSt = '<span class="badge badge-success">'+ response.requestStatusMsg +'</span>';
							} else {
								var strSt = '<span class="badge badge-danger">'+ response.requestStatusMsg +'</span>';
							}
							$(that).closest('tr').find('td.contentStatus').html(strSt);
						}
						$(that).closest('tr').find('td.userAction').html(errMsg).fadeIn(500);
					}
					if(contents_checked == total_contents) {
						setTimeout(function() {
							location.reload(true);
						}, 5000);
					}					
				}
			});
		}
	});

	$(".btn-approve-image").click(function(e) {
		e.preventDefault();
		var that = $(this);
			
		var photo_status = $(that).attr('data-id');
		var photo_id = $(that).closest('tr').attr('data-id');
		
		if(photo_status != '' && photo_id != '') {
			$.ajax({
				url: base_url + "agent/approvals/approve_user_photo",
				type: 'POST',
				data: {'photo_status': photo_status, 'photo_id': photo_id},
				success: function(response) {
					images_checked++;

					if(response.status == true) {						
						if(photo_status == 'active') {
							var strSt = '<span class="badge badge-success">'+ response.data +'</span>';
						} else {
							var strSt = '<span class="badge badge-danger">'+ response.data +'</span>';
						}
						$(that).closest('tr').find('td.photoStatus').html(strSt);
						$(that).closest('tr').find('td.userAction').html('');
					} else {
						var errMsg = '<span class="text-danger">'+response.message+'</span>';
						if(response.errorCode == 1) {
							if(response.requestStatus == 'active') {
								var strSt = '<span class="badge badge-success">'+ response.requestStatusMsg +'</span>';
							} else {
								var strSt = '<span class="badge badge-danger">'+ response.requestStatusMsg +'</span>';
							}
							$(that).closest('tr').find('td.photoStatus').html(strSt);
						}
						$(that).closest('tr').find('td.userAction').html(errMsg).fadeIn(500);
					}
					
					if(images_checked == total_images) {
						setTimeout(function() {
							location.reload(true);
						}, 5000);
					}
				}
			});
		}
	});


});

