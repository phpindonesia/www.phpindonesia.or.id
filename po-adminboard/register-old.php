<?php
session_start();
error_reporting(0);
include_once '../po-library/po-database.php';
$tableset = new PoTable('setting');
$currentSet = $tableset->findBy(id_setting, '1');
$currentSet = $currentSet->current();
$member_register = $currentSet->member_register;
if ($member_register == "Y"){
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
	if(!empty($_GET['errormsg'])){
		if($_GET['errormsg'] == 1){
			$errormsg = "<div class='alert alert-warning'>Please complete all form!<a class='close' data-dismiss='alert' href='#' aria-hidden='true'>&times;</a></div>";
		}elseif($_GET['errormsg'] == 2){
			$errormsg = "<div class='alert alert-warning'>Please type correct email!<a class='close' data-dismiss='alert' href='#' aria-hidden='true'>&times;</a></div>";
		}elseif($_GET['errormsg'] == 3){
			$errormsg = "<div class='alert alert-warning'>Please type another email!<a class='close' data-dismiss='alert' href='#' aria-hidden='true'>&times;</a></div>";
		}elseif($_GET['errormsg'] == 4){
			$errormsg = "<div class='alert alert-warning'>Please type password min 6 character!<a class='close' data-dismiss='alert' href='#' aria-hidden='true'>&times;</a></div>";
		}elseif($_GET['errormsg'] == 5){
			$errormsg = "<div class='alert alert-warning'>Please type the same password into retype column!<a class='close' data-dismiss='alert' href='#' aria-hidden='true'>&times;</a></div>";
		}elseif($_GET['errormsg'] == 6){
			$errormsg = "<div class='alert alert-warning'>Please type another username!<a class='close' data-dismiss='alert' href='#' aria-hidden='true'>&times;</a></div>";
		}else{
			header('location:register.php');
		}
	}
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
    <meta name="description" content="Register Panel PopojiCMS" />
    <meta name="keywords" content="register panel popojicms, popojicms" />
    <meta name="generator" content="PopojiCMS v.1.3.0" />
    <meta name="author" content="Dwira Survivor" />
    <meta name="language" content="Indonesia" />
    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->
    <title>Register Panel</title>
    <link rel="shortcut icon" type="image/png" href="favicon.png" />

	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="css/plugins.css" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<link type="text/css" rel="stylesheet" href="css/themes.css" />

	<script type="text/javascript" src="js/vendor/modernizr-2.7.1-respond-1.4.2.min.js"></script>
</head>
<body>
    <div class="top"><div class="colors"></div></div>
	<div id="login-container" class="animation-fadeIn" style="top:50px !important;">
		<div class="login-title text-center">
			<h1><strong>Register Panel</strong></h1>
		</div>
		<div class="block remove-margin">
			<div class="col-md-12">
				<?=$errormsg;?>
			</div>
			<form action="actregister.php" autocomplete="off" method="post" id="form-register" class="form-horizontal form-bordered form-control-borderless" />
                <div class="form">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group form-item">
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                <input type="text" id="login-username" name="username" class="form-control input-lg" placeholder="Username" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group form-item">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <input type="text" id="login-email" name="email" class="form-control input-lg" placeholder="Email" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group form-item">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                <input type="password" id="login-password" name="password" class="form-control input-lg" placeholder="Password" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group form-item">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                <input type="password" id="re-login-password" name="re-password" class="form-control input-lg" placeholder="Retype Password" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-8 text-right">
                            <button type="submit" class="btn btn-sm btn-success">Register Account</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <p class="text-center remove-margin">
                                <small>Oops, you have an account ?</small> <a href="./" id="link-login"><small>Click here !</small></a>
                            </p>
                        </div>
                    </div>
                </div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="js/vendor/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/vendor/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/plugins.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript">
        gradient();
    </script>
</body>
</html>
<?php
}else{
	header('location:admin.php?mod=home');
}
}else{
	header('location:./');
}
?>