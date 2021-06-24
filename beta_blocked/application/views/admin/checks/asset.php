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
                <a href="<?php echo base_url('admin/checks'); ?>"><?php echo $this->lang->line('checks'); ?></a>
            </li>                        
            <li class="active">
                <strong><?php echo ucfirst($this->lang->line('asset_check')); ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-5">
	    <form class="form-inline" method="GET" action="<?php echo base_url('admin/checks/asset'); ?>">
		    <div class="btn_filter_placeholder">
				<div class="form-group">
					<?php 
						$search_by_status = (isset($_GET['status']))? $_GET['status'] : '';

						$status_options = array(
					        ''			=> $this->lang->line('select_status'),
					        'pending'	=> $this->lang->line('pending'),
					        'verified'	=> $this->lang->line('verified'),
					        'rejected'	=> $this->lang->line('rejected'),
					        'deleted'	=> $this->lang->line('deleted')
						);

						echo form_dropdown('status', $status_options, $search_by_status, 'class="form-control"');
					?>
				</div>
				<button type="submit" name="btn-search" value="reality" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
		    </div>
	    </form>    	
    </div>    
</div>

<div class="col-lg-12 block_form">
    <div class="ibox-content-no-bg">
		<div class="clearfix table-responsive">
	    <?php 
	    	if(!empty($documents)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th></th>
					<th><?php echo $this->lang->line('document'); ?></th>
					<th><?php echo $this->lang->line('user_verified'); ?></th>					
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>					
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($documents as $approval):
	    			if($approval["user_active_photo_thumb"] == '') {
	    				$approval['user_active_photo_thumb'] = "images/avatar/".$approval['user_gender'].".png";
	    			}
			?>
			<tr data-id="<?php echo $approval['document_id']; ?>">
				<td><?php echo $sr_no++; ?></td>
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
				<td class="userStatus">
					<?php 
					if($approval['user_verified'] == 'yes') {
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($approval['user_verified']).'</span>'; 
					?>															
				</td>				
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
				<td class="userAction">
					<?php if($approval['document_status'] == 'pending') { 
							if($approval['user_verified'] == 'no') { ?>
						<button data-id = 'verified' class="btn btn-success btn-sm btn-block btn-verify-asset-document" style="padding: 2px 15px;"><?php echo $this->lang->line('verify'); ?></button>					
						<button data-id = 'rejected' class="btn btn-danger btn-sm btn-block btn-verify-asset-document" style="padding: 2px 15px;"><?php echo $this->lang->line('reject'); ?></button>
					<?php } else { ?>
						<button data-id = 'deleted' class="btn btn-danger btn-sm btn-block btn-verify-asset-document" style="padding: 2px 15px;"><?php echo $this->lang->line('delete'); ?></button>
					<?php } } ?>					
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
<?php
$this->load->view('templates/footers/admin_footer');
?>