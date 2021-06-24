<?php
$this->load->view('templates/headers/admin_header', $title);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('vip_packages'); ?></strong>
            </li>
        </ol>
    </div>
</div>

<div class="col-lg-12 block_form">
	<?php if($this->session->flashdata('message')) { ?>
	<div class="alert alert-info">
		<?php echo $this->session->flashdata('message'); ?>
	</div>
	<?php } ?>

    <div class="ibox-content-no-bg">
    	<div class="row">
    	<div class="col-lg-12">
    		<div class="pull-right">
    			<a href="<?php echo base_url('admin/vip/addPackage'); ?>" class="btn btn-success" style="border-radius: 5px;padding: 4px 20px;"><?php echo $this->lang->line('add_package'); ?></a>&nbsp;&nbsp;

    			<a href="<?php echo base_url('admin/vip/addFreeVIP'); ?>" class="btn btn-success" style="border-radius: 5px;padding: 4px 20px;"><?php echo $this->lang->line('add_free_vip'); ?></a>
    		</div>
    	</div>
    	</div>
    	<hr/>

		<div class="clearfix">
	    <?php 
	    	if(!empty($packages)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('package_name'); ?></th>
					<th><?php echo $this->lang->line('package_for'); ?></th>
					<th><?php echo $this->lang->line('validity_in_months'); ?></th>
					<th><?php echo $this->lang->line('package_in_amount'); ?></th>
					<th><?php echo $this->lang->line('package_in_diamonds'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($packages as $package):
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $package['package_name']; ?></td>
				<td><?php echo $this->lang->line($package['package_for']); ?></td>
				<td><?php echo $package['package_validity_total_months']; ?></td>
				<td><?php echo $package['package_total_amount']; ?></td>
				<td><?php echo $package['package_total_diamonds']; ?></td>
				<td>
					<?php 
					if($package['package_status'] == 'active') {						
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($package['package_status']).'</span>'; 
					?>					
				</td>
				<td><a href="<?php echo base_url('admin/vip/editPackage/').$package['package_id']; ?>"><i class="fa fa-edit"></i> <?php echo $this->lang->line('edit'); ?></a></td>
			</tr>	    	
			<?php
				endforeach;
			else:
			?>
			<div class="alert alert-info">
				<?php echo $this->lang->line('no_one_found'); ?>					
			</div>
			<?php
			endif;
			?>
				</tbody>
			</table>
		</div>
    </div>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>