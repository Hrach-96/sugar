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
<!-- START: FOR VIP Packages -->
<?php if(!empty($list)): ?>
<div class="table-box">
	<h3 style="border-bottom: 1px solid gray;padding: 20px;"><?php echo $this->lang->line('news'); ?></h3>
	<table cellspacing="5">
		<tr>
			<th></th>
			<th><?php echo $this->lang->line('email_address'); ?></th>
			<th><?php echo $this->lang->line('status'); ?></th>
			<th><?php echo $this->lang->line('date'); ?></th>
		</tr>
		<?php 
			$sr_no = 1;			
			foreach($list as $value):
		?>
		<tr>
			<td><?php echo $sr_no++; ?></td>
			<td><?php echo $value[0]; ?></td>
			<td><?php echo $value[1]; ?></td>
			<td><?php echo $value[2]; ?></td>
		</tr>	    	
		<?php
			endforeach;
		?>		
	</table>
</div>
<?php endif; ?>
<!-- END: FOR VIP Packages -->
</body>
</html>