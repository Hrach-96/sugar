<?php
	$this->load->view('templates/headers/admin_header', $title);
	$info = '';
	if(!empty($_GET['info'])){
		$info = $_GET['info'];
	}
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
	.gift_table_custom_class:hover{
		cursor:pointer;
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
                <strong><?php echo $this->lang->line('gift_canceled'); ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-12 block_form">
	<form action="/admin/gift/history" accept-charset="utf-8" >
		<div class='col-md-4'>
			<input type='text' name='info' value="<?php echo $info ?>" placeholder="<?php echo $this->lang->line('name'); ?>" class='form-control'>
		</div>
		<div class='col-md-2'>
			<button class='btn btn-success'>
				<?php echo $this->lang->line('search'); ?>
			</button>
		</div>
	</form>
	<div class='float-right'>
		<button class='btn btn-success btn_cancel_gifts_from_user'>
			<?php echo $this->lang->line('cancel_gift'); ?>
		</button>
	</div>
</div>
<div class="col-lg-12">
	<div class="clearfix clearfix_mobile_class">
	    <?php 
	    	if(!empty($history_user_list)):
	    ?>
			<table class="table table-striped table-hover gift_table_custom_class">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('choose'); ?></th>
					<th><?php echo $this->lang->line('nic_name'); ?></th>
					<th><?php echo $this->lang->line('gift_type'); ?></th>
					<th><?php echo $this->lang->line('user_firstname'); ?></th>
					<th><?php echo $this->lang->line('user_lastname'); ?></th>
					<th><?php echo $this->lang->line('email_address_short'); ?></th>
					<th><?php echo $this->lang->line('gender'); ?></th>
					<th><?php echo $this->lang->line('user_credits'); ?></th>
					<th><?php echo $this->lang->line('vip_status'); ?></th>
					<th><?php echo $this->lang->line('gift_added_time'); ?></th>
					<th><?php echo $this->lang->line('gift_canceled_time'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($history_user_list as $user):
			?>
				<tr>
					<td><?php echo $sr_no++; ?></td>
					<th>
						<?php
						if(!$user['canceled_date']){?>
							<input data-row-id="<?php echo $user['id']?>" id="user_row_<?php echo $user['user_id']?>" type='checkbox' name='user_for_gifts_checkbox' class='checkbox_for_checking' data-user-id="<?php echo $user['user_id']?>">
						<?php
						}
						?>
					</th>
					<td><?php echo $user['user_access_name']; ?></td>
					<td style='color:red;font-weight:bolder;font-size:15px'><?php echo $user['name']; ?></td>
					<td><?php echo $user['user_firstname']; ?></td>
					<td><?php echo $user['user_lastname']; ?></td>
					<td><?php echo $user['user_email']; ?></td>
					<td><?php echo $user['user_gender']; ?></td>
					<td><?php echo $user['user_credits']; ?></td>
					<td>
						<?php 
							if($user['user_is_vip'] == 'yes'){
								?>
									<h3 style='font-weight:bolder;color:red'>VIP</h3>
								<?php
							}
						?>
					</td>
					<td><?php echo convert_date_to_local($user['added_date'], SITE_DATETIME_FORMAT); ?></td>
					<td>
						<?php
						if($user['canceled_date']){
							echo convert_date_to_local($user['canceled_date'], SITE_DATETIME_FORMAT);
						}
						?>
					</td>
				</tr>
			<?php
				endforeach;
			endif;
			?>
				</tbody>
			</table>
		</div>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>