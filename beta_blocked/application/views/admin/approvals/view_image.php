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
    <div class="col-lg-7">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/approvals'); ?>"><?php echo $this->lang->line('approvals'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo ucfirst($this->lang->line('image')); ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-5">
	    <form class="form-inline" method="GET" action="<?php echo base_url('admin/approvals/image'); ?>">
		    <div class="btn_filter_placeholder">
				<div class="form-group">
					<?php 
						$type_options = array(
					        ''			=> $this->lang->line('select_type'),
					        'profile'	=> $this->lang->line('profile'),
					        'vip'	=> $this->lang->line('vip'),
					        'private'	=> $this->lang->line('private')
						);

						echo form_dropdown('type', $type_options, $profile_type, 'class="form-control"');
					?>
				</div>
				<div class="form-group">
					<?php 
						$status_options = array(
					        ''			=> $this->lang->line('select_status'),
					        'inactive'	=> $this->lang->line('pending'),
					        'active'	=> $this->lang->line('approved'),
					        'blocked'	=> $this->lang->line('blocked'),
					        'deleted'	=> $this->lang->line('deleted')
						);

						echo form_dropdown('status', $status_options, $search_by_status, 'class="form-control"');
					?>
				</div>
				<button type="submit" name="btn-search" value="image" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
		    </div>
	    </form>
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
					<th></th>
					<th><?php echo $this->lang->line('picture_type'); ?></th>
					<th><?php echo $this->lang->line('picture'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>					
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($approvals as $approval):
	    			if($approval["user_active_photo_thumb"] == '') {
	    				$approval['user_active_photo_thumb'] = "images/avatar/".$approval['user_gender'].".png";
	    			}
			?>
			<tr data-id="<?php echo $approval['photo_id']; ?>">
				<td><?php echo $sr_no++; ?></td>
				<td>
					<center>
					<a href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($approval["user_id_encrypted"]); ?>">
						<img style="width:78px;height:78px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $approval["user_active_photo_thumb"]; ?>" />
						<br/>
						<?php echo $approval['user_access_name']; ?>
			            <?php if($approval["user_status"] == 'deleted'): ?> 
			            <div class="deleted-stamp-profile-icon"><?php echo $this->lang->line($approval["user_status"]); ?></div>
			        	<?php endif; ?>
					</a>
					</center>					
				</td>
				<td><?php echo $this->lang->line($approval['photo_type']); ?></td>
				<td>
					
					<img id="profile-image-<?php echo $approval['photo_id']; ?>" style="width:178px;height:178px;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $approval["photo_url"]; ?>" />

					<button class="btn btn-default" onclick="imagePreview('<?php echo base_url().$approval["photo_url"]; ?>', <?php echo $approval['photo_id']; ?>);"><i class="fa fa-desktop"></i></button>

		            <?php if($approval["photo_status"] == 'deleted'): ?> 
		            <div class="deleted-stamp-for-image"><?php echo $this->lang->line($approval["photo_status"]); ?></div>
		        	<?php endif; ?>					
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
    <div class="modal-dialog" style="width: 90%;background-color: transparent;">
        <div class="modal-content" style="background-color: #111010;">
            <!-- Modal body -->
            <input type="hidden" id="edit_picture_id" name="edit_picture_id" value="">
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
            		<button type="button" onclick="saveImage();" class="btn btn-success" data-dismiss="modal"><span class="fa fa-save"></span></button>
            		<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-power-off"></span></button>

            	</div>

            </div>
        </div>
    </div>
</div>
<!-- Image Previev Modal -->

<script type="text/javascript">
	var cropper = null;
	var selected_image_id = null;

	function imagePreview(img_url, image_id) {
		// $("#prvTmpImage").attr('src', img_url);
		// var img_url = $("#prvImage").attr('src');
		$("#prvImage").attr('src', img_url);
		selected_image_id = image_id;

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

	function saveImage() {

        var canvas;
        var imgURL = $("#prvImage").attr('src');

        if(cropper) {
			canvas = cropper.getCroppedCanvas({
				// width: 1600,
				// height: 1200,
			});

          	canvas.toBlob(function (blob) {
	            var formImageData = new FormData();
	            var url =  "<?php echo base_url('admin/approvals/updatePicture'); ?>";

	            formImageData.append('url', imgURL);
	            formImageData.append('file', blob, 'profilepic.jpg');

	            $.ajax(url, {
	              	method: 'POST',
	              	data: formImageData,
	              	processData: false,
	              	contentType: false,
	              	success: function (data) {
	              		$("#profile-image-" + selected_image_id).attr('src', imgURL + '?v1');
  	              		//location.reload();
	                	//$cropperalert.show().html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message);
	              	},
	              	error: function () {
	              		//location.reload();
	                	//$cropperalert.show().html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message);
	              	},
	              	complete: function () {
	                	//location.reload();
	              	},
	            });
          	});
        }		
	}
</script>
<?php
$this->load->view('templates/footers/admin_footer');
?>