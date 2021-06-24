<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $settings["site_description"]; ?>">
    <meta name="keywords" content="<?php echo $settings["site_tags"]; ?>">
    <link href="<?php echo base_url(); ?>css/site/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/owl.theme.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/flaticon.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cinzel:400,700,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cinzel" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Dancing+Script:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<style type="text/css">
		.whatis_sugarbabe {
		    background-color: #000;
		    background-image: url('<?php echo base_url('images/home-back-1.png'); ?>');
		    background-size: 83% auto;
		    background-repeat: no-repeat;
		    background-position: calc(100% - -190px) -60px;
		    padding: 0px 0px 100px;
		}
		.rich_more {
		    background-color: #000;
		    background-image: url('<?php echo base_url('images/Valori-tonali-21.png'); ?>');
		    background-size: cover;
		    background-repeat: no-repeat;
		    background-position: -593px -125px;
		    padding: 200px 0px 280px 0px;
			position:relative;
			z-index:1;
		}		
		/* media query*/
		@media (max-width:1440px){
			.rich_more {
		    	background-position: -415px -120px;
			}
		}
		/* media query*/
		.go_btn_col a {
		    background-image: url('<?php echo base_url('images/sign_in_btn.png'); ?>');
		    height: 48px;
		    position: relative;
		    background-size: 100% 100%;
		    font-size: 16.67px;
		    display: block;
		    color: #fff;
		    line-height: 48px;
		    text-transform: uppercase;
		    font-weight: 600;
		}		
		.sign_now_btn {
		    background-image: url('<?php echo base_url('images/sign_in_btn.png'); ?>');
		    height: 48px;
		    position: relative;
		    background-size: 100% 100%;
		    font-size: 16.67px;
		    display: block;
		    color: #fff;
		    line-height: 48px;
		    text-transform: uppercase;
		    font-weight: 600;
		}
	</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>

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

<body>