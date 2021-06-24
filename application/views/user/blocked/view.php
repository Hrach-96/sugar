<?php
	$this->load->view('templates/headers/main_header', $title);
?>

<section class="payment_method blckUserSection fstBxMob">
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="margin-top: -60px; ">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>		
		<div class="row blckHead">
			<div class="col-md-12 text-center">
				<h4 class="full-pay gold-txt">          
      				<span class="vipPackage"><?php echo $this->lang->line('see_the_user_blacklist'); ?>  </span>
    			</h4>
				<h4 class="get_in_touch"><?php echo $this->lang->line('check_wich_user_is_on_your_blacklist_and_manage_his_status'); ?></h4>
			</div>				
		</div>

		
		<?php 
			if(!empty($users)) {
				foreach ($users as $user_row) {
		            if($user_row['user_active_photo_thumb'] == '') {
		              	$user_row['user_active_photo_thumb'] = "images/avatar/".$user_row['user_gender'].".png";
		            }
		?>
		<div class="row blckRow">
			<div class="col-md-9 col-sm-8 col-xs-12">
				<div class="blockedUsr">
					<a href="<?php echo base_url('user/profile/view?query=').urlencode($user_row['user_id_encrypted']); ?>">
						<img src="<?php echo base_url().$user_row['user_active_photo_thumb']; ?>"> <span class="blckUsrnm"><?php echo $user_row['user_access_name']; ?></span>
					</a>
				</div>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<div class="UnblockBtn">
					<a class="buy_nw_credit btn_hover btn-unblock-user" data-id="<?php echo $user_row['user_id_encrypted']; ?>"><?php echo $this->lang->line('unblock'); ?></a>
				</div>
			</div>
		</div>
    	<?php 
    			}	
    		} else {
    	?>
			<div class="text-center" style="color: white;"><?php echo $this->lang->line('no_one_found'); ?></div>
		<?php 
    		}
    	?>

	   	<?php if($links != '') { ?>
		<div class="col-xs-18 col-sm-12 col-md-12"></div>	
		<div class="pagination">
			<span class="go_to">Go To &nbsp;&nbsp;&nbsp;&nbsp;|</span> 
			<?php echo $links; ?>	
		</div>
		<?php } ?>

	</div>
</section>

<?php
	$this->load->view('templates/footers/main_footer');
?>
