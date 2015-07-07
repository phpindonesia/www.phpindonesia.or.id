<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../../404.php');
}else{
	include_once '../../../../po-library/po-database.php';
	include_once '../../../../po-library/po-function.php';

	$val = new Povalidasi;

	$fb_type = $_POST['fbtype'];
	if ($fb_type == "user"){
		$oauth_id = $_POST['fbid'];
		$oauth_user = $_POST['fbusername'];
		$oauth_token1 = $_POST['fbtoken'];
		$oauth_fbtype = $_POST['fbtype'];
		$data = array(
			'oauth_id' => $oauth_id,
			'oauth_user' => $oauth_user,
			'oauth_token1' => $oauth_token1,
			'oauth_fbtype' => $oauth_fbtype
		);
		$table = new PoTable('oauth');
		$table->updateBy('id_oauth', '1', $data);
	}else{
		$oauth_id = $_POST['fbpagesid'];
		$oauth_user = $_POST['fbpagesname'];
		$oauth_token1 = $_POST['fbtoken'];
		$oauth_fbtype = $_POST['fbtype'];
		$data = array(
			'oauth_id' => $oauth_id,
			'oauth_user' => $oauth_user,
			'oauth_token1' => $oauth_token1,
			'oauth_fbtype' => $oauth_fbtype
		);
		$table = new PoTable('oauth');
		$table->updateBy('id_oauth', '1', $data);
	}
	header('location:../../../admin.php?mod=setting');
}
?>