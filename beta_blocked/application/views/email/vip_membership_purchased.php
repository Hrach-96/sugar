<!-- / Hero subheader -->
<table class="container hero-subheader" border="0" cellpadding="0" cellspacing="0" width="620" style="width: 620px;">
<tr>
	<td class="hero-subheader__title" style="font-size: 43px; font-weight: bold; padding: 15px 15px;" align="left">
	<img style="width:128px;height:128px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo $user_profile_pic; ?>" />
	</td>
	<td class="hero-subheader__title" style="font-size: 43px; font-weight: bold; padding: 15px 15px ;vertical-align: top;" align="left">
		<h4 style="text-transform: uppercase;padding: 0px 0px;margin: 0px;font-size: 20px;color: rgb(232, 228, 151);font-family: 'Cinzel', serif;font-weight: 500;"><?php echo $this->lang->line('hello').' '.$user_name; ?>,</h4>
		
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_first_text'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_second_text'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_third_text').' '.$package_duration; ?> <?php if($package_duration == 1) { echo $this->lang->line('month'); } else { echo $this->lang->line('months'); } ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_fourth_text').' &euro;'.$purchase_amount.' '.$this->lang->line('vip_purchased_email_template_fifth_text'); ?></h4>

	</td>
</tr>
<tr>
	<td class="hero-subheader__title" style="visibility:hidden;font-size: 43px;font-weight: bold;padding: 0px 15px;" align="left">
	<div style="width:128px;height:128px;"></div>
	</td>
	<td class="hero-subheader__title" style="font-size: 43px;font-weight: bold;padding: 0px 15px;vertical-align: middle;" align="left">	

		<h4 style="text-decoration: underline;padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: bold;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('bill_address'); ?>:</h4>
		<table style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;width: 100%;">
			<tr><td><?php echo $this->lang->line('first_name'); ?>:</td><td><?php echo $first_name; ?></td></tr>
			<tr><td><?php echo $this->lang->line('last_name'); ?>:</td><td><?php echo $last_name; ?></td></tr>
			<tr><td><?php echo $this->lang->line('street_or_no'); ?>:</td><td><?php echo $street_or_no; ?></td></tr>
			<tr><td><?php echo $this->lang->line('location'); ?>:</td><td><?php echo $location; ?></td></tr>
			<tr><td><?php echo $this->lang->line('country'); ?>:</td><td><?php echo $country; ?></td></tr>
			<tr><td><?php echo $this->lang->line('email'); ?>:</td><td><?php echo $email; ?></td></tr>
			<tr><td><?php echo $this->lang->line('telephone'); ?>:</td><td><?php echo $telephone; ?></td></tr>
		</table>

		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('payment').':'.$payment_mode; ?></h4>
		<br/>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_sixth_text').' '.$package_expire_date; ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_seventh_text').' '.$package_duration; ?> <?php if($package_duration == 1) { echo $this->lang->line('month'); } else { echo $this->lang->line('months'); } ?> <?php echo $this->lang->line('vip_purchased_email_template_eighth_text').' &euro;'.$purchase_amount; ?></h4>
	</td>
</tr>
<tr>
	<td class="hero-subheader__title" style="visibility:hidden;font-size: 43px;font-weight: bold;padding: 0px 15px;" align="left">
	<div style="width:128px;height:128px;"></div>
	</td>
	<td class="hero-subheader__title" style="font-size: 43px;font-weight: bold;padding: 0px 15px;vertical-align: middle;" align="left">
	
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 0px;font-weight: 500;"><?php echo $this->lang->line('many_greetings'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 5px;font-weight: 500;"><?php echo $this->lang->line('your_sugarbabe_deluxe_team'); ?></h4>
	</td>
</tr>

</table>
<!-- /// Hero subheader -->