<?php
  $this->load->view('templates/headers/agent_header', $title);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('agent'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('dashboard'); ?></strong>
            </li>
        </ol>
    </div>
</div>

<div class="col-lg-12 block_form">
	<div class="row">

		<div class="col-sm-6">
			<div class="well block_admin_dash">
				<div class="row">
					<div class="col-sm-7">
						<i class="fa fa-picture-o"></i>
						<div class="desc_admin_block">						
							<b style="font-size: 16px;"><?php echo $this->lang->line('image_approvals'); ?></b>
						</div>
					</div>
					<div class="col-sm-5">
						<ul class="list-group" style="margin: 0px;">
					  		<li class="text-left list-group-item" style="font-weight: bold;">						  			
					  			<?php echo $this->lang->line('pending'); ?>
					    		<span class="badge badge-primary badge-pill"><?php echo $pending_images_approvals; ?></span>
					  		</li>						
					  		<li class="text-left list-group-item" style="font-weight: bold;">
					  			<?php echo $this->lang->line('approved'); ?>
					    		<span class="badge badge-primary badge-pill"><?php echo $todays_images_approved; ?></span>
						  	</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="well block_admin_dash">
				<div class="row">
					<div class="col-sm-7">
						<i class="fa fa-edit"></i>
						<div class="desc_admin_block">						
							<b style="font-size: 16px;"><?php echo $this->lang->line('content_approvals'); ?></b>
						</div>
					</div>
					<div class="col-sm-5">
						<ul class="list-group" style="margin: 0px;">
					  		<li class="text-left list-group-item" style="font-weight: bold;">						  			
					  			<?php echo $this->lang->line('pending'); ?>
					    		<span class="badge badge-primary badge-pill"><?php echo $pending_content_approvals; ?></span>
					  		</li>						
					  		<li class="text-left list-group-item" style="font-weight: bold;">
					  			<?php echo $this->lang->line('approved'); ?>
					    		<span class="badge badge-primary badge-pill"><?php echo $todays_content_approved; ?></span>
						  	</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr />

	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>agent/approvals/content"><i class="fa fa-edit"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>agent/approvals/content"><?php echo $this->lang->line('content_approvals'); ?></a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>agent/approvals/image"><i class="fa fa-picture-o"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>agent/approvals/image"><?php echo $this->lang->line('image_approvals'); ?></a>
				</div>
			</div>
		</div>
	</div>

</div>

<?php
  $this->load->view('templates/footers/agent_footer');
?>