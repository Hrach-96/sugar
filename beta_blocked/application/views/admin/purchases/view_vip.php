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
            <li>
                <a href="<?php echo base_url('admin/purchases'); ?>"><?php echo $this->lang->line('purchases'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('vip'); ?></strong>
            </li>
        </ol>
    </div>
</div>

<div class="col-lg-12 block_form">
    <div class="ibox-content-no-bg">
		<div class="clearfix">
	    <?php 
	    	if(!empty($vip_purchase)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('name'); ?></th>
					<th><?php echo $this->lang->line('package_name'); ?></th>
					<th><?php echo $this->lang->line('validity_in_months'); ?></th>
					<th><?php echo $this->lang->line('package_amount'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
					<th></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($vip_purchase as $purchase):
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $purchase['user_access_name']; ?></td>
				<td><?php echo $purchase['vip_package_name']; ?></td>
				<td><?php echo $purchase['package_validity_in_months']; ?></td>
				<td><?php echo $purchase['vip_package_amount']; ?></td>
				<td><?php echo convert_date_to_local($purchase['buy_vip_date'], SITE_DATETIME_FORMAT); ?></td>
				<td><?php if($purchase['vip_package_amount'] > 0 ) { ?><a target="_blank" href="<?php echo base_url('uploads/invoice/'.$purchase['transaction_id_ref'].'_vip_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a><?php } ?></td>
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