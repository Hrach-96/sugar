<?php
	$this->load->view('templates/headers/welcome_header', $title);
?>
<style type="text/css">
	.alert-danger-dlx {
		color: #f2e9e8;
		background-color: #d5191966;
		border-color: #e9e9e9;
		font-size: 16px;
	}
	.alert-dlx {
		padding: 10px;
		margin: 10px 10%;
		border: 1px solid transparent;
		border-radius: 4px;
	}
	.thnkSP {
	    font-size: 14.62px;
	    margin-top: -6px;
	    color: #fff;
	    text-align: center;
	}	
	.thnqSpn{
    padding: 0px 200px;
    display: block;
}
.noteTtl{
	    font-size: 41.67px;
}
#thankQmdl table tr td{
    position: relative;
    padding: 25px 0px;
}
#thankQmdl .control__indicator{
	top: 0px;
}
#thankQmdl .notesDiv{
	    text-align: center;
    padding: 44px;
    width: 1000px;
    margin: 0 auto;
}
.register_title{
	    font-size: 25px;
    font-weight: 300;
}
button{
	    background: transparent;
    outline: 0px;
    border: 0px;
}
@media (max-width:767px){
	#thankQmdl .notesDiv {
    width: 100%;
}
#thankQmdl .noteTtl {
    font-size: 25px;
}
#thankQmdl table tr td {
    padding: 0px 0px;
    display: block;
}
.thnqSpn{
      padding: 0px 0px;
    display: block;
    font-size: 25px;
}
.thnkP {
    font-size: 14px;
}
}
</style>
<section class="testimonial_section" id="thankQmdl">
	<form method="POST" action="">
	<div class="modal-body">
        <h4 class="full-pay gold-txt text-center">
        	<span class="sign_span thnqSpn"><?php echo $this->lang->line('create_new_password'); ?></span>
		</h4>
		<div class="notesDiv" style="text-align: center;padding: 44px;">
			<div class="text-left email_box">
				<label><?php echo $this->lang->line('new_password'); ?></label>
				<input class="email_add" type="password" name="new_password" autocomplete="off" maxlength="38" >	
			</div>

			<div class="text-left email_box">
				<label><?php echo $this->lang->line('confirm_new_password'); ?></label>
				<input class="email_add" type="password" name="confirm_new_password" autocomplete="off" maxlength="38" >
			</div>

			<?php if(validation_errors() != '') { ?>
			<div class="col-md-12 form-error error-box-message">
				<div class="alert-dlx alert-danger-dlx fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->lang->line('please_enter_correct_information'); ?>
				</div>
			</div>
			<?php } ?>
			<div class="notesDiv2" style="text-align: center;padding-top: 20px;">
				<button class="continue_btn RegBtn register_btn btn_hover" type="submit"><span class="cont_span"><?php echo $this->lang->line('confirm_and_continue'); ?></span></button>
		 	</div>
		</div>
    </div>
	</form>
</section>

<?php $this->load->view('templates/footers/welcome_footer'); ?>