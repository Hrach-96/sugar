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
    <div class="col-lg-8">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('manage_agents'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4">
	    <form class="form-inline" method="POST" action="<?php echo base_url('admin/agents'); ?>">
		    <div class="btn_filter_placeholder">
				<div class="form-group">
		    		<input type="text" name="search_text" value="<?php echo $search_key; ?>" class="form-control form-username" placeholder="<?php echo $this->lang->line('search_by_username'); ?>" />
				</div>
				<button type="submit" name="btn-search" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
		    </div>
	    </form>
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
    			<a href="<?php echo base_url('admin/agents/addAgent'); ?>" class="btn btn-success" style="border-radius: 5px;padding: 4px 20px;"><?php echo $this->lang->line('add_agent'); ?></a>
    		</div>			
    	</div>
    	</div>
    	<hr/>

		<div class="clearfix">
	    <?php 
	    	if(!empty($users)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('email_address'); ?></th>
					<th><?php echo $this->lang->line('gender'); ?></th>
					<th><?php echo $this->lang->line('birthday'); ?></th>
					<th><?php echo $this->lang->line('location'); ?></th>
					<th colspan="2" class="text-center"><?php echo $this->lang->line('image_approvals'); ?></th>
					<th colspan="2" class="text-center"><?php echo $this->lang->line('content_approvals'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>					
				</thead>
				<thead>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th class="text-center"><?php echo $this->lang->line('today'); ?></th>
					<th class="text-center"><?php echo $this->lang->line('total'); ?></th>
					<th class="text-center"><?php echo $this->lang->line('today'); ?></th>
					<th class="text-center"><?php echo $this->lang->line('total'); ?></th>
					<th></th>
					<th></th>
				</thead>				
				<tbody>
	    	<?php
	    		foreach($users as $user):
	    			if($user["user_active_photo_thumb"] == '') {
	    				$user['user_active_photo_thumb'] = "images/avatar/".$user['user_gender'].".png";
	    			}
			?>
			<tr>
				<td>
					<center>
			            <div class="online_status text-success" style="position: relative;top: 18px;left: -25px;">
		                <?php
			                if($user["last_online_time"] <= '00:03:00' && $user["last_online_time"] != ""):
			            ?>
		                	<i class="fa fa-circle"></i>
		                <?php
			                endif;
			            ?>
			            </div>
						<img style="width:78px;height:78px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $user["user_active_photo_thumb"]; ?>" />
						<br/>
						<?php echo $user['user_access_name']; ?>
					</center>
				</td>
				<td><?php echo $user['user_email']; ?></td>
				<td><?php echo $this->lang->line($user['user_gender']); ?></td>				
				<td><?php echo convert_date_to_local($user['user_birthday'], 'd M Y'); ?></td>
				<td><?php echo $user['user_city']; ?></td>
				<td class="text-center"><?php echo $user['todays_images_approved']; ?></td>
				<td class="text-center"><?php echo $user['total_images_approved']; ?></td>
				<td class="text-center"><?php echo $user['todays_content_approved']; ?></td>
				<td class="text-center"><?php echo $user['total_content_approved']; ?></td>
				
				<?php 
					$bg_status = 'badge-danger';
					if($user['user_status'] == 'active') {
						$bg_status = 'badge-success';
					} 
				?>
				<td><span class="badge <?php echo $bg_status; ?>"><?php echo $this->lang->line($user['user_status']); ?></span></td>
				<td>
					<a href="<?php echo base_url(); ?>admin/agents/editProfile?user_hash=<?php echo urlencode($user["user_id_encrypted"]); ?>"><i class="fa fa-edit"></i> <?php echo $this->lang->line('edit'); ?></a>
				</td>
			</tr>
			<?php
				endforeach;
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
			else: 
				?>
			<div class="alert alert-info">
				<?php echo $this->lang->line('no_one_found'); ?>					
			</div>
			<?php endif; ?>
		</div>

    </div>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>