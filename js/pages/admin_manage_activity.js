var percent = 0;

$(document).ready(function() {
	$(document).on("click",".btn_download_news_current_list",function(){
		var current_list_ids = $(".current_list_ids").val();
		var type_of_file = $(".type_of_file").val();
		setTimeout(function(){
            window.open('news/report?array=' + current_list_ids+'&type=' + type_of_file, '_blank');
        },1500)
	})
	$(document).on("click",".gift_table_custom_class td",function(){
		var checkbox_for_checking = $(this).parent().find(".checkbox_for_checking");
		if($(checkbox_for_checking).prop('checked')){
			$(checkbox_for_checking).prop('checked', false);
        }
        else{
			$(checkbox_for_checking).prop('checked', true);
        }
	})
	$(document).on("click",".btn_cancel_gifts_from_user",function(){
		var user_for_gifts = $("input[name=user_for_gifts_checkbox]:checked");
		if(user_for_gifts.length > 0){
			var choosed_user_array = [];
			for(var i = 0 ; i < user_for_gifts.length ; i++){
				var user_id = $(user_for_gifts[i]).attr('data-user-id');
				var row_id = $(user_for_gifts[i]).attr('data-row-id');
				choosed_user_array.push(row_id);
			}
			$.ajax({
	            type:"post",
				url: base_url + "admin/gift/cancel_gifts_from_user",
	            data:{choosed_user_array:choosed_user_array},
	            success:function(res){
	            	location.reload();
	            }
	        })
		}
	})
	$(document).on("click",".btn_add_gifts_to_user",function(){
		var user_for_gifts = $("input[name=user_for_gifts_checkbox]:checked");
		var vip_gift_value = $('input[name="vip_for_gift"]:checked').val();
		var credit_gift_value = $('input[name="credit_for_gift"]:checked').val();
		var send_gift_allow_user = false;
		var send_gift_allow_gift = false;
		if(user_for_gifts.length > 0){
			send_gift_allow_user = true;
		}
		else{
			alert('Bitte wählen Sie einige Benutzer')
		}
		if(vip_gift_value || credit_gift_value){
			send_gift_allow_gift = true;
		}
		else{
			alert('Bitte wählen Sie einen Geschenktyp (VIP oder Kredit).')
		}
		if(send_gift_allow_user && send_gift_allow_gift){
			var choosed_user_array = [];
			for(var i = 0 ; i < user_for_gifts.length ; i++){
				var user_id = $(user_for_gifts[i]).attr('data-user-id');
				choosed_user_array.push(user_id);
			}
			$.ajax({
	            type:"post",
				url: base_url + "admin/gift/add_gifts_to_user",
	            data:{choosed_user_array:choosed_user_array,vip_gift_value:vip_gift_value,credit_gift_value:credit_gift_value},
	            success:function(res){
	            	location.reload();
	            }
	        })
		}
	})
	$(document).on("change",".switchInput",function(){
		var id = $(this).attr('data-user-id');
        var val;
        if($(this).prop('checked')){
            val = 1
            $(this).parent().parent().css({'background':'0'})
        }
        else{
            $(this).parent().parent().css({'background':'red'})
            val = 0
        }
        $.ajax({
            type:"post",
			url: base_url + "admin/vip/change_manually_vip_for_user",
            data:{id:id,val:val},
            success:function(res){
            }
        })
	})
    $(document).on("click",".btn_for_save_invoice_number",function(){
    	var invoice_number = $(this).parent().find(".next_invoice_number").val();
    	console.log(invoice_number);
    	$.ajax({
			url: base_url + "admin/purchases/update_invoice_number",
			type: 'POST',
			data: {'invoice_number': invoice_number},
			success: function(response) {
			}
		})
    })
    $(document).on("click",".btn_save_add_info_cancel",function(){
    	var column_name = $(this).attr('data-column-name');
    	var row_id = $(this).attr('data-row-id');
    	var val = $(this).parent().find("."+column_name+"_field").val();
    	$.ajax({
			url: base_url + "admin/vip/save_additional_info_for_cancel_vip",
			type: 'POST',
			data: {'column_name': column_name,'val':val,'row_id':row_id},
			success: function(response) {
				console.log(response)
			}
		})
    })
    $(document).on("click",".generate_pdfs_for_all_bill_of_user",function(){
        var purchased_credit_id = $(this).attr('buy-purchased-credit-id');        
        $.ajax({
			url: base_url + "admin/credit/get_all_credit_bill_for_user",
			type: 'POST',
			data: {'purchased_credit_id': purchased_credit_id},
			success: function(response) {
				if(response){

					$(".content_all_credits_pdf").html('')
					response = JSON.parse(response);
					user_access_name = '';
					var html_table = '<table class="table_all_bills_of_user">';
					html_table+= '<tr>';
					html_table+= '<th>#</th>';
					html_table+= '<th>Kostenlose Credits</th>';
					html_table+= '<th>Preis</th>';
					html_table+= '<th>Date</th>';
					html_table+= '<th>Rechnung Nr.</th>';
					html_table+= '<th>Action</th>';
					html_table+= '</tr>';
					for(var i = 0 ; i < response.length ; i++){
						var start = new Date(response[i].buy_credit_date);
					    var end   = new Date("2021-03-17");
					    var diff  = new Date(end - start);
					    var days  = Math.ceil(diff/1000/60/60/24);
					    var currency = 'Euro';
					    if(response[i].currency == '' || response[i].currency == null){
					    	if(days < 1){
						        if(response[i].user_country == 'United Kingdom'){
						        	currency = 'GBP';
						        }
						        else if(response[i].user_country == 'Switzerland' || response[i].user_country == 'Schweiz'){
						        	currency = 'CHF';
						        }
					    	}
					    }
				    	else{
				    		currency = response[i].currency;
				    	}
						html_table+= '<tr>';
							html_table+= '<td>';
								html_table+= i + 1;
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= response[i].credit_package_name;
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= currency + ' ' + response[i].credit_package_amount;
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= response[i].buy_credit_date;
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= "<input data-credit-id='" + response[i].buy_credit_id + "' class='form-control invoice_number_value' style='float:left;width:85px' type='number' value='" + response[i].invoice_number + "' placeholder='Rechnung Nr.'>";
								html_table+= "<button class='btn btn-primary btn_savecredit_invoice'>Save</button>";
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= '<a target="_blank" href="/admin/purchases/invoiceCredit/' + response[i].buy_credit_id + '/credit_purchase.pdf"><i class="fa fa-file-pdf-o fa-2x pdf_icon_style_download"></i></a>';
							html_table+= '</td>';
						html_table+= '</tr>';
						user_access_name = response[i].user_access_name;
					}
					$(".content_all_credits_pdf").append(html_table)
					$(".user_name_all_bill").html(user_access_name)
				}
			}
		})
    })
    $(document).on("click",".btn_savecredit_invoice",function(){
    	var invoice_number_value = $(this).parent().find(".invoice_number_value");
    	var value = $(invoice_number_value).val();
    	var credit_id = $(invoice_number_value).attr('data-credit-id');
    	 $.ajax({
			url: base_url + "admin/credit/update_invoice_number_for_credit",
			type: 'POST',
			data: {'value': value,credit_id:credit_id},
			success: function(response) {}
    	})
    })
    $(document).on("click",".btn_savevip_invoice",function(){
    	var invoice_number_value = $(this).parent().find(".invoice_number_value");
    	var value = $(invoice_number_value).val();
    	var vip_id = $(invoice_number_value).attr('data-vip-id');
    	 $.ajax({
			url: base_url + "admin/vip/update_invoice_number_for_vip",
			type: 'POST',
			data: {'value': value,vip_id:vip_id},
			success: function(response) {}
    	})
    })
    $(document).on("click",".generate_pdfs_for_all_vip_bill_of_user",function(){
        var purchased_vip_id = $(this).attr('buy-purchased-vip-id');
        $.ajax({
			url: base_url + "admin/vip/get_all_vip_bill_for_user",
			type: 'POST',
			data: {'purchased_vip_id': purchased_vip_id},
			success: function(response) {
				if(response){
					$(".content_all_vips_pdf").html('')
					response = JSON.parse(response);
					user_access_name = '';
					var html_table = '<table class="table_all_bills_of_user">';
					html_table+= '<tr>';
					html_table+= '<th>#</th>';
					html_table+= '<th>Paketname</th>';
					html_table+= '<th>Preis</th>';
					html_table+= '<th>Date</th>';
					html_table+= '<th>Info</th>';
					html_table+= '<th>Rechnung Nr.</th>';
					html_table+= '<th>Action</th>';
					html_table+= '</tr>';
					for(var i = 0 ; i < response.length ; i++){
						var start = new Date(response[i].buy_vip_date);
					    var end   = new Date("2021-03-17");
					    var diff  = new Date(end - start);
					    var days  = Math.ceil(diff/1000/60/60/24);
					    var currency = 'Euro';
					    if(response[i].currency == '' || response[i].currency == null){
						    if(days < 1){
						        if(response[i].user_country == 'United Kingdom'){
						        	currency = 'GBP';
						        }
						        else if(response[i].user_country == 'Switzerland' || response[i].user_country == 'Schweiz'){
						        	currency = 'CHF';
						        }
						    }
					    }
					    else{
					    	currency = response[i].currency;
					    }
						html_table+= '<tr>';
							html_table+= '<td>';
								html_table+= i + 1;
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= response[i].vip_package_name;
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= currency + ' ' + response[i].vip_package_amount;;
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= response[i].buy_vip_date;
							html_table+= '</td>';
							html_table+= '<td>';
								if(response[i].canceled_date){
									html_table+= "<div style='z-index:999' class='online_status canceled-vip-in-table'>VIP Kündigung<br><small>" + response[i].canceled_date + "</small></div>";
								}
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= "<input data-vip-id='" + response[i].buy_vip_id + "' class='form-control invoice_number_value' style='float:left;width:85px' type='number' value='" + response[i].invoice_number + "' placeholder='Rechnung Nr.'>";
								html_table+= "<button class='btn btn-primary btn_savevip_invoice'>Save</button>";
							html_table+= '</td>';
							html_table+= '<td>';
								html_table+= '<a target="_blank" href="/admin/purchases/invoiceVIP/' + response[i].buy_vip_id + '/credit_purchase.pdf"><i class="fa fa-file-pdf-o fa-2x pdf_icon_style_download"></i></a>';
							html_table+= '</td>';
						html_table+= '</tr>';
						user_access_name = response[i].user_access_name;
					}
					$(".content_all_vips_pdf").append(html_table)
					$(".user_name_all_bill").html(user_access_name)
				}
			}
		})
    })
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
