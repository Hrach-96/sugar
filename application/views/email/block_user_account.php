<!-- / Hero subheader -->
<table class="container hero-subheader" border="0" cellpadding="0" cellspacing="0" width="620" style="width: 620px;">
<tr>
	
	<td class="hero-subheader__title" style="font-size: 43px; font-weight: bold; padding: 15px 15px;" align="left">
	<img style="width:128px;height:128px;border-radius:50%;object-fit:cover;visibility: hidden; border: 1px solid #464646;" src="<?php echo $user_profile_pic ?>" />
	</td>
	<td class="hero-subheader__title" style="font-size: 43px; font-weight: bold; padding: 15px 15px ;vertical-align: top;" align="left">

		<h4 style="text-transform: uppercase;padding: 0px 0px;margin: 0px;font-size: 20px;color: rgb(232, 228, 151);font-family: 'Cinzel', serif;font-weight: 500;"><?php echo $this->lang->line('hello').' '.$user_name; ?>!</h4>
		
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('block_user_email_template_first_text'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('block_user_email_template_second_text'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('activate_user_account_email_template_third_text').' '.' Justification'.' '.$this->lang->line('block_user_email_template_four_text'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('block_user_email_template_five_text'); ?></h4>

		<!--a href="<?php echo base_url(); ?>" style="width: 353px;height: 51px;background-image: url(<?php echo base_url('images/anmeldenImg.png') ;?>);display: block;line-height: 51px;text-align: center;color: #fff;text-transform: uppercase;letter-spacing: 2px;text-decoration: none;font-family: 'Montserrat', sans-serif;font-size: 16.67px;font-family: 'Montserrat';color: rgb(255, 255, 255);text-transform: uppercase;font-weight: 400;margin-top: 20px;">
						<?php echo $this->lang->line('login_now'); ?>
		</a -->
	</td>
</tr>
	<tr>
	<td class="hero-subheader__title " style="visibility:hidden;font-size: 43px;font-weight: bold;padding: 0px 15px;" align="left">
	<img src="<?php echo base_url('images/userImage.png'); ?>"> 
	</td>
	<td class="hero-subheader__title" style="font-size: 43px;font-weight: bold;padding: 0px 15px;vertical-align: middle;" align="left">
	
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 0px;font-weight: 500;"><?php echo $this->lang->line('many_greetings'); ?></h4>
		<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #fff;margin-top: 5px;font-weight: 500;"><?php echo $this->lang->line('your_sugarbabe_deluxe_team'); ?></h4>
	</td>
</tr>

</table>
<!-- /// Hero subheader -->