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
                <strong><?php echo $this->lang->line('approvals'); ?></strong>
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
			<div class="col-md-6">
				<div class="well block_admin_dash">
					<div class="row">
						<div class="col-sm-7">
							<a href="<?php echo base_url('admin/approvals/image'); ?>">
								<i class="fa fa-picture-o"></i>
								<div class="desc_admin_block">						
									<b><?php echo $photo_count_statuswise['total']; ?></b>
									<br />
									<?php echo $this->lang->line('total_images_approvals'); ?>
								</div>
							</a>
						</div>
						<div class="col-sm-5">
							<ul class="list-group" style="margin: 0px;">
						  		<li class="text-left list-group-item" style="font-weight: bold;">						  			
						  			<a href="<?php echo base_url('admin/approvals/image?status=inactive'); ?>">
						    			<?php echo $this->lang->line('pending'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $photo_count_statuswise['pending']; ?></span>
						  		</li>						
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/approvals/image?status=active'); ?>">
						  				<?php echo $this->lang->line('approved'); ?>
						  			</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $photo_count_statuswise['approved']; ?></span>
						  		</li>
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/approvals/image?status=blocked'); ?>">
						    			<?php echo $this->lang->line('blocked'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $photo_count_statuswise['rejected']; ?></span>
						  		</li>
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/approvals/image?status=deleted'); ?>">
						    			<?php echo $this->lang->line('deleted'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $photo_count_statuswise['deleted']; ?></span>
						  		</li>				  		
							</ul>
						</div>
					</div>
				</div>					
			</div>			

			<div class="col-md-6">
				<div class="well block_admin_dash">
					<div class="row">
						<div class="col-sm-7">
							<a href="<?php echo base_url('admin/approvals/content'); ?>">
								<i class="fa fa-edit"></i>
								<div class="desc_admin_block">
									<b><?php echo $content_count_statuswise['total']; ?></b>
									<br />
									<?php echo $this->lang->line('total_content_approvals'); ?>
								</div>
							</a>
						</div>
						<div class="col-sm-5">
							<ul class="list-group" style="margin: 0px;">
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/approvals/content?status=pending'); ?>">
						    			<?php echo $this->lang->line('pending'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $content_count_statuswise['pending']; ?></span>
						  		</li>						
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/approvals/content?status=approved'); ?>">
						  				<?php echo $this->lang->line('approved'); ?>
						  			</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $content_count_statuswise['approved']; ?></span>
						  		</li>
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/approvals/content?status=rejected'); ?>">
						    			<?php echo $this->lang->line('rejected'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $content_count_statuswise['rejected']; ?></span>
						  		</li>
						  		<li class="text-left list-group-item" style="font-weight: bold;visibility: hidden;">
						  			<?php echo $this->lang->line('deleted'); ?>
						  		</li>						  		
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>

		<div class="clearfix well">
		<fieldset>
			<legend><i class="fa fa-picture-o"></i> Image Approval Requests</legend>
			<div class="table-responsive">
	    <?php 
	    	if(!empty($images_approvals)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('picture_type'); ?></th>
					<th><?php echo $this->lang->line('picture'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($images_approvals as $approval):
	    			if($approval["user_active_photo_thumb"] == '') {
	    				$approval['user_active_photo_thumb'] = "images/avatar/".$approval['user_gender'].".png";
	    			}	    			
			?>
			<tr>
				<td>
					<center>
					<a href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($approval["user_id_encrypted"]); ?>">
						<img style="width:78px;height:78px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $approval["user_active_photo_thumb"]; ?>" />
						<br/>
						<?php echo $approval['user_access_name']; ?>
			            <?php if($approval["user_status"] == 'deleted'): ?> 
			            <div class="deleted-stamp-profile-icon"><?php echo $this->lang->line($approval["user_status"]); ?></div>
			        	<?php endif; ?>
					</center>
					</a>
				</td>
				<td><?php echo $this->lang->line($approval['photo_type']); ?></td>
				<td>
					<img style="width:178px;height:178px;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $approval["photo_thumb_url"]; ?>" />

		            <?php if($approval["photo_status"] == 'deleted'): ?> 
		            <div class="deleted-stamp-for-image"><?php echo $this->lang->line($approval["photo_status"]); ?></div>
		        	<?php endif; ?>
				</td>
				<td>
					<?php 
					if($approval['photo_status'] == 'active') {
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($approval['photo_status']).'</span>'; 
					?>
				</td>
				<td><?php echo convert_date_to_local($approval['photo_added_date'], SITE_DATETIME_FORMAT); ?></td>
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
				<tfoot>
					<td colspan="4"></td>
					<td><a href="<?php echo base_url('admin/approvals/image'); ?>"><?php echo $this->lang->line('view_all'); ?> >></a></td>
				</tfoot>
			</table>
			<?php
			else:
			?>
			<div class="alert alert-info">
				<?php echo $this->lang->line('no_one_found'); ?>
			</div>
			<?php
			endif;
			?>
			</div>
		</fieldset>
		</div>

		<div class="clearfix well">
		<fieldset>
			<legend><i class="fa fa-edit"></i> Content Approval Requests</legend>
			<div class="table-responsive">
	    <?php 
	    	if(!empty($content_approvals)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('content_type'); ?></th>
					<th><?php echo $this->lang->line('content'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		foreach($content_approvals as $approval):
	    			if($approval["user_active_photo_thumb"] == '') {
	    				$approval['user_active_photo_thumb'] = "images/avatar/".$approval['user_gender'].".png";
	    			}
			?>
			<tr>
				<td>
					<center>
					<a href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($approval["user_id_encrypted"]); ?>">
						<img style="width:78px;height:78px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $approval["user_active_photo_thumb"]; ?>" />
						<br/>
						<?php echo $approval['user_access_name']; ?>
			            <?php if($approval["user_status"] == 'deleted'): ?> 
			            <div class="deleted-stamp-profile-icon"><?php echo $this->lang->line($approval["user_status"]); ?></div>
			        	<?php endif; ?>						
					</center>
					</a>
				</td>
				<td>
				<?php 
					if($approval['content_type'] == 'user_city') {
						echo $this->lang->line('location');
					}
					if($approval['content_type'] == 'user_about') {
						echo $this->lang->line('my_description');
					}
					if($approval['content_type'] == 'user_how_impress') {
						echo $this->lang->line('how_can_man_impress_you');
					}					
				?>						
				</td>
				<td><?php echo $approval['content_text']; ?></td>
				<td>
					<?php 
					if($approval['content_status'] == 'approved') {
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($approval['content_status']).'</span>'; 
					?>															
					</td>
				<td><?php echo convert_date_to_local($approval['content_added_date'], SITE_DATETIME_FORMAT); ?></td>
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
				<tfoot>
					<td colspan="4"></td>
					<td><a href="<?php echo base_url('admin/approvals/content'); ?>"><?php echo $this->lang->line('view_all'); ?> >></a></td>
				</tfoot>
			</table>
			<?php
			else:
			?>
			<div class="alert alert-info">
				<?php echo $this->lang->line('no_one_found'); ?>
			</div>
			<?php
			endif;
			?>
			</div>
		</fieldset>
		</div>

    </div>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>