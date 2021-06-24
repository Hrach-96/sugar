<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $settings['site_description']; ?>">
    <meta name="keywords" content="<?php echo $settings['site_tags']; ?>">
	<link href='https://fonts.googleapis.com/css?family=Dancing+Script:400,700' rel='stylesheet' type='text/css'>

	<link href="<?php echo base_url(); ?>css/site/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/okflat.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cinzel:400,700,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/site/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/owl.carousel.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/owl.theme.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/owl.transitions.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/site/nailthumb.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/blueimp-gallery.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/vendor/jquery.sidr.dark.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/jquery.nouislider.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/jquery.cssemoticons.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>css/site/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/site/profile_slider.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/flaticon.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap-slider.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/floating-div.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/site/jquery.mCustomScrollbar.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>js/cropper/cropper.css" rel="stylesheet">    
	<!-- <link href="<?php echo base_url(); ?>css/site/tooltipster.bundle.min.css" rel="stylesheet">     -->
	<!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2832576146784115');
        fbq('track', 'PageView');
        fbq('track', 'Lead');
    </script>
    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=2832576146784115&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->		
</head>

<body class="body">
	<header class="top_header">

		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-3">
					<div class="logo_div">
						<a href="<?php echo base_url('home'); ?>">
							<img src="<?php echo base_url(); ?>images/logo.png">
						</a>
					</div>
				</div>
				
				<div class="col-md-6 col-sm-6 col-xs-9 text-right hide-lang" id="bs-collapse-1">
				<ul class="right_UL">
				<li><span class="langlbl"><?php echo strtoupper($this->lang->line('select_your_country')); ?></span>
				<li class="dropdown">
					<span class="select_lang dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('site_country_abbr'); ?></span>
					<ul class="dropdown-menu" aria-labelledby="about-us">
					<?php 
						$countries = $this->country_model->get_active_countries_list();						
						if(!empty($countries)):
							foreach ($countries as $country):
								if($country['country_abbr'] != $this->session->userdata('site_country_abbr')):
					?>
						<li><a onclick="switchCountry('<?php echo $country['country_abbr']; ?>')" href="javascript:void(0);"><?php echo $country['country_abbr']; ?></a></li>
					<?php 		endif;
							endforeach;
						endif; 
					?>
					</ul>
				</li>
				<li><i class="fa fa-search"></i></li>
				</div>
			</div>
		</div>
	</header>
	
	<?php
		$user_id = $this->session->userdata('user_id');
		$last_login_date = $this->session->userdata('user_last_login_date');

		$last_visited_to_me_count = $this->visitor_model->count_new_unseen_visitors($user_id);
		$last_kisses_to_me_count = $this->kiss_model->count_new_unseen_kisses_sent_to_user($user_id);
		$last_favorite_to_me_count = $this->favorite_model->count_new_unseen_favorites_to_user($user_id);
		$last_questions_to_me_count = $this->question_model->count_new_unseen_questions_to_users($user_id);
		$last_unlocks_to_me_count = $this->unlock_request_model->count_new_unseen_unlocks_to_users($user_id);

		$last_chats_to_me_count = $this->chat_model->count_last_chats_to_users_afterdate($user_id, $last_login_date);
	?>

	<?php if($this->session->has_userdata('user_id')): ?>
	<!--mobile menu-->
	<nav id='cssmenu'>
		<div class="logo"><a href="index.html"></a></div>
		<div id="head-mobile">
			<div class="pull-right">
				<a class="lovesli"><img src="<?php echo base_url(); ?>images/credit-img.png" class="diamond_img"><span class="label amtLbl pull-right"><?php echo $this->session->userdata('user_credits'); ?></span></a>
			</div>
		</div>
		<div class="button"><label class="menu_lbl">Menu</label></div>
		<ul class="mobile_menus">
			<li>
				<a href='<?php echo active_top_menu('home'); ?>'><?php echo $this->lang->line('home'); ?></a>
			</li>
			<li>
				<a style="<?php echo active_top_menu('visitors'); ?>" href="<?php echo base_url('visitors'); ?>"><span class="nav-label"><?php echo $this->lang->line('visitors'); ?></span></a>
                <?php if($last_visited_to_me_count > 0): ?>
                <div class="arrow_div arr_for_mbl"><?php echo $last_visited_to_me_count; ?></div>
            	<?php endif; ?>
			</li>
			<li>
				<a style="<?php echo active_top_menu('kisses'); ?>" href="<?php echo base_url('kisses'); ?>"><span class="nav-label"><?php echo $this->lang->line('kisses'); ?></span></a>
                <?php if($last_kisses_to_me_count > 0): ?>
                <div class="arrow_div arr_for_mbl"><?php echo $last_kisses_to_me_count; ?></div>
            	<?php endif; ?>
			</li>
			<li>
				<a style="<?php echo active_top_menu('chat'); ?>" href="<?php echo base_url('chat'); ?>"><span class="nav-label"><?php echo $this->lang->line('chat'); ?></span></a>
                <?php if($last_chats_to_me_count > 0): ?>
                <div class="arrow_div arr_for_mbl"><?php echo $last_chats_to_me_count; ?></div>
            	<?php endif; ?>
			</li>
			<li>
				<a style="<?php echo active_top_menu('favorites'); ?>" href="<?php echo base_url('favorites'); ?>"><span class="nav-label"><?php echo $this->lang->line('favorite'); ?></span></a>
                <?php if($last_favorite_to_me_count > 0): ?>
                <div class="arrow_div arr_for_mbl"><?php echo $last_favorite_to_me_count; ?></div>
            	<?php endif; ?>
			</li>
			<li>
				<a style="<?php echo active_top_menu('questions'); ?>" href="<?php echo base_url('questions'); ?>"><span class="nav-label"><?php echo $this->lang->line('questions'); ?></span></a>
                <?php if($last_questions_to_me_count > 0): ?>
                <div class="arrow_div arr_for_mbl"><?php echo $last_questions_to_me_count; ?></div>
            	<?php endif; ?>
			</li>
			<li>
				<a style="<?php echo active_top_menu('unlocks'); ?>" href="<?php echo base_url('unlocks'); ?>"><span class="nav-label"><?php echo $this->lang->line('unlocks'); ?></span></a>
                <?php if($last_unlocks_to_me_count > 0): ?>
                <div class="arrow_div arr_for_mbl"><?php echo $last_unlocks_to_me_count; ?></div>
            	<?php endif; ?>
			</li>

	        <li>
	        	<a href="<?php echo base_url('profileStatus'); ?>"><span><?php echo $this->lang->line('status'); ?></span></a>
	        </li>
	                   
	        <li>
	        	<a href="<?php echo base_url('user/profile/edit'); ?>"><span><?php echo $this->lang->line('profile_settings'); ?></span></a>
	        </li>  

	        <li>
	        	<a href="<?php echo base_url('user/blocked'); ?>"><span><?php echo $this->lang->line('blocked_user'); ?></span></a>
	        </li>

								             
