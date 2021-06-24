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
    <div class="col-lg-12">
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
		<div class="clearfix">
	    <?php 
	    	if(!empty($users)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('email_address'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>		
					<th><?php echo $this->lang->line('date'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($users as $user_row):
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