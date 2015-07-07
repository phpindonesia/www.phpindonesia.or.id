<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../../404.php');
}else{
include_once '../../../../po-library/po-database.php';
require_once('twitteroauth/twitteroauth.php');

$tableoauthtw = new PoTable('oauth');
$currentOauthtw = $tableoauthtw->findBy(id_oauth, '2');
$currentOauthtw = $currentOauthtw->current();
$conkeyOauthtw = $currentOauthtw->oauth_key;
$consecretOauthtw = $currentOauthtw->oauth_secret;

$tablesetting = new PoTable('setting');
$currentSetting = $tablesetting->findBy(id_setting, '1');
$currentSetting = $currentSetting->current();
$currentSettingweb = $currentSetting->website_url;

define('CONSUMER_KEY', ''.$conkeyOauthtw.'');
define('CONSUMER_SECRET', ''.$consecretOauthtw.'');
define('OAUTH_CALLBACK', ''.$currentSettingweb.'/po-adminboard/po-component/po-oauth/twitter/index.php');

/* Build TwitterOAuth object with client credentials. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

/* Get temporary credentials. */
$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

/* Save temporary credentials to session. */
$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

/* If last connection failed don't display authorization link. */
switch ($connection->http_code){
	default:
		/* Show notification if something went wrong. */
		header('location:../../../../po-adminboard/admin.php?mod=setting');
	break;
	case 200:
		/* Build authorize URL and redirect user to Twitter. */
		$url = $connection->getAuthorizeURL($token);
		header('location:'.$url);
	break;
}
?>
<?php
}
?>