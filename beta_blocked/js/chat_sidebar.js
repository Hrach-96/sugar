$(function() {
	$(".close_chat").click(function() {
		$("#feedback").css("top", "100px");
		$("#feedback-form").toggle("slide");
		 $(this).toggleClass('left_close');
		$("#feedback-tab").toggleClass("hide_title");
				$(".open_chat").show();
		$(".open_chat").removeClass("hide_chat_i");
		$(".open_chat").css("visibility","visible");
		

	 });
	 $(".open_chat").click(function() {
		 
		$("#feedback").css("top", "0px");
		$("#feedback-form").toggle("slide");
		 $(this).toggleClass('left_close');
		$("#feedback-tab").toggleClass("hide_title");
		$(this).hide();
		$('open_chat').removeClass("open_chat");
		
	 });
	
	$("#feedback-form form").on('submit', function(event) {
		var $form = $(this);
		$.ajax({
			type: $form.attr('method'),
			url: $form.attr('action'),
			data: $form.serialize(),
			success: function() {
				$("#feedback-form").toggle("slide").find("textarea").val('');
			}
		});
		event.preventDefault();
	});
});

$(function(){
    $(".heading-compose").click(function() {
      $(".side-two").css({
        "left": "0"
      });
    });

    $(".newMessage-back").click(function() {
      $(".side-two").css({
        "left": "-100%"
      });
    });
})

