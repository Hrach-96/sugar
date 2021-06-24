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
		<div class="clearfix clearfix_mobile_class">
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
					<th><?php echo $this->lang->line('invoice_number'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
					<th></th>
				</thead>
				<tbody>
	    	<?php
	    		$sr_no = $offset + 1;
	    		foreach($vip_purchase as $purchase):
	    			$curdate = strtotime('2021-03-17');
					$mydate = strtotime($purchase['buy_vip_date']);
					$currency = 'Euro';
					if($purchase['currency'] == ''){
						if($curdate < $mydate)
						{
							if($purchase['user_country'] == 'Switzerland' || $purchase['user_country'] == 'Schweiz'){
								$currency = 'CHF';
							}
							else if($purchase['user_country'] == 'United Kingdom'){
								$currency = 'GBP';
							}
						}
					}
					else{
						$currency = $purchase['currency'];
					}
	    			$showCancelVip = false;
	    			$eixstCancel = $this->vip_package_model->get_cancel_vip_exist($purchase['buy_vip_id']);
	    			if($eixstCancel){
	    				$canceled_date = strtotime(explode(' ' , $purchase['buy_vip_date'])[0]);
						$buy_date = strtotime($eixstCancel->canceled_date);
						$datediff = $buy_date - $canceled_date;
						$days = round($datediff / (60 * 60 * 24));
						if($days >= 0 && $days < 14){
							$showCancelVip = true;
						}
	    			}
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $purchase['user_access_name']; ?></td>
				<td><?php echo $purchase['vip_package_name']; ?></td>
				<td>
					<?php
						echo $purchase['package_validity_in_months'];
						if($showCancelVip){
		    				?>
		    					<div style='z-index:999' class="online_status canceled-vip-in-table"><?php echo $this->lang->line('vip_cancel'); ?>
		    						<br>
		    						<small><?php echo convert_date_to_local($eixstCancel->canceled_date, SITE_DATETIME_FORMAT); ?></small>
		    					</div>
		    				<?php
		    			}
					?>
				</td>
				<td><?php echo $currency . " " . $purchase['vip_package_amount']; ?></td>
				<td><?php echo $purchase['invoice_number']; ?></td>				
				<td><?php echo convert_date_to_local($purchase['buy_vip_date'], SITE_DATETIME_FORMAT); ?></td>				
				<td>
					<?php
						if($purchase['vip_package_amount'] > 0 ) {
					?>
						<!-- <a target="_blank" href="<?php //echo base_url('admin/purchases/invoiceVIP/'.$purchase['buy_vip_id'].'/vip_purchase.pdf'); ?>">
							<i class="fa fa-file-pdf-o"></i>
						</a> -->
						<button data-toggle="modal" data-target="#show_bills_of_user" buy-purchased-vip-id="<?php echo $purchase['buy_vip_id'] ?>" class='generate_pdfs_for_all_vip_bill_of_user'><i class="fa fa-file-pdf-o"></i></button>
					<?php
						}
					?>
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
<div class="modal fade" id="show_bills_of_user" tabindex="-1" role="dialog" aria-labelledby="show_bills_of_ser_buy" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="show_bills_of_user_title">
        	<?php
        		echo $this->lang->line('all_vip_bill_for');
        	?>
        	<span class='user_name_all_bill'></span> 
      	</h5>
      </div>
      <div class="modal-body content_all_vips_pdf clearfix_mobile_class">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
        	<?php
        		echo $this->lang->line('close');
        	?>
        </button>
      </div>
    </div>
  </div>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>