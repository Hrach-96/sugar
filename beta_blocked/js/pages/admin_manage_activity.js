var percent = 0;

$(document).ready(function() {

	$(".btn-verify-reality-document").click(function(e) {
		e.preventDefault();
		var that = $(this);
			
		var document_status = $(that).attr('data-id');
		var document_id = $(that).closest('tr').attr('data-id');
		
		if(document_status != '' && document_id != '') {
			$.ajax({
				url: base_url + "admin/checks/approve_reality_document",
				type: 'POST',
				data: {'document_status': document_status, 'document_id': document_id},
				success: function(response) {
					if(response.status == true) {						
						if(document_status == 'verified') {
							var strSt = '<span class="badge badge-success">'+ response.data +'</span>';

							var strUsrSt = '<span class="badge badge-success">'+ response.userStatus +'</span>';
							$(that).closest('tr').find('td.userStatus').html(strUsrSt);
						} else {
							var strSt = '<span class="badge badge-danger">'+ response.data +'</span>';
						}
						
						$(that).closest('tr').find('td.documentStatus').html(strSt);
						$(that).closest('tr').find('td.userAction').html('');
					} else {
						var errMsg = '<span class="text-danger">'+response.message+'</span>';
						if(response.errorCode == 1) {
							if(response.requestStatus == 'verified') {
								var strSt = '<span class="badge badge-success">'+ response.requestStatusMsg +'</span>';
							} else {
								var strSt = '<span class="badge badge-danger">'+ response.requestStatusMsg +'</span>';
							}
							$(that).closest('tr').find('td.documentStatus').html(strSt);
						}
						$(that).closest('tr').find('td.userAction').html(errMsg).fadeIn(500);
					}
				}
			});
		}
	});	

	$(".btn-verify-asset-document").click(function(e) {
		e.preventDefault();
		var that = $(this);
			
		var document_status = $(that).attr('data-id');
		var document_id = $(that).closest('tr').attr('data-id');
		
		if(document_status != '' && document_id != '') {
			$.ajax({
				url: base_url + "admin/checks/approve_asset_document",
				type: 'POST',
				data: {'document_status': document_status, 'document_id': document_id},
				success: function(response) {
					if(response.status == true) {						
						if(document_status == 'verified') {
							var strSt = '<span class="badge badge-success">'+ response.data +'</span>';
						} else {
							var strSt = '<span class="badge badge-danger">'+ response.data +'</span>';
						}
						
						$(that).closest('tr').find('td.documentStatus').html(strSt);
						$(that).closest('tr').find('td.userAction').html('');
					} else {
						var errMsg = '<span class="text-danger">'+response.message+'</span>';
						if(response.errorCode == 1) {
							if(response.requestStatus == 'verified') {
								var strSt = '<span class="badge badge-success">'+ response.requestStatusMsg +'</span>';
							} else {
								var strSt = '<span class="badge badge-danger">'+ response.requestStatusMsg +'</span>';
							}
							$(that).closest('tr').find('td.documentStatus').html(strSt);
						}
						$(that).closest('tr').find('td.userAction').html(errMsg).fadeIn(500);
					}
				}
			});
		}
	});

	$(".btn-approve_content").click(function(e) {
		e.preventDefault();
		var that = $(this);
			
		var content_status = $(that).attr('data-id');
		var content_id = $(that).closest('tr').attr('data-id');
		
		if(content_status != '' && content_id != '') {
			$.ajax({
				url: base_url + "admin/approvals/approve_user_content",
				type: 'POST',
				data: {'content_status': content_status, 'content_id': content_id},
				success: function(response) {
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
				url: base_url + "admin/approvals/approve_user_photo",
				type: 'POST',
				data: {'photo_status': photo_status, 'photo_id': photo_id},
				success: function(response) {
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
				}
			});
		}
	});
		

	$("#update-user-rank").click(function(e) {
		e.preventDefault();
		var that = $(this);

     	percent = 0;
     	$('#create-user-rank').attr('disabled', true);
      	showProgressBar();
		$.ajax({
			url: base_url + "admin/users/updateUserRank",
			type: 'GET',
			success: function(response) {
				percent = 100;
				percentage = '100%';
				$("#rank-progress-bar").width(percentage).attr('aria-valuenow', percent).text(percentage);
				if(response.status == true) {
					$('#create-user-rank').removeAttr('disabled');
				}
			}
		});
	});	


});


function showProgressBar() 
{
	percent = percent + 1;
	percentage = percent + '%';	

	if(percent < 100) {
		$("#rank-progress-bar").width(percentage).attr('aria-valuenow', percent).text(percentage);
		setTimeout(showProgressBar, 100);
	}
}
