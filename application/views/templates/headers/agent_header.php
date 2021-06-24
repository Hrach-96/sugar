<!DOCTYPE html>
<html>

<head>
 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $settings["site_description"]; ?>">
    <meta name="keywords" content="<?php echo $settings["site_tags"]; ?>">

	<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url(); ?>css/site/bootstrap.min.css" rel="stylesheet">    
    <link href="<?php echo base_url(); ?>css/site/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/site/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/site/nailthumb.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/jquery.nouislider.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap-select.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap.colorpickersliders.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/summernote.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/site/style_admin.css" rel="stylesheet">
    
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
    </script>
    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=2832576146784115&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body class="fixed-sidebar no-skin-config skinweb">

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> 
						<span>
                        <!-- <a href="<?php echo base_url('user/profile/edit'); ?>"> -->
                            <img alt="image" class="img-circle avatar_left" src="<?php echo base_url(); echo $this->session->userdata("user_avatar"); ?>" />
                        <!-- </a> -->
                        </span>
						
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><a href="<?php echo base_url('user/profile/edit'); ?>"><?php echo $this->session->userdata("user_username"); ?></a></strong></span>
                        </span>
                    </div>
                    <div class="logo-element">
                        <?php echo $settings["site_name"]; ?>
                    </div>
                </li>
                <li class="<?php echo active_admin_menu('agent/dashboard'); ?>">
                    <a href="<?php echo base_url('agent/dashboard'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo $this->lang->line('dashboard'); ?></span></a>
                </li>

                <li class="<?php echo active_admin_menu('agent/approvals/content'); ?>">
                    <a href="<?php echo base_url('agent/approvals/content') ?>"><i class="fa fa-edit"></i> <span class="nav-label"><?php echo $this->lang->line('content_approvals'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('agent/approvals/image'); ?>">
                    <a href="<?php echo base_url('agent/approvals/image') ?>"><i class="fa fa-picture-o"></i> <span class="nav-label"><?php echo $this->lang->line('image_approvals'); ?></span></a>
                </li>              

            </ul>

        </div>
    </nav>

	<div id="page-wrapper" class="gray-bg clearfix">
        <div class="row border-bottom">
        	<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
		        <div class="navbar-header">
			        <ul class="nav-toolbar">
		                <li class="dropdown"><a href="index.html#" data-toggle="dropdown"><i class="fa fa-bars" style="color:#77777f !important"></i></a>
		                	<div class="dropdown-menu lg pull-left arrow panel panel-default arrow-top-left">
		                    	<div class="panel-heading">
		                        	<?php echo $this->lang->line('agent_menu'); ?>
		                        </div>
		                        <div class="panel-body text-center">
		                        	<div class="row">
			                        	<div class="col-xs-6 col-sm-4"><a href="<?php echo base_url(); ?>agent/approvals/content" class="text-danger"><span class="h2"><i class="fa fa-edit"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('content_approvals'); ?></p></a></div>
			                            <div class="col-xs-6 col-sm-4"><a href="<?php echo base_url() ?>agent/approvals/image" class="text-brown"><span class="h2"><i class="fa fa-picture-o"></i></span><p class="text-gray"><?php echo $this->lang->line('image_approvals'); ?></p></a></div>
		                                
		                                <div class="col-lg-12 col-md-12 col-sm-12  hidden-xs"><hr></div>			                              
		                            </div>
		                        </div>
		                    </div>
		                </li>
		            </ul>
		            <div class="brand-web brand-admin">
		           		<a href="<?php echo base_url('home'); ?>"><?php echo $settings["site_name"]; ?></a>
		           		<!-- <span>Verision 1.1</span> -->
		            </div>
		        </div>
	            <ul class="nav navbar-top-links navbar-right">
<!-- 	                <li>
	                	<a href="<?php echo base_url(); ?>">
	                        <i class="fa fa-globe"></i> Back to the Website
	                    </a>
	                </li>	 -->
	                <li>
	                    <a href="<?php echo base_url(); ?>auth/logout">
	                        <i class="fa fa-sign-out"></i> <?php echo $this->lang->line('log_out'); ?>
	                    </a>
	                </li>
	            </ul>
			</nav>
        </div>