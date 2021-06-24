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
                <strong><?php echo $this->lang->line('purchases'); ?></strong>
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
			<div class="col-md-4">
				<div class="well block_admin_dash">
					<i class="fa fa-list"></i>
					<div class="desc_admin_block">
						<b><?php echo $total_vip_collected_amount; ?> €</b>
						<br />
						<?php echo $this->lang->line('total_vip_amount'); ?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well block_admin_dash">
					<i class="fa fa-diamond"></i>
					<div class="desc_admin_block">
						<b><?php echo $total_credit_collected_amount; ?> €</b>
						<br />
						<?php echo $this->lang->line('total_credit_amount'); ?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well block_admin_dash">
					<i class="fa fa-database"></i>
					<div class="desc_admin_block">
						<b><?php echo $total_diamond_collected_amount; ?> €</b>
						<br />
						<?php echo $this->lang->line('total_diamond_amount'); ?>
					</div>
				</div>
			</div>
		</div>

    	<div class="row">
    		<div class="col-lg-12 text-center">
	    	<form class="form-inline" method="POST" action="<?php echo base_url('admin/purchases/report'); ?>">
				<div class="form-group">
					<?php 						
						$report_by_opt = array(
					        ''	=> $this->lang->line('all'),
					        'by_date'	=> $this->lang->line('by_date')
						);

						echo form_dropdown('report_by', $report_by_opt, 'all', 'class="form-control" onChange="showDate(this);"');
					?>
				</div>

				<div class="form-group by_dates" style="display: none;">
		    		<input type="text" name="start_date" value="" class="form-control datepicker" placeholder="Select Start Date" />
				</div>

				<div class="form-group by_dates" style="display: none;">
		    		<input type="text" name="end_date" value="" class="form-control datepicker" placeholder="Select End Date" />
				</div>

				<div class="form-group">
					<?php 						
						$report_category_opt = array(
					        ''	=> $this->lang->line('all'),
					        'credit'	=> $this->lang->line('credit'),
					        'vip'	=> $this->lang->line('vip'),
					        'diamond'	=> $this->lang->line('diamond')
						);

						echo form_dropdown('report_category', $report_category_opt, '', 'class="form-control"');
					?>
				</div>

				<div class="form-group">
					<?php 						
						$report_type_opt = array(
					        'pdf'	=> $this->lang->line('pdf'),
					        'csv'	=> $this->lang->line('csv')
						);

						echo form_dropdown('report_type', $report_type_opt, 'pdf', 'class="form-control"');
					?>
				</div>
				<button type="submit" class="btn btn-success" style="border-radius: 5px;padding: 6px 20px;margin-left: 10px;"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></button>
	    	</form>
	    	</div>
    	</div>
    	<hr/>

		<div class="clearfix well clearfix_mobile_class">
		<fieldset>
			<legend><i class="fa fa-list"></i> <?php echo $this->lang->line('recent_vip_purchase'); ?></legend>
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
	    		$sr_no = 1;
	    		foreach($vip_purchase as $purchase):
	    			$currency = 'Euro';
	    			$curdate=strtotime('2021-03-17');
					$mydate=strtotime($purchase['buy_vip_date']);
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
					<?php if($purchase['vip_package_amount'] > 0 ) { ?>
						<!-- <a target="_blank" href="<?php // echo base_url('admin/purchases/invoiceVIP/'.$purchase['buy_vip_id'].'/vip_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a> -->
						<button data-toggle="modal" data-target="#show_bills_of_user" buy-purchased-vip-id="<?php echo $purchase['buy_vip_id'] ?>" class='generate_pdfs_for_all_vip_bill_of_user'><i class="fa fa-file-pdf-o"></i></button>
					<?php } ?>
				</td>