<!-- 			<li>
				<a style="<?php echo active_top_menu('shop'); ?>" href="<?php echo base_url('shop'); ?>"><span class="nav-label"><?php echo $this->lang->line('shop'); ?></span></a>
			</li> -->
			
			<li>
				<a style="<?php echo active_top_menu('buy/credit'); ?>" href="<?php echo base_url('buy/credit'); ?>"><span class="nav-label"><?php echo $this->lang->line('credit'); ?></span></a>
			</li>

			<li>
				<a style="<?php echo active_top_menu('user/vip'); ?> " href="<?php echo base_url('user/vip'); ?>"><span class="nav-label"><?php echo $this->lang->line('vip'); ?></span></a>
			</li>

			<li>
				<a href="<?php echo base_url('page/contactUs'); ?>"><span><?php echo $this->lang->line('contact_us'); ?></span></a>
			</li>

            <li>
            	<a href="<?php echo base_url('user/profile/manage'); ?>"><span><?php echo $this->lang->line('manage_profile'); ?></span></a>
            </li>

            <li>
            	<a href="<?php echo base_url('auth/logout'); ?>"><span><?php echo $this->lang->line('logout'); ?></span></a>
            </li>

<!-- 			<li>
				<a style="<?php echo active_top_menu('buy/diamond'); ?>" href="<?php echo base_url('buy/diamond'); ?>"><span class="nav-label"><?php echo $this->lang->line('buy_diamonds'); ?></span></a>
			</li> -->
<!-- 			<li>
				<a href="#"><span class="nav-label"><?php echo $this->lang->line('generate_code'); ?></span></a>
			</li> -->
