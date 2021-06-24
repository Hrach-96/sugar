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
                <strong><?php echo $this->lang->line('gift_to_user'); ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-12 block_form">
	<form action="/admin/gift/index" accept-charset="utf-8" >
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
		<button class='btn btn-success btn_add_gifts_to_user'>
			<?php echo $this->lang->line('add_gift_to_user'); ?>
		</button>
	</div>
</div>
<div style='margin-top:50px' class='col-lg-12 '>
	<table class='table table-striped table-hover'>
		<tr>
			<td><h4><?php echo $this->lang->line('vip'); ?></h4></td>
			<td>
				<label for='1_month_checked'><h3>1</h3></label>
				<input type='radio' value="1" name='vip_for_gift' id='1_month_checked'>
			</td>
			<td>
				<label for='3_month_checked'><h3>3</h3></label>
				<input type='radio' value="3" name='vip_for_gift' id='3_month_checked'>
			</td>
			<td>
				<label for='6_month_checked'><h3>6</h3></label>
				<input type='radio' value="6" name='vip_for_gift' id='6_month_checked'>
			</td>
			<td>
				<label for='12_month_checked'><h3>12</h3></label>
				<input type='radio' value="12" name='vip_for_gift' id='12_month_checked'>
			</td>
		</tr>
		<tr>
			<td><h4><?php echo $this->lang->line('credit'); ?></h4></td>
			<?php
				foreach($credit_packages as $key=>$value){
					?>
						<td>
							<label for="<?php echo $value['package_id']?>_credit_gift"><h3><?php echo $value['package_credits'] ?></h3></label>
							<input type='radio' value="<?php echo $value['package_id']?>" name='credit_for_gift' id="<?php echo $value['package_id']?>_credit_gift">
						</td>
					<?php
				}
			?>
		</tr>
	</table>
</div>
<div class="col-lg-12">
	<div class="clearfix clearfix_mobile_class">
	    <?php 
	    	if(!empty($user_list)):
	    ?>
			<table class="table table-striped table-hover gift_table_custom_class">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('choose'); ?></th>
					<th><?php echo $this->lang->line('nic_name'); ?></th>
					<th><?php echo $this->lang->line('user_firstname'); ?></th>
					<th><?php echo $this->lang->line('user_lastname'); ?></th>
					<th><?php echo $this->lang->line('email_address_short'); ?></th>
					<th><?php echo $this->lang->line('gender'); ?></th>
					<th><?php echo $this->lang->line('user_credits'); ?></th>
					<th><?php echo $this->lang->line('vip_status'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = 1;
	    		foreach($user_list as $user):
			?>
				<tr>
					<td><?php echo $sr_no++; ?></td>
					<th><input class='checkbox_for_checking' id="user_row_<?php echo $user['user_id']?>" type='checkbox' name='user_for_gifts_checkbox' data-user-id="<?php echo $user['user_id']?>"></th>
					<td><?php echo $user['user_access_name']; ?></td>
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