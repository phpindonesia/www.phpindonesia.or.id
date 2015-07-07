<?php if ($mod==""){
	header('location:../../404.php');
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<!-- Your Basic Site Informations -->
	<title><?php include "title.php"; ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="<?php include "meta-desc.php"; ?>" />
    <meta name="keywords" content="<?php include "meta-key.php"; ?>" />
    <meta http-equiv="Copyright" content="popojicms" />
    <meta name="author" content="Dwira Survivor" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="language" content="Indonesia" />
    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />

    <!-- Social Media Meta -->
    <?php include "meta-social.php"; ?>

    <!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- **CSS - stylesheets** -->
	<link id="default-css" rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/style.css" type="text/css" media="all" />
	<link id="shortcodes-css" rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/shortcodes.css" type="text/css" media="all"/>
	<link id="skin-css" rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/skins/blue/style.css" type="text/css" media="all"/>
    <link id="layer-slider" rel="stylesheet"  href="<?=$website_url;?>/po-content/<?=$folder;?>/css/layerslider.css" media="all" />
	
	<!-- **Additional - stylesheets** -->
	<link rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/responsive.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/css/meanmenu.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/css/prettyPhoto.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/css/animations.css" type="text/css" media="all" />
    
    <!-- **Font Awesome** -->
	<link rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/css/font-awesome.min.css" type="text/css" />
    
    <!-- **Google - Fonts** -->
    <link href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" rel="stylesheet" type="text/css">  
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">

    <!-- Favicons -->
	<link rel="shortcut icon" href="<?=$website_url;?>/<?=$favicon;?>" />

	<!-- Recaptcha -->
	<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
<!-- **Wrapper** -->
<div class="wrapper"> 
	<div class="inner-wrapper">
        <!-- **Top Bar** -->
        <div class="top-bar">
            <div class="container">
                <ul class="top-menu">
                    <li><i class="fa fa-home"></i> Bersama Berkaya Berjaya</li>
                    <li><i class="fa fa-envelope"></i> info<span>[at]</span>phpindonesia.or.id</li>
                </ul>
                <div class="top-right">
                    <span>Social Media PHP Indonesia</span>
                    <ul class="dt-sc-social-icons">
                        <li><a href="https://www.facebook.com/groups/35688476100" title="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://www.twitter.com/php_indonesia" title="twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="http://www.youtube.com/user/OurPHPIndonesia" title="youtube" target="_blank"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div><!-- **Top Bar - End** -->

		<div id="header-wrapper">
	        <!-- **Header** -->
	        <header class="header">
	        	<div class="container">
	                <!-- **Logo - End** -->
	                <div id="logo">
	                    <a href="<?=$website_url;?>" title="PHP Indonesia"><img src="<?=$website_url;?>/po-content/<?=$folder;?>/images/logo.png" alt="PHP Indonesia" height="57" /></a>
	                </div><!-- **Logo - End** -->
	                <div id="menu-container">
	                    <!-- **Nav - Starts**-->
	                    <nav id="main-menu">
                        	<div id="dt-menu-toggle" class="dt-menu-toggle">
                                Menu <span class="dt-menu-toggle-icon"></span>
                            </div>
							<?php 
								$instance = new PoController;
								$menu = $instance->popoji_menu(1, 'class="menu"', '', 'class="sub-menu"', 'front');
							?>
							<?php echo $menu; ?>
	                    </nav>
	                    <!-- **Nav - End**-->
	               </div>
	            </div>
	        </header><!-- **Header - End** -->
        </div>
<?php } ?>