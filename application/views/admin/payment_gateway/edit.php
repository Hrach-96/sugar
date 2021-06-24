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
                <a href="<?php echo base_url('admin/payment_gateway'); ?>"><?php echo $this->lang->line('payment_gateway'); ?></a>
            </li>            
            <li class="active">
                <strong><?php echo $this->lang->line('edit'); ?></strong>
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
	            <label for="gateway_name"><?php echo $this->lang->line('name'); ?> :</label>
	            <input type="text" class="form-control" id="gateway_name" name="gateway_name" value="<?php echo $gateway["payment_gateway_name"]; ?>" readonly>
	        </div>
	        <div class="form-group">
	            <label for="client_id"><?php echo $this->lang->line('client_id'); ?> :</label>
	            <input type="text" class="form-control" id="client_id" name="client_id" value="<?php echo $gateway["client_id"]; ?>">
	            <?php echo form_error('client_id'); ?>
	        </div>
	        <div class="form-group">
	            <label for="access_token"><?php echo $this->lang->line('access_token'); ?> :</label>
	            <input type="text" class="form-control" id="access_token" name="access_token" value="<?php echo $gateway["client_acces_token"]; ?>">
	            <?php echo form_error('access_token'); ?>
	        </div>
	        <div class="form-group">
	            <label for="currency"><?php echo $this->lang->line('currency'); ?> :</label>
	            <input type="text" class="form-control" id="currency" name="currency" value="<?php echo $gateway["currency"]; ?>">
	            <?php echo form_error('currency'); ?>
	        </div>
	        <div class="form-group">
	            <label for="url"><?php echo $this->lang->line('url'); ?> :</label>
	            <input type="text" class="form-control" id="url" name="url" value="<?php echo $gateway["url"]; ?>">
	            <?php echo form_error('url'); ?>
	        </div>
	        <div class="form-group">
	            <label for="mode"><?php echo $this->lang->line('mode'); ?> :</label>
				<select name="mode" id="mode" class="form-control">
					<option <?php if($gateway["mode"] == 'live'): ?>selected<?php endif; ?> value="live"><?php echo $this->lang->line('live'); ?></option>
					<option <?php if($gateway["mode"] == 'test'): ?>selected<?php endif; ?> value="test"><?php echo $this->lang->line('test'); ?></option>
				</select>
				<?php echo form_error('mode'); ?>	
	        </div>
	        <div class="form-group">
	            <label for="status"><?php echo $this->lang->line('status'); ?> :</label>
				<select name="status" id="status" class="form-control">
					<option <?php if($gateway["status"] == 'active'): ?>selected<?php endif; ?> value="active"><?php echo $this->lang->line('active'); ?></option>
					<option <?php if($gateway["status"] == 'inactive'): ?>selected<?php endif; ?> value="inactive"><?php echo $this->lang->line('inactive'); ?></option>
				</select>
				<?php echo form_error('status'); ?>	
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