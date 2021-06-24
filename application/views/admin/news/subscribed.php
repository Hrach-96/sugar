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
    <div class="col-lg-3">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('news'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-9">
	    <form class="form-inline" method="GET" action="<?php echo base_url('admin/news'); ?>">
		    <div class="btn_filter_placeholder">
				<div class="form-group">
		    		<input type="text" name="email" value="<?php echo isset($_GET['email'])?$_GET['email']:''; ?>" class="form-control form-email" placeholder="<?php echo $this->lang->line('search_by_email'); ?>" />
				</div>
				<button type="submit" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
		    </div>
	    </form>
    </div>
    <div class="row">
		<div class="col-lg-2">
			<select name='type' class='form-control type_of_file'>
				<option value='pdf'>pdf</option>
				<option value='csv'>csv</option>
			</select>
    	</div>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-success btn_download_news_current_list" style="border-radius: 5px;padding: 6px 20px;margin-left: 10px;"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></button>
		</div>
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
    			<a href="<?php echo base_url('admin/news/addNews'); ?>" class="btn btn-success" style="border-radius: 5px;padding: 4px 20px;"><?php echo $this->lang->line('create_news'); ?></a>
    		</div>
    	</div>
    	</div>
    	<hr/>    	
		<div class="clearfix clearfix_mobile_class">
	    <?php 
	    	if(!empty($users)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('email_address'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>		
					<th><?php echo $this->lang->line('date'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		$current_list_ids = '';
	    		foreach($users as $key=>$user_row):
	    			if($key == 0){
	    				$current_list_ids.= $user_row['news_subscriber_id'];
	    			}
	    			else{
	    				$current_list_ids.= "," . $user_row['news_subscriber_id'];
	    			}
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $user_row['news_subscriber_email']; ?></td>
				<td>
					<?php 
					if($user_row['news_subscriber_status'] == 'subscribed') {
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($user_row['news_subscriber_status']).'</span>'; 
					?>									
				</td>
				<td><?php echo convert_date_to_local($user_row['news_subscriber_added_date'], SITE_DATETIME_FORMAT); ?></td>
				<td style='text-align:center'>
					<a href="<?php echo base_url('admin/news/remove_email/'.$user_row['news_subscriber_id']); ?>" class='text-danger'><i class="fa fa-remove"></i><br> <?php echo $this->lang->line('delete'); ?></a>
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

			<input type='hidden' class='current_list_ids' value="<?php echo $current_list_ids?>" >
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