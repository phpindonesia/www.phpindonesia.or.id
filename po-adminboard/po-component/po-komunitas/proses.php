<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

$val = new Povalidasi;
$mod = $_POST['mod'];
$act = $_POST['act'];

// Delete Komunitas
if ($mod=='komunitas' AND $act=='delete'){
	$id = $val->validasi($_POST['id'],'sql');
	$tabledel = new PoTable('komunitas');
	$tabledel->deleteBy('id_komunitas', $id);
	header('location:../../admin.php?mod='.$mod);
}

// Multi Delete Komunitas
elseif ($mod=='komunitas' AND $act=='multidelete'){
	$totaldata = $val->validasi($_POST['totaldata'],'xss');
	if ($totaldata != "0"){
		$itemdel = $_POST['item'];
		$tabledel = new PoTable('komunitas');
		foreach ($itemdel as $item){
			$id = $val->validasi($item['deldata'],'xss');
			$tabledel->deleteBy('id_komunitas', $id);
		}
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Persetujuan
elseif ($mod=='komunitas' AND $act=='setuju'){
	$id = $val->validasi($_POST['id'],'sql');
	$tabledel = new PoTable('komunitas');
	$data = array(
		'status' => '1'
	);
	$table = new PoTable('komunitas');
	$table->updateBy('id_komunitas', $id, $data);
	header('location:../../admin.php?mod='.$mod);
}
// Input Komunitas
elseif ($mod=='komunitas' AND $act=='input'){
$nama = $val->validasi($_POST['nama'],'xss');
$alamat = $val->validasi($_POST['alamat'],'xss');
$email = $val->validasi($_POST['email'],'xss');
$facebook = $val->validasi($_POST['facebook'],'xss');
$twitter = $val->validasi($_POST['twitter'],'xss');
$skill = $val->validasi($_POST['skill'],'xss');
$lat = $val->validasi($_POST['lat'],'xss');
$lng = $val->validasi($_POST['lng'],'xss');
$status = $_POST['status'];
$seourl = seo_title($komunitas);
if(!empty($_POST['komunitas'])){
	$table = new PoTable('komunitas');
	$table->save(array(
		'nama' => $nama,
		'alamat' => $alamat,
		'email' => $email,
		'facebook' => $facebook,
		'twitter' => $twitter,
		'skill' => $skill,
		'lat' => $lat,
		'lng' => $lng,
		'status' => $status,
		'seourl' => $seourl,
	));
	header('location:../../admin.php?mod='.$mod);
}else{
	$table = new PoTable('komunitas');
	$table->save(array(
		'nama' => $nama,
		'alamat' => $alamat,
		'email' => $email,
		'facebook' => $facebook,
		'twitter' => $twitter,
		'skill' => $skill,
		'lat' => $lat,
		'lng' => $lng,
		'status' => $status,
		'seourl' => $seourl,
	));
	header('location:../../admin.php?mod='.$mod);
}
}

// Edit Komunitas
elseif ($mod=='komunitas' AND $act=='update'){
$id = $val->validasi($_POST['id'],'sql');
$nama = $val->validasi($_POST['nama'],'xss');
$alamat = $val->validasi($_POST['alamat'],'xss');
$email = $val->validasi($_POST['email'],'xss');
$facebook = $val->validasi($_POST['facebook'],'xss');
$twitter = $val->validasi($_POST['twitter'],'xss');
$skill = $val->validasi($_POST['skill'],'xss');
$lat = $val->validasi($_POST['lat'],'xss');
$lng = $val->validasi($_POST['lng'],'xss');
$status = $_POST['status'];
$seourl = seo_title($komunitas);
if(!empty($_POST['komunitas'])){
	$data = array(
		'nama' => $nama,
		'alamat' => $alamat,
		'email' => $email,
		'facebook' => $facebook,
		'twitter' => $twitter,
		'skill' => $skill,
		'lat' => $lat,
		'lng' => $lng,
		'status' => $status,
		'seourl' => $seourl,
	);
	$table = new PoTable('komunitas');
	$table->updateBy('id_komunitas', $id, $data);
	header('location:../../admin.php?mod='.$mod);
}else{
	$data = array(
		'nama' => $nama,
		'alamat' => $alamat,
		'email' => $email,
		'facebook' => $facebook,
		'twitter' => $twitter,
		'skill' => $skill,
		'lat' => $lat,
		'lng' => $lng,
		'status' => $status,
		'seourl' => $seourl,
	);
	$table = new PoTable('komunitas');
	$table->updateBy('id_komunitas', $id, $data);
	header('location:../../admin.php?mod='.$mod);
}
}
}
?>