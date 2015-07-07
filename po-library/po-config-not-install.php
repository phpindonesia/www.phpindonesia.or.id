<?php

$site['structure']  	= 'PopojiCMS';
$site['ver']        	= '1.2';
$site['build']      	= '5';
$site['release']    	= '11 Agustus 2014';

$site['title']      	= "PopojiCMS - Buat Sendiri Rasa Webmu";
$site['url']     	 	= "http://localhost/popojicms/";
$site['adm']  		 	= "{$site['url']}po-admin/";
$site['con']     	 	= "{$site['url']}po-content/";
$site['lib']  		 	= "{$site['url']}po-library/";

$dir['root']        	= "D:/wamp/www/popojicms/"; 
$dir['adm']         	= "{$dir['root']}po-admin/";
$dir['con']         	= "{$dir['root']}po-content/";
$dir['lib']         	= "{$dir['root']}po-library/";

define('PO_DIRECTORY_PATH_ADM', $dir['adm']);
define('PO_DIRECTORY_PATH_CON', $dir['con']);
define('PO_DIRECTORY_PATH_LIB', $dir['lib']);

$db['host']          	= "localhost";
$db['sock']          	= "";
$db['port']          	= "";
$db['user']          	= "root";
$db['passwd']			= "";
$db['db']				= "popojicms";

define('DATABASE_HOST', $db['host']);
define('DATABASE_SOCK', $db['sock']);
define('DATABASE_PORT', $db['port']);
define('DATABASE_USER', $db['user']);
define('DATABASE_PASS', $db['passwd']);
define('DATABASE_NAME', $db['db']);

if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
	error_reporting(E_ALL & ~E_NOTICE);
  
if (file_exists( $dir['root'] . 'po-install' )){
$ret = <<<EOJ
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<title>PopojiCMS Installation</title>
			<link href="{$site['url']}po-install/css/bootstrap.min.css" rel="stylesheet" />
			<link href="{$site['url']}po-install/css/docs.css" rel="stylesheet" />
			<link href='{$site['url']}po-install/favicon.png' rel='icon' />
			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			  <script src="{$site['url']}po-install/js/html5shiv.js"></script>
			  <script src="{$site['url']}po-install/js/respond.min.js"></script>
			<![endif]-->
		</head>
		<body class="bs-docs-home">
			<a class="sr-only" href="#content">Skip navigation</a>
			<div id="main">
			<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
				<div class="container">
					<div class="navbar-header">
						<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="./" class="navbar-brand">PopojiCMS</a>
					</div>
					<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
						<ul class="nav navbar-nav">
							<li><a>Congratulations</a></li>
						</ul>
					</nav>
				</div>
			</header>
			<main class="bs-masthead" id="content" role="main">
				<div class="container">
					<h1>{$site['structure']} {$site['ver']}.{$site['build']}</h1>
					<h2>Release {$site['release']}</h2>
					<p>&nbsp</p>
					<h4>Anda telah berhasil menginstall PopojiCMS silahkan remove 'po-install' directory</h4>
				</div>
			</main>
			<footer class="container" role="contentinfo">
				<ul class="bs-masthead-links">
					<li class="current-version">{$site['structure']} {$site['ver']}.{$site['build']}</li>
					<li>&copy; 2013-2014. All Right Reserved</li>
					<li><a href="http://www.popojicms.org" target="_blank">PopojiCMS Official Website</a></li>
				</ul>
			</footer>
			<script src="{\$site['url']}po-install/js/jquery.js"></script>
			<script src="{\$site['url']}po-install/js/bootstrap.min.js"></script>
		</body>
	</html>
EOJ;
echo $ret;
exit();
}

?>