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
                <a href="<?php echo base_url('admin/vouchers'); ?>"><?php echo $this->lang->line('manage_voucher'); ?></a>
            </li>            
            <li class="active">
                <strong><?php echo $this->lang->line('add'); ?></strong>
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
	        <div class="form-group">
	            <label for="procent"><?php echo $this->lang->line('procent_voucher'); ?> :</label>
	            <input type="number" min='1' max='100' class="form-control" id="procent" name="procent" value="<?php echo set_value("procent"); ?>">
	            <?php echo form_error('procent'); ?>
	        </div>        	        
		<hr />
        <div style="text-align:center;">
            <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-check"></i> <?php echo $this->lang->line('save_changes'); ?></button>
        </div>
	</form>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>