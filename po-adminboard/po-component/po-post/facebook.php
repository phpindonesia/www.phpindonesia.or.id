<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';
require_once '../../po-component/po-oauth/facebook/src/facebook.php';

$val = new Povalidasi;

$tableoauthfb = new PoTable('oauth');
$currentOauthfb = $tableoauthfb->findBy(id_oauth, '1');
$currentOauthfb = $currentOauthfb->current();
$appIdOauthfb = $currentOauthfb->oauth_key;
$secretOauthfb = $currentOauthfb->oauth_secret;
$idOauthfb = $currentOauthfb->oauth_id;
$tokenOauthfb = $currentOauthfb->oauth_token1;
$fbtypeOauthfb = $currentOauthfb->oauth_fbtype;

$tablesetting = new PoTable('setting');
$currentSetting = $tablesetting->findBy(id_setting, '1');
$currentSetting = $currentSetting->current();
$urlwebsite = $currentSetting->website_url;
$urlwebsitepost = trim($urlwebsite, "http://");
$urlwebsitename = $currentSetting->website_name;

$facebook = new Facebook(array(
	'appId'  => ''.$appIdOauthfb.'',
	'secret' => ''.$secretOauthfb.'',
	'fileUpload' => 'false',
));

$valid = $val->validasi($_GET['id'],'sql');
$table = new PoTable('post');
$currentPosts = $table->findBy(id_post, $valid);
$currentPosts = $currentPosts->current();
$contentPosts = html_entity_decode($currentPosts->content);
$contents = strip_tags($contentPosts);
$contents = substr($contents,0,500);
$contents = substr($contents,0,strrpos($contents," "));
$description = stripslashes(strip_tags(htmlspecialchars($contents,ENT_QUOTES)));
$descpost = $description;

$params = array(
	"access_token" => "$tokenOauthfb",
	"message" => "$currentPosts->title",
	"name" => "$currentPosts->title",
	"caption" => "$urlwebsitepost",
	"link" => "$urlwebsite/detailpost/$currentPosts->seotitle",
	"description" => "$descpost",
	"picture" => "$urlwebsite/po-content/po-upload/$currentPosts->picture",
	"actions" => array(
		array(
			"name" => "$urlwebsitename",
			"link" => "$urlwebsite"
		)
	)
);

if($fbtypeOauthfb == "user"){
	try {
		$ret = $facebook->api('/me/feed', 'post', $params);
		header('location:../../admin.php?mod=post');
	}
	catch (FacebookApiException $e){
		header('location:../../404.php');
	}
}else{
	try {
		$ret = $facebook->api('/'.$idOauthfb.'/feed', 'post', $params);
		header('location:../../admin.php?mod=post');
	}
	catch (FacebookApiException $e){
		header('location:../../404.php');
	}
}
}
?>