<!-- 				<td><?php if($purchase['vip_package_amount'] > 0 ) { ?><a target="_blank" href="<?php echo base_url('uploads/invoice/'.$purchase['transaction_id_ref'].'_vip_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a><?php } ?></td> -->
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
				<tfoot>
					<td colspan="5"></td>
					<td><a href="<?php echo base_url('admin/purchases/vip'); ?>"><?php echo $this->lang->line('view_all'); ?> >></a></td>
				</tfoot>
			</table>
			<?php
			else:
			?>
			<div class="alert alert-info">
				<?php echo $this->lang->line('no_one_found'); ?>					
			</div>
			<?php
			endif;
			?>
		</fieldset>
		</div>

		<div class="clearfix well clearfix_mobile_class">
		<fieldset>
			<legend><i class="fa fa-database"></i> <?php echo $this->lang->line('recent_credit_purchase'); ?></legend>
	    <?php 
	    	if(!empty($credit_purchase)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('name'); ?></th>
					<th><?php echo $this->lang->line('package_name'); ?></th>
					<th><?php echo $this->lang->line('package_credits'); ?></th>
					<th><?php echo $this->lang->line('package_amount'); ?></th>
					<th><?php echo $this->lang->line('invoice_number'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
					<th></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($credit_purchase as $purchase):
	    			$currency = 'Euro';
	    			$curdate=strtotime('2021-03-17');
					$mydate=strtotime($purchase['buy_credit_date']);
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
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $purchase['user_access_name']; ?></td>
				<td><?php echo $purchase['credit_package_name']; ?></td>
				<td><?php echo $purchase['credit_package_credits']; ?></td>
				<td>
					<?php
				 		echo $currency . " " . $purchase['credit_package_amount'];
				 	?>
			 	</td>
				<td><?php echo $purchase['invoice_number']; ?></td>
				<td><?php echo convert_date_to_local($purchase['buy_credit_date'], SITE_DATETIME_FORMAT); ?></td>
				<td><?php if($purchase['credit_package_amount'] > 0 ) { ?>
					<!-- <a target="_blank" href="<?php //echo base_url('admin/purchases/invoiceCredit/'.$purchase['buy_credit_id'].'/credit_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a> -->
					<button data-toggle="modal" data-target="#show_bills_of_user_credit" buy-purchased-credit-id="<?php echo $purchase['buy_credit_id'] ?>" class='generate_pdfs_for_all_bill_of_user'><i class="fa fa-file-pdf-o"></i></button>
				<?php } ?>
				</td>
				<!-- <td><?php if($purchase['credit_package_amount'] > 0 ) { ?><a target="_blank" href="<?php echo base_url('uploads/invoice/'.$purchase['transaction_id_ref'].'_credit_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a><?php } ?></td> -->
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
				<tfoot>
					<td colspan="5"></td>
					<td><a href="<?php echo base_url('admin/purchases/credit'); ?>"><?php echo $this->lang->line('view_all'); ?> >></a></td>
				</tfoot>
			</table>
			<?php
			else:
			?>
			<div class="alert alert-info">
				<?php echo $this->lang->line('no_one_found'); ?>					
			</div>
			<?php
			endif;
			?>
		</fieldset>
		</div>

		<div class="clearfix well">
		<fieldset>
		<legend><i class="fa fa-diamond"></i> <?php echo $this->lang->line('recent_diamond_purchase'); ?></legend>
	    <?php 
	    	if(!empty($diamond_purchase)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('name'); ?></th>
					<th><?php echo $this->lang->line('package_name'); ?></th>
					<th><?php echo $this->lang->line('package_diamonds'); ?></th>
					<th><?php echo $this->lang->line('package_amount'); ?></th>
					<th><?php echo $this->lang->line('date'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($diamond_purchase as $purchase):
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $purchase['user_access_name']; ?></td>
				<td><?php echo $purchase['diamond_package_name']; ?></td>
				<td><?php echo $purchase['diamond_package_diamonds']; ?></td>
				<td><?php echo $purchase['diamond_package_amount']; ?></td>
				<td><?php echo convert_date_to_local($purchase['buy_diamond_date'], SITE_DATETIME_FORMAT); ?></td>
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
				<tfoot>
					<td colspan="5"></td>
					<td><a href="<?php echo base_url('admin/purchases/diamond'); ?>"><?php echo $this->lang->line('view_all'); ?> >></a></td>
				</tfoot>
			</table>
			<?php
			else:
			?>
			<div class="alert alert-info">
				<?php echo $this->lang->line('no_one_found'); ?>					
			</div>
			<?php
			endif;
			?>
		</fieldset>
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
<!-- Modal -->
<div class="modal fade" id="show_bills_of_user_credit" tabindex="-1" role="dialog" aria-labelledby="show_bills_of_ser_buy_credit" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="show_bills_of_user_title">
        	<?php
        		echo $this->lang->line('all_credits_bill_for');
        	?>
        	<span class='user_name_all_bill'></span> 
      	</h5>
      </div>
      <div class="modal-body content_all_credits_pdf clearfix_mobile_class">
        
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
<script type="text/javascript">
	function showDate(obj) {
		if(obj.value == 'by_date') {
			$('.by_dates').show();
		} else {
			$('.by_dates').hide();
		}
	}
</script>
<?php
$this->load->view('templates/footers/admin_footer');
?>