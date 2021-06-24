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
    <link href="<?php echo base_url(); ?>css/site/style_admin.css?v=1.0" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/jquery-ui.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>js/cropper/cropper.css" rel="stylesheet">

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
                            <a href="<?php echo base_url('user/profile/edit'); ?>"><img alt="image" class="img-circle avatar_left" src="<?php echo base_url(); echo $this->session->userdata("user_avatar"); ?>" /></a>
                        </span>
                        
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><a href="<?php echo base_url('user/profile/edit'); ?>"><?php echo $this->session->userdata("user_username"); ?></a></strong></span>
                        </span>
                    </div>
                    <div class="logo-element">
                        <?php echo $settings["site_name"]; ?>
                    </div>
                </li>
                <li class="<?php echo active_admin_menu('admin/dashboard'); ?>">
                    <a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo $this->lang->line('dashboard'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/users'); ?>">
                    <a href="<?php echo base_url('admin/users') ?>"><i class="fa fa-users"></i> <span class="nav-label"><?php echo $this->lang->line('manage_users'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/agents'); ?>">
                    <a href="<?php echo base_url('admin/agents') ?>"><i class="fa fa-users"></i> <span class="nav-label"><?php echo $this->lang->line('manage_agents'); ?></span></a>
                </li>                     
                <li class="<?php echo active_admin_menu('admin/users/reported'); ?>">
                    <a href="<?php echo base_url('admin/users/reported') ?>"><i class="fa fa-bullhorn"></i> <span class="nav-label"><?php echo $this->lang->line('reported_users'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/vip'); ?>">
                    <a href="<?php echo base_url() ?>admin/vip"><i class="fa fa-list"></i> <span class="nav-label"><?php echo $this->lang->line('vip_packages'); ?></span></a>
                </li>                
                <li class="<?php echo active_admin_menu('admin/diamond'); ?>">
                    <a href="<?php echo base_url() ?>admin/diamond"><i class="fa fa-diamond"></i> <span class="nav-label"><?php echo $this->lang->line('diamond_packages'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/credit'); ?>">
                    <a href="<?php echo base_url() ?>admin/credit"><i class="fa fa-database"></i> <span class="nav-label"><?php echo $this->lang->line('credit_packages'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/credit/usedFreeCredits'); ?>">
                    <a href="<?php echo base_url() ?>admin/credit/usedFreeCredits"><i class="fa fa-database"></i> <span class="nav-label"><?php echo $this->lang->line('free_credits'); ?></span></a>
                </li>                
                <li class="<?php echo active_admin_menu('admin/purchases'); ?>">
                    <a href="<?php echo base_url() ?>admin/purchases"><i class="fa fa-euro"></i> <span class="nav-label"><?php echo $this->lang->line('purchases'); ?></span></a>
                </li>    
                <li class="<?php echo active_admin_menu('admin/credit/historyBuyCredits'); ?>">
                    <a href="<?php echo base_url() ?>admin/credit/historyBuyCredits"><i class="fa fa-euro"></i> <span class="nav-label"><?php echo $this->lang->line('purchases_credit'); ?></span></a>
                </li>   
                <li class="<?php echo active_admin_menu('admin/vip/historyCancelVip'); ?>">
                    <a href="<?php echo base_url() ?>admin/vip/historyCancelVip"><i class="fa fa-stop"></i> <span class="nav-label"><?php echo $this->lang->line('vip_cancel'); ?></span></a>
                </li>     
                <li class="<?php echo active_admin_menu('admin/gift'); ?>">
                    <a href="<?php echo base_url() ?>admin/gift"><i class="fa fa-gift"></i> <span class="nav-label"><?php echo $this->lang->line('gift_to_user'); ?></span></a>
                </li>      
                <li class="<?php echo active_admin_menu('admin/gift/history'); ?>">
                    <a href="<?php echo base_url() ?>admin/gift/history"><i class="fa fa-briefcase"></i> <span class="nav-label"><?php echo $this->lang->line('gift_history'); ?></span></a>
                </li>        
                <li class="<?php echo active_admin_menu('admin/gift/canceled'); ?>">
                    <a href="<?php echo base_url() ?>admin/gift/canceled"><i class="fa fa-newspaper-o"></i> <span class="nav-label"><?php echo $this->lang->line('gift_canceled'); ?></span></a>
                </li>        
                <li class="<?php echo active_admin_menu('admin/approvals'); ?>">
                    <a href="<?php echo base_url() ?>admin/approvals"><i class="fa fa-check-square-o"></i> <span class="nav-label"><?php echo $this->lang->line('approvals'); ?></span></a>
                </li>

                <li class="<?php echo active_admin_menu('admin/checks'); ?>">
                    <a href="<?php echo base_url() ?>admin/checks"><i class="fa fa-certificate"></i> <span class="nav-label"><?php echo ucfirst($this->lang->line('checks')); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/language'); ?>">
                    <a href="<?php echo base_url() ?>admin/language"><i class="fa fa-globe"></i> <span class="nav-label"><?php echo $this->lang->line('manage_languages'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/country'); ?>">
                    <a href="<?php echo base_url() ?>admin/country"><i class="fa fa-flag"></i> <span class="nav-label"><?php echo $this->lang->line('manage_country'); ?></span></a>
                </li>                 
                <li class="<?php echo active_admin_menu('admin/news'); ?>">
                    <a href="<?php echo base_url() ?>admin/news"><i class="fa fa-newspaper-o"></i> <span class="nav-label"><?php echo $this->lang->line('news'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/contactUs'); ?>">
                    <a href="<?php echo base_url() ?>admin/contactUs"><i class="fa fa-send"></i> <span class="nav-label"><?php echo $this->lang->line('contact_us'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/faq'); ?>">
                    <a href="<?php echo base_url() ?>admin/faq"><i class="fa fa-question-circle fa-lg"></i> <span class="nav-label"><?php echo $this->lang->line('faq'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/settings'); ?>">
                    <a href="<?php echo base_url() ?>admin/settings"><i class="fa fa-cogs"></i> <span class="nav-label"><?php echo $this->lang->line('site_settings'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/payment_gateway'); ?>">
                    <a href="<?php echo base_url() ?>admin/payment_gateway"><i class="fa fa-credit-card"></i> <span class="nav-label"><?php echo $this->lang->line('payment_gateway'); ?></span></a>
                </li>
                <li class="<?php echo active_admin_menu('admin/vouchers'); ?>">
                    <a href="<?php echo base_url() ?>admin/vouchers"><i class="fa fa-money"></i> <span class="nav-label"><?php echo $this->lang->line('vouchers'); ?></span></a>
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
                            <div class="dropdown-menu lg pull-left arrow panel panel-default arrow-top-left" style='overflow: scroll'>
                                <div class="panel-heading">
                                    <?php echo $this->lang->line('admin_menu'); ?>
                                </div>
                                <div class="panel-body text-center">
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url() ?>admin/dashboard" class="text-brown"><span class="h2"><i class="fa fa-th-large"></i></span><p class="text-gray"><?php echo $this->lang->line('dashboard'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url() ?>admin/users" class="text-brown"><span class="h2"><i class="fa fa-users"></i></span><p class="text-gray"><?php echo $this->lang->line('manage_users'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url() ?>admin/agents" class="text-brown"><span class="h2"><i class="fa fa-users"></i></span><p class="text-gray"><?php echo $this->lang->line('manage_agents'); ?></p></a>
                                        </div>
                                        <div class="col-xs-12 visible-xs-block"><hr style="margin-top:1px;margin-bottom: 9px;"></div>

                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/users/reported" class="text-green"><span class="h2"><i class="fa fa-bullhorn"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('reported_users'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/vip" class="text-green"><span class="h2"><i class="fa fa-list"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('vip_packages'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/diamond" class="text-green"><span class="h2"><i class="fa fa-diamond"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('diamond_packages'); ?></p></a>
                                        </div>
                                        <div class="col-xs-12 visible-xs-block"><hr style="margin-top:1px;margin-bottom: 9px;"></div>

                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/credit" class="text-orange"><span class="h2"><i class="fa fa-database"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('credit_packages'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/credit/usedFreeCredits" class="text-orange"><span class="h2"><i class="fa fa-database"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('free_credits'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/purchases" class="text-orange"><span class="h2"><i class="fa fa-euro"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('purchases'); ?></p></a>
                                        </div>
                                        <div class="col-xs-12 visible-xs-block"><hr style="margin-top:1px;margin-bottom: 9px;"></div>

                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/approvals" class="text-red"><span class="h2"><i class="fa fa-check-square-o"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('approvals'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/checks" class="text-red"><span class="h2"><i class="fa fa-certificate"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('checks'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/language" class="text-red"><span class="h2"><i class="fa fa-globe"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('manage_languages'); ?></p></a>
                                        </div>
                                        <div class="col-xs-12 visible-xs-block"><hr style="margin-top:1px;margin-bottom: 9px;"></div>

                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/country" class="text-green"><span class="h2"><i class="fa fa-flag"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('manage_country'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/news" class="text-green"><span class="h2"><i class="fa fa-newspaper-o"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('news'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/contactUs" class="text-green"><span class="h2"><i class="fa fa-send"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('contact_us'); ?></p></a>
                                        </div>
                                        <div class="col-xs-12 visible-xs-block"><hr style="margin-top:1px;margin-bottom: 9px;"></div>

                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/faq" class="text-blue"><span class="h2"><i class="fa fa-question-circle"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('faq'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/settings" class="text-blue"><span class="h2"><i class="fa fa-cogs"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('site_settings'); ?></p></a>
                                        </div>        
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url(); ?>admin/payment_gateway" class="text-blue"><span class="h2"><i class="fa fa-credit-card"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('payment_gateway'); ?></p></a>
                                        </div>
                                        <div class="col-xs-12 visible-xs-block"><hr style="margin-top:1px;margin-bottom: 9px;"></div>

                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url() ?>admin/vip/historyCancelVip" class="text-green"><span class="h2"><i class="fa fa-stop"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('vip_cancel'); ?></p></a>
                                        </div> 
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url() ?>admin/credit/historyBuyCredits" class="text-green"><span class="h2"><i class="fa fa-euro"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('purchases_credit'); ?></p></a>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="<?php echo base_url() ?>admin/vouchers" class="text-green"><span class="h2"><i class="fa fa-money"></i></span><p class="text-gray no-margn"><?php echo $this->lang->line('vouchers'); ?></p></a>
                                        </div>

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
<!--                    <li>
                        <a href="<?php echo base_url(); ?>">
                            <i class="fa fa-globe"></i> Back to the Website
                        </a>
                    </li>    -->
                    <li>
                        <a href="<?php echo base_url(); ?>auth/logout">
                            <i class="fa fa-sign-out"></i> <?php echo $this->lang->line('log_out'); ?>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>