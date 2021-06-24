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
                <strong><?php echo $this->lang->line('checks'); ?></strong>
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
							<a href="<?php echo base_url('admin/checks/reality'); ?>">
								<i class="fa fa-check-square-o"></i>
								<div class="desc_admin_block">						
									<b><?php echo $reality_doc_count['total']; ?></b>
									<br />
									<?php echo $this->lang->line('total_reality_documents'); ?>
								</div>
							</a>
						</div>
						<div class="col-sm-5">
							<ul class="list-group" style="margin: 0px;">
						  		<li class="text-left list-group-item" style="font-weight: bold;">						  			
						  			<a href="<?php echo base_url('admin/checks/reality?status=pending'); ?>">
						    			<?php echo $this->lang->line('pending'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $reality_doc_count['pending']; ?></span>
						  		</li>						
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/checks/reality?status=verified'); ?>">
						  				<?php echo $this->lang->line('verified'); ?>
						  			</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $reality_doc_count['verified']; ?></span>
						  		</li>
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/checks/reality?status=rejected'); ?>">
						    			<?php echo $this->lang->line('rejected'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $reality_doc_count['rejected']; ?></span>
						  		</li>
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/checks/reality?status=deleted'); ?>">
						    			<?php echo $this->lang->line('deleted'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $reality_doc_count['deleted']; ?></span>
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
							<a href="<?php echo base_url('admin/checks/asset'); ?>">
								<i class="fa fa-check-square-o"></i>
								<div class="desc_admin_block">						
									<b><?php echo $asset_doc_count['total']; ?></b>
									<br />
									<?php echo $this->lang->line('total_asset_documents'); ?>
								</div>
							</a>							
						</div>
						<div class="col-sm-5">
							<ul class="list-group" style="margin: 0px;">
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/checks/asset?status=pending'); ?>">
						    			<?php echo $this->lang->line('pending'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $asset_doc_count['pending']; ?></span>
						  		</li>						
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/checks/asset?status=verified'); ?>">
						  				<?php echo $this->lang->line('verified'); ?>
						  			</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $asset_doc_count['verified']; ?></span>
						  		</li>
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/checks/asset?status=rejected'); ?>">
						    			<?php echo $this->lang->line('rejected'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $asset_doc_count['rejected']; ?></span>
						  		</li>
						  		<li class="text-left list-group-item" style="font-weight: bold;">
						  			<a href="<?php echo base_url('admin/checks/asset?status=deleted'); ?>">
						    			<?php echo $this->lang->line('deleted'); ?>
						    		</a>
						    		<span class="badge badge-primary badge-pill"><?php echo $asset_doc_count['deleted']; ?></span>
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
			<legend><i class="fa fa-check-square-o"></i>&nbsp;<?php echo $this->lang->line('reality_check_documents'); ?></legend>
			<div class="table-responsive">
	    <?php 
	    	if(!empty($reality_documents)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('document'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($reality_documents as $approval):
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
			            <div class="deleted-stamp-at-images"><?php echo $this->lang->line($approval["user_status"]); ?></div>
			        	<?php endif; ?>
					</center>
					</a>
				</td>
				<td><a target="_blank" href="<?php echo base_url($approval['document_url']); ?>"><?php echo $approval['document_name']; ?></a></td>
				<td class="documentStatus">
					<?php 
					if($approval['document_status'] == 'verified') {
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($approval['document_status']).'</span>'; 
					?>															
				</td>
				<td><?php echo convert_date_to_local($approval['document_added_date'], SITE_DATETIME_FORMAT); ?></td>
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
				<tfoot>
					<td colspan="4"></td>
					<td><a href="<?php echo base_url('admin/checks/reality'); ?>"><?php echo $this->lang->line('view_all'); ?> >></a></td>
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
			<legend><i class="fa fa-check-square-o"></i>&nbsp;<?php echo $this->lang->line('asset_check_documents'); ?></legend>
			<div class="table-responsive">
	    <?php 
	    	if(!empty($asset_documents)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('document'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		foreach($asset_documents as $approval):
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
			            <div class="deleted-stamp-at-images"><?php echo $this->lang->line($approval["user_status"]); ?></div>
			        	<?php endif; ?>
					</center>
					</a>
				</td>
				<td><a target="_blank" href="<?php echo base_url($approval['document_url']); ?>"><?php echo $approval['document_name']; ?></a></td>
				<td class="documentStatus">
					<?php 
					if($approval['document_status'] == 'verified') {
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($approval['document_status']).'</span>'; 
					?>															
				</td>
				<td><?php echo convert_date_to_local($approval['document_added_date'], SITE_DATETIME_FORMAT); ?></td>
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
				<tfoot>
					<td colspan="4"></td>
					<td><a href="<?php echo base_url('admin/checks/asset'); ?>"><?php echo $this->lang->line('view_all'); ?> >></a></td>
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