$(document).ready(function(){
	//chat window conditionally width and height
	  var alterClass = function() {
		var ww = document.body.clientWidth;
		if (ww < 767) {
		  $('.open_chat').click(function(){
			  $('#feedback').addClass('fullWidthChat');
			  $('#feedback-form').addClass('fullForm');
		  });
		  $('.close_chat').click(function(){
			  $('#feedback').removeClass('fullWidthChat');
			   $('#feedback').addClass("WidthChat");
		  });
		}
	  };
	  $(window).resize(function(){
		alterClass();
	  });
	  //Fire it when the page first loads:
	  alterClass();
	
    // $(".contact").click(function(){
        // $('#sidepanel').addClass('chat_menu_close');
    // }); 
	// $(".chat_button").click(function(){
        // $('#sidepanel').removeClass('chat_menu_close');
    // });
	
	$('.button').click(function(){
		$(".open_chat").toggle();
	})
	$('#switch1').click(function(){
		$(".tglBtn span").toggleClass('offColor');
	});

    $('.ckCls').click(function() {
        document.cookie = "usecookies=false;";
        $('#cookieModal').remove();
    }); 

    $('.ckAgree').click(function() {
        document.cookie = "usecookies=true;";
        $('#cookieModal').remove();
    }); 	
});

$(window).on('load',function(){
    var cflag = getCookie("usecookies");

    if (cflag == "") {
        $('#cookieModal').addClass('showCookie');
    } else {
        $('#cookieModal').remove();
    }
});

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');

    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}