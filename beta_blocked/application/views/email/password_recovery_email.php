<!-- / Hero subheader -->
<table class="container hero-subheader" border="0" cellpadding="0" cellspacing="0" width="620" style="width: 620px;">
<tr>
	<td class="hero-subheader__title" style="font-size: 43px; font-weight: bold; padding: 15px 15px;" align="left">
	<img style="width:128px;height:128px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo $user_pic; ?>" />
	</td>
	<td class="hero-subheader__title" style="font-size: 43px; font-weight: bold; padding: 15px 15px ;vertical-align: top;" align="left">
		<h4 style="text-transform: uppercase;padding: 0px 0px;margin: 0px;font-size: 20px;color: rgb(232, 228, 151);font-family: 'Cinzel', serif;font-weight: 500;"><?php echo $this->lang->line('hello').' '.$user_name; ?>,</h4>
		
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('user_recovery_email_template_text_first'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('user_recovery_email_template_text_second'); ?></h4>

		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;word-break: break-all;"><a href="<?php echo $recovery_token_url; ?>" style="text-decoration:none;"><?php echo $recovery_token_url; ?></a></h4>
	</td>
</tr>
	<tr>
	<td class="hero-subheader__title" style="font-size: 43px;font-weight: bold;padding: 0px 15px;" align="left">
	<div style="width:128px;height:128px;"></div>
	</td>
	<td class="hero-subheader__title" style="font-size: 43px;font-weight: bold;padding: 0px 15px;vertical-align: middle;" align="left">
	
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 0px;font-weight: 500;"><?php echo $this->lang->line('many_greetings'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 5px;font-weight: 500;"><?php echo $this->lang->line('your_sugarbabe_deluxe_team'); ?></h4>
	</td>
</tr>

</table>