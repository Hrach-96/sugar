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
                <strong><?php echo $this->lang->line('manage_country'); ?></strong>
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
	    	if(!empty($countries)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('country'); ?></th>
					<th><?php echo $this->lang->line('abbreviation'); ?></th>
					<th><?php echo $this->lang->line('currency_iso_code'); ?></th>
					<th><?php echo $this->lang->line('currency_symbol'); ?></th>
					<th><?php echo $this->lang->line('language'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($countries as $country):
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $this->lang->line($country['country_name']); ?></td>
				<td><?php echo $country['country_abbr']; ?></td>
				<td><?php echo $country['country_currency_iso_code']; ?></td>
				<td><?php echo $country['country_currency_html_code'].' / '.$country['country_currency_text']; ?></td>
				<td><?php echo $this->lang->line($country['language_name']); ?></td>
				<td>
					<?php 
					if($country['country_status'] == 'active') {
						$country_status = 'badge-success';
					} else {
						$country_status = 'badge-danger';
					}
					echo '<span class="badge '.$country_status.'">'.$this->lang->line($country['country_status']).'</span>'; 
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