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
	}
	th {
	    text-align: left;
	    padding: 8px;
	    font-weight: bold;
	    font-size: 15px;
	}
	td {
	    text-align: left;
	    padding: 8px;
	    font-size: 14px;
	}
</style>
</head>
<body>

<?php 
	$total_vip = 0.00;
	$total_credit = 0.00;
	$total_diamond = 0.00;
?>

<!-- START: FOR VIP Packages -->
<?php if(!empty($vip)): ?>
<div class="table-box">
	<h3 style="border-bottom: 1px solid gray;padding: 20px;"><?php echo $this->lang->line('vip_purchase'); ?></h3>
	<table cellspacing="5">
		<tr>
			<th></th>
			<th style="padding: 18px;"><?php echo $this->lang->line('name'); ?></th>
			<th><?php echo $this->lang->line('package_name'); ?></th>
			<th style="text-align: right;"><?php echo $this->lang->line('package_amount'); ?></th>
			<th><?php echo $this->lang->line('date'); ?></th>
		</tr>
		<?php 
			$sr_no = 1;			
			foreach($vip as $purchase):
				$total_vip += $purchase['vip_package_amount'];
		?>
		<tr>
			<td><?php echo $sr_no++; ?></td>
			<td><?php echo $purchase['user_access_name']; ?></td>
			<td><?php echo $purchase['vip_package_name']; ?></td>
			<td style="text-align: right;"><?php echo $purchase['vip_package_amount']; ?></td>
			<td><?php echo convert_date_to_local($purchase['buy_vip_date'], SITE_DATETIME_FORMAT); ?></td>
		</tr>	    	
		<?php
			endforeach;
		?>
		<tr>
			<th></th>
			<th></th>
			<th><?php echo $this->lang->line('total'); ?></th>
			<th style="text-align: right;"><?php echo number_format($total_vip, 2); ?></th>
			<th></th>
		</tr>		
	</table>
</div>
<?php endif; ?>
<!-- END: FOR VIP Packages -->

<!-- START: FOR CREDIT Packages -->
<?php if(!empty($credit)): ?>
<div class="table-box">
	<h3 style="border-bottom: 1px solid gray;padding: 20px;"><?php echo $this->lang->line('credit_purchase'); ?></h3>
	<table cellspacing="5">
		<tr>
			<th></th>
			<th><?php echo $this->lang->line('name'); ?></th>
			<th><?php echo $this->lang->line('package_name'); ?></th>
			<th style="text-align: right;"><?php echo $this->lang->line('package_amount'); ?></th>
			<th><?php echo $this->lang->line('date'); ?></th>
		</tr>
	<?php
		$sr_no = 1;		
		foreach($credit as $purchase):
			$total_credit += $purchase['credit_package_amount'];
	?>
	<tr>
		<td><?php echo $sr_no++; ?></td>
		<td><?php echo $purchase['user_access_name']; ?></td>
		<td><?php echo $purchase['credit_package_name']; ?></td>
		<td style="text-align: right;"><?php echo $purchase['credit_package_amount']; ?></td>
		<td><?php echo convert_date_to_local($purchase['buy_credit_date'], SITE_DATETIME_FORMAT); ?></td>
	</tr>	    	
	<?php
		endforeach;
	?>
		<tr>
			<th></th>
			<th></th>
			<th><?php echo $this->lang->line('total'); ?></th>
			<th style="text-align: right;"><?php echo number_format($total_credit, 2); ?></th>
			<th></th>
		</tr>
	</table>
</div>
<?php endif; ?>
<!-- END: FOR CREDIT Packages -->

<!-- START: FOR DIAMOND Packages -->
<?php if(!empty($diamond)): ?>
<div class="table-box">
	<h3 style="border-bottom: 1px solid gray;padding: 20px;"><?php echo $this->lang->line('diamond_purchase'); ?></h3>
	<table cellspacing="5">
		<tr>
			<th></th>
			<th style="width: 220px;"><?php echo $this->lang->line('name'); ?></th>
			<th><?php echo $this->lang->line('package_name'); ?></th>
			<th style="text-align: right;"><?php echo $this->lang->line('package_amount'); ?></th>
			<th><?php echo $this->lang->line('date'); ?></th>
		</tr>
	<?php
		$sr_no = 1;
		foreach($diamond as $purchase):
			$total_diamond += $purchase['diamond_package_amount'];
	?>
	<tr>
		<td><?php echo $sr_no++; ?></td>
		<td><?php echo $purchase['user_access_name']; ?></td>
		<td><?php echo $purchase['diamond_package_name']; ?></td>
		<td style="text-align: right;"><?php echo $purchase['diamond_package_amount']; ?></td>
		<td><?php echo convert_date_to_local($purchase['buy_diamond_date'], SITE_DATETIME_FORMAT); ?></td>
	</tr>
	<?php
		endforeach;
	?>
		<tr>
			<th></th>
			<th style="width: 220px;"></th>
			<th><?php echo $this->lang->line('total'); ?></th>
			<th style="text-align: right;"><?php echo number_format($total_diamond, 2); ?></th>
			<th></th>
		</tr>
	</table>
<?php endif; ?>
<!-- END: FOR DIAMOND Packages -->

<h3 style="border-bottom: 1px solid gray;padding: 20px;"><?php echo $this->lang->line('purchases'); ?></h3>
<table cellpadding="4" cellspacing="4">
	<?php if($total_vip > 0) { ?>
	<tr>
		<td style="text-align: right;"><h4><?php echo $this->lang->line('total_vip_amount'); ?></h4></td>
		<td style="text-align: right;"><h3><?php echo number_format($total_vip, 2); ?></h3></td>
	</tr>
	<?php } if($total_credit > 0) { ?>
	<tr>
		<td style="text-align: right;"><h4><?php echo $this->lang->line('total_credit_amount'); ?></h4></td>
		<td style="text-align: right;"><h3><?php echo number_format($total_credit, 2); ?></h3></td>
	</tr>
	<?php } if($total_diamond > 0) { ?>
	<tr>
		<td style="text-align: right;"><h4><?php echo $this->lang->line('total_diamond_amount'); ?></h4></td>
		<td style="text-align: right;"><h3><?php echo number_format($total_diamond, 2); ?></h3></td>
	</tr>
	<?php } ?>
	<tr>
		<th style="text-align: right;"><h3><?php echo $this->lang->line('grand_total'); ?></h3></th>
		<th style="border-top: 2px solid gray;text-align: right;"><h3><?php echo number_format(($total_vip + $total_credit + $total_diamond), 2); ?></h3></th>
	</tr>
 </table>

</body>
</html>