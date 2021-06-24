<html>
<head> 
<meta charset="utf-8">
<style>
	body {
	    font-family:"Times New Roman", Times, serif;	    
	}            
	table {
	    border-collapse: collapse;
	    width: 100%;
	    font-size: 14px;
	}

	td, th {
	    text-align: left;
	    padding: 8px;
	}
</style>
</head>
<body>

<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #000;margin-top: 15px;font-weight: bold;font-family: 'Montserrat', sans-serif;text-transform: uppercase;"><?php echo $this->lang->line('hello').' '.$user_name; ?>,</h4>

<h4 style="padding: 0px 0px;margin: 0px;font-size: 14.67px;color: #000;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_third_text').' '.$package_duration; ?> <?php if($package_duration == 1) { echo $this->lang->line('month'); } else { echo $this->lang->line('months'); } ?></h4>
<h4 style="padding: 0px 0px;margin: 0px;font-size: 14.67px;color: #000;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_fourth_text').' &euro;'.$purchase_amount.' '.$this->lang->line('vip_purchased_email_template_fifth_text'); ?></h4>

<h4 style="padding: 0px 0px;margin: 0px;font-size: 14.67px;color: #000;margin-top: 15px;font-weight: bold;font-family: 'Montserrat', sans-serif;text-decoration: underline;"><?php echo $this->lang->line('bill_address'); ?>:</h4>

<table style="padding: 4px 10px;margin: 0px;font-size: 14.67px;color: #000;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;width: 100%;">
	<tr><td><?php echo $this->lang->line('first_name'); ?>:</td><td><?php echo $first_name; ?></td></tr>
	<tr><td><?php echo $this->lang->line('last_name'); ?>:</td><td><?php echo $last_name; ?></td></tr>
	<tr><td><?php echo $this->lang->line('street_or_no'); ?>:</td><td><?php echo $street_or_no; ?></td></tr>
	<tr><td><?php echo $this->lang->line('location'); ?>:</td><td><?php echo $location; ?></td></tr>
	<tr><td><?php echo $this->lang->line('country'); ?>:</td><td><?php echo $country; ?></td></tr>
	<tr><td><?php echo $this->lang->line('email'); ?>:</td><td><?php echo $email; ?></td></tr>
	<tr><td><?php echo $this->lang->line('telephone'); ?>:</td><td><?php echo $telephone; ?></td></tr>
</table>

<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #000;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('payment').':'.$payment_mode; ?></h4>

<h4 style="padding: 0px 0px;font-size: 16.67px;color: #000;margin: 10px 10px;font-weight: 500;"><br></h4>

<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #000;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_sixth_text').' '.$package_expire_date; ?></h4>
<h4 style="padding: 0px 0px;margin: 0px;font-size: 16.67px;color: #000;margin-top: 15px;font-weight: 400;font-family: 'Montserrat', sans-serif;"><?php echo $this->lang->line('vip_purchased_email_template_seventh_text').' '.$package_duration; ?> <?php if($package_duration == 1) { echo $this->lang->line('month'); } else { echo $this->lang->line('months'); } ?> <?php echo $this->lang->line('vip_purchased_email_template_eighth_text').' &euro;'.$purchase_amount; ?></h4>


<h4 style="padding: 0px 0px;font-size: 16.67px;color: #000;margin: 10px 10px;font-weight: 500;"><br></h4>

<h4 style="padding: 0px 0px;font-size: 16.67px;color: #000;margin: 10px 10px;font-weight: 500;"><?php echo $this->lang->line('many_greetings'); ?></h4>
<h4 style="padding: 0px 0px;font-size: 16.67px;color: #000;margin-top: 2px;font-weight: 500;"><?php echo $this->lang->line('your_sugarbabe_deluxe_team'); ?></h4>

</body>
</html>