<!-- 			<li><a href='#'>Shop</a>
			   <ul>
			      <li><a href='#'>Product 1</a>
			         <ul>
			            <li><a href='#'>Sub Product</a></li>
			            <li><a href='#'>Sub Product</a></li>
			         </ul>
			      </li>
			      <li><a href='#'>Product 2</a>
			         <ul>
			            <li><a href='#'>Sub Product</a></li>
			            <li><a href='#'>Sub Product</a></li>
			         </ul>
			      </li>
			   </ul>
			</li> -->
		</ul>
	</nav>
	<!--mobile menu-->

	<header class="menu_header">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<nav class="navbar navbar-default" role="navigation">

						<div id="bs-collapse-1">				
							<ul class="nav navbar-nav navbar-right right_menu">
						       
						        <li class="dropdown">						
						        	<a class="pull-left setting_a dropdown-toggle" href="javascript:void();" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="flaticon-gear"></i><span class="caret"></span></a>										
										<ul class="dropdown-menu settingMenu">
								            <li><a href="<?php echo base_url('profileStatus'); ?>"><span><?php echo $this->lang->line('status'); ?><img src="<?php echo base_url('images/avatari.png'); ?>" /></span></a></li>            
								            <li><a href="<?php echo base_url('chat'); ?>"><span><?php echo $this->lang->line('chat'); ?><img src="<?php echo base_url('images/speech-bubble-i.png'); ?>" /></span></a></li>            
								            <li><a href="<?php echo base_url('user/profile/edit'); ?>"><span><?php echo $this->lang->line('profile_settings'); ?><img src="<?php echo base_url('images/user-i.png'); ?>" /></span></a></li>            
								            <li><a href="<?php echo base_url('user/blocked'); ?>"><span><?php echo $this->lang->line('blocked_user'); ?><img src="<?php echo base_url('images/do-not-disturb-i.png'); ?>" /></span></a></li>            
								            <li><a href="<?php echo base_url('buy/credit'); ?>"><span><?php echo $this->lang->line('credits'); ?><img src="<?php echo base_url('images/coin-stack-i.png'); ?>" /></span></a></li>			
								            <li><a href="<?php echo base_url('user/vip'); ?>"><span><?php echo $this->lang->line('vip'); ?><img src="<?php echo base_url('images/crown-i.png'); ?>" /></span></a></li>

<!-- 								            <li><a href="<?php echo base_url('buy/diamond'); ?>"><span><?php echo $this->lang->line('diamonds'); ?><img src="<?php echo base_url('images/diamond-i.png'); ?>" /></span></a></li>

								            <li><a href="<?php echo base_url('shop'); ?>"><span><?php echo $this->lang->line('shop'); ?><img src="<?php echo base_url('images/gift-i.png'); ?>" /></span></a></li>             -->
								            
<!-- 								            <li>
								            	<a href="#"><span>My Wishlist<img src="<?php echo base_url('images/star-i.png'); ?>" /></span></a></li>             -->
								            <li><a href="<?php echo base_url('page/faq'); ?>"><span><?php echo $this->lang->line('faq'); ?><img src="<?php echo base_url('images/question-speech-i.png'); ?>" /></span></a></li>			
								            <li><a href="<?php echo base_url('page/contactUs'); ?>"><span><?php echo $this->lang->line('contact_us'); ?><img src="<?php echo base_url('images/envelope-i.png'); ?>" /></span></a></li>			
								            <li><a href="<?php echo base_url('user/profile/manage'); ?>"><span><?php echo $this->lang->line('manage_profile'); ?><img src="<?php echo base_url('images/settings-work-i.png'); ?>" /></span></a></li>			
								            <li><a href="<?php echo base_url('auth/logout'); ?>"><span><?php echo $this->lang->line('logout'); ?><img src="<?php echo base_url('images/logout-i.png'); ?>" /></span></a></li>            
          								</ul>					        	
						        </li>
								       <li>
						        	<a class="pull-right" title="Logout" href="<?php echo base_url('auth/logout'); ?>">
						        		<i class="flaticon-logout"></i>        					
						        	</a>						
						        </li>
					        </ul>
							<ul class="nav navbar-nav navbar-left main_menu">
								<li>
					                <a style="<?php echo active_top_menu('visitors'); ?>" href="<?php echo base_url('visitors'); ?>"><span class="nav-label"><?php echo $this->lang->line('visitors'); ?></span></a>
					                <?php if($last_visited_to_me_count > 0): ?>
					                <div class="arrow_div"><?php echo $last_visited_to_me_count; ?></div>
					            	<?php endif; ?>
					            </li>
					            <li>
					                <a style="<?php echo active_top_menu('kisses'); ?>" href="<?php echo base_url('kisses'); ?>"><span class="nav-label"><?php echo $this->lang->line('kisses'); ?></span></a>
					                <?php if($last_kisses_to_me_count > 0): ?>
					                <div class="arrow_div"><?php echo $last_kisses_to_me_count; ?></div>
					            	<?php endif; ?>
					            <li>
					                <a style="<?php echo active_top_menu('chat'); ?>" href="<?php echo base_url('chat'); ?>"><span class="nav-label"><?php echo $this->lang->line('chat'); ?></span></a>
					                <?php if($last_chats_to_me_count > 0): ?>
					                <div class="arrow_div"><?php echo $last_chats_to_me_count; ?></div>
					            	<?php endif; ?>
					            </li>
					            <li>
					                <a style="<?php echo active_top_menu('favorites'); ?>" href="<?php echo base_url('favorites'); ?>"><span class="nav-label"><?php echo $this->lang->line('favorite'); ?></span></a>
					                <?php if($last_favorite_to_me_count > 0): ?>
					                <div class="arrow_div"><?php echo $last_favorite_to_me_count; ?></div>
					            	<?php endif; ?>					                
					            </li>
					           
								<li>
					                <a style="<?php echo active_top_menu('questions'); ?>" href="<?php echo base_url('questions'); ?>"><span class="nav-label"><?php echo $this->lang->line('questions'); ?></span></a>
					                <?php if($last_questions_to_me_count > 0): ?>
					                <div class="arrow_div"><?php echo $last_questions_to_me_count; ?></div>
					            	<?php endif; ?>
					            </li>
								
						        <li>
					                <a style="<?php echo active_top_menu('unlocks'); ?>" href="<?php echo base_url('unlocks'); ?>"><span class="nav-label"><?php echo $this->lang->line('unlocks'); ?></span></a>
					                <?php if($last_unlocks_to_me_count > 0): ?>
					                <div class="arrow_div"><?php echo $last_unlocks_to_me_count; ?></div>
					            	<?php endif; ?>
					            </li>
