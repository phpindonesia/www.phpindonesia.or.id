<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';
require_once '../../po-component/po-oauth/twitter/twitteroauth/twitteroauth.php';

$val = new Povalidasi;

$tableoauthtw = new PoTable('oauth');
$currentOauthtw = $tableoauthtw->findBy(id_oauth, '2');
$currentOauthtw = $currentOauthtw->current();
$conkeyOauthtw = $currentOauthtw->oauth_key;
$consecretOauthtw = $currentOauthtw->oauth_secret;
$idOauthtw = $currentOauthtw->oauth_id;
$tokenOauthtw = $currentOauthtw->oauth_token1;
$tokensecretOauthtw = $currentOauthtw->oauth_token2;

$tablesetting = new PoTable('setting');
$currentSetting = $tablesetting->findBy(id_setting, '1');
$currentSetting = $currentSetting->current();
$urlwebsite = $currentSetting->website_url;
$urlwebsitename = $currentSetting->website_name;

define('CONSUMER_KEY', ''.$conkeyOauthtw.'');
define('CONSUMER_SECRET', ''.$consecretOauthtw.'');
define('OAUTH_CALLBACK', ''.$urlwebsite.'/po-adminboard/admin.php?mod=post');

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $tokenOauthtw, $tokensecretOauthtw);

$valid = $val->validasi($_GET['id'],'sql');
$table = new PoTable('post');
$currentPosts = $table->findBy(id_post, $valid);
$currentPosts = $currentPosts->current();

$params = array(
	"status" => "$currentPosts->title, Link : $urlwebsite/detailpost/$currentPosts->seotitle"
);
$status = $connection->post('statuses/update', $params);
if (200 == $connection->http_code) {
	header('location:../../admin.php?mod=post');
}else{
	header('location:../../404.php');
}
}
?>