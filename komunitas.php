<?php
session_start();
include_once 'po-library/po-database.php';
include_once 'po-library/po-function.php';
$val = new Povalidasi;
if ($_GET[id]=="data"){
	$komunitas=mysql_query("select * from komunitas where status='1'");
	while ($kom=mysql_fetch_assoc($komunitas)) {
		$k[nama]=$kom[nama];
		$k[lat]=(Float)$kom[lat];
		$k[lng]=(Float)$kom[lng];
		$k[alamat]=$kom[alamat];
		$k[email]=$kom[email];
		$k[facebook]=$kom[facebook];
		$k[twitter]=$kom[twitter];
		$row[]=$k;
	}
	echo json_encode($row);
}elseif ($_GET[id]=="add"){
	if(empty($_POST['lat']) || empty($_POST['lng']) || empty($_POST['nama']) || empty($_POST['alamat']) || empty($_POST['email']) || empty($_POST['facebook'])){
		echo"error:Mohon Lengkapi Data Anda";
	}else{
		$lat = $val->validasi($_POST['lat'],'xss');
		$lng = $val->validasi($_POST['lng'],'xss');
		$nama = $val->validasi($_POST['nama'],'xss');
		$alamat = $val->validasi($_POST['alamat'],'xss');
		$email = $val->validasi($_POST['email'],'xss');
		$facebook = $val->validasi($_POST['facebook'],'xss');
		$twitter = $val->validasi($_POST['twitter'],'xss');
		$skill = $val->validasi($_POST['skill'],'xss');
		$lat = $val->validasi($_POST['lat'],'xss');
		$lng = $val->validasi($_POST['lng'],'xss');
		$status = $val->validasi($_POST['status'],'xss');
		$message = "sukses:Terima Kasih Atas Partisipasi Anda.<br> Kami akan segera memeriksa data yang anda kirim untuk di setujui.";
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
			'status' => $status
		));
		unset($_POST);
		echo "$message";
	}
}
?>