<!-- 						       	<li>
					                <a style="<?php echo active_top_menu('shop'); ?>" href="<?php echo base_url('shop'); ?>"><span class="nav-label"><?php echo $this->lang->line('shop'); ?></span></a>
					            </li> -->
<!-- 								<li>
						       		<a class="lovesli" data-toggle="modal" data-target="#userDiamondsOnAccountModal"><img src="<?php echo base_url(); ?>images/diamond.png" class="diamond_img"><span class="label amtLbl pull-right"><?php echo $this->session->userdata('user_diamonds'); ?></span></a>
						       	</li> -->
								<li>
						       		<a class="lovesli"><img src="<?php echo base_url(); ?>images/credit-img.png" class="diamond_img"><span class="label amtLbl pull-right"><?php echo $this->session->userdata('user_credits'); ?></span></a>
						       	</li>
				        	</ul>

							<div class="clearfix"></div>
						</div>

					</nav>
				</div>
			</div>
		</div>
	</header>

	<header class="menu_2_header">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-8 leftDiv">
					<div class="userpic">
						<a href="<?php echo base_url('user/profile/edit'); ?>">
							<img src="<?php echo base_url().$this->session->userdata('user_avatar'); ?>">
							<?php if($this->session->userdata('user_is_vip') == 'yes') { ?>
							<div class="vip_member"><?php echo $this->lang->line('vip_member'); ?></div>
							<?php } ?>
						</a>
					</div>
					<div class="welcomeDiv">
					<span class="welcome_msg"> <?php echo $this->lang->line('welcome_back').' '.ucfirst($this->session->userdata('user_username')); ?></span>
					</div>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-8 hide_mb">
					<ul class="nav navbar-nav navbar-left main_menu submenu">
						<li><a style="<?php echo active_top_menu('user/vip'); ?> " href="<?php echo base_url('user/vip'); ?>"><span class="nav-label"><?php echo $this->lang->line('vip'); ?></span></a></li>
						<li><a style="<?php echo active_top_menu('buy/credit'); ?>" href="<?php echo base_url('buy/credit'); ?>"><span class="nav-label"><?php echo $this->lang->line('credit'); ?></span></a></li>
<!-- 						<li><a style="<?php echo active_top_menu('buy/diamond'); ?>" href="<?php echo base_url('buy/diamond'); ?>"><span class="nav-label"><?php echo $this->lang->line('buy_diamonds'); ?></span></a></li>
						<li><a href="#"><span class="nav-label"><?php echo $this->lang->line('generate_code'); ?></span></a></li> -->
	        		</ul>
				</div>
			</div>
		</div>
	</header>
	<?php
		$this->load->view('templates/sidebar/diamond_on_account_modal');
	?>
	<?php endif; ?>

	<?php if($this->session->has_userdata('message')) { ?>
	<section class="messages">
		<div class="alert tag-alert-golden alert-dismissible fade in text-center">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <?php echo $this->lang->line($this->session->userdata('message')); $this->session->unset_userdata('message'); ?>
		</div>
	</section>
	<?php } ?>