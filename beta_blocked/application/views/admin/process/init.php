<!DOCTYPE html>
<html>
<head>
	<title>Process your project</title>
</head>
<body>
	<div style="margin: 200px 25%;font-size: 20px;">
		<form method="POST" action="">
			Enter your Password: <input type="password" name="password" style="border: 1px solid gray;padding: 3px 35px;margin: 10px;">
			<button type="submit" style="border: 1px solid gray;padding: 3px 10px;font-weight: 600;width: 128px;margin: 10px;">Proceed</button>
			<div style="color:red;text-align: center;font-size: 16px;"><?php echo form_error('password'); ?><?php echo  $this->session->flashdata('message'); ?></div>
		</form>
	</div>
</body>
</html>