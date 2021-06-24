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
                <a href="<?php echo base_url('admin/credit'); ?>"><?php echo $this->lang->line('credit_packages'); ?></a>
            </li>            
            <li class="active">
                <strong><?php echo $this->lang->line('free_credits'); ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-12 block_form">	
	<form action="" method="post" accept-charset="utf-8" class="general_config well">
		<?php if(validation_errors() != '') { ?>
		<div class="alert alert-danger">
			<?php echo $this->lang->line('please_try_again_after_some_time'); ?>
		</div>
		<?php } ?>
	    <fieldset>
	    	<input type="hidden" name="package_id" value="<?php echo $package["package_id"]; ?>">
	    	<legend><i class="fa fa-database"></i>&nbsp;&nbsp;<?php echo $this->lang->line('add_free_credits'); ?></legend>
	        <table class="table">
	        	<tr>
	            	<td><label><?php echo $this->lang->line('package_name'); ?> </label></td>
	            	<td><?php echo $package["package_name"]; ?></td>
	            </tr>
	            <tr>
	            	<td><label><?php echo $this->lang->line('package_credits'); ?> </label></td>
	            	<td><?php echo $package["package_credits"]; ?></td>
	            </tr>
	        </table>
	    </fieldset>
		<hr />

        <div style="text-align:center;">
            <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-check"></i> <?php echo $this->lang->line('activate'); ?></button>
        </div>
	</form>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>