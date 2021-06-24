$( document ).ready(function() {	
	//image upload
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });
	//image upload

    $('.ckCls').click(function() {
        document.cookie = "usecookies=false;";
        $('#cookieModal').remove();
    }); 

    $('.ckAgree').click(function() {
        document.cookie = "usecookies=true;";
        $('#cookieModal').remove();
    }); 
	
	//file upload
(function($, window, document, undefined) {
    $('.inputfile').each(function() {
        var $input = $(this),
            $label = $input.next('label'),
            labelVal = $label.html();

        $input.on('change', function(e) {
            var fileName = '';

            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else if (e.target.value)
                fileName = e.target.value.split('\\').pop();

            if (fileName)
                $label.find('span').html(fileName);
            else
                $label.html(labelVal);
        });

        // Firefox bug fix
        $input
            .on('focus', function() {
                $input.addClass('has-focus');
            })
            .on('blur', function() {
                $input.removeClass('has-focus');
            });
    });

})(jQuery, window, document);
	//file upload

    //ready close	
});

$(window).on('load',function(){
    var cflag = getCookie("usecookies");
    
    if(getCookie("showWelcomeAd") == "") {
        document.cookie = "showWelcomeAd=false;";
        // $("#welcomeAdsModal").modal();

        setTimeout(function() {
            // $("#welcomeAdsModal").modal('hide');
        }, 8000);
    }

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