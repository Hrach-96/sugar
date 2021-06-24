$(document).ready(function() {

    /* Conatct Us */
    $("#attach_file").click(function(){
        $("#message_attachment").trigger('click');
    });    

    $(document).on("change", "#message_attachment", function(e) {
        var fileName = e.target.files[0].name;
        $("#attached_filename").html(fileName);
    });
});