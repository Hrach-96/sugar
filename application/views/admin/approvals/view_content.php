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
                <strong><?php echo ucfirst($this->lang->line('content')); ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-5">
	    <form class="form-inline" method="GET" action="<?php echo base_url('admin/approvals/content'); ?>">
		    <div class="btn_filter_placeholder">
				<div class="form-group">
					<?php 
						$status_options = array(
					        ''			=> $this->lang->line('select_status'),
					        'pending'	=> $this->lang->line('pending'),
					        'approved'	=> $this->lang->line('approved'),
					        'rejected'	=> $this->lang->line('rejected')
						);

						echo form_dropdown('status', $status_options, $search_by_status, 'class="form-control"');
					?>
				</div>
				<button type="submit" name="btn-search" value="content" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
		    </div>
	    </form>
    </div>    
</div>

<div class="col-lg-12 block_form">
    <div class="ibox-content-no-bg">
		<div class="clearfix table-responsive">
	    <?php 
	    	if(!empty($approvals)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th></th>
					<th><?php echo $this->lang->line('content_type'); ?></th>
					<th><?php echo $this->lang->line('content'); ?></th>
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
			<tr data-id="<?php echo $approval['content_id']; ?>">
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
				<td style='white-space:initial'><?php echo " <a target='_blank' href='https://translate.google.com/?sl=en&tl=de&text=" . preg_replace('/\s+/', '%20', $approval['content_text']) . "&op=translate'>" . $approval['content_text'] . "</a>"; ?></td>
				<td class="contentStatus">
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
				<td class="userAction">
					<?php if($approval['content_status'] == 'pending') { ?>
					<button data-id = 'approved' class="btn btn-success btn-sm btn-block btn-approve_content" style="padding: 2px 15px;"><?php echo $this->lang->line('approve'); ?></button>
					<button data-id = 'rejected' class="btn btn-danger btn-sm btn-block btn-approve_content" style="padding: 2px 15px;"><?php echo $this->lang->line('reject'); ?></button>
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
<?php
$this->load->view('templates/footers/admin_footer');
?>