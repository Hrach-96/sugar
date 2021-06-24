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
	.count_of_buyed_credits{
		background: black;
	    border-radius: 50%;
	    height: 26px;
	    width: 26px;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	    color: #fff;
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
                <strong><?php echo $this->lang->line('purchases_credit'); ?></strong>
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
			<div class="row">
	    		<div class="col-lg-12 text-center">
		    	<form class="form-inline" method="POST" action="<?php echo base_url('admin/credit/reportHistory'); ?>">
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

	    <?php 
	    	if(!empty($users)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th></th>
					<th><?php echo $this->lang->line('email_address'); ?></th>
					<th><?php echo $this->lang->line('country'); ?></th>		
					<th><?php echo $this->lang->line('location'); ?></th>
					<th><?php echo $this->lang->line('free_credits'); ?></th>	
					<th><?php echo $this->lang->line('date'); ?></th>
					<th><?php echo $this->lang->line('invoice_number'); ?></th>
					<th><?php echo $this->lang->line('quantity'); ?></th>
					<th><?php echo $this->lang->line('action'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($users as $user):
	    			if($user["user_active_photo_thumb"] == '') {
	    				$user['user_active_photo_thumb'] = "images/avatar/".$user['user_gender'].".png";
	    			}
	    			$buyed_credits = $this->credit_package_model->get_count_of_buyed_credits_for_user($user['purchased_user_id']);
				?>
				<tr>
					<td><?php echo $sr_no++; ?></td>
					<td>
						<center>
						<a href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($user['user_id_encrypted']); ?>">
							<img style="width:78px;height:78px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $user['user_active_photo_thumb']; ?>" />
							<br/>
							<?php echo $user['user_access_name']; ?>
				            <?php if($user["user_status"] == 'deleted'): ?> 
				            <div class="deleted-stamp-profile-icon"><?php echo $this->lang->line($user["user_status"]); ?></div>
				        	<?php endif; ?>
						</center>
						</a>
					</td>				
					<td><?php echo $user['user_email']; ?></td>
					<td><?php echo $user['user_country']; ?></td>
					<td><?php echo $user['user_city']; ?></td>
					<td><?php echo $user['credit_package_name']; ?></td>
					<td><?php echo convert_date_to_local($user['buy_credit_date'], SITE_DATETIME_FORMAT); ?></td>
					<td><?php echo $user['invoice_number']; ?></td>
					<td><p class='count_of_buyed_credits'><?php echo $buyed_credits ?></p></td>
					<td style='text-align:center'>
						<a href="<?php echo base_url(); ?>admin/users/editProfile?user_hash=<?php echo urlencode($user["user_id_encrypted"]); ?>"><i class="fa fa-pencil"></i> <span><?php echo $this->lang->line('edit'); ?></span></a><br>
						<!-- <a target="_blank" href="<?php echo base_url('admin/purchases/invoiceCredit/'.$user['buy_credit_id'].'/credit_purchase.pdf'); ?>"><i class="fa fa-file-pdf-o"></i></a> -->
						<button data-toggle="modal" data-target="#show_bills_of_user" buy-purchased-credit-id="<?php echo $user['buy_credit_id'] ?>" class='generate_pdfs_for_all_bill_of_user'><i class="fa fa-file-pdf-o"></i></button>
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

<!-- Modal -->
<div class="modal fade" id="show_bills_of_user" tabindex="-1" role="dialog" aria-labelledby="show_bills_of_ser_buy" aria-hidden="true">
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