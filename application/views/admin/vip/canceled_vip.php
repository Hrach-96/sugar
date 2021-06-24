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
	html, body {
		max-width: 100%;
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
                <strong><?php echo $this->lang->line('vip_cancel'); ?></strong>
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
			<form class="form-inline" method="POST" action="<?php echo base_url('admin/purchases/report_cancel_vip'); ?>">
				<button type="submit" class="btn btn-success" style="border-radius: 5px;padding: 6px 20px;margin-left: 10px;"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></button>
			</form>
	    	<div style='z-index:999' class="online_status canceled-vip-in-title"><?php echo $this->lang->line('vip_cancel'); ?></div>
			<div class="row">
	    	</div>

	    <?php 
	    	if(!empty($users)):
	    ?>
			<table class="table table-striped table-hover table_for_canceled_vip">
				<thead>
					<th></th>
					<th></th>
					<th><?php echo $this->lang->line('nic_name'); ?></th>
					<th><?php echo $this->lang->line('name'); ?></th>
					<th><?php echo $this->lang->line('country'); ?></th>		
					<th><?php echo $this->lang->line('location'); ?></th>
					<th><?php echo $this->lang->line('street'); ?></th>
					<th><?php echo $this->lang->line('house_nr'); ?></th>
					<th><?php echo $this->lang->line('email_address_short'); ?></th>
					<th><?php echo $this->lang->line('telephone_number_short'); ?></th>
					<th><?php echo $this->lang->line('vip'); ?></th>
					<th><?php echo $this->lang->line('buy_date'); ?></th>
					<th><?php echo $this->lang->line('cancel_date'); ?></th>
					<th>W</th>
					<th><?php echo $this->lang->line('abo_ende'); ?></th>	
					<th><?php echo $this->lang->line('k_beendigung'); ?></th>	
					<th><?php echo $this->lang->line('email'); ?></th>	
					<th>Anwalt</th>
					<th><?php echo $this->lang->line('action'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($users as $user):
	    			if($user["user_active_photo_thumb"] == '') {
	    				$user['user_active_photo_thumb'] = "images/avatar/".$user['user_gender'].".png";
	    			}
	    			$buy_vip_date = new DateTime($user['buy_vip_date']);
	    			$expire_date = $buy_vip_date->modify('+' . $user['package_validity_in_months'] . ' month');

	    			$cancelled_datetime = date_create($user['canceled_date']);
                    $buyed_datetime = date_create($user['buy_vip_date']);
                    $diff = date_diff($buyed_datetime,$cancelled_datetime);
                    $background_red_color = '';
                    if($diff->format("%a") < 14){
                    	$background_red_color = 'red';
                    }
				?>
				<tr>
					<td><?php echo $sr_no++; ?></td>			
					<td class='for_switch_style'>
						<center <?php echo ($user['user_is_vip'] == 'no')? 'style=background:red' : '' ?> >
							<a href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($user['user_id_encrypted']); ?>">
								<img style="width:78px;height:78px;border-radius:50%;object-fit:cover;border: 1px solid #464646;" src="<?php echo base_url() . $user['user_active_photo_thumb']; ?>" />
								<br/>
								<?php echo $user['user_access_name']; ?>
					            <?php if($user["user_status"] == 'deleted'): ?> 
					            <div class="deleted-stamp-profile-icon"><?php echo $this->lang->line($user["user_status"]); ?></div>
					        	<?php endif; ?>
							</a>
							<br>
							<label class="switch">
							  <input type="checkbox" <?php echo ($user['user_is_vip'] == 'yes')? 'checked' : '' ?> data-user-id="<?php echo $user['user_id'] ?>" class='switchInput'>
							  <span class="slider round"></span>
							</label>
						</center>
					</td>
					<td><?php echo $user['user_access_name']; ?></td>
					<td><?php echo $user['user_firstname'] . " " . $user['user_lastname']; ?></td>
					<td><?php echo $user['user_country']; ?></td>
					<td><?php echo $user['user_city']; ?></td>
					<td><?php echo $user['user_street']; ?></td>
					<td><?php echo $user['user_house_no']; ?></td>
					<td><?php echo $user['user_email']; ?></td>
					<td><?php echo $user['user_telephone']; ?></td>
					<td><?php echo preg_replace('/[^0-9]/', '', $user['vip_package_name']); ?></td>
					<td><?php echo convert_date_to_local($user['buy_vip_date'], SITE_DATETIME_FORMAT); ?></td>
					<td style="background:<?php echo $background_red_color?>"><?php echo convert_date_to_local($user['canceled_date'], SITE_DATETIME_FORMAT); ?></td>
					<td class='text-center'>
						<input value="<?php echo $user['w_yes_no']?>" type='text' class='form-control w_yes_no_field'>
						<button data-row-id="<?php echo $user['id']?>" data-column-name='w_yes_no' class='btn btn-primary btn_save_add_info_cancel'>save</button>
					</td>
					<td><?php echo $expire_date->format('Y-m-d') ?></td>
					<td class='text-center'>
						<input value="<?php echo $user['k_termination']?>" type='text' class='form-control k_termination_field'>
						<button data-row-id="<?php echo $user['id']?>" data-column-name='k_termination' class='btn btn-primary btn_save_add_info_cancel'>save</button>
					</td>
					<td class='text-center'>
						<input value="<?php echo $user['email_cancel']?>" type='text' class='form-control email_cancel_field'>
						<button data-row-id="<?php echo $user['id']?>" data-column-name='email_cancel' class='btn btn-primary btn_save_add_info_cancel'>save</button>
					</td>
					<td class='text-center'>
						<input value="<?php echo $user['anwalt']?>" type='text' class='form-control anwalt_field'>
						<button data-row-id="<?php echo $user['id']?>" data-column-name='anwalt' class='btn btn-primary btn_save_add_info_cancel'>save</button>
					</td>
					<td style='text-align:center'>
						<a href="<?php echo base_url(); ?>admin/users/editProfile?user_hash=<?php echo urlencode($user["user_id_encrypted"]); ?>"><i class="fa fa-pencil"></i> <span><?php echo $this->lang->line('edit'); ?></span></a><br>
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
      <div class="modal-body content_all_credits_pdf">
        
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