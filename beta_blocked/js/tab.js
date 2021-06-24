$(".targetDiv").hide();
$(".cls_advnc_srch").hide();
$(".advnc_srch_div").hide();
$("#div1").show();
$('.showSingle').on('click', function(){
  var target = $(this).attr('rel');
  $("#"+target).show(1200).siblings("div").hide(1200);
});

$('.advnc_srch').click(function() {
	$(this).hide();
	$('.cls_advnc_srch').show();
  $('.advnc_srch_div').slideToggle('slow');
});
$('.cls_advnc_srch').click(function() {
	$(this).hide();
	$('.advnc_srch').show();
  $('.advnc_srch_div').hide('slow');
});

//chat scroll

$("#chat_scroll").mCustomScrollbar({
	axis:"yx",
	theme:"3d",
	mouseWheel:{ preventDefault: true }
});


//accordion code
! function(t) {
    t.fn.liloAccordion = function(i) {
        var o = t.extend({
            onlyOneActive: !0,
            initFirstActive: !0,
            destructor: !1,
            hideControl: !1,
            openNextOnClose: !1
        }, i);
        return this.each(function() {
            var i = t(this),
                n = t("> .lilo-accordion-content", i).prev(".lilo-accordion-control"),
                e = t("> .lilo-accordion-content", i);
            if (o.destructor) return n.off("click").removeClass("active"), o.hideControl && n.css("display", "none"), e.css("display", "block"), void i.data("status", !1);

            function c() {
                n.filter(".active").next(".lilo-accordion-content").stop(!1, !0).slideDown(), n.filter(":not(.active)").next(".lilo-accordion-content").stop(!1, !0).slideUp()
            }
            1 != i.data("status") && (i.data("status", !0), n.css("display", "block"), e.css("display", "none"), o.initFirstActive && n.filter(":first").addClass("active"), c(), n.on("click", function(e) {
                e.preventDefault(), (i = t(this)).hasClass("active") ? (o.openNextOnClose && i.parent().find(".lilo-accordion-control").each(function() {
                    if (t(this).index() > i.index()) return t(this).addClass("active"), !1
                }), i.removeClass("active")) : (o.onlyOneActive && n.removeClass("active"), i.addClass("active")), c()
            }))
        })
    }
}(jQuery);

 $('.your-class').liloAccordion({
  onlyOneActive: true,
  initFirstActive: true,
  hideControl: false,
  openNextOnClose: true

});
//accordion code
