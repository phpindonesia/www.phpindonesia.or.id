<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../../404.php');
}else{
include_once '../../../../po-library/po-database.php';
require 'src/facebook.php';

$tableoauthfb = new PoTable('oauth');
$currentOauthfb = $tableoauthfb->findBy(id_oauth, '1');
$currentOauthfb = $currentOauthfb->current();
$appIdOauthfb = $currentOauthfb->oauth_key;
$secretOauthfb = $currentOauthfb->oauth_secret;

$facebook = new Facebook(array(
	'appId'  => ''.$appIdOauthfb.'',
	'secret' => ''.$secretOauthfb.'',
));

$user = $facebook->getUser();

if ($user){
	try {
		$user_profile = $facebook->api('/me');
		$fbid = $user_profile['id'];
		$fbuname = $user_profile['username'];
		$fbfullname = $user_profile['name'];
		$userpages = $facebook->api(array('method' => 'fql.query','query' => 'SELECT page_id,page_url,name,username FROM page WHERE page_id IN (SELECT page_id FROM page_admin WHERE uid ='.$user.')'));
		$facebook->setExtendedAccessToken();
		$access_token = $facebook->getAccessToken();
		$accounts = $facebook->api(
			'/me/accounts',
			'GET',
			array(
				'access_token' => $access_token
			)
		);
	}
	catch (FacebookApiException $e){
		error_log($e);
		$user = null;
	}
}

if (!$user){
	$loginUrl = $facebook->getLoginUrl(array(
		'scope' => 'publish_stream,manage_pages',
	));
}
?>
<?php if ($user): ?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta name="description" content="PopojiCMSOAuth 1.0 - Connect facebook to your website for automatic publish content to facebook from your post">
			<meta name="author" content="PopojiCMS">
			<link rel="shortcut icon" href="favicon.png">

			<title>PopojiCMSOAuth 1.0 - Facebook</title>

			<!-- Bootstrap core CSS -->
			<link href="dist/css/bootstrap.min.css" rel="stylesheet">
			<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
			<![endif]-->

			<style type="text/css">
				body {
					background: #ffffff;
					font-family: 'Open Sans', sans-serif;
					font-size: 12px;
					color: #666666;
					padding: 0px;
				}
				.jumbotron {
					background: #428bca;
					color: #ffffff;
				}
				#footer .container {
					padding: 40px 0 10px 0;
				}
				.text-muted {
					padding: 20px;
				}
			</style>
		</head>
		<body>
			<div class="jumbotron">
				<h1>PopojiCMSOAuth 1.0</h1>
				<p>Connect facebook to your website for automatic publish content to facebook from your post.</p>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<form role="form" method="post" action="proses.php" autocomplete="off">
							<input type="hidden" name="fbtype" value="user">
							<input type="hidden" name="fbtoken" value="<?php echo $access_token; ?>">
							<div class="panel panel-default">
								<div class="panel-heading"><span class="glyphicon glyphicon-link"></span> Connect Facebook From User</div>
								<ul class="list-group">
									<li class="list-group-item">Facebook Id
										<input type="text" class="form-control" name="fbid" value="<?php echo $fbid; ?>" readonly>
									</li>
									<li class="list-group-item">Facebook Username
										<input type="text" class="form-control" name="fbusername" value="<?php echo $fbuname; ?>" readonly>
									</li>
									<li class="list-group-item">Facebook Fullname
										<input type="text" class="form-control" name="fbfullname" value="<?php echo $fbfullname; ?>" readonly>
									</li>
								</ul>
								<div class="panel-footer"></div>
							</div>
							<button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-transfer"></span> Connect User</button>
						</form>
						<p>&nbsp;</p><p>&nbsp;</p>
					</div>
					<div class="col-md-6">
						<form role="form" method="post" action="proses.php" autocomplete="off">
							<input type="hidden" name="fbtype" value="pages">
							<input type="hidden" name="fbtoken" value="<?php echo $access_token; ?>">
							<input type="hidden" name="fbid" value="<?php echo $fbid; ?>">
							<input type="hidden" name="fbusername" value="<?php echo $fbuname; ?>">
							<input type="hidden" name="fbfullname" value="<?php echo $fbfullname; ?>">
							<div class="panel panel-default">
								<div class="panel-heading"><span class="glyphicon glyphicon-link"></span> Connect Facebook From Pages</div>
								<ul class="list-group">
									<li class="list-group-item">Facebook Pages
										<select id="fbpages" class="form-control">
											<?php
												foreach ($userpages as $userpage) {
													echo '<option value="'.$userpage["page_id"].'">'.$userpage["username"].'</option>';
												}
											?>
										</select>
									</li>
									<li class="list-group-item">Facebook Pages Id
										<input type="text" class="form-control" name="fbpagesid" id="fbpagesid" value="" readonly>
									</li>
									<li class="list-group-item">Facebook Pages Name
										<input type="text" class="form-control" name="fbpagesname" id="fbpagesname" value="" readonly>
									</li>
								</ul>
								<div class="panel-footer"></div>
							</div>
							<button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-transfer"></span> Connect Pages</button>
						</form>
					</div>
				</div>
			</div>
			<div id="footer">
				<div class="container">
					<p class="text-muted">PopojiCMSOAuth 1.0 &copy; 2014. PopojiCMS Team. All Rights Reserved.</p>
				</div>
			</div>
			<script type="text/javascript" src="dist/js/jquery.min.js"></script>
			<script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#fbpages').on('click', function (e) {
						var optionSelected = $("option:selected", this);
						var valueSelected = optionSelected.val();
						var valueSelectedT = optionSelected.text();
						$("#fbpagesid").val(valueSelected);
						$("#fbpagesname").val(valueSelectedT);
					});
				});
			</script>
		</body>
	</html>
<?php else: ?>
	<script language="javascript" type="text/javascript">
		window.location.href="<?php echo $loginUrl; ?>";
	</script>
<?php endif ?>
<?php
}
?>