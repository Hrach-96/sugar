<?php
$this->load->view('templates/headers/agent_header', $title);
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
                <a href="javascript:void(0);"><?php echo $this->lang->line('agent'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo ucfirst($this->lang->line('image_approvals')); ?></strong>
            </li>
        </ol>
    </div>
</div>

<div class="col-lg-12 block_form">
    <div class="ibox-content-no-bg">
		<div class="clearfix table-responsive" id="container">
	    <?php 
	    	if(!empty($approvals)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('picture_type'); ?></th>
					<th><?php echo $this->lang->line('picture'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>					
				</thead>
				<tbody>
	    	<?php
	    		foreach($approvals as $approval):
	    			if($approval["user_active_photo_thumb"] == '') {
	    				$approval['user_active_photo_thumb'] = "images/avatar/".$approval['user_gender'].".png";
	    			}
			?>
			<tr data-id="<?php echo $approval['photo_id']; ?>">
				<td>
					<center>
					<a href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($approval["user_id_encrypted"]); ?>">
						<img style="width:78px;height:78px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $approval["user_active_photo_thumb"]; ?>" />
						<br/>
						<?php echo $approval['user_access_name']; ?>
					</a>
					</center>					
				</td>
				<td><?php echo $this->lang->line($approval['photo_type']); ?></td>
				<td>
					
					<img style="width:178px;height:178px;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $approval["photo_thumb_url"]; ?>" />

					<button class="btn btn-default" onclick="imagePreview('<?php echo base_url().$approval["photo_url"]; ?>');"><i class="fa fa-desktop"></i></button>
				</td>
				<td class="photoStatus">
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
				<td class="userAction">
					<?php if($approval['photo_status'] == 'inactive') { ?>
					<button data-id = 'active' class="btn btn-success btn-sm btn-block btn-approve-image" style="padding: 2px 15px;"><?php echo $this->lang->line('approve'); ?></button>
					<button data-id = 'blocked' class="btn btn-danger btn-sm btn-block btn-approve-image" style="padding: 2px 15px;"><?php echo $this->lang->line('reject'); ?></button>
					<?php } ?>
				</td>				
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
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
    </div>
</div>

<!-- Image Previev Modal -->
<div class="modal fade fade-in" id="userImagePreviewModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
				<img id="prvImage" style="width:100%;height:100%;object-fit:cover;" src="" />
            </div>
        </div>
    </div>
</div>
<!-- Image Previev Modal -->

<script type="text/javascript">
	var images_checked = 0;
	var total_images = <?php echo (empty($approvals))?'0':count($approvals); ?>;

	function imagePreview(img_url) {
		$("#prvImage").attr('src', img_url);
		$("#userImagePreviewModal").modal('show');
	}
</script>

<?php
$this->load->view('templates/footers/agent_footer');
?>