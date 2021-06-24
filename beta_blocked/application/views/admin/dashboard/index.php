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
            <li class="active">
                <strong><?php echo $this->lang->line('dashboard'); ?></strong>
            </li>
        </ol>
    </div>
</div>

<div class="col-lg-12 block_form">
	<div class="row">
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<i class="fa fa-area-chart"></i>
				<div class="desc_admin_block">
					<b><?php echo $total_users; ?></b>
					<br />
					<?php echo $this->lang->line('total_users'); ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<i class="fa fa-user-plus"></i>
				<div class="desc_admin_block">
					<b><?php echo $new_users_today; ?></b>
					<br />
					<?php echo $this->lang->line('new_users_today'); ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<i class="fa fa-euro"></i>
				<div class="desc_admin_block">
					<b><?php echo $total_purchases; ?></b>
					<br />
					<?php echo $this->lang->line('total_purchases'); ?>
				</div>
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>admin/settings"><i class="fa fa-cogs"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>admin/settings"><?php echo $this->lang->line('site_settings'); ?></a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>admin/users"><i class="fa fa-users"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>admin/users"><?php echo $this->lang->line('manage_users'); ?></a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>admin/users/reported"><i class="fa fa-bullhorn"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>admin/users/reported"><?php echo $this->lang->line('reported_users'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>admin/vip"><i class="fa fa-list"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>admin/vip"><?php echo $this->lang->line('vip_packages'); ?></a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>admin/diamond"><i class="fa fa-diamond"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>admin/diamond"><?php echo $this->lang->line('diamond_packages'); ?></a>
				</div>
			</div>
		</div>

    <div class="col-md-4">
      <div class="well block_admin_dash">
        <a href="<?php echo base_url(); ?>admin/credit"><i class="fa fa-database"></i></a>
        <div class="desc_admin_block">
          <a href="<?php echo base_url(); ?>admin/credit"><?php echo $this->lang->line('credit_packages'); ?></a>
        </div>
      </div>
    </div>

	
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>admin/purchases"><i class="fa fa-euro"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>admin/purchases"><?php echo $this->lang->line('purchases'); ?></a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>admin/language"><i class="fa fa-globe"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>admin/language"><?php echo $this->lang->line('manage_languages'); ?></a>
				</div>
			</div>
		</div>		
		<div class="col-md-4">
			<div class="well block_admin_dash">
				<a href="<?php echo base_url(); ?>admin/news"><i class="fa fa-newspaper-o"></i></a>
				<div class="desc_admin_block">
					<a href="<?php echo base_url(); ?>admin/news"><?php echo $this->lang->line('news'); ?></a>
				</div>
			</div>
		</div>		
	</div>

</div>

<?php
  $this->load->view('templates/footers/admin_footer');
?>