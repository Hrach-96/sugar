<?php
$this->load->view('templates/headers/admin_header', $title);
?>
<style type="text/css">
	.pagination_ul li {
		display: inline-block;
	}
	.pagination_ul {
		padding:10px;
	}	
	.pagination_ul li .active {
		background: #140c0c1a;
	}
	.thumbnail img {
		height: 189px;
	}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('free_credits'); ?></strong>
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
		<div class="clearfix">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-4">
					<div class="well block_admin_dash">
						<i class="fa fa-area-chart"></i>
						<div class="desc_admin_block">
							<b><?php echo $total_users; ?></b>
							<br>
							<?php echo $this->lang->line('total_users'); ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="well block_admin_dash">
						<i class="fa fa-database"></i>
						<div class="desc_admin_block">
							<b><?php echo $total_free_credits; ?></b>
							<br>
							<?php echo $this->lang->line('total_free_credits'); ?>
						</div>
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>

	    <?php 
	    	if(!empty($users)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th></th>
					<th><?php echo $this->lang->line('email_address'); ?></th>
					<th><?php echo $this->lang->line('country'); ?></th>		
					<th><?php echo $this->lang->line('location'); ?></th>
					<th><?php echo $this->lang->line('free_credits'); ?></th>	
					<th><?php echo $this->lang->line('date'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($users as $user):
	    			if($user["user_active_photo_thumb"] == '') {
	    				$user['user_active_photo_thumb'] = "images/avatar/".$user['user_gender'].".png";
	    			}
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td>
					<center>
					<a href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($user['user_id_encrypted']); ?>">
						<img style="width:78px;height:78px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $user['user_active_photo_thumb']; ?>" />
						<br/>
						<?php echo $user['user_access_name']; ?>
			            <?php if($user["user_status"] == 'deleted'): ?> 
			            <div class="deleted-stamp-profile-icon"><?php echo $this->lang->line($user["user_status"]); ?></div>
			        	<?php endif; ?>
					</center>
					</a>
				</td>				
				<td><?php echo $user['user_email']; ?></td>
				<td><?php echo $user['user_country']; ?></td>
				<td><?php echo $user['user_city']; ?></td>
				<td><?php echo $user['user_taken_free_credits']; ?></td>
				<td><?php echo convert_date_to_local($user['user_register_date'], SITE_DATETIME_FORMAT); ?></td>
				<td>
					<a href="<?php echo base_url(); ?>admin/users/editProfile?user_hash=<?php echo urlencode($user["user_id_encrypted"]); ?>"><i class="fa fa-pencil"></i> <span><?php echo $this->lang->line('edit'); ?></span></a>
				</td>
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

	<?php
		if($links != ""):
	?>
	<div class="col-sm-12">
		<div class="btnmoreplaceholder">
			<?php echo $links; ?>
		</div>
	</div>
	<?php
		endif; 
	?>

		</div>
    </div>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>