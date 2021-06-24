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
	.rank-progress {
		margin: 0px;
		height: 24px;
		margin-left: 0px;
	}
	.btn-purple {
		padding: 2px;
		background: #1a1a66;
		border-color: #100080;
		color:#fff;
	}
	.progress-bar-purple {
		background: #1a1a66;
		border-color: #100080;
		color:#fff;
	}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-3">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo $this->lang->line('manage_users'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-9">
	    <form class="form-inline" method="GET" action="<?php echo base_url('admin/users'); ?>">
		    <div class="btn_filter_placeholder">
				<div class="form-group">
		    		<input type="text" name="key" value="<?php echo isset($_GET['key'])?$_GET['key']:''; ?>" class="form-control form-username" placeholder="<?php echo $this->lang->line('search_by_username'); ?>" />
				</div>		    	
				<div class="form-group">
					<?php 
						$search_by_gender = isset($_GET['gender']) ? $_GET['gender'] : '';
						$gender_options = array(
					        ''		=> $this->lang->line('gender'),
					        'male'	=> $this->lang->line('male'),
					        'female'	=> $this->lang->line('female')
						);

						echo form_dropdown('gender', $gender_options, $search_by_gender, 'class="form-control"');
					?>
				</div>
				<div class="form-group">
					<?php 
						$search_by_online = isset($_GET['online']) ? $_GET['online'] : '';
						$online_options = array(
					        ''		=> $this->lang->line('online'),
					        'yes'	=> $this->lang->line('yes'),
					        'no'	=> $this->lang->line('no')
						);

						echo form_dropdown('online', $online_options, $search_by_online, 'class="form-control"');
					?>
				</div>				
				<div class="form-group">
					<?php 
						$search_by_country = isset($_GET['country']) ? $_GET['country'] : '';
						$country_options = array(
					        ''		=> $this->lang->line('country')
						);

						if(!empty($countries)) {
							foreach ($countries as $country) {
								$country_options[$this->lang->line($country['country_name'])] = $this->lang->line($country['country_name']);
							}
						}
						echo form_dropdown('country', $country_options, $search_by_country, 'class="form-control"');
					?>
				</div>
				<div class="form-group">
					<?php 
						$search_by_vip = isset($_GET['vip']) ? $_GET['vip'] : '';
						$vip_options = array(
					        ''		=> $this->lang->line('vip'),
					        'yes'	=> $this->lang->line('yes'),
					        'no'	=> $this->lang->line('no')
						);

						echo form_dropdown('vip', $vip_options, $search_by_vip, 'class="form-control"');
					?>
				</div>
				<button type="submit" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
		    </div>
	    </form>
    </div>
</div>

<div class="col-lg-12 block_form">
    <p class="col-sm-12" style="font-weight: 600;color: #5d5d5d;font-style: italic;text-align: center;"><?php echo $this->lang->line('total').' <b>'.$total_users.'</b> '.$this->lang->line('users_found'); ?></p>
</div>

<div class="col-lg-12 block_form">
	<?php if($this->session->flashdata('message')) { ?>
	<div class="alert alert-info">
		<?php echo $this->session->flashdata('message'); ?>
	</div>
	<?php } ?>

    <div class="panel">
    	<div class="panel-body no-padding">
    	<div class="col-lg-3 no-padding">
    		<button id="update-user-rank" class="btn btn-purple btn-block">Update User Rank</button>
    	</div>
    	<div class="col-lg-9">
			<div class="progress rank-progress">
				<div id="rank-progress-bar" class="progress-bar progress-bar-purple" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
				0%
				</div>
			</div>
		</div>
		</div>
    </div>

    <div class="ibox-content-no-bg">
		<div class="clearfix">
	    <?php 
	    	if(!empty($users)):
	    		foreach($users as $user):		
	    			if($user["user_active_photo_thumb"] == '')
	    				$user['user_active_photo_thumb'] = "images/avatar/".$user['user_gender'].".png";
			?>
	    	
			<div class="col-lg-3 col-md-4 col-xs-12 clearfix user_block" data-user-id="<?php echo $user["user_id_encrypted"]; ?>">
				<div class="thumb">
	                <a class="thumbnail" href="<?php echo base_url(); ?>user/profile/view?query=<?php echo urlencode($user["user_id_encrypted"]); ?>">
			            <img src="<?php echo base_url() . $user["user_active_photo_thumb"]; ?>" alt="Photo User" />
			            <div class="online_status text-success">			            	

		                <?php		                	
			                if($user["last_online_time"] <= '00:03:00' && $user["last_online_time"] != ""):
			            ?>
		                	<i class="fa fa-circle"></i>
		                <?php
		                	else:
		                		echo '&nbsp;';
			                endif;
			            ?>
			            </div>
			            <?php if($user["user_status"] == 'deleted'): ?> 
			            <div class="online_status deleted-stamp"><?php echo $this->lang->line($user["user_status"]); ?> <br><small><?php echo convert_date_to_local($user["user_deletion_date"], SITE_DATETIME_FORMAT); ?></small></div>
			        	<?php endif; ?> 
	               	</a>
				   	<div class="userslst_infos">
					   	<b><?php echo $user["user_access_name"]; ?></b>
					   	<div class="userslst_age">
					   		<?php echo $this->lang->line($user["user_gender"]); ?> &#8226; <?php echo floor($user["user_age"]); ?> &#8226; 
					   		<?php echo $this->lang->line($user["user_status"]); ?> 
					   	</div>
					   	<div class="userslst_age">
					   		<?php echo $user["user_city"]; ?> &#8226;
					   		<?php echo $user["user_country"]; ?>
					   	</div>					   	
					   	<div class="row text-center">
<!-- 						   	<div class="col-md-6 btndelete">
							   	<a href="javascript:void(0);" class="btn btn-danger btn-delete-user"><i class="fa fa-ban"></i> <span>Delete</span></a>
						   	</div>
 -->						<div class="col-md-12">
							   	<a href="<?php echo base_url(); ?>admin/users/editProfile?user_hash=<?php echo urlencode($user["user_id_encrypted"]); ?>" class="btn btn-info btn-edit-user"><i class="fa fa-pencil"></i> <span><?php echo $this->lang->line('edit'); ?></span></a>		   	
						   	</div>
					   	</div>
					   	<br/>
					</div>
				</div>
            </div>

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
		</div>

    </div>

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
<?php
$this->load->view('templates/footers/admin_footer');
?>