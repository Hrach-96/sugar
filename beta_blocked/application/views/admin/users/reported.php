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
	.font-weight-normal {
		font-weight: normal;
	}
	.userslst_age {
		padding-left: 13px;
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
                <strong><?php echo $this->lang->line('reported_users'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4">
	    <form class="form-inline" method="POST" action="<?php echo base_url('admin/users/reported'); ?>">
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
		<div class="clearfix">
	    <?php 
	    	if(!empty($users)):
	    		foreach($users as $user):		
	    			if($user["user_active_photo_thumb"] == '')
	    				$user['user_active_photo_thumb'] = "images/avatar/".$user['user_gender'].".png";
			?>
	    	
			<div class="col-lg-12 col-md-12 col-xs-12 clearfix user_block" data-user-id="<?php echo $user["user_id_encrypted"]; ?>">
				<div class="thumb col-sm-3">
	                <a class="thumbnail" href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($user["user_id_encrypted"]); ?>">
			            <img src="<?php echo base_url() . $user["user_active_photo_thumb"]; ?>" alt="Photo User" />
			            <div class="online_status text-success">			            	
		                <?php
			                if($user["last_online_time"] <= '00:03:00' && $user["last_online_time"] != ""):
			            ?>
		                	<i class="fa fa-circle"></i>
		                <?php
		                	else:
		                		echo '&nbsp;';
			                endif;
			            ?>
			            </div>

			            <?php if($user["user_status"] == 'deleted'): ?> 
			            <div class="online_status deleted-stamp"><?php echo $this->lang->line($user["user_status"]); ?> <br><small><?php echo date(SITE_DATETIME_FORMAT, strtotime($user["user_deletion_date"])); ?></small></div>
			        	<?php endif; ?>
	               	</a>
				</div>
				<div class="thumb col-sm-9">					
				   	<div class="userslst_infos">
						<a href="<?php echo base_url(); ?>admin/users/editProfile?user_hash=<?php echo urlencode($user["user_id_encrypted"]); ?>" class="btn" title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;<b><?php echo $user["user_access_name"]; ?></b></a>
					   	<!-- <b><?php echo $user["user_access_name"]; ?></b> -->
					   	<div class="userslst_age">
					   		<?php echo $this->lang->line($user["user_gender"]); ?> &#8226; <?php echo floor($user["user_age"]); ?> &#8226; 
					   		<?php echo $this->lang->line($user["user_status"]); ?> &#8226; 
					   		<?php echo $user["user_city"]; ?> &#8226; 
					   		<?php echo $user["user_country"]; ?>
					   	</div>
					</div>
					<br/>

					<table class="table">
						<tbody>
							<tr>
								<th><b><?php echo $this->lang->line('reported_by'); ?></b></th>
								<th>
					   				<div class="font-weight-normal"><?php echo $user['reported_by']; ?></div>
								</th>
							</tr>
							<tr>
								<th><b><?php echo $this->lang->line('date'); ?></b></th>
								<th>
					   				<div class="font-weight-normal"><?php echo date('Y-m-d H:i:s', strtotime($user['report_added_date'])); ?></div>
								</th>
							</tr>

							<tr>
								<th><b><?php echo $this->lang->line('reason'); ?></b></th>
								<th>
					   				<div class="font-weight-normal"><?php echo $this->lang->line($user['report_reason_text']); ?></div>
								</th>
							</tr>
							<?php if($user['report_user_comment'] != '') { ?>
							<tr>
								<th><b><?php echo $this->lang->line('other_reason'); ?></b></th>
								<th>
					   				<div class="font-weight-normal"><?php echo $user['report_user_comment']; ?></div>
								</th>
							</tr>
							<?php } ?>
							<tr>
								<th style="width: 30%;"></th>
								<th></th>
							</tr>
						</tbody>
					</table>
				</div>

            </div>

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
		</div>

    </div>

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
<?php
$this->load->view('templates/footers/admin_footer');
?>