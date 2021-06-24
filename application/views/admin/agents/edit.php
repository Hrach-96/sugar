<?php
$this->load->view('templates/headers/admin_header', $title);
?>
<style type="text/css">
	.text-white {
		color: #edeaea;
	}
	.make-box {
		border: 1px solid #eee;
		box-shadow: 1px 1px 2px gray;
		margin-bottom: 10px;
	}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
			<li>
                <a href="<?php echo base_url('admin/agents'); ?>"><?php echo $this->lang->line('manage_agents'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('edit'); ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-12 block_form">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

		<div class="panel panel-success">
			<div class="panel-heading" role="tab" id="headingOne">
				<span class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				<?php echo $this->lang->line('public_information'); ?> </a>
				</span>
				<div class="pull-right">
					<a class="text-white" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
					<i class="fa fa-plus fa-lg"></i></a>
				</div>
			</div>
			<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
						<h3><?php echo $user_row["user_access_name"]; ?></h3>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('gender'); ?></label>
									<select name="gender" class="form-control gender" style="text-align:center !important;">
										<option value="male" <?php if($user_row["user_gender"] == 'male'): ?> selected="true"<?php endif; ?> ><?php echo $this->lang->line('male'); ?></option>
										<option value="female" <?php if($user_row["user_gender"] == 'female'): ?> selected="true"<?php endif; ?>><?php echo $this->lang->line('female'); ?></option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="control-label"><?php echo $this->lang->line('location'); ?></label>
									<input name="user_location" type="text" class="form-control" placeholder="<?php echo $this->lang->line('enter_location'); ?>" value="<?php echo $user_row['user_city']; ?>" />
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label"><?php echo $this->lang->line('birthday'); ?></label>
							<?php 
								$user_birthdate = explode('-', $user_row['user_birthday']);
							?>							
							<div class="col-ws-12">
								<div class="col-xs-4">
									<select name="dateofbirth_day" class="form-control text-center">
										<?php for($day=1; $day <= 31; $day++) { ?>
										<option class="option" value="<?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?>" <?php if($user_birthdate[2] == $day) { ?> selected="true" <?php } ?> ><?php echo str_pad($day, 2,"0", STR_PAD_LEFT); ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-xs-4">
									<select name="dateofbirth_month" class="form-control text-center">
										<?php for($month=1; $month <= 12; $month++) { ?>
										<option class="option" value="<?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?>" <?php if($user_birthdate[1] == $month) { ?> selected="true" <?php } ?>><?php echo str_pad($month, 2,"0", STR_PAD_LEFT); ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-xs-4">
									<select name="dateofbirth_year" class="form-control text-center">
										<?php 
										$curr_year = date('Y');
										$year_diff = $settings['site_age_limit'];
										$upto_year = $curr_year - $year_diff - 52;

										for($year=($curr_year-$year_diff); $year >= $upto_year; $year--) { ?>
										<option class="option" value="<?php echo $year; ?>" <?php if($user_birthdate[0] == $year) { ?> selected="true" <?php } ?>><?php echo $year; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

					</div>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading" role="tab" id="headingTwo">
				<span class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				<?php echo $this->lang->line('account_information'); ?> </a>
				</span>
				<div class="pull-right">
					<a class="collapsed text-white" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-plus fa-lg"></i></a>
				</div>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
						<div class="form-group">
							<label class="control-label"><?php echo $this->lang->line('username'); ?></label>
							<input type="text" class="form-control username" name="username" placeholder="<?php echo $this->lang->line('your_username'); ?>" value="<?php echo $user_row["user_access_name"]; ?>" />
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo $this->lang->line('email'); ?></label>
							<input type="email" class="form-control email" name="email" placeholder="you@email.com" value="<?php echo $user_row["user_email"]; ?>" />
						</div>
				</div>
			</div>
		</div>

		<?php if($user_row['user_status'] == 'blocked' || $user_row['user_status'] == 'inactive') { ?>			
		<div class="panel panel-success" style="border-color: #148c14;">
			<div class="panel-heading" role="tab" id="headingFour" style="background-color: #148c14;border-color: #0bb62b;">
				<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				<?php echo $this->lang->line('activate_user'); ?></a>
				</h4>
			</div>
			<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
				<div class="panel-body" style="text-align: center;">
					<a class="btn btn-success" href="<?php echo base_url(); ?>admin/agents/activateUser?user_hash=<?php echo urlencode($user_row["user_id_encrypted"]); ?>"><?php echo $this->lang->line('activate_user_confirm_message'); ?></a>
				</div>
			</div>
		</div>
		<?php } ?>

		<?php if($user_row['user_status'] != 'blocked') { ?>
		<div class="panel panel-danger">
			<div class="panel-heading" role="tab" id="headingFive">
				<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				<?php echo $this->lang->line('block_user'); ?></a>
				</h4>
			</div>
			<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
				<div class="panel-body" style="text-align: center;">
					<a class="btn btn-danger" href="<?php echo base_url(); ?>admin/agents/blockUser?user_hash=<?php echo urlencode($user_row["user_id_encrypted"]); ?>"><?php echo $this->lang->line('block_user_confirm_message'); ?></a>
				</div>
			</div>
		</div>
		<?php } ?>

	</div>

</div>
<script data-path="/okdate/pixie" src="<?php echo base_url(); ?>pixie/pixie-integrate.js"></script>

<?php
$this->load->view('templates/footers/admin_footer');
?>