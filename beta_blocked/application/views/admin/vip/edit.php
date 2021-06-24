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
                <a href="<?php echo base_url('admin/vip'); ?>"><?php echo $this->lang->line('vip_packages'); ?></a>
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
	            <label for="package_name"><?php echo $this->lang->line('package_name'); ?> :</label>
	            <input type="text" class="form-control" id="package_name" name="package_name" value="<?php echo $package["package_name"]; ?>">
	            <?php echo form_error('package_name'); ?>
	        </div>
	        <div class="form-group">
	            <label for="package_for"><?php echo $this->lang->line('package_for'); ?> :</label>
				<select name="package_for" id="package_for" class="form-control">
					<option <?php if($package["package_for"] == 'male'): ?>selected<?php endif; ?> value="male"><?php echo $this->lang->line('male'); ?></option>
					<option <?php if($package["package_for"] == 'female'): ?>selected<?php endif; ?> value="female"><?php echo $this->lang->line('female'); ?></option>
				</select>
				<?php echo form_error('package_for'); ?>
	        </div>
	        <div class="form-group">
	            <label for="package_validity_total_months"><?php echo $this->lang->line('validity_in_months'); ?> :</label>
	            <input type="text" class="form-control" id="package_validity_total_months" name="package_validity_total_months" value="<?php echo $package["package_validity_total_months"]; ?>" placeholder="e.g. 10">
	            <?php echo form_error('package_validity_total_months'); ?>
	        </div>
	        <div class="form-group">
	            <label for="package_total_amount"><?php echo $this->lang->line('package_in_amount'); ?> :</label>
	            <input type="text" class="form-control" id="package_total_amount" name="package_total_amount" value="<?php echo $package["package_total_amount"]; ?>" placeholder="e.g. 100.00">
	            <?php echo form_error('package_total_amount'); ?>
	        </div>
	        <div class="form-group">
	            <label for="package_total_diamonds"><?php echo $this->lang->line('package_in_diamonds'); ?> :</label>
	            <input type="text" class="form-control" id="package_total_diamonds" name="package_total_diamonds" value="<?php echo $package["package_total_diamonds"]; ?>" placeholder="e.g. 10">
	            <?php echo form_error('package_total_diamonds'); ?>
	        </div>	        
	        <div class="form-group">
	            <label for="package_status"><?php echo $this->lang->line('status'); ?> :</label>
				<select name="package_status" id="package_status" class="form-control">
					<option <?php if($package["package_status"] == 'active'): ?>selected<?php endif; ?> value="active"><?php echo $this->lang->line('active'); ?></option>
					<option <?php if($package["package_status"] == 'inactive'): ?>selected<?php endif; ?> value="inactive"><?php echo $this->lang->line('inactive'); ?></option>
				</select>
				<?php echo form_error('package_status'); ?>	
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