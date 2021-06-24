<?php
$this->load->view('templates/headers/admin_header', $title);
?>
<style type="text/css">
	.text-white {
		color: #edeaea;
	}
	.make-box {
		border: 1px solid #eee;
		box-shadow: 1px 1px 2px gray;
		margin-bottom: 10px;
	}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
			<li>
                <a href="<?php echo base_url('admin/users'); ?>"><?php echo $this->lang->line('manage_users'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('edit'); ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-12 block_form">
	<div class="panel">
		<h3 style="padding: 10px;"><?php echo $user_row["user_access_name"]; ?>
		<span class="badge badge-primary pull-right text-uppercase">
			<?php echo $user_row["user_status"]; ?>
		</span>			
		</h3>
	</div>

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

		<div class="panel panel-success">
			<div class="panel-heading" role="tab" id="headingOne">
				<span class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				<?php echo $this->lang->line('public_information'); ?> </a>
				</span>
				<div class="pull-right">
					<a class="text-white" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
					<i class="fa fa-plus fa-lg"></i></a>
				</div>
			</div>
			<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('gender'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_gender"]); ?></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('location'); ?></label>
									<div class="form-control"><?php echo $user_row["user_city"]; ?>, <?php echo $user_row["user_country"]; ?></div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('postcode'); ?></label>
									<div class="form-control"><?php echo $user_row["user_postcode"]; ?></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('birthday'); ?></label>
									<div class="form-control"><?php echo date(MESSAGE_DATE_FORMAT, strtotime($user_row["user_birthday"])); ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('latitude'); ?></label>
									<div class="form-control"><?php echo $user_row["user_latitude"]; ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('longitude'); ?></label>
									<div class="form-control"><?php echo $user_row["user_longitude"]; ?></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('interested_in'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_interested_in"]); ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('arangement'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_arangement"]); ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('serious_relationship'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["interested_in_serious_relationship"]); ?></div>
								</div>
							</div>
						</div>													
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('figure'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_figure"]); ?></div>
								</div>
							</div>
							<div class="col-sm-4">		
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('size'); ?></label>
									<div class="form-control"><?php echo $user_row["user_height"]; ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('smoker'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_smoker"]); ?></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('eye_color'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_eye_color"]); ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('hair_color'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_hair_color"]); ?></div>
								</div>	
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('monthly_budget'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_monthly_budget"]); ?></div>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('job'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_job"]); ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('ethnicity'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_ethnicity"]); ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('verified'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_verified"]); ?></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('children'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["user_has_child"]); ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('how_many'); ?></label>
									<div class="form-control"><?php echo $user_row["how_many_childrens"]; ?></div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('language'); ?></label>
									<div class="form-control"><?php echo $this->lang->line($user_row["language_id_ref"]); ?></div>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group" style="text-align:left;margin-top:20px;">
									<label class="control-label"><?php echo $this->lang->line('my_description'); ?></label>
									<div style="height:auto;" class="form-control"><?php echo $user_row["user_about"]; ?></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group" style="text-align:left;margin-top:20px;">
									<label class="control-label"><?php if($user_row['user_gender'] == 'female') { echo $this->lang->line('how_can_man_impress_you'); } else { echo $this->lang->line('how_can_women_impress_you'); } ?></label>
									<div style="height:auto;" class="form-control"><?php echo $user_row["user_how_impress"]; ?></div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading" role="tab" id="headingTwo">
				<span class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				<?php echo $this->lang->line('account_information'); ?> </a>
				</span>
				<div class="pull-right">
					<a class="collapsed text-white" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-plus fa-lg"></i></a>
				</div>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label"><?php echo $this->lang->line('username'); ?></label>
								<div class="form-control"><?php echo $user_row["user_access_name"]; ?></div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="form-group">
								<label class="control-label"><?php echo $this->lang->line('email'); ?></label>
								<div class="form-control"><?php echo $user_row["user_email"]; ?></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label"><?php echo $this->lang->line('last_activity'); ?></label>
								<div class="form-control"><?php echo convert_date_to_local($user_row["user_last_activity_date"], 'Y-m-d H:i:s'); ?></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label"><?php echo $this->lang->line('last_login'); ?></label>
								<div class="form-control"><?php echo convert_date_to_local($user_row["user_last_activity_date"], 'Y-m-d H:i:s'); ?></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label"><?php echo $this->lang->line('registered_date'); ?></label>
								<div class="form-control"><?php echo convert_date_to_local($user_row["user_register_date"], 'Y-m-d H:i:s'); ?></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label"><?php echo $this->lang->line('rank'); ?></label>
								<div class="form-control"><?php echo $user_row["user_rank"]; ?></div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="form-group">
								<label class="control-label">IP Address</label>
								<div class="form-control"><?php echo $user_row["ip_address"]; ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading" role="tab" id="headingSix">
				<span class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
				<?php echo ucfirst($this->lang->line('diamonds')); ?> / <?php echo ucfirst($this->lang->line('credits')); ?> / <?php echo $this->lang->line('vip'); ?></a>
				</span>
				<div class="pull-right">
					<a class="collapsed text-white" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix"><i class="fa fa-plus fa-lg"></i></a>
				</div>
			</div>
			<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
							<h4>
								<?php echo $this->lang->line('free_credits'); ?> : <?php echo $user_row['user_taken_free_credits'].' '.$this->lang->line('credits'); ?>

								<span class="pull-right badge badge-secondary">
									<?php echo $this->lang->line('vip'); ?> : <?php echo $this->lang->line($user_row['user_is_vip']); ?>
								</span>
								
							</h4>
						</div>
						<div class="col-sm-12">
							<div class="col-sm-2 well block_admin_dash">
								<a href="#"><i class="fa fa-diamond"></i></a>
								<div class="desc_admin_block">
									<?php echo $user_row['user_diamonds'].' '.$this->lang->line('diamonds'); ?>
								</div>
							</div>							
							<div class="col-sm-10">
							<?php if(!empty($diamond_purchase)): ?>
								<table class="table table-striped table-hover">
									<thead>
										<th><?php echo $this->lang->line('package_name'); ?></th>
										<th><?php echo $this->lang->line('package_diamonds'); ?></th>
										<th><?php echo $this->lang->line('package_amount'); ?></th>
										<th><?php echo $this->lang->line('date'); ?></th>
									</thead>
									<tbody>
							    	<?php foreach($diamond_purchase as $purchase): ?>
									<tr>
										<td><?php echo $purchase['diamond_package_name']; ?></td>
										<td><?php echo $purchase['diamond_package_diamonds']; ?></td>
										<td><?php echo $purchase['diamond_package_amount']; ?></td>
										<td><?php echo convert_date_to_local($purchase['buy_diamond_date'], SITE_DATETIME_FORMAT); ?></td>
									</tr>	    	
									<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
							</div>
			       		</div>			       					       	
						<div class="col-sm-12">
							<div class="col-sm-2 well block_admin_dash">
								<a href="#"><i class="fa fa-database"></i></a>
								<div class="desc_admin_block">
									<?php echo $user_row['user_credits'].' '.$this->lang->line('credits'); ?>
								</div>
							</div>
							<div class="col-sm-10">
							<?php if(!empty($credit_purchase)): ?>
								<table class="table table-striped table-hover">
									<thead>
										<th><?php echo $this->lang->line('package_name'); ?></th>
										<th><?php echo $this->lang->line('package_credits'); ?></th>
										<th><?php echo $this->lang->line('package_amount'); ?></th>
										<th><?php echo $this->lang->line('date'); ?></th>
										<th></th>
									</thead>
									<tbody>
							    	<?php foreach($credit_purchase as $purchase): ?>
									<tr>
										<td><?php echo $purchase['credit_package_name']; ?></td>
										<td><?php echo $purchase['credit_package_credits']; ?></td>
										<td><?php echo $purchase['credit_package_amount']; ?></td>
										<td><?php echo convert_date_to_local($purchase['buy_credit_date'], SITE_DATETIME_FORMAT); ?></td>
										<td><?php if($purchase['credit_package_amount'] > 0 ) { ?><a target="_blank" href="<?php echo base_url('uploads/invoice/'.$purchase['transaction_id_ref'].'_credit_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a><?php } ?></td>
									</tr>	    	
									<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
							</div>							
			       		</div>

						<div class="col-sm-12">
							<div class="col-sm-2 well block_admin_dash">
								<?php if($user_row['user_is_vip'] == 'yes') { ?>
									<img src="<?php echo base_url('images/vip-user.png'); ?>" class="UserStImg" style="width: 50%;background:black;border-radius: 50%;" >
									<h4 class="basisUsr"><?php echo $this->lang->line('vip_user'); ?></h4>
								<?php } else { ?>
									<img src="<?php echo base_url('images/basis-usr-gold.png'); ?>" class="UserStImg" style="width: 50%;background:black;border-radius: 50%;" >
									<h4 class="basisUsr"><?php echo $this->lang->line('basis_user'); ?></h4>
								<?php } ?>
							</div>
							<div class="col-sm-10">
							<?php if(!empty($vip_purchase)): ?>
								<table class="table table-striped table-hover">
									<thead>
										<th><?php echo $this->lang->line('package_name'); ?></th>
										<th><?php echo $this->lang->line('validity_in_months'); ?></th>
										<th><?php echo $this->lang->line('package_amount'); ?></th>
										<th><?php echo $this->lang->line('date'); ?></th>
										<th></th>
									</thead>
									<tbody>
							    	<?php foreach($vip_purchase as $purchase): ?>
									<tr>
										<td><?php echo $purchase['vip_package_name']; ?></td>
										<td><?php echo $purchase['package_validity_in_months']; ?></td>
										<td><?php echo $purchase['vip_package_amount']; ?></td>
										<td><?php echo convert_date_to_local($purchase['buy_vip_date'], SITE_DATETIME_FORMAT); ?></td>
										<td><?php if($purchase['vip_package_amount'] > 0 ) { ?><a target="_blank" href="<?php echo base_url('uploads/invoice/'.$purchase['transaction_id_ref'].'_vip_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a><?php } ?></td>
									</tr>	    	
									<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
							</div>
						</div>

			       	</div>
				</div>
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading" role="tab" id="headingPhotos">
				<span class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsePhotos" aria-expanded="false" aria-controls="collapsePhotos">
						<?php echo $this->lang->line('photos'); ?> </a>
				</span>
				<div class="pull-right">
					<a class="collapsed text-white" data-toggle="collapse" data-parent="#accordion" href="#collapsePhotos" aria-expanded="false" aria-controls="collapsePhotos"><i class="fa fa-plus fa-lg"></i></a>
				</div>				
			</div>
			<div id="collapsePhotos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPhotos">
				<div id="photosBody" class="panel-body">
					<?php if (empty($user_photos)) { ?>
						<div class="alert alert-info"><?php echo $this->lang->line('no_photos_uploaded_so_far'); ?></div>
					<?php } else { ?>
						<div class="col-sm-12 make-box">
							<h3><?php echo $this->lang->line('profile').' '.$this->lang->line('photos'); ?></h3>
							<hr/>
							<div class="lightBoxGallery">
								<?php 
									foreach ($user_photos as $photo): 
										if($photo['photo_type'] == 'profile'):
								?>
									<div class="galleryItem">
										<div style="position: relative;">
											<img onclick="imagePreview('<?php echo base_url().$photo["photo_url"]; ?>');" class="img-thumbnail" src="<?php echo base_url() .$photo["photo_url"] ?>" style="cursor: pointer;" />

								            <?php if($photo["photo_status"] == 'deleted'): ?> 
								            <div class="deleted-stamp-at-images"><?php echo $this->lang->line($photo["photo_status"]); ?></div>
								        	<?php endif; ?>
										</div>
										<?php 
											$bg_status = "primary";
											if($photo["photo_status"] == 'active') {
												$bg_status = "success";
											} else if($photo["photo_status"] == 'deleted' || $photo["photo_status"] == 'blocked') {
												$bg_status = "danger";
											}
										?>
										<span class="badge badge-<?php echo $bg_status; ?> btn-block btn-sm text-uppercase">
											<?php echo $this->lang->line($photo["photo_status"]); ?>
										</span>
									</div>
								<?php 
										endif;
									endforeach;
								?>
							</div>
						</div>

						<div class="col-sm-12 make-box">
							<h3><?php echo $this->lang->line('vip').' '.$this->lang->line('photos'); ?></h3>
							<hr/>
							<div class="lightBoxGallery">
								<?php 
									foreach ($user_photos as $photo): 
										if($photo['photo_type'] == 'vip'):
								?>
									<div class="galleryItem">
										<div style="position: relative;">
											<img onclick="imagePreview('<?php echo base_url().$photo["photo_url"]; ?>');" class="img-thumbnail" src="<?php echo base_url() .$photo["photo_url"] ?>" style="cursor: pointer;" />	

								            <?php if($photo["photo_status"] == 'deleted'): ?> 
								            <div class="deleted-stamp-at-images"><?php echo $this->lang->line($photo["photo_status"]); ?></div>
								        	<?php endif; ?>
										</div>
										<?php 
											$bg_status = "primary";
											if($photo["photo_status"] == 'active') {
												$bg_status = "success";
											} else if($photo["photo_status"] == 'deleted' || $photo["photo_status"] == 'blocked') {
												$bg_status = "danger";
											}
										?>
										<span class="badge badge-<?php echo $bg_status; ?> btn-block btn-sm text-uppercase">
											<?php echo $this->lang->line($photo["photo_status"]); ?>
										</span>
									</div>
								<?php 
										endif;
									endforeach;
								?>
							</div>
						</div>

						<div class="col-sm-12 make-box">
							<h3><?php echo $this->lang->line('private').' '.$this->lang->line('photos'); ?></h3>
							<hr/>
							<div class="lightBoxGallery">
								<?php 
									foreach ($user_photos as $photo): 
										if($photo['photo_type'] == 'private'):
								?>
									<div class="galleryItem">
										<div style="position: relative;">
											<img onclick="imagePreview('<?php echo base_url().$photo["photo_url"]; ?>');" class="img-thumbnail" src="<?php echo base_url() .$photo["photo_url"] ?>" style="cursor: pointer;" />

								            <?php if($photo["photo_status"] == 'deleted'): ?> 
								            <div class="deleted-stamp-at-images"><?php echo $this->lang->line($photo["photo_status"]); ?></div>
								        	<?php endif; ?>
										</div>
										<?php 
											$bg_status = "primary";
											if($photo["photo_status"] == 'active') {
												$bg_status = "success";
											} else if($photo["photo_status"] == 'deleted' || $photo["photo_status"] == 'blocked') {
												$bg_status = "danger";
											}
										?>
										<span class="badge badge-<?php echo $bg_status; ?> btn-block btn-sm text-uppercase">
											<?php echo $this->lang->line($photo["photo_status"]); ?>
										</span>
									</div>
								<?php 
										endif;
									endforeach;
								?>
							</div>
						</div>				
					<?php } ?>
				</div>
			</div>
		</div>

		<?php if($user_row['user_status'] != 'active') { ?>			
		<div class="panel panel-success" style="border-color: #148c14;">
			<div class="panel-heading" role="tab" id="headingFour" style="background-color: #148c14;border-color: #0bb62b;">
				<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				<?php echo $this->lang->line('activate_user'); ?></a>
				</h4>
			</div>
			<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
				<div class="panel-body" style="text-align: center;">
					<a class="btn btn-success" href="<?php echo base_url(); ?>admin/users/activateUser?user_hash=<?php echo urlencode($user_row["user_id_encrypted"]); ?>"><?php echo $this->lang->line('activate_user_confirm_message'); ?></a>
				</div>
			</div>
		</div>
		<?php } ?>

		<?php if($user_row['user_status'] != 'blocked' && $user_row['user_status'] != 'deleted') { ?>
		<div class="panel panel-danger">
			<div class="panel-heading" role="tab" id="headingFive">
				<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				<?php echo $this->lang->line('block_user'); ?></a>
				</h4>
			</div>
			<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
				<div class="panel-body" style="text-align: center;">
					<a class="btn btn-danger" href="<?php echo base_url(); ?>admin/users/blockUser?user_hash=<?php echo urlencode($user_row["user_id_encrypted"]); ?>"><?php echo $this->lang->line('block_user_confirm_message'); ?></a>
				</div>
			</div>
		</div>
		<?php } ?>

		<?php if($user_row['user_status'] != 'deleted') { ?>
		<div class="panel panel-danger">
			<div class="panel-heading" role="tab" id="headingSeven">
				<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
				<?php echo $this->lang->line('delete_account'); ?></a>
				</h4>
			</div>
			<div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
				<div class="panel-body" style="text-align: center;">
					<a class="btn btn-danger btn-delete-user" href="<?php echo base_url(); ?>admin/users/deleteUser?user_hash=<?php echo urlencode($user_row["user_id_encrypted"]); ?>"><?php echo $this->lang->line('delete_account_confirm_message'); ?></a>
				</div>
			</div>
		</div>
		<?php } ?>

	</div>

</div>
<script data-path="/okdate/pixie" src="<?php echo base_url(); ?>pixie/pixie-integrate.js"></script>

<!-- Image Previev Modal -->
<div class="modal fade fade-in" id="userImagePreviewModal">
    <div class="modal-dialog" style="width: 90%;background-color: transparent;">
        <div class="modal-content" style="background-color: #111010;">
            <!-- Modal body -->
            <div class="modal-body">
            	<div class="cropper-img-container">
					<img id="prvImage">
				</div>
            </div>
            <div class="modal-footer" style="border: none;">
            	<div class="col-sm-12 text-center">
            		<div class="btn-group">
            			<button type="button" class="btn btn-primary" onclick="zoomImage(this)" data-option="0.1" title="Zoom In">
            				<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.zoom(0.1)">
            					<span class="fa fa-search-plus"></span>
            				</span>
            			</button>
            			<button type="button" class="btn btn-primary" onclick="zoomImage(this)" data-method="zoom" data-option="-0.1" title="Zoom Out">
            				<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.zoom(-0.1)">
            					<span class="fa fa-search-minus"></span>
            				</span>
            			</button>
            		</div>
            		<div class="btn-group">
            			<button type="button" onclick="moveImage(this)"  class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            				<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.move(-10, 0)">
            					<span class="fa fa-arrow-left"></span>
            				</span>
            			</button>
            			<button type="button"  onclick="moveImage(this)" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            				<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.move(10, 0)">
            					<span class="fa fa-arrow-right"></span>
            				</span>
            			</button>
            			<button type="button"  onclick="moveImage(this)" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            				<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.move(0, -10)">
            					<span class="fa fa-arrow-up"></span>
            				</span>
            			</button>
            			<button type="button"  onclick="moveImage(this)" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            				<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.move(0, 10)">
            					<span class="fa fa-arrow-down"></span>
            				</span>
            			</button>
            		</div>
            		<div class="btn-group">
            			<button type="button" onclick="rotateImage(this)" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
            				<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.rotate(-45)">
            					<span class="fa fa-undo"></span>
            				</span>
            			</button>
            			<button type="button"   onclick="rotateImage(this)" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
            				<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.rotate(45)">
            					<span class="fa fa-repeat"></span>
            				</span>
            			</button>
            		</div>  
            		<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-power-off"></span></button>

            	</div>

            </div>
        </div>
    </div>
</div>
<!-- Image Previev Modal -->

<script type="text/javascript">
	var cropper = null;

	function imagePreview(img_url) {
		// $("#prvTmpImage").attr('src', img_url);
		// var img_url = $("#prvImage").attr('src');
		$("#prvImage").attr('src', img_url);
		var width = $(window).width();
		var height = $(window).height();
		width = parseInt((width) - (width * 15 / 100));
		height = parseInt((height) - (height * 25 / 100));

		if(cropper != null) {
			cropper.destroy();
		}
		setTimeout(function(){
			var image = document.querySelector('#prvImage');
	      	cropper = new Cropper(image, {
	      		dragMode: 'move',
	      		aspectRatio: NaN,
	      		minContainerWidth: width,
	      		minContainerHeight: height,
				ready() {
				    cropper.clear();
				},
	      	});

			$("#userImagePreviewModal").modal('show');
		}, 500);

	}

	function zoomImage(obj) {
		var val = $(obj).attr('data-option');
		cropper.zoom(val);
	}

	function moveImage(obj) {
		var val1 = $(obj).attr('data-option');
		var val2 = $(obj).attr('data-second-option');
		cropper.move(val1, val2);
	}

	function rotateImage(obj) {
		var val = $(obj).attr('data-option');
		cropper.rotate(val);
	}

</script>
<?php
$this->load->view('templates/footers/admin_footer');
?>