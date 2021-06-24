<?php
$this->load->view('templates/headers/admin_header', $title);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/agents'); ?>"><?php echo $this->lang->line('manage_agents'); ?></a>
            </li>            
            <li class="active">
                <strong><?php echo $this->lang->line('add'); ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-12 block_form">	
	<form action="" method="post" accept-charset="utf-8" class="general_config well">
		<?php if(validation_errors() != '') { ?>
		<div class="alert alert-danger">
			<?php echo $this->lang->line('please_correct_your_information'); ?>
		</div>
		<?php } ?>
	    <fieldset>
	        <div class="form-group">
	            <label for="user_name"><?php echo $this->lang->line('username'); ?> :</label>
	            <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo set_value("user_name"); ?>">
	            <?php echo form_error('user_name'); ?>
	        </div>
	        <div class="form-group">
	            <label for="user_password"><?php echo $this->lang->line('password'); ?> :</label>
	            <input type="password" class="form-control" id="user_password" name="user_password" value="<?php echo set_value("user_password"); ?>">
	            <?php echo form_error('user_password'); ?>
	        </div>	        
	        <div class="form-group">
	            <label for="email_address"><?php echo $this->lang->line('email_address'); ?> :</label>
	            <input type="text" class="form-control" id="email_address" name="email_address" value="<?php echo set_value("email_address"); ?>">
	            <?php echo form_error('email_address'); ?>
	        </div>	       
	        <div class="form-group">
	            <label for="package_status"><?php echo $this->lang->line('gender'); ?> :</label>
				<select name="user_gender" class="form-control gender" style="text-align:center !important;">
					<option value="male" <?php if(set_value("user_gender") == 'male'): ?> selected="true"<?php endif; ?> ><?php echo $this->lang->line('male'); ?></option>
					<option value="female" <?php if(set_value("user_gender") == 'female'): ?> selected="true"<?php endif; ?>><?php echo $this->lang->line('female'); ?></option>
				</select>
				<?php echo form_error('user_gender'); ?>				
	        </div>

	        <div class="form-group">
	            <label for="user_birthday"><?php echo $this->lang->line('birthday'); ?> :</label>
				<div class="row">
					<div class="col-xs-4">
						<select name="dateofbirth_day" class="form-control text-center">
							<?php for($day=1; $day <= 31; $day++) { ?>
							<option class="option" value="<?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?>" <?php if(set_value('dateofbirth_day') == $day) { ?> selected="true" <?php } ?> ><?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-xs-4">
						<select name="dateofbirth_month" class="form-control text-center">
							<?php for($month=1; $month <= 12; $month++) { ?>
							<option class="option" value="<?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?>" <?php if(set_value('dateofbirth_month') == $month) { ?> selected="true" <?php } ?>><?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-xs-4">
						<select name="dateofbirth_year" class="form-control text-center">
							<?php 
							$curr_year = date('Y');
							$year_diff = $settings['site_age_limit'];
							$upto_year = $curr_year - $year_diff - 52;

							for($year=($curr_year-$year_diff); $year >= $upto_year; $year--) { ?>
							<option class="option" value="<?php echo $year; ?>" <?php if(set_value('dateofbirth_year') == $year) { ?> selected="true" <?php } ?>><?php echo $year; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
	        </div>

	        <div class="form-group">
	            <label for="user_postcode"><?php echo $this->lang->line('postcode'); ?> :</label>          
	            <input type="text" class="form-control" id="user_postcode" name="user_postcode" value="<?php echo set_value("user_postcode"); ?>">
	            <?php echo form_error('user_postcode'); ?>
	        </div>
	        <div class="form-group">
	            <label for="user_location"><?php echo $this->lang->line('location'); ?>:</label>	            
	            <input type="text" class="form-control" id="user_location" name="user_location" value="<?php echo set_value("user_location"); ?>">
	            <?php echo form_error('user_location'); ?>
	        </div>	        	        
	        <input type="hidden" name="user_country" id="user_country" value="">
	        <input type="hidden" name="user_latitude" id="user_latitude" value="">
	        <input type="hidden" name="user_longitude" id="user_longitude" value="">

	    </fieldset>
		<hr />

        <div style="text-align:center;">
            <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-check"></i> <?php echo $this->lang->line('save_changes'); ?></button>
        </div>
	</form>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#user_postcode").change(function() {
		var pincode_addr = $(this).val();

		<?php $country = "IN"; ?>
		$.ajax({
			url: "https://maps.googleapis.com/maps/api/geocode/json?address="+ pincode_addr +"+<?php echo $country; ?>&language=en&key=<?php echo GOOGLE_MAP_API_KEY; ?>",
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				var addr_str = "";

				if(data.results.length > 0) {
					var addr_length = data.results[0].address_components.length;
					var g_city = data.results[0].address_components[1].long_name;
					var g_country = data.results[0].address_components[addr_length-1].long_name;
					user_latitude = data.results[0].geometry.location.lat;
					user_longitude = data.results[0].geometry.location.lng;
					$("#user_location").val(g_city);
					$("#user_country").val(g_country);
					$("#user_latitude").val(user_latitude);
					$("#user_longitude").val(user_longitude);
				}
			}
		});
	});

});	
</script>