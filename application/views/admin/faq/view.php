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
                <strong><?php echo $this->lang->line('faq'); ?></strong>
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
		<div class="clearfix clearfix_mobile_class">
	    <?php 
	    	if(!empty($messages)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('name'); ?></th>
					<th><?php echo $this->lang->line('email_address'); ?></th>
					<th><?php echo $this->lang->line('phone_number'); ?></th>
					<th><?php echo $this->lang->line('questions'); ?></th>		
					<th><?php echo $this->lang->line('message_date'); ?></th>
					<th><?php echo $this->lang->line('reply'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>					
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($messages as $message):
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $message['full_name']; ?></td>
				<td><?php echo $message['email_address']; ?></td>
				<td><?php echo $message['phone_number']; ?></td>
				<td><?php echo $message['question']; ?></td>				
				<td><?php echo convert_date_to_local($message['faq_added_date'], SITE_DATETIME_FORMAT); ?></td>
				<td><?php echo $message['faq_reply_text']; ?></td>
				<td><a href="<?php echo base_url('admin/faq/reply/'.$message['faq_id']); ?>"><i class="fa fa-reply"></i> <?php echo $this->lang->line('reply'); ?></a></td>
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