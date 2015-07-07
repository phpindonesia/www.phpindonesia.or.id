<?php
	include_once 'po-library/po-database.php';
	$tableset = new PoTable('setting');
	$currentSet = $tableset->findBy(id_setting, '1');
	$currentSet = $currentSet->current();
	$mode_maintenance = $currentSet->website_maintenance;
	$maintenance_tgl = $currentSet->website_maintenance_tgl;
	$tanggal = substr($maintenance_tgl,3,2);
	$bulan = substr($maintenance_tgl,0,2);
	$tahun = substr($maintenance_tgl,6,4);
	if ($mode_maintenance == "N"){
		header('location:./');
	}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="Copyright" content="Popojicms" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="PopojiCMS Under Maintenance" />
    <meta name="keywords" content="popojicms" />
    <meta name="generator" content="PopojiCMS v.1.3.0" />
    <meta name="author" content="Dwira Survivor" />
    <meta name="language" content="Indonesia" />
    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Under Maintenance</title>

    <link rel="shortcut icon" href="favicon.png" />

	<link href="http://fonts.googleapis.com/css?family=Lato:300,700,400,700italic,400italic" rel="stylesheet" type="text/css" />
	<link type="text/css" rel="stylesheet" href="po-adminboard/css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="po-adminboard/css/maintenance.css" />
</head>
<body>
	<section id="intro">
		<div class="container">
			<div class="intro">
				<h2>Under Maintenance</h2>
				<p class="lead">The website will be ready in...</p>
			</div>
		</div>
	</section>
	<section id="countdown">
		<div class="container">
			<div class="row countdown text-center">
				<div class="countdown-wrap col-sm-3 col-xs-6">
					<span class="timer ce-days"></span> <br> <span class="ce-days-label"></span>
				</div>
				<div class="countdown-wrap col-sm-3 col-xs-6">
					<span class="timer ce-hours"></span> <br> <span class="ce-hours-label"></span>
				</div>
				<div class="countdown-wrap col-sm-3 col-xs-6">
					<span class="timer ce-minutes"></span> <br> <span class="ce-minutes-label"></span>
				</div>
				<div class="countdown-wrap col-sm-3 col-xs-6">
					<span class="timer ce-seconds"></span> <br> <span class="ce-seconds-label"></span>
				</div>
			</div>
		</div>
	</section>
	<section id="footer">
		<div class="container">
			<p>Copyright &copy; 2013-2015. All Rights Reserved</p>
		</div>
	</section>
	<script type="text/javascript" src="po-adminboard/js/vendor/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="po-adminboard/js/vendor/jquery.counteverest.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".countdown").countEverest({
				day: <?=$tanggal;?>,
				month: <?=$bulan;?>,
				year: <?=$tahun;?>
			});
		});
	</script>
</body>
</html>
<?php
	}
?>