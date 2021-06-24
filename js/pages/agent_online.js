$(document).ready(function() {
	setTimeout(syncWithServer, 2000);
});

function syncWithServer() {
	$.ajax({
		type: 'post',
		async: false,
		url: base_url + "agent/online/sync",
		success: function(response) {
			setTimeout(syncWithServer, 10000);
    	},
    	error: function (xhr, ajaxOptions, thrownError) {
    		setTimeout(syncWithServer, 20000);
    	}
	});

}