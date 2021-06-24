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
                <strong><?php echo $this->lang->line('manage_languages'); ?></strong>
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
		<div class="clearfix">
	    <?php 
	    	if(!empty($languages)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('language'); ?></th>
					<th><?php echo $this->lang->line('used_for_website'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>			
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($languages as $language):
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $this->lang->line($language['language_name']); ?></td>
				<td>
					<?php 
					if($language['used_for_website'] == 'yes') {
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($language['used_for_website']).'</span>'; 
					?>									
				</td>
				<td>
					<?php 
					if($language['language_status'] == 'active') {
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($language['language_status']).'</span>'; 
					?>									
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

		</div>
    </div>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>