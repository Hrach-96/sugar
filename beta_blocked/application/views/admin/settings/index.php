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
            <li class="active">
                <strong><?php echo $this->lang->line('site_settings'); ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-12 block_form">	
	<?php //echo validation_errors(); ?>
	<form action="" method="post" accept-charset="utf-8" class="general_config well">
		<?php if($this->session->flashdata('message')) { ?>
		<div class="alert alert-info">
			<?php echo $this->session->flashdata('message'); ?>
		</div>
		<?php } ?>

	    <fieldset>
	        <legend><i class="fa fa-level-up"></i> <?php echo $this->lang->line('general_settings'); ?></legend>
	        <div class="form-group">
	            <label for="site_name"><?php echo $this->lang->line('website_name'); ?> :</label>
	            <input type="text" class="form-control" id="site_name" name="site_name" value="<?php echo $settings["site_name"]; ?>" placeholder="<?php echo $this->lang->line('your_website_name'); ?>">
	        </div>
	        <div class="form-group">
	            <label for="site_tagline"><?php echo $this->lang->line('website_tagline'); ?> :</label>
	            <input type="text" class="form-control" id="site_tagline" name="site_tagline" value="<?php echo $settings["site_tagline"]; ?>" placeholder="<?php echo $this->lang->line('the_title_of_your_website_which_will_appear_in_the_search_engines'); ?>">
	        </div>
	        <div class="form-group">
	            <label for="site_description"><?php echo $this->lang->line('website_description'); ?> :</label>
	            <input type="text" class="form-control" id="site_description" name="site_description" value="<?php echo $settings["site_description"]; ?>" placeholder="<?php echo $this->lang->line('your_website_description'); ?>">
	        </div>
	        <div class="form-group">
	            <label for="site_tags"><?php echo $this->lang->line('website_keywords'); ?> :</label>
	            <input type="text" class="form-control" id="site_tags" name="site_tags" value="<?php echo $settings["site_tags"]; ?>" placeholder="Ex. date, dating, meet, ...">
	        </div>
	        <div class="form-group">
	            <label for="free_credits"><?php echo $this->lang->line('free_credits'); ?> :</label>
	            <input type="text" class="form-control" id="free_credits" name="free_credits" value="<?php echo $settings["free_credits"]; ?>">
	        </div>
	        <div class="form-group">
	            <label for="vip_user_unlocking_cost"><?php echo $this->lang->line('vip_user_unlocking_cost'); ?> :</label>
	            <input type="text" class="form-control" id="vip_user_unlocking_cost" name="vip_user_unlocking_cost" value="<?php echo $settings["vip_user_unlocking_cost"]; ?>">
	        </div>	     
	        <div class="form-group">
	            <label for="basic_user_unlocking_cost"><?php echo $this->lang->line('basic_user_unlocking_cost'); ?> :</label>
	            <input type="text" class="form-control" id="basic_user_unlocking_cost" name="basic_user_unlocking_cost" value="<?php echo $settings["basic_user_unlocking_cost"]; ?>">
	        </div>
	        <div class="form-group">
	            <label for="site_age_limit"><?php echo $this->lang->line('minimum_age_to_register'); ?> :</label>
				<select name="site_age_limit" id="site_age_limit" class="form-control">
				<?php
					for($cpt = 10; $cpt <= 25; $cpt++) {
				?>
					<option <?php if($settings["site_age_limit"] == $cpt): ?>selected<?php endif; ?> value="<?php echo $cpt; ?>"><?php echo $cpt; ?></option>
				<?php	
					}
				?>
				</select>				
	        </div>	        
	        <div class="form-group">
	            <label for="default_country"><?php echo $this->lang->line('default_country'); ?> :</label>
				<select name="default_country" id="default_country" class="form-control">
				<?php
				if(!empty($countries)) {
					foreach($countries as $country) {
				?>
					<option <?php if($settings["default_country_abbr"] == $country['country_abbr']): ?>selected<?php endif; ?> value="<?php echo $country['country_abbr']; ?>"><?php echo $this->lang->line($country['country_name']); ?></option>
				<?php	
					}
				}
				?>
				</select>				
	        </div>	        
			<div class="form-group">
	            <label for="site_analytics"><?php echo $this->lang->line('analytics_code'); ?> :</label>
	            <textarea class="form-control" id="site_analytics" name="site_analytics" placeholder="Your Javascript Analytics Code Goes Here"><?php echo $settings["site_analytics"]; ?></textarea>
				<p class="help-block"><i class="fa fa-info-circle"></i> <?php echo $this->lang->line('paste_your_google_or_ther_system_analytics_code'); ?></p>
	        </div>
	    </fieldset>
		<hr />
	    <fieldset>
	        <legend><i class="fa fa-facebook-square"></i> <?php echo $this->lang->line('social_profiles'); ?></legend>
	        <div class="form-group">
	            <label for="fb_url">Facebook :</label>
	            <input type="text" class="form-control fb_url" id="fb_url" name="fb_url" value="<?php echo $settings["fb_url"]; ?>" placeholder="Your Facebook Page / Profile URL">
	        </div>
	        <div class="form-group">
	            <label for="twitter_url">Twitter :</label>
	            <input type="text" class="form-control twitter_url" id="twitter_url" name="twitter_url" value="<?php echo $settings["twitter_url"]; ?>" placeholder="Your Twitter Profile URL">
	        </div>
	        <div class="form-group">
	            <label for="instagram_url">Instagram :</label>
	            <input type="text" class="form-control instagram_url" id="instagram_url" name="instagram_url" value="<?php echo $settings["instagram_url"]; ?>" placeholder="Your Instagram Profile URL">
	        </div>
	        <div class="form-group">
	            <label for="youtube_url">Youtube :</label>
	            <input type="text" class="form-control gplus_url" id="youtube_url" name="youtube_url" value="<?php echo $settings["youtube_url"]; ?>" placeholder="Your Youtube Page URL">
	        </div>
	        <div class="form-group">
	            <label for="instagram_url">iOS App :</label>
	            <input type="text" class="form-control instagram_url" id="app_ios" name="app_ios" value="<?php echo $settings["app_ios"]; ?>" placeholder="Your iOS APP">
	        </div>
	        <div class="form-group">
	            <label for="gplus_url">Android App :</label>
	            <input type="text" class="form-control gplus_url" id="gplus_url" name="gplus_url" value="<?php echo $settings["app_android"]; ?>" placeholder="Your Android App">
	        </div>	        
	    </fieldset>
	    <hr/>		
		<fieldset>
			<legend><i class="fa fa-envelope"></i> <?php echo $this->lang->line('email_settings'); ?></legend>
			<div class="form-group">
				<label for="email_protocol">Protocol :</label>
				<select name="email_protocol" id="email_protocol" class="form-control">
				<?php
					$email_protocols = array('smtp', 'sendmail', 'mail');
					foreach($email_protocols as $protocol) {
				?>
					<option <?php if($settings["email_protocol"] == $protocol): ?>selected="true" <?php endif; ?> value="<?php echo $protocol; ?>"><?php echo strtoupper($protocol); ?></option>
				<?php } ?>
				</select>
			</div>			
			<div class="form-group">
				<label for="from_email"><?php echo $this->lang->line('from_email_address'); ?> :</label>
				<input type="text" class="form-control" id="from_email" name="from_email" value="<?php echo $settings["from_email"]; ?>" placeholder="e.g noreply@example.com">
			</div>
			<div class="form-group">
				<label for="smtp_host"><?php echo $this->lang->line('smtp_hostname'); ?> :</label>
				<input type="text" class="form-control" id="smtp_host" name="smtp_host" value="<?php echo $settings["smtp_host"]; ?>">
			</div>
			<div class="form-group">
				<label for="smtp_user"><?php echo $this->lang->line('smtp_username'); ?> :</label>
				<input type="text" class="form-control" id="smtp_user" name="smtp_user" value="<?php echo $settings["smtp_user"]; ?>">
			</div>
			<div class="form-group">
				<label for="smtp_pass"><?php echo $this->lang->line('smtp_password'); ?> :</label>
				<input type="text" class="form-control" id="smtp_pass" name="smtp_pass" value="<?php echo $settings["smtp_pass"]; ?>">
			</div>
			<div class="form-group">
				<label for="smtp_port"><?php echo $this->lang->line('smtp_port'); ?> :</label>
				<input type="text" class="form-control" id="smtp_port" name="smtp_port" value="<?php echo $settings["smtp_port"]; ?>" placeholder="21">
			</div>
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