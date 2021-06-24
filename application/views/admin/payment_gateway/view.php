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
                <strong><?php echo $this->lang->line('payment_gateway'); ?></strong>
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
		<div class="table-responsive">
	    <?php 
	    	if(!empty($gateways)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('name'); ?></th>
					<th><?php echo $this->lang->line('client_id'); ?></th>
					<th><?php echo $this->lang->line('access_token'); ?></th>
					<th><?php echo $this->lang->line('currency'); ?></th>
					<th><?php echo $this->lang->line('url'); ?></th>
					<th><?php echo $this->lang->line('mode'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($gateways as $grow):
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $grow['payment_gateway_name']; ?></td>
				<td style="word-break: break-all;"><?php echo $grow['client_id']; ?></td>
				<td style="word-break: break-all;"><?php echo $grow['client_acces_token']; ?></td>
				<td><?php echo $grow['currency']; ?></td>
				<td><?php echo $grow['url']; ?></td>
				<td>
					<?php 
					if($grow['mode'] == 'live') {						
						$mode_status = 'badge-success';
					} else {
						$mode_status = 'badge-danger';
					}
					echo '<span class="badge '.$mode_status.'">'.$this->lang->line($grow['mode']).'</span>'; 
					?>					
				</td>
				<td>
					<?php 
					if($grow['status'] == 'active') {						
						$plan_status = 'badge-success';
					} else {
						$plan_status = 'badge-danger';
					}
					echo '<span class="badge '.$plan_status.'">'.$this->lang->line($grow['status']).'</span>'; 
					?>					
				</td>
				<td><a href="<?php echo base_url('admin/payment_gateway/edit/').$grow['gateway_id']; ?>"><i class="fa fa-edit"></i> <?php echo $this->lang->line('edit'); ?></a></td>
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