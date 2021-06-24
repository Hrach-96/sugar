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
	.chkout_radio {
    color: #fff !important;
    font-size: 12.5px;
    padding-left: 35px;
}
.chkout_radio .control__indicator {
    left: 0px;
    top: 0px;
    position: absolute;
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
.continue_btn {
	width: 325px;
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
.email_box{
	width: 100%;
}
.email_box .email_add {
    border-radius: 4px;
    background-color: rgb(255, 255, 255);
    height: 50px;
    padding: 0px 20px;
    margin-top: 5px;
    border: 0px;
    font-size: 15px;
    font-weight: 500;
    color: #999999;
    width: 100%;
}
.error_div{
    color: red;
    font-weight: 600;
    position: relative;
    top: 10px;
}
</style>

<section class="profile_section_home profile_setting" id="fbRegister" class="registerModal">
	<div class="container">

		<!--User Details-->
		<form id="fb_user" action="<?php echo base_url('auth/fb_register'); ?>" method="POST" enctype="multipart/form-data">
			<div class="row" id="userDetails">
				<div class="col-md-12 padding_zero">
			        <h4 class="full-pay gold-txt text-center">
			        	<span class="sign_span thnqSpn"><?php echo $this->lang->line('create_your_account'); ?></span>
					</h4>
				<br/><br/>
				<input type="hidden" name="user_country" value="<?php echo set_value('user_country'); ?>">
				<input type="hidden" name="user_latitude" value="<?php echo set_value('user_latitude'); ?>">
				<input type="hidden" name="user_longitude" value="<?php echo set_value('user_longitude'); ?>">
				</div>
				<div class="col-md-12 padding_zero">
					<div class="text-left email_box">
						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('username'); ?></label>
								<input class="email_add" name="user_username" type="text" placeholder="<?php echo $this->lang->line('enter_username'); ?>" value="<?php echo set_value('user_username'); ?>" autocomplete="off" maxlength="100" value="" >
								<div class="error_div"><?php echo form_error('user_username'); ?></div>
							</div>

							<div class="col-md-2">
								<label><?php echo $this->lang->line('day'); ?></label>
								<div class="select">
									<select name="dateofbirth_day">								
										<?php for($day=1; $day <= 31; $day++) { ?>
										<option class="option" value="<?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?>"><?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?></option>
										<?php } ?>
									</select>
				  					<div class="select__arrow">
				  						<i class="fa fa-angle-down" aria-hidden="true"></i>
				  					</div>
								</div>
							</div>

							<div class="col-md-2">
								<label><?php echo $this->lang->line('month'); ?></label>
								<div class="select">
									<select name="dateofbirth_month">
										<?php for($month=1; $month <= 12; $month++) { ?>
										<option class="option" value="<?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?>" ><?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?></option>
										<?php } ?>
									</select>
	      							<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
	    						</div>
							</div>

							<div class="col-md-2">
								<label><?php echo $this->lang->line('year'); ?></label>
								<div class="select">
									<select name="dateofbirth_year">
										<?php 
										$curr_year = date('Y');
										$year_diff = $settings['site_age_limit'];
										$upto_year = $curr_year - $year_diff - 52;
										for($year=($curr_year-$year_diff); $year >= $upto_year; $year--) { ?>
										<option class="option" value="<?php echo $year; ?>" ><?php echo $year; ?></option>
										<?php } ?>
									</select>
	      							<div class="select__arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
	    						</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('postcode');?></label>
								<input class="email_add" id="user_postcode_fb" name="user_postcode" type="text" placeholder="<?php echo $this->lang->line('enter_postcode'); ?>" autocomplete="off" maxlength="100" value="<?php echo set_value('user_postcode'); ?>" >
								<div class="error_div"><?php echo form_error('user_postcode'); ?></div>
							</div>
							<div class="col-md-6">
								<label><?php echo $this->lang->line('where_are_you_from');?></label>
								<input class="email_add" name="user_location" id="user_location_fb" type="text" placeholder="<?php echo $this->lang->line('enter_location'); ?>" autocomplete="off" maxlength="100" value="<?php echo set_value('user_location'); ?>" >
								<div class="error_div"><?php echo form_error('user_location'); ?></div>
							</div>
						</div>

						<div class="row">							
							<div class="col-md-6">
								<label><?php echo $this->lang->line('i_am_a'); ?></label>
								<div class="col-md-3">
									<label class="control control--radio col-md-12 interest chkout_radio">
	      								<input type="radio" name="i_am_a" value="male" checked="true" /><?php echo $this->lang->line('man'); ?>
	      								<div class="control__indicator"></div>
	    							</label>
	    						</div>
	    						<div class="col-md-3">
	    							<label class="control control--radio col-md-12 interest chkout_radio">
	      								<input type="radio" name="i_am_a" value="female"/><?php echo $this->lang->line('female'); ?>
	      								<div class="control__indicator"></div>
    							</label>
	    						</div>
							</div>

							<div class="col-md-6">
                               <label><?php echo $this->lang->line('i_am_inerested_in'); ?></label>
								<div class="col-md-3">
									<label class="control control--radio col-md-12 interest chkout_radio">
	      								<input type="radio" name="i_am_inerested_in" value="male" /><?php echo $this->lang->line('man'); ?>
	      								<div class="control__indicator"></div>
	    							</label>
	    						</div>
	    						<div class="col-md-3">
	    							<label class="control control--radio col-md-12 interest chkout_radio">
	      								<input type="radio" name="i_am_inerested_in" value="female" checked="true" /><?php echo $this->lang->line('female'); ?>
	      								<div class="control__indicator"></div>
    							</label>
	    						</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label><?php echo $this->lang->line('size'); ?></label>
								<div class="select">
									<input class="email_add" name="user_size" placeholder="<?php echo $this->lang->line('enter_size');?>" maxlength="3" value="<?php echo set_value('user_size'); ?>" >
									<div class="select__arrow"><?php echo $this->lang->line('cm'); ?></div>
								</div>
								<div class="error_div"><?php echo form_error('user_size'); ?></div>
							</div>
						</div>
				     </div>
				</div>
			</div>	
										
			
			<div class="row" id="submit_btns">
				<div class="col-md-12 padding_zero">
					<hr class="prfl_stting">
				</div>
				<div class="col-md-12 padding_zero">
					<div class="btn_box ">
					<center><button type="submit" class="continue_btn btn-register-fb next btn_hover"><span class="cont_span"><?php echo $this->lang->line('confirm_and_continue'); ?></span></button></center>
					</div>
				</div>
				<div class="col-md-12 padding_zero" id="mobHr">
					<hr class="prfl_stting">
				</div>
			</div>
		</form>
	</div>
</section>
<?php $this->load->view('templates/footers/welcome_footer'); ?>



<script type="text/javascript">
	$(document).ready(function(){
	$("#user_postcode_fb").change(function() {
		var pincode_addr = $(this).val();

		<?php 
			if($this->session->has_userdata('user_currlocation')) {
				$cur_country = $this->session->userdata('user_currlocation')['country'];
			} else {
				$cur_country = DEFAULT_COUNTRY;
			}
		 ?>
		$.ajax({
			url: "https://maps.googleapis.com/maps/api/geocode/json?address="+ pincode_addr +"+<?php echo $cur_country; ?>&language=en&key=<?php echo GOOGLE_MAP_API_KEY; ?>",
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				var addr_str = "";

				if(data.results.length > 0) {
					var addr_length = data.results[0].address_components.length;

					if(addr_length > 1) {
						var g_city = data.results[0].address_components[1].long_name;
						var g_country = data.results[0].address_components[addr_length-1].long_name;
					} else {
						var g_city = '';
						var g_country = data.results[0].address_components[0].long_name;
					}

					$("#fb_user input[name=user_latitude]").val(data.results[0].geometry.location.lat);
					$("#fb_user input[name=user_longitude]").val(data.results[0].geometry.location.lng);
					$("#fb_user input[name=user_location]").val(g_city);
					$("#fb_user input[name=user_country]").val(g_country);
				}
			}
		});
	});

	$("#user_location_fb").change(function() {
		var location_addr = $(this).val();

		$.ajax({
			url: "https://maps.googleapis.com/maps/api/geocode/json?address="+ location_addr +"&language=en&key=<?php echo GOOGLE_MAP_API_KEY; ?>",
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				var addr_str = "";

				if(data.results.length > 0) {
					var addr_length = data.results[0].address_components.length;

					if(addr_length > 1) {
						var g_city = data.results[0].address_components[1].long_name;
						var g_country = data.results[0].address_components[addr_length-1].long_name;
					} else {
						var g_city = '';
						var g_country = data.results[0].address_components[0].long_name;
					}

					$("#fb_user input[name=user_latitude]").val(data.results[0].geometry.location.lat);
					$("#fb_user input[name=user_longitude]").val(data.results[0].geometry.location.lng);
					$("#fb_user input[name=user_country]").val(g_country);
				}
			}
		});
	});
});
</script>

