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
                <strong><?php echo ucfirst($this->lang->line('credits')); ?></strong>
            </li>
        </ol>
    </div>
</div>

<div class="col-lg-12 block_form">
    <div class="ibox-content-no-bg">
		<div class="clearfix clearfix_mobile_class">
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
	    		$sr_no = $offset + 1;
	    		foreach($credit_purchase as $purchase):
			?>
			<tr>
				<td><?php echo $sr_no++; ?></td>
				<td><?php echo $purchase['user_access_name']; ?></td>
				<td><?php echo $purchase['credit_package_name']; ?></td>
				<td><?php echo $purchase['credit_package_credits']; ?></td>
				<td><?php echo $purchase['credit_package_amount']; ?></td>
				<td><?php echo $purchase['invoice_number']; ?></td>
				<td><?php echo convert_date_to_local($purchase['buy_credit_date'], SITE_DATETIME_FORMAT); ?></td>				
				<td><?php if($purchase['credit_package_amount'] > 0 ) { ?>
					<!-- <a target="_blank" href="<?php // echo base_url('admin/purchases/invoiceCredit/'.$purchase['buy_credit_id'].'/credit_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a> -->
					<button data-toggle="modal" data-target="#show_bills_of_user_credit" buy-purchased-credit-id="<?php echo $purchase['buy_credit_id'] ?>" class='generate_pdfs_for_all_bill_of_user'><i class="fa fa-file-pdf-o"></i></button>
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
<?php
$this->load->view('templates/footers/admin_footer');
?>